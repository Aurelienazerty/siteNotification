<?php
/**
 *
 * Display Last Post extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace aurelienazerty\sitenotification\migrations;

class schema extends \phpbb\db\migration\migration 
{
	public function effectively_installed()
	{
		$query = '
			SELECT character_set_name 
			FROM information_schema.`COLUMNS` 
			WHERE table_name = "phpbb_notifications" 
			AND column_name = "notification_data"
		';
		$result = $this->sql_query($query);
		$row = $this->db->sql_fetchrow($result);
		return  $row['character_set_name']== 'utf8mb4';
	}
	
	public function update_schema()
	{
		$this->sql_query("ALTER TABLE `phpbb_notifications` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
		$this->sql_query("ALTER TABLE `phpbb_notifications` CHANGE `notification_data` `notification_data` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL");
	}
	
	public function revert_schema() 
	{
		$this->sql_query("ALTER TABLE `phpbb_notifications` CONVERT TO CHARACTER SET utf8 COLLATE utf8_bin");
		$this->sql_query("ALTER TABLE `phpbb_notifications` CHANGE `notification_data` `notification_data` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL");
	}
}
