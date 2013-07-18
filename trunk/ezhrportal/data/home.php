<?
include_once("../ezportal/auth.php");
include_once("../ezportal/include/site_config.php");
include_once("../ezportal/include/css/home.css");
?>
<table border=0 cellspacing=0 cellpadding=5 width=100%>
<tr>
	<td width=210 align=center valign=top>
		<?include_once("menu/my_profile.php");?>
		<?include_once("menu/applications.php");?>
		
	</td>
	<td width=140 align=center valign=top>
	<?include_once("widgets/weather_blr.php");?>
	<?include_once("widgets/weather_mum.php");?>
	<?include_once("widgets/weather_del.php");?>
	<?include_once("widgets/weather_hyd.php");?>
	<?include_once("widgets/weather_sgp.php");?>
	<?include_once("widgets/weather_dub.php");?>
	<?include_once("widgets/weather_la.php");?>
	</td>
	<td align=center valign=top>
	<?include_once("widgets/directory_search.php");?>
	<?include_once("widgets/birthday.php");?>
	<?include_once("widgets/anniversary.php");?>
	<?include_once("widgets/rss_startup.php");?>
	</td>
</tr>
</table>