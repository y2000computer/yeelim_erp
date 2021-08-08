<?php
class gl_chart_master_model extends dataManager
{
	private $dbh;
	private $primary_table;
	private $primary_keyname;
	private $primary_indexname;
	
	private $table_field;  // variable for dataManager
	private $errorMsg;   // variable for dataManager
	private $mainTable;   // variable for dataManager
	
	public function __construct()
    {

		parent::__construct();
    	$this->mainTable='tbl_gl_chart_master';
    	$this->setTable($this->mainTable);
    	$this->setErrorMsg('GL -> Maintenance -> Chart Master -> SQL error:');
    	$this->table_field=$this->getTableField();

		$this->primary_keyname = 'chart_id';
		$this->primary_indexname = 'chart_code';
		try {
			$this->dbh = new PDO(DB_CONNECTION_STRING,DB_USERNAME,DB_PASSWORD);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->dbh->query("set names utf8");
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage();
				die();
				}
	}
	
   public function primary_keyname()
	{
		return $this->primary_keyname;
	}

   public function search($jsondata)
	{
		$json = json_decode($jsondata, true);
	
		$sql_filter = "";
		if($json['general']['chart_code']<>"") {
			$sql_filter .= " C.chart_code LIKE '%".addslashes(trim($json['general']['chart_code']))."%'" ;
		}

		if($json['general']['chart_name']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " C.chart_name LIKE '%".addslashes(trim($json['general']['chart_name']))."%'" ;
		}

		//echo "<br>sql_filter:".$sql_filter."<br>";
		
		$sql = "SELECT ".$this->primary_keyname. " FROM tbl_gl_chart_master AS C ";
		$sql .= "  LEFT JOIN  tbl_gl_chart_type_master AS TY ON C.type_code = TY.type_code  ";
		$sql .= "  WHERE ";
		$sql .= " C.comp_id = ". $_SESSION["target_comp_id"] ;
		if(!empty($sql_filter)) $sql .= " AND  ".$sql_filter ;
		$sql .= " ORDER BY ".$this->primary_indexname.  ";";
		//echo "<br>sql:".$sql."<br>";
		
		$arr_primary_id =array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_primary_id[] = "'". addslashes($row[$this->primary_keyname]) ."'";
		endforeach; 	

		$array_count = count($arr_primary_id);

		if ($array_count > 0){	  
			$result_id = implode(",", $arr_primary_id);
		}
		
		$lot_id = strtotime(date("Y-m-d H:i:s")).rand(0, 10);;

	
		$sql = 'INSERT INTO `tbl_sys_paging_control`(
					`searchphrase`,
					`lot_id`,
					`result_id`,
					`create_user`,
					`create_datetime`
					) VALUES (';
		$sql.='\''.addslashes($jsondata).'\''.',';
		$sql.='\''.addslashes($lot_id).'\''.',';
		$sql.='\''.addslashes($result_id).'\''.',';
		$sql.='\''.addslashes($_SESSION["sUserID"]).'\''.',';
		$sql.='now()'.')';

		//echo "<br>sql:".$sql."<br>";
		$last_insert_id = $this->runSQLReturnID($sql);		


		return $lot_id;
	}

 
  public function retreive_content($lot_id,$page)
	{

		$sql = "SELECT * FROM tbl_sys_paging_control WHERE lot_id = '".$lot_id."' AND create_user =	'".$_SESSION['sUserID']."';";
		//echo "<br>sql:".$sql."<br>";
		$arr_record = $this->runSQLAssoc($sql);	

		$arr =  $arr_record[0];
		$arr_primary_id = $arr['result_id']; 
		
		
		if ($arr_primary_id != '')		
		{
			$sql = "SELECT C.*, TY.type_name FROM tbl_gl_chart_master AS C ";
			$sql .= "  LEFT JOIN  tbl_gl_chart_type_master AS TY ON C.type_code = TY.type_code  ";
			if(!empty($arr_primary_id)) $sql .= "WHERE ".$this->primary_keyname. " in (".$arr_primary_id.")" ;
			$sql .= " ORDER BY " .$this->primary_indexname ;
			$sql .= " LIMIT ". SYSTEM_PAGE_ROW_LIMIT . " OFFSET  ".($page-1)*SYSTEM_PAGE_ROW_LIMIT ;
			//echo "<br>sql:".$sql."<br>";
			
			$arr_record = $this->runSQLAssoc($sql);	

		}
		
		return $arr_record;
	}

  public function paging_config($lot_id)
	{
		$sql = "SELECT * FROM tbl_sys_paging_control WHERE lot_id = '".$lot_id."' AND create_user =	'".$_SESSION['sUserID']."';";
		//echo "<br>sql:".$sql."<br>";
		$arr_record = $this->runSQLAssoc($sql);	

		$result_id = $arr_record[0]['result_id'];

		$sql ="UPDATE `tbl_sys_paging_control` SET modify_datetime =now()	WHERE lot_id ='$lot_id'";
		//echo "<br>sql:".$sql."<br>";
		$void = $this->runSQLReturnID($sql);
	
		return $result_id;
	}	

