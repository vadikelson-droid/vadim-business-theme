<?php get_header(); ?>

<!-- Hero -->
<section class="hero">
  <div class="hero-inner">
    <div class="hero-content">
      <div class="hero-badge rv"><span class="dot"></span> <?php echo esc_html(get_theme_mod('hero_badge', 'Accepting new projects')); ?></div>
      <?php
      $title = get_theme_mod('hero_title', 'We build websites that bring real clients');
      $accent_word = get_theme_mod('hero_accent', 'real clients');
      if ($accent_word) {
          $title = str_replace($accent_word, '<span class="accent">' . esc_html($accent_word) . '</span>', $title);
      }
      ?>
      <h1 class="rv rv-d1"><?php echo wp_kses($title, ['span' => ['class' => []], 'br' => []]); ?></h1>
      <p class="rv rv-d2"><?php echo esc_html(get_theme_mod('hero_text', 'Full-cycle development: from idea to working product.')); ?></p>
      <div class="hero-btns rv rv-d3">
        <a href="<?php echo esc_url(get_theme_mod('hero_btn_url', '#contact')); ?>" class="btn-primary">
          <?php echo esc_html(get_theme_mod('hero_btn_text', 'Start a Project')); ?>
        </a>
        <a href="#portfolio" class="btn-ghost">View Portfolio</a>
      </div>
    </div>
  </div>
</section>

<!-- Stats Bar -->
<div class="stats-bar rv">
  <?php for ($i = 1; $i <= 3; $i++):
    $num = get_theme_mod("stat_{$i}_num", ['12+', '3 days', '24/7'][$i-1]);
    $lbl = get_theme_mod("stat_{$i}_label", ['Projects', 'Landing delivery', 'Support'][$i-1]);
  ?>
    <?php if ($i > 1): ?><div class="stat-divider"></div><?php endif; ?>
    <div class="stat">
      <span class="stat-num"><?php echo esc_html($num); ?></span>
      <span class="stat-lbl"><?php echo esc_html($lbl); ?></span>
    </div>
  <?php endfor; ?>
</div>

<!-- Services -->
<section class="section" id="services">
  <div class="section-header rv">
    <div class="section-tag">Services</div>
    <h2 class="section-title">What We Do</h2>
    <p class="section-sub">Comprehensive digital solutions for your business</p>
  </div>
  <div class="services-grid">
    <?php
    $services = new WP_Query(['post_type' => 'service', 'posts_per_page' => 6, 'orderby' => 'menu_order', 'order' => 'ASC']);
    if ($services->have_posts()):
      $icons = ['💻', '🤖', '⚡', '🛒', '🎨', '🔧'];
      $idx = 0;
      while ($services->have_posts()): $services->the_post();
    ?>
      <div class="service-card rv<?php echo $idx > 0 ? ' rv-d' . min($idx, 3) : ''; ?>">
        <div class="service-icon <?php echo $idx % 2 === 0 ? 'blue' : 'gold'; ?>"><?php echo $icons[$idx % count($icons)]; ?></div>
        <h3><?php the_title(); ?></h3>
        <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
      </div>
    <?php $idx++; endwhile; wp_reset_postdata();
    else: ?>
      <div class="service-card rv">
        <div class="service-icon blue">💻</div>
        <h3>Web Development</h3>
        <p>Responsive websites from 1 to 10+ pages. Mobile version, SSL, domain, hosting — all included.</p>
      </div>
      <div class="service-card rv rv-d1">
        <div class="service-icon gold">🤖</div>
        <h3>Telegram Bots</h3>
        <p>Bots for orders, bookings, notifications, CRM integration. Working 24/7 without weekends.</p>
      </div>
      <div class="service-card rv rv-d2">
        <div class="service-icon blue">⚡</div>
        <h3>Automation</h3>
        <p>POS systems, payment services, Google Sheets, notifications — everything works automatically.</p>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Portfolio -->
