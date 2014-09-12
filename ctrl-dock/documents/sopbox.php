<?
include_once("../auth.php");
include_once("../include/features.php");

if (check_feature(46)){
	$read=1;$write=0;$drop=1;
}
if ($read==0 && $write==0){
	?><font face=Arial size=2>This feature is not enabled for your profile</font><?
	exit;
}

$conf_chroot="files/SOPBOX";
if (!file_exists($conf_chroot)) {
    mkdir("$conf_chroot", 0777);
}


$conf_images    = 'images'; // Directory that contains the FileManager images
$conf_showdirs  = TRUE; // Show directories in the file list?
$conf_sort_dirs = TRUE; // Sort the directories by name (otherwise displayed in order of file system)
$conf_resolveid = FALSE; // Resolve UID / GID names?

// ini settings to allow long execution time, larger memory usage and large file uploads
ini_set("max_execution_time",60);
ini_set("upload_max_filesize","100M");
ini_set("memory_limit","32M");
ini_set("output_buffering",1);
ini_set("magic_quotes_gpc",0);

// Force no cache for this script so directories are reloaded correctly
header("Pragma: no-cache");
header("Cache-Control: no-store");


function download_file()
{
	global $conf_chroot;
	if (!isset($_GET['file']) || $_GET['file'] == '') {
		return;
	}
	$filename = basename($_GET['file']);
	$file     = $conf_chroot.format_path(dirname($_GET['file'])).$filename;
	if (!file_exists($file)) {
		die("No such file or directory");
	}
	$size     = filesize($file);
	header("Content-Type: application/save");
	header("Content-Length: $size");
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Transfer-Encoding: binary");
	if ($fp = fopen("$file", "rb")) {
		fpassthru($fp);
	}
	fclose($fp);
}


function recurse_paste_or_delete($file,$dest_dir,$action)
{
	global $conf_chroot;
	$dest = $conf_chroot.$dest_dir.basename($file);
	if (is_dir($file)) {
		$dir = substr($file,strrpos($file,'/')+1);
		if ($action == 'cut' || $action == 'copy') {
			if (($mod = fileperms($file)) === FALSE) {
				// if we cant read old dir mod, assume a safe default
				$mod = '0755';
			}
			mkdir($conf_chroot.$dest_dir.$dir,$mod);
		}
		$dh = @opendir($file);
		while (($name = readdir($dh)) !== FALSE) {
			if ($name != '.' && $name != '..') {
				recurse_paste_or_delete($file.'/'.$name,$dest_dir.$dir.'/',$action);
			}
		}
		@closedir($dh);
		if ($action == 'delete' || $action == 'cut') {
			rmdir($file);
		}
	} else switch ($action) {
		case 'cut':
			// Prior to PHP 4.3.3, rename() could not rename files across
			// partitions on *nix based systems
			$mod = fileperms($file);
			if (version_compare(phpversion(),'4.3.3') == -1) {
				if (copy($file,$dest)) {
					unlink($file);
				}
			} else {
				rename($file,$dest);
			}
			// Set dest file mods same as original
			if ($mod) {
				chmod($dest,$mod);
			}
			break;
		case 'copy':
			$mod = fileperms($file);
			copy($file,$dest);
			// Set dest file mods same as original
			if ($mod) {
				chmod($dest,$mod);
			}
			break;
		case 'delete':
			unlink($file);
			break;
	}
}

function paste_or_delete($action)
{
	global $current_path, $conf_chroot;
	reset($_SESSION['selected']);
	while (list(,$file) = each($_SESSION['selected'])) {
		$real_file = $conf_chroot.$file;
		if (file_exists($real_file)) {
			recurse_paste_or_delete($real_file,$current_path,$action);
		}
	}
	// w/o clearing stat cache, php would show deleted/moved files in readdir()
	clearstatcache();
}

