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

class character_info_viewtopic {
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
	* Set character stats for viewtopic
	*/
	public function khy_set_character_info_to_viewtopic($event) {
		$pf = $event['post_row'];
		$character_details = array();

		// Only assign these variable if character account
		if ($pf['PROFILE_ACCOUNT_TYPE_VALUE'] == 'Character') {
			$race = $pf['PROFILE_C_RACE_OPTS_VALUE'];
			$class = $pf['PROFILE_C_CLASS_OPTS_VALUE'];
			$level = $this->utilities->get_level($pf['PROFILE_C_EXPERIENCE_VALUE']);
			$currency = $this->utilities->calc_currency($pf['PROFILE_C_COPPER_VALUE']);

			$character_details = array(
				'PROFILE_LEVEL'	   => $level,
				'PROFILE_TOTAL_HP' => $this->utilities->get_life_modifier($race, $class, $level)[0],
				'PROFILE_TOTAL_MP' => $this->utilities->get_life_modifier($race, $class, $level)[1],
				'PROFILE_COPPER'   => $currency['Copper'],
				'PROFILE_SILVER'   => $currency['Silver'],
				'PROFILE_GOLD' 	   => $currency['Gold'],
				'PROFILE_PLATINUM' => $currency['Platinum']
			);
		}

		// Clean description by removing html and bbcode for word count
		$desc = preg_replace('/(\[.*?\])/', '', strip_tags($pf['MESSAGE'], ''));
		$desc_count = array(
			'WORD_COUNT' => str_word_count($desc)
		);

		// Assign viewtopic variables
		$this->template->assign_block_vars('postrow.khy', array_merge($character_details, $desc_count));
	}
}
