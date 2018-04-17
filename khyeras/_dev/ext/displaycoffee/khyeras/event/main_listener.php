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

 	/**
 	 * Constructor
 	 *
 	 * @param \phpbb\controller\helper	$helper		Controller helper object
 	 * @param \phpbb\template\template	$template	Template object
 	 * @param \phpbb\user               $user       User object
 	 * @param string                    $php_ext    phpEx
 	 */
 	public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user)
 	{
 		$this->helper   = $helper;
 		$this->template = $template;
 		$this->user     = $user;
 	}

 	/**
 	 * Get data from profile fields
 	 */
 	public function pf_variables()
 	{
		global $phpbb_container;

		// Get the user id
		$user_id = $this->user->data['user_id'];

		// Get profile field data
		$cp = $phpbb_container->get('profilefields.manager');
		$pf = $cp->grab_profile_fields_data($user_id);

		// Get the account type
		$acc_type = $pf[$user_id]['account_type']['value'];

		// Check the account type field
		// 2 == Writer, 3 == Character
		if ($acc_type == 2) {
			$acc_type = 'Writer';
		} else if ($acc_type == 3) {
			$acc_type = 'Character';
		} else {
			$acc_type = null;
		}

		// Assign global template variables for re-use
 		$this->template->assign_vars(array(
			'ACCOUNT_TYPE' => $acc_type
 		));
 	}

	/**
	 * Add user to account type group after activation
	 */
	public function add_account_group($event)
	{
		global $db;

		// Get the user id and account type
		$user_id = $event['user_id'];
		$acc_type = $event['cp_data']['pf_account_type'];

		// Check the account type field
		// 2 == Writer / 10 == group id, 3 == Character / 11 == group id
		if ($acc_type == 2) {
			$group_number = '10';
		} else if ($acc_type == 3) {
			$group_number = '11';
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
			$user_group_sql = 'INSERT INTO ' . USER_GROUP_TABLE . ' ' . $db->sql_build_array('INSERT', $user_group_arr);
			$db->sql_query($user_group_sql);

			// User data
			$user_array = array(
			    'group_id'    => $group_number
			);

			// Update users table with default group id
			$user_sql = 'UPDATE ' . USERS_TABLE . '
			    SET ' . $db->sql_build_array('UPDATE', $user_array) . '
			    WHERE user_id = ' . (int) $user_id;
			$db->sql_query($user_sql);
		}
	}
 }
