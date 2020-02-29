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
		// Set up variable shortcuts
		$db = $this->db;
		$utilities = $this->utilities;

		// Call common utilities
		$common = $utilities->common();

		// Get the user id and account type
		$user_id = $event['user_id'];
		$acc_type = 'acc_type_' . $event['cp_data']['pf_account_type'];

		if ($common[$acc_type]) {
			// User group cp_data
			$user_group_arr = array(
				'group_id'     => $common[$acc_type]['group'],
				'user_id' 	   => $user_id,
				'group_leader' => 0,
				'user_pending' => 0
			);

			// Insert a new row into the db for new group
			$user_group_sql = 'INSERT INTO ' . $common['tables']['user_groups'] . ' ' . $db->sql_build_array('INSERT', $user_group_arr);

			// Run the query
			$user_group_result = $db->sql_query($user_group_sql);

			// Be sure to free the result after a SELECT query
			$db->sql_freeresult($user_group_result);

			// User data
			$user_array = array(
				'group_id'    => $common[$acc_type]['group'],
				'user_rank'   => $common[$acc_type]['rank'],
				'user_colour' => $common[$acc_type]['hex']
			);

			// Update users table with default group id
			$user_sql = 'UPDATE ' . $common['tables']['users'] . '
				SET ' . $db->sql_build_array('UPDATE', $user_array) . '
				WHERE user_id = ' . (int) $user_id;

			// Run the query
			$user_result = $db->sql_query($user_sql);

			// Be sure to free the result after a SELECT query
			$db->sql_freeresult($user_result);
		}
	}
}
