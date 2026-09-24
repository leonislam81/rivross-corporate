<?php
/**
 * Branded single article template.
 *
 * @package Rivross_Corporate
 */

get_header();

while ( have_posts() ) :
	the_post();

	$post_id       = get_the_ID();
	$categories    = get_the_category();
	$category      = ! empty( $categories ) ? $categories[0] : null;
	$category_name = $category ? $category->name : __( 'Insights', 'rivross-corporate' );
	$category_slug = $category ? $category->slug : 'insights';
	$read_time     = get_post_meta( $post_id, '_rivross_read_time', true );
	if ( ! $read_time ) {
		$minutes   = max( 3, (int) ceil( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) );
		$read_time = sprintf( _n( '%d min read', '%d min read', $minutes, 'rivross-corporate' ), $minutes );
	}
	$author       = get_post_meta( $post_id, '_rivross_news_author', true );
	$author       = $author ? $author : get_theme_mod( 'rivross_news_article_author_default', __( 'RIVROSS Insights', 'rivross-corporate' ) );
	$intro        = get_post_meta( $post_id, '_rivross_news_intro', true );
	$intro        = $intro ? $intro : wp_strip_all_tags( get_the_excerpt() );
	$subheading   = get_post_meta( $post_id, '_rivross_news_subheading', true );
	$subheading   = $subheading ? $subheading : get_theme_mod( 'rivross_news_article_subheading', __( 'A market shaped by confidence and change', 'rivross-corporate' ) );
	$callout      = get_post_meta( $post_id, '_rivross_news_callout', true );
	$callout      = $callout ? $callout : get_theme_mod( 'rivross_news_article_callout', __( 'Smart growth starts with a clear view of people, place and opportunity.', 'rivross-corporate' ) );
	$feature_image = get_the_post_thumbnail_url( $post_id, 'full' );
	$feature_image = $feature_image ? $feature_image : get_theme_file_uri( '/assets/images/news/news-hero.png' );
	$archive_url   = get_permalink( get_page_by_path( 'news-media' ) );
	$archive_url   = $archive_url ? $archive_url : home_url( '/news-media/' );

	$trend_defaults = array(
		array( __( 'Connected communities', 'rivross-corporate' ), __( 'People increasingly value locations that bring work, family life and everyday services closer together.', 'rivross-corporate' ) ),
		array( __( 'Efficient, resilient homes', 'rivross-corporate' ), __( 'Thoughtful design, energy performance and reliable delivery are becoming central to long-term value.', 'rivross-corporate' ) ),
		array( __( 'Confidence through clarity', 'rivross-corporate' ), __( 'Clear communication and disciplined planning help clients make confident decisions in a changing market.', 'rivross-corporate' ) ),
	);
	$trends = array();
	for ( $trend_index = 1; $trend_index <= 3; $trend_index++ ) {
		$trend_title       = get_post_meta( $post_id, '_rivross_news_trend_' . $trend_index . '_title', true );
		$trend_description = get_post_meta( $post_id, '_rivross_news_trend_' . $trend_index . '_description', true );
		$trends[]          = array(
			'title'       => $trend_title ? $trend_title : $trend_defaults[ $trend_index - 1 ][0],
			'description' => $trend_description ? $trend_description : $trend_defaults[ $trend_index - 1 ][1],
		);
	}

	$popular_query = new WP_Query(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 3,
			'post__not_in'   => array( $post_id ),
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);
	$related_args = array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
		'post__not_in'   => array( $post_id ),
		'orderby'        => 'date',
		'order'          => 'DESC',
	);
	if ( $category ) {
		$related_args['category__in'] = array( $category->term_id );
	}
	$related_ids = get_posts( array_merge( $related_args, array( 'fields' => 'ids', 'posts_per_page' => 3 ) ) );
	if ( count( $related_ids ) < 3 ) {
		$extra_ids = get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 3 - count( $related_ids ), 'post__not_in' => array_merge( array( $post_id ), $related_ids ), 'orderby' => 'date', 'order' => 'DESC', 'fields' => 'ids' ) );
		$related_ids = array_merge( $related_ids, $extra_ids );
	}
	$related_query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 3, 'post__in' => $related_ids, 'orderby' => 'post__in' ) );
	$share_url   = rawurlencode( get_permalink() );
	$share_title = rawurlencode( get_the_title() );
	?>

	<section class="news-single-hero" style="--news-single-hero-image: url('<?php echo esc_url( $feature_image ); ?>');">
		<div class="rivross-container rivross-container--wide news-single-hero__inner">
			<nav class="news-single-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rivross-corporate' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'rivross-corporate' ); ?></a><span aria-hidden="true">/</span>
				<a href="<?php echo esc_url( $archive_url ); ?>"><?php esc_html_e( 'News & Media', 'rivross-corporate' ); ?></a><span aria-hidden="true">/</span><span><?php echo esc_html( $category_name ); ?></span>
			</nav>
			<div class="news-single-hero__copy">
				<span class="rivross-eyebrow"><?php echo esc_html( $category_name ); ?></span>
				<h1><?php the_title(); ?></h1>
				<div class="news-single-hero__meta"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo rivross_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( get_the_date( 'M d, Y' ) ); ?></time><span><?php echo rivross_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $read_time ); ?></span></div>
				<p><?php echo esc_html( $intro ); ?></p>
			</div>
		</div>
	</section>

	<section class="news-single-main">
		<div class="rivross-container rivross-container--wide news-single-layout">
			<article <?php post_class( 'news-article' ); ?> id="post-<?php the_ID(); ?>">
				<figure class="news-article__feature">
					<?php if ( has_post_thumbnail() ) : ?><?php the_post_thumbnail( 'full', array( 'loading' => 'eager' ) ); ?><?php else : ?><img src="<?php echo esc_url( $feature_image ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="eager"><?php endif; ?>
				</figure>
				<div class="news-article__body">
					<span class="rivross-eyebrow"><?php esc_html_e( 'Market perspective', 'rivross-corporate' ); ?></span>
					<h2><?php echo esc_html( $subheading ); ?></h2>
					<div class="news-article__content"><?php the_content(); ?></div>
					<section class="news-article__trends" aria-labelledby="news-trends-title">
						<h3 id="news-trends-title"><?php esc_html_e( 'Three trends to watch', 'rivross-corporate' ); ?></h3>
						<?php foreach ( $trends as $index => $trend ) : ?><div class="news-trend"><span class="news-trend__number"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span><div><h4><?php echo esc_html( $trend['title'] ); ?></h4><p><?php echo esc_html( $trend['description'] ); ?></p></div></div><?php endforeach; ?>
					</section>
					<blockquote class="news-article__callout"><?php echo esc_html( $callout ); ?></blockquote>
					<h3><?php esc_html_e( 'What this means for investors', 'rivross-corporate' ); ?></h3>
					<p><?php esc_html_e( 'The strongest opportunities will be supported by a clear understanding of place, people and purpose. As the market evolves, careful research and dependable partners help turn positive signals into lasting value.', 'rivross-corporate' ); ?></p>
					<div class="news-article__share"><strong><?php esc_html_e( 'Share this insight', 'rivross-corporate' ); ?></strong><div class="news-share-links"><a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo esc_attr( $share_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'rivross-corporate' ); ?>"><?php echo rivross_icon( 'linkedin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr( $share_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on Facebook', 'rivross-corporate' ); ?>"><?php echo rivross_icon( 'facebook' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><a href="https://wa.me/?text=<?php echo esc_attr( rawurlencode( get_the_title() . ' ' . get_permalink() ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on WhatsApp', 'rivross-corporate' ); ?>"><?php echo rivross_icon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a><a href="mailto:?subject=<?php echo esc_attr( $share_title ); ?>&body=<?php echo esc_attr( $share_url ); ?>" aria-label="<?php esc_attr_e( 'Share by email', 'rivross-corporate' ); ?>"><?php echo rivross_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div></div>
				</div>
			</article>

			<aside class="news-single-sidebar">
				<section class="news-sidebar-card news-sidebar-card--details"><h2><?php esc_html_e( 'Article Details', 'rivross-corporate' ); ?></h2><dl><div><dt><?php esc_html_e( 'Published', 'rivross-corporate' ); ?></dt><dd><?php echo esc_html( get_the_date( 'M d, Y' ) ); ?></dd></div><div><dt><?php esc_html_e( 'Category', 'rivross-corporate' ); ?></dt><dd><?php echo esc_html( $category_name ); ?></dd></div><div><dt><?php esc_html_e( 'Reading time', 'rivross-corporate' ); ?></dt><dd><?php echo esc_html( $read_time ); ?></dd></div><div><dt><?php esc_html_e( 'Author', 'rivross-corporate' ); ?></dt><dd><?php echo esc_html( $author ); ?></dd></div></dl></section>
				<section class="news-sidebar-card news-sidebar-card--newsletter"><span class="news-sidebar-card__icon"><?php echo rivross_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><h2><?php esc_html_e( 'Stay Informed', 'rivross-corporate' ); ?></h2><p><?php echo esc_html( get_theme_mod( 'rivross_news_subscribe_text', __( 'Get the latest news and market insights from RIVROSS.', 'rivross-corporate' ) ) ); ?></p><?php echo rivross_newsletter_notice(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><form method="post" action="<?php echo esc_url( $archive_url ); ?>"><?php echo rivross_newsletter_form_fields( 'article' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><label class="screen-reader-text" for="single-newsletter-email"><?php esc_html_e( 'Email address', 'rivross-corporate' ); ?></label><input id="single-newsletter-email" type="email" name="newsletter_email" placeholder="<?php echo esc_attr( get_theme_mod( 'rivross_news_subscribe_placeholder', __( 'Enter your email address', 'rivross-corporate' ) ) ); ?>" required><button class="rivross-button" type="submit"><?php echo esc_html( get_theme_mod( 'rivross_news_subscribe_button', __( 'Subscribe', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button></form></section>
				<?php if ( $popular_query->have_posts() ) : ?><section class="news-sidebar-card news-sidebar-card--popular"><h2><?php echo esc_html( get_theme_mod( 'rivross_news_popular_title', __( 'Popular Insights', 'rivross-corporate' ) ) ); ?></h2><div class="news-popular-list"><?php while ( $popular_query->have_posts() ) : $popular_query->the_post(); ?><a class="news-popular-item" href="<?php the_permalink(); ?>"><span class="news-popular-item__date"><?php echo esc_html( get_the_date( 'M d, Y' ) ); ?></span><strong><?php the_title(); ?></strong><span><?php esc_html_e( 'Read insight', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span></a><?php endwhile; wp_reset_postdata(); ?></div></section><?php endif; ?>
			</aside>
		</div>
	</section>

	<?php if ( $related_query->have_posts() ) : ?><section class="news-related"><div class="rivross-container rivross-container--wide"><div class="news-related__heading"><div><span class="rivross-eyebrow"><?php esc_html_e( 'Keep exploring', 'rivross-corporate' ); ?></span><h2><?php echo esc_html( get_theme_mod( 'rivross_news_related_title', __( 'Related Insights', 'rivross-corporate' ) ) ); ?></h2></div><a href="<?php echo esc_url( $archive_url ); ?>"><?php esc_html_e( 'View All News', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div><div class="news-related-grid"><?php while ( $related_query->have_posts() ) : $related_query->the_post(); $related_categories = get_the_category(); $related_category = ! empty( $related_categories ) ? $related_categories[0] : null; $related_read_time = get_post_meta( get_the_ID(), '_rivross_read_time', true ); ?><article class="news-related-card"><a class="news-related-card__media" href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); } ?></a><div class="news-related-card__body"><?php if ( $related_category ) : ?><span class="news-card__category news-card__category--<?php echo esc_attr( $related_category->slug ); ?>"><?php echo esc_html( $related_category->name ); ?></span><?php endif; ?><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><div class="news-card__meta"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo rivross_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( get_the_date( 'M d, Y' ) ); ?></time><?php if ( $related_read_time ) : ?><span><?php echo rivross_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $related_read_time ); ?></span><?php endif; ?></div><a class="news-card__read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'rivross-corporate' ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></div></article><?php endwhile; wp_reset_postdata(); ?></div></div></section><?php endif; ?>

	<section class="news-single-newsletter"><div class="rivross-container rivross-container--wide news-single-newsletter__inner"><div class="news-newsletter__icon" aria-hidden="true"><?php echo rivross_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div><div class="news-newsletter__copy"><h2><?php echo esc_html( get_theme_mod( 'rivross_news_subscribe_title', __( 'Stay Updated with RIVROSS', 'rivross-corporate' ) ) ); ?></h2><p><?php echo esc_html( get_theme_mod( 'rivross_news_subscribe_text', __( 'Subscribe to our newsletter and get the latest news, insights and exclusive updates straight to your inbox.', 'rivross-corporate' ) ) ); ?></p></div><?php echo rivross_newsletter_notice(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><form class="news-newsletter__form" method="post" action="<?php echo esc_url( $archive_url ); ?>"><?php echo rivross_newsletter_form_fields( 'article' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><label class="screen-reader-text" for="single-newsletter-email-bottom"><?php esc_html_e( 'Email address', 'rivross-corporate' ); ?></label><input id="single-newsletter-email-bottom" type="email" name="newsletter_email" placeholder="<?php echo esc_attr( get_theme_mod( 'rivross_news_subscribe_placeholder', __( 'Enter your email address', 'rivross-corporate' ) ) ); ?>" required><button class="rivross-button" type="submit"><?php echo esc_html( get_theme_mod( 'rivross_news_subscribe_button', __( 'Subscribe', 'rivross-corporate' ) ) ); ?> <?php echo rivross_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button><small><?php esc_html_e( 'We respect your privacy. Unsubscribe at any time.', 'rivross-corporate' ); ?></small></form></div></section>
<?php endwhile; ?>

<?php get_footer(); ?>