<div class="section-alt" id="portfolio">
  <section class="section">
    <div class="section-header rv">
      <div class="section-tag">Portfolio</div>
      <h2 class="section-title">Our Work</h2>
      <p class="section-sub">Real projects that are working right now</p>
    </div>
    <div class="portfolio-grid">
      <?php
      $projects = new WP_Query(['post_type' => 'portfolio', 'posts_per_page' => 6, 'orderby' => 'menu_order', 'order' => 'ASC']);
      if ($projects->have_posts()):
        $pidx = 0;
        while ($projects->have_posts()): $projects->the_post();
          $link = get_post_meta(get_the_ID(), 'project_url', true);
          $techs = get_post_meta(get_the_ID(), 'technologies', true);
      ?>
        <<?php echo $link ? 'a href="' . esc_url($link) . '" target="_blank"' : 'div'; ?> class="portfolio-card rv<?php echo $pidx === 0 ? ' featured' : ''; ?>">
          <?php if (has_post_thumbnail()): ?>
            <div class="portfolio-img"><?php the_post_thumbnail('portfolio-thumb'); ?></div>
          <?php endif; ?>
          <div class="portfolio-body">
            <h3><?php the_title(); ?></h3>
            <p><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
            <?php if ($techs): ?>
              <div class="tags">
                <?php foreach (explode(',', $techs) as $t): ?>
                  <span class="tag"><?php echo esc_html(trim($t)); ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </<?php echo $link ? 'a' : 'div'; ?>>
      <?php $pidx++; endwhile; wp_reset_postdata();
      else: ?>
        <div class="portfolio-card featured rv">
          <div class="portfolio-img" style="height:220px;background:linear-gradient(135deg,#1e1b4b,#312e81);display:flex;align-items:center;justify-content:center">
            <span style="font-size:2rem;font-weight:800;color:rgba(255,255,255,.1)">PROJECT</span>
          </div>
          <div class="portfolio-body">
            <h3>Your First Project</h3>
            <p>Add portfolio projects through the WordPress admin panel → Portfolio → Add New</p>
            <div class="tags"><span class="tag">WordPress</span><span class="tag">Custom Theme</span></div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>
</div>

<!-- Testimonials -->
<section class="section" id="testimonials">
  <div class="section-header rv">
    <div class="section-tag">Testimonials</div>
    <h2 class="section-title">What Clients Say</h2>
  </div>
  <div class="testimonials-grid">
    <?php
    $reviews = new WP_Query(['post_type' => 'testimonial', 'posts_per_page' => 3]);
    if ($reviews->have_posts()):
      $ridx = 0;
      while ($reviews->have_posts()): $reviews->the_post();
        $role = get_post_meta(get_the_ID(), 'client_role', true);
    ?>
      <div class="testimonial-card rv<?php echo $ridx > 0 ? ' rv-d' . $ridx : ''; ?>">
        <div class="testimonial-stars">★★★★★</div>
        <blockquote><?php echo wp_trim_words(get_the_content(), 40); ?></blockquote>
        <div class="testimonial-author">
          <div class="testimonial-avatar"><?php echo esc_html(mb_substr(get_the_title(), 0, 1)); ?></div>
          <div>
            <div class="testimonial-name"><?php the_title(); ?></div>
            <?php if ($role): ?><div class="testimonial-role"><?php echo esc_html($role); ?></div><?php endif; ?>
          </div>
        </div>
      </div>
    <?php $ridx++; endwhile; wp_reset_postdata();
    else: ?>
      <?php
      $demo_reviews = [
          ['name' => 'Maria S.', 'role' => 'Beauty Salon Owner', 'text' => 'Amazing work! The website looks exactly how I imagined. Professional, fast, and very responsive to feedback.'],
          ['name' => 'Alex K.', 'role' => 'Restaurant Manager', 'text' => 'The Telegram bot completely changed how we handle orders. Now everything is automated and we save hours daily.'],
          ['name' => 'Diana P.', 'role' => 'Photographer', 'text' => 'Beautiful portfolio website with a powerful admin panel. I can manage my gallery myself without any technical knowledge.'],
      ];
      foreach ($demo_reviews as $i => $r): ?>
        <div class="testimonial-card rv<?php echo $i > 0 ? " rv-d{$i}" : ''; ?>">
          <div class="testimonial-stars">★★★★★</div>
          <blockquote><?php echo esc_html($r['text']); ?></blockquote>
          <div class="testimonial-author">
            <div class="testimonial-avatar"><?php echo esc_html($r['name'][0]); ?></div>
            <div>
              <div class="testimonial-name"><?php echo esc_html($r['name']); ?></div>
              <div class="testimonial-role"><?php echo esc_html($r['role']); ?></div>
            </div>
          </div>
        </div>
      <?php endforeach;
    endif; ?>
  </div>
</section>

<?php get_footer(); ?>
