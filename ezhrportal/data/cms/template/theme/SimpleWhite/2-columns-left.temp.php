<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<?php get_header(); ?>
	<link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz|Droid+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css' />
	<link rel="stylesheet" type="text/css" media="all" href="<?php get_theme_url(); ?>/simplewhite.css" />
	<script type="text/javascript" src="<?php get_theme_url(); ?>/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="<?php get_theme_url(); ?>/js/jquery.nivo.slider.js"></script>
	<title><?php get_site_name(); ?> - <?php get_page_clean_title(); ?></title>
</head>

<body>
<div id="wrapper960" class="clearfix">
<?php include('toplinks.php'); ?>

	<div id="header" class="clearfix shadow">
		<div id="sitetitle" class="clearfix">
			<h1><a href="<?php get_site_url(); ?>"><?php get_site_name(); ?></a></h1>
		</div>

		<div id="nav" class="clearfix">
			<ul>
				<?php get_navigation(return_page_slug(FALSE)); ?>
			</ul>
		</div>
	</div>

<?php include('nivoslider.php'); ?>

	<div id="content" class="clearfix shadow">
		<div id="sidebar" class="left">
			<div class="inner">
				<?php get_component('sidebar'); ?>
			</div>
		</div>

		<div id="main" class="right">
			<h2><?php get_page_title(); ?></h2>
		<p><?php get_page_content(); ?></p>
		</div>
	</div>

	<div id="footer" class="shadow">
		<p>&copy; 2012 <a href="<?php get_site_url(); ?>"><?php get_site_name(); ?></a> | Template design by <a href="gsthemes.tk" target="_blank">GS Themes</a><br /><?php get_site_credits(); ?></p>
		<?php get_footer(); ?>
	</div>
</div>

<script type="text/javascript">
	$(window).load(function() {
		$('#slider').nivoSlider();
	});
</script>
</body>
</html>