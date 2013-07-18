<?php if(!defined('IN_GS')){ die('you cannot load this page directly.'); }

/****************************************************
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 3.0 License
Name       : Big Business 2.0
Description: A two-column, fixed-width design with a bright color scheme.
Version    : 1.0
Released   : 20120326
GSbigbusiness theme for GetSimple CMS Released   : 20121221
***************************************************/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

<title><?php get_page_clean_title(); ?> | <?php get_site_name(); ?>, <?php get_component('tagline'); ?></title>
  <?php get_header(); ?>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php get_theme_url(); ?>/style.css" />
<script type="text/javascript" src="<?php get_theme_url(); ?>/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php get_theme_url(); ?>/jquery.dropotron-1.0.js"></script>
<script type="text/javascript" src="<?php get_theme_url(); ?>/jquery.slidertron-1.1.js"></script>
<script type="text/javascript">
	$(function() {
		$('#menu > ul').dropotron({
			mode: 'fade',
			globalOffsetY: 11,
			offsetY: -15
		});
		$('#slider').slidertron({
			viewerSelector: '.viewer',
			indicatorSelector: '.indicator span',
			reelSelector: '.reel',
			slidesSelector: '.slide',
			speed: 'slow',
			advanceDelay: 4000
		});
	});
</script>
</head>
<body>
<div id="wrapper">
	<div id="header">
		<div id="logo">
			<h1><a href="<?php get_site_url(); ?>"><?php get_site_name(); ?></a></h1>
		</div>
		<div id="slogan">
			<h2><?php get_component('tagline'); ?></h2>
		</div>
	</div>
	<div id="menu">
		<ul>
					<?php if(function_exists(get_i18n_navigation)){ get_i18n_navigation($slug, $minlevel=0, $maxlevel=10, $show=I18N_SHOW_MENU, $component=null); 
       } else { get_navigation(get_page_slug(FALSE)); } ?>
		</ul>
		<br class="clearfix" />
	</div>
	<div id="slider">
		<?php get_component('slidebigbusiness'); ?>
		</div>
		<div class="indicator">
			<span>1</span>
			<span>2</span>
			<span>3</span>
			<span>4</span>
			<span>5</span>
		</div>
	</div>
	<div id="page">
		<div id="content">
			<div class="box">
				<h2><?php get_page_title(); ?></h2>
				<p><div id="page-content">
				<div class="page-text">
					<?php get_page_content(); ?>
				</div>
			</div></p>
			</div>
			
			<br class="clearfix" />
		</div>
				<div id="sidebar">
					<div class="box">
						<p><?php get_component('sidebar'); ?></p>
				</div>
				<br class="clearfix" />
			</div>
		</div>
		<div id="footer">
		  <p><?php echo date('Y'); ?> &copy; <?php get_site_name(); ?> | Design by <a href="http://nodethirtythree.com" target="_blank">nodethirtythree</a> and <a href="http://www.freecsstemplates.org/" target="_blank">FCT</a> | <a href="http://get-simple.info" target="_blank">Adapted for Getsimple</a> by <a href="http://studiobox.fr/" target="_blank">JLM</a></p>
    </div>
</body>
</html>