function make_directory()
{
	global $conf_chroot, $conf_images, $current_path;
	
	if (!is_dir($conf_chroot.$current_path)) {
		// Quick check to see if path is a valid location.
		// Path it self is already filtered in main with format_path()
		die("Invalid path specified");
	}
	if (isset($_POST['dir']) && $_POST['dir'] != '') {		
		$dir = format_path($conf_chroot.$current_path.$_POST['dir']);
		$dir=getcwd().$dir;
		if (!mkdir($dir,0755)) {
			echo "<script>alert('Error making $dir');</script>\n";
		}
		else
		{
		$filename=$dir.'user_log_file.txt';
		fopen($filename, "w+");
		echo "<script>this.opener.location=this.opener.location; window.close();</script>";
		}
	} else {
		echo "<html><head><LINK href=\"$conf_images/fm.css\" rel=stylesheet></head><body>\n".
			 "<form action=\"{$_SERVER['PHP_SELF']}?event=mkdir&path=$current_path\" method=\"post\">".
		 	"<div class=uploadheader><br>Create Directory<br><br>".
		 	"<input type=\"text\" name=\"dir\" size=32><br><br>".
		 	"<input type=\"submit\" value=\"Create\"> <input type=button value=\"Cancel\" onClick=\"window.close();\"><br>".
		 	"</div></form></body></html>";
	}
}


function upload_file()
{
	global $conf_images, $conf_chroot, $current_path;
	if (!is_dir($conf_chroot.$current_path)) {
		// Quick check to see if path is a valid location.
		// Path it self is already filtered in main with format_path()
		die("Invalid path specified");
	}
	if (count($_FILES) == 0) {
		echo "<html><head><LINK href=\"$conf_images/fm.css\" rel=stylesheet></head><body>\n".
			 "<form action=\"{$_SERVER['PHP_SELF']}?event=upload&path=$current_path\" method=\"post\" ENCTYPE=\"multipart/form-data\">".
			 "<div class=uploadheader><br>Select File to Upload<br><br>".
			 "<input type=\"file\" name=\"userfile\" size=32><br><br>".
			 "<input type=\"submit\" value=\"Upload\"> <input type=button value=\"Cancel\" onClick=\"window.close();\"><br>".
			 "</div></form></body></html>";
	} else {
		if ($_FILES['userfile']['error'] !== 0) {
			switch ($_FILES['userfile']['error']) {
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					$reason = "File size exceeds max allowed";
				break;
				case UPLOAD_ERR_PARTIAL:
					$reason = "File only partialy uploaded";
					break;
				case UPLOAD_ERR_NO_FILE:
					$reason = "No file specified";
					break;
				default:
					$reason = "Unhandled error";
					break;
			}
			echo "<html><body><h1>Error uploading file: $reason</h1></body></html>";
		}
		$dest = $conf_chroot.$current_path.basename($_FILES['userfile']['name']);
		// move_uploaded_file prevents upload file injection attacks, etc so
		// doesn't need to be re-checked in userspace
		$logfile = $conf_chroot.$current_path.'user_log_file.txt';
		$fh = fopen($logfile, 'a') or die("can't open file");
		$stringData = $_SESSION['username']."\t".basename($_FILES['userfile']['name'])."\t".date("F j, Y, g:i a")."\n";
		fwrite($fh, $stringData);
		fclose($fh);
		if(file_exists($dest))
		{
			$newfilename=$conf_chroot.$current_path.'old'.'_'.basename($_FILES['userfile']['name']);
			rename($dest, $newfilename);
			move_uploaded_file($_FILES['userfile']['tmp_name'], $dest);
			echo "<script>this.opener.location=this.opener.location; window.close();</script>";
		}
		else
		{
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $dest)) {
			echo "<script>this.opener.location=this.opener.location; window.close();</script>";
		} else {
			echo "<html><body><h1>Error uploading file: Possible file upload attack!</h1></body></html>";
		}
		}
	}
}


