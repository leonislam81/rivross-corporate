<?php
/**
 * Generic WordPress page template.
 *
 * @package Rivross_Corporate
 */

get_header();
?>

<section class="rivross-page-shell">
	<div class="rivross-container rivross-container--wide">
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class( 'rivross-page' ); ?> id="post-<?php the_ID(); ?>">
				<header class="rivross-page__header">
					<h1><?php the_title(); ?></h1>
				</header>
				<div class="rivross-page__content">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	</div>
</section>

<?php get_footer();
