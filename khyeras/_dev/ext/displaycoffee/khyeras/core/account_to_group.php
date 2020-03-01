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

class account_to_group {
	/** @var \phpbb\cache\driver\driver_interface */
	protected $db;

	/** @var \displaycoffee\khyeras\utilities\utilities */
	protected $utilities;

	/**
	* Constructor
	*
	* @param \phpbb\db\driver\driver_interface          $db        DBAL object
	* @param \displaycoffee\khyeras\utilities\utilities $utilities Utilities helper functions
	*/
	public function __construct(\phpbb\db\driver\driver_interface $db, \displaycoffee\khyeras\utilities\utilities $utilities) {
		$this->db        = $db;
		$this->utilities = $utilities;
	}

	/**
	* Add user to correct group and rank after registration
	*/
	public function khy_add_account_to_group($event) {
		// Call common utilities
		$common = $this->utilities->common();

		// Get the user id and account type
		$user_id = $event['user_id'];
		$acc_type = $event['cp_data']['pf_account_type'];

		// Set group id base on account type
		$group_id = false;
		if ($acc_type == 2) {
			$group_id = 'group_8';
		} else if ($acc_type == 3) {
			$group_id = 'group_9';
		}

		if ($common['groups'][$group_id]) {
			// Set group data
			$user_group_data = $common['groups'][$group_id];

			// User group cp_data
			$user_group_arr = array(
				'group_id'     => $user_group_data['id'],
				'user_id' 	   => $user_id,
				'group_leader' => 0,
				'user_pending' => 0
			);

			// Insert a new row into the db for new group
			$user_group_sql = 'INSERT INTO ' . $common['tables']['user_groups'] . ' ' . $this->db->sql_build_array('INSERT', $user_group_arr);

			// Run the query
			$user_group_result = $this->db->sql_query($user_group_sql);

			// Be sure to free the result after a SELECT query
			$this->db->sql_freeresult($user_group_result);

			// User data
			$user_array = array(
				'group_id'    => $user_group_data['id'],
				'user_rank'   => $user_group_data['rank'],
				'user_colour' => $user_group_data['hex']
			);

			// Update users table with default group id
			$user_sql = 'UPDATE ' . $common['tables']['users'] . '
				SET ' . $this->db->sql_build_array('UPDATE', $user_array) . '
				WHERE user_id = ' . (int) $user_id;

			// Run the query
			$user_result = $this->db->sql_query($user_sql);

			// Be sure to free the result after a SELECT query
			$this->db->sql_freeresult($user_result);
		}
	}
}
