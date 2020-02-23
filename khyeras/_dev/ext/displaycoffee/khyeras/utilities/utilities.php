<?php

/**
*
* Khy'eras Custom Code. An extension for the phpBB Forum Software package.
*
* @copyright (c) 2020, Adria, https://github.com/displaycoffee
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace displaycoffee\khyeras\utilities;

if (!defined('IN_PHPBB')) {
	exit;
}

/**
* Utilities/helper functions
*/

class utilities {
	/**
	* Turn strings into hyphen separated handles
	*/
	public function handleize($value) {
		$pattern = array('/&amp;/', '/[^a-zA-Z ]/', '/ +/', '/-+/');
		$replacement = array('and', '', '-', '-');
		$handle = strtolower(preg_replace($pattern, $replacement, $value));

		// Truncate handle if its too long
		$class_limit = 50;
		if (strlen($handle) > $class_limit) {
			$handle = trim(substr($handle, 0, $class_limit), '-');
		}

		return $handle;
	}

	/**
	* Determine what user level is
	*/
	public function get_level($exp)	{
		$per_increment = 5;
		$multiplier_increment = 0.5;
		$base_increment = 25;
		$max_level = 60;
		$max_exp = 107970;

		if ($exp < $max_exp) {
			for ($level = 1; $level <= $max_level; $level++) {
				$multiplier = $base_increment + floor(($level - 1) / $per_increment) * $multiplier_increment;
				$current_experience = $multiplier * $level * ($level - 1);

				if ($current_experience > $exp)	{
					return $level - 1;
				}
			}
		} else {
			return 60;
		}
	}

	/**
	* Determine what total user hp/mp is
	*/
	public function get_life_modifier($race, $class, $level) {
		// Set base modifiers
		$base_hp = 20;
		$base_mp = 15;

		// HP/MP values for races
		$race_list = [
			'Dragon' 	   => ['HP' => 3, 'MP' => 2],
			'Dwarf' 	   => ['HP' => 3, 'MP' => 0],
			'Elemental'    => ['HP' => 1, 'MP' => 3],
			'Fae' 	       => ['HP' => 1, 'MP' => 3],
			'Ghost'        => ['HP' => 2, 'MP' => 2],
			'Human' 	   => ['HP' => 2, 'MP' => 2],
			'Kerasoka' 	   => ['HP' => 2, 'MP' => 0],
			'Korcai' 	   => ['HP' => 2, 'MP' => 1],
			'Lumeacia'     => ['HP' => 1, 'MP' => 3],
			'Shapeshifter' => ['HP' => 2, 'MP' => 2],
			'Ue\'drahc'    => ['HP' => 3, 'MP' => 2],
			'Empty'        => ['HP' => 0, 'MP' => 0]
		];

		// Get race modifiers by calculating average
		$race_modifiers = calc_life_modifier($race, $race_list);

		// HP/MP values for classes
		$class_list = [
			'Alchemist'   => ['HP' => 2, 'MP' => 2],
			'Barbarian'   => ['HP' => 3, 'MP' => 0],
			'Bard' 		  => ['HP' => 2, 'MP' => 2],
			'Cleric'	  => ['HP' => 2, 'MP' => 3],
			'Druid' 	  => ['HP' => 2, 'MP' => 3],
			'Fighter'     => ['HP' => 3, 'MP' => 1],
			'Magical'     => ['HP' => 1, 'MP' => 3],
			'Monk' 		  => ['HP' => 2, 'MP' => 1],
			'Paladin'     => ['HP' => 3, 'MP' => 2],
			'Physical'    => ['HP' => 3, 'MP' => 1],
			'Ranger' 	  => ['HP' => 2, 'MP' => 1],
			'Restoration' => ['HP' => 2, 'MP' => 3],
			'Rogue' 	  => ['HP' => 2, 'MP' => 1],
			'Sorcerer'    => ['HP' => 1, 'MP' => 3],
			'Summoner'    => ['HP' => 1, 'MP' => 3],
			'Wizard'      => ['HP' => 1, 'MP' => 3],
			'Empty'  	  => ['HP' => 0, 'MP' => 0]
		];

		// Get class modifiers by calculating average
		$class_modifiers = calc_life_modifier($class, $class_list);

		// Add total hp/mp modifiers
		$hp_modifer = $class_modifiers[0] + $race_modifiers[0];
		$mp_modifer = $class_modifiers[1] + $race_modifiers[1];

		// Get bonus modifier
		$bonus_hp_modifier = 0;
		$bonus_mp_modifier = 0;

		if ($level % 10 == 0) {
			$bonus_hp_modifier = ($level / 10) * $hp_modifer;
			$bonus_mp_modifier = ($level / 10) * $mp_modifer;
		}

		// Get total hp/mp
		$total_hp = (($base_hp + $class_modifiers[0] + $race_modifiers[0]) * round(($level / 2))) + $bonus_hp_modifier;
		$total_mp = (($base_mp + $class_modifiers[1] + $race_modifiers[1]) * round(($level / 2))) + $bonus_mp_modifier;

		return [$total_hp, $total_mp];
	}

	/**
	* Calculate currency total
	*/
	public function calc_currency($total_copper) {
		$currency_ratio = 100;

		$copper = $total_copper % $currency_ratio;
		$total_silver = $total_copper / $currency_ratio;
		$silver = $total_silver % $currency_ratio;
		$total_gold = $total_silver / $currency_ratio;
		$gold = $total_gold % $currency_ratio;
		$platinum = floor($total_gold / $currency_ratio);

		$currency = [
			'Copper'   => $copper,
			'Silver'   => $silver,
			'Gold' 	   => $gold,
			'Platinum' => $platinum
		];

		return $currency;
	}
}

/**
* Calculate modifiers for hp and mp
*/
function calc_life_modifier($options, $list) {
	$hp_mod = 0;
	$mp_mod = 0;
	$selected_options = explode(', ', $options);

	foreach ($selected_options as $selected) {
		$hp_mod += $list[$selected]['HP'];
		$mp_mod += $list[$selected]['MP'];
	}

	return [round($hp_mod / count($selected_options)), round($mp_mod / count($selected_options))];
}
