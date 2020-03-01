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

class character_info_profile {
	/** @var \phpbb\template\template */
	protected $template;

	/** @var \displaycoffee\khyeras\utilities\utilities */
	protected $utilities;

	/**
	* Constructor
	*
	* @param \phpbb\template\template                   $template  Template object
	* @param \displaycoffee\khyeras\utilities\utilities $utilities Utilities helper functions
	*/
	public function __construct(\phpbb\template\template $template, \displaycoffee\khyeras\utilities\utilities $utilities) {
		$this->template  = $template;
		$this->utilities = $utilities;
	}

	/**
	* Set character stats for memberlist profile
	*/
	public function khy_set_character_info_to_profile($event) {
		// Set up prefix
		$prefix = 'PROFILE_';

		// Call common utilities
		$common = $this->utilities->common();

		// Get profile fields information
		$pf = $event['profile_fields']['row'];

		// Only assign these variable if character account
		if ($pf[$prefix . 'ACCOUNT_TYPE_VALUE'] == $common['groups']['group_9']['name_s']) {
			$level = $this->utilities->get_level($pf[$prefix . 'C_EXPERIENCE_VALUE']);

			$this->template->assign_vars(array(
				'KHY_MEMBER_LEVEL'    => $level,
				'KHY_MEMBER_STATS'    => $this->utilities->get_life_modifier($pf[$prefix . 'C_RACE_OPTS_VALUE'], $pf[$prefix . 'C_CLASS_OPTS_VALUE'], $level),
				'KHY_MEMBER_CURRENCY' => $this->utilities->calc_currency($pf[$prefix . 'C_COPPER_VALUE'])
	 		));
		}
	}
}
