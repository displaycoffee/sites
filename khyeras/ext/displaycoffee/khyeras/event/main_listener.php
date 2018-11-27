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
 			'core.page_header' 	  => 'pf_variables',
			'core.user_add_after' => 'add_account_group',
			'core.memberlist_view_profile' => 'add_stat_information',
			'core.viewtopic_post_row_after' => 'add_stat_information2'
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
 	public function pf_variables()
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
			'KHY_GROUP_ID'     => $group_id,
			'KHY_GROUP_NAME'   => $group_row['group_name'],
			'KHY_ACCOUNT_TYPE' => $pf_lang[$acc_name],
			'KHY_RACE'   	   => $pf_lang[$race_opts],
			'KHY_CLASS'   	   => $pf_lang[$class_opts]
 		));

		// --- END --- Variable Assignment
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
		// Writer > 2 / group_id > 8 / rank > 4 | Character > 3 / group_id > 9 / rank > 5
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
				'group_id'     => $group_number,
				'user_rank'    => $rank_number
			);

			// Update users table with default group id
			$user_sql = 'UPDATE ' . USERS_TABLE . '
				SET ' . $this->db->sql_build_array('UPDATE', $user_array) . '
				WHERE user_id = ' . (int) $user_id;
			$this->db->sql_query($user_sql);
		}
	}

	/**
	 * Add user to account type group after activation
	*/
	public function add_stat_information($event)
	{
		var_dump($event);
	}

	/**
	 * Add user to account type group after activation
	*/
	public function add_stat_information2($event)
	{
		$level = get_level($event['post_row']['PROFILE_C_EXPERIENCE_VALUE']);

		$this->template->assign_block_vars('postrow.test', array(
			'LEVEL' => $level,
			'EXP'   => $event['post_row']['PROFILE_C_EXPERIENCE_VALUE']
		));
	}
 }

/**
  * Determine what user level is
*/
function get_level($exp)
{
	//$expMultiplier = 25;
	// $level = calc_level(25, $exp);
	//
	// // Add .5 to the multiplier every 5th level (6, 11, 16...)
	// //if ($level > 5) {
	// 	$expMultiplier = 25 + floor(($level - 1) / 5) * 0.5;
	// 	$level = calc_level($expMultiplier, $exp);
	// //}



	$level = calc_level($exp);


	return $level;
}

/**
 * Equation for level
*/
function calc_level($xp)
{
	$levelsPerIncrement = 5;
	$multiplierIncrement = 0.5;
	$baseMultiplier = 25;
	$maxLevel = 60;

	for ($level = 1; $level <= $maxLevel; $level++)
	{
		$expMultiplier = $baseMultiplier + floor(($level - 1) / $levelsPerIncrement) * $multiplierIncrement;
		$currXP = $expMultiplier * $level * ($level - 1);
		if ($currXP > $xp)
		{
			return $level - 1;
		}
	}
}
