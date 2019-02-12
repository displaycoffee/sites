<?php
/**
 *
 * Khy'eras Custom Code. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Adria, https://github.com/displaycoffee
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace displaycoffee\khyeras\event;

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
 			'core.page_header' 	  			=> 'user_info',
			'core.user_add_after' 		    => 'add_account_group',
			'core.memberlist_view_profile'  => 'memberlist_character_info',
			'core.viewtopic_post_row_after' => 'viewtopic_character_info'
 		);
 	}

 	/* @var \phpbb\controller\helper */
 	protected $helper;

 	/* @var \phpbb\template\template */
 	protected $template;

 	/* @var \phpbb\user */
 	protected $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

 	/**
 	 * Constructor
 	 *
 	 * @param \phpbb\controller\helper	$helper		Controller helper object
 	 * @param \phpbb\template\template	$template	Template object
 	 * @param \phpbb\user               $user       User object
 	 * @param string                    $php_ext    phpEx
 	*/
 	public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db)
 	{
 		$this->helper   = $helper;
 		$this->template = $template;
 		$this->user     = $user;
		$this->db       = $db;
 	}

 	/**
 	 * Get data from profile fields
 	*/
 	public function user_info()
 	{
		global $phpbb_container;

		// Get the user id and group id
		$user_id = $this->user->data['user_id'];
		$group_id = $this->user->data['group_id'];

		// --- START --- Group Information

		// Get the row of data with selected group_id
		$group_array = array(
			'group_id' => $group_id
		);

		// Create the SQL statement for group data
		$group_sql = 'SELECT group_name
			FROM ' . GROUPS_TABLE . '
			WHERE ' . $this->db->sql_build_array('SELECT', $group_array);

		// Run the query
		$group_result = $this->db->sql_query($group_sql);

		// $group_row should hold the selected data
		$group_row = $this->db->sql_fetchrow($group_result);

		// Be sure to free the result after a SELECT query
		$this->db->sql_freeresult($group_result);

		// --- END --- Group Information

		// --- START --- Profile Field Information

		// Get profile data from profilefields manager
		$pf = $phpbb_container->get('profilefields.manager')->grab_profile_fields_data($user_id);

		// Set profile field names
		$pf_user = $pf[$user_id];
		$acc_name = 'account_type';
		$race_opts = 'c_race_opts';
		$class_opts = 'c_class_opts';

		// Array to store language variables
		$pf_lang = array();

		// Associative array for grabbing multiple lang variables
		// We only really need to do this for dropdowns and multi checkboxes
		$pf_array = array(
			$acc_name => array(
				'field_id' 	=> $pf_user[$acc_name]['data']['field_id'],
				'option_id' => ($pf_user[$acc_name]['value']) - 1
			),
			$race_opts => array(
				'field_id' 	=> $pf_user[$race_opts]['data']['field_id'],
				'option_id' => explode(';', $pf_user[$race_opts]['value'])
			),
			$class_opts => array(
				'field_id' 	=> $pf_user[$class_opts]['data']['field_id'],
				'option_id' => explode(';', $pf_user[$class_opts]['value'])
			)
		);

		// Loop through $pf_array and add info for each lang variable to $pf_lang
		foreach ($pf_array as $key => $value)
		{
			// Check if the option_id value is an array
			if (gettype($value['option_id']) == 'array')
			{
				// Set empty string to add comma separated options
				$options = '';

				// Loop through each option
				for ($i = 0; $i < count($value['option_id']); $i++)
				{
					// Get the option value
					$option = ($value['option_id'][$i]) - 1;

					// Create the SQL statement for option data
					$pf_sql = 'SELECT lang_value
						FROM ' . PROFILE_FIELDS_LANG_TABLE . '
						WHERE field_id="' . $value['field_id'] . '" AND option_id="' .  $option . '"';

					// Run the query
					$pf_result = $this->db->sql_query($pf_sql);

					// Add selected data to options string
					$options = $options . $this->db->sql_fetchrow($pf_result)['lang_value'] . ', ';
				}

				// Finally add to $pf_lang array
				$pf_lang[$key] = rtrim($options, ', ');
			}
			else
			{
				// Create the SQL statement for lang data
				$pf_sql = 'SELECT lang_value
					FROM ' . PROFILE_FIELDS_LANG_TABLE . '
					WHERE ' . $this->db->sql_build_array('SELECT', $value);

				// Run the query
				$pf_result = $this->db->sql_query($pf_sql);

				// Add selected data to $pf_lang
				$pf_lang[$key] = $this->db->sql_fetchrow($pf_result)['lang_value'];
			}

			// Be sure to free the result after a SELECT query
			$this->db->sql_freeresult($pf_result);
		}

		// --- END --- Profile Field Information

		// --- START --- Variable Assignment

		// Assign global template variables for re-use
 		$this->template->assign_vars(array(
			'KHY_USER_GROUP_ID'     => $group_id,
			'KHY_USER_GROUP_NAME'   => $group_row['group_name'],
			'KHY_USER_ACCOUNT_TYPE' => $pf_lang[$acc_name],
			'KHY_USER_RACE'   	    => $pf_lang[$race_opts],
			'KHY_USER_CLASS'   	    => $pf_lang[$class_opts],
			'KHY_USER_LEVEL'   	    => get_level($pf_user['c_experience']['value'])
 		));

		// Add list of completed achievements only for achievement page
		if ($this->user->page && $this->user->page['page'] == 'app.php/achievements') {
			$this->template->assign_vars(array(
				'KHY_USER_ACHIEVEMENTS' => $pf_user['c_achievements']['value']
	 		));
		}

		// --- END --- Variable Assignment
 	}

	/**
	 * Determine member stats for memberlist_view page
	*/
	public function memberlist_character_info($event)
	{
		$pf = $event['profile_fields']['row'];

		// Only assign these variable if character account
		if ($pf['PROFILE_ACCOUNT_TYPE_VALUE'] == 'Character') {
			$race = $pf['PROFILE_C_RACE_OPTS_VALUE'];
			$class = $pf['PROFILE_C_CLASS_OPTS_VALUE'];
			$level = get_level($pf['PROFILE_C_EXPERIENCE_VALUE']);
			$currency = calc_currency($pf['PROFILE_C_COPPER_VALUE']);

			$this->template->assign_vars(array(
				'KHY_MEMBER_LEVEL'    => $level,
				'KHY_MEMBER_TOTAL_HP' => get_life_modifier($race, $class, $level)[0],
				'KHY_MEMBER_TOTAL_MP' => get_life_modifier($race, $class, $level)[1],
				'KHY_MEMBER_COPPER'   => $currency['Copper'],
				'KHY_MEMBER_SILVER'   => $currency['Silver'],
				'KHY_MEMBER_GOLD'     => $currency['Gold'],
				'KHY_MEMBER_PLATINUM' => $currency['Platinum']
	 		));
		}
	}

	/**
	 * Determine member stats for viewtopic_body page
	*/
	public function viewtopic_character_info($event)
	{
		$pr = $event['post_row'];
		$character_details = array();

		// Only assign these variable if character account
		if ($pr['PROFILE_ACCOUNT_TYPE_VALUE'] == 'Character') {
			$race = $pr['PROFILE_C_RACE_OPTS_VALUE'];
			$class = $pr['PROFILE_C_CLASS_OPTS_VALUE'];
			$level = get_level($pr['PROFILE_C_EXPERIENCE_VALUE']);
			$currency = calc_currency($pr['PROFILE_C_COPPER_VALUE']);

			$character_details = array(
				'PROFILE_LEVEL'	   => $level,
				'PROFILE_TOTAL_HP' => get_life_modifier($race, $class, $level)[0],
				'PROFILE_TOTAL_MP' => get_life_modifier($race, $class, $level)[1],
				'PROFILE_COPPER'   => $currency['Copper'],
				'PROFILE_SILVER'   => $currency['Silver'],
				'PROFILE_GOLD' 	   => $currency['Gold'],
				'PROFILE_PLATINUM' => $currency['Platinum']
			);
		}

		// Clean description by removing html and bbcode for word count
		$desc = preg_replace('/(\[.*?\])/', '', strip_tags($pr['MESSAGE'], ''));
		$desc_count = array(
			'WORD_COUNT' => str_word_count($desc)
		);

		// Assign viewtopic variables
		$this->template->assign_block_vars('postrow.khy', array_merge($character_details, $desc_count));
	}

	/**
	 * Add user to account type group after activation
	*/
	public function add_account_group($event)
	{
		// Get the user id and account type
		$user_id = $event['user_id'];
		$acc_type = $event['cp_data']['pf_account_type'];

		// Check the account type field
		// Writer > 2 / group_id > 8 / rank > 4
		// Character > 3 / group_id > 9 / rank > 5
		if ($acc_type == 2) {
			$group_number = '8';
			$rank_number = '4';
		} else if ($acc_type == 3) {
			$group_number = '9';
			$rank_number = '5';
		}

		if ($acc_type == 2 || $acc_type == 3) {
			// User group cp_data
			$user_group_arr = array(
				'group_id'     => $group_number,
				'user_id' 	   => $user_id,
				'group_leader' => 0,
				'user_pending' => 0,
			);

			// Insert a new row into the db for new group
			$user_group_sql = 'INSERT INTO ' . USER_GROUP_TABLE . ' ' . $this->db->sql_build_array('INSERT', $user_group_arr);
			$this->db->sql_query($user_group_sql);

			// User data
			$user_array = array(
				'group_id'  => $group_number,
				'user_rank' => $rank_number
			);

			// Update users table with default group id
			$user_sql = 'UPDATE ' . USERS_TABLE . '
				SET ' . $this->db->sql_build_array('UPDATE', $user_array) . '
				WHERE user_id = ' . (int) $user_id;
			$this->db->sql_query($user_sql);
		}
	}
}

