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

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\cache\driver\driver_interface */
	protected $db;

	/** @var \phpbb\profilefields\manager */
	protected $manager;

	/** @var \phpbb\profilefields\lang_helper */
	protected $lang_helper;

	/** @var \displaycoffee\khyeras\utilities\utilities */
	protected $utilities;

	/** @var string table_prefix */
	protected $table_prefix;

	/** @var string phpEx */
	protected $php_ext;

	/**
	* Constructor
	*
	* @param \phpbb\template\template                   $template     Template object
	* @param \phpbb\user                                $user         User object
	* @param \phpbb\db\driver\driver_interface          $db           DBAL object
	* @param \phpbb\profilefields\manager               $manager      Profile fields manager
	* @param \phpbb\profilefields\lang_helper           $lang_helper  Profile fields language helper
	* @param \displaycoffee\khyeras\utilities\utilities $utilities Utilities helper functions
	* @param string                                     $table_prefix Table Prefix
	* @param string                                     $php_ext      phpEx
	*/
	public function __construct(\phpbb\template\template $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, \phpbb\profilefields\manager $manager, \phpbb\profilefields\lang_helper $lang_helper, \displaycoffee\khyeras\utilities\utilities $utilities, $table_prefix, $php_ext) {
		$this->template     = $template;
 		$this->user         = $user;
		$this->db           = $db;
		$this->manager      = $manager;
		$this->lang_helper  = $lang_helper;
		$this->utilities    = $utilities;
		$this->table_prefix = $table_prefix;
		$this->php_ext      = $php_ext;
	}

	/**
	* Set global member variables
	*/
	public function khy_set_member_info($event) {
		// Get the user id, group id, and lang_id
		$user_id = $this->user->data['user_id'];
		$group_id = $this->user->data['group_id'];
		$lang_id = $this->user->lang_id ? $this->user->lang_id : 1;

		var_dump($this->utilities->common());

		// --- START --- Group Information

		// Set table group prefix
		$group_table = $this->table_prefix . 'groups';

		// Get the row of data with selected group_id
		$group_array = array(
			'group_id' => $group_id
		);

		// Create the SQL statement for group data
		$group_sql = 'SELECT group_name
			FROM ' . $group_table . '
			WHERE ' . $this->db->sql_build_array('SELECT', $group_array);

		// Run the query
		$group_result = $this->db->sql_query($group_sql);

		// $group_row should hold the selected data
		$group_row = $this->db->sql_fetchrow($group_result);

		// Be sure to free the result after a SELECT query
		$this->db->sql_freeresult($group_result);

		// --- END --- Group Information

		// --- START --- Profile Field Information

		// Get user profile field information
		$pf = $this->manager->grab_profile_fields_data($user_id)[$user_id];

		// Load profile field language
		$this->lang_helper->load_option_lang($lang_id);

		// account_type - field information
		$acc = $pf['account_type'];
		$account_type = $this->lang_helper->get($acc['data']['field_id'], $lang_id, $acc['value']);

		// Only do the below actions on character accounts
		if ($group_row['group_name'] == 'Characters') {
			// Get user race and class
			$user_race = translate_multi_fields($pf['c_race_opts'], $this->lang_helper, $lang_id);
			$user_class = translate_multi_fields($pf['c_class_opts'], $this->lang_helper, $lang_id);
		}

		// --- END --- Profile Field Information

		// --- START --- Variable Assignment

		$character_array = array();
		if ($account_type == 'Character') {
			$character_array = array(
				'KHY_USER_RACE'  => $user_race,
				'KHY_USER_CLASS' => $user_class,
				'KHY_USER_LEVEL' => $this->utilities->get_level($pf['c_experience']['value'])
	 		);
		}

		$account_array = array(
			'KHY_USER_GROUP_ID'     => $group_id,
			'KHY_USER_GROUP_NAME'   => $group_row['group_name'],
			'KHY_USER_ACCOUNT_TYPE' => $account_type
 		);

		// Assign global template variables for re-use
 		$this->template->assign_vars(array_merge($character_array, $account_array));

		// --- END --- Variable Assignment
	}

	/**
	* Set global page variables
	*/
	public function khy_set_page_info($event) {
		// --- START --- Page Display Details

		// Set page_script_name and initial page_type
		$page_script_name = str_replace('.' . $this->php_ext, '', $this->user->page['page_name']);
		$page_type = $page_script_name;

		// Get page titles
		$page_title = strtolower($event['page_title']);
		$page_l_title = strtolower($this->template->retrieve_var('L_TITLE'));

		// If on a certain type of page, reset the page_type or page_title
		if (strpos($page_type, 'thankslist/givens') !== false) {
			$page_type = 'search';
			$page_title = 'thanks';
		} elseif (strpos($page_type, 'app/') !== false) {
			$page_type = 'page';
		} elseif ($page_type == 'mcp' && $page_l_title && ($page_title != $page_l_title)) {
			$page_title = $page_l_title;
		}

		// Piece together page details for handle
		$page_handle = $page_type . '-' . $this->utilities->handleize($page_title);

		// --- END --- Page Display Details

		// --- START --- Page Link Building

		// Create pages table prefix
		$pages_table = $this->table_prefix . 'pages';

		// Empty object to store page links
		$page_links = [];

		// Create the SQL statement for page data
		$page_sql = 'SELECT *
			FROM ' . $pages_table . '
			ORDER BY page_order ASC, page_title ASC';

		// Run the query
		$page_result = $this->db->sql_query($page_sql);

		// Loops through the page rows and add to page_links
		while ($row = $this->db->sql_fetchrow($page_result)) {
			// Get last number in page order
			$page_order = intval(substr($row['page_order'], -1));

			// Get page description
			$page_desc = $row['page_description'] ? $row['page_description'] : false;

			$page_data = [
				'label'    => $row['page_title'],
				'url'      => $row['page_route'],
				'is_nav'   => ($page_order <= 2) ? true : false,
				'level'    => $page_order,
				'crumbs'   => create_breadcrumbs($page_desc),
				'desc'     => $page_desc
			];

			$page_links[$row['page_route']] = $page_data;
		}

		// Be sure to free the result after a SELECT query
		$this->db->sql_freeresult($page_result);

		// --- END --- Page Link Building

		// --- START --- Variable Assignment

		// Assign global template variables for re-use
 		$this->template->assign_vars(array(
			'KHY_SCRIPT_NAME'       => str_replace('app/', '', $page_script_name),
			'KHY_HANDLE_SHORT'      => $page_type,
			'KHY_HANDLE'            => $page_handle,
			//'KHY_LINKS'             => $page_links,
			//'KHY_NAV_LINKS'         => create_navlinks($page_links)
 		));

		// Add list of completed achievements only for achievement page
		if ($page_script_name == 'app/gameplay-achievements') {
			$this->template->assign_vars(array(
				'KHY_USER_ACHIEVEMENTS' => $pf['c_achievements']['value']
	 		));
		}

		// --- END --- Variable Assignment
	}

	/**
	* Get details of characters
	*/
	public function khy_get_character_details($event) {
		// Set page_script_name and initial page_type
		$page_script_name = str_replace('.' . $this->php_ext, '', $this->user->page['page_name']);
		$page_type = $page_script_name;

		// Don't run any of the below code unless on the correct pages
		if ($page_script_name == 'app/members-character-census' || $page_script_name == 'app/members-character-listing') {
			// Get the lang_id
			$lang_id = $this->user->lang_id ? $this->user->lang_id : 1;

			// Create users table prefix
			$users_table = $this->table_prefix . 'users';

			// Empty object to store characters
			$characters = [];

			// Empty object to store counts for stats
			$races_count = [];
			$races_count_expanded = [];
			$classes_count = [];
			$classes_count_expanded = [];
			$residences_count = [];

			// Create the SQL statement for character data
			$character_sql = 'SELECT *
				FROM ' . $users_table . '
				WHERE group_id=9 ORDER BY user_id ASC';

			// Run the query
			$character_result = $this->db->sql_query($character_sql);

			// Loops through the chracter rows and add to characters
			while ($row = $this->db->sql_fetchrow($character_result)) {
				$character_data = [
					'id'          => $row['user_id'],
					'name'        => $row['username'],
					'last_active' => $this->user->format_date($row['user_lastpost_time']),
					'avatar'      => $row['user_avatar'] ? $row['user_avatar'] : false
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
				$character_currency = $this->utilities->calc_currency($pf['c_copper']['value']);

				// Get user race, class, and residence
				$character_race_type = translate_multi_fields($pf['c_race_type'], $this->lang_helper, $lang_id);
				$character_race = translate_multi_fields($pf['c_race_opts'], $this->lang_helper, $lang_id);
				$character_class_type = translate_multi_fields($pf['c_class_type'], $this->lang_helper, $lang_id);
				$character_class = translate_multi_fields($pf['c_class_opts'], $this->lang_helper, $lang_id);
				$character_residence = $pf['c_residence']['value'] ? $pf['c_residence']['value'] : false;

				// Add details to character data
				$character_data = [
					'race'      => $character_race,
					'class'     => $character_class,
					'residence' => $character_residence,
					'level'     => $character_level,
					'hp'        => $this->utilities->get_life_modifier($character_race, $character_class, $character_level)[0],
					'mp'        => $this->utilities->get_life_modifier($character_race, $character_class, $character_level)[1],
					'copper'    => $character_currency['Copper'],
					'silver'    => $character_currency['Silver'],
					'gold'      => $character_currency['Gold'],
					'platinum'  => $character_currency['Platinum']
				];

				// Add details to characters array
				$characters[$value['id']] = array_merge($characters[$value['id']], $character_data);

				// Break up race to add to count
				$race_array = explode(', ', $character_race);

				for ($i = 0; $i < count($race_array); $i++) {
					$current_race = $race_array[$i];

					// Add counts for all races with Half-breeds not seperated
					$race_key = ($character_race_type == 'Half-breed') ? 'Half-breed' : $current_race;
					$races_count[$race_key] = get_stat_count($races_count[$race_key]);

					// Add counts for races with Half-breeds seperated
					$races_count_expanded[$current_race] = get_stat_count($races_count_expanded[$current_race]);
				}

				// Break up class to add to count
				$class_array = explode(', ', $character_class);

				for ($j = 0; $j < count($class_array); $j++) {
					$current_class = $class_array[$j];

					// Fix label for Draconic classes
					if ($current_class == 'Physical' || $current_class == 'Magical' || $current_class == 'Restoration') {
						$current_class = 'Draconic - ' . $current_class;
					}

					// Add counts for all classes with Dual not seperated
					$class_key = ($character_class_type == 'Dual') ? 'Dual' : $current_class;
					$classes_count[$class_key] = get_stat_count($classes_count[$class_key]);

					// Add counts for classes with Dual seperated
					$classes_count_expanded[$current_class] = get_stat_count($classes_count_expanded[$current_class]);
				}

				// Add residence count
				if ($character_residence) {
					// Set array of places we want to show in the count
					$allowed_residences = array('Tviyr', 'Ninraih', 'Irtuen Reaches', 'Fellsgard', 'Verdant Row', 'Ajteire', 'Domrhask');

					// If the residence is not in $allowed_residences, add as "Elsewhere"
					$residence_key = in_array($character_residence, $allowed_residences) ? $character_residence : 'Elsewhere';

					// Add counts for residences
					$residences_count[$residence_key] = get_stat_count($residences_count[$residence_key]);
				}
			}

			// Adjust race and class count for Half-breed and Dual
			if ($races_count['Half-breed']) {
				$races_count['Half-breed'] = $races_count['Half-breed'] / 2;
			}
			if ($classes_count['Dual']) {
				$classes_count['Dual'] = $classes_count['Dual'] / 2;
			}

			// --- START --- Variable Assignment

			// Assign global template variables for re-use
			$this->template->assign_vars(array(
				'KHY_CHARACTERS'             => $characters,
				'KHY_RACES_COUNT'            => $races_count,
				'KHY_RACES_COUNT_EXPANDED'   => $races_count_expanded,
				'KHY_CLASSES_COUNT'          => $classes_count,
				'KHY_CLASSES_COUNT_EXPANDED' => $classes_count_expanded,
				'KHY_RESIDENCES_COUNT'       => $residences_count
	 		));

			var_dump($characters);

			// --- END --- Variable Assignment
		}
	}
}

/**
* Create breadcrumbs function
*/
function create_breadcrumbs($desc) {
	if ($desc) {
		// Set initial breadcrumbs array
		$breadcrumbs = array();

		// Split the description for the first time
		$parent = explode(' | ', $desc);

		// Loop through the parent breadcrumbs
		for ($i = 0; $i < count($parent); $i++) {
			$current =  $parent[$i];

			// If the current parent contains a > character, split again
			if (strpos($current, ' > ') !== false) {
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
function create_navlinks($links) {
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
				if (strpos($current, ' > ') !== false) {
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


/**
* Get stat count for things like number of races or classes
*/
function get_stat_count($object) {
	if ($object) {
		return $object + 1;
	} else {
		return 1;
	}
}
