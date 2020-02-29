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
		// Set up variable shortcuts
		$template = $this->template;
		$utilities = $this->utilities;
		$prefix = 'PROFILE_';

		// Call common utilities
		$common = $utilities->common();

		// Get profile fields information
		$pf = $event['post_row'];

		// Set empty character details array
		$character_details = array();

		// Only assign these variable if character account
		if ($pf[$prefix . 'ACCOUNT_TYPE_VALUE'] == $common['groups']['group_9']['name_s']) {
			$level = $utilities->get_level($pf[$prefix . 'C_EXPERIENCE_VALUE']);

			$character_details = array(
				'PROFILE_LEVEL'	   => $level,
				'PROFILE_STATS'    => $utilities->get_life_modifier($pf[$prefix . 'C_RACE_OPTS_VALUE'], $pf[$prefix . 'C_CLASS_OPTS_VALUE'], $level),
				'PROFILE_CURRENCY' => $utilities->calc_currency($pf[$prefix . 'C_COPPER_VALUE'])
			);
		}

		// Clean description by removing html and bbcode for word count
		$desc = preg_replace('/(\[.*?\])/', '', strip_tags($pf['MESSAGE'], ''));
		$desc_count = array(
			'WORD_COUNT' => str_word_count($desc)
		);

		// Assign viewtopic variables
		$template->assign_block_vars('postrow.khy', array_merge($character_details, $desc_count));
	}
}