function draw_files()
{
	global $current_path, $conf_chroot, $conf_sort_dirs, $conf_showdirs, $conf_images,
		   $total_files, $total_size, $total_dirs, $write, $read, $drop;
	$path        = $conf_chroot."/".$current_path;
	$total_files = 0;
	$total_size  = 0;
	echo "<td width=100% height=100% align=left valign=top>\n".
		 "<div style=\"width: 100%; height: 100%; overflow: auto;\">\n".
		 "<table cellspacing=0 cellpadding=0 height=100% width=100%>\n".
		 "<form name=\"selectform\" method=\"post\" action=\"{$_SERVER['PHP_SELF']}?path=$current_path\">\n".
		 "<input type=\"hidden\" name=\"action\" value=\"\">\n".
		 "<tr>\n".
		 "<td class=fileheader align=center ><b>File / Folder Name</b></td>\n".
		 "<td class=fileheader align=center><b>Size</b></td>\n".
		 "<td class=fileheader align=center><b>Date / Time</b></td>\n".
		 "<td class=fileheader align=center><b>&nbsp;</b></td>\n";
	if ($drop==1){ 
		echo "<td class=fileheader align=center><b>&nbsp;</b></td>\n";
	}
	echo "<td class=fileheader align=center><b>&nbsp;</b></td>\n".
		 "</tr>\n";
	if (!$dh   = opendir($path)) {
		die("Fatal error opening $path");
	}
	$files = array();
	$dirs  = array();
	while (($name = readdir($dh)) !== FALSE) {
		$stat          = stat("$path/$name");
		$file['name']  = $name;
		$file['size']  = format_size($stat['size']);
		$file['date']  = date("d-M-Y H:i",$stat['mtime']);
		if (is_link("$path/$name")) {
			$file['link'] = "<font color=blue><i> --> ".readlink("$path/$name")."</i></font>";
		} else {
			$file['link'] = '';
		}
		if (is_dir("$path/$name")) {
			$total_dirs++;
			if ($conf_showdirs) {
				$dirs[$name]  = $file;
			}
		} else {
			$files[$name] = $file;
			$total_files++;
			$total_size += $stat['size'];
		}
	}
	closedir($dh);
	reset($files);
	reset($dirs);
	if ($conf_sort_dirs) {
		ksort($files);
		ksort($dirs);
	}
	while (list(,$file) = each($dirs)) {
		if (($file['name'] != '.') && 
			($current_path != '/' || $file['name'] != '..')) {
			if ($file['name'] == '..') {
				$tmp = substr($current_path,0,strlen($current_path)-1);
				$tmp = substr($tmp,0,strrpos($tmp,'/'));
				if ($tmp != '') {
					$link = $_SERVER['PHP_SELF']."?path=$tmp";
				} else {
					$link = $_SERVER['PHP_SELF'];
				}
			} else {
				$link = $_SERVER['PHP_SELF']."?path=$current_path{$file['name']}";
			}
			if ($file['name'] == '..') {
				$icon = 'folder-up.gif';
			} else {
				$icon = 'folder.gif';
			}
			echo "<tr>\n".
			 	 "<td class=fileentry><img src=\"$conf_images/$icon\" width=16 height=16 align=left>&nbsp;&nbsp;<a href=\"{$_SERVER['PHP_SELF']}?path=$parent$current_path{$file['name']}\"><b>{$file['name']}</b>{$file['link']}<a></td>\n".
				 "<td class=fileentry>&nbsp;</td>\n".
			 	 "<td class=fileentry align=center>{$file['date']}</td>\n".
			 	 "<td class=fileentry>&nbsp;</td>\n";
			if ($file['name'] == '..') {
				echo "<td class=fileentry>&nbsp;</td>\n";
			} else {
				echo "<td class=fileentry align=center><input type=checkbox name=selected[] value=\"$current_path{$file['name']}\"></td>\n";
			}
			echo "</tr>\n";
		}
	}
	$icons = array(
		'text'    => array('txt'),
		'word'    => array('doc','docx','rtf'),
		'excel'   => array('xls','xlsx'),
		'media'   => array('mp3','mpg','mpeg','avi'),
		'image'   => array('gif','jpg','jpeg','png','svg','ico','tiff','tff','swg','psd','pdd','bmp','rle','eps','jpe','pcx','pct','raw','dib'),
		'conf'    => array('ini','conf','cfg'),
		'web'     => array('html','htm','asp','cfm','php','php3','php4','php5','shtm','shtml','xhtml','xml','wdsl','xsl','rss','rdf','dtd','xsd','css','js','asa','tpl','wml','vtm','vtml'),
		'archive' => array('rpm','zip','rar','bz2','gz','gzip','arj','lzh','tar','dep')
	);
	while (list(,$file) = each($files)) {
		$icon = 'document.gif';
		if (($pos = strrpos($file['name'],'.')) !== FALSE) {
			$pos++;
			$ext = strtolower(substr($file['name'],$pos));
			reset($icons);
			while (list($icon_name,$exts) = each($icons)) {
				if (in_array($ext,$exts)) {
					$icon = 'document-'.$icon_name.'.gif';
				}
			}
		}
		if($file['name'] != 'user_log_file.txt')
		{
		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
		echo "<tr>\n".
			 "<td class=fileentry><img src=\"$conf_images/$icon\" width=16 height=16 align=left>&nbsp;&nbsp;<a href=\"$conf_chroot$current_path{$file['name']}\">{$file['name']}<a></td>\n".
			 "<td class=fileentry >&nbsp;&nbsp;{$file['size']}</td>\n".
			 "<td class=fileentry align=center>{$file['date']}</td>\n".
		 	 "<td class=fileentry align=center><a href=\"{$_SERVER['PHP_SELF']}?file=$current_path{$file['name']}&event=download\" alt=\"Download this file\"><img src=\"$conf_images/save.gif\" width=16 height=16></a></td>\n";
			 if(!in_array($ext,$icons['archive']))
			 {
		echo"<td class=fileentry align=center><input type=checkbox name=selected[] value=\"$current_path{$file['name']}\"></td>\n".
			 "</tr>\n";
			 }
			 else
			 {
				echo"<td class=fileentry align=center>&nbsp;</td>\n".
			 "</tr>\n";
			 }
		}	 
	}
	if (isset($_SESSION['action']) && ($_SESSION['action'] == 'cut' || $_SESSION['action'] == 'copy')) {
		$disabled = '';
	} else {
		$disabled = 'DISABLED';
	}
	
	
	if ($write==1){
	echo "<tr><td height=100% valign=bottom align=left colspan=8><p align=center><br>\n".
		 "<input class=button type=\"button\" value=\"Cut\" onClick=\"document.selectform.action.value='cut'; document.selectform.submit();\">".
		 "<input class=button type=\"button\" value=\"Copy\" onClick=\"document.selectform.action.value='copy'; document.selectform.submit();\">".
		 "<input class=button type=\"button\" value=\"Paste\" onClick=\"document.selectform.action.value='paste'; document.selectform.submit();\" $disabled>".
		 "<input class=button type=\"button\" value=\"Delete\" onClick=\"if (confirm('Delete file(s)?')) { document.selectform.action.value='delete'; document.selectform.submit(); }\">".
		 "<input class=button type=\"button\" value=\"Create Folder\" onClick=\"window.open('{$_SERVER['PHP_SELF']}?event=mkdir&path=$current_path','win_create','width=320,height=140,fullscreen=no,scrollbars=no,resizable=no,status=no,toolbar=no,menubar=no,location=no')\">".
		 "<input class=button type=\"button\" value=\"Upload\" onClick=\"window.open('{$_SERVER['PHP_SELF']}?event=upload&path=$current_path','win_upload','width=320,height=140,fullscreen=no,scrollbars=no,resizable=no,status=no,toolbar=no,menubar=no,location=no')\">".
		 "<br>&nbsp;</p></td></tr>\n".
		 "</form>\n".
	 	 "</table>\n".
		 "</div>\n".
	     "</td>\n</tr>\n";
	}else{
		echo "<tr><td height=100% valign=bottom align=left colspan=8><p align=center><br>\n".
		 "<br>&nbsp;</p></td></tr>\n".
		 "</form>\n".
	 	 "</table>\n".
		 "</div>\n".
	     "</td>\n</tr>\n";
	}	
}


