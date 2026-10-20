<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); $c = os_content( 'company' ); ?>
<a class="skip-link" href="#main">Skip to content</a>
<header class="hdr">
	<div class="hdr__top">
		<div class="container hdr__top-in">
			<span><?php echo os_icon( 'truck' ); ?> Free shipping in Germany from €<?php echo (int) $c['free_shipping']; ?> · same-day dispatch before <?php echo esc_html( $c['cutoff'] ); ?> CET</span>
			<span class="hdr__top-links"><a href="tel:<?php echo esc_attr( $c['phone_href'] ); ?>"><?php echo esc_html( $c['phone'] ); ?></a><a href="<?php echo esc_url( home_url( '/delivery/' ) ); ?>">Delivery</a><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a></span>
		</div>
	</div>
	<div class="container hdr__main">
		<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?><span class="logo__mark"><?php echo os_icon( 'logo' ); ?></span><span class="logo__text">Ortho<em>Supply</em></span><?php endif; ?>
		</a>
		<form class="hdr__search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="Search by product, SKU or brand, e.g. Gemini MBT .022" aria-label="Search products">
			<input type="hidden" name="post_type" value="product">
			<button type="submit" aria-label="Search"><?php echo os_icon( 'search' ); ?></button>
		</form>
		<nav class="hdr__actions" aria-label="Account and cart">
			<a class="hdr__action" href="<?php echo esc_url( home_url( '/quick-order/' ) ); ?>"><?php echo os_icon( 'list' ); ?><span>Quick order</span></a>
			<a class="hdr__action" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php echo os_icon( 'user' ); ?><span><?php echo is_user_logged_in() ? 'Account' : 'Sign in'; ?></span></a>
			<a class="hdr__action cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php echo os_icon( 'cart' ); ?><span>Cart</span><span class="cart-link__count"><?php echo (int) WC()->cart->get_cart_contents_count(); ?></span></a>
			<button class="nav-toggle" type="button" aria-controls="site-nav" aria-expanded="false" aria-label="Menu"><span></span></button>
		</nav>
	</div>
	<div class="hdr__nav">
		<div class="container hdr__nav-in" id="site-nav">
			<div class="catnav" data-catnav>
				<button class="catnav__btn" type="button" aria-expanded="false" aria-controls="catnav-menu"><?php echo os_icon( 'grid' ); ?> All categories <?php echo os_icon( 'chevron' ); ?></button>
				<div class="catnav__menu" id="catnav-menu" hidden>
					<ul>
						<?php foreach ( os_top_categories() as $cat ) : ?>
							<li><a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"><?php echo esc_html( wp_specialchars_decode( $cat->name ) ); ?><small><?php echo (int) $cat->count; ?></small></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<nav class="mainnav" aria-label="Primary"><?php wp_nav_menu( [ 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'mainnav__list', 'fallback_cb' => 'os_default_menu', 'depth' => 1 ] ); ?></nav>
		</div>
	</div>
</header>
<main id="main" class="site-main">
