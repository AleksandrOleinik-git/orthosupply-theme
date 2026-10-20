<?php
/**
 * Product archive with sidebar filters.
 */
defined( 'ABSPATH' ) || exit;
get_header( 'shop' );
?>
<section class="page-head">
	<div class="container">
		<?php woocommerce_breadcrumb(); ?>
		<h1 class="page-head__title"><?php woocommerce_page_title(); ?></h1>
		<?php if ( is_tax() && term_description() ) : ?><div class="page-head__desc"><?php echo wp_kses_post( term_description() ); ?></div><?php endif; ?>
	</div>
</section>
<div class="container shop">
	<?php get_template_part( 'template-parts/shop-filters' ); ?>
	<main class="shop__main">
		<?php if ( woocommerce_product_loop() ) : ?>
			<div class="shop__bar"><?php woocommerce_result_count(); woocommerce_catalog_ordering(); ?></div>
			<?php woocommerce_product_loop_start(); while ( have_posts() ) : the_post(); wc_get_template_part( 'content', 'product' ); endwhile; woocommerce_product_loop_end(); ?>
			<?php woocommerce_pagination(); ?>
		<?php else : ?>
			<div class="empty"><?php echo os_icon( 'search', 'empty__icon' ); ?><h2>No products match these filters</h2><p>Try removing a filter, search by SKU, or <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">ask our specialists</a>. We can source items that are not in the catalogue.</p></div>
		<?php endif; ?>
	</main>
</div>
<?php get_footer( 'shop' );
