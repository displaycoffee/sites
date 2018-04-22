<?php
/**
 *
 * Khy'eras Custom Code. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Adria, https://github.com/displaycoffee
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace displaycoffee\khyeras\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Khy'eras Custom Code Event listener.
 */
 class main_listener implements EventSubscriberInterface
 {
 	static public function getSubscribedEvents()
 	{
 		return array(
 			'core.page_header' 	  => 'pf_variables',
			'core.user_add_after' => 'add_account_group'
 		);
 	}

 	/* @var \phpbb\controller\helper */
 	protected $helper;

 	/* @var \phpbb\template\template */
 	protected $template;

 	/* @var \phpbb\user */
 	protected $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

 	/**
 	 * Constructor
 	 *
 	 * @param \phpbb\controller\helper	$helper		Controller helper object
 	 * @param \phpbb\template\template	$template	Template object
 	 * @param \phpbb\user               $user       User object
 	 * @param string                    $php_ext    phpEx
 	 */
 	public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db)
 	{
 		$this->helper   = $helper;
 		$this->template = $template;
 		$this->user     = $user;
		$this->db       = $db;
 	}

 	/**
 	 * Get data from profile fields
 	 */
 	public function pf_variables()
 	{
		global $phpbb_container;

		// Get the user id and group id
		$user_id = $this->user->data['user_id'];
		$group_id = $this->user->data['group_id'];

		// --- START --- Group Information

		// Get the row of data with selected group_id
		$group_array = array(
		    'group_id'    => $group_id
		);

		// Create the SQL statement for group data
		$group_sql = 'SELECT group_name
	        FROM ' . GROUPS_TABLE . '
	        WHERE ' . $this->db->sql_build_array('SELECT', $group_array);

		// Run the query
		$group_result = $this->db->sql_query($group_sql);

		// $group_row should hold the selected data
		$group_row = $this->db->sql_fetchrow($group_result);

		// Be sure to free the result after a SELECT query
		$this->db->sql_freeresult($group_result);

		// --- END --- Group Information

		// --- START --- Profile Field Information

		// Get profile data from profilefields manager
		$pf = $phpbb_container->get('profilefields.manager')->grab_profile_fields_data($user_id);

		// Get the profile field information
		$acc_id = $pf[$user_id]['account_type']['data']['field_id'];
		$acc_value = ($pf[$user_id]['account_type']['value']) - 1;

		// Get the row of data with selected field_id and option_id
		$pf_array = array(
		    'field_id'  => $acc_id,
			'option_id' => $acc_value
		);

		// Create the SQL statement for group data
		$pf_sql = 'SELECT lang_value
	        FROM ' . PROFILE_FIELDS_LANG_TABLE . '
	        WHERE ' . $this->db->sql_build_array('SELECT', $pf_array);

		// Run the query
		$pf_result = $this->db->sql_query($pf_sql);

		// $pf_row should hold the selected data
		$pf_row = $this->db->sql_fetchrow($pf_result);

		// Be sure to free the result after a SELECT query
		$this->db->sql_freeresult($pf_result);

		// --- END --- Profile Field Information

		// --- START --- Variable Assignment

		// Assign global template variables for re-use
 		$this->template->assign_vars(array(
			'KHY_ACCOUNT_TYPE' => $pf_row['lang_value'],
			'KHY_GROUP_ID'     => $group_id,
			'KHY_GROUP_NAME'   => $group_row['group_name']
 		));

		// --- END --- Variable Assignment
 	}

	/**
	 * Add user to account type group after activation
	 */
	public function add_account_group($event)
	{
		// Get the user id and account type
		$user_id = $event['user_id'];
		$acc_type = $event['cp_data']['pf_account_type'];

		// Check the account type field
		// Writer > 2 / group_id > 8 / rank > 4 | Character > 3 / group_id > 9 / rank > 5
		if ($acc_type == 2) {
			$group_number = '8';
			$rank_number = '4';
		} else if ($acc_type == 3) {
			$group_number = '9';
			$rank_number = '5';
		}

		if ($acc_type == 2 || $acc_type == 3) {
			// User group cp_data
			$user_group_arr = array(
			    'group_id'     => $group_number,
			    'user_id' 	   => $user_id,
			    'group_leader' => 0,
			    'user_pending' => 0,
			);

			// Insert a new row into the db for new group
			$user_group_sql = 'INSERT INTO ' . USER_GROUP_TABLE . ' ' . $this->db->sql_build_array('INSERT', $user_group_arr);
			$this->db->sql_query($user_group_sql);

			// User data
			$user_array = array(
			    'group_id'     => $group_number,
				'user_rank'    => $rank_number
			);

			// Update users table with default group id
			$user_sql = 'UPDATE ' . USERS_TABLE . '
			    SET ' . $this->db->sql_build_array('UPDATE', $user_array) . '
			    WHERE user_id = ' . (int) $user_id;
			$this->db->sql_query($user_sql);
		}
	}
 }
