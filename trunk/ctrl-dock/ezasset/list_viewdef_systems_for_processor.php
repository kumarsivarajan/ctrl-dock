<?php

$query_array=array("headline"=>__("List Systems with Processor"),
                   "sql"=>"SELECT processor_id, processor_caption, processor_name, processor_socket_designation, net_ip_address, system_name, system_uuid
                   FROM processor, system WHERE processor_name = '".$_GET["name"]."'
                   AND processor_uuid = system_uuid AND processor_timestamp = system_timestamp ",
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
                                   "50"=>array("name"=>"processor_caption",
                                               "head"=>__("Caption"),
                                               "show"=>"y",
                                               "link"=>"n",
                                              ),
                                   "60"=>array("name"=>"processor_socket_designation",
                                               "head"=>__("Socket"),
                                               "show"=>"y",
                                               "link"=>"n",
                                              ),
                                  ),
                  );
?> 
