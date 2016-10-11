<?php namespace BoiseState\Hours;

class Plugin {
	private $data;
	private $view;

	public function __construct()
	{
		$this->view = new View();
		$this->data = new Data();

		// Create our fields
		add_action( 'add_meta_boxes', array( $this, 'createMetaBox' ) );
		// Save our fields on post save
		add_filter( 'save_post', array( $this, 'saveMetaBox' ), 10, 2 );
		// Add shortcode
		add_shortcode($this->data->pluginName(), array($this->view, 'display'));
		// Show dashboard menu for admins
		if(is_admin()) {
			new Settings($this->view);
		}
	}

	public function createMetaBox() {
		add_meta_box(
			'bsu_hours_info_meta_box',
			__( 'Hours Details', $this->data->postType() ),
			array( $this->view, 'printMetaBox' ),
			$this->data->postType(),
			'normal'
		);
	}

	public function saveMetaBox( $post_id, $post ) {
		// Don't auto-save, check if values are empty
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return null;
		if( empty( $_POST['meta_box_ids'] ) ) return null;

		foreach( $_POST['meta_box_ids'] as $metabox_id ){
			// Verify and check if anything needs saved
			if( ! wp_verify_nonce( $_POST[ $metabox_id . '_nonce' ], 'save_' . $metabox_id ) ) continue;
			if( count( $_POST[ $metabox_id . '_fields' ] ) == 0 ) continue;

			// Save each value
			foreach( $_POST[ $metabox_id . '_fields' ] as $field_id ){
				update_post_meta($post_id, $field_id, $_POST[ $field_id ]);
			}
		}

		return $post;
	}

}

