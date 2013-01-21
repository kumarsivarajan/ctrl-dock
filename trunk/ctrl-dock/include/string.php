<?
function clean_string($string){
	$string=str_replace("'"," ",$string);
	$string=str_replace("("," ",$string);
	$string=str_replace(")"," ",$string);
	$string=str_replace("\""," ",$string);
	return $string;
}
?>