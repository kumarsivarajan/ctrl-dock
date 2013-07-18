<?
include("config.php"); 

$account=$_REQUEST["account"];
$directory = "../../data/user_photos/";
$filename=$account.".jpg";
	
//$target_path = $directory . basename( $_FILES['uploadedfile']['name']); 
$target_path = $directory . $filename; 

if (basename($_FILES['uploadedfile']['name'])){
	move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
	?>
	<font face=Arial size=2><b>Photo was successfully uploaded, please wait ....</b></font>
	<meta http-equiv="refresh" content="2;url=edit_personal_information_1.php?account=<?echo $account;?>" /> 
	<?
	
}
?>