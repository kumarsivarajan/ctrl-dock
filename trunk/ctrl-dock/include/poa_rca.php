<?
function random_key(){
	$approver_key_1=rand(1000000000,9000000000);
	$approver_key_2=rand(2000000000,8000000000);
	$approver_key=$approver_key_1.$approver_key_2;
	return $approver_key;
}
?>