<?php if(!defined('IN_GS')){ die('you cannot load this page directly.'); }
/****************************************************
*
* @File: 		template.php
* @Package:		GetSimple
* @Action:		Unbound theme for GetSimple CMS
*
*****************************************************/
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

<?php get_header(); ?>
<title>
		<?php if (function_exists('get_custom_title_tag'))
		{echo(get_custom_title_tag());}
		else { get_page_clean_title(); }  ?>
</title>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<meta name="author" content="Erwin Aligam - styleshout.com" />
<meta name="robots" content="index, follow, noarchive" />
<meta name="googlebot" content="noarchive" />

<link rel="stylesheet" type="text/css" href="<?php get_theme_url(); ?>/style.css" media="all"/>
<link rel="stylesheet" type="text/css" href="<?php get_theme_url(); ?>/1col.css" media="all"/>

</head>
<body id="<?php get_page_slug(); ?>">

	<!-- header starts-->
	<div id="header-wrap">			
				
		<div id="header-photo">
		<img alt="header photo" src="<?php get_theme_url(); ?>/images/header-photo.jpg" width="890" height="290" />
		</div>
		
		<h1 id="logo-text"><a href="<?php get_site_url(); ?>" title=""><?php get_site_name(); ?></a></h1>		
		<p id="intro"><?php get_component('tagline'); ?></p>		
		
		<div  id="nav">
			<ul>
				<?php get_navigation(return_page_slug()); ?>
			</ul>		
		</div>		
	<!--Search Box 
		<form id="quick-search" action="index.html" method="get" >
			<p>
			<label for="qsearch">Search:</label>
			<input class="tbox" id="qsearch" type="text" name="qsearch" value="Search this site..." title="Start typing and hit ENTER" />
			<input class="btn" type="submit" value="Submit" />
			</p>
		</form>		
	-->	
	<!-- header ends here -->
	</div>
	
	<!-- content starts -->
	<div id="content-outer" class="clear"><div id="content-wrapper">
	
		<!-- column-one -->
		<div id="content"><div class="col-one">
				
			<a name="TemplateInfo"></a>
			<h2><a href="index.html"><?php get_page_title(); ?></a></h2>			
			<p class="post-info">Published on &nbsp;<span><?php get_page_date('F jS, Y'); ?></span> </p>
			<?php insert_page_content(); ?>            
			
		</div></div>
	</div>
	</div>

	<!-- footer starts here -->	
	<div id="footer-wrapper">
	
		<!-- column-one -->
		<div id="footer"><div class="col-one">	
		
			<?php insert_page_content("foot_one"); ?>
		
		</div></div>
		
		
		<div id="footer-bottom">
			<?php get_footer(); ?>
			<p class="bottom-left">			
			    &nbsp; &copy;<?php echo date('Y'); ?> <strong><?php get_site_name(); ?></strong> &nbsp; &nbsp;
				<?php get_site_credits(); ?>&nbsp; &nbsp;
			    <a href="http://www.styleshout.com/">Template by styleshout</a>&nbsp; &nbsp;
				<a href="http://www.cyberpress.biz/">Ported by Cyberpress</a>
			</p>
			
			<p class="bottom-right" >
				<a href="<?php get_site_url(); ?>">Home</a> |
				<a href="<?php get_site_url(); ?>/admin">Admin</a> |
				<a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | 
		   	    <a href="http://validator.w3.org/check/referer">XHTML</a>
			</p>
	
		</div>	
			
	</div>
	<!-- footer ends here -->

</body>
</html>
