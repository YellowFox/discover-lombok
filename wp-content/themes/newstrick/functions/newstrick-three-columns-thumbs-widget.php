<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Three Columns Thumbs Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget that show recent posts by categories with thumbs
 	Version: 1.0
 	Author: ZERGE
 	Author URI:  http://www.color-theme.com
 
-----------------------------------------------------------------------------------
*/

/**
 * Add function to widgets_init that'll load our widget.
 */

add_action('widgets_init', 'ct_3columns_load_widgets');

function ct_3columns_load_widgets()
{
	register_widget('CT_3Columns_Widget');
}

/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update. 
 *
 */
class CT_3Columns_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */		
	function CT_3Columns_Widget()
	{
		/* Widget settings. */
		$widget_ops = array('classname' => 'ct_3columns_widget', 'description' => __( 'Three Columns Thumbs Widget (show recent posts).' , 'color-theme-framework' ) );
		
		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ct_3columns_widget' );
		
		/* Create the widget. */
		$this->WP_Widget( 'ct_3columns_widget', __( 'CT: Three Columns Magazine Widget' , 'color-theme-framework' ), $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);

		$title = $instance['title'];
		$categories = $instance['categories'];
		$posts = $instance['posts'];
		$show_image = isset($instance['show_image']) ? 'true' : 'false';
		$show_likes = isset($instance['show_likes']) ? 'true' : 'false';
		$show_comments = isset($instance['show_comments']) ? 'true' : 'false';
		$show_views = isset($instance['show_views']) ? 'true' : 'false';
		$show_date = isset($instance['show_date']) ? 'true' : 'false';
		$show_category = isset($instance['show_category']) ? 'true' : 'false';
		$excerpt_lenght = $instance['excerpt_lenght'];
		$video_height = $instance['video_height'];
		$background_title = $instance['background_title'];

		$title2 = $instance['title2'];
		$categories2 = $instance['categories2'];
		$posts2 = $instance['posts2'];
		$show_image2 = isset($instance['show_image2']) ? 'true' : 'false';
		$show_likes2 = isset($instance['show_likes2']) ? 'true' : 'false';
		$show_comments2 = isset($instance['show_comments2']) ? 'true' : 'false';
		$show_views2 = isset($instance['show_views2']) ? 'true' : 'false';
		$show_date2 = isset($instance['show_date2']) ? 'true' : 'false';
		$show_category2 = isset($instance['show_category2']) ? 'true' : 'false';
		$excerpt_lenght2 = $instance['excerpt_lenght2'];
//		$video_height2 = $instance['video_height2'];
		$background_title2 = $instance['background_title2'];		

		$title3 = $instance['title3'];
		$categories3 = $instance['categories3'];
		$posts3 = $instance['posts3'];
		$show_image3 = isset($instance['show_image3']) ? 'true' : 'false';
		$show_likes3 = isset($instance['show_likes3']) ? 'true' : 'false';
		$show_comments3 = isset($instance['show_comments3']) ? 'true' : 'false';
		$show_views3 = isset($instance['show_views3']) ? 'true' : 'false';
		$show_date3 = isset($instance['show_date3']) ? 'true' : 'false';
		$show_category3 = isset($instance['show_category3']) ? 'true' : 'false';
		$excerpt_lenght3 = $instance['excerpt_lenght3'];
//		$video_height3 = $instance['video_height3'];
		$background_title3 = $instance['background_title3'];	

		$widget_width = $instance['widget_width'];
		$divider_type = $instance['divider_type'];
		$background = $instance['background'];

	 	global $data, $post, $ct_video_height;
	 	$ct_video_height = $video_height;
		?>

		<!-- FIRST COLUMN -->	
		<?php
		  $recent_posts = new WP_Query(array(
		    'showposts' => 1,
			'post_type' => 'post',
			'cat' => $categories,
		  ));
		?>

		<?php
		
		/* Before widget (defined by themes). */
		if ( $title ) { 
			echo "\n<!-- START THREE COLUMNS TUMBS WIDGET -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';">';
		} 
		else {
			echo "\n<!-- START THREE COLUMNS TUMBS WIDGET -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';padding-top: 20px;">';
		}
		?>


		<div class="row-fluid two-column-widget">
	  		<div class="span4">
		    	<?php
				$cat_color = ct_get_color($categories);
				if ( $cat_color == '') { $cat_color = '#000'; }

				if ( $categories != 'all' ):
					$category_title_link = get_category_link( $categories );
					echo '<div class="widget-title bottom-shadow" style="background:' . $cat_color .';"><h2><a href="'.$category_title_link.'" title="'.__('View all posts in ','color-theme-framework').$title.'">'.$title.'</a></h2><div class="arrow-down" style="border-top-color:' . $cat_color . ';"></div><!-- .arrow-down --><div class="plus"><a href="'.$category_title_link.'" title="'.__('View all posts in ','color-theme-framework').$title.'"><span></span></a></div><!-- .plus --></div><!-- widget-title -->';
				else :
					echo '<div class="widget-title bottom-shadow" style="background:' . $background_title .';"><h2>' . $title . '</h2><div class="arrow-down" style="border-top-color:' . $background_title . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->';
				endif;
				?>

				<?php while($recent_posts->have_posts()): $recent_posts->the_post();  

					// get post format
	  				$ct_format = get_post_format();
	  
	  				if ( false === $ct_format ) {
	      				$format = 'standard';
	  				} else {
		  				$format = $ct_format;
	  				}

		  			//Get post type: standard post or review
					$post_type = get_post_meta($post->ID, 'ct_mb_post_type', true);
					if( $post_type == '' ) $post_type = 'standard_post';
					?>

					<div class="<?php echo $format . " " . $post_type; ?>">

	  	  				<?php
	  
	  					// if Video post format
	  					if ( $ct_format == 'video' ) : get_template_part( 'includes/widget', $ct_format );

	    				// if Audio post format
	  					elseif( $ct_format == 'audio' ): get_template_part( 'includes/widget', $ct_format );

	  					// if Gallery post format	
	  					elseif( $ct_format == 'gallery' ): get_template_part( 'includes/widget', $ct_format );

						// if post has Feature image
	  					else:

							if(has_post_thumbnail()) : ?>
	      	  					<div class="widget-post-big-thumb ct-preload">
		        					<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'post-thumb'); ?>	
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
		  	  					</div><!-- .widget-post-big-thumb -->
	    					<?php
	    					endif; //has_post_thumbnail

	  					endif; ?>

		  				<!-- different meta style if no thumbnail -->
		  				<?php if(has_post_thumbnail() or ($ct_format == 'audio') or ($ct_format == 'video') or ($ct_format == 'gallery') ): ?>

		  					<!-- with thumbnail -->
	        				<div class="meta-posted-by muted-small" style="border-top: 3px solid <?php echo $cat_color; ?>;">
		        				<?php _e('Posted by ','color-theme-framework'); echo the_author_posts_link(); ?>
    							<span class="post-format" title="<?php echo $format; ?>" style="background-color:<?php echo $cat_color; ?>;"><i class="ct-format <?php echo $format; ?>"></i></span><!-- post-format -->
	        				</div><!-- .meta-posted-by -->
	        
	        				<span class="meta-time"><?php echo esc_attr( get_the_date( 'd F' ) ); ?></span><!-- meta-time -->

						<!-- without thumbnail -->
		  				<?php else: ?>

							<div style="margin-bottom: 15px;padding-top: 3px;border-top: 3px solid <?php echo $cat_color; ?>;">
	        					<span class="meta-posted-by muted-small"><?php _e('Posted by ','color-theme-framework'); echo the_author_posts_link(); ?></span><!-- .meta-posted-by -->
	        					<span style="font-size:11px;"><?php _e('on','color-theme-framework'); ?></span>
	        					<span class="meta-time no-thumb muted-small"><?php echo esc_attr( get_the_date( 'd F' ) ); ?></span><!-- meta-time -->
								<span class="post-format" title="<?php echo $format; ?>" style="top: 0;background-color:<?php echo $cat_color; ?>;"><i class="ct-format <?php echo $format; ?>"></i></span><!-- post-format -->
	      					</div>
		  				<?php endif; ?>

		  				<!-- title -->
		  				<h4 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>"><?php the_title(); ?></a></h4>

		  				<!-- post excerpt -->
		  				<div class="entry-content"><?php $post_excerpt = get_the_excerpt(); echo strip_tags(mb_substr($post_excerpt, 0, $excerpt_lenght ) ) . ' ...'; ?></div><!-- .entry-content -->

		  				<?php
						// Check if post is Review, then show rating
						if ( $post_type == 'review_post' ) : ?>
							<div class="meta clearfix">
								<?php
								ct_get_rating_stars();
								ct_get_post_meta($post->ID, false, false, false, false, false);
								?>
								<?php ct_get_readmore(); // get read more link ?>
							</div><!-- .meta -->
						<?php
						// Else, show standard meta
						else : ?>

						<div class="meta">
							<?php ct_get_post_meta($post->ID, true, true, true, false, false); ?>
							<?php ct_get_readmore(); // get read more link ?>
						</div><!-- .meta -->
						<?php endif; ?>


						<?php 
						// Divider type
						if ( $divider_type == 'striped') : ?>
							<div class="widget-devider"></div>
						<?php else: ?>
							<div class="widget-devider-1px"></div>
						<?php endif; ?>

					</div><!-- post format -->
				<?php endwhile; ?>

				
				<!-- Query with thumbnails -->
				<?php
				$recent_posts = new WP_Query( array(
					'showposts' => $posts,
					'post_type' => 'post',
					'cat' => $categories,
				));
			
				$counter = 0;
				?>

				<ul class="widget-one-column-horizontal">
					<?php while($recent_posts->have_posts()): $recent_posts->the_post();
						if($counter >= 1 ) { ?>
							<li class="clearfix">
								<?php if( $show_image == 'true' ): ?>
									<?php if(has_post_thumbnail()): ?>
				    					<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'small-thumb'); 
				    					if ( $image[1] == 75 && $image[2] == 75 ) : //if has generated thumb ?>
					 		  				<div class="widget-post-small-thumb">
							    				<a href='<?php the_permalink(); ?>' title='<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>'><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
					  		  				</div><!-- widget-post-small-thumb -->
										<?php else : // else use standard 150x150 thumb
			  		  		  				$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail'); ?>
					 	 	  				<div class="widget-post-small-thumb">
							    				<a href='<?php the_permalink(); ?>' title='<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>'><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
					  		  				</div><!-- widget-post-small-thumb -->
					  					<?php endif; ?>
						  			<?php endif; ?><!-- has_post_thumbnail -->
								<?php endif; ?><!-- show_image -->

								<div class="post-title">
						  			<h5><a href='<?php the_permalink(); ?>' title='<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>'><?php the_title(); ?></a></h5>
								</div><!-- post-title -->

		  						<?php
		  						//Get post type: standard post or review
								$post_type = get_post_meta($post->ID, 'ct_mb_post_type', true);
								if( $post_type == '' ) $post_type = 'standard_post';

								// Check if post is Review, then show rating
								if ( $post_type == 'review_post' ) : ?>
									<div class="meta clearfix">
										<?php
										ct_get_rating_stars_s();
										ct_get_post_meta($post->ID, $show_likes, $show_comments, $show_views, $show_date, $show_category);
										?>
									</div><!-- .meta -->
								<?php
								// Else, show standard meta
								else : ?>

								<div class="meta">
									<?php ct_get_post_meta($post->ID, $show_likes, $show_comments, $show_views, $show_date, $show_category); ?>
								</div><!-- .meta -->
								<?php endif; ?>

							</li>
						<?php }

				    	$counter++;
					endwhile; ?>
				</ul>
		  	</div><!-- span4 -->









