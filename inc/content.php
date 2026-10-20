<?php
/**
 * Static store texts in one place. Filterable: add_filter( 'orthosupply_content_faq', ... ).
 */
defined( 'ABSPATH' ) || exit;

function os_content( string $block ): array {
	static $c = null;
	if ( $c === null ) {
		$c = [
			'company' => [
				'name' => 'OrthoSupply', 'tagline' => 'Orthodontic supplies for clinics and labs',
				'phone' => '+49 30 555 0199', 'phone_href' => '+49305550199', 'email' => 'orders@orthosupply.example',
				'address' => 'Friedrichstraße 123', 'city' => 'Berlin', 'zip' => '10117', 'hours' => 'Mon–Fri 8:30–17:30 CET',
				'free_shipping' => 300, 'cutoff' => '15:00',
			],
			'usps' => [
				[ 'truck', 'Same-day dispatch', 'Orders placed before 15:00 CET ship the same day from our Berlin warehouse.' ],
				[ 'shield', 'Original products only', 'Direct supply from 3M, Ormco, Ortho Organizers, YDM and Accuram with full traceability.' ],
				[ 'tag', 'Clinic pricing', 'Volume discounts from 10 units, net-30 terms for registered practices and labs.' ],
				[ 'chat', 'Specialist support', 'Orthodontic product specialists help you choose systems, slots and sizes by phone or chat.' ],
			],
			'brands' => [ '3M Unitek', 'Ormco', 'Ortho Organizers', 'YDM', 'Accuram', 'Myobrace', 'LM', 'Reliance', 'Dentaurum' ],
			'faq' => [
				[ 'Is there a minimum order?', 'No. Shipping is free on orders over €300 within Germany and over €500 to the rest of the EU; below that a flat €6.90 applies.' ],
				[ 'Do you sell to private individuals?', 'We supply registered dental practices, orthodontists, laboratories, clinics and universities. Create an account and we will verify your practice within one working day.' ],
				[ 'Can I pay on invoice?', 'Yes. Verified practices get net-30 terms after the first paid order. Card, PayPal and bank transfer are available to everyone.' ],
				[ 'How fast is delivery?', 'Germany: 1–2 working days. EU: 2–5 working days with DHL Express. Orders before 15:00 CET leave the same day.' ],
				[ 'Can I return a product?', 'Unopened products in original packaging can be returned within 14 days. Sterile and custom items are excluded.' ],
			],
		];
	}
	return apply_filters( 'orthosupply_content_' . $block, $c[ $block ] ?? [] );
}
