<?
include("../include/config.php");
include("../include/db.php");

// Fetch audit expiry value and set the cleanup date accordingly.

$sql    ="select * from config";
$result = mysql_query($sql);
$row    = mysql_fetch_row($result);
$AUDIT_EXPIRY=$row[3]*2;

echo "Initializing clean up of audited data before $AUDIT_EXPIRY days\n\n";
$clean_before=mktime()-($AUDIT_EXPIRY*86400);



// Delete old audited data
include("../include/dboa.php");

$sub_sql="show tables";
$sub_result = mysql_query($sub_sql);
while($sub_row = mysql_fetch_row($sub_result)){
        $table=$sub_row[0];
        echo "Cleaning table $table\n";
        $del_sql="delete from $table where UNIX_TIMESTAMP(timestamp) < $clean_before";
        mysql_query($del_sql);
}


// Backup the Database
include("../include/config.php");
`mysqldump -h$DATABASE_SERVER $DATABASE_NAME -u $DATABASE_USERNAME -p$DATABASE_PASSWORD > ../backup/$DATABASE_NAME.sql`;
$DATABASE_NAME=$DATABASE_NAME."_oa";
`mysqldump -h$DATABASE_SERVER $DATABASE_NAME -u $DATABASE_USERNAME -p$DATABASE_PASSWORD > ../backup/$DATABASE_NAME.sql`;


// Backup Configuration & Data files
`cp -rf ../include/config.php ../backup/`;
`cp -rf ../images/logo.png ../backup/`;
`cp -rf ../eztickets/attachments ../backup/`;
`cp -rf ../broadcast/attachments/ ../backup/`;
`cp -rf ../documents/files ../backup/`;
`cp -rf ../documents/.htaccess ../backup/`;


?>
