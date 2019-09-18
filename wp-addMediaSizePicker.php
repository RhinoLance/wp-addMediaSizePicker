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
        $dir = preg_replace('/^https?:/', 'https:', $dir);

        // Get the info for each media item
        $meta = wp_get_attachment_metadata($id);

        // and loop + output
        foreach ( $meta['sizes'] as $name=>$info) {
			
			$url = $dir . "/" . $info['file'];
			
			// could limit which sizes are output here with a simple if $name ==
			echo "<div>";	
			echo "<strong>" . $name . "</strong>&nbsp;";
			echo "<a href='#' title='Copy to clipboard' onclick='copyToClipboard(\"" . $url . "\")'><span class='dashicons dashicons-admin-links'></span></a>";
			echo "<a href='" . $url . "' title='Open in new window' target='_new'><span class='dashicons dashicons-external'></span></a>";
			echo "</div>";
				
        }
}
}

// Hook actions to admin_init
function hook_new_media_columns() {
        add_filter( 'manage_media_columns', 'sizes_column' );
        add_action( 'manage_media_custom_column', 'sizes_value', 10, 2 );
}
add_action( 'admin_init', 'hook_new_media_columns' );

function enqueue_scripts() {

                $path = plugin_dir_url(__FILE__) . 'script.js';
                        error_log( 'addMediaSizePicker enqueue' , 0 );
                        error_log( 'addMediaSizePicker dir 1' . plugin_dir_url(__FILE__) , 0 );
                                error_log( 'addMediaSizePicker dir 2' . $path , 0 );

                                wp_enqueue_script('addMediaSizePicker_script', $path);
}
add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );
add_action( 'admin_init', 'enqueue_scripts' );