function draw_tree()
{
	global $current_path, $conf_images;
	echo "<tr><td width=200 align=left valign=top height=100%>\n".
		 "<div class=\"treeview\">\n".
		 "<table cellspacing=0 cellpadding=0>";
	recurse_draw_tree(get_tree($current_path,0),'','');
	echo "</table>\n".
		 "</div>\n".
	     "</td>\n";

}


function recurse_draw_tree($tree, $spacing, $parent)
{
	global $conf_images;
	$tree_mid      = "<img align=left src=\"$conf_images/tree-mid.gif\" width=16 height=22 vspace=0 hspace=0>";
	$tree_end      = "<img align=left src=\"$conf_images/tree-end.gif\" width=16 height=22 vspace=0 hspace=0>";
	$tree_blank    = "<img align=left src=\"$conf_images/tree-blank.gif\" width=16 height=22 vspace=0 hspace=0>";
	$tree_straight = "<img align=left src=\"$conf_images/tree-straight.gif\" width=16 height=22 vspace=0 hspace=0>";
	$folder_open   = "<img align=left src=\"$conf_images/tree-folder-open.gif\" width=24 height=22 vspace=0 hspace=0>";
	$folder_closed = "<img align=left src=\"$conf_images/tree-folder-closed.gif\" width=24 height=22 vspace=0 hspace=0>";
	if ($parent == '') {
		// top level, draw /
		echo "<tr><td height=22 align=left><a href=\"{$_SERVER['PHP_SELF']}?path=/\">$folder_open/</a></td></tr>\n";
	}
	$count = count($tree);
	$i     = 0;
	reset($tree);
	while (list($dir,$subs) = each($tree)) {
		$result = $spacing;
		if ($i != $count-1) {
			$result .= $tree_mid;
		} else {
			$result .= $tree_end;
		}
		if ($subs !== FALSE) {
			$result .= $folder_open;
		} else { // not expanded
			$result .= $folder_closed;
		}
		$result .= $dir;
		echo "<tr><td height=22 align=left><a href=\"{$_SERVER['PHP_SELF']}?path=$parent/$dir\">$result</a></td></tr>\n";
		if ($subs !== FALSE) {
			if ($i == $count-1) {
				$sp = $tree_blank;
			} else {
				$sp = $tree_straight;
			}   
			$sp = $spacing.$sp;
			recurse_draw_tree($subs,$sp,"$parent/$dir");
		}
		$i++;
	}
}


