<?php namespace BoiseState\Hours;

class Settings {
	private $view;
	private $postType;
	private $apiKey;
	private $mapUrl;
	private $settingsSection;

	public function __construct( $view ) {
		$this->view = $view;
		$data = new Data();
		$this->postType = $data->postType();
		$this->apiKey = $data->apiKey();
		$this->mapUrl = $data->mapUrl();
		$this->settingsSection = $data->whatSection();
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'submenu' ) );
		// TODO: Update with PHP 5.4, have to manually pass in variables rather than use $this-> in <= PHP 5.3
		$postType = $this->postType;
		$apiKey = $this->apiKey;
		$mapUrl = $this->mapUrl;
		add_action( 'whitelist_options', function($whitelistOptions) use($postType, $apiKey, $mapUrl) {
			$whitelistOptions[$postType] = array(
				$apiKey,
				$mapUrl
			);
			return $whitelistOptions;
		});
		add_action( 'admin_init', array($this, 'adminInit') );
	}

	public function init()
	{
		$labels = array(
			'name' => _x( 'Hours', $this->postType ),
			'singular_name' => _x( 'Hours', $this->postType ),
			'add_new' => _x( 'Add New', $this->postType ),
			'add_new_item' => _x( 'Add New Hours', $this->postType ),
			'edit_item' => _x( 'Edit Hours', $this->postType ),
			'new_item' => _x( 'New Hours', $this->postType ),
			'view_item' => _x( 'View Hours', $this->postType ),
			'not_found_in_trash' => _x( 'No hours found in Trash', $this->postType ),
			'menu_name' => _x( 'Hours', $this->postType ),
		);

		$args = array(
			'labels' => $labels,
			'hierarchical' => false,
			'description' => 'Display location hours',
			'supports' => array( 'title', 'thumbnail', 'revisions', 'page-attributes' ),
			'taxonomies' => array(),
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 25,
			'menu_icon' => 'dashicons-clock',
			'show_in_nav_menus' => true,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'has_archive' => false,
			'can_export' => true,
			'capability_type' => 'post'
		);
		register_post_type( $this->postType, $args );
	}

	public function adminInit()
	{
		add_settings_section(
			$this->postType,
			'Hours Settings', // Title
			array( $this, 'settings' ),
			$this->settingsSection
		);

	}

	public function submenu()
	{
		add_submenu_page(
			"edit.php?post_type=" . $this->postType, // Parent slug
			"Shortcode", // Page title
			"Shortcode", // Menu title
			"activate_plugins", // Role required
			'hours_shortcode', // Menu slug
			array($this->view, 'shortcode'));

		add_submenu_page(
			"edit.php?post_type=" . $this->postType, // Parent slug
			"Settings", // Page title
			"Settings", // Menu title
			"activate_plugins", // Role required
			'hours_settings', // Menu slug
			array($this->view, 'admin'));
	}

	public function settings()
	{
		// API key setting
		register_setting(
			$this->postType,
			$this->apiKey
		);
		add_settings_field(
			$this->apiKey,
			'Set API Key:',
			array($this, 'createApiKeyField'),
			$this->settingsSection,
			$this->postType
		);

		// Set default map url
		register_setting(
			$this->postType,
			$this->mapUrl
		);
		add_settings_field(
			$this->mapUrl,
			'Set Default Map URL:',
			array($this, 'createMapUrlField'),
			$this->settingsSection,
			$this->postType
		);
	}

	public function createApiKeyField()
	{
		$clientId = get_option($this->apiKey);
		echo '<input type="text" name="' . $this->apiKey . '" value="' . $clientId . '" >';
	}

	public function createMapUrlField()
	{
		$clientId = get_option($this->mapUrl);
		echo '<input type="text" name="' . $this->mapUrl . '" value="' . $clientId . '" >';
	}

}