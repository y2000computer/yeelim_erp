<?php
class prop_tenant_info_model
{
	private $dbh;
	private $primary_table;
	private $primary_keyname;
	private $primary_indexname;
	
	public function __construct()
    {
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
			$sql_filter .= " C.tenant_code LIKE '%".addslashes($json['general']['tenant_code'])."%'" ;
		}

		if($json['general']['eng_name']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " C.eng_name LIKE '%".addslashes($json['general']['eng_name'])."%'" ;
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
		try {
			$rs = $this->dbh->query($sql);
			while($row = $rs->fetch(PDO::FETCH_ASSOC)){
				$arr_primary_id[] = "'". addslashes($row[$this->primary_keyname]) ."'";
				}
			} catch (PDOException $e){
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		
		

		$array_count = count($arr_primary_id);

		if ($array_count > 0){	  
			$result_id = implode(",", $arr_primary_id);
		}
		
		$lot_id = strtotime(date("Y-m-d H:i:s")).rand(0, 10);;

		$this->dbh->beginTransaction();

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

		try {
			$rows = $this->dbh->query($sql);
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}
		  
		$this->dbh->commit();

		return $lot_id;
	}

 
  public function retreive_content($lot_id,$page)
	{

		$sql = "SELECT * FROM tbl_sys_paging_control WHERE lot_id = '".$lot_id."' AND create_user =	'".$_SESSION['sUserID']."';";
		//echo "<br>sql:".$sql."<br>";
		$arr_record = array();	
		try {
				$rs = $this->dbh->query($sql);
				while($row = $rs->fetch(PDO::FETCH_ASSOC)){
					$arr_record[] = $row;
					}
				} catch (PDOException $e){
					print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
					die();
					}		

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
			
			$arr_record = array();	
			try {
					$rs = $this->dbh->query($sql);
					while($row = $rs->fetch(PDO::FETCH_ASSOC)){
						$arr_record[] = $row;
						}
					} catch (PDOException $e){
						print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
						die();
						}		
			return $arr_record;
		}
		
		return $arr_record;
	}

