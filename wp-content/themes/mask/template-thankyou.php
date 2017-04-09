<?php /* Template Name: Thank You */ get_header();
$leftContent = get_field('thank_you_left_hand_copy');
$rightContent = get_field('thank_you_right_hand_copy');
?>

	<main role="main">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<section class="support-header">
				<div class="content">
                <h1 class="marker"><?php the_title(); ?></h1>
			</div>
			</section>
			<section class="header-sync details">
				<div class="content gutters">
						<div class="span-6 col left">
							<?php if($leftContent){
								echo $leftContent;
							}else{
								echo 'The Impactful Provocative Tagline Goes Here';
							}
							
							 ?>
							 </div>
                		<div class="span-6 col right">							
							<?php if($rightContent){
								echo $rightContent;
							}else{
								echo 'The Impactful Provocative Tagline Goes Here';
							}
							
							 ?></div>
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
