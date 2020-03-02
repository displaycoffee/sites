<?php
/**
*
* Khy'eras places Code. An extension for the phpBB Forum Software package.
*
* @copyright (c) 2020, Adria, https://github.com/displaycoffee
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace displaycoffee\khyeras\core;

if (!defined('IN_PHPBB')) {
	exit;
}

class global_info {
	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\cache\driver\driver_interface */
	protected $db;

	/** @var \phpbb\profilefields\manager */
	protected $manager;

	/** @var \phpbb\profilefields\lang_helper */
	protected $lang_helper;

	/** @var \displaycoffee\khyeras\utilities\utilities */
	protected $utilities;

	/**
	* Constructor
	*
	* @param \phpbb\template\template                   $template     Template object
	* @param \phpbb\db\driver\driver_interface          $db           DBAL object
	* @param \phpbb\profilefields\manager               $manager      Profile fields manager
	* @param \phpbb\profilefields\lang_helper           $lang_helper  Profile fields language helper
	* @param \displaycoffee\khyeras\utilities\utilities $utilities Utilities helper functions
	*/
	public function __construct(\phpbb\template\template $template, \phpbb\db\driver\driver_interface $db, \phpbb\profilefields\manager $manager, \phpbb\profilefields\lang_helper $lang_helper, \displaycoffee\khyeras\utilities\utilities $utilities) {
		$this->template     = $template;
		$this->db           = $db;
		$this->manager      = $manager;
		$this->lang_helper  = $lang_helper;
		$this->utilities    = $utilities;
	}

	/**
	* Set global member variables
	*/
	public function khy_set_member_info($event) {
		// Call common utilities
		$common = $this->utilities->common();

		// Get the user id, group id, group data, and lang_id
		$user_id = $common['user']['id'];
		$group_id = $common['user']['group'];
		$group_data = $common['groups']['group_' . $group_id];
		$lang_id = $common['user']['lang'];

		// Get user profile field information
		$pf = $this->manager->grab_profile_fields_data($user_id)[$user_id];

		// Load profile field language
		$this->lang_helper->load_option_lang($lang_id);

		// Account_type - field information
		$account_type = $pf['account_type'];
		$account_type_value = $this->lang_helper->get($account_type['data']['field_id'], $lang_id, $account_type['value']);

		// Account information for template variables
		$account_array = array(
			'KHY_USER_GROUP_ID'     => $group_id,
			'KHY_USER_GROUP_NAME'   => $group_data['name_p'],
			'KHY_USER_ACCOUNT_TYPE' => $account_type_value
		);

		// Only assign the below variables on character accounts
		$character_array = array();
		if ($account_type_value == $group_data['name_s']) {
			$character_array = array(
				'KHY_USER_RACE'  => $this->utilities->translate_multi_fields($pf['c_race_opts'], $this->lang_helper, $lang_id),
				'KHY_USER_CLASS' => $this->utilities->translate_multi_fields($pf['c_class_opts'], $this->lang_helper, $lang_id),
				'KHY_USER_LEVEL' => $this->utilities->get_level($pf['c_experience']['value'])
			);
		}

		// Add list of completed achievements only for achievement page
		$achievements_array = array();
		if ($common['script_name'] == 'app/gameplay-achievements') {
			$achievements_array = array(
				'KHY_USER_ACHIEVEMENTS' => $pf['c_achievements']['value']
			);
		}

		// Assign global template variables for re-use
		$this->template->assign_vars(array_merge($account_array, $character_array, $achievements_array));
	}

	/**
	* Set global page variables
	*/
	public function khy_set_page_info($event) {
		// Call common utilities
		$common = $this->utilities->common();

		// Set page_script_name and initial page_type
		$page_script_name = $common['script_name'];
		$page_type = $page_script_name;

		// Get page titles
		$page_title = strtolower($event['page_title']);
		$page_l_title = strtolower($this->template->retrieve_var('L_TITLE'));

		// If on a certain type of page, reset the page_type or page_title
		if ($this->utilities->in_string($page_type, 'thankslist/givens')) {
			$page_type = 'search';
			$page_title = 'thanks';
		} elseif ($this->utilities->in_string($page_type, 'app/')) {
			$page_type = 'page';
		} elseif ($page_type == 'mcp' && $page_l_title && ($page_title != $page_l_title)) {
			$page_title = $page_l_title;
		}

		// Empty object to store page links
		$page_links = [];

		// Create the SQL statement for page data
		$page_sql = 'SELECT *
			FROM ' . $common['tables']['pages'] . '
			ORDER BY page_order ASC, page_title ASC';

		// Run the query
		$page_result = $this->db->sql_query($page_sql);

		// Loops through the page rows and add to page_links
		while ($row = $this->db->sql_fetchrow($page_result)) {
			// Get last number in page order
			$page_order = intval(substr($row['page_order'], -1));

			// Get page description
			$page_desc = $this->utilities->exists($row['page_description'], false);

			$page_data = [
				'name'   => $row['page_title'],
				'url'    => $row['page_route'],
				'is_nav' => ($page_order <= 2) ? true : false,
				'level'  => $page_order,
				'crumbs' => create_breadcrumbs($page_desc, $this->utilities),
				'desc'   => $page_desc
			];

			$page_links[$row['page_route']] = $page_data;
		}

		// Be sure to free the result after a SELECT query
		$this->db->sql_freeresult($page_result);

		// Assign global template variables for re-use
 		$this->template->assign_vars(array(
			'KHY_SCRIPT_NAME'  => str_replace('app/', '', $page_script_name),
			'KHY_HANDLE_SHORT' => $page_type,
			'KHY_HANDLE'       => $page_type . '-' . $this->utilities->handleize($page_title),
			// 'KHY_LINKS'        => $page_links,
			// 'KHY_NAV_LINKS'    => create_navlinks($page_links, $this->utilities)
 		));
	}

	/**
	* Get details of characters
	*/
	public function khy_get_character_details($event) {
		// Call common utilities
		$common = $this->utilities->common();

		// Don't run any of the below code unless on the correct pages
		if ($common['script_name'] == 'app/members-character-census' || $common['script_name'] == 'app/members-character-listing') {
			// Get the user lang_id
			$lang_id = $common['user']['lang'];

			// Empty object to store characters
			$characters = [];

			// Empty object to store counts for stats
			$races_count = [];
			$races_count_expanded = [];
			$classes_count = [];
			$classes_count_expanded = [];
			$genders_count = [];
			$residences_count = [];

			// Create the SQL statement for character data
			$character_sql = 'SELECT *
				FROM ' . $common['tables']['users'] . '
				WHERE group_id=9 ORDER BY user_id ASC';

			// Run the query
			$character_result = $this->db->sql_query($character_sql);

			// Loops through the chracter rows and add to characters
			while ($row = $this->db->sql_fetchrow($character_result)) {
				// Set user last post time
				$last_post_time = intval($row['user_lastpost_time']);

				// Set default time text as never
				$days_since_value = 'Never';
				$last_post_value = 'Never';

				if ($last_post_time) {
					// Formate dates as ISO8601
					$iso_time = 'Y-m-d\TH:i:s';

					// Formate seconds into ISO readable times
					$formatted_last_post_time = new \DateTime(date($iso_time, $last_post_time));
					$formatted_current_time = new \DateTime(date($iso_time, $common['user']['time']));

					// Get time difference object
					$time_diff = $formatted_last_post_time->diff($formatted_current_time);

					// Set days since value
					$days_since_value = $time_diff->days;

					// If days are over 1, format year, days, and months using utilities function
					// Otherwise, set to "Less than 1 day ago"
					if ($days_since_value) {
						$time_years = $this->utilities->get_time_label($time_diff->y, 'year');
						$time_months = $this->utilities->get_time_label($time_diff->m, 'month');
						$time_days = $this->utilities->get_time_label($time_diff->d, 'day');
						$last_post_value = $time_years . $time_months . $time_days . 'ago';
					} else {
						$last_post_value = 'Less than 1 day ago';
					}
				}

				// Set initial character details
				$character_data = [
					'id'         => $row['user_id'],
					'name'       => $row['username'],
					'days_since' => $days_since_value,
					'last_post'  => $last_post_value,
					'avatar'     => $this->utilities->exists($row['user_avatar'], false)
				];

				$characters[$row['user_id']] = $character_data;
			}

			// Be sure to free the result after a SELECT query
			$this->db->sql_freeresult($character_result);

			// Load profile field language
			$this->lang_helper->load_option_lang($lang_id);

			// Loop through characters array
			foreach ($characters as $key => $value) {
				// Get chracter profile field information
				$pf = $this->manager->grab_profile_fields_data($value['id'])[$value['id']];

				// Set level and currenty for later Variables
				$character_level = $this->utilities->get_level($pf['c_experience']['value']);

				// Get user race, class, and residence
				$character_race_type = $this->utilities->translate_multi_fields($pf['c_race_type'], $this->lang_helper, $lang_id);
				$character_race = $this->utilities->translate_multi_fields($pf['c_race_opts'], $this->lang_helper, $lang_id);
				$character_class_type = $this->utilities->translate_multi_fields($pf['c_class_type'], $this->lang_helper, $lang_id);
				$character_class = $this->utilities->translate_multi_fields($pf['c_class_opts'], $this->lang_helper, $lang_id);
				$character_gender = $this->utilities->exists($pf['c_gender']['value'], 'Undisclosed');
				$character_residence = $this->utilities->exists($pf['c_residence']['value'], 'Elsewhere');

				// Add details to character data
				$character_data = [
					'race'      => $character_race,
					'class'     => $character_class,
					'gender'    => $character_gender,
					'residence' => $character_residence,
					'level'     => $character_level,
					'stats'     => $this->utilities->get_life_modifier($character_race, $character_class, $character_level),
					'currency'  => $this->utilities->calc_currency($pf['c_copper']['value'])
				];

				// Add details to characters array
				$characters[$value['id']] = array_merge($characters[$value['id']], $character_data);

				// Break up race to add to count
				$race_array = explode(', ', $character_race);

				for ($i = 0; $i < count($race_array); $i++) {
					$current_race = $race_array[$i];

					// Add counts for all races with Half-breeds not seperated
					$race_key = ($character_race_type == 'Half-breed') ? 'Half-breed' : $current_race;
					$races_count[$race_key] = $this->utilities->get_stat_count($races_count[$race_key]);

					// Add counts for races with Half-breeds seperated
					$races_count_expanded[$current_race] = $this->utilities->get_stat_count($races_count_expanded[$current_race]);
				}

				// Break up class to add to count
				$class_array = explode(', ', $character_class);

				for ($j = 0; $j < count($class_array); $j++) {
					$current_class = $class_array[$j];

					// Fix name for Draconic classes
					if ($current_class == 'Physical' || $current_class == 'Magical' || $current_class == 'Restoration') {
						$current_class = 'Draconic - ' . $current_class;
					}

					// Add counts for all classes with Dual not seperated
					$class_key = ($character_class_type == 'Dual') ? 'Dual' : $current_class;
					$classes_count[$class_key] = $this->utilities->get_stat_count($classes_count[$class_key]);

					// Add counts for classes with Dual seperated
					$classes_count_expanded[$current_class] = $this->utilities->get_stat_count($classes_count_expanded[$current_class]);
				}

				// Add gender count
				if ($character_gender) {
					// Set gender arrays
					$trans = array('transgender', 'transsexual');
					$nonbinary = array('nonbinary', 'genderqueer', 'bigender', 'genderfluid', 'gender fluid', 'agender', 'demigender');
					$female = array('female', 'woman', 'her', 'she', 'hers', 'girl');
					$male = array('male', 'man', 'him', 'he', 'his', 'boy');
					$none = array('no gender', 'none');

					// Set up default gender_key
					$gender_key = 'Undisclosed';

					// Create a gender handle for splitting up into an array
					$pattern = array('/-+/', '/[^a-zA-Z]/', '/ +/');
					$replacement = array('', ' ', ' ');
					$gender_handle = strtolower(preg_replace($pattern, $replacement, $character_gender));

					// Break up gender to add to count
					$gender_array = explode(' ', $gender_handle);

					for ($k = 0; $k < count($gender_array); $k++) {
						$current_gender = $gender_array[$k];

						// Determine gender key
						if (in_array($current_gender, $trans)) {
							$gender_key = 'Transgender';
						} else if (in_array($current_gender, $nonbinary)) {
							$gender_key = 'Non-binary';
						} else if (in_array($current_gender, $female)) {
							$gender_key = 'Female';
						} else if (in_array($current_gender, $male)) {
							$gender_key = 'Male';
						} else if (in_array($current_gender, $none)) {
							$gender_key = 'None';
						}

						// If match was found, break
						break;
					}

					// Add counts for gender
					$genders_count[$gender_key] = $this->utilities->get_stat_count($genders_count[$gender_key]);
				}

				// Add residence count
				if ($character_residence) {
					// Set array of places we want to show in the count
					$allowed_residences = array('Tviyr', 'Ninraih', 'Irtuen Reaches', 'Fellsgard', 'Verdant Row', 'Ajteire', 'Domrhask');

					// If the residence is not in $allowed_residences, add as "Elsewhere"
					$residence_key = in_array($character_residence, $allowed_residences) ? $character_residence : 'Elsewhere';

					// Add counts for residences
					$residences_count[$residence_key] = $this->utilities->get_stat_count($residences_count[$residence_key]);
				}
			}

			// Adjust race and class count for Half-breed and Dual
			if ($races_count['Half-breed']) {
				$races_count['Half-breed'] = $races_count['Half-breed'] / 2;
			}
			if ($classes_count['Dual']) {
				$classes_count['Dual'] = $classes_count['Dual'] / 2;
			}

			// Assign global template variables for re-use
			$this->template->assign_vars(array(
				'KHY_CHARACTERS'             => $characters,
				'KHY_RACES_COUNT'            => $races_count,
				'KHY_RACES_COUNT_EXPANDED'   => $races_count_expanded,
				'KHY_CLASSES_COUNT'          => $classes_count,
				'KHY_CLASSES_COUNT_EXPANDED' => $classes_count_expanded,
				'KHY_RESIDENCES_COUNT'       => $residences_count
	 		));
		}
	}
}

