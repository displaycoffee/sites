<?php
/**
*
* Extending Auto Groups Example
*
* @copyright (c) 2015 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace foo\bar;

/**
* This ext class is optional and can be omitted if left empty.
* However you can add special (un)installation commands in the
* methods enable_step(), disable_step() and purge_step(). As it is,
* these methods are defined in \phpbb\extension\base, which this
* class extends, but you can overwrite them to give special
* instructions for those cases.
*/
class ext extends \phpbb\extension\base
{
	/**
	* This method is only needed if this extension requires Auto Groups
	*/
	public function is_enableable()
	{
		$ext_manager = $this->container->get('ext.manager');

		return $ext_manager->is_enabled('phpbb/autogroups');
	}

	/**
	* This method is required
	*/
	public function purge_step($old_state)
	{
		switch ($old_state)
		{
			case '':
				try
				{
					// Try to remove this extension from auto groups db tables
					$autogroups = $this->container->get('phpbb.autogroups.manager');
					$autogroups->purge_autogroups_type('vendor.extension.autogroups.type.example');
				}
				catch (\InvalidArgumentException $e)
				{
					// Continue
				}

				return 'autogroups';
			break;

			default:
				return parent::purge_step($old_state);
			break;
		}
	}
}
