<?php get_header(); ?>

<main class="section" style="padding-top:120px">
  <?php if (have_posts()): ?>
    <div class="section-header">
      <h2 class="section-title"><?php echo is_home() ? 'Blog' : get_the_archive_title(); ?></h2>
    </div>
    <div class="portfolio-grid">
      <?php while (have_posts()): the_post(); ?>
        <article class="portfolio-card rv">
          <?php if (has_post_thumbnail()): ?>
            <div class="portfolio-img">
              <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('portfolio-thumb'); ?></a>
            </div>
          <?php endif; ?>
          <div class="portfolio-body">
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <p><?php echo wp_trim_words(get_the_excerpt(), 30); ?></p>
            <div class="tags">
              <span class="tag"><?php echo get_the_date(); ?></span>
            </div>
          </div>
        </article>
      <?php endwhile; ?>
    </div>
    <div style="text-align:center;margin-top:40px">
      <?php the_posts_pagination(['mid_size' => 2, 'prev_text' => '← Previous', 'next_text' => 'Next →']); ?>
    </div>
  <?php else: ?>
    <div class="section-header">
      <h2 class="section-title">Nothing found</h2>
      <p class="section-sub">No posts yet.</p>
    </div>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
