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

	/** @var string table_prefix*/
	protected $table_prefix;

	/**
	* Constructor
	*
	* @param \phpbb\db\driver\driver_interface $db            DBAL object
	* @param string                            $table_prefix  Table Prefix
	*/
	public function __construct(\phpbb\db\driver\driver_interface $db, $table_prefix) {
		$this->db           = $db;
		$this->table_prefix = $table_prefix;
	}

	/**
	* Add user to correct group and rank after registration
	*/
	public function khy_add_account_to_group($event) {
		// Get the user id and account type
		$user_id = $event['user_id'];
		$acc_type = $event['cp_data']['pf_account_type'];

		// Set table prefixes
		$user_group_table = $this->table_prefix . 'user_group';
		$users_table = $this->table_prefix . 'users';

		// Set group details object
		// 2 = Writer custom profile field, 3 = Character custom profile field
		$groups = [
			2 => [
				'group' => 8,
				'rank'  => 4,
				'hex'   => 'f19051'
			],
			3 => [
				'group' => 9,
				'rank'  => 5,
				'hex'   => '73abd0'
			]
		];

		if ($groups[$acc_type]) {
			// User group cp_data
			$user_group_arr = array(
				'group_id'     => $groups[$acc_type]['group'],
				'user_id' 	   => $user_id,
				'group_leader' => 0,
				'user_pending' => 0
			);

			// Insert a new row into the db for new group
			$user_group_sql = 'INSERT INTO ' . $user_group_table . ' ' . $this->db->sql_build_array('INSERT', $user_group_arr);

			// Run the query
			$user_group_result = $this->db->sql_query($user_group_sql);

			// Be sure to free the result after a SELECT query
			$this->db->sql_freeresult($user_group_result);

			// User data
			$user_array = array(
				'group_id'    => $groups[$acc_type]['group'],
				'user_rank'   => $groups[$acc_type]['rank'],
				'user_colour' => $groups[$acc_type]['hex']
			);

			// Update users table with default group id
			$user_sql = 'UPDATE ' . $users_table . '
				SET ' . $this->db->sql_build_array('UPDATE', $user_array) . '
				WHERE user_id = ' . (int) $user_id;

			// Run the query
			$user_result = $this->db->sql_query($user_sql);

			// Be sure to free the result after a SELECT query
			$this->db->sql_freeresult($user_result);
		}
	}
}
