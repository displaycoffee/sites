<?php

/**
 *
 * Khy'eras Custom Code. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Adria, https://github.com/displaycoffee
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace displaycoffee\khyeras\event;

if (!defined('IN_PHPBB'))
{
	exit;
}

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
 			'core.page_header' 	  			=> 'theme_globals',
			'core.user_add_after' 		    => 'add_account_group',
			'core.memberlist_view_profile'  => 'memberlist_character_info',
			'core.viewtopic_post_row_after' => 'viewtopic_character_info'
 		);
 	}

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\profilefields\manager */
	protected $manager;

	/** @var \phpbb\profilefields\lang_helper */
	protected $lang_helper;

	/** @var \displaycoffee\khyeras\core\page_info */
	protected $page_info;

	/** @var \displaycoffee\khyeras\core\add_to_group */
	protected $add_to_group;

	/** @var \displaycoffee\khyeras\core\member_character_info */
	protected $member_character_info;

	/** @var \displaycoffee\khyeras\core\topic_character_info */
	protected $topic_character_info;

	/** @var string phpEx */
	protected $php_ext;

 	/**
 	 * Constructor
 	 *
 	 * @param \phpbb\template\template				$template			Template object
 	 * @param \phpbb\user              				$user       		User object
	 * @param \phpbb\db\driver\driver_interface		$db         		DBAL object
	 * @param \phpbb\profilefields\manager			$manager			Profile fields manager
	 * @param \phpbb\profilefields\lang_helper		$lang_helper		Profile fields language helper
	 * @param \displaycoffee\khyeras\core\page_info		$page_info		Testing a page_info
	 * @param \displaycoffee\khyeras\core\add_to_group		$add_to_group		Testing a add_to_group
	 * @param \displaycoffee\khyeras\core\member_character_info		$member_character_info		Testing a add_to_group
	 * @param \displaycoffee\khyeras\core\topic_character_info		$topic_character_info		Testing a add_to_group
	 * @param string                        		$php_ext			phpEx
 	*/
 	public function __construct(\phpbb\template\template $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, \phpbb\profilefields\manager $manager, \phpbb\profilefields\lang_helper $lang_helper, \phpbb\pages\operators\page $pages, \displaycoffee\khyeras\core\page_info $page_info, \displaycoffee\khyeras\core\add_to_group $add_to_group, \displaycoffee\khyeras\core\member_character_info $member_character_info, \displaycoffee\khyeras\core\topic_character_info $topic_character_info, $php_ext)
 	{
 		$this->template    = $template;
 		$this->user		   = $user;
		$this->db		   = $db;
		$this->manager 	   = $manager;
		$this->lang_helper = $lang_helper;
		$this->pages       = $pages;
		$this->page_info       = $page_info;
		$this->add_to_group       = $add_to_group;
		$this->member_character_info       = $member_character_info;
		$this->topic_character_info       = $topic_character_info;
		$this->php_ext	   = $php_ext;
 	}

 	/**
 	 * Set global data for theme use
 	*/
 	public function theme_globals($event)
 	{


		// Get the user id, group id, and lang_id
		$user_id = $this->user->data['user_id'];
		$group_id = $this->user->data['group_id'];
		$lang_id = $this->user->lang_id ? $this->user->lang_id : 1;

		// --- START --- Group Information

		// Get the row of data with selected group_id
		$group_array = array(
			'group_id' => $group_id
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
			for ($i = 0; $i < count($race_values); $i++)
			{
				$current = $this->lang_helper->get($race['data']['field_id'], $lang_id, $race_values[$i]);
				$race_options = $race_options . $current . ', ';
			}

			// class_opts - field information
			$class = $pf['c_class_opts'];
			$class_values = explode(';', $class['value']);

			// class_opts - empty string to add comma separated options
			$class_options = false;

			// class_opts - loop through each class option
			for ($j = 0; $j < count($class_values); $j++)
			{
				$current = $this->lang_helper->get($class['data']['field_id'], $lang_id, $class_values[$j]);
				$class_options = $class_options . $current . ', ';
			}
		}

		// --- END --- Profile Field Information

		// --- START --- Page Display Details



		// --- END --- Page Display Details

		// --- START --- Variable Assignment

		$this->page_info->khy_set_page_details($event);


		// // Assign global template variables for re-use
 		// $this->template->assign_vars(array(
		// 	// 'KHY_USER_GROUP_ID'     => $group_id,
		// 	// 'KHY_USER_GROUP_NAME'   => $group_row['group_name'],
		// 	// 'KHY_USER_ACCOUNT_TYPE' => $account_type
 		// ));
		//
		// // Only add these variables for characters
		// if ($account_type == 'Character') {
		// 	$this->template->assign_vars(array(
		// 		// 'KHY_USER_RACE'  => rtrim($race_options, ', '),
		// 		// 'KHY_USER_CLASS' => rtrim($class_options, ', '),
		// 		//'KHY_USER_LEVEL' => get_level($pf['c_experience']['value'])
	 	// 	));
		// }

		// --- END --- Variable Assignment
 	}

	/**
	* Determine member stats for memberlist_view page
	*/
	public function memberlist_character_info($event) {
		$this->member_character_info->khy_member_character_info($event);
	}

	/**
	* Determine member stats for viewtopic_body page
	*/
	public function viewtopic_character_info($event) {
		$this->topic_character_info->khy_topic_character_info($event);
	}

	/**
	* Add user to correct group and rank after registration
	*/
	public function add_account_group($event) {
		$this->add_to_group->khy_add_to_group($event);
	}
}
