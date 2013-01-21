<?php

$query_array=array("headline"=>__("List Systems with Hard Drive Size"),
                   "sql"=>"SELECT * FROM system, hard_drive
                           WHERE hard_drive_uuid  = system_uuid
                           AND system_timestamp  = hard_drive_timestamp
                           AND hard_drive_size = '" . $_GET["hard_drive_size"] . "'  ",
                   "sort"=>"system_name",
                   "dir"=>"ASC",
                   "get"=>array("file"=>"system.php",
                                "title"=>"Go to System",
                                "var"=>array("pc"=>"%system_uuid",
                                             "view"=>"summary",
                                            ),
                               ),
                   "fields"=>array("10"=>array("name"=>"system_uuid",
                                               "head"=>__("UUID"),
                                               "show"=>"n",
                                              ),
                                   "20"=>array("name"=>"net_ip_address",
                                               "head"=>__("IP"),
                                               "show"=>"y",
                                               "link"=>"y",
                                              ),
                                   "30"=>array("name"=>"system_name",
                                               "head"=>__("Hostname"),
                                               "show"=>"y",
                                               "link"=>"y",
                                              ),
                                   "40"=>array("name"=>"hard_drive_caption",
                                               "head"=>__("Brand/Model"),
                                               "show"=>"y",
                                               "link"=>"n",
                                              ),
                                   "50"=>array("name"=>"hard_drive_interface_type",
                                               "head"=>__("Interface"),
                                               "show"=>"y",
                                               "link"=>"n",
                                              ),
                                  ),
                  );
?>
