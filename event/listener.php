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
	
	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface    $db DBAL object
	 * @param \phpbb\user	$user	user object
	 * @return \aurelienazerty\sitenotification\event\listener
	 * @access public
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user) {
		$this->user = $user;
		$this->db = $db;
	}

	static public function getSubscribedEvents() {
		return array();
	}
	
}
