<?php /* Template Name: Homepage Template */ get_header(); 
$tagline = the_field('tagline');
$mission = the_field('mission');
$who = the_field('who_we_are');
$quote = the_field('quote');
$attribution = the_field('attribution');
?>

	<main role="main">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<section class="hero">
				<div class="content">
					<h1 class="marker"><?php 
						if($tagline){
							echo $tagline;
						}else{
							echo 'No Value';
						}
						?></h1>
					<div class="button-group">
						<a class="button secondary-dark-bg" href="">Contact Us</a>
						<a class="button primary-dark-bg" href="">Donate</a>
					</div>
				</div>
			</section>
			<section class="mission">
				<div class="content">
					<h2 class="marker">Our Mission</h2>
					<p><?php
						if($mission){
							echo $mission;
						}else{
							echo 'No Value';
						}					
					?></p>
					<a class="button secondary-dark-bg" href="">Learn More</a>
				</div>
			</section>
			<section class="who-what">
				<div class="content">
					<div class="col span-6">
						<h2>Who We Are</h2>
						<p><?php
							if($who){
								echo $who;
							}else{
								echo 'No Value';
							}
						?></p>
						<a class="button primary-light-bg" href="">Read More</a>
					</div>
					<div class="col span-6">
						<h2>Where We're Posted</h2>
						<a class="button primary-light-bg" href="">Read More</a>
						
					</div>
				</div>
			</section>
			<section class="quote">
				<blockquote>
					<p><?php
						if($quote){
							echo $quote;
						}else{
							echo 'No Value';
						}
					?></p>
					<p class="attribution">- <?php
						if($attribution){
							echo $attribution;
						}else{
							echo 'No Value';
						}
					?></p>
				</blockquote>
			</section>
			<section class="latest">
				<div class="content">
					<h2>The Latest</h2>
					<?php 
					$my_query = new WP_Query( 'posts_per_page=9' ); while ( 					$my_query->have_posts() ) : $my_query->the_post(); ?>
						<!-- Do special_cat stuff... -->
					<?php endwhile; ?>
				</div>
			</section>
			<section class="events">
				<div class="content">
					<h2>Events</h2>
				</div>
			</section>
		<?php endwhile; ?>

		<?php else: ?>

			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'boilerplate' ); ?></h2>

			</article>

		<?php endif; ?>

	</main>


<?php get_footer(); ?>
