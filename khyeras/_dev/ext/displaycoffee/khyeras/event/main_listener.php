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

	/** @var \displaycoffee\khyeras\core\page_info */
	protected $page_info;

	/** @var \displaycoffee\khyeras\core\global_member_info */
	protected $global_member_info;

	/** @var \displaycoffee\khyeras\core\member_character_info */
	protected $member_character_info;

	/** @var \displaycoffee\khyeras\core\topic_character_info */
	protected $topic_character_info;

	/** @var \displaycoffee\khyeras\core\add_to_group */
	protected $add_to_group;

 	/**
 	 * Constructor
 	 *
	 * @param \displaycoffee\khyeras\core\page_info		$page_info		Testing a page_info
	 * @param \displaycoffee\khyeras\core\global_member_info		$global_member_info		Testing a global_member_info
	 * @param \displaycoffee\khyeras\core\member_character_info		$member_character_info		Testing a add_to_group
	 * @param \displaycoffee\khyeras\core\topic_character_info		$topic_character_info		Testing a add_to_group
	 * @param \displaycoffee\khyeras\core\add_to_group		$add_to_group		Testing a add_to_group
 	*/
 	public function __construct(\displaycoffee\khyeras\core\page_info $page_info, \displaycoffee\khyeras\core\global_member_info $global_member_info, \displaycoffee\khyeras\core\member_character_info $member_character_info, \displaycoffee\khyeras\core\topic_character_info $topic_character_info, \displaycoffee\khyeras\core\add_to_group $add_to_group)
 	{
		$this->page_info       = $page_info;
		$this->global_member_info       = $global_member_info;
		$this->member_character_info       = $member_character_info;
		$this->topic_character_info       = $topic_character_info;
		$this->add_to_group       = $add_to_group;
 	}

 	/**
 	 * Set global data for theme use
 	*/
 	public function theme_globals($event) {
		$this->page_info->khy_set_page_details($event);

		$this->global_member_info->khy_set_member_details();
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
