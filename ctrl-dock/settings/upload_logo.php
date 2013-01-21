<?
include("config.php"); 

$directory = "../images/";
$filename  = "logo.png";
	
$target_path = $directory . $filename; 

if (basename($_FILES['uploadedfile']['name'])){
	move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
	?>
	<font face=Arial size=2><b>Logo was successfully uploaded. For changes to take effect, please log out and log back in.</b></font>
	<?
	
}
?>