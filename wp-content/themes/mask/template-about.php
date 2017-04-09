<?php /* Template Name: About Us */ get_header();
$heroTitle = get_field('about_hero_title');
$heroImage = get_field('about_hero_image');
$whatTitle = get_field('what_title');
$whatLeft = get_field('what_left_copy');
$whatRight = get_field('what_right_copy');
$armyVideo = get_field('youtube_video');
$armySubtitle = get_field('army_subtitle');
$armyCopy = get_field('army_copy');

$heroBG = 'background:linear-gradient(rgba(69, 96, 85, 0.7),rgba(69, 96, 85, 0.7)),url('.$heroImage.') top center / cover no-repeat fixed;';
$armyBG = 'background:linear-gradient(rgba(69, 96, 85, 0.7),rgba(69, 96, 85, 0.7)),url('.$armyImage.') top center / cover no-repeat;';
?>

	<main role="main">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<section class="about-hero parrallax" style="<?php echo $heroBG ?>">
				<div class="content">
					<h1><?php
						if($heroTitle){
							echo $heroTitle;
						}else{
							echo 'Mask is what happens<br/>when we take parenting<br/>to the street.';
						}
						?></h1>
				</div>
			</section>
			<section class="what-we-do header-sync">
				<div class="top"></div>
				<div class="content gutters">
					<div class="span-6 col">
						<h2>
							<?php
							if($whatTitle){
								echo $whatTitle;
							}else{
								echo 'What We Do';
							}
							?>
						</h2>
						<?php
						if($whatLeft){
							echo $whatLeft;
						}else{
							echo 'A bunch of copy';
						}
						?>
						
					</div>
					<div class="span-6 col">
						<?php
						if($whatLeft){
							echo $whatRight;
						}else{
							echo 'A bunch of copy';
						}
						?>
						
					</div>					
				</div>
			</section>
			<section class="army-hero">
				<div class="top"></div>
				<div class="youtube">
					<?php
					if($armyVideo){
						echo $armyVideo;
					}else{
						echo 'What We Do';
					}
					?>
				</div>
				<div class="bottom"></div>
			</section>
			<section class="army-copy">
				<div class="content">
					<div class="copy-group">
					<h2>							<?php
							if($armySubtitle){
								echo $armySubtitle;
							}else{
								echo 'I’m not an activist, I’m just a mother.';
							}
							?>
</h2>
						<?php
						if($armyCopy){
							echo $armyCopy;
						}else{
							echo 'I used to think my greatest accomplishment was raising two happy, healthy children in Chicago, where so many other mothers are denied that right. Then I sat in a lawn chair on a street corner and extended the love I have for my kids to someone else’s. I have been enriched and deeply fulfilled by all of my children. I hope that one day you get to experience the same level of purpose that I have.
See you on the block.';
						}
						?>
						<img src="<?php echo get_template_directory_uri(); ?>/dist/img/signature.svg" onerror="this.src='<?php echo get_template_directory_uri(); ?>/dist/img/signature.png'" class="signature">
						
					</div>

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
