<?php
/* 6Oct15 zig - add default backgound for no posts to be the same as the service background 
*/
// general styles
$custom_pattern = get_theme_mod( 'front_bg_pattern_custom', false );
$pattern        = false;


// specific styles
/* if ( 'services' == get_post_type() && ! is_single() ) { */
	echo '<!-- zig:  title area: post_type = '.get_post_type()." for id:  ".get_the_ID()."-->";
if ( 'services' == get_post_type() || (get_the_ID() == 0) || ('team' == get_post_type()) ){ 
	$title_bg = ot_get_option( 'services_bg', '' );
} elseif ( 'gallery' == get_post_type() ) {
	$title_bg = get_post_meta( get_the_ID(), 'title_bg', true );

	if ( ! is_single() || empty( $title_bg ) ) {
		$title_bg = ot_get_option( 'gallery_bg', '' );
	}
} elseif ( 'team' == get_post_type() ) {
	$title_bg = ot_get_option( 'team_bg', '' );
} elseif ( is_404() ) {
	$title_bg = get_post_meta( (int)get_option( 'page_for_posts' ), 'title_bg', true );
} elseif ( is_home() || ( is_single() && 'post' === get_post_type() ) || is_category() || is_tag() || is_search() ) {
	$title_bg = get_post_meta( (int)get_option( 'page_for_posts' ), 'title_bg', true );
} elseif ( is_woocommerce_active() && is_woocommerce() ) {
	$title_bg = get_post_meta( (int)get_option( 'woocommerce_shop_page_id' ), 'title_bg', true );
} else {
	$title_bg = get_post_meta( get_the_ID(), 'title_bg', true );
}

if ( $title_bg ) {
	$style_attr = create_style_attr( $title_bg );
	$class_attr = '';
} else {
	if ( empty( $custom_pattern ) ) {
		$style_attr = '';
		$class_attr = get_theme_mod( 'front_bg_pattern', false );
	} else {
		$style_attr = sprintf('style="background-image: url(%s);"', $custom_pattern);
		$class_attr = '';
	}
}


?>

<div class="title-area <?php echo $class_attr; ?>" <?php echo $style_attr; ?>>
	<?php if ( ! is_404() ): ?>
	<div class="container">
		<div class="row">
			<div class="span9">
				<?php
				if ( is_home() ) {
					$title = ot_get_option( 'blog_page_title', get_bloginfo( 'title' ) );
				} elseif ( is_category() ) {
					$title = __( 'Category' , 'carpress_wp') . ': ' . single_cat_title( '', false );
				} elseif ( is_tag() ) {
					$title = __( 'Tag' , 'carpress_wp') . ': ' . single_tag_title( '', false );
				} elseif ( is_search() ) {
					$title = __( 'Search Results For' , 'carpress_wp') . ' &quot;' . get_search_query() . '&quot;';
				} elseif ( 'services' == get_post_type() ) {
					$title = ot_get_option( 'services_page_title', __( 'Services' , 'carpress_wp') );
				} elseif ( 'gallery' == get_post_type() ) {
					$title = ot_get_option( 'gallery_page_title', __( 'Gallery' , 'carpress_wp') );
				} elseif ( 'team' == get_post_type() ) {
					$title = ot_get_option( 'team_page_title', __( 'Meet the Team' , 'carpress_wp') );
				} elseif ( is_woocommerce_active() && is_woocommerce() ) {
					ob_start();
					woocommerce_page_title();
					$title = ob_get_contents();
					ob_end_clean();
				} else {
					$title = get_the_title();
				}

				?>
				<h1><?php echo strip_tags( $title ); ?></h1>
			</div>
			<?php get_template_part( 'social-icons' ); ?>
		</div>
	</div>
	<?php endif ?>
</div>