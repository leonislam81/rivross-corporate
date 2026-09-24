<?php
/**
 * Theme fallback template.
 *
 * @package Rivross_Corporate
 */

get_header();
?>

<div class="rivross-container" style="padding-block: 5rem;">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<h1><?php esc_html_e( 'RIVROSS Corporate', 'rivross-corporate' ); ?></h1>
		<p><?php esc_html_e( 'The custom homepage is being prepared from the approved design system.', 'rivross-corporate' ); ?></p>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
