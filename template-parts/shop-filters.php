<?php
/**
 * Shop sidebar: category tree and attribute filters (WooCommerce's layered nav via ?filter_<attr>=).
 */
defined( 'ABSPATH' ) || exit;
$current = is_tax( 'product_cat' ) ? get_queried_object() : null;
$top     = os_top_categories();
$attrs   = [ 'pa_brand' => 'Brand', 'pa_prescription' => 'Prescription', 'pa_slot' => 'Slot', 'pa_material' => 'Material' ];
$base    = $current ? get_term_link( $current ) : wc_get_page_permalink( 'shop' );
?>
<aside class="shop__side">
	<button class="btn btn--ghost shop__filters-toggle" type="button" aria-expanded="false" aria-controls="shop-filters" data-filters-toggle><?php echo os_icon( 'filter' ); ?> Filters</button>
	<div class="shop__filters" id="shop-filters">
		<div class="filterblock">
			<h3>Categories</h3>
			<ul class="cattree">
				<?php foreach ( $top as $cat ) : $active = $current && ( $current->term_id === $cat->term_id || $current->parent === $cat->term_id ); ?>
					<li class="<?php echo $active ? 'is-active' : ''; ?>"><a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"><?php echo esc_html( wp_specialchars_decode( $cat->name ) ); ?><small><?php echo (int) $cat->count; ?></small></a>
						<?php if ( $active ) : $children = get_terms( [ 'taxonomy' => 'product_cat', 'parent' => $cat->term_id, 'hide_empty' => true ] ); if ( $children && ! is_wp_error( $children ) ) : ?>
							<ul><?php foreach ( $children as $ch ) : ?><li class="<?php echo $current->term_id === $ch->term_id ? 'is-active' : ''; ?>"><a href="<?php echo esc_url( get_term_link( $ch ) ); ?>"><?php echo esc_html( wp_specialchars_decode( $ch->name ) ); ?><small><?php echo (int) $ch->count; ?></small></a></li><?php endforeach; ?></ul>
						<?php endif; endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<form class="filterform" method="get" action="<?php echo esc_url( $base ); ?>" data-filterform>
			<?php foreach ( $attrs as $tax => $label ) : $terms = get_terms( [ 'taxonomy' => $tax, 'hide_empty' => true ] ); if ( ! $terms || is_wp_error( $terms ) ) { continue; } $key = 'filter_' . str_replace( 'pa_', '', $tax ); $sel = isset( $_GET[ $key ] ) ? explode( ',', sanitize_text_field( wp_unslash( $_GET[ $key ] ) ) ) : []; ?>
				<fieldset class="filterblock"><legend><?php echo esc_html( $label ); ?></legend>
					<?php foreach ( $terms as $t ) : ?><label><input type="checkbox" name="<?php echo esc_attr( $key ); ?>[]" value="<?php echo esc_attr( $t->slug ); ?>" <?php checked( in_array( $t->slug, $sel, true ) ); ?>> <?php echo esc_html( wp_specialchars_decode( $t->name ) ); ?><small><?php echo (int) $t->count; ?></small></label><?php endforeach; ?>
				</fieldset>
			<?php endforeach; ?>
			<fieldset class="filterblock"><legend>Availability</legend><label><input type="checkbox" name="stock_status" value="instock" <?php checked( isset( $_GET['stock_status'] ) ); ?>> In stock only</label></fieldset>
			<fieldset class="filterblock filterblock--price"><legend>Price, €</legend><div><input type="number" name="min_price" placeholder="0" min="0" value="<?php echo esc_attr( sanitize_text_field( wp_unslash( $_GET['min_price'] ?? '' ) ) ); ?>" aria-label="Min price"><input type="number" name="max_price" placeholder="500" min="0" value="<?php echo esc_attr( sanitize_text_field( wp_unslash( $_GET['max_price'] ?? '' ) ) ); ?>" aria-label="Max price"></div></fieldset>
			<?php if ( isset( $_GET['orderby'] ) ) : ?><input type="hidden" name="orderby" value="<?php echo esc_attr( sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) ); ?>"><?php endif; ?>
			<div class="filterform__actions"><button class="btn btn--primary" type="submit">Apply</button><a class="btn btn--ghost" href="<?php echo esc_url( $base ); ?>">Reset</a></div>
		</form>
	</div>
</aside>
