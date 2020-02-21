<?php

/**
*
* Khy'eras places Code. An extension for the phpBB Forum Software package.
*
* @copyright (c) 202, Adria, https://github.com/displaycoffee
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
	/** @var \phpbb\cache\driver\driver_interface */
	protected $db;

	/** @var string table_prefix*/
	protected $table_prefix;

	/**
	* Constructor
	*
	* @param \phpbb\db\driver\driver_interface $db            DBAL object
	* @param string                            $table_prefix  Table Prefix
	*/

	public function __construct(\phpbb\db\driver\driver_interface $db, $table_prefix) {
		$this->db		    = $db;
		$this->table_prefix = $table_prefix;
	}

	/**
	* Set global data for theme use
	*/
	public function get_khy_pages() {
		// Create pages table prefix
		$page_table = $this->table_prefix . 'pages';

		// Empty object to store page links
		$page_links = [];

		// Create the SQL statement for page data
		$page_sql = 'SELECT *
			FROM ' . $page_table . '
			ORDER BY page_order ASC, page_id ASC';

		// Run the query
		$page_result = $this->db->sql_query($page_sql);

		// Loops through the page rows and add to page_links
		while ($row = $this->db->sql_fetchrow($page_result))
		{
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

		return $page_links;
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
