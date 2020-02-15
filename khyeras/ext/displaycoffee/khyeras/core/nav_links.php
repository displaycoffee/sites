<?php

/**
 *
 * Khy'eras Custom Code. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Adria, https://github.com/displaycoffee
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace displaycoffee\khyeras\core;

if (!defined('IN_PHPBB'))
{
   exit;
}

// /**
//  * @ignore
//  */
// use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Khy'eras Custom Code Event listener.
 */
 class nav_links
 {
 	// static public function getSubscribedEvents()
 	// {
 	// 	return array(
 	// 		'core.page_header' 	  			=> 'theme_globals2',
	// 		// 'core.user_add_after' 		    => 'add_account_group',
	// 		// 'core.memberlist_view_profile'  => 'memberlist_character_info',
	// 		// 'core.viewtopic_post_row_after' => 'viewtopic_character_info'
 	// 	);
 	// }

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

	/** @var string phpEx */
	protected $table_prefix;

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
 	public function __construct(\phpbb\template\template $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, \phpbb\profilefields\manager $manager, \phpbb\profilefields\lang_helper $lang_helper, \phpbb\pages\operators\page $pages, $php_ext, $table_prefix)
 	{
 		$this->template    = $template;
 		$this->user		   = $user;
		$this->db		   = $db;
		$this->manager 	   = $manager;
		$this->lang_helper = $lang_helper;
		$this->pages       = $pages;
		$this->php_ext	   = $php_ext;
		$this->table_prefix = $table_prefix;
 	}

 	/**
 	 * Set global data for theme use
 	*/
 	public function theme_globals2()
 	{
		// Create pages table prefix
		$page_table = $this->table_prefix . 'pages';

		// Empty array to store page links
		$page_links = [];
		$first_links = array();
		$second_links = array();
		$third_links = array();

		// Create the SQL statement for page data
		$page_sql = 'SELECT *
			FROM ' . $page_table . '
			ORDER BY page_order ASC, page_id ASC';

		// Run the query
		$page_result = $this->db->sql_query($page_sql);

		// Loops through the page rows and add to page_links
		while ($row = $this->db->sql_fetchrow($page_result))
		{
			// Create page level based on page order
			$page_level = explode('.', ($row['page_order'] / 10))[1];

			$page_data = [
				'label'  => $row['page_title'],
				'url'    => $row['page_route'],
				'level'  => $page_level,
				'crumbs' => create_crumbs($row['page_title'], $row['page_route'], $page_level),
				//'quick'  => create_quick_link($row['page_title'], $row['page_route'])
			];

			$page_links[$row['page_route']] = $page_data;
		}

		// Be sure to free the result after a SELECT query
		$this->db->sql_freeresult($page_result);

		return $page_links;
 	}
}

function create_crumbs($title, $route, $level)
{
	// Delimiters for links and array
	$delimiter = '-';
	$delimiter2 = ':';

	// Split page route by hyphen
	$parents = explode($delimiter, $route);

	// Initialize first and second link strings
	$first = false;
	$second = false;

	// Set first and second link strings
	if ($parents[0]) {
		$first = $parents[0];
		if ($parents[1]) {
			$second = $first . $delimiter . $parents[1];
		}
	}

	// Create first and second link mappings
	$first_links = [
		'about'    => 'About',
		'lore'     => 'Lore',
		'setting'  => 'Setting',
		'gameplay' => 'Gameplay'
	];
	$second_links = [
		'lore-races'             => 'Races',
		'lore-religion'          => 'Religion',
		'lore-classes'           => 'Classes',
		'setting-tviyr'          => 'Tviyr',
		'setting-ninraih'        => 'Ninraih',
		'setting-irtuen-reaches' => 'Irtuen Reaches'
	];

	// Array to store crumbs
	$crumbs = array();

	if ($level == 2) {
		//array_push($crumbs, $first . $delimiter2 . $first_links[$first]);
	} else if ($level == 3) {
		// if ($second == 'setting-irtuen') {
		// 	$second = 'setting-irtuen-reaches';
		// }
		//
		// array_push(
		// 	$crumbs,
		// 	$first . $delimiter2 . $first_links[$first],
		// 	$second . $delimiter2 . $second_links[$second]
		// );
	} else {
		$crumbs = false;
	}

	return $crumbs;
}

