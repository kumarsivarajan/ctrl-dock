<?

/* Get correct id for plugin. */
$thisfile=basename(__FILE__, ".php");

/* Register plugin. */
register_plugin(
	$thisfile, 				# ID of plugin, should be filename minus php
	'rss feeder', 					# Title of plugin
	'0.1', 						# Version of plugin
	'Mikkel Bundgaard',						# Author of plugin
	'http://www.notfound.dk', 						# Author URL
	'A small rss feed reader', 						# Plugin Description
	'rss link', 					# Page type of plugin
	'rss_show(RSS link)'  	# Function that displays content
);



function show_rss($url) {

      $urlpage = $url;
	
     $dom = new DOMDocument();

     if (@$xml=simplexml_load_file($urlpage)) {

          // $title = $dom->getElementsByTagName("rdf:RDF");
          //$description = $dom->getElementsByTagName("description");

         //  $arr['id'] = $id;
           // $arr['title'] = $title->item(0)->textContent;
		
		//echo $xml->asXML();
		
	
	
	 foreach($xml->channel as $pChild) {
		
		   // echo "<h1>" . $pChild->title . "</h1>\n"; 
		    //echo "<p>"; 
		    //echo $pChild->description . "<br />"; 
		    //printf('Visit us at <a href="%s">%s</a><br />' . "\n",  $pChild->link, $pChild->link); 
		   // echo "</p>\n";
		
		
		foreach ($xml->item as $pItem) {
			
			unset($link);
			unset($title);
			unset($description);
			  foreach ($pItem->children() as $pChild)
			{
				
				 switch ($pChild->getName()) 
				    { 
					case 'title': 
					    //printf('<div class="rss_title">' . $pChild . '</div>'); 
					    $title = $pChild;
					    break; 
					     
					case 'link': 
					    $link = $pChild;
					    break; 
					case 'description': 
					    $description = $pChild;
					    break; 
					default: 
					    //echo nl2br($pChild) . "<br />"; 
					    break; 
				    } 
				if (isset($link) && isset($title) && isset($description)) {
				 printf('<h2><a href="%s">%s</a></h2>',$link,$title);
				 printf('<div id="rss:%s" class="rssdescription">%s</div>',$link,$description);
				 unset($link);
				 unset($title);
				}
			}
			
			
		
			
		}
	 }  
	//   echo $xml->asXML();
	   /*print($arr);
	   echo "<br/>";
	   $header = $arr[0];
	   
	   echo "TEST" . $header;
	   
	   echo "<br/>";*/
        }
	
       // $json= '('.json_encode($arr).');'; //must wrap in arens and end with semicolon
        //print_r($_GET['callback'].$json); //callback is prepended for json-p
}
 
 

// show_rss('http://wiki.notfound.dk/dokuwiki/feed.php');
 
?>
