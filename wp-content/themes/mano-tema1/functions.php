<?php

function mano_tema_styles() {
    wp_enqueue_style(
        'mano-tema-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );
}

add_action('wp_enqueue_scripts', 'mano_tema_styles');
