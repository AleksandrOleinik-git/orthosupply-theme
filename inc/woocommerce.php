<?php
/**
 * WooCommerce integration: wrappers, hooks, card markup, cart fragments, account tweaks.
 */
defined( 'ABSPATH' ) || exit;

// Replace the default wrappers with the theme's layout.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
add_action( 'woocommerce_before_main_content', static fn () => print( '<div class="container shop"><main class="shop__main">' ), 10 );
add_action( 'woocommerce_after_main_content', static fn () => print( '</main></div>' ), 10 );

// Breadcrumbs above the title, in the page head band.
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_filter( 'woocommerce_breadcrumb_defaults', static fn ( array $d ) => array_merge( $d, [ 'delimiter' => ' <span>/</span> ', 'wrap_before' => '<nav class="breadcrumbs" aria-label="Breadcrumb">', 'wrap_after' => '</nav>', 'home' => 'Home' ] ) );

// Product card: our own markup.
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_before_shop_loop_item', 'os_card_open', 10 );
add_action( 'woocommerce_after_shop_loop_item', 'os_card_close', 10 );

function os_card_open(): void {
	global $product;
	$brand = os_product_brand( $product );
	?>
	<div class="pcard">
		<a class="pcard__media" href="<?php echo esc_url( $product->get_permalink() ); ?>" tabindex="-1" aria-hidden="true">
			<?php echo $product->get_image( 'woocommerce_thumbnail', [ 'loading' => 'lazy' ] ); ?>
			<?php if ( $product->is_on_sale() ) : ?><span class="pcard__badge pcard__badge--sale">Sale</span><?php elseif ( ! $product->is_in_stock() ) : ?><span class="pcard__badge pcard__badge--out">Out of stock</span><?php endif; ?>
		</a>
		<div class="pcard__body">
			<?php if ( $brand ) : ?><p class="pcard__brand"><?php echo esc_html( $brand ); ?></p><?php endif; ?>
			<h2 class="pcard__title"><a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h2>
			<p class="pcard__sku">SKU <?php echo esc_html( $product->get_sku() ?: '—' ); ?></p>
			<div class="pcard__foot">
				<span class="pcard__price"><?php echo $product->get_price_html(); ?></span>
				<?php woocommerce_template_loop_add_to_cart( [ 'class' => 'btn btn--sm btn--primary ' . ( $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button ajax_add_to_cart' : '' ) ] ); ?>
			</div>
	<?php
}
function os_card_close(): void {
	echo '</div></div>';
}

/** Brand from the global "Brand" attribute or the product tag. */
function os_product_brand( WC_Product $product ): string {
	$brand = $product->get_attribute( 'pa_brand' );
	if ( ! $brand ) {
		$tags  = get_the_terms( $product->get_id(), 'product_tag' );
		$brand = $tags && ! is_wp_error( $tags ) ? $tags[0]->name : '';
	}
	return $brand;
}

// Result count + ordering in our bar; pagination unchanged.
add_filter( 'woocommerce_catalog_orderby', static fn ( array $o ) => [ 'menu_order' => 'Default', 'popularity' => 'Bestsellers', 'date' => 'Newest', 'price' => 'Price: low to high', 'price-desc' => 'Price: high to low' ] );
add_filter( 'loop_shop_per_page', static fn () => 24 );

// Shop sidebar: category tree + attribute filters, rendered by template-parts/shop-filters.php.
add_action( 'woocommerce_before_shop_loop', static function () {
	echo '<div class="shop__bar">';
}, 15 );
add_action( 'woocommerce_before_shop_loop', static function () {
	echo '</div>';
}, 35 );

// Single product: sticky buy box pieces reordered.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'os_single_brand_sku', 4 );
function os_single_brand_sku(): void {
	global $product;
	$brand = os_product_brand( $product );
	echo '<p class="single__brand">' . ( $brand ? esc_html( $brand ) . ' · ' : '' ) . 'SKU ' . esc_html( $product->get_sku() ?: '—' ) . '</p>';
}
add_action( 'woocommerce_single_product_summary', static function () {
	$c = os_content( 'company' );
	echo '<ul class="single__points"><li>' . os_icon( 'truck' ) . ' Same-day dispatch before ' . esc_html( $c['cutoff'] ) . ' CET</li><li>' . os_icon( 'shield' ) . ' Original product, full traceability</li><li>' . os_icon( 'tag' ) . ' Volume pricing from 10 units</li></ul>';
}, 35 );

// Cart count fragment for the header.
add_filter( 'woocommerce_add_to_cart_fragments', static function ( array $f ) {
	$f['.cart-link__count'] = '<span class="cart-link__count">' . (int) WC()->cart->get_cart_contents_count() . '</span>';
	return $f;
} );

// Volume discount notice: 10+ of one SKU gets 5 % off, 50+ gets 10 % (demo rule).
add_action( 'woocommerce_cart_calculate_fees', static function ( WC_Cart $cart ) {
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
		return;
	}
	$discount = 0;
	foreach ( $cart->get_cart() as $item ) {
		$qty = (int) $item['quantity'];
		$rate = $qty >= 50 ? 0.10 : ( $qty >= 10 ? 0.05 : 0 );
		$discount += $item['line_subtotal'] * $rate;
	}
	if ( $discount > 0 ) {
		$cart->add_fee( 'Volume discount', -$discount, true );
	}
} );

// Remove the default "WooCommerce" generator noise, keep things light.
add_filter( 'woocommerce_enqueue_styles', static function ( array $styles ) {
	unset( $styles['woocommerce-general'], $styles['woocommerce-layout'], $styles['woocommerce-smallscreen'] );
	return $styles;
} );

// Quantity +/- buttons around WooCommerce quantity inputs.
add_action( 'woocommerce_before_quantity_input_field', static fn () => print( '<button type="button" class="qtybtn" data-qty="-" aria-label="Decrease quantity">−</button>' ) );
add_action( 'woocommerce_after_quantity_input_field', static fn () => print( '<button type="button" class="qtybtn" data-qty="+" aria-label="Increase quantity">+</button>' ) );

// Rename the "Additional information" tab and drop reviews for a B2B catalogue.
add_filter( 'woocommerce_product_tabs', static function ( array $tabs ) {
	if ( isset( $tabs['additional_information'] ) ) {
		$tabs['additional_information']['title'] = 'Specifications';
	}
	unset( $tabs['reviews'] );
	return $tabs;
}, 98 );

// Shop page title.
add_filter( 'woocommerce_page_title', static fn ( string $t ) => is_shop() ? 'Catalogue' : $t );

// Category thumbnails: use the first product image when the category has none.
add_filter( 'get_term_metadata', static function ( $value, $object_id, $meta_key ) {
	if ( $meta_key !== 'thumbnail_id' || $value !== null ) {
		return $value;
	}
	$term = get_term( $object_id );
	if ( ! $term || is_wp_error( $term ) || $term->taxonomy !== 'product_cat' ) {
		return $value;
	}
	$cached = wp_cache_get( 'os_cat_thumb_' . $object_id, 'orthosupply' );
	if ( $cached !== false ) {
		return [ $cached ];
	}
	$ids = get_posts( [ 'post_type' => 'product', 'posts_per_page' => 1, 'fields' => 'ids', 'tax_query' => [ [ 'taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $object_id ] ], 'meta_key' => '_thumbnail_id', 'orderby' => 'menu_order', 'order' => 'ASC' ] );
	$thumb = $ids ? (int) get_post_thumbnail_id( $ids[0] ) : 0;
	wp_cache_set( 'os_cat_thumb_' . $object_id, $thumb, 'orthosupply', HOUR_IN_SECONDS );
	return [ $thumb ];
}, 10, 3 );
