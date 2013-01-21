<?php
/**********************************************************************************************************
Module:	system_viewdef_summary.php

Description:
	Menu and SQL query definition for computer system summary page
	
Change Control:

	[Nick Brown]	03/04/2009
	Added "uuid" parameter to the user and computer ldap links
	
**********************************************************************************************************/
include "include_config.php";
include_once "include_functions.php";
$query_array=array("name"=>array("name"=>__("Summary"),
                                 "sql"=>"SELECT `system_name` FROM `system` WHERE `system_uuid` = '" . $_GET["pc"] . "'",
                                ),
                   "views"=>array("summary"=>array(
                                                    "headline"=>__("System"),
                                                    "sql"=>"SELECT * FROM system
                                                            LEFT JOIN network_card ON (system_uuid=net_uuid AND system_timestamp=net_timestamp AND system.net_ip_address = network_card.net_ip_address)
                                                            WHERE system_uuid = '" . $_REQUEST["pc"] . "' AND  system_timestamp = '".$GLOBAL["system_timestamp"]."'
                                                            LIMIT 0,1",
                                                    "image"=>"images/os_l.png",
                                                    "fields"=>array("10"=>array("name"=>"net_uuid",
                                                                                "show"=>"n",
                                                                               ),
                                                                    "20"=>array("name"=>"system_name", "head"=>__("System Name"),),
                                                                    // Include a blank entry as a place holder so we can add the LDAP details tab at the end  if required (AJH)
                                                                    "25"=>array("name"=>"", "head"=>__(""),),                                                                                 
                                                                    "30"=>array("name"=>"system_description", "head"=>__("Description"),),
                                                                    "40"=>array("name"=>"net_domain_role", "head"=>__("Domain Role"),),
                                                                    "50"=>array("name"=>"system_registered_user", "head"=>__("Registered User"),),
                                                                    "60"=>array("name"=>"net_user_name", "head"=>__("Current User"),),
                                                                    // Include a blank entry as a place holder so we can add the LDAP details tab at the end  if required (AJH)
                                                                    "65"=>array("name"=>"", "head"=>__(""),),                                                                                 
                                                                    "70"=>array("name"=>"net_domain", "head"=>__("Domain"),),
                                                                    "80"=>array("name"=>"system_system_type", "head"=>__("Chassis Type"),),
                                                                    "90"=>array("name"=>"system_model", "head"=>__("Model #"),),
                                                                    "100"=>array("name"=>"system_id_number", "head"=>__("Serial #"),),
                                                                    "110"=>array("name"=>"system_vendor", "head"=>__("Manufacturer"),),
                                                                    "120"=>array("name"=>"system_os_name", "head"=>__("Operating System"),),
                                                                    "130"=>array("name"=>"system_build_number", "head"=>__("Build Number"),),
                                                                    "140"=>array("name"=>"system_uuid", "head"=>__("UUID"),),
                                                                    "150"=>array("name"=>"date_system_install", "head"=>__("OS Installed Date"),),
                                                                    "160"=>array("name"=>"net_ip_address", "head"=>__("IP"),),
                                                                    "170"=>array("name"=>"net_ip_subnet", "head"=>__("Subnet"),),
                                                                    "180"=>array("name"=>"net_dhcp_server", "head"=>__("DHCP"),),
                                                                    "190"=>array("name"=>"system_first_timestamp", "head"=>__("Date First Audited"),),
                                                                    "200"=>array("name"=>"system_timestamp", "head"=>__("Date Last Audited"),),
                                                                    "210"=>array("name"=>"system_memory", "head"=>__("Memory"),),
                                                                   ),
                                                ),

                                 ),
                  );
              
