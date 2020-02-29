<?php
/**
*
* Khy'eras places Code. An extension for the phpBB Forum Software package.
*
* @copyright (c) 2020, Adria, https://github.com/displaycoffee
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace displaycoffee\khyeras\utilities;

if (!defined('IN_PHPBB')) {
	exit;
}

class utilities {
	/** @var string groups_table */
	protected $groups_table;

	/** @var string pages_table */
	protected $pages_table;

	/** @var string users_table */
	protected $users_table;

	/** @var string user_group_table */
	protected $user_group_table;

	/**
	* Constructor
	*
	* @param string $groups_table      Table Prefix
	* @param string $pages_table       Table Prefix
	* @param string $users_table       Table Prefix
	* @param string $user_group_table  Table Prefix
	*/
	public function __construct($groups_table, $pages_table, $users_table, $user_group_table) {
		$this->groups_table     = $groups_table;
		$this->pages_table      = $pages_table;
		$this->users_table      = $users_table;
		$this->user_group_table = $user_group_table;
	}

	/**
	* Common extension variables
	*/
	public function common() {
		$common = [
			'tables' => [
				'groups'      => $this->groups_table,
				'pages'       => $this->pages_table,
				'users'       => $this->users_table,
				'user_groups' => $this->user_group_table
			],
			'acc_type_2' => [
				'type'   => 2,
				'name_s' => 'Writer',
				'name_p' => 'Writers',
				'group'  => 8,
				'rank'   => 4,
				'hex'    => 'f19051'
			],
			'acc_type_3' => [
				'type'   => 3,
				'name_s' => 'Character',
				'name_p' => 'Characters',
				'group'  => 9,
				'rank'   => 5,
				'hex'    => '73abd0'
			]
		];

		return $common;
	}

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
	* Determine character level
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
	* Determine character HP/MP
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

		// Set stats to return
		$stats = [
			'hp' => $total_hp,
			'mp' => $total_mp
		];

		return $stats;
	}

	/**
	* Calculate character currency
	*/
	public function calc_currency($total_copper) {
		$currency_ratio = 100;

		// Currency calculations
		$copper = $total_copper % $currency_ratio;
		$total_silver = $total_copper / $currency_ratio;
		$silver = $total_silver % $currency_ratio;
		$total_gold = $total_silver / $currency_ratio;
		$gold = $total_gold % $currency_ratio;
		$platinum = floor($total_gold / $currency_ratio);

		// Set currency to return
		$currency = [
			'copper'   => $copper,
			'silver'   => $silver,
			'gold' 	   => $gold,
			'platinum' => $platinum
		];

		return $currency;
	}
}

/**
* Calculate modifiers for HP/MP
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