    public function searchphrase($lot_id)
	{
		$sql = "SELECT searchphrase FROM tbl_sys_paging_control WHERE lot_id = '".$lot_id."' AND create_user =	'".$_SESSION['sUserID']."';";
		//echo "<br>sql:".$sql."<br>";
		
		$arr_record = $this->runSQLAssoc($sql);	

		$searchphrase = $arr_record[0]['searchphrase'];
		return $searchphrase;
				
	}		

    public function select($primary_id)
	{
 		$sql ="SELECT * FROM tbl_gl_chart_master WHERE ".$this->primary_keyname. " = '$primary_id'";
		//echo "<br>sql:".$sql."<br>";
		
		$arr_record = $this->runSQLAssoc($sql);	

		return $arr_record[0];
	}		
	
 
	public function create($general)
	{
		//$comp_id = $_SESSION["target_comp_id"];
		$comp_id = $general['comp_id'];
		$chart_code = $general['chart_code'];
		$chart_name = $general['chart_name'];
		$type_code = $general['type_code'];
		$brought_forward = $general['brought_forward'];
		$status = $general['status'];
		$create_user = $_SESSION['sUserID'];


		$ar_fields=array();
		$ar_fields['comp_id'] = $comp_id;
		$ar_fields['chart_code'] = $chart_code;
		$ar_fields['chart_name'] = $chart_name;
		$ar_fields['type_code'] = $type_code;
		$ar_fields['brought_forward'] = $brought_forward;
		$ar_fields['status'] = $status;
		$ar_fields['create_user'] = $create_user;
		$ar_fields['modify_user'] = $create_user;
		$ar_fields['create_datetime'] = 'now()';
		$ar_fields['modify_datetime'] = 'now()';

		$sql= $this->createInsertSql($ar_fields,$this->table_field,$this->mainTable);
		//echo '<br> sqal : '.$sql.'<br>';
		$last_insert_id = $this->runSQLReturnID($sql);	
	
		return $last_insert_id;
	}
	
	
	public function update($primary_id, $general)
	{
		$chart_name = $general['chart_name'];
		$type_code = $general['type_code'];
		$brought_forward = $general['brought_forward'];
		$status = $general['status'];
		$modify_user = $_SESSION['sUserID'];

		$ar_fields=array();
		$ar_fields['chart_name'] = $chart_name;
		$ar_fields['type_code'] = $type_code;
		$ar_fields['brought_forward'] = $brought_forward;
		$ar_fields['status'] = $status;
		$ar_fields['modify_user'] = $modify_user;
		$ar_fields['modify_datetime'] = 'now()';

		$sql= $this->createUpdateSql($ar_fields,$this->table_field,$this->mainTable,$this->primary_keyname,$primary_id);
		//echo '<br> sqal : '.$sql.'<br>';
		$this->runSql($sql);

		return true;
	}	

	
	public function is_duplicate_field($field_name, $para)
	{
		$para = addslashes($para);
		$sql ="SELECT COUNT(*) AS RecordCount FROM tbl_gl_chart_master ";
		$sql .= "  WHERE ";
		$sql .= " comp_id = ". $_SESSION["target_comp_id"] ;
		$sql .=" AND $field_name = '$para'";
		//echo '<br>'.$sql; // Debug used		
		
		$arr_record = $this->runSQLAssoc($sql);	

		$is_find = false;
		if ($arr_record[0]['RecordCount'] >=1) $is_find = true;
		
		return $is_find;
	}	
			
			
	public function is_duplicate_field_myself($myself_id_para , $field_name, $field_para)
	{
		$myself_id_para = addslashes($myself_id_para);
		$field_name = addslashes($field_name);
		$field_para = addslashes($field_para);
		
		$sql ="SELECT COUNT(*) AS RecordCount FROM tbl_gl_chart_master ";
		$sql .= "  WHERE ";
		$sql .= " comp_id = ". $_SESSION["target_comp_id"] ;
		$sql .=" AND $field_name = '$field_para' AND ".$this->primary_keyname. "<>'$myself_id_para' ";
		
		//echo '<br>'.$sql; // Debug used		
		$arr_record = $this->runSQLAssoc($sql);	
		
		$is_find = false;
		if ($arr_record[0]['RecordCount'] >=1) $is_find = true;
		
		return $is_find;
	}	
		
    public function chart_type_master_viewall()
	{
		$sql ="SELECT * FROM tbl_gl_chart_type_master ORDER BY type_code;";
		//echo '<br>'.$sql; // Debug used		
		
		$arr_record = $this->runSQLAssoc($sql);	

		return $arr_record;
	}		


    public function get_chart_brought_forward_total()
	{
		$sql ="SELECT SUM(brought_forward) AS brought_forward_ttl FROM tbl_gl_chart_master ";
		$sql .= "  WHERE ";
		$sql .= " comp_id = ". $_SESSION["target_comp_id"] ;
		
		//echo '<br>'.$sql; // Debug used		

		$brought_forward_ttl = 0;
	
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$brought_forward_ttl = $row['brought_forward_ttl'];
		endforeach; 	

	
		return $brought_forward_ttl;
	}		

	
    public function close()
	{
		$this->dbh = null;
	}	
	
} //class
?>