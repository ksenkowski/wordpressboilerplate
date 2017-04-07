<?php /* Template Name: Homepage Template */ get_header();
$tagline = the_field('tagline');
$mission = the_field('mission');
$who = the_field('who_we_are');
$quote = the_field('quote');
$attribution = the_field('attribution');
$featuredImage = the_field('featured_image');
?>

	<main role="main">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<section class="hero parrallax">
				<div class="content">
					<h1 class="marker"><?php
						if($tagline){
							echo $tagline;
						}else{
							echo 'The Impactful Provocative Tagline Goes Here';
						}
						?></h1>
					<div class="button-group sticky">
						<a class="button secondary-dark-bg" href="">Contact Us</a>
						<a class="button primary-dark-bg" href="">Donate</a>
					</div>
				</div>
			</section>
			<section class="mission">
				<div class="content">
					<div class="content-group">
					<h2 class="marker">Our<br/>Mission</h2>
					<p class="text-center"><?php
						if($mission){
							echo $mission;
						}else{
							echo 'MASK is starting on a grass roots level to come together and organize parents with emphasis on the power of mothers, to become a force in the fight against the violence. ';
						}
					?></p>
					<a class="button secondary-dark-bg" href="">Learn More</a>
				</div>
				</div>
			</section>
			<section class="who-what">
				<div class="top"></div>
				<div class="content flex">
					<div class="col span-6 who">
						<h2 class="marker">Who We Are</h2>
						<?php
							if($who){
								echo $who;
							}else{
								echo '<p>M.A.S.K. is putting an end to senseless gun violence and adolescent outrage on our neighborhood streets. By injecting a motherly presence, we establish love and peace on the block, giving the community and our children a future.</p><p>MASK is a force that empowers us to be the voice of change, safety, and presence for our families and communities. As individuals joined together, our many voices are ampliied as one.</p>';
							}
						?>
						<a class="button primary-light-bg" href="">Read More</a>
					</div>
					<div class="col span-6 where">
						<h2 class="marker">Where We're Posted</h2>
						<img src="<?php echo get_template_directory_uri(); ?>/dist/img/map.svg" onerror="this.src='<?php echo get_template_directory_uri(); ?>/dist/img/map.png'" class="map">
						<a class="button primary-light-bg" href="">See Details</a>

					</div>
				</div>
				<div class="bottom"></div>
			</section>
			<section class="quote">
				<div class="content">
					<img src="<?php echo get_template_directory_uri(); ?>/dist/img/quote-icon.svg" onerror="this.src='<?php echo get_template_directory_uri(); ?>/dist/img/quote-icon.png'" class="quote-icon">
				</div>
				<div class="content">
				<div class="blockquote">
					<p><?php
						if($quote){
							echo $quote;
						}else{
							echo 'Everybody is starting to realize that gun violence is not just a south side problem. It’s an American problem.';
						}
					?></p>
					<p class="attribution">- <?php
						if($attribution){
							echo $attribution;
						}else{
							echo 'Tamar Manasseh';
						}
					?></p>
				</div>
			</div>
			</section>
			<?php endwhile; ?>
			<section class="latest">
				<div class="content">
					<h2 class="marker">The Latest</h2>
						<a class="button secondary-light-bg" href="">See All Posts</a>
				</div>
				<div class="content latest-featured">
				<?php
						$my_query = new WP_Query( 'posts_per_page=3' );
						$count = 0;
						while ( $my_query->have_posts() ) : $my_query->the_post();
						$do_not_duplicate[] = $post->ID;
						$count++;
						if ($count == 1):
				?>

					<div class="col span-8 latest-featured-left">
						<?php
						if($featuredImage): ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <span><?php the_title(); ?></span>
                <p class="teaser">The Cook County Land Band (CCLB) has awarded MASK ownership of their half of the vacant lot at 75th and Stewart.</p>
              </a>
						<?php endif; ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
              <span><?php the_title(); ?></span><br/>
              <span class="teaser">The Cook County Land Band (CCLB) has awarded MASK ownership of their half of the vacant lot at 75th and Stewart.</span>
            </a>
					</div>
					<div class="col span-4 latest-featured-small">
						<?php elseif ($count == 2): ?>
						<div class="latest-featured-top">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><span><?php the_title(); ?></span></a>
						</div>
						<?php elseif ($count == 3): ?>
						<div class="latest-featured-bottom">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><span><?php the_title(); ?></span></a>
						</div>

					<?php endif; ?>
					<?php endwhile; ?>
				  </div>
				</div>


					<div class="content">

				<?php $my_query = new WP_Query( 'posts_per_page=9' );
						while ( $my_query->have_posts() ) : $my_query->the_post();
					if ( in_array( $post->ID, $do_not_duplicate ) ) continue;
					$count++;
					?>
					<?php
					if ($count > 3):

						?>
						<div class="col latest-boxes box-<?php echo $count; ?>">
							<?php the_post_thumbnail(array(250,250)); ?>
							<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
							<p class="excerpt"><?php boilerplate_excerpt('boilerplate_index'); ?></p>

							<div class="meta-group">
							<p class="author"><?php echo get_the_author(); ?> - <?php the_time('F j, Y'); ?></p>
							<p class="category"><?php  the_category(', '); // Separated by commas ?></p>
						</div>
						</div>
<?php endif; ?>
		<?php endwhile;  ?>
</div>
			</section>
			<section class="events">
				<div class="content">
					<h2 class="marker">Events</h2>
          <ul class="events-list">
            <?php for($i = 0; $i<=3; $i++){ ?>
              <li class="single-event span-3">
                <div class="single-event-container">
                  <div class="event-header">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <p>Chicago, IL</p>
                  </div>
                  <div class="event-body">
                    <p class="event-title">Event Title</p>
                    <div class="event-info">
                      <em>Friday, April 7th, 2017</em>
                      <p>7:00pm - 8:30pm</p>
                    </div>
                  </div>
                </div>
              </li>
            <?php } ?>
          </ul>
				</div>
			</section>

		<?php else: ?>

			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'boilerplate' ); ?></h2>

			</article>

		<?php endif; ?>

	</main>


<?php get_footer(); ?>
