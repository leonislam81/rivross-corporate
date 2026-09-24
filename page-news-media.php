<?php
/**
 * News & Media archive page template.
 *
 * @package Rivross_Corporate
 */

get_header();

$hero_image       = get_theme_mod( 'rivross_news_hero_image', get_theme_file_uri( '/assets/images/news/news-hero.png' ) );
$breadcrumb_home  = get_theme_mod( 'rivross_news_breadcrumb_home', __( 'Home', 'rivross-corporate' ) );
$archive_page_id  = is_home() ? (int) get_option( 'page_for_posts' ) : get_queried_object_id();
$archive_page_title = $archive_page_id ? get_the_title( $archive_page_id ) : __( 'News & Media', 'rivross-corporate' );
$breadcrumb_page  = get_theme_mod( 'rivross_news_breadcrumb_page', $archive_page_title );
$hero_line_1      = get_theme_mod( 'rivross_news_hero_line_1', __( 'News & Insights', 'rivross-corporate' ) );
$hero_line_2      = get_theme_mod( 'rivross_news_hero_line_2', __( 'Stay Informed, Stay Ahead', 'rivross-corporate' ) );
$hero_description = get_theme_mod( 'rivross_news_hero_description', __( 'Explore the latest updates, market trends, company announcements and real estate insights from RIVROSS and the industry.', 'rivross-corporate' ) );
$page_url         = $archive_page_id ? get_permalink( $archive_page_id ) : home_url( '/' );
$page_url         = $page_url ? $page_url : home_url( '/' );
$search_term      = isset( $_GET['news_s'] ) ? sanitize_text_field( wp_unslash( $_GET['news_s'] ) ) : '';
$category_slug    = isset( $_GET['news_cat'] ) ? sanitize_title( wp_unslash( $_GET['news_cat'] ) ) : '';
$current_page     = max( 1, get_query_var( 'paged' ), isset( $_GET['news_page'] ) ? absint( $_GET['news_page'] ) : 1 );

$category_icons = array(
	'project-updates' => 'building',
	'market-insights' => 'chart',
	'company-news'    => 'users',
	'sustainability' => 'leaf',
	'lifestyle'      => 'hotel',
	'events'         => 'award',
	'tea-business'   => 'leaf',
	'travel-tourism' => 'plane',
);
$category_terms = get_terms( array( 'taxonomy' => 'category', 'hide_empty' => true ) );
if ( is_wp_error( $category_terms ) ) {
	$category_terms = array();
}
$preferred_order = array( 'company-news', 'market-insights', 'project-updates', 'sustainability', 'lifestyle', 'events', 'tea-business', 'travel-tourism' );
$terms_by_slug   = array();
foreach ( $category_terms as $term ) {
	$terms_by_slug[ $term->slug ] = $term;
}
$ordered_terms = array();
foreach ( $preferred_order as $slug ) {
	if ( isset( $terms_by_slug[ $slug ] ) ) {
		$ordered_terms[] = $terms_by_slug[ $slug ];
		unset( $terms_by_slug[ $slug ] );
	}
}
$category_terms = array_merge( $ordered_terms, array_values( $terms_by_slug ) );

$query_args = array(
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => 8,
	'paged'          => $current_page,
	'orderby'        => 'date',
	'order'          => 'DESC',
);
if ( '' !== $search_term ) {
	$query_args['s'] = $search_term;
}
if ( '' !== $category_slug ) {
	$query_args['category_name'] = $category_slug;
}
$news_query = new WP_Query( $query_args );

$filter_url = function ( $slug = '' ) use ( $page_url, $search_term ) {
	$args = array();
	if ( '' !== $slug ) {
		$args['news_cat'] = $slug;
	}
	if ( '' !== $search_term ) {
		$args['news_s'] = $search_term;
	}
	return add_query_arg( $args, $page_url );
};

