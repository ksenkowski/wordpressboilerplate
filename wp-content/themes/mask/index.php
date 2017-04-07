<!-- Homepage Template -->

<?php get_header(); ?>

	<main role="main">
		<section>
			<div class="content gutters">
				<div class="span-8 col">
					<h1><?php _e( 'Latest Posts', 'boilerplate' ); ?></h1>

					<?php get_template_part('loop'); ?>

					<?php get_template_part('pagination'); ?>
				</div>
				<div class="span-4 col">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</section>
	</main>


<?php get_footer(); ?>
