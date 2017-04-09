<?php /* Template Name: Cancel Donation */ get_header();
$leftContent = get_field('cancel_left_hand_copy');
$rightContent = get_field('cancel_right_hand_copy');
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
								echo '<p>MASK is 100% fueled by donations. We really hope you reconsider.</p>';
							}
							
							 ?>
	 						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
	 							<input type="hidden" name="cmd" value="_s-xclick">
	 							<input type="hidden" name="hosted_button_id" value="D24AVFFXTPMM6">
	 						
	 						<button class="button primary-light-bg">Donate</button>
	 						</form>
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
<p>It is only through donations that we can continue this critical work. Without donations, all MASK work is funded by MASK communities and our volunteers.</p>';
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
