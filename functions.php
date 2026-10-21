<?php
/**
 * OrthoSupply theme bootstrap.
 */
defined( 'ABSPATH' ) || exit;

define( 'OS_THEME_VERSION', '1.0.2' );

require_once get_theme_file_path( 'inc/content.php' );
require_once get_theme_file_path( 'inc/woocommerce.php' );

add_action( 'after_setup_theme', static function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'gallery', 'caption', 'script', 'style' ] );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'woocommerce', [
		'thumbnail_image_width' => 480,
		'single_image_width'    => 800,
		'product_grid'          => [ 'default_columns' => 4, 'min_columns' => 2, 'max_columns' => 5 ],
	] );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	register_nav_menus( [ 'primary' => 'Primary menu', 'footer' => 'Footer menu', 'top' => 'Top bar links' ] );
} );

add_action( 'wp_enqueue_scripts', static function () {
	wp_enqueue_style( 'os-fonts', 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap', [], null );
	wp_enqueue_style( 'os-main', get_theme_file_uri( 'assets/css/main.css' ), [], OS_THEME_VERSION );
	wp_enqueue_script( 'os-main', get_theme_file_uri( 'assets/js/main.js' ), [], OS_THEME_VERSION, [ 'strategy' => 'defer' ] );
	wp_localize_script( 'os-main', 'osTheme', [ 'ajax' => admin_url( 'admin-ajax.php' ), 'cartUrl' => wc_get_cart_url() ] );
} );

add_filter( 'wp_resource_hints', static function ( array $urls, string $relation ) {
	if ( $relation === 'preconnect' ) {
		$urls[] = [ 'href' => 'https://fonts.gstatic.com', 'crossorigin' ];
	}
	return $urls;
}, 10, 2 );

/** Inline SVG icon from the sprite. */
function os_icon( string $name, string $class = '' ): string {
	return '<svg class="icon icon--' . esc_attr( $name ) . ( $class ? ' ' . esc_attr( $class ) : '' ) . '" aria-hidden="true" width="24" height="24"><use href="' . esc_url( get_theme_file_uri( 'assets/img/icons.svg' ) ) . '#' . esc_attr( $name ) . '"></use></svg>';
}

/** Fallback menu until one is assigned. */
function os_default_menu( array $args ): void {
	$items = [ 'Catalogue' => wc_get_page_permalink( 'shop' ), 'Brands' => home_url( '/brands/' ), 'Quick order' => home_url( '/quick-order/' ), 'Delivery & payment' => home_url( '/delivery/' ), 'About' => home_url( '/about/' ), 'Contact' => home_url( '/contact/' ) ];
	echo '<ul class="' . esc_attr( $args['menu_class'] ?? 'menu' ) . '">';
	foreach ( $items as $label => $url ) {
		echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}

/** Top-level product categories with thumbnails, for the header dropdown and home tiles. */
function os_top_categories(): array {
	$terms = get_terms( [ 'taxonomy' => 'product_cat', 'parent' => 0, 'hide_empty' => true, 'orderby' => 'name' ] );
	return is_wp_error( $terms ) ? [] : array_values( array_filter( $terms, static fn ( $t ) => $t->slug !== 'uncategorized' ) );
}

/** Organisation schema. */
add_action( 'wp_head', static function () {
	$c = os_content( 'company' );
	echo '<script type="application/ld+json">' . wp_json_encode( [
		'@context' => 'https://schema.org', '@type' => 'MedicalBusiness', 'name' => get_bloginfo( 'name' ), 'url' => home_url( '/' ),
		'telephone' => $c['phone'], 'email' => $c['email'],
		'address' => [ '@type' => 'PostalAddress', 'streetAddress' => $c['address'], 'addressLocality' => $c['city'], 'postalCode' => $c['zip'], 'addressCountry' => 'DE' ],
	], JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}, 20 );

add_filter( 'excerpt_length', static fn () => 20 );
