<section class="cta" id="contact">
  <div class="cta-inner">
    <h2 class="rv"><?php echo esc_html(get_theme_mod('cta_title', 'Ready to discuss your project?')); ?></h2>
    <p class="rv rv-d1"><?php echo esc_html(get_theme_mod('cta_text', 'Write to us — we respond within an hour')); ?></p>
    <div class="rv rv-d2">
      <a href="<?php echo esc_url(get_theme_mod('cta_btn_url', '#')); ?>" class="btn-white">
        <?php echo esc_html(get_theme_mod('cta_btn_text', 'Contact Us')); ?>
      </a>
    </div>
  </div>
</section>

<footer class="site-footer">
  <div class="footer-inner">
    <div class="footer-brand">
      <h3><?php bloginfo('name'); ?></h3>
      <p><?php bloginfo('description'); ?></p>
    </div>
    <?php if (is_active_sidebar('footer-widgets')): ?>
      <?php dynamic_sidebar('footer-widgets'); ?>
    <?php else: ?>
      <div class="footer-col">
        <h4>Services</h4>
        <a href="#">Web Development</a>
        <a href="#">Telegram Bots</a>
        <a href="#">Automation</a>
      </div>
      <div class="footer-col">
        <h4>Company</h4>
        <a href="#">About</a>
        <a href="#">Portfolio</a>
        <a href="#">Process</a>
      </div>
      <div class="footer-col">
        <h4>Contact</h4>
        <?php if (get_theme_mod('contact_email')): ?>
          <a href="mailto:<?php echo esc_attr(get_theme_mod('contact_email')); ?>"><?php echo esc_html(get_theme_mod('contact_email')); ?></a>
        <?php endif; ?>
        <?php if (get_theme_mod('contact_telegram')): ?>
          <a href="https://t.me/<?php echo esc_attr(get_theme_mod('contact_telegram')); ?>">Telegram</a>
        <?php endif; ?>
        <?php if (get_theme_mod('contact_phone')): ?>
          <a href="tel:<?php echo esc_attr(get_theme_mod('contact_phone')); ?>"><?php echo esc_html(get_theme_mod('contact_phone')); ?></a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
  <div class="footer-bottom">
    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
