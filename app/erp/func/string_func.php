<?php
// Portal share common string function
function _utf8_substr($str,$from,$len){
  return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
                       '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
                       '$1',$str);
}

function _utf8_strlen($str) {
  $count = 0;
  for ($i = 0; $i < strlen($str); ++$i) {
    if ((ord($str[$i]) & 0xC0) != 0x80) {
      ++$count;
    }
  }
  return $count;
}
function print_ar($array, $count=0) {
    $i=0;
    $tab ='';
    while($i != $count) {
        $i++;
        $tab .= "&nbsp;&nbsp;|&nbsp;&nbsp;";
    }
    foreach($array as $key=>$value){
        if(is_array($value)){
            echo $tab."[<strong><u>$key</u></strong>]<br />";
            $count++;
            print_ar($value, $count);
            $count--;
        }
        else{
            $tab2 = substr($tab, 0, -12);
            echo "$tab2~ $key: <strong>$value</strong><br />";
        }
        $k++;
    }
    $count--;
}
function print_r_html($data,$return_data=false)
{
    $data = print_r($data,true);
    $data = str_replace( " ","&nbsp;", $data);
    $data = str_replace( "\r\n","<br>\r\n", $data);
    $data = str_replace( "\r","<br>\r", $data);
    $data = str_replace( "\n","<br>\n", $data);

    if (!$return_data)
        echo $data;    
    else 
        return $data;
}

function print_r_html_v2($data,$return_data=false)
{
    $data = print_r($data,true);
    $data = str_replace( " ","&nbsp;", $data);
    $data = str_replace( "\r\n","<br>\r\n", $data);
    //$data = str_replace( "\r","<br>\r", $data);
    //$data = str_replace( "\n","<br>\n", $data);

    if (!$return_data)
        echo $data;    
    else 
        return $data;
}

function print_r_html_v3($data,$return_data=false)
{
    $data = print_r($data,true);
    $data = str_replace( " ","&nbsp;", $data);
    //$data = str_replace( "\r\n","<br>\r\n", $data);
    $data = str_replace( "\r","<br>\r", $data);
    $data = str_replace( "\n","<br>\n", $data);

    if (!$return_data)
        echo $data;    
    else 
        return $data;
}

?>