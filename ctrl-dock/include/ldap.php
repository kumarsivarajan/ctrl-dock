<?
// connect to ldap server
$ldap_conn = ldap_connect("$LDAP_URL")or die("Could not connect to LDAP server.");

if ($ldap_conn) {
	ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);

    // binding to ldap server
    $ldap_bind = ldap_bind($ldap_conn, "$LDAP_USER", $LDAP_PASS);	
	
	/*
	if ($ldap_bind) {
        echo "LDAP bind successful...";
    } else {
        echo "LDAP bind failed...";
    }
	*/	
}
?>