<!-- *************** SECOND COLUMN ************ -->
			<?php
			$recent_posts = new WP_Query(array(
				'showposts' => 1,
				'post_type' => 'post',
				'cat' => $categories2,
			));
			?>

	  		<div class="span4">
		    	<?php
				$cat_color = ct_get_color($categories2);
				if ( $cat_color == '') { $cat_color = '#000'; }

				if ( $categories2 != 'all' ):
					$category_title_link = get_category_link( $categories2 );
					echo '<div class="widget-title bottom-shadow" style="background:' . $cat_color .';"><h2><a href="'.$category_title_link.'" title="'.__('View all posts in ','color-theme-framework').$title2.'">'.$title2.'</a></h2><div class="arrow-down" style="border-top-color:' . $cat_color . ';"></div><!-- .arrow-down --><div class="plus"><a href="'.$category_title_link.'" title="'.__('View all posts in ','color-theme-framework').$title2.'"><span></span></a></div><!-- .plus --></div><!-- widget-title -->';
				else :
					echo '<div class="widget-title bottom-shadow" style="background:' . $background_title2 .';"><h2>' . $title2 . '</h2><div class="arrow-down" style="border-top-color:' . $background_title2 . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->';
				endif;
				?>

				<?php while($recent_posts->have_posts()): $recent_posts->the_post();  

					// get post format
	  				$ct_format = get_post_format();
	  
	  				if ( false === $ct_format ) {
	      				$format = 'standard';
	  				} else {
		  				$format = $ct_format;
	  				}

		  			//Get post type: standard post or review
					$post_type = get_post_meta($post->ID, 'ct_mb_post_type', true);
					if( $post_type == '' ) $post_type = 'standard_post';
					?>

					<div class="<?php echo $format . " " . $post_type; ?>">

	  	  				<?php
	  
	  					// if Video post format
	  					if ( $ct_format == 'video' ) : get_template_part( 'includes/widget', $ct_format );

	    				// if Audio post format
	  					elseif( $ct_format == 'audio' ): get_template_part( 'includes/widget', $ct_format );

	  					// if Gallery post format	
	  					elseif( $ct_format == 'gallery' ): get_template_part( 'includes/widget', $ct_format );

						// if post has Feature image
	  					else:

							if(has_post_thumbnail()) : ?>
	      	  					<div class="widget-post-big-thumb ct-preload">
		        					<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'post-thumb'); ?>	
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
		  	  					</div><!-- .widget-post-big-thumb -->
	    					<?php
	    					endif; //has_post_thumbnail

	  					endif; ?>

		  				<!-- different meta style if no thumbnail -->
		  				<?php if(has_post_thumbnail() or ($ct_format == 'audio') or ($ct_format == 'video') or ($ct_format == 'gallery') ): ?>

		  					<!-- with thumbnail -->
	        				<div class="meta-posted-by muted-small" style="border-top: 3px solid <?php echo $cat_color; ?>;">
		        				<?php _e('Posted by ','color-theme-framework'); echo the_author_posts_link(); ?>
    							<span class="post-format" title="<?php echo $format; ?>" style="background-color:<?php echo $cat_color; ?>;"><i class="ct-format <?php echo $format; ?>"></i></span><!-- post-format -->
	        				</div><!-- .meta-posted-by -->
	        
	        				<span class="meta-time"><?php echo esc_attr( get_the_date( 'd F' ) ); ?></span><!-- meta-time -->

						<!-- without thumbnail -->
		  				<?php else: ?>

							<div style="margin-bottom: 15px;padding-top: 3px;border-top: 3px solid <?php echo $cat_color; ?>;">
	        					<span class="meta-posted-by muted-small"><?php _e('Posted by ','color-theme-framework'); echo the_author_posts_link(); ?></span><!-- .meta-posted-by -->
	        					<span style="font-size:11px;"><?php _e('on','color-theme-framework'); ?></span>
	        					<span class="meta-time no-thumb muted-small"><?php echo esc_attr( get_the_date( 'd F' ) ); ?></span><!-- meta-time -->
								<span class="post-format" title="<?php echo $format; ?>" style="top: 0;background-color:<?php echo $cat_color; ?>;"><i class="ct-format <?php echo $format; ?>"></i></span><!-- post-format -->
	      					</div>
		  				<?php endif; ?>

		  				<!-- title -->
		  				<h4 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>"><?php the_title(); ?></a></h4>

		  				<!-- post excerpt -->
		  				<div class="entry-content"><?php $post_excerpt = get_the_excerpt(); echo strip_tags(mb_substr($post_excerpt, 0, $excerpt_lenght2 ) ) . ' ...'; ?></div><!-- .entry-content -->

		  				<?php
						// Check if post is Review, then show rating
						if ( $post_type == 'review_post' ) : ?>
							<div class="meta clearfix">
								<?php
								ct_get_rating_stars();
								ct_get_post_meta($post->ID, false, false, false, false, false);
								?>
								<?php ct_get_readmore(); // get read more link ?>
							</div><!-- .meta -->
						<?php
						// Else, show standard meta
						else : ?>

						<div class="meta">
							<?php ct_get_post_meta($post->ID, true, true, true, false, false); ?>
							<?php ct_get_readmore(); // get read more link ?>
						</div><!-- .meta -->
						<?php endif; ?>

						<?php if ( $divider_type == 'striped') : ?>
							<div class="widget-devider" style="margin-left:0;"></div>
						<?php else: ?>
							<div class="widget-devider-1px"></div>
						<?php endif; ?>

					</div><!-- post format -->
				<?php endwhile; ?>

				
				<!-- Query with thumbnails -->
				<?php
				$recent_posts = new WP_Query( array(
					'showposts' => $posts2,
					'post_type' => 'post',
					'cat' => $categories2,
				));
			
				$counter = 0;
				?>

				<ul class="widget-one-column-horizontal">
					<?php while($recent_posts->have_posts()): $recent_posts->the_post();
						if($counter >= 1 ) { ?>
							<li class="clearfix">
								<?php if( $show_image2 == 'true' ): ?>
									<?php if(has_post_thumbnail()): ?>
				    					<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'small-thumb'); 
				    					if ( $image[1] == 75 && $image[2] == 75 ) : //if has generated thumb ?>
					 		  				<div class="widget-post-small-thumb">
							    				<a href='<?php the_permalink(); ?>' title='<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>'><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
					  		  				</div><!-- widget-post-small-thumb -->
										<?php else : // else use standard 150x150 thumb
			  		  		  				$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail'); ?>
					 	 	  				<div class="widget-post-small-thumb">
							    				<a href='<?php the_permalink(); ?>' title='<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>'><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
					  		  				</div><!-- widget-post-small-thumb -->
					  					<?php endif; ?>
						  			<?php endif; ?><!-- has_post_thumbnail -->
								<?php endif; ?><!-- show_image -->

								<div class="post-title">
						  			<h5><a href='<?php the_permalink(); ?>' title='<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>'><?php the_title(); ?></a></h5>
								</div><!-- post-title -->

		  						<?php
		  						//Get post type: standard post or review
								$post_type = get_post_meta($post->ID, 'ct_mb_post_type', true);
								if( $post_type == '' ) $post_type = 'standard_post';

								// Check if post is Review, then show rating
								if ( $post_type == 'review_post' ) : ?>
									<div class="meta clearfix">
										<?php
										ct_get_rating_stars_s();
										ct_get_post_meta($post->ID, $show_likes2, $show_comments2, $show_views2, $show_date2, $show_category2);
										?>
									</div><!-- .meta -->
								<?php
								// Else, show standard meta
								else : ?>

								<div class="meta">
									<?php ct_get_post_meta($post->ID, $show_likes2, $show_comments2, $show_views2, $show_date2, $show_category2); ?>
								</div><!-- .meta -->
								<?php endif; ?>
							</li>
						<?php }

				    	$counter++;
					endwhile; ?>
				</ul>
		  	</div><!-- span4 -->




