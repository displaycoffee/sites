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

if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* Utilities/helper functions
*/

class utilities
{
	/**
	* Function to turn strings into hyphen separated handles
	*/
	public function handleize($value)
	{
		$pattern = array('/&amp;/', '/[^a-zA-Z ]/', '/ +/', '/-+/');
		$replacement = array('and', '', '-', '-');
		$handle = strtolower(preg_replace($pattern, $replacement, $value));
		return $handle;
	}
}
