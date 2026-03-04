<?php
/**
 * Astra Child Theme functions and definitions
 */

// Force load CSS
add_action('wp_enqueue_scripts', function() {
    // Parent theme CSS
    wp_enqueue_style('astra-parent', get_template_directory_uri() . '/style.css');
    
    // Child theme CSS - with cache busting
    wp_enqueue_style('astra-child', 
        get_stylesheet_directory_uri() . '/style.css', 
        ['astra-parent'], 
        time() // This forces browser to reload CSS every time
    );
}, 999);



// Add smooth scroll script
add_action('wp_footer', function() {
    if (is_front_page()) {
        ?>
        <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
        </script>
        <?php
    }
});
