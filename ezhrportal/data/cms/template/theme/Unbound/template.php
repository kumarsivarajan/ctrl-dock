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
<link rel="stylesheet" type="text/css" href="<?php get_theme_url(); ?>/3col.css" media="all"/>

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
	<!--Search Box -->	
		<form id="quick-search" action="index.html" method="get" >
			<p>
			<label for="qsearch">Search:</label>
			<input class="tbox" id="qsearch" type="text" name="qsearch" value="Search this site..." title="Start typing and hit ENTER" />
			<input class="btn" type="submit" value="Submit" />
			</p>
		</form>		
	
	<!-- header ends here -->
	</div>
	
	<!-- content starts -->
	<div id="content-outer" class="clear"><div id="content-wrapper">
	
		<!-- column-one -->
		<div id="content"><div class="col-one">
				
			<a name="TemplateInfo"></a>
			<h2><a href="index.html"><?php get_page_title(); ?></a></h2>			
			<p class="post-info">Published on &nbsp;<span><?php get_page_date('F jS, Y'); ?></span> </p>
			<?php get_page_content(); ?>            
			
		</div></div>
		
		<!-- column-two -->
		<div class="col-two">
			<h3>Sidebar Menu</h3>
			
			<ul class="sidemenu">				
				<?php get_navigation(return_page_slug()); ?>
			</ul>
			
	<h3>Help With this Theme</h3>
			<ul class="sidemenu">
                <li><a href="http://get-simple.info/forums/showthread.php?tid=4057" >Forum<br />
                <span>A Forum Thread just for this Theme</span></a>
                </li>
                <li><a href="http://get-simple.info/wiki/" >Wiki<br />
                <span>The General Purpose GetSimple Wiki</span></a>
                </li>
                <li><a href="http://www.styleshout.com/templates/preview/Unbound11/index.html" title="Website Hosting">styleshout.com<br />
                <span>The original static Unbound template</span>
                </a></li>
				<li><a href="http://timbowgs.bplaced.net/">Timbow's GS Site<br />
                <span>Including a working demo of Unbound with instructions for advanced setup</span>
                </a></li>
   			</ul>

			<?php get_component('sidebar');	?>		
			
		</div>
		
		<!-- column-three -->
		<div class="col-three">
		
			<h3>Simple Input Tabs<br/>Read This!</h3>
			<p>This version of the Unbound Theme for GetSimple is set up for use with the Simple Input Tabs Plugin. Apart form this default template the theme has three standard templates for one, two and three column layouts and three 'tabbed' templates set up for use with the Simple Input Tabs plugin. This plugin enables easy editing of the multiple content areas of a page like this. To use these templates you must install the Simple Input Tabs plugin and it's little brother the Small Plugin Toolkit from the <a href=http://www.get-simple.info/extend/ >GetSimple Extend Page</a></p>
			<p><img src="<?php get_theme_url(); ?>/images/erwin.jpg" width="40" height="40" alt="Erwin Aligam" class="float-left" />This is the Unbound Theme designed by Erwin Aligam and released under the <strong><a rel="license" href="http://creativecommons.org/licenses/by/2.5/"> Creative Commons Attribution 2.5 License</a>.</strong> I have adapted it as a GetSimple Theme.</p>
			<p><img src="<?php get_theme_url(); ?>/images/timbow.jpg" width="40" height="40" alt="Timbow" class="float-left" />This is the default page template in which I have left everything in, so you see two alternative nav menus, two search boxes and a lot of ideas for using the footer. For more general use I have made one, two, and three column templates with the search boxes and the sidebar nav menu commented out. You will find them ready in the GS Backend under Page Options when you edit a page.</p>
			
			
					
			<h3>Search Box</h3>	
			<form action="#" class="searchform">
				<p>
				<input name="search_query" class="textbox" type="text" />
  				<input name="search" class="button" value="Search" type="submit" />
				</p>			
			</form>							
			
		</div>	
	
	<!-- contents end here -->	
	</div></div>

	<!-- footer starts here -->	
	<div id="footer-wrapper">
	
		<!-- column-one -->
		<div id="footer"><div class="col-one">	
	
			<h3>Image Gallery </h3>					
				<p class="thumbs">
					<a href="index.html"><img src="<?php get_theme_url(); ?>/images/thumb-2.jpg" width="40" height="40" alt="thumbnail" /></a>
					<a href="index.html"><img src="<?php get_theme_url(); ?>/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>
					<a href="index.html"><img src="<?php get_theme_url(); ?>/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>
					<a href="index.html"><img src="<?php get_theme_url(); ?>/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>
					<a href="index.html"><img src="<?php get_theme_url(); ?>/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>
					<a href="index.html"><img src="<?php get_theme_url(); ?>/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>	
					<a href="index.html"><img src="<?php get_theme_url(); ?>/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>
					<a href="index.html"><img src="<?php get_theme_url(); ?>/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>
					<a href="index.html"><img src="<?php get_theme_url(); ?>/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>
					<a href="index.html"><img src="<?php get_theme_url(); ?>/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>
					<a href="index.html"><img src="<?php get_theme_url(); ?>/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>	
					<a href="index.html"><img src="<?php get_theme_url(); ?>/images/thumb.jpg" width="40" height="40" alt="thumbnail" /></a>
				</p>	
		
			<h3>Resources</h3>

                <p>
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum.
			    Cras id urna. Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu
			    posuere nunc justo tempus leo.
                </p>

				<ul class="footer-list">				
                    <li><a href="http://www.dreamtemplate.com" title="Website Templates">DreamTemplate -
                    <span>Over 6,000+ Premium Web Templates</span></a>
                    </li>
                    <li><a href="http://www.themelayouts.com" title="WordPress Themes">ThemeLayouts -
                    <span> Premium WordPress &amp; Joomla Themes</span></a>
                    </li>
                    <li><a href="http://www.imhosted.com" title="Website Hosting">ImHosted.com -
                    <span>Affordable Web Hosting Provider</span></a>
                    </li>
                    <li><a href="http://www.dreamstock.com" title="Stock Photos">DreamStock -
                    <span>Download Amazing Stock Photos</span></a>
                    </li>
                    <li><a href="http://www.evrsoft.com" title="Website Builder">Evrsoft -
                    <span>Website Builder Software &amp; Tools</span></a>
                    </li>
                    <li><a href="http://www.webhostingwp.com" title="Web Hosting">Web Hosting -
                    <span>Top 10 Hosting Reviews</span></a>
                    </li>
				</ul>			
						
		</div></div>
		
		<!-- column-two -->
		<div class="col-two">
		
			<h3>Lorem Ipsum</h3>			
			
			<p>
			<strong>Lorem ipsum dolor</strong> <br />
			Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. 
			Cras id urna. Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu 
			posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum 
			odio, ac blandit ante orci ut diam. <a href="index.html">Read more...</a>
			</p>
			
			<ul class="footer-list">				
				<li><a href="index.html">consequat molestie</a></li>
				<li><a href="index.html">sem justo</a></li>
				<li><a href="index.html">semper</a></li>
				<li><a href="index.html">magna sed purus</a></li>
				<li><a href="index.html">tincidunt</a></li>		
				<li><a href="index.html">semper</a></li>
				<li><a href="index.html">magna sed purus</a></li>
				<li><a href="index.html">tincidunt</a></li>				
			</ul>
				
		</div>		
	
		<!-- column-three -->
		<div class="col-three">
	
			<h3>About</h3>			
			
			<p>
			<a href="http://getfirefox.com/"><img src="<?php get_theme_url(); ?>/images/firefox-gray.jpg" width="40" height="40" alt="firefox" class="float-left" /></a>
			Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum.
			Cras id urna. Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu 
			posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum
			odio, ac blandit ante orci ut diam.</p>
			
			<p>
			Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. 
			Cras id urna. <a href="index.html">Learn more...</a></p>
						
		</div>	
	
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
