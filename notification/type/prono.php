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
abstract class prono extends \phpbb\notification\type\base
{
	/**
	 * Get notification type name
	 *
	 * @return string
	 */
	abstract public function get_type();
	
	protected $helper;
	protected $user_loader;
	protected $config;

	public function set_controller_helper(\phpbb\controller\helper $helper)
	{
		$this->helper = $helper;
	}
	
	public function set_user_loader(\phpbb\user_loader $user_loader)
	{
		$this->user_loader = $user_loader;
	}
	
	public function set_config(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	/**
	 * Is this type available to the current user (defines whether or not it will be shown in the UCP Edit notification options)
	 *
	 * @return bool True/False whether or not this is available to the user
	 */
	public function is_available()
	{
		return true;
	}


	/**
	 * Find the users who want to receive notifications
	 *
	 * @param array $type_data The type specific data
	 * @param array $options Options for finding users for notification
	 * 		ignore_users => array of users and user types that should not receive notifications from this type because they've already been notified
	 * 						e.g.: array(2 => array(''), 3 => array('', 'email'), ...)
	 *
	 * @return array
	 */
	public function find_users_for_notification($type_data, $options = array())
	{
		// Return an array of users to be notified, storing the user_ids as the array keys
		return $this->check_user_notification_options(array($type_data['user_id']), $options);
	}

	/**
	 * Users needed to query before this notification can be displayed
	 *
	 * @return array Array of user_ids
	 */
	public function users_to_query()
	{
		return array($this->get_data('liker_id'));
	}

	/**
	 * Get the HTML formatted title of this notification
	 *
	 * @return string
	 */
	abstract public function get_title();

	/**
	 * Get the url to this item
	 *
	 * @return string URL
	 */
	public function get_url()
	{
		return "/html/prono-foot/pronostiquez-competition-" . $this->get_data('competition_id') . "-grille-" . $this->get_data('grille_id') . '.html';
	}

	/**
	 * Get email template
	 *
	 * @return string|bool
	 */
	public function get_email_template()
	{
		return false;
	}

	/**
	 * Get email template variables
	 *
	 * @return array
	 */
	public function get_email_template_variables()
	{
		return array();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function get_avatar()
	{
		return $this->user_loader->get_avatar($this->user_loader->load_user_by_username('Pronofoot'), false, true);
	}
	
	/**
	 * Get the id of the notification
	 *
	 * @param array $type_data The type specific data
	 *
	 * @return int Id of the notification
	 */
	public static function get_item_id($type_data)
	{
		return (int) $type_data['grille_id'];
	}

	/**
	 * Get the id of the parent
	 *
	 * @param array $type_data The type specific data
	 *
	 * @return int Id of the parent
	 */
	public static function get_item_parent_id($type_data)
	{
		return (int) $type_data['competition_id'];
	}

	/**
	 * Function for preparing the data for insertion in an SQL query
	 * (The service handles insertion)
	 *
	 * @param array $type_data The type specific data
	 * @param array $pre_create_data Data from pre_create_insert_array()
	 */
	public function create_insert_array($type_data, $pre_create_data = array())
	{
		$this->set_data('competition_id', $type_data['competition_id']);
		$this->set_data('grille_id', $type_data['grille_id']);
		$this->set_data('grille_nom', $type_data['grille_nom']);

		parent::create_insert_array($type_data, $pre_create_data);
	}
}
