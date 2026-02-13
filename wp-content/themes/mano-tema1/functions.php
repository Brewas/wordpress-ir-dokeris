<?php
function mano_tema_enqueue_styles() {
    wp_enqueue_style('mano-tema-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'mano_tema_enqueue_styles');