$pagination_args = array();
if ( '' !== $search_term ) {
	$pagination_args['news_s'] = $search_term;
}
if ( '' !== $category_slug ) {
	$pagination_args['news_cat'] = $category_slug;
}
$pagination_base = add_query_arg( 'news_page', 999999999, $page_url );
$pagination_base = str_replace( '999999999', '%#%', $pagination_base );
$pagination      = paginate_links(
	array(
		'base'      => $pagination_base,
		'format'    => '',
		'current'   => $current_page,
		'total'     => max( 1, (int) $news_query->max_num_pages ),
		'mid_size'  => 1,
		'end_size'  => 1,
		'prev_next' => false,
		'add_args'  => $pagination_args,
		'type'      => 'array',
	)
 );
?>

<section class="news-hero" style="--news-hero-image: url('<?php echo esc_url( $hero_image ); ?>');">
	<div class="rivross-container rivross-container--wide news-hero__inner">
		<nav class="news-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rivross-corporate' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $breadcrumb_home ); ?></a>
			<span aria-hidden="true">/</span>
			<span><?php echo esc_html( $breadcrumb_page ); ?></span>
		</nav>
		<div class="news-hero__copy">
			<h1><span><?php echo esc_html( $hero_line_1 ); ?></span><strong><?php echo esc_html( $hero_line_2 ); ?></strong></h1>
			<span class="news-hero__rule"></span>
			<p><?php echo esc_html( $hero_description ); ?></p>
		</div>
	</div>
</section>

