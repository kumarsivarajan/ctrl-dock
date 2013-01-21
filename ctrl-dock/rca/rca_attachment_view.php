<?php

$directory = "attachments/".$activity_id."/";
	
	
	if (file_exists($filename)) {          
    } else { mkdir($directory, 0777);   }  
	
	$target_path = $directory . basename( $_FILES['uploadedfile']['name']); 

	if (basename($_FILES['uploadedfile']['name'])){
		move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
	}
?>

<table border=1 width=100% cellspacing=0 cellpadding=5 style="border-collapse: collapse" bordercolor="#E5E5E5" bgcolor=#F5F5F5>
<tr><td class=reportheader style='text-align:left'><b>&nbsp;Attachments</font></b></td></tr>
<?

    $handler = opendir("$directory");
	$ctr=0;
    $filelist=array();
	while ($file = readdir($handler)) {
		if ($file != '.' && $file != '..'){
				$fullpath=$directory.$file;
		
				$datestamp = date("d M Y", filemtime($fullpath));
				$timestamp = date("H:i:s", filemtime($fullpath));
				

				$filelist[$ctr][0]=$file;
				$filelist[$ctr][1]=$fullpath;
				$filelist[$ctr][2]=$datestamp;
				$filelist[$ctr][3]=$timestamp;
				
            	$ctr=$ctr+1;        	
			
    	}
	}
    closedir($handler);
	
	$filelist=array_sort($filelist,0);
	$filecount=count($filelist);
	
	
	for($ctr=0;$ctr<$filecount;$ctr++){
				$slno=$ctr+1;
				$file=$filelist[$ctr][0];
				$fullpath=$filelist[$ctr][1];
				$datestamp=$filelist[$ctr][2];
				$timestamp=$filelist[$ctr][3];
				
				echo "<tr>";
				echo "<td class=reportdata>&nbsp;<a href='$fullpath'>$file</a></td>";
				echo "</tr>";
	}
	
	
	
function array_sort($array, $key) 
{ 
   foreach ($array as $i => $k) {
        $sort_values[$i] = $array[$i][$key]; 
   } 
   asort ($sort_values); 
   reset ($sort_values); 
   while (list ($arr_key, $arr_val) = each ($sort_values)) { 
          $sorted_arr[] = $array[$arr_key]; 
   } 
   return $sorted_arr; 
} 
?>
</table>
</center>
