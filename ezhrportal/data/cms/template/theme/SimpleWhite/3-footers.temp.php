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
		<h2><?php get_page_title(); ?></h2>
		<p><?php get_page_content(); ?></p>
	</div>

	<div id="extended" class="clearfix shadow">
		<div id="trio1">
			<div class="inner">
				<h3>Standards-compliant code</h3>
				<p>The SimpleWhite template is written with standards-compliant HTML5 and CSS3.</p>
			</div>
		</div>

		<div id="trio2">
			<div class="inner">
				<h3>Slider included</h3>
				<p>The slider is made with a jQuery plugin called <a href="http://nivo.dev7studios.com">Nivo Slider</a>, created by Gilbert Pellegrom of dev7studios and released under the <a href="http://www.opensource.org/licenses/mit-license.php">MIT Licence</a>.</p>
			</div>
		</div>

		<div id="trio3">
			<div class="inner">
				<h3>Multiple layout options</h3>
				<p>Single-column, two columns with left or right sidebars, three columns - or a combination of any two layout options.</p>
			</div>
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