if ((isset($use_ldap_integration))and($use_ldap_integration == 'y')) {

    if ((isset($full_details))and ($full_details  == 'y')) {
    $query_array['views']['summary']['fields']['25']=array("name"=>"system_name", "head"=>__("Directory Info"),
                                                                        "get"=>array("head"=>__("Computer Details"),
                                                                                             "file"=>"ldap_details.php",
                                                                                             //"%net_user_name"
                                                                                             "title"=>__("Advanced Computer Details"),
                                                                                             //"name"=>"%net_user_name",                                                                                             
                                                                                             "image"=>"./images/o_terminal_server.png",
                                                                                             "image_width"=>"16",
                                                                                             "image_height"=>"16",
                                                                                             "var"=>array("name"=>"%system_name",
                                                                                                          "full_details"=> "y",
                                                                                                          "record_type" => "computer",
																																																					"uuid" => "%system_uuid"
                                                                                                         ),
                                                                                            ),
                                                                              );
                                                                          
       $query_array['views']['summary']['fields']['65']=array("name"=>"net_user_name", "head"=>__("Directory Info"),
                                                                        "get"=>array("head"=>__("User Details"),
                                                                                             "file"=>"ldap_details.php",
                                                                                             //"%net_user_name"
                                                                                             "title"=>__("Advanced User Details"),
                                                                                             //"name"=>"%net_user_name",                                                                                             
                                                                                             "image"=>"./images/groups_l.png",
                                                                                             "image_width"=>"16",
                                                                                             "image_height"=>"16",
                                                                                             "var"=>array("name"=>"%net_user_name",
                                                                                                          "full_details"=> "y",
                                                                                                          "record_type" => "user",
																																																					"uuid" => "%system_uuid"
                                                                                                         ),
                                                                                            ),
                                                                              );                                                                          
                                                                              
                                  } else {
   $query_array['views']['summary']['fields']['25']=array("name"=>"system_name", "head"=>__("Directory Info"),
                                                                        "get"=>array("head"=>__("Computer Details"),
                                                                                             "file"=>"ldap_details.php",
                                                                                             //"%net_user_name"
                                                                                             "title"=>__("Computer Details"),
                                                                                             //"name"=>"%net_user_name",                                                                                             
                                                                                             "image"=>"./images/o_terminal_server.png",
                                                                                             "image_width"=>"16",
                                                                                             "image_height"=>"16",
                                                                                             "var"=>array("name"=>"%system_name",
                                                                                                          "full_details"=> "n",
                                                                                                          "record_type" => "computer",
																																																					"uuid" => "%system_uuid"
                                                                                                         ),
                                                                                            ),
                                                                              );                                      
    $query_array['views']['summary']['fields']['65']=array("name"=>"net_user_name", "head"=>__("Directory Info"),
                                                                        "get"=>array("head"=>__("User Details"),
                                                                                             "file"=>"ldap_details.php",
                                                                                             //"%net_user_name"
                                                                                             "title"=>__("User Details"),
                                                                                             //"name"=>"%net_user_name",                                                                                             
                                                                                             "image"=>"./images/groups_l.png",
                                                                                             "image_width"=>"16",
                                                                                             "image_height"=>"16",
                                                                                             "var"=>array("name"=>"%net_user_name",
                                                                                                         "full_details"=> "n",
                                                                                                          "record_type" => "user",
																																																					"uuid" => "%system_uuid"
                                                                                                         ),
                                                                                            ),
                                                                              );                                  
                                }
                            }
 
 // Look for a suitable picture in the images/equipment folder.
 // If present, show the correct image in place of the default picture.
   $db = mysql_connect($mysql_server,$mysql_user,$mysql_password) or die('Could not connect: ' . mysql_error());
  mysql_select_db($mysql_database,$db);
     $sql="SELECT system_model, system_uuid FROM `system` WHERE `system_uuid` = '".$_REQUEST["pc"]."'; ";
  $result = mysql_query($sql, $db);
  $myrow = mysql_fetch_array($result);

       $result_model = str_replace('/', '', $myrow["system_model"]);
        $filename = 'images/equipment/'.$result_model.'.jpg';
        
        $filename = strtolower($filename);

        if (file_exists($filename)) {
        // FIXME: OK We got a good image,but we need to make it a bit bigger than the default of 16 x 16 . 
        $scale_image_by = "3.5";
        $query_array['views']['management']['image'] = $filename ;

        // Replace the default "image_width"=>"16",
        // and "image_height"=>"16", Adjust to suit the size of your images
        $query_array['views']['management']['image_width'] = $query_array['views']['management']['image_width'] *$scale_image_by  ;  //      
        $query_array['views']['management']['image_height'] =  $query_array['views']['management']['image_height'] * $scale_image_by ;

     } else {
        // echo $filename;
         }
//echo $filename;
//echo $query_array['views']['management']['image'] ;
?>