function get_tree($path,$level)
{
	global $conf_chroot,$conf_sort_dirs;
	$path_components = explode('/',$path);
	$current_path    = $conf_chroot."/";
	$ret             = array();
	// construct the path we are now traversing
	if ($level > 0) {
		for ($i = 0 ; $i <= $level; $i++) {
			$current_path .= $path_components[$i]."/";
		}
	}
	if (($dh = opendir($current_path)) === FALSE) {
		die("Fatal error trying to read directory: $path<br>");
	}
	while (($dir = readdir($dh)) !== FALSE) {
		if (is_dir("$current_path/$dir") && $dir != '.' && $dir != '..') {
			if ((count($path_components) > ($level+1)) && $dir == $path_components[$level+1]) {
				$ret[$dir] = get_tree($path,$level+1);
			} else {
				$ret[$dir] = FALSE;
			}
		}
	}
	closedir($dh);
	if ($conf_sort_dirs) ksort($ret);
	return $ret;
}


function format_size($arg)
{
	if ($arg > 0) {
		$j = 0;
		$ext = array(" bytes"," Kb"," Mb"," Gb"," Tb");
		while ($arg >= pow(1024,$j)) {
			++$j;
		}
		return round($arg / pow(1024,$j-1) * 100) / 100 . $ext[$j-1];
	}
	return "0 Mb";
}


