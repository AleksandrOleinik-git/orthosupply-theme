<?php get_header(); the_post(); ?>
<section class="page-head"><div class="container"><nav class="breadcrumbs" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> <span>/</span> <span aria-current="page"><?php the_title(); ?></span></nav><h1 class="page-head__title"><?php the_title(); ?></h1></div></section>
<section class="sec"><div class="container <?php echo is_cart() || is_checkout() || is_account_page() ? 'wc-page' : 'container--narrow prose'; ?>"><?php the_content(); ?></div></section>
<?php get_footer();
