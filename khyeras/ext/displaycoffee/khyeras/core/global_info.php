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
			// race_opts - field information
			$race = $pf['c_race_opts'];
			$race_values = explode(';', $race['value']);

			// race_opts - empty string to add comma separated options
			$race_options = false;

			// race_opts - loop through each race option
			for ($i = 0; $i < count($race_values); $i++) {
				$current = $this->lang_helper->get($race['data']['field_id'], $lang_id, $race_values[$i]);
				$race_options = $race_options . $current . ', ';
			}

			// class_opts - field information
			$class = $pf['c_class_opts'];
			$class_values = explode(';', $class['value']);

			// class_opts - empty string to add comma separated options
			$class_options = false;

			// class_opts - loop through each class option
			for ($j = 0; $j < count($class_values); $j++) {
				$current = $this->lang_helper->get($class['data']['field_id'], $lang_id, $class_values[$j]);
				$class_options = $class_options . $current . ', ';
			}
		}

		// --- END --- Profile Field Information

		// --- START --- Variable Assignment

		$character_array = array();
		if ($account_type == 'Character') {
			$character_array = array(
				'KHY_USER_RACE'  => rtrim($race_options, ', '),
				'KHY_USER_CLASS' => rtrim($class_options, ', '),
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
			ORDER BY page_order ASC, page_id ASC';

		// Run the query
		$page_result = $this->db->sql_query($page_sql);

		// Loops through the page rows and add to page_links
		while ($row = $this->db->sql_fetchrow($page_result)) {
			// Get last number in page order
			$page_order = intval(substr($row['page_order'], -1));

			// Get page breadcrumb data
			$page_crumbs = create_breadcrumbs($row['page_description']);

			$page_data = [
				'label'    => $row['page_title'],
				'url'      => $row['page_route'],
				'is_nav'   => ($page_order <= 2) ? true : false,
				'level'    => $page_order,
				'parent'   => $page_crumbs ? $page_crumbs[count($page_crumbs) - 1] : false,
				'crumbs'   => $page_crumbs
			];

			$page_links[$row['page_route']] = $page_data;
		}

		// Be sure to free the result after a SELECT query
		$this->db->sql_freeresult($page_result);

		var_dump(create_navlinks($page_links));

		// --- END --- Page Link Building

		// --- START --- Variable Assignment

		// Assign global template variables for re-use
 		$this->template->assign_vars(array(
			'KHY_SCRIPT_NAME'       => str_replace('app/', '', $page_script_name),
			'KHY_HANDLE_SHORT'      => $page_type,
			'KHY_HANDLE'            => $page_handle,
			//'KHY_LINKS'             => $page_links
 		));

		// Add list of completed achievements only for achievement page
		if ($page_script_name == 'app/gameplay-achievements') {
			$this->template->assign_vars(array(
				'KHY_USER_ACHIEVEMENTS' => $pf['c_achievements']['value']
	 		));
		}

		// --- END --- Variable Assignment
	}
}

/**
* Create breadcrumbs function
*/
function create_breadcrumbs($desc) {
	if ($desc != 'false') {
		// Set initial crumbs array
		$crumbs = array();

		// Split the description for the first time
		$parent_array = explode(' > ', $desc);
		$parent_length = count($parent_array);

		// Loop through the parent crumbs
		for ($i = 0; $i < $parent_length; $i++) {
			$current =  $parent_array[$i];

			// If the current parent contains a | character, split again
			if (strpos($current, ' | ') !== false) {
				$child_crumbs = array();
				$child_array = explode(' | ', $current);
				$child_length = count($child_array);

				// Loop through child crumbs and add into a child array
				for ($j = 0; $j < $child_length; $j++) {
					array_push($child_crumbs, $child_array[$j]);
				}

				// Then push child array to crumbs
				array_push($crumbs, $child_crumbs);
			} else {
				// Push parent value to crumbs
				array_push($crumbs, $current);
			}
		}
	} else {
		$crumbs = false;
	}

	return $crumbs;
}

/**
* Create breadcrumbs function
*/
function create_navlinks($links) {
	$new_links = [];

	// Get all top level nodes into $new_links
	// Add remaining nodes to $children
	foreach ($links as $key => $value) {
		if (!$value['parent']) {

			$new_links[$key] = $value;


		} else {

			// if ($new_links[$value['parent']]) {
			//
			// 	$new_links[$value['parent']]['children'][$key] = $value;
			//
			// } else {

				$crumbs_count = count($value['crumbs']);

				for ($i = 0; $i < $crumbs_count; $i++) {

					$current_crumb = $value['crumbs'][$i];
					$previous_crumb = $value['crumbs'][$i - 1];

					if ($previous_crumb) {

						if (is_array($current_crumb)) {

							for ($j = 0; $j < count($current_crumb); $j++) {

								$new_links[$previous_crumb]['children'][$current_crumb[$j]]['children'][$key] = $value;

							}

						} else {




							$new_links[$previous_crumb]['children'][$current_crumb]['children'][$key] = $value;

						}

					}

				}
		}
	}

	return $new_links;
}
