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
		$pf = $event['profile_fields']['row'];

		// Only assign these variable if character account
		if ($pf['PROFILE_ACCOUNT_TYPE_VALUE'] == 'Character') {
			$race = $pf['PROFILE_C_RACE_OPTS_VALUE'];
			$class = $pf['PROFILE_C_CLASS_OPTS_VALUE'];
			$level = $this->utilities->get_level($pf['PROFILE_C_EXPERIENCE_VALUE']);
			$currency = $this->utilities->calc_currency($pf['PROFILE_C_COPPER_VALUE']);

			$this->template->assign_vars(array(
				'KHY_MEMBER_LEVEL'    => $level,
				'KHY_MEMBER_TOTAL_HP' => $this->utilities->get_life_modifier($race, $class, $level)[0],
				'KHY_MEMBER_TOTAL_MP' => $this->utilities->get_life_modifier($race, $class, $level)[1],
				'KHY_MEMBER_COPPER'   => $currency['Copper'],
				'KHY_MEMBER_SILVER'   => $currency['Silver'],
				'KHY_MEMBER_GOLD'     => $currency['Gold'],
				'KHY_MEMBER_PLATINUM' => $currency['Platinum']
	 		));
		}
	}
}
