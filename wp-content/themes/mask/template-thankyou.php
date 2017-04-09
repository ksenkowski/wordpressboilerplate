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
								echo '<p><strong>You rock!</strong> <br>We really appreciate your support.</p>';
							}
							
							 ?>
							 </div>
                		<div class="span-6 col right">							
							<?php if($rightContent){
								echo $rightContent;
							}else{
								echo '<p>Your gift will be used directly in support of:</p>
<ul>
 	<li>Feeding our communities</li>
 	<li>Summer programming</li>
 	<li>The Lot - Englewood, Chicago</li>
 	<li>Back to school drives</li>
</ul>
<p>Thanks to generous people like you, we can continue our work in our current communities, and ensure that MASK is around to reach even more communities in the future.</p>';
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
