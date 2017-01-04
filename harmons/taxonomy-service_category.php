<?php /* modifications: 
	7Aug15 - show category description 
	2Sept15 - display featured image, title, exceprt in 2 columns.
*/ ?>
<?php get_header(); ?>

	<?php get_template_part( 'titlearea' ); ?>

	<?php get_template_part( 'breadcrumbs' ); ?>

	<div class="main-content"><!-- taxonomy-service_category -->
		<div class="container">
			<div class="row">
				<?php
					$sidebar = ot_get_option( 'services_layout', 'left' );

					if ( "no" == $sidebar ) {
						$main_class_span = 12;
						$service_class_span = 6;
					} else {
						$main_class_span = 9;
						$service_class_span = 4;
					}

					if ( "left" == $sidebar ) {
				?>
				<div class="span3">
					<div class="left sidebar">
						<?php dynamic_sidebar( 'services-sidebar' ); ?>
					</div>
				</div>
				<?php } ?>

				<?php
					$params = array_merge( $wp_query->query_vars, array(
						'orderby' => 'menu_order',
						'nopaging' => true,
						'order' => 'ASC'
					) );
					query_posts( $params );

				?>

				<div class="span<?php echo $main_class_span; ?>">
					<div class="row">
						
						<?php  /* category description */
							$cat_title = single_cat_title('', false);
							echo '<div class="span'.$main_class_span.'">';
							echo   '<div class="lined">';
							
							echo     '<h2>'.$cat_title.'</h2>';
							echo   '</div>';
							echo   '<div class="row with-margin">';
							echo 	  '<div class="span'.$main_class_span.'">';
							echo 	     category_description();
							echo       '</div>';
							echo    '</div>';
							echo '</div>';
						?>
						<?php if ( have_posts() ) :
								$num_services = 0;
								while ( have_posts() ) :
									the_post();
									$num_services ++;
						?>
							<?php /* */ ?>
							<div class="span<?php echo $service_class_span; ?> service-wrap">
								<div class="service-title-wrap lined lined-short">
									<div class="service-icon">
										<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'services-icon' ); ?></a>
									</div>
									<h2 class="service-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<?php
										$subtitle = get_post_meta( get_the_ID(), 'subtitle', true );
										if ( ! empty( $subtitle ) ) :
									?>
									<h5><?php echo $subtitle; ?></h5>
									<?php endif; ?>
									<?php /* <span class="bolded-line"></span> */ ?>
								</div>
								<div class="service-excerpt-wrap">
									<?php the_excerpt(); ?>
								</div>
								
							</div><!-- /service -->

							<?php  if ($num_services % 2 == 0)  { ?>
								<div class="span<?php echo $main_class_span; ?>">
									<?php /* <div class="divide-line">
										<div class="icon icons-<?php echo $content_divider; ?>"></div>
									</div> */ ?>
								</div> 
							<?php  } ?>

						<?php endwhile; else : ?>
							<?php /* <div class="span<?php echo $main_class_span; ?>">
								 <div class="lined">
									<h2><?php _e( 'Not Found' , 'carpress_wp'); ?></a></h2>
									<span class="bolded-line"></span>
								</div> 
								<p><?php _e( 'Page not found' , 'carpress_wp'); ?></p>
							</div> */ ?>
						<?php endif; ?>

					</div>
				</div><!-- /blog -->

				<?php
					if ( "right" == $sidebar ) {
				?>
				<div class="span3">
					<div class="right sidebar">
						<?php dynamic_sidebar( 'services-sidebar' ); ?>
					</div>
				</div>
				<?php } ?>


			</div><!-- / -->
		</div><!-- /container -->
	</div>

<?php get_footer(); ?>
