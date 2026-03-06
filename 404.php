<?php get_header(); ?>

<main class="section" style="padding-top:120px;text-align:center;min-height:60vh;display:flex;align-items:center;justify-content:center">
  <div>
    <h1 style="font-size:4rem;font-weight:800;color:var(--accent);margin-bottom:16px">404</h1>
    <h2 class="section-title">Page Not Found</h2>
    <p class="section-sub" style="margin-bottom:32px">The page you're looking for doesn't exist.</p>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">Back to Home</a>
  </div>
</main>

<?php get_footer(); ?>
