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
	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\cache\driver\driver_interface */
	protected $db;

	/** @var \phpbb\group\helper */
	protected $group_helper;

	/** @var string phpEx */
	protected $php_ext;

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
	* @param \phpbb\user                       $user             User object
	* @param \phpbb\db\driver\driver_interface $db               DBAL object
	* @param \phpbb\group\helper               $group_helper     Group helper object
	* @param string                            $php_ext          phpEx
	* @param string                            $groups_table     Table Prefix
	* @param string                            $pages_table      Table Prefix
	* @param string                            $users_table      Table Prefix
	* @param string                            $user_group_table Table Prefix
	*/
	public function __construct(\phpbb\user $user, \phpbb\db\driver\driver_interface $db, \phpbb\group\helper $group_helper, $php_ext, $groups_table, $pages_table, $users_table, $user_group_table) {
		$this->user             = $user;
		$this->db               = $db;
		$this->group_helper     = $group_helper;
		$this->php_ext          = $php_ext;
		$this->groups_table     = $groups_table;
		$this->pages_table      = $pages_table;
		$this->users_table      = $users_table;
		$this->user_group_table = $user_group_table;
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
			'platinum' => $platinum,
			'gold' 	   => $gold,
			'silver'   => $silver,
			'copper'   => $copper
		];

		return $currency;
	}

	/**
	* Check if value exists (uses utilities_exists)
	*/
	public function exists($value, $fallback) {
		return utilities_exists($value, $fallback);
	}

	/**
	* Common extension variables
	*/
	public function common() {
		// Set up common object
		$common = [
			'user'        => [
				'id'   	=> $this->user->data['user_id'],
				'group' => $this->user->data['group_id'],
				'lang'  => utilities_exists($this->user->lang_id, 1),
				'time'  => $this->user->time_now
			],
			'script_name' => str_replace('.' . $this->php_ext, '', $this->user->page['page_name']),
			'tables'      => [
				'groups'      => $this->groups_table,
				'pages'       => $this->pages_table,
				'users'       => $this->users_table,
				'user_groups' => $this->user_group_table
			]
		];

		// Create the SQL statement for group data
		$group_sql = 'SELECT *
			FROM ' . $this->groups_table;

		// Run the query
		$group_result = $this->db->sql_query($group_sql);

		// Loops through the group rows and add to common
		while ($row = $this->db->sql_fetchrow($group_result)) {
			// Set group account type id
			$group_acc = false;
			if ($row['group_id'] == '8') {
				$group_acc = '2';
			} else if ($row['group_id'] == '9') {
				$group_acc = '3';
			}

			// Set singular and plural group names
			$group_name_p = $this->group_helper->get_name($row['group_name']);
			$group_name_s = utilities_exists($this->group_helper->get_rank($row)['title'], $group_name_p);

			// Add to group_data
			$group_data = [
				'id'     => $row['group_id'],
				'type'   => $group_acc,
				'name_s' => $group_name_s,
				'name_p' => $group_name_p,
				'rank'   => $row['group_rank'],
				'hex'    => $row['group_colour']
			];

			// Add group_data to common
			$common['groups']['group_' . $row['group_id']] = $group_data;
		}

		// $group_row should hold the selected data
		$group_row = $this->db->sql_fetchrow($group_result);

		// Be sure to free the result after a SELECT query
		$this->db->sql_freeresult($group_result);

		return $common;
	}

	/**
	* Get badge data array
	*/
	public function get_badges() {
		// Commonly used badge variables
		$badge_obj = [
			'default' => create_badge_image('pending'),
			'spooky'  => 'spooky-sundown'
		];

		$badges = array(
			'events'       => [
				'title' => 'Events',
				'desc'  => 'Badges awared through limited timed events.',
				'list'  => [
					$badge_obj['spooky'] => [
						'title'       => 'Spooky Sundown 2020',
						'url'         => 'viewtopic.php?f=26&amp;t=351',
						'image'       => create_badge_image($badge_obj['spooky']),
						'desc'        => 'Awared to those who participated in the Spooky Sundown 2020 Halloween Event.',
						'recipients'  => []
					]
				]
			],
			'achievements' => [
				'title' => 'Achievements',
				'desc'  => 'Badges awared through player achievements.'
			]
		);

		return $badges;
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
			'Dragon'       => ['HP' => 3, 'MP' => 2],
			'Dwarf'        => ['HP' => 3, 'MP' => 0],
			'Elemental'    => ['HP' => 1, 'MP' => 3],
			'Fae'          => ['HP' => 1, 'MP' => 3],
			'Ghost'        => ['HP' => 2, 'MP' => 2],
			'Human'        => ['HP' => 2, 'MP' => 2],
			'Kerasoka'     => ['HP' => 2, 'MP' => 0],
			'Korcai'       => ['HP' => 2, 'MP' => 1],
			'Lumeacia'     => ['HP' => 1, 'MP' => 3],
			'Shapeshifter' => ['HP' => 2, 'MP' => 2],
			'Ue\'drahc'    => ['HP' => 3, 'MP' => 2]
		];

		// Get race modifiers by calculating average
		$race_modifiers = calc_life_modifier($race, $race_list);

		// HP/MP values for classes
		$class_list = [
			'Alchemist'   => ['HP' => 2, 'MP' => 2],
			'Barbarian'   => ['HP' => 3, 'MP' => 0],
			'Bard'        => ['HP' => 2, 'MP' => 2],
			'Cleric'      => ['HP' => 2, 'MP' => 3],
			'Druid'       => ['HP' => 2, 'MP' => 3],
			'Fighter'     => ['HP' => 3, 'MP' => 1],
			'Magical'     => ['HP' => 1, 'MP' => 3],
			'Monk'        => ['HP' => 2, 'MP' => 1],
			'Paladin'     => ['HP' => 3, 'MP' => 2],
			'Physical'    => ['HP' => 3, 'MP' => 1],
			'Ranger'      => ['HP' => 2, 'MP' => 1],
			'Restoration' => ['HP' => 2, 'MP' => 3],
			'Rogue'       => ['HP' => 2, 'MP' => 1],
			'Sorcerer'    => ['HP' => 1, 'MP' => 3],
			'Summoner'    => ['HP' => 1, 'MP' => 3],
			'Wizard'      => ['HP' => 1, 'MP' => 3]
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
	* Check if string is in text
	*/
	public function in_string($string, $search) {
		return strpos($string, $search) !== false ? true : false;
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


/**
* Create badge image url
*/
function create_badge_image($value) {
	// Badge image variables
	$badge_image_path = 'images/badges/';
	$badge_image_size = '-x24';
	$badge_image_ext = '.png';

	return $badge_image_path . $value . $badge_image_size . $badge_image_ext;
}

/**
* Check if value exists
*/
function utilities_exists($value, $fallback) {
	return $value ? $value : $fallback;
}
