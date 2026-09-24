<?php
/**
 * RIVROSS article metadata for standard WordPress posts.
 *
 * @package Rivross_Corporate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Add the article presentation fields used by the single article layout. */
function rivross_add_news_article_meta_box() {
	add_meta_box(
		'rivross_news_article_details',
		__( 'RIVROSS Article Details', 'rivross-corporate' ),
		'rivross_render_news_article_meta_box',
		'post',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_post', 'rivross_add_news_article_meta_box' );

/** Render optional article presentation fields. */
function rivross_render_news_article_meta_box( $post ) {
	wp_nonce_field( 'rivross_save_news_article', 'rivross_news_article_nonce' );
	$fields = array(
		'author'    => get_post_meta( $post->ID, '_rivross_news_author', true ),
		'intro'     => get_post_meta( $post->ID, '_rivross_news_intro', true ),
		'subheading'=> get_post_meta( $post->ID, '_rivross_news_subheading', true ),
		'callout'   => get_post_meta( $post->ID, '_rivross_news_callout', true ),
	);
	?>
	<p class="description"><?php esc_html_e( 'These optional fields shape the branded single article page. Leave a field blank to use the theme default or the post excerpt.', 'rivross-corporate' ); ?></p>
	<table class="form-table" role="presentation">
		<tr><th><label for="rivross_news_author"><?php esc_html_e( 'Article Author Label', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_news_author" name="rivross_news_author" value="<?php echo esc_attr( $fields['author'] ); ?>" placeholder="RIVROSS Insights"></td></tr>
		<tr><th><label for="rivross_news_intro"><?php esc_html_e( 'Article Intro', 'rivross-corporate' ); ?></label></th><td><textarea class="large-text" rows="3" id="rivross_news_intro" name="rivross_news_intro" placeholder="A short introduction shown below the feature image."><?php echo esc_textarea( $fields['intro'] ); ?></textarea></td></tr>
		<tr><th><label for="rivross_news_subheading"><?php esc_html_e( 'Key Section Heading', 'rivross-corporate' ); ?></label></th><td><input class="regular-text" type="text" id="rivross_news_subheading" name="rivross_news_subheading" value="<?php echo esc_attr( $fields['subheading'] ); ?>" placeholder="A market shaped by confidence and change"></td></tr>
		<tr><th><label for="rivross_news_callout"><?php esc_html_e( 'Article Callout', 'rivross-corporate' ); ?></label></th><td><textarea class="large-text" rows="2" id="rivross_news_callout" name="rivross_news_callout" placeholder="Smart growth starts with a clear view of people, place and opportunity."><?php echo esc_textarea( $fields['callout'] ); ?></textarea></td></tr>
		<?php for ( $trend_index = 1; $trend_index <= 3; $trend_index++ ) : $trend_title = get_post_meta( $post->ID, '_rivross_news_trend_' . $trend_index . '_title', true ); $trend_description = get_post_meta( $post->ID, '_rivross_news_trend_' . $trend_index . '_description', true ); ?>
		<tr><th><label for="rivross_news_trend_<?php echo esc_attr( $trend_index ); ?>_title"><?php printf( esc_html__( 'Key Trend %d', 'rivross-corporate' ), $trend_index ); ?></label></th><td><input class="regular-text" type="text" id="rivross_news_trend_<?php echo esc_attr( $trend_index ); ?>_title" name="rivross_news_trend_<?php echo esc_attr( $trend_index ); ?>_title" value="<?php echo esc_attr( $trend_title ); ?>" placeholder="Connected communities"><textarea class="large-text" rows="2" name="rivross_news_trend_<?php echo esc_attr( $trend_index ); ?>_description" placeholder="Short explanation for this trend."><?php echo esc_textarea( $trend_description ); ?></textarea></td></tr>
		<?php endfor; ?>
	</table>
	<?php
}

/** Save article presentation fields. */
function rivross_save_news_article_meta( $post_id ) {
	if ( ! isset( $_POST['rivross_news_article_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rivross_news_article_nonce'] ) ), 'rivross_save_news_article' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$textarea_fields = array( 'intro', 'callout' );
	$text_fields     = array( 'author', 'subheading' );
	foreach ( $text_fields as $field ) {
		$key   = 'rivross_news_' . $field;
		$value = isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '';
		if ( '' === $value ) {
			delete_post_meta( $post_id, '_rivross_news_' . $field );
		} else {
			update_post_meta( $post_id, '_rivross_news_' . $field, $value );
		}
	}
	foreach ( $textarea_fields as $field ) {
		$key   = 'rivross_news_' . $field;
		$value = isset( $_POST[ $key ] ) ? sanitize_textarea_field( wp_unslash( $_POST[ $key ] ) ) : '';
		if ( '' === $value ) {
			delete_post_meta( $post_id, '_rivross_news_' . $field );
		} else {
			update_post_meta( $post_id, '_rivross_news_' . $field, $value );
		}
	}
	for ( $trend_index = 1; $trend_index <= 3; $trend_index++ ) {
		foreach ( array( 'title', 'description' ) as $field ) {
			$key   = 'rivross_news_trend_' . $trend_index . '_' . $field;
			$value = isset( $_POST[ $key ] ) ? ( 'title' === $field ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : sanitize_textarea_field( wp_unslash( $_POST[ $key ] ) ) ) : '';
			$meta  = '_rivross_news_trend_' . $trend_index . '_' . $field;
			if ( '' === $value ) {
				delete_post_meta( $post_id, $meta );
			} else {
				update_post_meta( $post_id, $meta, $value );
			}
		}
	}
}
add_action( 'save_post_post', 'rivross_save_news_article_meta' );