  public function paging_config($lot_id)
	{
		$sql = "SELECT * FROM tbl_sys_paging_control WHERE lot_id = '".$lot_id."' AND create_user =	'".$_SESSION['sUserID']."';";
		//echo "<br>sql:".$sql."<br>";
		$arr_record = array();	
		try {
			$rows = $this->dbh->query($sql);
			while($row = $rows->fetch(PDO::FETCH_ASSOC)){
				$arr_record[] = $row;
					}
				} catch (PDOException $e){
					print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
					die();
					}		
		  
		$result_id = $arr_record[0]['result_id'];

		$this->dbh->beginTransaction();

		$sql ="UPDATE `tbl_sys_paging_control` SET modify_datetime =now()	WHERE lot_id ='$lot_id'";


		try {
			$rows = $this->dbh->query($sql);
			$last_insert_id = $this->dbh->lastInsertId(); 
			} catch (PDOException $e) {		
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		
		
		$this->dbh->commit();		
		return $result_id;
	}	

    public function searchphrase($lot_id)
	{
		$sql = "SELECT searchphrase FROM tbl_sys_paging_control WHERE lot_id = '".$lot_id."' AND create_user =	'".$_SESSION['sUserID']."';";
		//echo "<br>sql:".$sql."<br>";
		
		$arr_record = array();	
		try {
			$rows = $this->dbh->query($sql);
			while($row = $rows->fetch(PDO::FETCH_ASSOC)){
				$arr_record[] = $row;
				}
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		

		$searchphrase = $arr_record[0]['searchphrase'];
		return $searchphrase;
				
	}		

    public function select($primary_id)
	{
 		$sql ="SELECT * FROM tbl_prop_tenant_info WHERE ".$this->primary_keyname. " = '$primary_id'";
		//echo "<br>sql:".$sql."<br>";
				
		$arr_record = array();
		try {
			$rows = $this->dbh->query($sql);
			while($row = $rows->fetch(PDO::FETCH_ASSOC)){
			  $arr_record[] = $row;
			 }
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		
		
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
			
		$arr_record = array();
 		try {
			$rows = $this->dbh->query($sql);
			while($row = $rows->fetch(PDO::FETCH_ASSOC)){
				$arr_record[] = $row;
				}
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		

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
			
		$arr_record = array();
 		try {
			$rows = $this->dbh->query($sql);
			while($row = $rows->fetch(PDO::FETCH_ASSOC)){
				$arr_record[] = $row;
				}
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		

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
		
		$record = array();
		try {
			$rows = $this->dbh->query($sql);
			while($row = $rows->fetch(PDO::FETCH_ASSOC)){
			  $record[] = $row;
				}
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
			}		
		
		return $record;
	}	

	public function create($general)
	{
		$build_id = trim(addslashes($general['build_id']));
		$tenant_code = trim(addslashes($general['tenant_code']));
		$eng_name = trim(addslashes($general['eng_name']));
		$add_1 = trim(addslashes($general['add_1']));
		$add_2 = trim(addslashes($general['add_2']));
		$add_3 = trim(addslashes($general['add_3']));
		$ref_no = trim(addslashes($general['ref_no']));
		$shop_no = trim(addslashes($general['shop_no']));
		$rent_date = toYMD($general['rent_date']);
		$rent_amount = trim(addslashes($general['rent_amount']));
		$maint_date = toYMD($general['maint_date']);
		$maint_amount = trim(addslashes($general['maint_amount']));
		$ptype = addslashes($general['ptype']);
		$status = $general['status'];
		
		$create_user = $_SESSION['sUserID'];

		$this->dbh->beginTransaction();
		
		$sql = "INSERT INTO `tbl_prop_tenant_info`(
						`build_id`
						,`tenant_code`
						,`eng_name`
						,`add_1`
						,`add_2`
						,`add_3`
						,`ref_no`
						,`shop_no`
						,`rent_date`
						,`rent_amount`
						,`maint_date`
						,`maint_amount`
						,`ptype`
						,`status`
						,`create_user`
						,`modify_user`
						,`create_datetime`
						,`modify_datetime`
						) VALUES (
							'$build_id'
							,'$tenant_code'
							,'$eng_name'
							,'$add_1'
							,'$add_2'
							,'$add_3'
							,'$ref_no'
							,'$shop_no'
							,'$rent_date'
							,'$rent_amount'
							,'$maint_date'
							,'$maint_amount'
							,'$ptype'
							,'$status'
							,'$create_user'
							,'$create_user'
							,now()
							,now()
							)";

		//echo '<br>'.$sql.'<br>';		
								
		try {
			$rows = $this->dbh->query($sql);
			$last_insert_id = $this->dbh->lastInsertId(); 
			} catch (PDOException $e) {		
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		
		
		$this->dbh->commit();
			
		return $last_insert_id;
	}
	
	
	public function update($primary_id, $general)
	{
		$build_id = trim(addslashes($general['build_id']));
		$tenant_code = trim(addslashes($general['tenant_code']));
		$eng_name = trim(addslashes($general['eng_name']));
		$add_1 = trim(addslashes($general['add_1']));
		$add_2 = trim(addslashes($general['add_2']));
		$add_3 = trim(addslashes($general['add_3']));
		$ref_no = trim(addslashes($general['ref_no']));
		$shop_no = trim(addslashes($general['shop_no']));
		$rent_date = toYMD($general['rent_date']);
		$rent_amount = trim(addslashes($general['rent_amount']));
		$maint_date = toYMD($general['maint_date']);
		$maint_amount = trim(addslashes($general['maint_amount']));
		$ptype = addslashes($general['ptype']);
		$status = $general['status'];
		
		$modify_user = $_SESSION['sUserID'];

		$this->dbh->beginTransaction();
	
		$sql ='UPDATE  `tbl_prop_tenant_info` SET ';
		$sql.='`build_id`='.'\''.trim($build_id).'\'';
		$sql.=',`tenant_code`='.'\''.$tenant_code.'\'';
		$sql.=',`eng_name`='.'\''.$eng_name.'\'';
		$sql.=',`add_1`='.'\''.$add_1.'\'';
		$sql.=',`add_2`='.'\''.$add_2.'\'';
		$sql.=',`add_3`='.'\''.$add_3.'\'';
		$sql.=',`ref_no`='.'\''.$ref_no.'\'';
		$sql.=',`shop_no`='.'\''.$shop_no.'\'';
		$sql.=',`rent_date`='.'\''.$rent_date.'\'';
		$sql.=',`rent_amount`='.'\''.$rent_amount.'\'';
		$sql.=',`maint_date`='.'\''.$maint_date.'\'';
		$sql.=',`maint_amount`='.'\''.$maint_amount.'\'';
		$sql.=',`ptype`='.'\''.$ptype.'\'';
		$sql.=',`status`='.'\''.$status.'\'';
		$sql.=',`modify_user`='.'\''.$modify_user.'\'';
		$sql.=',`modify_datetime`=NOW()'.' ';
		$sql.=' WHERE ';
		$sql.='`'.$this->primary_keyname. '`='.'\''.addslashes($primary_id).'\''.' ';
		//echo '<br>'.$sql; // Debug used				
	
		try {
			$rows = $this->dbh->query($sql);
			$last_insert_id = $this->dbh->lastInsertId(); 
			} catch (PDOException $e) {		
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		
		
		$this->dbh->commit();
		
		return $last_insert_id;
	}	
	

	public function rent_transaction_list($primary_id)
	{


		$sql = "SELECT A.*  FROM tbl_prop_rent_inv AS A  ";
		$sql .= " WHERE A.".$this->primary_keyname. " = '$primary_id'";
		$sql .= " ORDER BY A.".$this->primary_keyname." ; ";

		//echo "<br><br><br>sql:".$sql."<br>";
				
		$arr_record = array();
		try {
			$rows = $this->dbh->query($sql);
			while($row = $rows->fetch(PDO::FETCH_ASSOC)){
			  $arr_record[] = $row;
			 }
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		
		
		return $arr_record;
	}		

	public function maint_transaction_list($primary_id)
	{


		$sql = "SELECT A.*  FROM tbl_prop_maint_inv AS A  ";
		$sql .= " WHERE A.".$this->primary_keyname. " = '$primary_id'";
		$sql .= " ORDER BY A.".$this->primary_keyname." ; ";

		//echo "<br><br><br>sql:".$sql."<br>";
				
		$arr_record = array();
		try {
			$rows = $this->dbh->query($sql);
			while($row = $rows->fetch(PDO::FETCH_ASSOC)){
			  $arr_record[] = $row;
			 }
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		
		
		return $arr_record;
	}		
 	

    public function close()
	{
		$this->dbh = null;
	}	
	
} //class
?>