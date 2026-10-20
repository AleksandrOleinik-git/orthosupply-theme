<?php defined( 'ABSPATH' ) || exit; $items = os_content( 'faq' ); $schema = [ '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => [] ]; ?>
<div class="faq"><?php foreach ( $items as [ $q, $a ] ) : $schema['mainEntity'][] = [ '@type' => 'Question', 'name' => $q, 'acceptedAnswer' => [ '@type' => 'Answer', 'text' => $a ] ]; ?>
	<details class="faq__item"><summary><?php echo esc_html( $q ); ?><?php echo os_icon( 'chevron' ); ?></summary><div class="faq__answer"><p><?php echo esc_html( $a ); ?></p></div></details>
<?php endforeach; ?></div>
<script type="application/ld+json"><?php echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); ?></script>
