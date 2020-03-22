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
				'KHY_USER_RACE'  => translate_multi_fields($pf['c_race_opts'], $this->lang_helper, $lang_id),
				'KHY_USER_CLASS' => translate_multi_fields($pf['c_class_opts'], $this->lang_helper, $lang_id),
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
				'desc'   => $page_desc,
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
			'KHY_LINKS'        => $page_links,
			'KHY_NAV_LINKS'    => create_navlinks($page_links, $this->utilities)
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
			$character_census = [
				'race'      => [],
				'class'     => [],
				'gender'    => [],
				'residence' => []
			];

			// Name of keys that will appear in census object
			$limit = 'limit';
			$limit_expanded = 'limit_expanded';
			$all = 'all';
			$all_expanded = 'all_expanded';

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
				$days_since_value = -1;
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
						$time_years = get_time_label($time_diff->y, 'year');
						$time_months = get_time_label($time_diff->m, 'month');
						$time_days = get_time_label($time_diff->d, 'day');
						$last_post_value = $time_years . $time_months . $time_days . 'ago';
					} else {
						$last_post_value = 'Less than 1 day ago';
					}
				}

				// Set initial character details
				$character_data = [
					'id'         => $row['user_id'],
					'name'       => $row['username'],
					'profile'    => 'memberlist.php?mode=viewprofile&un=' . $row['username_clean'],
					'days_since' => $days_since_value,
					'last_post'  => $last_post_value,
					'avatar'     => $this->utilities->exists(get_user_avatar($row['user_avatar'], $row['user_avatar_type'], $row['user_avatar_width'], $row['user_avatar_height']), false)
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

				// Get user writer name, race, class, gender, and residence
				$character_writer = $this->utilities->exists($pf['c_writer_name']['value'], false);
				$character_race = translate_multi_fields($pf['c_race_opts'], $this->lang_helper, $lang_id);
				$character_class = translate_multi_fields($pf['c_class_opts'], $this->lang_helper, $lang_id);
				$character_gender = $this->utilities->exists($pf['c_gender']['value'], 'Undisclosed');
				$character_residence = $this->utilities->exists($pf['c_residence']['value'], 'Elsewhere');

				// Get hp and mp loss
				$chracter_remaining = [
					'hp' => ($pf['c_hp']['value'] * 1),
					'mp' => ($pf['c_mp']['value'] * 1)
				];

				// Add details to character data
				$character_data = [
					'writer_url'  => $character_writer ? ('memberlist.php?mode=viewprofile&un=' . $character_writer) : false,
					'writer_name' => $character_writer ? $character_writer : false,
					'race'        => $character_race,
					'class'       => $character_class,
					'gender'      => $character_gender,
					'residence'   => $character_residence,
					'level'       => $character_level,
					'stats'       => $this->utilities->get_life_modifier($character_race, $character_class, $character_level),
					'remaining'   => $chracter_remaining,
					'currency'    => $this->utilities->calc_currency($pf['c_copper']['value'])
				];

				// Add details to characters array
				$characters[$value['id']] = array_merge($characters[$value['id']], $character_data);

				// Break up race to add to count
				$race_array = explode(', ', $character_race);
				$race_count = count($race_array);

				for ($i = 0; $i < $race_count; $i++) {
					$current_race = $race_array[$i];

					// Add counts for census with and without Half-breed separated
					$race_key = ($race_count > 1) ? 'Half-breed' : $current_race;
					$race_modifier = ($race_count > 1) ? (1 / 2) : 1;
					$character_census['race'][$all][$race_key] += $race_modifier;
					$character_census['race'][$all_expanded][$current_race] += 1;

					// Add limited counts for census with and without Half-breed separated
					if (check_limit($value['days_since'])) {
						$character_census['race'][$limit][$race_key] += 1;
						$character_census['race'][$limit_expanded][$current_race] += 1;
					}
				}

				// Break up class to add to count
				$class_array = explode(', ', $character_class);
				$class_count = count($class_array);

				for ($j = 0; $j < $class_count; $j++) {
					$current_class = $class_array[$j];

					// Fix name for Draconic classes
					if ($current_class == 'Physical' || $current_class == 'Magical' || $current_class == 'Restoration') {
						$current_class = 'Draconic - ' . $current_class;
					}

					// Add counts for census with and without Dual separated
					$class_key = ($class_count > 1) ? 'Dual' : $current_class;
					$class_modifier = ($class_count > 1) ? (1 / 2) : 1;
					$character_census['class'][$all][$class_key] += $class_modifier;
					$character_census['class'][$all_expanded][$current_class] += 1;

					// Add limited counts for census with and without Dual separated
					if (check_limit($value['days_since'])) {
						$character_census['class'][$limit][$class_key] += 1;
						$character_census['class'][$limit_expanded][$current_class] += 1;
					}
				}

				// Add gender count
				if ($character_gender) {
					// Set object / array of genders we want to show in the count
					$allowed_genders = [
						'Transgender' => array('transgender', 'transsexual'),
						'Non-binary'  => array('nonbinary', 'genderqueer', 'bigender', 'genderfluid', 'gender fluid', 'agender', 'demigender'),
						'Female'      => array('female', 'woman', 'her', 'she', 'hers', 'girl'),
						'Male'        => array('male', 'man', 'him', 'he', 'his', 'boy'),
						'None'        => array('no gender', 'none'),
					];

					// Set up default gender_key
					$gender_key = 'Undisclosed';

					// Create a gender handle and split into an array
					$pattern = array('/-+/', '/[^a-zA-Z]/', '/ +/');
					$replacement = array('', ' ', ' ');
					$gender_handle = strtolower(preg_replace($pattern, $replacement, $character_gender));
					$gender_array = explode(' ', $gender_handle);

					// Loop through the allowed genders
					foreach ($allowed_genders as $key2 => $value2) {
						// Now check the user's gender and update the gender key
						for ($k = 0; $k < count($gender_array); $k++) {
							if (in_array($gender_array[$k], $value2)) {
								$gender_key = $key2;
								break;
							}
						}
					}

					// Add counts for gender
					$character_census['gender'][$all][$gender_key] += 1;

					// Add limited counts for gender
					if (check_limit($value['days_since'])) {
						$character_census['gender'][$limit][$gender_key] += 1;
					}
				}

				// Add residence count
				if ($character_residence) {
					// Set array of places we want to show in the count
					$allowed_residences = array('Tviyr', 'Ninraih', 'Irtuen Reaches', 'Fellsgard', 'Verdant Row', 'Ajteire', 'Domrhask');

					// If the residence is not in $allowed_residences, add as "Elsewhere"
					$residence_key = in_array($character_residence, $allowed_residences) ? $character_residence : 'Elsewhere';

					// Add counts for residences
					$character_census['residence'][$all][$residence_key] += 1;

					// Add limited counts for residences
					if (check_limit($value['days_since'])) {
						$character_census['residence'][$limit][$residence_key] += 1;
					}
				}
			}

			// Assign global template variables for re-use
			$this->template->assign_vars(array(
				'KHY_CHARACTERS' => $characters,
				'KHY_CENSUS'     => $character_census
	 		));
		}
	}
}

