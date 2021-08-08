<?php
class gl_journal_entry_model  extends dataManager
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
    	$this->mainTable='tbl_gl_journal_entry';
    	$this->setTable($this->mainTable);
    	$this->setErrorMsg('GL -> Transaction -> GL Entry -> SQL error:');
    	$this->table_field=$this->getTableField();

		$this->primary_keyname = 'journal_id';
		$this->primary_indexname = 'journal_code';
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
		
		if($json['general']['journal_date_from']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " date(JL.journal_date) BETWEEN '". toYMD($json['general']['journal_date_from'])."' AND '". toYMD($json['general']['journal_date_to'])."'" ;
		}			

		
		if($json['general']['journal_code']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " JL.journal_code LIKE '%".addslashes(trim($json['general']['journal_code']))."%'" ;
		}

		//echo "<br>sql_filter:".$sql_filter."<br>";
		

		$sql = "SELECT "."JL.".$this->primary_keyname. " FROM tbl_gl_journal_entry AS JL ";
		$sql .= " WHERE ";		
		
		$sql .= " JL.comp_id = ". $_SESSION["target_comp_id"] ;
		if(!empty($sql_filter)) $sql .= " AND  ".$sql_filter ;
		//$sql .= " ORDER BY "."JL.".$this->primary_indexname.  ";";
		$sql .= " ORDER BY "."JL."."Journal_Date DESC , JL.journal_id  DESC ".  ";";
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

		//echo "<br>sql:".$sql."<br>";
		$last_insert_id = $this->runSQLReturnID($sql);		

		return $lot_id;
	}

 
   public function search_advance($jsondata)
	{
		$json = json_decode($jsondata, true);
	
		$sql_filter = "";
		
		if($json['general']['journal_date_from']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " date(JL.journal_date) BETWEEN '". toYMD($json['general']['journal_date_from'])."' AND '". toYMD($json['general']['journal_date_to'])."'" ;
		}			

		
		if($json['general']['journal_code']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " JL.journal_code LIKE '%".addslashes(trim($json['general']['journal_code']))."%'" ;
		}

		if($json['general']['chart_code']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " C.chart_code LIKE '%".addslashes(trim($json['general']['chart_code']))."%'" ;
		}

		
		if($json['general']['chart_name']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " C.chart_name LIKE '%".addslashes(trim($json['general']['chart_name']))."%'" ;
		}
		
		if($json['general']['description']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " DETAIL.description LIKE '%".addslashes(trim($json['general']['description']))."%'" ;
		}
		
		
		//echo "<br>sql_filter:".$sql_filter."<br>";
		
	
		$sql = "SELECT DISTINCT "."JL.".$this->primary_keyname. " FROM tbl_gl_journal_entry AS JL ";
		$sql .= " LEFT JOIN tbl_gl_journal_entry_detail AS DETAIL  ON JL.journal_id = DETAIL.journal_id ";
		$sql .= " LEFT JOIN tbl_gl_chart_master AS C  ON DETAIL.chart_id = C.chart_id ";
		$sql .= " LEFT JOIN  tbl_gl_chart_type_master AS TY ON C.type_code = TY.type_code  ";
		$sql .= " WHERE ";
		
		$sql .= " JL.comp_id = ". $_SESSION["target_comp_id"] ;
		if(!empty($sql_filter)) $sql .= " AND  ".$sql_filter ;
		//$sql .= " ORDER BY "."JL.".$this->primary_indexname.  ";";
		$sql .= " ORDER BY "."JL."."Journal_Date DESC , JL.journal_id  DESC ".  ";";
		//echo "<br><br><br>sql:".$sql."<br>";
				
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

		
			$sql = "SELECT JL.* FROM tbl_gl_journal_entry AS JL ";
		
			if(!empty($arr_primary_id)) $sql .= "WHERE "."JL.".$this->primary_keyname. " in (".$arr_primary_id.")" ;
			//$sql .= " ORDER BY " .$this->primary_indexname ;
			$sql .= " ORDER BY JL.journal_date DESC , JL." .$this->primary_indexname. ' DESC ' ;
			$sql .= " LIMIT ". SYSTEM_PAGE_ROW_LIMIT . " OFFSET  ".($page-1)*SYSTEM_PAGE_ROW_LIMIT ;
			//echo "<br>sql:".$sql."<br>";
			
			$arr_record = $this->runSQLAssoc($sql);	


			return $arr_record;
			
		}
		
		return $arr_record;
	}

	
	public function retreive_content_advance($lot_id,$page)
	{

		$sql = "SELECT * FROM tbl_sys_paging_control WHERE lot_id = '".$lot_id."' AND create_user =	'".$_SESSION['sUserID']."';";
		//echo "<br>sql:".$sql."<br>";

		$arr_record = $this->runSQLAssoc($sql);	


		$arr =  $arr_record[0];
		$arr_primary_id = $arr['result_id']; 
		
		
		if ($arr_primary_id != '')		
		{
			
			//$sql = "SELECT JL.* FROM tbl_gl_journal_entry AS JL ";
			$sql = "SELECT JL.*, C.chart_code, C.chart_name, ";
			$sql .= " DETAIL.irow_id, DETAIL.chart_id, DETAIL.description, DETAIL.amount ";
			$sql .= " FROM tbl_gl_journal_entry AS JL ";
			$sql .= " LEFT JOIN tbl_gl_journal_entry_detail AS DETAIL  ON JL.journal_id = DETAIL.journal_id ";
			$sql .= " LEFT JOIN tbl_gl_chart_master AS C  ON DETAIL.chart_id = C.chart_id ";
			$sql .= " LEFT JOIN  tbl_gl_chart_type_master AS TY ON C.type_code = TY.type_code  ";
		
			if(!empty($arr_primary_id)) $sql .= "WHERE "."JL.".$this->primary_keyname. " in (".$arr_primary_id.")" ;
			//$sql .= " ORDER BY " .$this->primary_indexname ;
			//$sql .= " ORDER BY JL.journal_date DESC , JL." .$this->primary_indexname. ' DESC ' ;
			$sql .= " ORDER BY JL.journal_date DESC , JL." .$this->primary_indexname. ' DESC '. ','. 'DETAIL.irow_id ' ;
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

		$this->dbh->beginTransaction();

		$sql ="UPDATE `tbl_sys_paging_control` SET modify_datetime =now()	WHERE lot_id ='$lot_id'";

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
 		$sql ="SELECT * FROM tbl_gl_journal_entry WHERE ".$this->primary_keyname. " = '$primary_id'";
		//echo "<br>sql:".$sql."<br>";
		$arr_record = $this->runSQLAssoc($sql);	

		return $arr_record[0];
	}		
	
 
	public function create($general)
	{
		//$comp_id = $_SESSION["target_comp_id"];
		$comp_id = $general['comp_id'];
		$journal_date = toYMD($general['journal_date']);
		$type_code = $general['type_code'];
		$balance = 0;
		$status = 1;
		$year_end_is = 0;		
		$create_user = $_SESSION['sUserID'];


		$ar_fields=array();
		$ar_fields['comp_id'] = $comp_id;
		$ar_fields['journal_date'] = $journal_date;
		$ar_fields['balance'] = $balance;
		$ar_fields['status'] = $status;
		$ar_fields['create_user'] = $create_user;
		$ar_fields['modify_user'] = $create_user;
		$ar_fields['create_datetime'] = 'now()';
		$ar_fields['modify_datetime'] = 'now()';


		$journal_prefix	='';
		$sql ="SELECT a.journal_prefix FROM tbl_sys_company_master AS a
				 WHERE  a.comp_id = '$comp_id' LIMIT 1 ";
		//echo '<br>'.$sql.'<br>';
		
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$journal_prefix = $row['journal_prefix'];
		endforeach;	
		
		//Generate prefix
		$YY =substr($journal_date,2,2);
		$prefix_YY = $journal_prefix.$YY;
		//echo '<br>prefix_YY ='.$prefix_YY.'<br>'	;
		$sql = "SELECT MAX(journal_code) as max  FROM tbl_gl_journal_entry WHERE
					comp_id=".$comp_id." and left(journal_code,4)='".$prefix_YY."'";
		//echo '<br>'.$sql.'<br>';
		$prefix_max ='';

		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$prefix_max = $row['max'];
		endforeach;

		//echo '<br>prefix_max ='.$prefix_max.'<br>'	;
		
		if($prefix_max ==null )	{
			$prefix_max_no = 0;	  
		} else {
			$prefix_max_no = substr($prefix_max, 4, 5); 
		}
		
		$prefix_max_no = $prefix_max_no+1;
		//echo 'prefix_max_no ='.$prefix_max_no.'<br>'	;
		$journal_code =$prefix_YY.str_pad($prefix_max_no,5,0,STR_PAD_LEFT);
		//echo 'journal_code ='.$journal_code.'<br>'	;
		
		//<end>Generate prefix

		$ar_fields['journal_code'] = $journal_code;

		$sql= $this->createInsertSql($ar_fields,$this->table_field,$this->mainTable);
		//echo '<br> sql : '.$sql.'<br>';
		$last_insert_id = $this->runSQLReturnID($sql);	
	
		return $last_insert_id;
	}
	
	
	public function update($primary_id, $general)
	{
		//$journal_code = trim(addslashes($general['journal_code']));
		$journal_date = toYMD($general['journal_date']);
		$status = $general['status'];
		$modify_user = $_SESSION['sUserID'];


		$ar_fields=array();
		$ar_fields['journal_date'] = $journal_date;
		$ar_fields['status'] = $status;
		$ar_fields['modify_user'] = $modify_user;
		$ar_fields['modify_datetime'] = 'now()';

		$sql= $this->createUpdateSql($ar_fields,$this->table_field,$this->mainTable,$this->primary_keyname,$primary_id);
		//echo '<br> sql : '.$sql.'<br>';
		$this->runSql($sql);

		return true;
	}	

	
	public function is_duplicate_field($field_name, $para)
	{
		$para = addslashes($para);
		$sql ="SELECT COUNT(*) AS RecordCount FROM tbl_gl_journal_entry ";
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
		
		$sql ="SELECT COUNT(*) AS RecordCount FROM tbl_gl_journal_entry ";
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


	
    public function detail_list($primary_id)
	{


		$sql = "SELECT DETAIL.*, C.chart_code, C.chart_name, TY.type_code, TY.type_name  FROM tbl_gl_journal_entry_detail AS DETAIL  ";
		$sql .= " LEFT JOIN tbl_gl_chart_master AS C  ON DETAIL.chart_id = C.chart_id ";
		$sql .= " LEFT JOIN  tbl_gl_chart_type_master AS TY ON C.type_code = TY.type_code  ";
		$sql .= " WHERE DETAIL.".$this->primary_keyname. " = '$primary_id'";
		$sql .= " ORDER BY DETAIL.irow_id; ";

		//echo "<br><br><br>sql:".$sql."<br>";
		$arr_record = $this->runSQLAssoc($sql);	

		return $arr_record;
	}		


    public function chart_list($chart_code)
	{
 	
		$sql = "SELECT C.* FROM tbl_gl_chart_master AS C  ";
		$sql .= " LEFT JOIN  tbl_gl_chart_type_master AS TY ON C.type_code = TY.type_code  ";
		$sql .= "  WHERE ";
		$sql .= " comp_id = ". $_SESSION["target_comp_id"] ;
		$sql .= " AND C.chart_code ='$chart_code'";
		
		//echo "<br>sql:".$sql."<br>";
		$arr_record = $this->runSQLAssoc($sql);	
		
		return $arr_record;
	}		
	
		
		
    public function chart_listall()
	{
 	
		$sql = "SELECT C.*, TY.* FROM tbl_gl_chart_master AS C  ";
		$sql .= " LEFT JOIN  tbl_gl_chart_type_master AS TY ON C.type_code = TY.type_code  ";
		$sql .= "  WHERE ";
		$sql .= " comp_id = ". $_SESSION["target_comp_id"] ;
		$sql .= " ORDER BY C.Chart_Code";
		
		//echo "<br>sql:".$sql."<br>";
		$arr_record = $this->runSQLAssoc($sql);	

		return $arr_record;
	}		
	

	public function detail_update($primary_id, $general)
	{
		$deleteaction = $general['deleteaction'];
		
		$comp_id = $general['comp_id'];
		$irow_id = $general['irow_id'];
		$chart_code = addslashes($general['chart_code']);
		$description = trim(addslashes($general['description']));
		$amount = $general['amount'];
		$modify_user = $_SESSION['sUserID'];


		$ar_fields=array();
		$ar_fields['comp_id'] = $comp_id;
		$ar_fields['irow_id'] = $irow_id;
		$ar_fields['chart_code'] = $chart_code;
		$ar_fields['description'] = $description;
		$ar_fields['amount'] = $amount;
		$ar_fields['modify_user'] = $modify_user;
		$ar_fields['modify_datetime'] = 'now()';


		//retreive chart_id
		$sql ="SELECT chart_id FROM tbl_gl_chart_master WHERE ";
		//$sql .= " comp_id = ". $_SESSION["target_comp_id"] ;
		$sql .= " comp_id = ". $comp_id ;
		$sql .= " AND " ;
		$sql .= " chart_code = "."'". $chart_code."'" ;
		//echo "<br>sql:".$sql."<br>";

		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$chart_id = $row['chart_id'];
		endforeach; 	

		
		if($deleteaction=='yes') {
			
				$sql ='DELETE FROM `tbl_gl_journal_entry_detail`  ';
				$sql.=' WHERE ';
				$sql.='`'.'irow_id'. '`='.'\''.$irow_id.'\''.' ';
				echo '<br>'.$sql; // Debug used				
				$void = $this->runSQLReturnID($sql);	

				
		} else {
				if($irow_id=='') {
			
					$sql = "INSERT INTO `tbl_gl_journal_entry_detail`(
						`journal_id`
						,`chart_id`
						,`description`
						,`amount`
						) VALUES (
							'$primary_id'
							,'$chart_id'
							,'$description'
							,'$amount'
							);";
					}
					//echo '<br>'.$sql; // Debug used	
					$void = $this->runSQLReturnID($sql);
					
					if($irow_id<>'') {
					
						$sql ='UPDATE  `tbl_gl_journal_entry_detail` SET ';
						$sql.='`chart_id`='.'\''.$chart_id.'\'';
						$sql.=',`description`='.'\''.$description.'\'';
						$sql.=',`amount`='.'\''.$amount.'\'';
						$sql.=' WHERE ';
						$sql.='`'.'irow_id'. '`='.'\''.$irow_id.'\''.' ';
						//echo '<br>'.$sql; // Debug used				
						$void = $this->runSQLReturnID($sql);	
				

						//echo '<br>'.$sql.'<br>';		
					
					}
		} //if(deleteaction=='yes') {
			
	
		return true;
	}	


	public function detail_posting_update($primary_id)
	{
	
		$modify_user = $_SESSION['sUserID'];

		//$this->dbh->beginTransaction();
		
		$amount_ttl =0;
		$posting_is =0;
		
		$sql ="SELECT SUM(amount) AS amount_ttl FROM tbl_gl_journal_entry_detail ";
		$sql .= "  WHERE ";
		$sql .="   ".$this->primary_keyname. '='.$primary_id.';';

		//echo '<br>'.$sql; // Debug used		
		$arr_record = $this->runSQLAssoc($sql);	
		

		if ($arr_record[0]['amount_ttl'] <>NULL ) $amount_ttl = $arr_record[0]['amount_ttl'] ;
		$posting_is = ($amount_ttl==0? 1:0);
			
		
		$sql ='UPDATE  `tbl_gl_journal_entry` SET ';
		$sql.=' `balance`='.'\''.$amount_ttl.'\'';
		$sql.=',`posting_is`='.'\''.$posting_is.'\'';
		$sql.=',`modify_user`='.'\''.$modify_user.'\'';
		$sql.=',`modify_datetime`=NOW()'.' ';
		$sql.=' WHERE ';
		$sql.='`'.$this->primary_keyname. '`='.'\''.addslashes($primary_id).'\''.' ';
		//echo '<br>'.$sql; // Debug used				
		
	     $void = $this->runSQLReturnID($sql);	
		
		return true;
	}	


	
	public function is_valid_chart_code($chart_code)
	{

		$sql ="SELECT COUNT(*) AS RecordCount FROM tbl_gl_chart_master ";
		$sql .= "  WHERE ";
		$sql .= " comp_id = ". $_SESSION["target_comp_id"] ;
		$sql .=" AND chart_code = '$chart_code'";
		
		//echo '<br>'.$sql; // Debug used		
		$arr_record = $this->runSQLAssoc($sql);	

		$is_find = false;
		if ($arr_record[0]['RecordCount'] >=1) $is_find = true;
		
		return $is_find;
	}	
	
	
    public function detail_select($irow_id)
	{
		$sql = "SELECT JL.*, DETAIL.*, C.chart_code, C.chart_name, TY.type_code, TY.type_name  FROM tbl_gl_journal_entry AS JL ";
		$sql .= " LEFT JOIN tbl_gl_journal_entry_detail AS DETAIL  ON JL.journal_id = DETAIL.journal_id ";
		//$sql .= " LEFT JOIN tbl_gl_chart_master AS C  ON DETAIL.chart_code = C.chart_code  ";
		$sql .= " LEFT JOIN tbl_gl_chart_master AS C  ON DETAIL.chart_id = C.chart_id  ";
		$sql .= " LEFT JOIN  tbl_gl_chart_type_master AS TY ON C.type_code = TY.type_code  ";
		$sql .= " WHERE DETAIL.irow_id  = '$irow_id'";

		//echo "<br>sql:".$sql."<br>";
		$arr_record = $this->runSQLAssoc($sql);	

		return $arr_record[0];
	}		
	
	
    public function close()
	{
		$this->dbh = null;
	}	
	
} //class
?>