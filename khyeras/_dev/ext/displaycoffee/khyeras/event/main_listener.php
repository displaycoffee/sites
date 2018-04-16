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
 			'core.page_header' => 'pf_variables'
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

		global $phpbb_container, $db;

		$user_id = $this->user->data['user_id'];

		$cp = $phpbb_container->get('profilefields.manager');
		$profile_fields = $cp->grab_profile_fields_data($user_id);

		$acc_type = $profile_fields[$user_id]['account_type']['value'];
		if ($acc_type == 2) {
			$acc_type = 'Writer';
		} else if ($acc_type == 3) {
			$acc_type = 'Character';
		} else {
			$acc_type = null;
		}

 		$this->template->assign_vars(array(
			'ACCOUNT_TYPE' => $acc_type
 		));

		//var_dump($this->user->data['group_id']);

		if ($this->user->data['group_id'] == '10') {

			// $sql_ary = array(
			//     'group_id'    => '10'
			// );
			//
			// $sql_arr = array(
			//     'group_id'    => '10',
			//     'user_id'        => $user_id,
			//     'group_leader'    => 0,
			//     'user_pending'     => 0,
			// );

			// $sql = 'INSERT INTO ' . USER_GROUP_TABLE . '
			//     SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
			//     WHERE user_id = ' . (int) $user_id;
			// $db->sql_query($sql);


			// $sql = 'INSERT INTO ' . USER_GROUP_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_arr);
			// $db->sql_query($sql);

			// $sql = 'UPDATE ' . USERS_TABLE . '
			//     SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
			//     WHERE user_id = ' . (int) $user_id;
			// $db->sql_query($sql);

		}
 	}
 }