<!-- *************** THIRD COLUMN ************ -->
			<?php
			$recent_posts = new WP_Query(array(
				'showposts' => 1,
				'post_type' => 'post',
				'cat' => $categories3,
			));
			?>

	  		<div class="span4">
		    	<?php
				$cat_color = ct_get_color($categories3);
				if ( $cat_color == '') { $cat_color = '#000'; }

				if ( $categories3 != 'all' ):
					$category_title_link = get_category_link( $categories3 );
					echo '<div class="widget-title bottom-shadow" style="background:' . $cat_color .';"><h2><a href="'.$category_title_link.'" title="'.__('View all posts in ','color-theme-framework').$title3.'">'.$title3.'</a></h2><div class="arrow-down" style="border-top-color:' . $cat_color . ';"></div><!-- .arrow-down --><div class="plus"><a href="'.$category_title_link.'" title="'.__('View all posts in ','color-theme-framework').$title3.'"><span></span></a></div><!-- .plus --></div><!-- widget-title -->';
				else :
					echo '<div class="widget-title bottom-shadow" style="background:' . $background_title3 .';"><h2>' . $title3 . '</h2><div class="arrow-down" style="border-top-color:' . $background_title3 . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->';
				endif;
				?>

				<?php while($recent_posts->have_posts()): $recent_posts->the_post();  

					// get post format
	  				$ct_format = get_post_format();
	  
	  				if ( false === $ct_format ) {
	      				$format = 'standard';
	  				} else {
		  				$format = $ct_format;
	  				}

		  			//Get post type: standard post or review
					$post_type = get_post_meta($post->ID, 'ct_mb_post_type', true);
					if( $post_type == '' ) $post_type = 'standard_post';
					?>

					<div class="<?php echo $format . " " . $post_type; ?>">

	  	  				<?php
	  
	  					// if Video post format
	  					if ( $ct_format == 'video' ) : get_template_part( 'includes/widget', $ct_format );

	    				// if Audio post format
	  					elseif( $ct_format == 'audio' ): get_template_part( 'includes/widget', $ct_format );

	  					// if Gallery post format	
	  					elseif( $ct_format == 'gallery' ): get_template_part( 'includes/widget', $ct_format );

						// if post has Feature image
	  					else:

							if(has_post_thumbnail()) : ?>
	      	  					<div class="widget-post-big-thumb ct-preload">
		        					<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'post-thumb'); ?>	
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
		  	  					</div><!-- .widget-post-big-thumb -->
	    					<?php
	    					endif; //has_post_thumbnail

	  					endif; ?>

		  				<!-- different meta style if no thumbnail -->
		  				<?php if(has_post_thumbnail() or ($ct_format == 'audio') or ($ct_format == 'video') or ($ct_format == 'gallery') ): ?>

		  					<!-- with thumbnail -->
	        				<div class="meta-posted-by muted-small" style="border-top: 3px solid <?php echo $cat_color; ?>;">
		        				<?php _e('Posted by ','color-theme-framework'); echo the_author_posts_link(); ?>
    							<span class="post-format" title="<?php echo $format; ?>" style="background-color:<?php echo $cat_color; ?>;"><i class="ct-format <?php echo $format; ?>"></i></span><!-- post-format -->
	        				</div><!-- .meta-posted-by -->
	        
	        				<span class="meta-time"><?php echo esc_attr( get_the_date( 'd F' ) ); ?></span><!-- meta-time -->

						<!-- without thumbnail -->
		  				<?php else: ?>

							<div style="margin-bottom: 15px;padding-top: 3px;border-top: 3px solid <?php echo $cat_color; ?>;">
	        					<span class="meta-posted-by muted-small"><?php _e('Posted by ','color-theme-framework'); echo the_author_posts_link(); ?></span><!-- .meta-posted-by -->
	        					<span style="font-size:11px;"><?php _e('on','color-theme-framework'); ?></span>
	        					<span class="meta-time no-thumb muted-small"><?php echo esc_attr( get_the_date( 'd F' ) ); ?></span><!-- meta-time -->
								<span class="post-format" title="<?php echo $format; ?>" style="top: 0;background-color:<?php echo $cat_color; ?>;"><i class="ct-format <?php echo $format; ?>"></i></span><!-- post-format -->
	      					</div>
		  				<?php endif; ?>

		  				<!-- title -->
		  				<h4 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>"><?php the_title(); ?></a></h4>

		  				<!-- post excerpt -->
		  				<div class="entry-content"><?php $post_excerpt = get_the_excerpt(); echo strip_tags(mb_substr($post_excerpt, 0, $excerpt_lenght3 ) ) . ' ...'; ?></div><!-- .entry-content -->

		  				<?php
						// Check if post is Review, then show rating
						if ( $post_type == 'review_post' ) : ?>
							<div class="meta clearfix">
								<?php
								ct_get_rating_stars();
								ct_get_post_meta($post->ID, false, false, false, false, false);
								?>
								<?php ct_get_readmore(); // get read more link ?>
							</div><!-- .meta -->
						<?php
						// Else, show standard meta
						else : ?>

						<div class="meta">
							<?php ct_get_post_meta($post->ID, true, true, true, false, false); ?>
							<?php ct_get_readmore(); // get read more link ?>
						</div><!-- .meta -->
						<?php endif; ?>

						<?php if ( $divider_type == 'striped') : ?>
							<div class="widget-devider" style="margin-left:0;"></div>
						<?php else: ?>
							<div class="widget-devider-1px"></div>
						<?php endif; ?>

					</div><!-- post format -->
				<?php endwhile; ?>

				
				<!-- Query with thumbnails -->
				<?php
				$recent_posts = new WP_Query( array(
					'showposts' => $posts3,
					'post_type' => 'post',
					'cat' => $categories3,
				));
			
				$counter = 0;
				?>

				<ul class="widget-one-column-horizontal">
					<?php while($recent_posts->have_posts()): $recent_posts->the_post();
						if($counter >= 1 ) { ?>
							<li class="clearfix">
								<?php if( $show_image3 == 'true' ): ?>
									<?php if(has_post_thumbnail()): ?>
				    					<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'small-thumb'); 
				    					if ( $image[1] == 75 && $image[2] == 75 ) : //if has generated thumb ?>
					 		  				<div class="widget-post-small-thumb">
							    				<a href='<?php the_permalink(); ?>' title='<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>'><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
					  		  				</div><!-- widget-post-small-thumb -->
										<?php else : // else use standard 150x150 thumb
			  		  		  				$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail'); ?>
					 	 	  				<div class="widget-post-small-thumb">
							    				<a href='<?php the_permalink(); ?>' title='<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>'><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
					  		  				</div><!-- widget-post-small-thumb -->
					  					<?php endif; ?>
						  			<?php endif; ?><!-- has_post_thumbnail -->
								<?php endif; ?><!-- show_image -->

								<div class="post-title">
						  			<h5><a href='<?php the_permalink(); ?>' title='<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>'><?php the_title(); ?></a></h5>
								</div><!-- post-title -->

		  						<?php
		  						//Get post type: standard post or review
								$post_type = get_post_meta($post->ID, 'ct_mb_post_type', true);
								if( $post_type == '' ) $post_type = 'standard_post';

								// Check if post is Review, then show rating
								if ( $post_type == 'review_post' ) : ?>
									<div class="meta clearfix">
										<?php
										ct_get_rating_stars_s();
										ct_get_post_meta($post->ID, $show_likes3, $show_comments3, $show_views3, $show_date3, $show_category3);
										?>
									</div><!-- .meta -->
								<?php
								// Else, show standard meta
								else : ?>

								<div class="meta">
									<?php ct_get_post_meta($post->ID, $show_likes3, $show_comments3, $show_views3, $show_date3, $show_category3); ?>
								</div><!-- .meta -->
								<?php endif; ?>
							</li>
						<?php }

				    	$counter++;
					endwhile; ?>
				</ul>
		  	</div><!-- span4 -->		  	
		</div><!-- row-fluid -->

		<!-- <style>
			.audio .single-media-thumb iframe { height: <?php echo $video_height.'px'; ?>}
		</style> -->

		<?php
		echo $after_widget;

	 	// Restor original Query & Post Data
		wp_reset_query();
		wp_reset_postdata();
	}

	/**
	 * Update the widget settings.
	 */			
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['categories'] = $new_instance['categories'];
		$instance['posts'] = $new_instance['posts'];
		$instance['show_image'] = $new_instance['show_image'];
		$instance['show_likes'] = $new_instance['show_likes'];
		$instance['show_comments'] = $new_instance['show_comments'];
		$instance['show_views'] = $new_instance['show_views'];
		$instance['show_date'] = $new_instance['show_date'];
		$instance['show_category'] = $new_instance['show_category'];
		$instance['excerpt_lenght'] = $new_instance['excerpt_lenght'];		
		$instance['video_height'] = $new_instance['video_height'];
		$instance['background_title'] = strip_tags($new_instance['background_title']);		

		$instance['title2'] = $new_instance['title2'];
		$instance['categories2'] = $new_instance['categories2'];
		$instance['posts2'] = $new_instance['posts2'];
		$instance['show_image2'] = $new_instance['show_image2'];
		$instance['show_likes2'] = $new_instance['show_likes2'];
		$instance['show_comments2'] = $new_instance['show_comments2'];
		$instance['show_views2'] = $new_instance['show_views2'];
		$instance['show_date2'] = $new_instance['show_date2'];
		$instance['show_category2'] = $new_instance['show_category2'];
		$instance['excerpt_lenght2'] = $new_instance['excerpt_lenght2'];		
