<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
		<link rel='dns-prefetch' href='//fonts.googleapis.com' />

		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">
		<link rel='stylesheet' id='openSansFont-css'  href='https://fonts.googleapis.com/css?family=Open+Sans:400,800' type='text/css' media='all' />
		<link rel='stylesheet' id='permanentMarkerFont-css'  href='http://fonts.googleapis.com/css?family=Permanent+Marker&#038;ver=4.7.3' type='text/css' media='all' />
		<script src="https://use.fontawesome.com/70889c11f6.js"></script>
		<?php wp_head(); ?>
		
		<script>
        conditionizr.config({
            assets: '<?php echo get_template_directory_uri(); ?>',
            tests: {}
        });
        </script>

	</head>
	<body <?php body_class(); ?>>


			<!-- header -->
			<header class="header" role="banner">
				<nav class="menu slide-left" role="navigation">
					<button class="close-menu">X</button>
					<?php if (function_exists(boilerplate_nav())) boilerplate_nav(); ?>
					
					<div class="button-group">
						<div class="social-buttons"></div>
						<a class="button secondary-dark-bg" href="donate.com">Contact Us</a>
						<a class="button primary-dark-bg" href="donate.com">Donate</a>
					</div>
				</nav>
				<div class="mask"></div>
				<div class="content">
					<!-- logo -->
					<div class="span-12 col">
						<button class="open-menu">&#9776;</button>
						<!-- <a href="<?php echo home_url(); ?>">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg" onerror="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png'" class="logo">
						</a> -->
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg" onerror="this.src='<?php echo get_template_directory_uri(); ?>/assets/img/logo-header.png'" class="logo">
					<div class="button-group sticky">
						<ul class="unstyled">
							<li><a class="button secondary-dark-bg">Contact Us</a></li>
							<li><a class="button primary-dark-bg">Donate</a></li>
						</ul>
					</div>
				</div>
				</div>
			</header>
			<!-- /header -->
