<?php

/**
*
* Khy'eras places Code. An extension for the phpBB Forum Software package.
*
* @copyright (c) 2020, Adria, https://github.com/displaycoffee
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace displaycoffee\khyeras\core;

if (!defined('IN_PHPBB')) {
	exit;
}

/**
* Class for setting member details globally
*/

class global_member_info {
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
	*/

	public function __construct(\phpbb\template\template $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, \phpbb\profilefields\manager $manager, \phpbb\profilefields\lang_helper $lang_helper, \displaycoffee\khyeras\utilities\utilities $utilities, $table_prefix) {
		$this->template     = $template;
 		$this->user         = $user;
		$this->db           = $db;
		$this->manager      = $manager;
		$this->lang_helper  = $lang_helper;
		$this->utilities    = $utilities;
		$this->table_prefix = $table_prefix;
	}

	/**
	* Set page details such as handles, types, and links
	*/
	public function khy_set_member_details() {
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
}
