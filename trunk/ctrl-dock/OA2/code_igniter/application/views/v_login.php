<?php
/**
 * OAv2
 *
 * An open source network auditing application
 *
 * @package OAv2
 * @author Mark Unwin <mark.unwin@gmail.com>
 * @version beta 8
 * @copyright Copyright (c) 2011, Mark Unwin
 * @license http://www.gnu.org/licenses/agpl-3.0.html aGPL v3
 */
include("../include/config.php");
$base_url="http://";
if ($HTTPS==1){$base_url="https://";}
$base_url.=$_SERVER["SERVER_NAME"]."/".$INSTALL_HOME;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
var x = new XMLHttpRequest();
x.open("GET", "<?=$base_url;?>api/dock_auth.php", true);
x.onreadystatechange = function () {
  if (x.readyState == 4 && x.status == 200)
  {
    var doc = x.responseXML;
	var status = doc.getElementsByTagName("node")[0].getElementsByTagName("status")[0].firstChild.nodeValue;
	if (status==1){
		setTimeout("document.getElementById('loginform').submit();",1000);
	}
	if (status==0){
		window.location.href = "<?=$base_url;?>index.php";
	}
  }
};
x.send(null);
</script>

<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon" />
	<style type="text/css">
	#container { width: 950px; margin: 0 auto; padding: 10px 0;}
	a { color: #101010; text-decoration: none }
	a:hover { color: #729FCF; }
	body { font-family:"Arial"; background: #dcd2bd; font-size:12px; color:#111;}
	h2 { border-color:#DBD9C5; border-style:solid; border-width:0pt 0pt 1px; color:#555555; font-size:22px; font-weight:bold; padding:0px 0px 1px; }
	img {border:0;}
	</style>
</head>
<body onload="document.myform.username.focus();">
<SCRIPT LANGUAGE="JavaScript"> 
	setTimeout("document.getElementById('loginform').submit();",2000);
</SCRIPT>
<div id="header" style='height: 200px; width: 950px; margin-left: auto; margin-right: auto; padding: 20px; border: 10px;' align='left'>
	<?php $attributes = array ('name' => 'myform','id'=>'loginform'); ?>
	<?php echo form_open('login/process_login', $attributes, $hidden) . "\n"; ?>
			<div align='left' style="height: 150px; width:60%; float: left; valign: center; text-align: center;">
			</div>
			<div align='right' style="height: 150px; width:40%; float: right; text-align: center;">
        		<p><input type="hidden" name="username" id="username" value="admin"/></p>
        		<p><input type="hidden" name="password" id="password"  value="password" /></p>
			</div>
	<?php echo form_close(); ?>
	<?php if ($systems == '0' ) {
		}
	?>
</div>
<script type="text/javascript">
	function audit_my_pc() {
		location.href = "audit_my_pc";
	}
</script>
</body>
</html>
