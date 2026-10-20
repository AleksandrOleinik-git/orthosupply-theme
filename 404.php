<?php get_header(); ?>
<section class="sec"><div class="container empty"><?php echo os_icon( 'search', 'empty__icon' ); ?><h1>Page not found</h1><p>The product may have been discontinued. Search by SKU above or go to the <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">catalogue</a>.</p></div></section>
<?php get_footer();
