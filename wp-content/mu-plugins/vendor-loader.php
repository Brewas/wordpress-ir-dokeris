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
    $vendor_plugins_dir = WP_CONTENT_DIR . '/vendor-plugins';
    
    // Debug log
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Vendor Loader: Checking directory: ' . $vendor_plugins_dir);
    }
    
    if (!is_dir($vendor_plugins_dir)) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('Vendor Loader: Directory not found: ' . $vendor_plugins_dir);
        }
        return;
    }
    
    $plugin_dirs = scandir($vendor_plugins_dir);
    $loaded_plugins = array();
    
    foreach ($plugin_dirs as $plugin_dir) {
        // Skip current and parent directory references
        if ($plugin_dir === '.' || $plugin_dir === '..') {
            continue;
        }
        
        $plugin_path = $vendor_plugins_dir . '/' . $plugin_dir;
        
        // Check if it's a directory
        if (is_dir($plugin_path)) {
            // Try to find the main plugin file
            $main_plugin_file = find_main_plugin_file($plugin_path, $plugin_dir);
            
            if ($main_plugin_file) {
                require_once $main_plugin_file;
                $loaded_plugins[] = $plugin_dir;
                
                if (defined('WP_DEBUG') && WP_DEBUG) {
                    error_log('Vendor Loader: Loaded plugin: ' . $plugin_dir);
                }
            } else {
                if (defined('WP_DEBUG') && WP_DEBUG) {
                    error_log('Vendor Loader: No main plugin file found in: ' . $plugin_dir);
                }
            }
        }
    }
    
    // Store loaded plugins for admin display
    if (!empty($loaded_plugins)) {
        update_option('vendor_loader_loaded_plugins', $loaded_plugins);
    }
}

/**
 * Find the main plugin file in a plugin directory
 */
function find_main_plugin_file($plugin_path, $plugin_dir) {
    // Common WordPress plugin patterns
    $possible_files = array(
        $plugin_path . '/' . $plugin_dir . '.php',           // woocommerce/woocommerce.php
        $plugin_path . '/plugin.php',                         // plugin.php
        $plugin_path . '/index.php',                          // index.php
        $plugin_path . '/' . basename($plugin_path) . '.php' // directory-name/directory-name.php
    );
    
    foreach ($possible_files as $file) {
        if (file_exists($file)) {
            return $file;
        }
    }
    
    // If none of the common patterns match, try to find any PHP file with plugin header
    $files = glob($plugin_path . '/*.php');
    foreach ($files as $file) {
        $content = file_get_contents($file);
        if (strpos($content, 'Plugin Name:') !== false) {
            return $file;
        }
    }
    
    return null;
}

// Load vendor plugins after all standard plugins are loaded
add_action('plugins_loaded', 'load_vendor_plugins', 1);

// Add admin notice to show which plugins were loaded
function vendor_loader_admin_notice() {
    if (!current_user_can('activate_plugins')) {
        return;
    }
    
    $loaded_plugins = get_option('vendor_loader_loaded_plugins', array());
    
    if (!empty($loaded_plugins)) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><strong>Vendor Plugins Loader:</strong> Successfully loaded: <?php echo implode(', ', $loaded_plugins); ?></p>
        </div>
        <?php
    } else {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><strong>Vendor Plugins Loader:</strong> No vendor plugins found in wp-content/vendor-plugins/</p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'vendor_loader_admin_notice');

// Add a debug info page in admin
function vendor_loader_debug_menu() {
    add_management_page(
        'Vendor Loader Debug',
        'Vendor Loader',
        'manage_options',
        'vendor-loader-debug',
        'vendor_loader_debug_page'
    );
}
add_action('admin_menu', 'vendor_loader_debug_menu');

function vendor_loader_debug_page() {
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1>Vendor Plugins Loader Debug Info</h1>
        
        <h2>Configuration</h2>
        <table class="wp-list-table widefat fixed striped">
            <tr>
                <th>Vendor Plugins Directory</th>
                <td><?php echo WP_CONTENT_DIR . '/vendor-plugins'; ?></td>
            </tr>
            <tr>
                <th>Directory Exists</th>
                <td><?php echo is_dir(WP_CONTENT_DIR . '/vendor-plugins') ? 'Yes' : 'No'; ?></td>
            </tr>
            <tr>
                <th>Directory Readable</th>
                <td><?php echo is_readable(WP_CONTENT_DIR . '/vendor-plugins') ? 'Yes' : 'No'; ?></td>
            </tr>
            <tr>
                <th>WP_DEBUG Enabled</th>
                <td><?php echo defined('WP_DEBUG') && WP_DEBUG ? 'Yes' : 'No'; ?></td>
            </tr>
        </table>
        
        <h2>Loaded Plugins</h2>
        <?php
        $loaded_plugins = get_option('vendor_loader_loaded_plugins', array());
        if (!empty($loaded_plugins)) {
            echo '<ul>';
            foreach ($loaded_plugins as $plugin) {
                echo '<li>' . esc_html($plugin) . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No plugins have been loaded yet.</p>';
        }
        ?>
        
        <h2>Directory Contents</h2>
        <?php
        $vendor_dir = WP_CONTENT_DIR . '/vendor-plugins';
        if (is_dir($vendor_dir)) {
            $contents = scandir($vendor_dir);
            echo '<ul>';
            foreach ($contents as $item) {
                if ($item !== '.' && $item !== '..') {
                    $path = $vendor_dir . '/' . $item;
                    $type = is_dir($path) ? '📁 Directory' : '📄 File';
                    echo '<li>' . $type . ': ' . esc_html($item) . '</li>';
                }
            }
            echo '</ul>';
        } else {
            echo '<p>Directory does not exist.</p>';
        }
        ?>
    </div>
    <?php
}
