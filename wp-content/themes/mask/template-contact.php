<?php /* Template Name: Contact Form */ get_header();
$leftContent = get_field('left_hand_page_content');
$rightContent = get_field('form_content');
?>

	<main role="main">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<section class="form-header">
				<div class="content">
                <h1 class="marker"><?php the_title(); ?></h1>
			</div>
			</section>
			<section class="form header-sync">
				<div class="content gutters">
						<div class="span-6 col">
							<?php if($leftContent){
								echo $leftContent;
							}else{
								echo 'The Impactful Provocative Tagline Goes Here';
							}
							
							 ?></div>
                		<div class="span-6 col">							<?php if($rightContent){
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
