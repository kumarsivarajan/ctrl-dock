<?include("config.php");$host_id=$_REQUEST["host_id"];$hostname=$_REQUEST["hostname"];?><br><br><h3>Kindly confirm if you wish to delete the host : <b><?echo $hostname;?></b></h3><a href=host_delete.php?host_id=<?echo $host_id?>><font face=Arial size=2 color=Red><b>YES</a>&nbsp;&nbsp;&nbsp;<a href=index.php><font face=Arial size=2 color=Green><b>NO</a>