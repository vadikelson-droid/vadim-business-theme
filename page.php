<?php get_header(); ?>

<main class="section" style="padding-top:120px;max-width:900px">
  <?php while (have_posts()): the_post(); ?>
    <div class="section-header">
      <h1 class="section-title"><?php the_title(); ?></h1>
    </div>
    <div style="font-size:.95rem;line-height:1.8;color:var(--text2)">
      <?php the_content(); ?>
    </div>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>