<section class="news-archive" aria-label="<?php esc_attr_e( 'News archive', 'rivross-corporate' ); ?>">
	<div class="rivross-container rivross-container--wide">
		<section class="news-filters" aria-label="<?php esc_attr_e( 'News filters', 'rivross-corporate' ); ?>">
			<nav class="news-categories" aria-label="<?php esc_attr_e( 'News categories', 'rivross-corporate' ); ?>">
				<a class="news-category<?php echo '' === $category_slug ? ' is-active' : ''; ?>" href="<?php echo esc_url( $filter_url() ); ?>">
					<span class="news-category__icon"><?php echo rivross_icon( 'grid' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<span><?php echo esc_html( get_theme_mod( 'rivross_news_all_label', __( 'All News', 'rivross-corporate' ) ) ); ?></span>
				</a>
				<?php foreach ( $category_terms as $term ) : $icon = isset( $category_icons[ $term->slug ] ) ? $category_icons[ $term->slug ] : 'folder'; ?>
					<a class="news-category<?php echo $category_slug === $term->slug ? ' is-active' : ''; ?>" href="<?php echo esc_url( $filter_url( $term->slug ) ); ?>">
						<span class="news-category__icon"><?php echo rivross_icon( rivross_sanitize_icon_choice( $icon ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<span><?php echo esc_html( $term->name ); ?></span>
					</a>
				<?php endforeach; ?>
			</nav>
			<form class="news-search" role="search" method="get" action="<?php echo esc_url( $page_url ); ?>">
				<?php if ( '' !== $category_slug ) : ?><input type="hidden" name="news_cat" value="<?php echo esc_attr( $category_slug ); ?>"><?php endif; ?>
				<label class="screen-reader-text" for="news-search-input"><?php esc_html_e( 'Search articles', 'rivross-corporate' ); ?></label>
				<input id="news-search-input" type="search" name="news_s" value="<?php echo esc_attr( $search_term ); ?>" placeholder="<?php echo esc_attr( get_theme_mod( 'rivross_news_search_placeholder', __( 'Search articles...', 'rivross-corporate' ) ) ); ?>">
				<button type="submit" aria-label="<?php esc_attr_e( 'Search articles', 'rivross-corporate' ); ?>"><?php echo rivross_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
			</form>
		</section>

		<?php if ( $news_query->have_posts() ) : ?>
			<section class="news-grid" aria-label="<?php esc_attr_e( 'News articles', 'rivross-corporate' ); ?>">
				<?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
					<?php
					$categories = get_the_category();
					$category   = ! empty( $categories ) ? $categories[0] : null;
					$category_slug_for_card = $category ? $category->slug : 'company-news';
					$read_time  = get_post_meta( get_the_ID(), '_rivross_read_time', true );
					if ( ! $read_time ) {
						$minutes   = max( 3, (int) ceil( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) );
						$read_time = sprintf( _n( '%d min read', '%d min read', $minutes, 'rivross-corporate' ), $minutes );
					}
					?>
					<article <?php post_class( 'news-card' ); ?>>
						<a class="news-card__media" href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?>
							<?php else : ?>
								<span class="news-card__media-placeholder" aria-hidden="true"><?php echo rivross_icon( 'news' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							<?php endif; ?>
						</a>
						<div class="news-card__body">
							<?php if ( $category ) : ?><a class="news-card__category news-card__category--<?php echo esc_attr( $category_slug_for_card ); ?>" href="<?php echo esc_url( $filter_url( $category_slug_for_card ) ); ?>"><?php echo esc_html( $category->name ); ?></a><?php endif; ?>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 23, '…' ) ); ?></p>
							<div class="news-card__meta">
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo rivross_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( get_the_date( 'M d, Y' ) ); ?></time>
								<span><?php echo rivross_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $read_time ); ?></span>
							</div>
							<a class="news-card__read-more" href="<?php the_permalink(); ?>"><?php echo esc_html( get_theme_mod( 'rivross_news_read_more_label', __( 'Read More', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
						</div>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			</section>
		<?php else : ?>
			<div class="news-empty"><h2><?php esc_html_e( 'No articles found', 'rivross-corporate' ); ?></h2><p><?php esc_html_e( 'Try another keyword or choose a different category.', 'rivross-corporate' ); ?></p></div>
		<?php endif; ?>

		<?php if ( ! empty( $pagination ) && $news_query->max_num_pages > 1 ) : ?>
			<nav class="news-pagination" aria-label="<?php esc_attr_e( 'News pagination', 'rivross-corporate' ); ?>">
				<?php foreach ( $pagination as $page_link ) : ?><?php echo wp_kses_post( $page_link ); ?><?php endforeach; ?>
				<?php if ( $current_page < $news_query->max_num_pages ) : ?><a class="news-pagination__next" href="<?php echo esc_url( add_query_arg( array_merge( $pagination_args, array( 'news_page' => $current_page + 1 ) ), $page_url ) ); ?>"><?php esc_html_e( 'Next', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><?php endif; ?>
			</nav>
		<?php endif; ?>
	</div>
</section>

<section class="news-newsletter">
	<div class="rivross-container rivross-container--wide news-newsletter__inner">
		<div class="news-newsletter__icon" aria-hidden="true"><?php echo rivross_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		<div class="news-newsletter__copy">
			<h2><?php echo esc_html( get_theme_mod( 'rivross_news_subscribe_title', __( 'Stay Updated with RIVROSS', 'rivross-corporate' ) ) ); ?></h2>
			<p><?php echo esc_html( get_theme_mod( 'rivross_news_subscribe_text', __( 'Subscribe to our newsletter and get the latest news, insights and exclusive updates straight to your inbox.', 'rivross-corporate' ) ) ); ?></p>
		</div>
		<?php echo rivross_newsletter_notice(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<form class="news-newsletter__form" method="post" action="<?php echo esc_url( $page_url ); ?>">
			<?php echo rivross_newsletter_form_fields( 'news' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<label class="screen-reader-text" for="news-newsletter-email"><?php esc_html_e( 'Email address', 'rivross-corporate' ); ?></label>
			<input id="news-newsletter-email" type="email" name="newsletter_email" placeholder="<?php echo esc_attr( get_theme_mod( 'rivross_news_subscribe_placeholder', __( 'Enter your email address', 'rivross-corporate' ) ) ); ?>" required>
			<button class="rivross-button" type="submit"><?php echo esc_html( get_theme_mod( 'rivross_news_subscribe_button', __( 'Subscribe', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
			<small><?php esc_html_e( 'We respect your privacy. Unsubscribe at any time.', 'rivross-corporate' ); ?></small>
		</form>
	</div>
</section>

<?php get_footer(); ?>
