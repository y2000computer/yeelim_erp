<?php
function toYMD($user_dmy_input)
{
	if (strpos($user_dmy_input,"/")) {
		$Date_Array = explode("/",$user_dmy_input);
	} elseif (strpos ($temp,"-")) {
		$Date_Array = explode("-",$user_dmy_input);
	}
	$day = padZero($Date_Array[0], 2);
	$month = padZero($Date_Array[1], 2);
	$year = padZero($Date_Array[2], 4);
	$date = $year . "-" . $month . "-" . $day;
	return $date;
}
function toDMY($temp)
{
	return date("d/m/Y",strtotime($temp));
}
function YMDtoDMY($temp)
{
	if (strtotime($temp) == false) {
	   return '';
	   } else {
			return date("d/m/Y",strtotime($temp));
	   }
}
function toDMYHMS($temp)
{
	return date("d/m/Y G:i:s",strtotime($temp));
}
function Is_Date($DateEntry) {

	$DateEntry =Trim($DateEntry);

	if (strpos($DateEntry,"/")) {
		$Date_Array = explode("/",$DateEntry);
	} elseif (strpos ($DateEntry,"-")) {
		$Date_Array = explode("-",$DateEntry);
	} elseif (strlen($DateEntry)==6) {
		$Date_Array[0]= substr($DateEntry,0,2);
		$Date_Array[1]= substr($DateEntry,2,2);
		$Date_Array[2]= substr($DateEntry,4,2);
	} elseif (strlen($DateEntry)==8) {
		$Date_Array[0]= substr($DateEntry,0,2);
		$Date_Array[1]= substr($DateEntry,2,2);
		$Date_Array[2]= substr($DateEntry,4,4);
	}

	if(isset($Date_Array[2])) {
		If ((int)$Date_Array[2] >9999) {
			Return 0;
		}
	} else { Return 0; }	

	if (is_long((int)$Date_Array[0]) AND is_long((int)$Date_Array[1]) AND is_long((int)$Date_Array[2])) {
		if (checkdate((int)$Date_Array[1],(int)$Date_Array[0],(int)$Date_Array[2])){
			Return 1;
		} else {
			Return 0;
		}
	}else { // end if all numeric inputs
		Return 0;
	}

} 
function padZero($temp, $count)
{
	While (strlen($temp) < $count) $temp = "0" . $temp;
	return $temp; 
}
?>