function format_path($str)
{
	$str  = trim(str_replace("..","",str_replace("\\","/",str_replace("\$","",$str))));
	while ($str != ($str = str_replace("//","/",$str))) {}
    if (strlen($str)) {
		if ($str[0] != "/") {
			$str = "/".$str;
		}
        if ($str[strlen($str)-1] != "/") {
			$str .= "/";
		}
    } else {
		$str = "/";
	}
	return $str;
}


function draw_header()
{
	global $conf_images;
?>
<html>
<head>
<LINK href="<? echo $conf_images; ?>/fm.css" rel=stylesheet>
<title>Documents</title>
</head>
<body>
<center>
<table cellspacing=0 cellpadding=0 width="100%" height="100%" border=1 style="border-collapse: collapse" bordercolor="#666666">
<?
}

function draw_footer()
{
	global $total_dirs, $total_files, $total_size, $conf_chroot, $current_path,$rep_base,$conf_images,$drop;
		
?>
<tr>
<td colspan=2 bgcolor=#666666 height=30>
</td>
</tr>
</table>
</body>
</html>
<?
}

function draw_location()
{
	global $current_path,$conf_images,$rep_base;
?>
<tr>
	<td colspan=1 align=left valign=middle bgcolor=#666666>	
	<font face=Arial size=2 color=white><b>&nbsp;&nbsp;Browsing SOPBOX</b></font>
	</td>
	<td colspan=1 align=left valign=middle bgcolor=#666666>	
				<div class="taskicon"><img src="<? echo $conf_images; ?>/task_view.png"></a></div>
			<div class="tasktitle"><? echo $rep_base ?><? echo $current_path; ?>&nbsp;&nbsp;&nbsp;&nbsp;</div>

	</td>
</tr>
<?
}


if (isset($_GET['event'])) {
	$event = $_GET['event'];
} else {
	$event = 'view';
}

if (isset($_GET['path'])) {
	$current_path = format_path($_GET['path']);
} else {
	$current_path = '/';
}

session_start();
if (isset($_POST['action'])) {
	switch ($_POST['action']) {
		case 'cut':
		case 'copy':
			if (isset($_POST['selected']) && count($_POST['selected'])) {
				$_SESSION['source']   = $current_path;
				$_SESSION['action']   = $_POST['action'];
				$_SESSION['selected'] = $_POST['selected'];
			}
			break;
		case 'paste':
			if ($_SESSION['action'] != 'copy' || $_SESSION['action'] != 'cut') {
				if (isset($_SESSION['source']) && $_SESSION['source'] != $current_path) {
					paste_or_delete($_SESSION['action']);
					if (isset($_SESSION['source']))   unset($_SESSION['source']);
					if (isset($_SESSION['selected'])) unset($_SESSION['selected']);
					if (isset($_SESSION['action']))   unset($_SESSION['action']);
				} else {
					echo "\n<script>alert('Can\'t {$_SESSION['action']} file(s). Source and destination are the same');</script>\n";
				}
			}
			break;
		case 'delete':
			$_SESSION['action']   = $_POST['action'];
			$_SESSION['selected'] = $_POST['selected'];
			paste_or_delete('delete');
			if (isset($_SESSION['source']))   unset($_SESSION['source']);
			if (isset($_SESSION['selected'])) unset($_SESSION['selected']);
			if (isset($_SESSION['action']))   unset($_SESSION['action']);
			break;
		default:
			die("Invalid action specified");
			break;
	}
}


switch ($event) {
	case 'view':
		draw_header();
		draw_location();
		draw_tree();
		draw_files();
		draw_footer();
		break;
	case 'upload':
		upload_file();
		break;
	case 'mkdir':
		make_directory();
		break;
	case 'download':
		download_file();
		break;
	case 'passwd':
		change_passwd();
		break;
	default:
		die('Invalid event');
		break;
}


?>
