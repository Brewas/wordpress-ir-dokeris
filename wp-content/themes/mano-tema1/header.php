<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header class="site-header">
    <div class="nav-container">
        <div class="logo">
            <a href="<?php echo home_url(); ?>">MySite</a>
        </div>

        <nav class="main-nav">
            <a href="#">Home</a>
            <a href="#">Services</a>
            <a href="#">About</a>
            <a href="#">Reviews</a>
            <a href="#">Why Us</a>
            <a href="#">Contact</a>
        </nav>
    </div>
</header>
