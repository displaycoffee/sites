<?php
/**
*
* Khy'eras places Code. An extension for the phpBB Forum Software package.
*
* @copyright (c) 2020, Adria, https://github.com/displaycoffee
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace displaycoffee\khyeras\event;

if (!defined('IN_PHPBB')) {
	exit;
}

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface {
	static public function getSubscribedEvents() {
		return array(
			'core.user_add_after'           => 'add_account_to_group',
			'core.memberlist_view_profile'  => 'set_character_info_to_profile',
			'core.viewtopic_post_row_after' => 'set_character_info_to_viewtopic',
			'core.page_header'              => 'set_theme_globals'
		);
	}

	/** @var \displaycoffee\khyeras\core\account_to_group */
	protected $account_to_group;

	/** @var \displaycoffee\khyeras\core\character_info_profile */
	protected $character_info_profile;

	/** @var \displaycoffee\khyeras\core\character_info_viewtopic */
	protected $character_info_viewtopic;

	/** @var \displaycoffee\khyeras\core\global_info */
	protected $global_info;

	/**
	* Constructor
	*
	* @param \displaycoffee\khyeras\core\account_to_group         $account_to_group         Add account to group
	* @param \displaycoffee\khyeras\core\character_info_profile   $character_info_profile   Add character info to profile
	* @param \displaycoffee\khyeras\core\character_info_viewtopic $character_info_viewtopic Add character info to viewtopic
	* @param \displaycoffee\khyeras\core\global_info              $global_info              Add global variables
	*/
 	public function __construct(\displaycoffee\khyeras\core\account_to_group $account_to_group, \displaycoffee\khyeras\core\character_info_profile $character_info_profile, \displaycoffee\khyeras\core\character_info_viewtopic $character_info_viewtopic, \displaycoffee\khyeras\core\global_info $global_info) {
		$this->account_to_group         = $account_to_group;
		$this->character_info_profile   = $character_info_profile;
		$this->character_info_viewtopic = $character_info_viewtopic;
		$this->global_info              = $global_info;
 	}

	/**
	* Add user to correct group and rank after registration
	*/
	public function add_account_to_group($event) {
		$this->account_to_group->khy_add_account_to_group($event);
	}

	/**
	* Set character stats for memberlist profile
	*/
	public function set_character_info_to_profile($event) {
		$this->character_info_profile->khy_set_character_info_to_profile($event);
	}

	/**
	* Set character stats for viewtopic
	*/
	public function set_character_info_to_viewtopic($event) {
		$this->character_info_viewtopic->khy_set_character_info_to_viewtopic($event);
	}

	/**
	* Set global variables for theme
	*/
	public function set_theme_globals($event) {
		// Set global member variables
		$this->global_info->khy_set_member_info($event);

		// Set global page variables
		$this->global_info->khy_set_page_info($event);

		// Get details of characters
		$this->global_info->khy_get_character_details($event);
	}
}
