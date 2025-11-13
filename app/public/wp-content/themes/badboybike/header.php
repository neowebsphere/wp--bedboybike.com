<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- HEADER -->
<header class="header">
    <div class="container header__container">
        <?php if (has_custom_logo()) : ?>
            <?php the_custom_logo(); ?>
        <?php else : ?>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                <span class="logo__text">BAD</span>
                <span class="logo__text">BOY</span>
                <span class="logo__text">BIKE</span>
            </a>
        <?php endif; ?>
        
        <nav class="nav" id="nav">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => 'nav__list',
                'container' => false,
                'fallback_cb' => 'badboybike_default_menu',
            ));
            ?>
        </nav>
        
        <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
            <span class="nav-toggle__bar"></span>
            <span class="nav-toggle__bar"></span>
            <span class="nav-toggle__bar"></span>
        </button>
    </div>
</header>

<?php
// Default menu fallback
function badboybike_default_menu() {
    ?>
    <ul class="nav__list">
        <li><a href="<?php echo esc_url(home_url('/')); ?>" class="nav__link<?php echo is_front_page() ? ' active' : ''; ?>">HOME</a></li>
        <li><a href="<?php echo esc_url(site_url('/customs/')); ?>" class="nav__link<?php echo is_page('customs') ? ' active' : ''; ?>">CUSTOMS</a></li> 
        <li><a href="<?php echo esc_url(site_url('/about/')); ?>" class="nav__link<?php echo is_page('about') ? ' active' : ''; ?>">ABOUT</a></li>
          
        <li><a href="<?php echo esc_url(site_url('/contact/')); ?>" class="nav__link<?php echo is_page('contact') ? ' active' : ''; ?>">CONTACT</a></li>
    </ul>
    <?php
}   


