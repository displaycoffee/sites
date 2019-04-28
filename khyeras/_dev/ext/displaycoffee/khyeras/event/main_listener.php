<?php
/**
 *
 * Khy'eras Custom Code. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Adria, https://github.com/displaycoffee
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
 			'core.page_header' 	  			=> 'theme_globals',
			'core.user_add_after' 		    => 'add_account_group',
			'core.memberlist_view_profile'  => 'memberlist_character_info',
			'core.viewtopic_post_row_after' => 'viewtopic_character_info'
 		);
 	}

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\profilefields\manager */
	protected $manager;

	/** @var \phpbb\profilefields\lang_helper */
	protected $lang_helper;

	/** @var string phpEx */
	protected $php_ext;

 	/**
 	 * Constructor
 	 *
 	 * @param \phpbb\template\template				$template			Template object
 	 * @param \phpbb\user              				$user       		User object
	 * @param \phpbb\db\driver\driver_interface		$db         		DBAL object
	 * @param \phpbb\profilefields\manager			$manager			Profile fields manager
	 * @param \phpbb\profilefields\lang_helper		$lang_helper		Profile fields language helper
	 * @param string                        		$php_ext			phpEx
 	*/
 	public function __construct(\phpbb\template\template $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, \phpbb\profilefields\manager $manager, \phpbb\profilefields\lang_helper $lang_helper, $php_ext)
 	{
 		$this->template    = $template;
 		$this->user		   = $user;
		$this->db		   = $db;
		$this->manager 	   = $manager;
		$this->lang_helper = $lang_helper;
		$this->php_ext	   = $php_ext;
 	}

 	/**
 	 * Set global data for theme use
 	*/
 	public function theme_globals($event)
 	{
		// Get the user id, group id, and lang_id
		$user_id = $this->user->data['user_id'];
		$group_id = $this->user->data['group_id'];
		$lang_id = $this->user->lang_id ? $this->user->lang_id : 1;

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

		// Get user profile field information
		$pf = $this->manager->grab_profile_fields_data($user_id)[$user_id];

		// Load profile field language
		$this->lang_helper->load_option_lang($lang_id);

		// account_type - field information
		$acc = $pf['account_type'];
		$account_type = $this->lang_helper->get($acc['data']['field_id'], $lang_id, $acc['value']);

		// Only do the below actions on character accounts
		if ($group_row['group_name'] == 'Characters') {

			// race_opts - field information
			$race = $pf['c_race_opts'];
			$race_values = explode(';', $race['value']);

			// race_opts - empty string to add comma separated options
			$race_options = false;

			// race_opts - loop through each race option
			for ($i = 0; $i < count($race_values); $i++)
			{
				$current = $this->lang_helper->get($race['data']['field_id'], $lang_id, $race_values[$i]);
				$race_options = $race_options . $current . ', ';
			}

			// class_opts - field information
			$class = $pf['c_class_opts'];
			$class_values = explode(';', $class['value']);

			// class_opts - empty string to add comma separated options
			$class_options = false;

			// class_opts - loop through each class option
			for ($j = 0; $j < count($class_values); $j++)
			{
				$current = $this->lang_helper->get($class['data']['field_id'], $lang_id, $class_values[$j]);
				$class_options = $class_options . $current . ', ';
			}
		}

		// --- END --- Profile Field Information

		// --- START --- Page Display Details

		// Set page_script_name and initial page_type
		$page_script_name = str_replace('.' . $this->php_ext, '', $this->user->page['page_name']);
		$page_type = $page_script_name;

		// Get page titles
		$page_title = strtolower($event['page_title']);
		$page_l_title = strtolower($this->template->retrieve_var('L_TITLE'));

		// If on a certain type of page, set the page_type or page_title
		if (strpos($page_type, 'thankslist/givens') !== false) {
			$page_type = 'search';
			$page_title = 'thanks';
		} elseif (strpos($page_type, 'app/') !== false) {
			$page_type = 'page';
		} elseif ($page_type == 'mcp' && $page_l_title && ($page_title != $page_l_title)) {
			$page_title = $page_l_title;
		}

		// Piece together page details for handle
		$page_patterns = array('/&amp;/', '/[^a-zA-Z ]/', '/ +/', '/-+/');
		$page_replaces = array('and', '', '-', '-');
		$page_handle = $page_type . '-' . preg_replace($page_patterns, $page_replaces, $page_title);

		// Truncate handle if its too long
		$class_limit = 50;
		if (strlen($page_handle) > $class_limit) {
			$page_handle = trim(substr($page_handle, 0, $class_limit), '-');
		}

		// --- END --- Page Display Details

		// --- START --- Variable Assignment

		// Assign global template variables for re-use
 		$this->template->assign_vars(array(
			'KHY_SCRIPT_NAME'		=> str_replace('app/', '', $page_script_name),
			'KHY_HANDLE_SHORT'		=> $page_type,
			'KHY_HANDLE'   			=> $page_handle,
			'KHY_LINKS'		   		=> link_mapping(),
			'KHY_USER_GROUP_ID'     => $group_id,
			'KHY_USER_GROUP_NAME'   => $group_row['group_name'],
			'KHY_USER_ACCOUNT_TYPE' => $account_type,
			'KHY_USER_RACE'   	    => rtrim($race_options, ', '),
			'KHY_USER_CLASS'   	    => rtrim($class_options, ', '),
			'KHY_USER_LEVEL'   	    => get_level($pf['c_experience']['value'])
 		));

		// Add list of completed achievements only for achievement page
		if ($page_script_name == 'app/gameplay-achievements') {
			$this->template->assign_vars(array(
				'KHY_USER_ACHIEVEMENTS' => $pf['c_achievements']['value']
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
		$pf = $event['post_row'];
		$character_details = array();

		// Only assign these variable if character account
		if ($pf['PROFILE_ACCOUNT_TYPE_VALUE'] == 'Character') {
			$race = $pf['PROFILE_C_RACE_OPTS_VALUE'];
			$class = $pf['PROFILE_C_CLASS_OPTS_VALUE'];
			$level = get_level($pf['PROFILE_C_EXPERIENCE_VALUE']);
			$currency = calc_currency($pf['PROFILE_C_COPPER_VALUE']);

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
		$desc = preg_replace('/(\[.*?\])/', '', strip_tags($pf['MESSAGE'], ''));
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
		if ($acc_type == 2) {
			// Writer > 2 / group_id > 8 / rank > 4
			$group_number = '8';
			$rank_number = '4';
		} else if ($acc_type == 3) {
			// Character > 3 / group_id > 9 / rank > 5
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

			// Run the query
			$user_group_result = $this->db->sql_query($user_group_sql);

			// Be sure to free the result after a SELECT query
			$this->db->sql_freeresult($user_group_result);

			// User data
			$user_array = array(
				'group_id'  => $group_number,
				'user_rank' => $rank_number
			);

			// Update users table with default group id
			$user_sql = 'UPDATE ' . USERS_TABLE . '
				SET ' . $this->db->sql_build_array('UPDATE', $user_array) . '
				WHERE user_id = ' . (int) $user_id;

			// Run the query
			$user_result = $this->db->sql_query($user_sql);

			// Be sure to free the result after a SELECT query
			$this->db->sql_freeresult($user_result);
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
  * Calculate modifiers for hp and mp
*/
function calc_life_modifier($options, $list) {
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

/**
  * Create link map
*/
function link_mapping() {
	// Parent about links
	$about = 'about';

	// Parent lore links
	$lore = 'lore';
	$lore_races = 'lore-races';
	$lore_religion = 'lore-religion';
	$lore_classes = 'lore-classes';

	// Parent setting links
	$setting = 'setting';
	$setting_tviyr = 'setting-tviyr';
	$setting_ninraih = 'setting-ninraih';
	$setting_irtuen_reaches = 'setting-irtuen-reaches';

	// Parent gameplay links
	$gameplay = 'gameplay';

	// Quick link arrays
	$race_links = ['General', 'Physical Features', 'Traits', 'History'];
	$class_links = ['General', 'Description'];
	$setting_links = ['General', 'Description', 'Places of Interest'];
	$setting_sublinks = ['General', 'History', 'Culture', 'Housing', 'Transportation', 'Leadership', 'Views on Magic'];

	$link_map = [
		$about => [
			'label'  => 'About'
		],
		'about-rules' => [
			'label'  => 'Rules',
			'parent' => $about,
			'quick'  => ['General', 'On Writing', 'Mature Content']
		],
		'about-managing-your-account' => [
			'label'  => 'Managing Your Account',
			'parent' => $about,
			'quick'  => ['General', 'Writer versus Character', 'Account Linking', 'Signatures and Avatars']
		],
		'about-getting-started' => [
			'label'  => 'Getting Started',
			'parent' => $about,
			'quick'  => ['The "Not So Fun" Stuff', 'Creating a Character', 'Starting the Journey']
		],
		$lore => [
			'label'  => 'Lore'
		],
		'lore-history' => [
			'label'  => 'History',
			'parent' => $lore,
		],
		'lore-short-history' => [
			'label'  => 'History',
			'parent' => $lore,
		],
		'lore-timeline' => [
			'label'  => 'Timeline',
			'parent' => $lore,
		],
		'lore-glossary' => [
			'label'  => 'Glossary',
			'parent' => $lore,
			'quick'  => range('A', 'Z')
		],
		$lore_races => [
			'label'  => 'Races',
			'parent' => $lore,
			'quick'  => ['Beast', 'Changeling', 'Elf', 'Mortal', 'Mystic', 'Terra', 'Undead']
		],
		'lore-races-dragon' => [
			'label'  => 'Dragon',
			'parent' => [$lore, $lore_races],
			'quick'  => $race_links
		],
		'lore-races-kerasoka' => [
			'label'  => 'Kerasoka',
			'parent' => [$lore, $lore_races],
			'quick'  => $race_links
		],
		'lore-races-human' => [
			'label'  => 'Human',
			'parent' => [$lore, $lore_races],
			'quick'  => $race_links
		],
		'lore-races-dwarf' => [
			'label'  => 'Dwarf',
			'parent' => [$lore, $lore_races],
			'quick'  => $race_links
		],
		'lore-races-shapeshifter' => [
			'label'  => 'Shapeshifter',
			'parent' => [$lore, $lore_races],
			'quick'  => $race_links
		],
		'lore-races-korcai' => [
			'label'  => 'Korcai',
			'parent' => [$lore, $lore_races],
			'quick'  => $race_links
		],
		'lore-races-ghost' => [
			'label'  => 'Ghost',
			'parent' => [$lore, $lore_races],
			'quick'  => $race_links
		],
		'lore-races-elemental' => [
			'label'  => 'Elemental',
			'parent' => [$lore, $lore_races],
			'quick'  => $race_links
		],
		'lore-races-lumeacia' => [
			'label'  => 'Lumeacia',
			'parent' => [$lore, $lore_races],
			'quick'  => $race_links
		],
		'lore-races-uedrahc' => [
			'label'  => 'Ue\'drahc',
			'parent' => [$lore, $lore_races],
			'quick'  => $race_links
		],
		'lore-races-fae' => [
			'label'  => 'Fae',
			'parent' => [$lore, $lore_races],
			'quick'  => $race_links
		],
		'lore-races-half-breed' => [
			'label'  => 'Half-Breed',
			'parent' => [$lore, $lore_races],
			'quick'  => ['Playing a Half-Breed', 'Dragon', 'Dwarf', 'Elemental', 'Fae', 'Ghost', 'Human', 'Kerasoka', 'Korcai', 'Lumeacia', 'Shapeshifter', 'Ue\'drahc']
		],
		$lore_religion => [
			'label'  => 'Religion',
			'parent' => $lore,
		],
		'lore-religion-archaicism' => [
			'label'  => 'Archaicism',
			'parent' => [$lore, $lore_religion],
			'quick'  => ['Dainyil', 'Ixaziel', 'Ny\'tha', 'Pheriss', 'Ristgir']
		],
		'lore-religion-idolism' => [
			'label'  => 'Idolism',
			'parent' => [$lore, $lore_religion],
			'quick'  => ['Ahm\'kela', 'Bhelest', 'Cecilia', 'Esyrax', 'Faryv', 'Faunir', 'Iodrah', 'Kaxitaki', 'Kelorha', 'Lahiel', 'Misanyt', 'Nilbein', 'Veditova']
		],
		'lore-religion-other' => [
			'label'  => 'Other Religions',
			'parent' => [$lore, $lore_religion],
			'quick'  => ['Agnosticism', 'Atheism']
		],
		$lore_classes => [
			'label'  => 'Classes',
			'parent' => $lore,
			'quick'  => ['Combat', 'Magic', 'Supportive', 'Other Classes']
		],
		'lore-classes-draconic' => [
			'label'  => 'Draconic',
			'parent' => [$lore, $lore_classes],
			'quick'  => $class_links
		],
		'lore-classes-druid' => [
			'label'  => 'Druid',
			'parent' => [$lore, $lore_classes],
			'quick'  => $class_links
		],
		'lore-classes-summoner' => [
			'label'  => 'Summoner',
			'parent' => [$lore, $lore_classes],
			'quick'  => $class_links
		],
		'lore-classes-sorcerer' => [
			'label'  => 'Sorcerer',
			'parent' => [$lore, $lore_classes],
			'quick'  => $class_links
		],
		'lore-classes-wizard' => [
			'label'  => 'Wizard',
			'parent' => [$lore, $lore_classes],
			'quick'  => $class_links
		],
		'lore-classes-cleric' => [
			'label'  => 'Cleric',
			'parent' => [$lore, $lore_classes],
			'quick'  => $class_links
		],
		'lore-classes-alchemist' => [
			'label'  => 'Alchemist',
			'parent' => [$lore, $lore_classes],
			'quick'  => $class_links
		],
		'lore-classes-paladin' => [
			'label'  => 'Paladin',
			'parent' => [$lore, $lore_classes],
			'quick'  => $class_links
		],
		'lore-classes-monk' => [
			'label'  => 'Monk',
			'parent' => [$lore, $lore_classes],
			'quick'  => $class_links
		],
		'lore-classes-rogue' => [
			'label'  => 'Rogue',
			'parent' => [$lore, $lore_classes],
			'quick'  => $class_links
		],
		'lore-classes-ranger' => [
			'label'  => 'Ranger',
			'parent' => [$lore, $lore_classes],
			'quick'  => $class_links
		],
		'lore-classes-fighter' => [
			'label'  => 'Fighter',
			'parent' => [$lore, $lore_classes],
			'quick'  => $class_links
		],
		'lore-classes-bard' => [
			'label'  => 'Bard',
			'parent' => [$lore, $lore_classes],
			'quick'  => $class_links
		],
		'lore-classes-barbarian' => [
			'label'  => 'Barbarian',
			'parent' => [$lore, $lore_classes],
			'quick'  => $class_links
		],
		'lore-magic' => [
			'label'  => 'Magic',
			'parent' => $lore,
			'quick'  => ['Invocation', 'Manipulation', 'Polarity', 'Primal', 'Other Magic']
		],
		$setting => [
			'label'  => 'Setting',
		],
		$setting_tviyr => [
			'label'  => 'Tviyr',
			'parent' => $setting,
			'quick'  => $setting_links
		],
		'setting-tviyr-verdant-row' => [
			'label'  => 'Verdant Row',
			'parent' => [$setting, $setting_tviyr],
			'quick'  => $setting_sublinks
		],
		'setting-tviyr-fellsgard' => [
			'label'  => 'Fellsgard',
			'parent' => [$setting, $setting_tviyr],
			'quick'  => $setting_sublinks
		],
		$setting_ninraih => [
			'label'  => 'Ninraih',
			'parent' => $setting,
			'quick'  => $setting_links
		],
		'setting-ninraih-ajteire' => [
			'label'  => 'Ajteire',
			'parent' => [$setting, $setting_ninraih],
			'quick'  => $setting_sublinks
		],
		$setting_irtuen_reaches => [
			'label'  => 'Irtuen Reaches',
			'parent' => $setting,
			'quick'  => $setting_links
		],
		'setting-irtuen-reaches-domrhask' => [
			'label'  => 'Domrhask',
			'parent' => [$setting, $setting_irtuen_reaches],
			'quick'  => $setting_sublinks
		],
		'setting-map' => [
			'label'  => 'Map',
			'parent' => $setting,
		],
		$gameplay => [
			'label'  => 'Gameplay',
		],
		'gameplay-leveling' => [
			'label'  => 'Leveling',
			'parent' => $gameplay,
		],
		'gameplay-achievements' => [
			'label'  => 'Achievements',
			'parent' => $gameplay,
			'quick'  => ['Guidelines', 'Fellsgard', 'Verdant Row', 'Ajteire', 'Domrhask', 'Other']
		],
		'gameplay-stats' => [
			'label'  => 'Stats',
			'parent' => $gameplay,
			'quick'  => ['Hit Points (or HP)', 'Magic Points (or MP)']
		],
		'gameplay-currency' => [
			'label'  => 'Currency',
			'parent' => $gameplay,
		]
	];

	return $link_map;
}
