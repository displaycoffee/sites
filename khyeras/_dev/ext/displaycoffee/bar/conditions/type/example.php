<?php
/**
*
* Extending Auto Groups Example
*
* @copyright (c) 2015 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace foo\bar\conditions\type;

/**
* Auto Groups Example class
*/
class example extends \phpbb\autogroups\conditions\type\base
{
	/**
	* Get condition type
	*
	* @return string Condition type
	* @access public
	*/
	public function get_condition_type()
	{
		return 'vendor.extension.autogroups.type.example';
	}

	/**
	* Get condition field (this is the field to check)
	*
	* @return string Condition field name
	* @access public
	*/
	public function get_condition_field()
	{
		return 'example_data';
	}

	/**
	* Get condition type name
	*
	* @return string Condition type name
	* @access public
	*/
	public function get_condition_type_name()
	{
		return $this->user->lang('VENDOR_EXTENSION_AUTOGROUPS_TYPE_EXAMPLE');
	}

	/**
	* Get users to apply to this condition
	* Return an array of user data
	*    eg: 1 => array('user_id' => 1, 'example_data' => 'foo'),
	*        2 => array('user_id' => 2, 'example_data' => 'bar')
	*
	* @param array $options Array of optional data
	* @return array Array of users ids as keys and their condition data as values
	* @access public
	*/
	public function get_users_for_condition($options = array())
	{
		// The user data this condition needs to check
		$condition_data = array(
			$this->get_condition_field(),
			// additional fields can be added here
		);

		$user_data = array();

		// This query simply grabs all users and their example_data field
		$sql = 'SELECT user_id, ' . implode(', ', $condition_data) . '
			FROM ' . USERS_TABLE;
		$result = $this->db->sql_query_limit($sql, 1);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$user_data[$row['user_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		return $user_data;
	}

	/**
	* This method is optional, and is used in this example to
	* perform additional actions prior to running the check() method.
	*
	* @param array $user_row Array of user data to perform checks on
	* @param array $options  Array of optional data
	* @return null
	* @access public
	*/
	public function check($user_row, $options = array())
	{
		// Merge default options, overriden by any data provided when called
		$options = array_merge(array(
			'foo'   => '',
		), $options);

		if ($options['foo'] == 'bar')
		{
			// do some pre-check actions here
		}

		// Now perform the base check() method
		parent::check($user_row, $options);
	}
}
