<?php
/**
*
* Extend Auto Groups
*
* @copyright (c) 2015 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace displaycoffee\extendautogroups\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Example showing how to call an Auto Group from an event
*/
class listener implements EventSubscriberInterface
{
	protected $autogroup_manager;

	// The autogroups_manager argument must be set last and = to null (because it is optional)
	public function __construct(\phpbb\autogroups\conditions\manager $autogroup_manager = null)
	{
		$this->autogroup_manager = $autogroup_manager;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.submit_post_end'		=> 'do_example',
		);
	}

	public function do_example($event)
	{
		// This conditional must be used to ensure calls only go out if Auto Groups is installed/enabled
		if ($this->autogroup_manager !== null)
		{

			// This calls our class (with no optional arguments)
			$this->autogroup_manager->check_condition('displaycoffee.extendautogroups.autogroups.type.account_type');

			// This calls our class and sends it some $options data
			$this->autogroup_manager->check_condition('displaycoffee.extendautogroups.autogroups.type.account_type', array(
				'foo'	=> 'bar',
				'users'	=> $user_id_ary,
			));

			// This calls our class and sends it some $options data
			// $this->autogroup_manager->check_condition('displaycoffee.extendautogroups.autogroups.type.account_type', array(
			// 	'foo'   => 'bar',
			// 	'users' => $event['user_id_ary'],
			// ));
		}
	}
}
