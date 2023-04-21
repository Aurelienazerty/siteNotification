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
class photolike extends \phpbb\notification\type\base
{
	/**
	 * Get notification type name
	 *
	 * @return string
	 */
	public function get_type()
	{
		return 'aurelienazerty.sitenotification.notification.type.photolike';
	}
	
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
	 * Notification option data (for outputting to the user)
	 *
	 * @var bool|array False if the service should use it's default data
	 * 					Array of data (including keys 'id', 'lang', and 'group')
	 */
	public static $notification_option = array(
		'lang'	=> 'NOTIFICATION_TYPE_AURELIENAZERTY_SITENOTIFICATION_PHOTOLIKE',
		'group'	=> 'NOTIFICATION_TYPE_AURELIENAZERTY_SITENOTIFICATION',
	);

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
		return $this->check_user_notification_options(array($type_data['owner_commentaire_id']), $options);
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
	public function get_title()
	{
		$username = $this->user_loader->get_username($this->get_data('liker_id'), 'no_profile');
		$reaction = $this->get_data('reaction_type');
		
		$sql_array = array(
			'SELECT'	=> 'r.*',
			'FROM'		=> array('phpbb_reaction_types' => 'r'),
			'WHERE' => 'r.reaction_type_id = ' . (int) $reaction,
		);
		
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);
		$smiley = $this->db->sql_fetchfield('reaction_file_name');
		$alt = $this->db->sql_fetchfield('reaction_type_title');
		$this->db->sql_freeresult($result);
		
		//Rétrocompatibilité
		if (!$smiley) {
			$sql_array = array(
				'SELECT'	=> 'r.*',
				'FROM'		=> array('phpbb_reaction_types' => 'r'),
				'WHERE' => 'r.reaction_type_enable = 1',
			);
			
			$sql = $this->db->sql_build_query('SELECT', $sql_array);
			$result = $this->db-> sql_query_limit($sql, 1);
			$smiley = $this->db->sql_fetchfield('reaction_file_name');
			$alt = $this->db->sql_fetchfield('reaction_type_title');
		}
		
		$reaction = generate_board_url() . '/' . $this->config['reactions_image_path'] . '/' . $smiley;

        return $this->language->lang('AURELIENAZERTY_SITENOTIFICATION_PHOTOLIKE_TEXT', $reaction, $alt, $username);
	}

	/**
	 * Get the url to this item
	 *
	 * @return string URL
	 */
	public function get_url()
	{
		return "/images/view-" . $this->get_data('photo_id') . ".html#com" . $this->get_data('commentaire_id');
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
		return $this->user_loader->get_avatar($this->get_data('liker_id'), false, true);
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
		return (int) $type_data['commentaire_id'];
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
		return (int) $type_data['photo_id'];
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
		$this->set_data('photo_id', $type_data['photo_id']);
		$this->set_data('liker_id', $type_data['liker_id']);
		$this->set_data('commentaire_id', $type_data['commentaire_id']);
		$this->set_data('owner_commentaire_id', $type_data['owner_commentaire_id']);
		$this->set_data('reaction_type', $type_data['reaction_type']);
		
		$this->db->sql_query("SET NAMES 'utf8mb4'");

		parent::create_insert_array($type_data, $pre_create_data);
	}
}
