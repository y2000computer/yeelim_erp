<?php
class prop_tenant_info_model extends dataManager
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
		$this->mainTable='tbl_prop_tenant_info';
    	$this->setTable($this->mainTable);
    	$this->setErrorMsg('PROP -> Transaction -> Tenant Information -> SQL error:');
    	$this->table_field=$this->getTableField();
	
		$this->primary_keyname = 'tenant_id';
		$this->primary_indexname = 'tenant_code';
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
		if($json['general']['build_id']<>"") {
			$sql_filter .= " C.build_id = '".addslashes($json['general']['build_id'])."'" ;
		}		
		if($json['general']['tenant_code']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " C.tenant_code LIKE '%".addslashes(trim($json['general']['tenant_code']))."%'" ;
		}

		if($json['general']['eng_name']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " C.eng_name LIKE '%".addslashes(trim($json['general']['eng_name']))."%'" ;
		}

		//echo "<br>sql_filter:".$sql_filter."<br>";
		
		$sql = "SELECT ".$this->primary_keyname. " FROM tbl_prop_tenant_info AS C ";
		$sql .= "  LEFT JOIN  tbl_prop_build_master AS B ON C.build_id = B.build_id  ";
		$sql .= "  WHERE ";
		$sql .= " (1) " ;
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
			$sql = "SELECT C.*, B.eng_name AS 'build_eng_name' FROM tbl_prop_tenant_info AS C ";
			$sql .= "  LEFT JOIN  tbl_prop_build_master AS B ON C.build_id = B.build_id  ";
			if(!empty($arr_primary_id)) $sql .= "WHERE ".$this->primary_keyname. " in (".$arr_primary_id.")" ;
			$sql .= " ORDER BY " .$this->primary_indexname ;
			$sql .= " LIMIT ". SYSTEM_PAGE_ROW_LIMIT . " OFFSET  ".($page-1)*SYSTEM_PAGE_ROW_LIMIT ;
			//echo "<br>sql:".$sql."<br>";
			$arr_record = $this->runSQLAssoc($sql);	

					
			return $arr_record;
		}
		
		return $arr_record;
	}

  public function paging_config($lot_id)
	{
		$sql = "SELECT * FROM tbl_sys_paging_control WHERE lot_id = '".$lot_id."' AND create_user =	'".$_SESSION['sUserID']."';";
		//echo "<br>sql:".$sql."<br>";
		$arr_record = $this->runSQLAssoc($sql);	


		$result_id = $arr_record[0]['result_id'];

		//$this->dbh->beginTransaction();

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

		 $sql ="SELECT T.*, B.eng_name AS 'build_eng_name' FROM tbl_prop_tenant_info AS T";
		 $sql .= " LEFT JOIN  tbl_prop_build_master AS B ON T.build_id = B.build_id ";
		 $sql .= " WHERE T.".$this->primary_keyname. " = '$primary_id'";
		 //echo "<br>sql:".$sql."<br>";
		$arr_record = $this->runSQLAssoc($sql);	
		
		return $arr_record[0];
	}		
	
 
	
	public function is_duplicate_field($field_name, $para, $build_id)
	{
		$para = addslashes($para);
		$sql ="SELECT COUNT(*) AS RecordCount FROM tbl_prop_tenant_info ";
		$sql .= "  WHERE ";
		$sql .= " build_id = ". $build_id ;
		$sql .=" AND $field_name = '$para'";
		//echo '<br>'.$sql; // Debug used		
		$arr_record = $this->runSQLAssoc($sql);	
		

		$is_find = false;
		if ($arr_record[0]['RecordCount'] >=1) $is_find = true;
		
		return $is_find;
	}	
			
			
	public function is_duplicate_field_myself($myself_id_para , $field_name, $field_para, $build_id)
	{
		$myself_id_para = addslashes($myself_id_para);
		$field_name = addslashes($field_name);
		$field_para = addslashes($field_para);
		
		$sql ="SELECT COUNT(*) AS RecordCount FROM tbl_prop_tenant_info ";
		$sql .= "  WHERE ";
		$sql .= " build_id = ". $build_id ;
		$sql .=" AND $field_name = '$field_para' AND ".$this->primary_keyname. "<>'$myself_id_para' ";
		
		//echo '<br>'.$sql; // Debug used		
		$arr_record = $this->runSQLAssoc($sql);	
		
		
		$is_find = false;
		if ($arr_record[0]['RecordCount'] >=1) $is_find = true;
		
		return $is_find;
	}	
		

    public function prop_build_master_viewall($comp_id)
	{
		$sql ="SELECT * FROM tbl_prop_build_master ";
		$sql .= " WHERE ";
		$sql .= " comp_id = ". $comp_id;
		$sql .= " ORDER BY build_id ASC; ";
		
		//echo '<br>'.$sql; // Debug used		
		$arr_record = $this->runSQLAssoc($sql);	
		
		
		return $arr_record;
	}	

	public function create($general)
	{
		$build_id = $general['build_id'];
		$tenant_code = $general['tenant_code'];
		$eng_name = $general['eng_name'];
		$add_1 = $general['add_1'];
		$add_2 = $general['add_2'];
		$add_3 = $general['add_3'];
		$ref_no = $general['ref_no'];
		$shop_no = $general['shop_no'];
		$rent_date = toYMD($general['rent_date']);
		$rent_amount = $general['rent_amount'];
		$maint_date = toYMD($general['maint_date']);
		$maint_amount = $general['maint_amount'];
		$ptype = $general['ptype'];
		$status = $general['status'];
		$create_user = $_SESSION['sUserID'];

		$ar_fields=array();
		$ar_fields['build_id'] = $build_id;
		$ar_fields['tenant_code'] = $tenant_code;
		$ar_fields['eng_name'] = $eng_name;
		$ar_fields['add_1'] = $add_1;
		$ar_fields['add_2'] = $add_2;
		$ar_fields['add_3'] = $add_3;
		$ar_fields['ref_no'] = $ref_no;
		$ar_fields['shop_no'] = $shop_no;
		$ar_fields['rent_date'] = $rent_date;
		$ar_fields['rent_amount'] = $rent_amount;
		$ar_fields['maint_date'] = $maint_date;
		$ar_fields['maint_amount'] = $maint_amount;
		$ar_fields['ptype'] = $ptype;
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

		$build_id = $general['build_id'];
		$eng_name = $general['eng_name'];
		$add_1 = $general['add_1'];
		$add_2 = $general['add_2'];
		$add_3 = $general['add_3'];
		$ref_no = $general['ref_no'];
		$shop_no = $general['shop_no'];
		$rent_date = toYMD($general['rent_date']);
		$rent_amount = $general['rent_amount'];
		$maint_date = toYMD($general['maint_date']);
		$maint_amount = $general['maint_amount'];
		$ptype = $general['ptype'];
		$status = $general['status'];
		$modify_user = $_SESSION['sUserID'];

		$ar_fields=array();
		$ar_fields['eng_name'] = $eng_name;
		$ar_fields['add_1'] = $add_1;
		$ar_fields['add_2'] = $add_2;
		$ar_fields['add_3'] = $add_3;
		$ar_fields['ref_no'] = $ref_no;
		$ar_fields['shop_no'] = $shop_no;
		$ar_fields['rent_date'] = $rent_date;
		$ar_fields['rent_amount'] = $rent_amount;
		$ar_fields['maint_date'] = $maint_date;
		$ar_fields['maint_amount'] = $maint_amount;
		$ar_fields['ptype'] = $ptype;
		$ar_fields['status'] = $status;
		$ar_fields['modify_user'] = $modify_user;
		$ar_fields['modify_datetime'] = 'now()';


		$sql= $this->createUpdateSql($ar_fields,$this->table_field,$this->mainTable,$this->primary_keyname,$primary_id);
		//echo '<br> sql : '.$sql.'<br>';
		$this->runSql($sql);


		return true;
	}	
	

	public function rent_transaction_list($primary_id)
	{


		$sql = "SELECT A.*  FROM tbl_prop_rent_inv AS A  ";
		$sql .= " WHERE A.".$this->primary_keyname. " = '$primary_id'";
		$sql .= " ORDER BY A.".$this->primary_keyname." ; ";

		//echo "<br><br><br>sql:".$sql."<br>";
		$arr_record = $this->runSQLAssoc($sql);	

		return $arr_record;
	}		

	public function maint_transaction_list($primary_id)
	{

		$sql = "SELECT A.*  FROM tbl_prop_maint_inv AS A  ";
		$sql .= " WHERE A.".$this->primary_keyname. " = '$primary_id'";
		$sql .= " ORDER BY A.".$this->primary_keyname." ; ";

		//echo "<br><br><br>sql:".$sql."<br>";
		$arr_record = $this->runSQLAssoc($sql);	


		return $arr_record;
	}		
 	

    public function close()
	{
		$this->dbh = null;
	}	
	
} //class
?>