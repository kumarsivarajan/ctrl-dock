<?php

$query_array=array("headline"=>__("List Systems with Memory"),
                   "sql"=>"SELECT * FROM system,
                           (select *, sum(memory_capacity) AS total_memory FROM memory GROUP BY memory_uuid, memory_timestamp) AS full_system_memory
                           WHERE full_system_memory.memory_uuid  = system_uuid
                           AND full_system_memory.memory_timestamp = system_timestamp
                           AND full_system_memory.total_memory = '" . $_GET["name"] . "'
                           ",
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
                                   "40"=>array("name"=>"total_memory",
                                               "head"=>__("Total Memory"),
                                               "show"=>"y",
                                               "link"=>"n",
                                              ),
                                   "50"=>array("name"=>"system_memory",
                                               "head"=>__("Windows Reported"),
                                               "show"=>"y",
                                               "link"=>"n",
                                              ),
                                   "60"=>array("name"=>"memory_form_factor",
                                               "head"=>__("Type"),
                                               "show"=>"y",
                                               "link"=>"n",
                                              ),
                                   "70"=>array("name"=>"memory_speed",
                                               "head"=>__("Speed"),
                                               "show"=>"y",
                                               "link"=>"n",
                                              ),
                                  ),
                  );
?>