/**
* Check limit for census counts
*/

function check_limit($value) {
	return ($value > -1 && $value <= 180) ? true : false;
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

			// If the current parent contains a ~ character, split again
			if ($utilities->in_string($current, ' ~ ')) {
				$children = explode(' ~ ', $current);

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
* Create navlinks function
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

				// If the current parent contains a ~ character, split again
				if ($utilities->in_string($current, ' ~ ')) {
					$children = explode(' ~ ', $current);
					$children_length = count($children);

					// Create a path based on count and push by array index values
					if ($children_length == 1) {
						$new_links[$children[0]]['children'][$key] = $value;
					} else if ($children_length == 2) {
						$new_links[$children[0]]['children'][$children[1]]['children'][$key] = $value;
					} else if ($children_length == 3) {
						$new_links[$children[0]]['children'][$children[1]]['children'][$children[2]]['children'][$key] = $value;
					}
				} else {// If there is no additional seperator, add key value to main node
					$new_links[$current]['children'][$key] = $value;
				}
			}
		}
	}

	return $new_links;
}

/**
* Get time label (mostly used in core/global_info)
*/
function get_time_label($number, $value) {
	$time_label = '';
	if ($number) {
		$time_label = $number . ' ' . $value . ($number != 1 ? 's' : '') . ' ';
	}

	return $time_label;
}

/**
* Translate multi-select fields like race and class options
*/
function translate_multi_fields($field, $language, $lang_id) {
	// Split field by semi-colon
	$value_array = explode(';', $field['value']);

	// Empty string to add comma separated options
	$value_options = false;

	// Loop through each option and concat string
	for ($i = 0; $i < count($value_array); $i++) {
		$current = $language->get($field['data']['field_id'], $lang_id, $value_array[$i]);
		$value_options = $value_options . $current . ', ';
	}

	return rtrim($value_options, ', ');
}
