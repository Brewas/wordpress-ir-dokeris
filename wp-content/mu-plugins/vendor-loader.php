<?php
/**
 * Plugin Name: Vendor Plugin Loader
 * Description: Automatically loads Composer-installed plugins from wp-content/vendor-plugins.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$vendor_dir = WP_CONTENT_DIR . '/vendor-plugins';

if ( ! is_dir( $vendor_dir ) ) {
    return;
}

/**
 * Load all plugins inside vendor-plugins directory.
 */
foreach ( glob( $vendor_dir . '/*', GLOB_ONLYDIR ) as $plugin_dir ) {

    // Look for PHP files in each plugin directory
    foreach ( glob( $plugin_dir . '/*.php' ) as $file ) {

        // Check if file contains a valid WordPress plugin header
        $plugin_data = get_file_data(
            $file,
            [
                'Name' => 'Plugin Name',
            ]
        );

        if ( ! empty( $plugin_data['Name'] ) ) {
            require_once $file;
            break; // Stop after loading main plugin file
        }
    }
}
