<link rel="stylesheet" href="<?= $css; ?>"/>
<!-- CSRF Protection -->
<?php wp_nonce_field( 'save_' . $metabox['id'], $metabox['id'] . '_nonce' ); ?>

<!-- Save registry of metaboxes to be saved, including current metabox ID -->
<input type="hidden" name="meta_box_ids[]" value="<?php echo $metabox['id']; ?>" />

<input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="calendarId" />
<input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="phone" />
<input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="fax" />
<input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="address" />
<input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="show_reservations" />
<input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="show_map" />
<input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="full_schedule" />


<table class="form-table">
	<tr>
		<th class="row">
			<label for="calendarId"><?php _e('Calendar ID', $shortcodeName); ?></label>
		</th>
		<td>
			<input name="calendarId" type="text" value="<?php echo get_post_meta($post->ID, 'calendarId', true);?>" class="regular-text" required>
		</td>
	</tr>
	<tr>
		<th class="row">
			<label for="phone"><?php _e('Phone', $shortcodeName); ?></label>
		</th>
		<td>
			<input name="phone" type="text" id="position" value="<?php echo get_post_meta($post->ID, 'phone', true); ?>" class="regular-text" required>
		</td>
	</tr>
	<tr>
		<th class="row">
			<label for="fax"><?php _e('Fax', $shortcodeName); ?></label>
		</th>
		<td>
			<input name="fax" type="text" id="position" value="<?php echo get_post_meta($post->ID, 'fax', true); ?>" class="regular-text">
		</td>
	</tr>
	<tr>
		<th class="row">
			<label for="address"><?php _e('Address', $shortcodeName); ?></label>
		</th>
		<td>
			<input name="address" type="text" id="position" value="<?php echo get_post_meta($post->ID, 'address', true); ?>" class="regular-text" required>
		</td>
	</tr>
	<tr>
		<th class="row">
			<label for="show_map"><?php _e('Show Map', $shortcodeName); ?></label>
		</th>
		<td>
			<input type="radio" name="show_map" <?= get_post_meta($post->ID, 'show_map', true) ? "checked='checked'" :
				'';
			?>/> Yes
			<br/>
			<input type="radio" name="show_map" <?= !get_post_meta($post->ID, 'show_map', true) ? "checked='checked'" :
				'';?>/> No
		</td>
	</tr>
	<tr>
		<th class="row">
			<label for="show_reservations"><?php _e('Show Reservations', $shortcodeName); ?></label>
		</th>
		<td>
			<input type="radio" name="show_reservations" <?= get_post_meta($post->ID, 'show_reservations', true) ? "checked='checked'" : '';?>/> Yes
			<br/>
			<input type="radio" name="show_reservations" <?= !get_post_meta($post->ID, 'show_reservations', true) ? "checked='checked'" : '';?>/> No
		</td>
	</tr>
	<tr>
		<th class="row">
			<label for="full_schedule"><?php _e('Full Schedule URL', $shortcodeName); ?></label>
		</th>
		<td>
			<input type="text" name="full_schedule" value="<?= get_post_meta($post->ID, 'full_schedule', true); ?>"
			       class="regular-text"/>
		</td>
	</tr>
</table>