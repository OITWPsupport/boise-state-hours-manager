<?php namespace BoiseState\Hours;


class View {
	private $data;

	public function __construct() {
		$this->data = new Data();
	}

	public function shortcode() {
		echo $this->data->getPage( 'plugin/shortcode.php', array(
			'data' => htmlentities( json_encode( array(
				'hours'         => $this->data->getLocations(),
				'shortcodeName' => $this->data->postType()
			) ) ),
		), 'shortcode');
	}

	public function admin() {
		echo $this->data->getPage( 'plugin/admin.php', array(
			'postType'        => $this->data->postType(),
			'settingsSection' => $this->data->whatSection()
		) );
	}

	public function display( $params ) {
		$locationIds      = $this->data->safeParams( $params, 'locations' );
		$viewType = $locationIds == 'all' ? 'all' : $this->data->safeParams( $params, 'view' );

		return $this->data->getPage( 'plugin/display.php', array(
			'type' => $viewType,
			'data' => htmlentities( json_encode( array(
				'title'     => $this->data->safeParams( $params, 'title' ),
				'locations' => $this->data->getLocations( $locationIds ),
				'settings'  => $this->data->getSettings()
			) ) )
		), 'hours' );
	}

	public function printMetaBox( $post, $metabox ) {
		echo $this->data->getPage( 'plugin/form.php', array(
			'css'           => $this->data->getFilePath('styles', 'css'),
			'post'          => $post,
			'metabox'       => $metabox,
			'shortcodeName' => $this->data->postType()
		) );
	}

}