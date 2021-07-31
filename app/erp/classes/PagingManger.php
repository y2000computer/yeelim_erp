<?php
class PagingManger
{
	var $Result_ID_Array;		//array
    var $RecordCount;           //Total number of items 
	var $TotalPages;			//Total Pages
	var $CurrentRow;			//Current Row of Record
	
    #function PagingManger($Result_ID_Array,$page_row_limit) {
	public function __construct($Result_ID_Array,$page_row_limit) {
		

        $this->Result_ID_Array    = $Result_ID_Array;
		$this->RecordCount		  = count(explode(",", $Result_ID_Array));
		$this->TotalPages         = ceil($this->RecordCount / $page_row_limit);

    }

    function getRecordCount(){

        return $this->RecordCount;
    }
	
    function getTotalPages(){
        return $this->TotalPages;
    }
	
    function getCurrentRow($id){
		$var = str_replace("'", "", $this->Result_ID_Array);
		$cell = explode(",", $var);
		$position = array_search($id, $cell);
		if ($position !== false)   $this->CurrentRow=$position+1;
		return $this->CurrentRow;
    }


    function CalcuatePageNo($id,$page_row_limit){
		$var = explode(",", $this->Result_ID_Array);
		$var_break = array_chunk($var, $page_row_limit);
			$i = 0;
			foreach ($var_break as $inner_array) {
				$i++;
				//while (list($key, $value) = each($inner_array)) {   //  deprecated function each php at php 7
				while (list($key, $value) = $this->myEach($inner_array)) {  
					if($value =="'".$id."'")	{
					$page = $i;
					}
				}
			}
		return $page;
    }


   function getPrev_ID($id){
		$var = str_replace("'", "", $this->Result_ID_Array);
		$cell = explode(",", $var);
		return $cell[$this->getCurrentRow($id)-2];
	}

   function getNext_ID($id){
		$var = str_replace("'", "", $this->Result_ID_Array);
		$cell = explode(",", $var);
		return $cell[$this->getCurrentRow($id)];
	}


	function myEach(&$arr) {
		$key = key($arr);
		$result = ($key === null) ? false : [$key, current($arr), 'key' => $key, 'value' => current($arr)];
		next($arr);
		return $result;
	}
	
}

?>
