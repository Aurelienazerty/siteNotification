<?php
/**
 *
 * Notification du site. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, aurelienazerty, https://www.team-azerty.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace aurelienazerty\sitenotification;

/**
 * Notification du site Extension base
 *
 * It is recommended to remove this file from
 * an extension if it is not going to be used.
 */
class ext extends \phpbb\extension\base
{
	
	/**
	 * Check whether or not the extension can be enabled.
	 * The current phpBB version should meet or exceed
	 * the minimum version required by this extension:
	 *
	 * Requires phpBB 3.2.1 and PHP 5.4.
	 *
	 * @return bool
	 * @access public
	 */
	public function is_enableable()
	{
		$config = $this->container->get('config');

		return phpbb_version_compare($config['version'], '3.2.1', '>=') && version_compare(PHP_VERSION, '5.4', '>=');
	}
	
	/**
	 * Overwrite enable_step to enable extension notifications before any included migrations are installed.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 *
	 * @return mixed Returns false after last step, otherwise temporary state
	 * @access public
	 */
	public function enable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				// Enable notifications
				return $this->notification_handler('enable', $this->notification_types());
			default:
				// Run parent enable step method
				return parent::enable_step($old_state);
		}
	}

	/**
	 * Overwrite disable_step to disable extension notifications before the extension is disabled.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 *
	 * @return mixed Returns false after last step, otherwise temporary state
	 * @access public
	 */
	public function disable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				// Disable notifications
				return $this->notification_handler('disable', $this->notification_types());
			default:
				// Run parent disable step method
				return parent::disable_step($old_state);
		}
	}

	/**
	 * Overwrite purge_step to purge extension notifications before any included and installed migrations are reverted.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 *
	 * @return mixed Returns false after last step, otherwise temporary state
	 * @access public
	 */
	public function purge_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				// Purge notifications
				return $this->notification_handler('purge', $this->notification_types());
			default:
				// Run parent purge step method
				return parent::purge_step($old_state);
		}
	}

	/**
	 * Notification handler to call notification enable/disable/purge steps
	 *
	 * @author        VSEphpbb (Matt Friedman)
	 * @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
	 * @license       GNU General Public License, version 2 (GPL-2.0)
	 *
	 * @param string $step               The step (enable, disable, purge)
	 * @param array  $notification_types The notification type names
	 *
	 * @return string Return notifications as temporary state
	 * @access        protected
	 */
	protected function notification_handler($step, $notification_types)
	{
		/** @type \phpbb\notification\manager $phpbb_notifications */
		$phpbb_notifications = $this->container->get('notification_manager');

		foreach ($notification_types as $notification_type)
		{
			call_user_func(array($phpbb_notifications, $step . '_notifications'), $notification_type);
		}

		return 'notifications';
	}

	/**
	 * Returns the list of notification types
	 *
	 * @return array
	 * @access protected
	 */
	protected function notification_types()
	{
		return array(
			'aurelienazerty.sitenotification.notification.type.photolike',
		);
	}
}
