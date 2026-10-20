<?php get_header(); $title = is_search() ? 'Search: ' . get_search_query() : ( is_home() ? 'News' : wp_strip_all_tags( get_the_archive_title() ) ); ?>
<section class="page-head"><div class="container"><h1 class="page-head__title"><?php echo esc_html( $title ); ?></h1></div></section>
<section class="sec"><div class="container">
<?php if ( have_posts() ) : ?><div class="post-list"><?php while ( have_posts() ) : the_post(); ?><article class="post-item"><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><p><?php echo esc_html( get_the_excerpt() ); ?></p></article><?php endwhile; ?></div><?php the_posts_pagination(); ?>
<?php else : ?><div class="empty"><h2>Nothing found</h2><p>Try the <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">catalogue</a>.</p></div><?php endif; ?>
</div></section>
<?php get_footer();