function create_quick_link($title, $route)
{
	// Common quick link text
	$general = 'General';
	$desc = 'Description';

	// Specific page titles to check and map
	$region_values = ['Tviyr', 'Ninraih', 'Irtuen Reaches'];
	$city_values = ['Verdant Row', 'Fellsgard', 'Ajteire', 'Domrhask'];
	$exploration_values = ['The Serpent Kin', 'Cetnisadel Bay', 'Erair Manor', 'Lament of the Willow', 'Ninraih Station', 'Farinyir\'s Basin', 'Varorthe Barrens', 'Baslehr Ridge', 'Elasokir Reservoir', 'Ordinuad River', 'Preldova Narrows', 'Res\'lora Azure', 'Slyscera Mountains'];

	// Value to check for the switch statement
	if (strpos($route, 'lore-races-') !== false || strpos($route, 'lore-classes-') !== false) {
		$value = $route;
	} else {
		$value = $title;
	}

	// Assign $quick_links variable based on certain conditions
	switch ($value) {
		case 'Rules':
			$quick_links = [$general, 'On Writing', 'Mature Content'];
			break;
		case 'Managing Your Account':
			$quick_links = [$general, 'Writer versus Character', 'Account Linking', 'Signatures and Avatars'];
			break;
		case 'Getting Started':
			$quick_links = ['The "Not So Fun" Stuff', 'Creating a Character', 'Starting the Journey'];
			break;
		case 'Glossary':
			$quick_links = range('A', 'Z');
			break;
		case 'Races':
			$quick_links = ['Beast', 'Changeling', 'Elf', 'Mortal', 'Mystic', 'Terra', 'Undead'];
			break;
		case 'Half-breed':
			$quick_links = ['Playing a Half-breed', 'Dragon', 'Dwarf', 'Elemental', 'Fae', 'Ghost', 'Human', 'Kerasoka', 'Korcai', 'Lumeacia', 'Shapeshifter', 'Ue\'drahc'];
			break;
		case strpos($value, 'lore-races-') !== false:
			$quick_links = [$general, 'Physical Features', 'Traits', 'Forms', 'History', 'Relations', 'Life Stages', 'Playing As'];
			break;
		case 'Archaicism':
			$quick_links = ['Dainyil', 'Ixaziel', 'Ny\'tha', 'Pheriss', 'Ristgir'];
			break;
		case 'Idolism':
			$quick_links = ['Ahm\'kela', 'Bhelest', 'Cecilia', 'Esyrax', 'Faryv', 'Faunir', 'Iodrah', 'Kaxitaki', 'Kelorha', 'Lahiel', 'Misanyt', 'Nilbein', 'Veditova'];
			break;
		case 'Other Religions':
			$quick_links = ['Agnosticism', 'Atheism'];
			break;
		case 'Classes':
			$quick_links = ['Combat', 'Magic', 'Supportive', 'Other Classes'];
			break;
		case strpos($value, 'lore-classes-') !== false || in_array($value, $exploration_values):
			$quick_links = [$general, $desc];
			break;
		case 'Magic	':
			$quick_links = ['Invocation', 'Manipulation', 'Polarity', 'Primal', 'Other Magic'];
			break;
		case in_array($value, $region_values):
			$quick_links = [$general, $desc, 'Places of Interest'];
			break;
		case in_array($value, $city_values):
			$quick_links = [$general, 'History', 'Layout', 'Travel', 'Leadership', 'Culture', 'Views on Magic'];
			break;
		case 'Achievements':
			$quick_links = ['Guidelines', 'Fellsgard', 'Verdant Row', 'Ajteire', 'Domrhask', 'Other'];
			break;
		case 'Stats':
			$quick_links = ['Hit Points (or HP)', 'Magic Points (or MP)'];
			break;
		default:
			$quick_links = false;
	}

	return $quick_links;
}
