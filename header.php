<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
  <div class="header-inner">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
      <?php if (has_custom_logo()): ?>
        <?php the_custom_logo(); ?>
      <?php else: ?>
        <div class="mark"><?php echo esc_html(mb_substr(get_bloginfo('name'), 0, 1)); ?></div>
        <?php bloginfo('name'); ?>
      <?php endif; ?>
    </a>
    <nav class="main-nav">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'items_wrap'     => '%3$s',
        'fallback_cb'    => 'vadim_default_menu',
      ]);
      ?>
      <a href="<?php echo esc_url(get_theme_mod('hero_btn_url', '#contact')); ?>" class="nav-cta">
        <?php echo esc_html(get_theme_mod('cta_btn_text', 'Contact Us')); ?>
      </a>
    </nav>
  </div>
</header>

<?php
function vadim_default_menu() {
    echo '<a href="#services">Services</a>';
    echo '<a href="#portfolio">Portfolio</a>';
    echo '<a href="#testimonials">Testimonials</a>';
    echo '<a href="#contact">Contact</a>';
}
?>
