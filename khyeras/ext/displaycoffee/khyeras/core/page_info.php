<?php

/**
*
* Khy'eras places Code. An extension for the phpBB Forum Software package.
*
* @copyright (c) 2020, Adria, https://github.com/displaycoffee
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace displaycoffee\khyeras\core;

if (!defined('IN_PHPBB')) {
	exit;
}

/**
* Class for grabbing page information and setting breadcrumbs
*/

class page_info {
	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\cache\driver\driver_interface */
	protected $db;

	/** @var \displaycoffee\khyeras\utilities\utilities */
	protected $utilities;

	/** @var string table_prefix */
	protected $table_prefix;

	/** @var string phpEx */
	protected $php_ext;

	/**
	* Constructor
	*
	* @param \phpbb\template\template                   $template     Template object
	* @param \phpbb\user                                $user         User object
	* @param \phpbb\db\driver\driver_interface          $db           DBAL object
	* @param \displaycoffee\khyeras\utilities\utilities $utilities    Utilities helper functions
	* @param string                                     $table_prefix Table Prefix
	* @param string                                     $php_ext      phpEx
	*/

	public function __construct(\phpbb\template\template $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, \displaycoffee\khyeras\utilities\utilities $utilities, $table_prefix, $php_ext) {
		$this->template     = $template;
 		$this->user         = $user;
		$this->db           = $db;
		$this->utilities    = $utilities;
		$this->table_prefix = $table_prefix;
		$this->php_ext	    = $php_ext;
	}

	/**
	* Set page details such as handles, types, and links
	*/
	public function khy_set_page_details($event) {
		// --- START --- Page Display Details

		// Set page_script_name and initial page_type
		$page_script_name = str_replace('.' . $this->php_ext, '', $this->user->page['page_name']);
		$page_type = $page_script_name;

		// Get page titles
		$page_title = strtolower($event['page_title']);
		$page_l_title = strtolower($this->template->retrieve_var('L_TITLE'));

		// If on a certain type of page, reset the page_type or page_title
		if (strpos($page_type, 'thankslist/givens') !== false) {
			$page_type = 'search';
			$page_title = 'thanks';
		} elseif (strpos($page_type, 'app/') !== false) {
			$page_type = 'page';
		} elseif ($page_type == 'mcp' && $page_l_title && ($page_title != $page_l_title)) {
			$page_title = $page_l_title;
		}

		// Piece together page details for handle
		$page_handle = $page_type . '-' . $this->utilities->handleize($page_title);

		// --- END --- Page Display Details

		// --- START --- Page Link Building

		// Create pages table prefix
		$pages_table = $this->table_prefix . 'pages';

		// Empty object to store page links
		$page_links = [];

		// Create the SQL statement for page data
		$page_sql = 'SELECT *
			FROM ' . $pages_table . '
			ORDER BY page_order ASC, page_id ASC';

		// Run the query
		$page_result = $this->db->sql_query($page_sql);

		// Loops through the page rows and add to page_links
		while ($row = $this->db->sql_fetchrow($page_result)) {
			// Get breadcrumb array
			$page_crumbs = create_crumbs($row['page_description']);

			// Get last number in page order
			$page_order = intval(substr($row['page_order'], -1));

			$page_data = [
				'label'  => $row['page_title'],
				'url'    => $row['page_route'],
				'is_nav' => ($page_order <= 2) ? true : false,
				'level'  => $page_order,
				'crumbs' => $page_crumbs
			];

			$page_links[$row['page_route']] = $page_data;
		}

		// Be sure to free the result after a SELECT query
		$this->db->sql_freeresult($page_result);

		// --- END --- Page Link Building

		// --- START --- Variable Assignment

		// Assign global template variables for re-use
 		$this->template->assign_vars(array(
			'KHY_SCRIPT_NAME'       => str_replace('app/', '', $page_script_name),
			'KHY_HANDLE_SHORT'      => $page_type,
			'KHY_HANDLE'            => $page_handle,
			'KHY_LINKS'             => $page_links
 		));

		// Add list of completed achievements only for achievement page
		if ($page_script_name == 'app/gameplay-achievements') {
			$this->template->assign_vars(array(
				'KHY_USER_ACHIEVEMENTS' => $pf['c_achievements']['value']
	 		));
		}

		// --- END --- Variable Assignment
	}
}

function create_crumbs($desc) {
	if ($desc != 'false') {
		// Set initial crumbs array
		$crumbs = array();

		// Split the description for the first time
		$parent_array = explode(' > ', $desc);
		$parent_length = count($parent_array);

		// Loop through the parent crumbs
		for ($i = 0; $i < $parent_length; $i++) {
			$current =  $parent_array[$i];

			// If the current parent contains a | character, split again
			if (strpos($current, ' | ') !== false) {
				$child_crumbs = array();
				$child_array = explode(' | ', $current);
				$child_length = count($child_array);

				// Loop through child crumbs and add into a child array
				for ($j = 0; $j < $child_length; $j++) {
					array_push($child_crumbs, $child_array[$j]);
				}

				// Then push child array to crumbs
				array_push($crumbs, $child_crumbs);
			} else {
				// Push parent value to crumbs
				array_push($crumbs, $current);
			}
		}
	} else {
		$crumbs = false;
	}

	return $crumbs;
}
