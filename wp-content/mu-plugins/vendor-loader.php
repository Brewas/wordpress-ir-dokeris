<?php
/**
 * Plugin Name: Vendor Plugins Loader
 * Description: Loads plugins installed via Composer from vendor-plugins directory
 * Version: 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load plugins from vendor-plugins directory
 */
function load_vendor_plugins() {
    $vendor_dir = WP_CONTENT_DIR . '/vendor-plugins';
    
    // Check if directory exists
    if (!is_dir($vendor_dir)) {
        return;
    }
    
    // Get all plugin folders
    $plugins = scandir($vendor_dir);
    $loaded = array();
    
    foreach ($plugins as $plugin) {
        // Skip . and ..
        if ($plugin === '.' || $plugin === '..') {
            continue;
        }
        
        $plugin_path = $vendor_dir . '/' . $plugin;
        
        // Only process directories
        if (!is_dir($plugin_path)) {
            continue;
        }
        
        // Look for the main plugin file
        $main_file = $plugin_path . '/' . $plugin . '.php';
        
        // If that doesn't exist, try to find any PHP file with plugin header
        if (!file_exists($main_file)) {
            $php_files = glob($plugin_path . '/*.php');
            foreach ($php_files as $file) {
                $content = file_get_contents($file);
                if (strpos($content, 'Plugin Name:') !== false) {
                    $main_file = $file;
                    break;
                }
            }
        }
        
        // Load the plugin if we found the main file
        if (file_exists($main_file)) {
            require_once $main_file;
            $loaded[] = $plugin;
        }
    }
    
    // Store loaded plugins for admin display
    if (!empty($loaded)) {
        update_option('vendor_loader_loaded_plugins', $loaded);
    }
}

// Load plugins after WordPress is fully initialized
add_action('plugins_loaded', 'load_vendor_plugins', 5);

// Simple admin notice to show loaded plugins
function vendor_loader_admin_notice() {
    if (!current_user_can('activate_plugins')) {
        return;
    }
    
    $loaded = get_option('vendor_loader_loaded_plugins', array());
    
    if (!empty($loaded)) {
        echo '<div class="notice notice-success is-dismissible">';
        echo '<p><strong>Vendor Plugins Loader:</strong> Loaded: ' . implode(', ', $loaded) . '</p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'vendor_loader_admin_notice');