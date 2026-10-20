<?php
/**
 * Store home page.
 */
get_header();
$c = os_content( 'company' );
?>
<section class="hero">
	<div class="container hero__in">
		<div class="hero__text">
			<p class="eyebrow">B2B supplier · Berlin · ships EU-wide</p>
			<h1>Everything for orthodontic treatment, from one supplier</h1>
			<p class="lead">Brackets, archwires, bands, tubes, elastics, instruments, bonding and appliances from 3M, Ormco, Ortho Organizers, YDM and Accuram. Same-day dispatch, clinic pricing, specialist support.</p>
			<div class="hero__cta"><a class="btn btn--primary btn--lg" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Browse the catalogue</a><a class="btn btn--ghost btn--lg" href="<?php echo esc_url( home_url( '/quick-order/' ) ); ?>"><?php echo os_icon( 'list' ); ?> Quick order by SKU</a></div>
			<ul class="hero__facts"><li><strong><?php echo (int) wp_count_posts( 'product' )->publish; ?>+</strong><span>products in stock</span></li><li><strong>9</strong><span>manufacturers</span></li><li><strong><?php echo esc_html( $c['cutoff'] ); ?></strong><span>same-day cut-off</span></li></ul>
		</div>
		<div class="hero__tiles">
			<?php foreach ( array_slice( os_top_categories(), 0, 6 ) as $cat ) : $thumb = get_term_meta( $cat->term_id, 'thumbnail_id', true ); ?>
				<a class="tile" href="<?php echo esc_url( get_term_link( $cat ) ); ?>">
					<?php echo $thumb ? wp_get_attachment_image( $thumb, 'woocommerce_thumbnail', false, [ 'loading' => 'lazy' ] ) : '<span class="tile__ph">' . os_icon( 'grid' ) . '</span>'; ?>
					<span class="tile__name"><?php echo esc_html( wp_specialchars_decode( $cat->name ) ); ?><small><?php echo (int) $cat->count; ?> items</small></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="sec">
	<div class="container">
		<div class="sec__head"><h2>Shop by category</h2><a class="link-arrow" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Full catalogue <?php echo os_icon( 'arrow' ); ?></a></div>
		<div class="cats">
			<?php foreach ( os_top_categories() as $cat ) : $thumb = get_term_meta( $cat->term_id, 'thumbnail_id', true ); $children = get_terms( [ 'taxonomy' => 'product_cat', 'parent' => $cat->term_id, 'hide_empty' => true ] ); ?>
				<div class="catcard">
					<a class="catcard__media" href="<?php echo esc_url( get_term_link( $cat ) ); ?>"><?php echo $thumb ? wp_get_attachment_image( $thumb, 'woocommerce_thumbnail', false, [ 'loading' => 'lazy' ] ) : '<span class="tile__ph">' . os_icon( 'grid' ) . '</span>'; ?></a>
					<div class="catcard__body"><h3><a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"><?php echo esc_html( wp_specialchars_decode( $cat->name ) ); ?></a></h3>
						<?php if ( $children && ! is_wp_error( $children ) ) : ?><ul><?php foreach ( $children as $ch ) : ?><li><a href="<?php echo esc_url( get_term_link( $ch ) ); ?>"><?php echo esc_html( wp_specialchars_decode( $ch->name ) ); ?> <small>(<?php echo (int) $ch->count; ?>)</small></a></li><?php endforeach; ?></ul><?php else : ?><p><?php echo (int) $cat->count; ?> products</p><?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="sec sec--alt">
	<div class="container">
		<div class="sec__head"><h2>Bestsellers</h2><a class="link-arrow" href="<?php echo esc_url( add_query_arg( 'orderby', 'popularity', wc_get_page_permalink( 'shop' ) ) ); ?>">All bestsellers <?php echo os_icon( 'arrow' ); ?></a></div>
		<?php echo do_shortcode( '[products limit="8" columns="4" visibility="featured"]' ); ?>
	</div>
</section>

<section class="sec">
	<div class="container">
		<div class="sec__head"><h2>On sale this month</h2></div>
		<?php echo do_shortcode( '[products limit="4" columns="4" on_sale="true"]' ); ?>
	</div>
</section>

<section class="sec sec--brands">
	<div class="container">
		<h2 class="sec__title">Brands we stock</h2>
		<ul class="brands"><?php foreach ( os_content( 'brands' ) as $b ) : ?><li><a href="<?php echo esc_url( add_query_arg( 'filter_brand', sanitize_title( $b ), wc_get_page_permalink( 'shop' ) ) ); ?>"><?php echo esc_html( $b ); ?></a></li><?php endforeach; ?></ul>
	</div>
</section>

<section class="sec sec--alt">
	<div class="container container--narrow">
		<h2 class="sec__title">Questions from practices</h2>
		<?php get_template_part( 'template-parts/faq' ); ?>
	</div>
</section>
<?php get_footer();
