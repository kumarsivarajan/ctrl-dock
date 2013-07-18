<?php if(!defined('IN_GS')){ die('you cannot load this page directly.'); }
/****************************************************
*
* @File: 		template.php
* @Package:		GetSimple
* @Action:		SimpleMin640 Theme for GetSimple CMS
*				
*****************************************************/
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Language" content="English" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php get_header(); ?>
<title>
	<?php if (function_exists('get_custom_title_tag'))
	{echo(get_custom_title_tag());}
	else { get_page_clean_title(); }  ?>
</title>
    <link rel="stylesheet" type="text/css" href="<?php get_theme_url(); ?>/style.css" />
</head>

<body id="<?php get_page_slug(); ?>">

<div id="wrap"> 

	<div id="header">
		<h1><a href="<?php get_site_url(); ?>"><?php get_site_name(); ?></a></h1>
		<h2><?php get_component('tagline'); ?></h2>
	</div> 

	<div class="right">
		<h1> <?php get_page_title(); ?> </h1>
		<?php get_page_content(); ?>
	</div>

	<div class="left">
		<ul>
			<?php get_navigation(return_page_slug()); ?>
		</ul>
		<?php get_component('sidebar'); ?>

	</div>

	<div style="clear: both;"> </div>




	<div class="footer">
		<?php get_footer(); ?>
		 &copy;<?php echo date('Y'); ?> <strong><?php get_site_name(); ?></strong>
		 &nbsp; &nbsp;|&nbsp; &nbsp;<?php get_site_credits(); ?>
		 &nbsp; &nbsp;|&nbsp; &nbsp;<a href="http://www.free-css-templates.com/">Free CSS Templates</a>
		 &nbsp; &nbsp;|&nbsp; &nbsp;<a href="http://www.cyberpress.biz/">cyberpress</a>
	 </div>

</div>

</body>
</html>