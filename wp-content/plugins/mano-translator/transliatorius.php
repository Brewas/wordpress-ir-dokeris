<?php
/**
 * Plugin Name: Transliatorius 
 * Description: ENG/LT transliacija
 * Version: 1.0.0
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load plugin text domain for translations
 */
function st_load_textdomain() {
    load_plugin_textdomain('simple-translator', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'st_load_textdomain');

/**
 * Get translated text
 * 
 * @param string $key The translation key
 * @param string $default_text Default text if translation not found
 * @return string Translated text
 */
function st_translate($key, $default_text = '') {
    // Define translations array (English and Lithuanian)
    $translations = array(
        // Header translations
        'welcome_message' => array(
            'en' => 'Welcome to our website!',
            'lt' => 'Sveiki atvykę į mūsų svetainę!'
        ),
        'about_us' => array(
            'en' => 'About Us',
            'lt' => 'Apie mus'
        ),
        'contact' => array(
            'en' => 'Contact',
            'lt' => 'Kontaktai'
        ),
        
        // Content translations
        'our_services' => array(
            'en' => 'Our Services',
            'lt' => 'Mūsų paslaugos'
        ),
        'read_more' => array(
            'en' => 'Read More',
            'lt' => 'Skaityti daugiau'
        ),
        'get_in_touch' => array(
            'en' => 'Get in Touch',
            'lt' => 'Susisiekite'
        ),

        'all_rights_reserved' => array(
            'en' => 'All rights reserved',
            'lt' => 'Visos teisės saugomos'
        ),
        'privacy_policy' => array(
            'en' => 'Privacy Policy',
            'lt' => 'Privatumo politika'
        ),
    );
    
    $language = st_get_current_language();
    
    // Return translation if exists, otherwise return default text or key
    if (isset($translations[$key][$language])) {
        return $translations[$key][$language];
    }
    
    return !empty($default_text) ? $default_text : $key;
}

/**
 * Get current language
 * 
 * @return string Current language code (en or lt)
 */
function st_get_current_language() {
    // You can implement language detection here
    // For now, we'll use a session/cookie or URL parameter
    
    // Check if language is set in URL (e.g., ?lang=lt)
    if (isset($_GET['lang']) && in_array($_GET['lang'], array('en', 'lt'))) {
        setcookie('st_language', $_GET['lang'], time() + (86400 * 30), '/');
        return $_GET['lang'];
    }
    
    // Check if language is set in cookie
    if (isset($_COOKIE['st_language']) && in_array($_COOKIE['st_language'], array('en', 'lt'))) {
        return $_COOKIE['st_language'];
    }
    
    return 'en';
}


function st_language_switcher_shortcode() {
    $current_lang = st_get_current_language();
    $other_lang = ($current_lang === 'en') ? 'lt' : 'en';
    $other_lang_name = ($other_lang === 'en') ? 'English' : 'Lietuvių';
    
    $url = add_query_arg('lang', $other_lang);
    
    return '<div class="language-switcher">
        <a href="' . esc_url($url) . '">' . $other_lang_name . '</a>
    </div>';
}
add_shortcode('language_switcher', 'st_language_switcher_shortcode');

/**
 * 
 * @param string $key Translation key
 * @param string $default_text Default text
 * @return string Translated text
 */
function __st($key, $default_text = '') {
    return st_translate($key, $default_text);
}