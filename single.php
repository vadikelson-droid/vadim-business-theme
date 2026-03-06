<?php get_header(); ?>

<main class="section" style="padding-top:120px;max-width:800px">
  <?php while (have_posts()): the_post(); ?>
    <article>
      <div class="section-header" style="text-align:left">
        <div class="section-tag"><?php echo get_the_date(); ?></div>
        <h1 class="section-title"><?php the_title(); ?></h1>
      </div>
      <?php if (has_post_thumbnail()): ?>
        <div style="margin-bottom:32px;border-radius:var(--radius);overflow:hidden">
          <?php the_post_thumbnail('large'); ?>
        </div>
      <?php endif; ?>
      <div style="font-size:.95rem;line-height:1.8;color:var(--text2)">
        <?php the_content(); ?>
      </div>
    </article>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>
