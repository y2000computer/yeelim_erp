<?php
// Portal share common function for generate sql statement 
// Eliminate database proprietary feature and syntax

function gen_reference($prefix,$last) {
	$len_of_random =  11 - strlen($last);
	$rand_dec  ='';
	for ($i = 1; $i <= $len_of_random; $i++) {
		$rand_dec .='9';
	}
	//echo 'rand_dec ='.$rand_dec.'<br>';
	$ran_string = rand(1, $rand_dec);
	//echo 'ran_string ='.$ran_string.'<br>';
	$ref = str_pad($ran_string, $len_of_random, "0", STR_PAD_LEFT);
	$ref = $prefix.'-'.$last.$ref;
	return $ref;
}

?>