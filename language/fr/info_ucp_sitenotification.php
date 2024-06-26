<?php
/**
 *
 * Notification du site. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, aurelienazerty, https://www.team-azerty.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'NOTIFICATION_TYPE_AURELIENAZERTY_SITENOTIFICATION' => 'Notifications via le site',
	
	'NOTIFICATION_TYPE_AURELIENAZERTY_SITENOTIFICATION_PHOTOLIKE'	=> "Quelqu'un a réagi à l'un de vos commentaires",
	'NOTIFICATION_TYPE_AURELIENAZERTY_SITENOTIFICATION_OLDPRONO' => "En cas de pronostique ancien",
	'NOTIFICATION_TYPE_AURELIENAZERTY_SITENOTIFICATION_NOPRONO' => "En cas d'absence de prono",
));
