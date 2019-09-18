<?php
/*
Plugin Name: Functionality Plugin to add media size options
Plugin URI: https://github.com/RhinoLance/wp-addMediaSizePicker
Description: Provides links to media files at different resolutions.
Author: RhinoLance
Version: 1.0
Author URI: https://github.com/RhinoLance/
License: MIT
*/
// Adds a "Sizes" column
function sizes_column( $cols ) {
	$cols["sizes"] = "Sizes";
	return $cols;
}

// Fill the Sizes column
function sizes_value( $column_name, $id ) {
if ( $column_name == "sizes" ) {
	// Including the direcory makes the list much longer 
	// but required if you use /year/month for uploads
	$up_load_dir =  wp_upload_dir();
	$dir = $up_load_dir['url'];

	// Get the info for each media item
	$meta = wp_get_attachment_metadata($id);

	// and loop + output
	foreach ( $meta['sizes'] as $name=>$info) {
		// could limit which sizes are output here with a simple if $name ==
		echo "<strong>" . $name . "</strong><br>";
		echo "<small>" . $dir . "/" . $info['file'] . " </small><br>";
	}
}
}

// Hook actions to admin_init
function hook_new_media_columns() {
add_filter( 'manage_media_columns', 'sizes_column' );
add_action( 'manage_media_custom_column', 'sizes_value', 10, 2 );
}
add_action( 'admin_init', 'hook_new_media_columns' );