/**
* Create breadcrumbs function
*/
function create_breadcrumbs($desc, $utilities) {
	if ($desc) {
		// Set initial breadcrumbs array
		$breadcrumbs = array();

		// Split the description for the first time
		$parent = explode(' | ', $desc);

		// Loop through the parent breadcrumbs
		for ($i = 0; $i < count($parent); $i++) {
			$current =  $parent[$i];

			// If the current parent contains a > character, split again
			if ($utilities->in_string($current, ' > ')) {
				$children = explode(' > ', $current);

				// Loop through child breadcrumbs and add into breadcrumbs
				for ($j = 0; $j < count($children); $j++) {
					$current_child = $children[$j];

					// If the element is in the array, push a slash
					// Means the category is in multiple categories
					if (in_array($current_child, $breadcrumbs)) {
						array_push($breadcrumbs, '/');
					} else {
						// Otherwise, just add new breadcrumbs
						array_push($breadcrumbs, $children[$j]);
					}
				}
			} else {
				// If there is no additional seperator, push parent value to breadcrumbs
				array_push($breadcrumbs, $current);
			}
		}
	} else {
		$breadcrumbs = false;
	}

	return $breadcrumbs;
}

/**
* Create breadcrumbs function
*/
function create_navlinks($links, $utilities) {
	$new_links = [];

	foreach ($links as $key => $value) {
		// If there is no desc, then the key should be a main level node
		if (!$value['desc']) {
			$new_links[$key] = $value;
		} else {
			// Split the description for the first time
			$parent = explode(' | ',  $value['desc']);

			// Loop through the parent links
			for ($i = 0; $i < count($parent); $i++) {
				$current =  $parent[$i];

				// If the current parent contains a > character, split again
				if ($utilities->in_string($current, ' > ')) {
					$children = explode(' > ', $current);
					$children_length = count($children);

					// Create a path based on count and push by array index values
					if ($children_length == 1) {
						$new_links[$children[0]]['children'][$key] = $value;
					} else if ($children_length == 2) {
						$new_links[$children[0]]['children'][$children[1]]['children'][$key] = $value;
					} else if ($children_length == 3) {
						$new_links[$children[0]]['children'][$children[1]]['children'][$children[2]]['children'][$key] = $value;
					}
				} else {
					// If there is no additional seperator, add key value to main node
					$new_links[$current]['children'][$key] = $value;
				}
			}
		}
	}

	return $new_links;
}
