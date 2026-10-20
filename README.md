# OrthoSupply theme

A clean, fast WooCommerce theme for B2B medical and dental supply stores. No page builder, no jQuery in the theme code, one CSS file on custom properties.

**Live demo:** https://orthosupply.clientus.vip · **Companion plugin:** [orthosupply-quick-order](https://github.com/AleksandrOleinik-git/orthosupply-quick-order)

## What it does

- Store-style header: search by product, SKU or brand; account and cart with live count; "All categories" dropdown built from product categories.
- Home page: hero with category tiles, categories with subcategories, bestsellers and sale blocks (WooCommerce shortcodes), brand strip, FAQ with `FAQPage` schema.
- Catalogue: sidebar with category tree, attribute filters (brand, prescription, slot, material), stock and price filters; custom product cards with SKU, brand, sale and stock badges, AJAX add to cart.
- Product page: gallery, brand and SKU line, price, variations, quantity +/- buttons, trust points, "Specifications" tab from attributes.
- Cart, checkout and account pages styled for the WooCommerce block and classic templates.
- Volume discount rule (5 % from 10 units, 10 % from 50 units of one SKU) as an example of pricing logic in `inc/woocommerce.php`.
- `MedicalBusiness` organisation schema; store texts (USPs, FAQ, company details) live in `inc/content.php` and are filterable.

## Requirements

WordPress 6.4+, WooCommerce 9+, PHP 8.0+.

## License

GPL-2.0-or-later.
