<?php /* Template Name: Homepage Template */ get_header();
$heroTitle = get_field('hero_title');
$heroSubtitle = get_field('hero_subtitle');
$heroUrl = get_field('hero_url');
$mission = get_field('mission');
$whereSubtitle = get_field('where_subtitle');
$quote = get_field('quote');
$attribution = get_field('attribution');
$heroImage = get_field('hero_image');
$ctaLeftTitle = get_field('cta_left_title');
$ctaLeftCopy = get_field('cta_left_copy');
$ctaRightTitle = get_field('cta_right_title');
$ctaRightCopy = get_field('cta_right_copy');
$heroBG = 'background:linear-gradient(rgba(69, 96, 85, 0.7),rgba(69, 96, 85, 0.7)),url('.$heroImage.') top center / cover no-repeat fixed;';
?>

	<main role="main">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<section class="hero parrallax" style="<?php echo $heroBG ?>">
				<div class="content">
					<h1><?php
						if($heroTitle){
							echo $heroTitle;
						}else{
							echo 'The Great Spring Break Sit-Out';
						}
						?></h1>
						<?php
						if($heroSubtitle){
							echo $heroSubtitle;
						}else{
							echo '<p><strong>April 10 - April 14</strong></p><p>The time you give to building communit really matters. Come sit with us next week!</p>';
						}
						?>
					<div class="button-group sticky">
						<?php
						if($heroUrl):?>
						<a class="button primary-dark-bg" href="<?php echo $heroUrl; ?>">View Event</a>
						
					<?php endif; ?>
						
					</div>
				</div>
			</section>
			<section class="mission header-sync">
				<div class="top"></div>
				<div class="content">
					<div class="content-group">
					<h2 class="marker">Our<br/>Mission</h2>
					<p class="text-center"><?php
						if($mission){
							echo $mission;
						}else{
							echo 'MASK is a force that empowers us to be the voice of change, safety, and presence for our families and communities. As individuals joined together, our many voices are ampliied as one.';
						}
					?></p>
					<a class="button secondary-dark-bg" href="/about">Learn More</a>
				</div>
				</div>
			</section>
			<section class="who-what">
				<div class="top"></div>
				<div class="content flex">
					<div class="col span-6 who">
						<h2 class="marker">Where We're Posted</h2>
						<?php
							if($whereSubtitle){
								echo $whereSubtitle;
							}else{
								echo '<p>You can find us represented in the following cities.</p>';
							}
							if(have_rows('posted_locations')):
						?>
						<ul class="unstyled spaced-list">
							<?php while(have_rows('posted_locations')): the_row();
								$name = get_sub_field('location_name');
								$url = get_sub_field('location_url');
								?>
								<li><span class="location"><?php echo $name ?></span>
									<?php if($url): ?>
									<br/><a href="<?php echo $url ?>">Visit Facebook ></a>
								<?php endif; ?>
								</li>
								<?php endwhile; ?>
						</ul>
					<?php endif; ?>
					</div>
					<div class="col span-6 where">
						<img src="<?php echo get_template_directory_uri(); ?>/dist/img/map.svg" onerror="this.src='<?php echo get_template_directory_uri(); ?>/dist/img/map.png'" class="map">
					</div>
				</div>
				<div class="bottom"></div>
			</section>
			<section class="quote">
				<div class="content">
				<div class="blockquote">
					<p>					<img src="<?php echo get_template_directory_uri(); ?>/dist/img/quote-icon.svg" onerror="this.src='<?php echo get_template_directory_uri(); ?>/dist/img/quote-icon.png'" class="quote-icon">
<?php
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
			<section class="cta">
				<div class="top"></div>
				<div class="content gutters">
					<div class="span-6 col">
						<h2><?php
						if($ctaLeftTitle){
							echo $ctaLeftTitle;
						}else{
							echo '100% Fueled by Donations';
						}
						?></h2>
						<?php
						if($ctaLeftCopy){
							echo $ctaLeftCopy;
						}else{
							echo 'Your gift will be used directly in support of:';
						}
						?>
					</div>
					<div class="span-6 col">
						<h2><?php
						if($ctaRightTitle){
							echo $ctaRightTitle;
						}else{
							echo 'Reach Out!';
						}
						?></h2>
						<?php
						if($ctaRightCopy){
							echo $ctaRightCopy;
						}else{
							echo 'The Great Spring Break Sit-Out';
						}
						?>
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
			<section class="donate-contact">
				<div class="content">
					<div class="span-6 col"></div>
					<div class="span-6 col"></div>
				</div>
			</section>
		<?php else: ?>

			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'boilerplate' ); ?></h2>

			</article>

		<?php endif; ?>

	</main>


<?php get_footer(); ?>
