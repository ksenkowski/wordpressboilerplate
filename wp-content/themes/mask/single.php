<?php get_header(); ?>

	<main role="main">
	

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>
		
		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<section class="article-head">
				<div class="content">
					<h1>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h1>
					<span class="date"><?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></span>
					<span class="author"><?php _e( 'Published by', 'boilerplate' ); ?> <?php the_author_posts_link(); ?></span>
					
				</div>
			</section>
			
			<section class="hero-image">
				<div class="content">
				<!-- post thumbnail -->
				<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_post_thumbnail(); // Fullsize image for the single post ?>
					</a>
				<?php endif; ?>
				<!-- /post thumbnail -->				
				</div>
			</section>
			
			<section class="article-body">
				<?php the_content(); ?>
				
			</section>
			
			<section class="photo-gallery">
				
			</section>

			<!-- post title -->
			
			<!-- /post title -->

			<!-- post details -->
			<!-- /post details -->


			<?php the_tags( __( 'Tags: ', 'boilerplate' ), ', ', '<br>'); // Separated by commas with a line break at the end ?>

			<p><?php _e( 'Categorised in: ', 'boilerplate' ); the_category(', '); // Separated by commas ?></p>

			<p><?php _e( 'This post was written by ', 'boilerplate' ); the_author(); ?></p>

			<?php edit_post_link(); // Always handy to have Edit Post Links available ?>


		</article>
		<!-- /article -->

	<?php endwhile; ?>

	<?php else: ?>

		<!-- article -->
		<article>

			<h1><?php _e( 'Sorry, nothing to display.', 'boilerplate' ); ?></h1>

		</article>
		<!-- /article -->
		

	<?php endif; ?>

	<!-- /section -->
	</main>


<?php get_footer(); ?>