/**
  * Determine what user level is
*/
function get_level($exp)
{
	$per_increment = 5;
	$multiplier_increment = 0.5;
	$base_increment = 25;
	$max_level = 60;
	$max_exp = 107970;

	if ($exp < $max_exp) {
		for ($level = 1; $level <= $max_level; $level++)
		{
			$multiplier = $base_increment + floor(($level - 1) / $per_increment) * $multiplier_increment;
			$current_experience = $multiplier * $level * ($level - 1);
			if ($current_experience > $exp)
			{
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
function get_life_modifier($race, $class, $level)
{
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
	$race_modifiers = cal_life_modifier($race, $race_list);

	// HP/MP values for classes
	$class_list = [
		'Barbarian'   => ['HP' => 3, 'MP' => 0],
		'Fighter'     => ['HP' => 3, 'MP' => 1],
		'Paladin'     => ['HP' => 3, 'MP' => 2],
		'Physical'    => ['HP' => 3, 'MP' => 1],
		'Ranger' 	  => ['HP' => 2, 'MP' => 1],
		'Monk' 		  => ['HP' => 2, 'MP' => 1],
		'Rogue' 	  => ['HP' => 2, 'MP' => 1],
		'Alchemist'   => ['HP' => 2, 'MP' => 2],
		'Bard' 		  => ['HP' => 2, 'MP' => 2],
		'Cleric'	  => ['HP' => 2, 'MP' => 3],
		'Druid' 	  => ['HP' => 2, 'MP' => 3],
		'Restoration' => ['HP' => 2, 'MP' => 3],
		'Sorcerer'    => ['HP' => 1, 'MP' => 3],
		'Summoner'    => ['HP' => 1, 'MP' => 3],
		'Wizard'      => ['HP' => 1, 'MP' => 3],
		'Magical'     => ['HP' => 1, 'MP' => 3],
		'Empty'  	  => ['HP' => 0, 'MP' => 0]
	];

	// Get class modifiers by calculating average
	$class_modifiers = cal_life_modifier($class, $class_list);

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
  * Calculate modifiers for hp and mp
*/
function cal_life_modifier($options, $list) {
	$hp_mod = 0;
	$mp_mod = 0;
	$selected_options = explode(', ', $options);

	foreach ($selected_options as $selected)
	{
		$hp_mod += $list[$selected]['HP'];
		$mp_mod += $list[$selected]['MP'];
	}

	return [round($hp_mod / count($selected_options)), round($mp_mod / count($selected_options))];
}

/**
  * Calculate currency total
*/
function calc_currency($total_copper) {
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
