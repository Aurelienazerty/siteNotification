<?php
/**
 *
 * Notification du site. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, aurelienazerty, https://www.team-azerty.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace aurelienazerty\sitenotification\notification\type;

/**
 * Notification du site Notification class.
 */
class noprono extends prono
{
	/**
	 * Get notification type name
	 *
	 * @return string
	 */
	public function get_type()
	{
		return 'aurelienazerty.sitenotification.notification.type.noprono';
	}

	/**
	 * Notification option data (for outputting to the user)
	 *
	 * @var bool|array False if the service should use it's default data
	 * 					Array of data (including keys 'id', 'lang', and 'group')
	 */
	public static $notification_option = array(
		'lang'	=> 'NOTIFICATION_TYPE_AURELIENAZERTY_SITENOTIFICATION_NOPRONO',
		'group'	=> 'NOTIFICATION_TYPE_AURELIENAZERTY_SITENOTIFICATION',
	);
	
	/**
	 * Get the HTML formatted title of this notification
	 *
	 * @return string
	 */
	public function get_title()
	{
		$title = sprintf($this->language->lang('AURELIENAZERTY_SITENOTIFICATION_NOPRONO_TEXT', $this->get_data('grille_nom')));
		return $title;
	}

}
