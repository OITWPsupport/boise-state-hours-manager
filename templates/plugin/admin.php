<div class="wrap">

	<h2>Bsu Hours Manager Admin</h2>
	<?php settings_errors(); ?>
	<form method="POST" action="options.php">
		<?php settings_fields( $postType ); ?>
		<?php do_settings_sections( $settingsSection); ?>
		<?php submit_button(); ?>
	</form>

</div>