//		$instance['video_height2'] = $new_instance['video_height2'];
		$instance['background_title2'] = strip_tags($new_instance['background_title2']);

		$instance['title3'] = $new_instance['title3'];
		$instance['categories3'] = $new_instance['categories3'];
		$instance['posts3'] = $new_instance['posts3'];
		$instance['show_image3'] = $new_instance['show_image3'];
		$instance['show_likes3'] = $new_instance['show_likes3'];
		$instance['show_comments3'] = $new_instance['show_comments3'];
		$instance['show_views3'] = $new_instance['show_views3'];
		$instance['show_date3'] = $new_instance['show_date3'];
		$instance['show_category3'] = $new_instance['show_category3'];
		$instance['excerpt_lenght3'] = $new_instance['excerpt_lenght3'];		
//		$instance['video_height3'] = $new_instance['video_height3'];
		$instance['background_title3'] = strip_tags($new_instance['background_title3']);

		$instance['background'] = strip_tags($new_instance['background']);
		$instance['widget_width'] = $new_instance['widget_width'];
		$instance['divider_type'] = $new_instance['divider_type'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */	
	function form($instance)
	{
		$defaults = array( 
			'title' => __( 'First Column', 'color-theme-framework' ), 
			'categories' => 'all', 
			'posts' => 3, 
			'show_image'=>'on', 
			'show_likes'=>'on',
			'show_comments'=>'on',
			'show_views'=>'on',
			'show_date'=>'off',
			'show_category' => 'off',
			'widget_width' => 'ct-full-width', 
			'background' => '#FFFFFF', 
			'background_title' => '#ff0000',
			'excerpt_lenght' => '140',
			'video_height' => '162',
			'title2' => __( 'Second Column', 'color-theme-framework' ), 
			'categories2' => 'all', 
			'posts2' => 3, 
			'show_image2'=>'on', 
			'show_likes2'=>'on',
			'show_comments2'=>'on',
			'show_views2'=>'on',
			'show_date2'=>'off',
			'show_category2' => 'off',
			'background_title2' => '#ff0000',
			'excerpt_lenght2' => '140',
//			'video_height2' => '162',
			'title3' => __( 'Second Column', 'color-theme-framework' ), 
			'categories3' => 'all', 
			'posts3' => 3, 
			'show_image3'=>'on', 
			'show_likes3'=>'on',
			'show_comments3'=>'on',
			'show_views3'=>'on',
			'show_date3'=>'off',
			'show_category3' => 'off',
			'background_title3' => '#ff0000',
			'excerpt_lenght3' => '140',
//			'video_height3' => '162',			
			'divider_type' => 'striped'
		);

		$instance = wp_parse_args((array) $instance, $defaults);
		$background = esc_attr($instance['background']);
		$background_title2 = esc_attr($instance['background_title2']);
		$background_title3 = esc_attr($instance['background_title3']);
		$background_title = esc_attr($instance['background_title']); ?>

		<script type="text/javascript">
			//<![CDATA[
				jQuery(document).ready(function()
				{
					// colorpicker field
					jQuery('.cw-color-picker').each(function(){
						var $this = jQuery(this),
							id = $this.attr('rel');

						$this.farbtastic('#' + id);
					});
				});
			//]]>   
		  </script>	

		<p style="font-weight: bold;">
          <label><?php _e('First column settings:', 'color-theme-framework'); ?></label> 
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' , 'color-theme-framework' ); ?></label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_image'], 'on'); ?> id="<?php echo $this->get_field_id('show_image'); ?>" name="<?php echo $this->get_field_name('show_image'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_image'); ?>"><?php _e( 'Show thumbnail image' , 'color-theme-framework' ); ?></label>
		</p>

		<p style="margin-top: 20px;">
			<label style="font-weight: bold;"><?php _e( 'Post meta info' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_likes'], 'on'); ?> id="<?php echo $this->get_field_id('show_likes'); ?>" name="<?php echo $this->get_field_name('show_likes'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_likes'); ?>"><?php _e( 'Show likes' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_comments'], 'on'); ?> id="<?php echo $this->get_field_id('show_comments'); ?>" name="<?php echo $this->get_field_name('show_comments'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_comments'); ?>"><?php _e( 'Show comments' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_views'], 'on'); ?> id="<?php echo $this->get_field_id('show_views'); ?>" name="<?php echo $this->get_field_name('show_views'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_views'); ?>"><?php _e( 'Show views' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_date'], 'on'); ?> id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e( 'Show date' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_category'], 'on'); ?> id="<?php echo $this->get_field_id('show_category'); ?>" name="<?php echo $this->get_field_name('show_category'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_category'); ?>"><?php _e( 'Show category' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('posts'); ?>"><?php _e( 'Number of posts:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>" />
			
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('excerpt_lenght'); ?>"><?php _e( 'Length of post excerpt (chars):' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="500" class="widefat" id="<?php echo $this->get_field_id('excerpt_lenght'); ?>" name="<?php echo $this->get_field_name('excerpt_lenght'); ?>" value="<?php echo $instance['excerpt_lenght']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e( 'Filter by Category:' , 'color-theme-framework' ); ?></label> 
			<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>

		<p>
          <label for="<?php echo $this->get_field_id('background_title'); ?>"><?php _e('Background Title Color:', 'color-theme-framework'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('background_title'); ?>" name="<?php echo $this->get_field_name('background_title'); ?>" type="text" value="<?php if($background_title) { echo $background_title; } else { echo '#ff0000'; } ?>" />
			<div class="cw-color-picker" rel="<?php echo $this->get_field_id('background_title'); ?>"></div>
        </p>

<!-- ************* Second Column **************** -->
		<p style="margin-top:50px; font-weight: bold;">
          <label><?php _e('Second column settings:', 'color-theme-framework'); ?></label> 
        </p>

		<p>
			<label for="<?php echo $this->get_field_id('title2'); ?>"><?php _e( 'Title:' , 'color-theme-framework' ); ?></label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title2'); ?>" name="<?php echo $this->get_field_name('title2'); ?>" value="<?php echo $instance['title2']; ?>" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_image2'], 'on'); ?> id="<?php echo $this->get_field_id('show_image2'); ?>" name="<?php echo $this->get_field_name('show_image2'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_image2'); ?>"><?php _e( 'Show thumbnail image' , 'color-theme-framework' ); ?></label>
		</p>

		<p style="margin-top: 20px;">
			<label style="font-weight: bold;"><?php _e( 'Post meta info' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_likes2'], 'on'); ?> id="<?php echo $this->get_field_id('show_likes2'); ?>" name="<?php echo $this->get_field_name('show_likes2'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_likes2'); ?>"><?php _e( 'Show likes' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_comments2'], 'on'); ?> id="<?php echo $this->get_field_id('show_comments2'); ?>" name="<?php echo $this->get_field_name('show_comments2'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_comments2'); ?>"><?php _e( 'Show comments' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_views2'], 'on'); ?> id="<?php echo $this->get_field_id('show_views2'); ?>" name="<?php echo $this->get_field_name('show_views2'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_views2'); ?>"><?php _e( 'Show views' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_date2'], 'on'); ?> id="<?php echo $this->get_field_id('show_date2'); ?>" name="<?php echo $this->get_field_name('show_date2'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_date2'); ?>"><?php _e( 'Show date' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_category2'], 'on'); ?> id="<?php echo $this->get_field_id('show_category2'); ?>" name="<?php echo $this->get_field_name('show_category2'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_category2'); ?>"><?php _e( 'Show category' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('posts2'); ?>"><?php _e( 'Number of posts:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('posts2'); ?>" name="<?php echo $this->get_field_name('posts2'); ?>" value="<?php echo $instance['posts2']; ?>" />
			
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('excerpt_lenght2'); ?>"><?php _e( 'Length of post excerpt (chars):' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="500" class="widefat" id="<?php echo $this->get_field_id('excerpt_lenght2'); ?>" name="<?php echo $this->get_field_name('excerpt_lenght2'); ?>" value="<?php echo $instance['excerpt_lenght2']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('categories2'); ?>"><?php _e( 'Filter by Category:' , 'color-theme-framework' ); ?></label> 
			<select id="<?php echo $this->get_field_id('categories2'); ?>" name="<?php echo $this->get_field_name('categories2'); ?>" class="widefat" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories2']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories2']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>

		<p>
          <label for="<?php echo $this->get_field_id('background_title2'); ?>"><?php _e('Background Title Color:', 'color-theme-framework'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('background_title2'); ?>" name="<?php echo $this->get_field_name('background_title2'); ?>" type="text" value="<?php if($background_title2) { echo $background_title2; } else { echo '#ff0000'; } ?>" />
			<div class="cw-color-picker" rel="<?php echo $this->get_field_id('background_title2'); ?>"></div>
        </p>




<!-- ************* Third Column **************** -->
		<p style="margin-top:50px; font-weight: bold;">
          <label><?php _e('Third column settings:', 'color-theme-framework'); ?></label> 
        </p>

		<p>
			<label for="<?php echo $this->get_field_id('title3'); ?>"><?php _e( 'Title:' , 'color-theme-framework' ); ?></label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title3'); ?>" name="<?php echo $this->get_field_name('title3'); ?>" value="<?php echo $instance['title3']; ?>" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_image3'], 'on'); ?> id="<?php echo $this->get_field_id('show_image3'); ?>" name="<?php echo $this->get_field_name('show_image3'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_image3'); ?>"><?php _e( 'Show thumbnail image' , 'color-theme-framework' ); ?></label>
		</p>

		<p style="margin-top: 20px;">
			<label style="font-weight: bold;"><?php _e( 'Post meta info' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_likes3'], 'on'); ?> id="<?php echo $this->get_field_id('show_likes3'); ?>" name="<?php echo $this->get_field_name('show_likes3'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_likes3'); ?>"><?php _e( 'Show likes' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_comments3'], 'on'); ?> id="<?php echo $this->get_field_id('show_comments3'); ?>" name="<?php echo $this->get_field_name('show_comments3'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_comments3'); ?>"><?php _e( 'Show comments' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_views3'], 'on'); ?> id="<?php echo $this->get_field_id('show_views3'); ?>" name="<?php echo $this->get_field_name('show_views3'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_views3'); ?>"><?php _e( 'Show views' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_date3'], 'on'); ?> id="<?php echo $this->get_field_id('show_date3'); ?>" name="<?php echo $this->get_field_name('show_date3'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_date3'); ?>"><?php _e( 'Show date' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_category3'], 'on'); ?> id="<?php echo $this->get_field_id('show_category3'); ?>" name="<?php echo $this->get_field_name('show_category3'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_category3'); ?>"><?php _e( 'Show category' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('posts3'); ?>"><?php _e( 'Number of posts:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('posts3'); ?>" name="<?php echo $this->get_field_name('posts3'); ?>" value="<?php echo $instance['posts3']; ?>" />
			
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('excerpt_lenght3'); ?>"><?php _e( 'Length of post excerpt (chars):' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="500" class="widefat" id="<?php echo $this->get_field_id('excerpt_lenght3'); ?>" name="<?php echo $this->get_field_name('excerpt_lenght3'); ?>" value="<?php echo $instance['excerpt_lenght3']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('categories3'); ?>"><?php _e( 'Filter by Category:' , 'color-theme-framework' ); ?></label> 
			<select id="<?php echo $this->get_field_id('categories3'); ?>" name="<?php echo $this->get_field_name('categories3'); ?>" class="widefat" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories3']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories3']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>

		<p>
          <label for="<?php echo $this->get_field_id('background_title3'); ?>"><?php _e('Background Title Color:', 'color-theme-framework'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('background_title3'); ?>" name="<?php echo $this->get_field_name('background_title3'); ?>" type="text" value="<?php if($background_title3) { echo $background_title3; } else { echo '#ff0000'; } ?>" />
			<div class="cw-color-picker" rel="<?php echo $this->get_field_id('background_title3'); ?>"></div>
        </p>




<!-- *************************************************** -->
		<p style="margin-top:50px; font-weight: bold;">
          <label><?php _e('Common settings:', 'color-theme-framework'); ?></label> 
        </p>

		<p>
			<label for="<?php echo $this->get_field_id( 'widget_width' ); ?>"><?php _e('Widget width:', 'color-theme-framework'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'widget_width' ); ?>" name="<?php echo $this->get_field_name( 'widget_width' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'span2' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span2</option>
				<option <?php if ( 'span3' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span3</option>
				<option <?php if ( 'span4' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span4</option>
				<option <?php if ( 'span5' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span5</option>				
				<option <?php if ( 'span6' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span6</option>
				<option <?php if ( 'span7' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span7</option>
				<option <?php if ( 'span8' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span8</option>
				<option <?php if ( 'span9' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span9</option>
				<option <?php if ( 'span10' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span10</option>
				<option <?php if ( 'span11' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span11</option>
				<option <?php if ( 'span12' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span12</option>
				<option <?php if ( 'ct-full-width' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>ct-full-width</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('video_height'); ?>"><?php _e( 'Height of embedded video or audio  (px):' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="1000" class="widefat" id="<?php echo $this->get_field_id('video_height'); ?>" name="<?php echo $this->get_field_name('video_height'); ?>" value="<?php echo $instance['video_height']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'divider_type' ); ?>"><?php _e('Divider type (below the first post):', 'color-theme-framework'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'divider_type' ); ?>" name="<?php echo $this->get_field_name( 'divider_type' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'striped' == $instance['divider_type'] ) echo 'selected="selected"'; ?>>striped</option>
				<option <?php if ( '1px' == $instance['divider_type'] ) echo 'selected="selected"'; ?>>1px</option>
			</select>
		</p>

		<p>
          <label for="<?php echo $this->get_field_id('background'); ?>"><?php _e('Background Color:', 'color-theme-framework'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('background'); ?>" name="<?php echo $this->get_field_name('background'); ?>" type="text" value="<?php if($background) { echo $background; } else { echo '#FFFFFF'; } ?>" />
			<div class="cw-color-picker" rel="<?php echo $this->get_field_id('background'); ?>"></div>
        </p>
<!-- *************************************************** -->

	<?php }
}
?>