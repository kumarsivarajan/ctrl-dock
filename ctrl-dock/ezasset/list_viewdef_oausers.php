<?php

$query_array=array("headline"=>__("User Management"),
                   "sql"=>"SELECT * FROM auth",
                   "sort"=>"auth_username",
                   "dir"=>"ASC",
                   "fields"=>array(
                                   "10"=>array("name"=>"delete",
                                               "head"=>__("Delete"),
                                               "show"=>"y",
                                               "link"=>"y",
                                               "sort"=>"n",
                                               "search"=>"n",
                                               "get"=>array("file"=>"admin_users_actions.php",
                                                            "title"=>__("Delete User"),
                                                            "onClick"=>"return confirm('".__("Do you really want to DELETE this user?")."');",
                                                            "var"=>array("action"=>"deluser",
                                                                         "confirm"=>"1",
                                                                         "user"=>"%auth_id",
                                                                        ),
                                                           ),
                                              ),
                                   "20"=>array("name"=>"auth_username",
                                               "head"=>__("Username"),
                                               "show"=>"y",
                                               "link"=>"y",
                                               "get"=>array("file"=>"system.php",
                                                            "title"=>__("Modify User"),
                                                            "var"=>array("user"=>"%auth_id",
                                                                         "view"=>"oauser",
                                                                        ),
                                                           ),
                                              ),
                                   "30"=>array("name"=>"auth_realname",
                                               "head"=>__("Real Name"),
                                               "show"=>"y",
                                               "link"=>"n",
                                              ),
                                   "40"=>array("name"=>"auth_enabled",
                                               "head"=>__("Enabled"),
                                               "show"=>"y",
                                               "link"=>"n",
                                              ),
                                   "50"=>array("name"=>"auth_admin",
                                               "head"=>__("Admin"),
                                               "show"=>"y",
                                               "link"=>"n",
                                              ),
                                  ),
                  );
?>
