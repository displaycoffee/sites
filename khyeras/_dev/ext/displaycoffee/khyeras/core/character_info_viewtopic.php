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
		// Set up prefix
		$prefix = 'PROFILE_';

		// Call common utilities
		$common = $this->utilities->common();

		// Get profile fields information
		$pf = $event['post_row'];

		// Set empty character details array
		$character_details = array();

		// Only assign these variable if character account
		if ($pf[$prefix . 'ACCOUNT_TYPE_VALUE'] == $common['groups']['group_9']['name_s']) {
			$level = $this->utilities->get_level($pf[$prefix . 'C_EXPERIENCE_VALUE']);

			$character_details = array(
				'PROFILE_LEVEL'	   => $level,
				'PROFILE_STATS'    => $this->utilities->get_life_modifier($pf[$prefix . 'C_RACE_OPTS_VALUE'], $pf[$prefix . 'C_CLASS_OPTS_VALUE'], $level),
				'PROFILE_CURRENCY' => $this->utilities->calc_currency($pf[$prefix . 'C_COPPER_VALUE'])
			);
		}

		// Set empty badge details array
		$badge_details = array();

		// Only assign these variables if member has badges
		if ($pf[$prefix . 'C_BADGES_VALUE']) {
			// Set empty badge data array
			$member_badge_data = array();

			// List of badges
			$badges = $this->utilities->get_badges();

			// Split member badges
			$badge_array = explode(', ', $pf[$prefix . 'C_BADGES_VALUE']);

			// Loop through main badge types
			foreach ($badges as $key => $value) {
				if ($value['list']) {
					// Loop through badge types list
					foreach ($value['list'] as $badge_list_key => $badge_list_value) {
						// If the badge is in the badge_array, push the member data to member badge data
						if (in_array($badge_list_key, $badge_array)) {
							$badge_details = $badge_list_value;
							$badge_details['type'] = $key;
							unset($badge_details['recipients']);

							array_push($member_badge_data, $badge_details);
						}
					}
				}
			}

			if ($member_badge_data) {
				$badge_details = array(
					'PROFILE_BADGES' => $member_badge_data
				);
			}
		}

		// Clean description by removing html and bbcode for word count
		$desc = preg_replace('/(\[.*?\])/', '', strip_tags($pf['MESSAGE'], ''));
		$desc_count = array(
			'WORD_COUNT' => str_word_count($desc)
		);

		// Assign viewtopic variables
		$this->template->assign_block_vars('postrow.khy', array_merge($character_details, $badge_details, $desc_count));
	}
}
