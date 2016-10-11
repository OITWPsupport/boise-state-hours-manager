<?php namespace BoiseState\Hours;

use WP_Query;

class Data {
	protected $postType;
	protected $pluginName;
	protected $pluginDirectory;
	protected $templateDirectory;
	protected $settings;

	public function __construct() {
		$this->postType        = 'saw_hours';
		$this->pluginName      = 'saw_hours';
		$this->settings        = array(
			'fields'  => array(
				'apiKey' => 'saw_hours_api_key',
				'mapUrl' => 'saw_hours_default_map_url'
			),
			'section' => 'saw_hours_settings_section'
		);
		$this->pluginDirectory = __DIR__ . '/../';
		// Get the plugin directory name
		preg_match( "%(?<=wp-content/plugins/).*?(?=/)%", $this->pluginDirectory, $path );
		$this->publicPath        = '/wp-content/plugins/' . array_shift( $path );
		$this->templateDirectory = $this->pluginDirectory . '/templates/';
	}
	public function pluginName() {
		return $this->pluginName;
	}
	public function postType() {
		return $this->postType;
	}
	public function whatSection() {
		return $this->settings['section'];
	}
	public function mapUrl() {
		return $this->settings['fields']['mapUrl'];
	}
	public function apiKey() {
		return $this->settings['fields']['apiKey'];
	}
	public function getLocations( $ids = null ) {
		$args = array(
			'post_status' => 'publish',
			'post_type'   => $this->postType,
			'orderby'     => 'menu_order'
		);
		if ( $ids && $ids !== 'all' ) {
			$args['post__in'] = explode( ',', $ids );
		}
		$hours = array();
		$loop  = new WP_Query( $args );
		while ( $loop->have_posts() ) {
			$loop->the_post();
			$post    = $loop->post;
			$imgPath = '';
			if ( has_post_thumbnail( $post->ID ) ) {
				$imgArray = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
				$imgPath  = array_shift( $imgArray );
			}

			$post->details = array(
				'address'          => get_post_meta( $post->ID, 'address', true ),
				'calendarId'       => get_post_meta( $post->ID, 'calendarId', true ),
				'fullSchedule'     => get_post_meta( $post->ID, 'full_schedule', true ),
				'imgPath'          => $imgPath,
				'phone'            => get_post_meta( $post->ID, 'phone', true ),
				'fax'              => get_post_meta( $post->ID, 'fax', true ),
				'showReservations' => get_post_meta( $post->ID, 'show_reservations', true ),
				'showMap'          => get_post_meta( $post->ID, 'show_map', true )
			);
			$hours[]       = $post;
		}

		return $hours;
	}
	public function getSettings() {
		$settings                = new \StdClass;
		$settings->apiKey        = get_option( $this->settings['fields']['apiKey'] );
		$settings->defaultMapUrl = get_option( $this->settings['fields']['mapUrl'] );

		return $settings;
	}
	public function safeParams( $params, $id ) {
		return isset( $params[ $id ] ) ? $params[ $id ] : null;
	}
	public function getPage( $filename, $data = array(), $scriptName = null) {
		$data['id'] = $this->createRandomId();
		$data['app'] = $this->getApp($data['id'], $scriptName);

		return $this->getFileContents($filename, $data);
	}
	public function getApp($id, $appName) {
		$display = $appName ? $this->getFilePath($appName, 'js') : null;
		return $this->getFileContents( 'plugin/includes.php', array(
			'id'           => $id,
			'css'          => $this->getFilePath( 'styles', 'css' ),
			'dependencies' => $this->getFilePath( 'dependencies', 'js' ),
			'display'      => $display,
			'appName'      => $appName . 'App'
		) );
	}
	private function getFileContents($filename, $data){
		ob_start();
		extract( $data );
		include( $this->templateDirectory . $filename );
		$file = ob_get_contents();
		ob_end_clean();

		return $file;
	}
	private function createRandomId() {
		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$id   = '';
		for ( $i = 0; $i < 19; $i ++ ) {
			$id .= $pool[ rand( 0, strlen( $pool ) - 1 ) ];
		}

		return $id;
	}
	public function getFilePath( $name, $type ) {
		$manifest = json_decode( file_get_contents( __DIR__ . '/../app/revs/' . $name . '-rev.json' ) );

		return $this->publicPath . '/app/' . $manifest->{$name . '.' . $type};
	}
}