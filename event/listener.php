<?php
/**
 *
 * photos extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace aurelienazerty\sitenotification\event;

/**
 * Event listener
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface {
	
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\user $user */
	protected $user;
	
	/** @var \phpbb\language\language $language */
	protected $language;
	
	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface    $db DBAL object
	 * @param \phpbb\user	$user	user object
	 * @param \phpbb\language\language	$language	language object
	 * @return \aurelienazerty\sitenotification\event\listener
	 * @access public
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\language\language $language) {
		$this->user = $user;
		$this->db = $db;
	}

	static public function getSubscribedEvents() {
		return array(
			'core.user_setup'                    => 'load_language_on_setup',
		);
	}
	
	/**
	 * Load language files during user setup
	 *
	 * @param \phpbb\event\data $event The event object
	 *
	 * @return void
	 * @access public
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'aurelienazerty/sitenotification',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	
}
