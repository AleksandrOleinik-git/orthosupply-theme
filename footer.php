</main>
<?php $c = os_content( 'company' ); ?>
<section class="usps">
	<div class="container usps__grid">
		<?php foreach ( os_content( 'usps' ) as [ $icon, $title, $text ] ) : ?>
			<div class="usp"><?php echo os_icon( $icon, 'usp__icon' ); ?><div><h3><?php echo esc_html( $title ); ?></h3><p><?php echo esc_html( $text ); ?></p></div></div>
		<?php endforeach; ?>
	</div>
</section>
<footer class="ftr">
	<div class="container ftr__grid">
		<div>
			<a class="logo logo--light" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="logo__mark"><?php echo os_icon( 'logo' ); ?></span><span class="logo__text">Ortho<em>Supply</em></span></a>
			<p>Orthodontic supplies for practices, clinics and laboratories across the EU. Original products from 3M, Ormco, Ortho Organizers, YDM and Accuram.</p>
			<p><a href="tel:<?php echo esc_attr( $c['phone_href'] ); ?>"><?php echo esc_html( $c['phone'] ); ?></a><br><a href="mailto:<?php echo esc_attr( $c['email'] ); ?>"><?php echo esc_html( $c['email'] ); ?></a><br><?php echo esc_html( $c['hours'] ); ?></p>
		</div>
		<nav aria-label="Catalogue"><h3>Catalogue</h3><ul><?php foreach ( os_top_categories() as $cat ) : ?><li><a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"><?php echo esc_html( wp_specialchars_decode( $cat->name ) ); ?></a></li><?php endforeach; ?></ul></nav>
		<nav aria-label="Customer service"><h3>Customer service</h3><?php wp_nav_menu( [ 'theme_location' => 'footer', 'container' => false, 'fallback_cb' => 'os_default_menu', 'depth' => 1 ] ); ?></nav>
		<div><h3>Account</h3><ul><li><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">My account</a></li><li><a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>">Order history</a></li><li><a href="<?php echo esc_url( home_url( '/quick-order/' ) ); ?>">Quick order by SKU</a></li><li><a href="<?php echo esc_url( wc_get_cart_url() ); ?>">Cart</a></li></ul>
			<p class="ftr__pay"><span>Visa</span><span>Mastercard</span><span>PayPal</span><span>SEPA</span><span>Invoice</span></p></div>
	</div>
	<div class="container ftr__bottom"><span>© <?php echo (int) gmdate( 'Y' ); ?> <?php echo esc_html( $c['name'] ); ?> GmbH · <?php echo esc_html( $c['address'] . ', ' . $c['zip'] . ' ' . $c['city'] ); ?>. Demo store: no real orders are processed.</span><span><a href="<?php echo esc_url( get_privacy_policy_url() ?: '#' ); ?>">Privacy</a> · <a href="<?php echo esc_url( home_url( '/refund_returns/' ) ); ?>">Returns</a></span></div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
