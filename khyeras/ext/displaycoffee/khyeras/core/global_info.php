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
		// Get the lang_id
		$lang_id = $this->user->lang_id ? $this->user->lang_id : 1;

		// Create users table prefix
		$users_table = $this->table_prefix . 'users';

		// Empty object to store characters
		$characters = [];

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
				'last_active' => $this->user->format_date($row['user_lastvisit']),
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

			// Get user race and class
			$character_race = translate_multi_fields($pf['c_race_opts'], $this->lang_helper, $lang_id);
			$character_class = translate_multi_fields($pf['c_class_opts'], $this->lang_helper, $lang_id);

			// Add details to characters array
			$characters[$value['id']]['race'] = $character_race;
			$characters[$value['id']]['class'] = $character_class;
		}

		var_dump($characters);
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
