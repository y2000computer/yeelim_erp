<?php
class prop_rent_payment_model
{
	private $dbh;
	private $primary_table;
	private $primary_keyname;
	private $primary_indexname;
	
	public function __construct()
    {
		$this->primary_keyname = 'payment_id';
		$this->primary_indexname = 'payment_code';
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
			$sql_filter .= " PAY.build_id = '".addslashes($json['general']['build_id'])."'" ;
		}	
		
		
		if($json['general']['payment_date_from']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " date(PAY.payment_date) BETWEEN '". toYMD($json['general']['payment_date_from'])."' AND '". toYMD($json['general']['payment_date_to'])."'" ;
		}			

		
		if($json['general']['payment_code']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " PAY.payment_code LIKE '%".addslashes($json['general']['payment_code'])."%'" ;
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
		
		$sql = "SELECT ".$this->primary_keyname. " FROM tbl_prop_rent_payment AS PAY ";
		$sql .= "  LEFT JOIN  tbl_prop_rent_inv AS INV ON PAY.inv_id = INV.inv_id  ";
		$sql .= "  LEFT JOIN  tbl_prop_tenant_info AS C ON INV.tenant_id = C.tenant_id  ";
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
			$sql = "SELECT PAY.*, C.tenant_code, INV.eng_name AS 'tenant_eng_name' , B.eng_name AS 'build_eng_name', INV.inv_date, INV.inv_code, INV.period_date_from, INV.period_date_to ";
			$sql .= "  ,INV.amount AS inv_amount ";
			$sql .= "  FROM tbl_prop_rent_payment AS PAY ";
			$sql .= "  LEFT JOIN  tbl_prop_rent_inv AS INV ON PAY.inv_id = INV.inv_id  ";
			$sql .= "  LEFT JOIN  tbl_prop_tenant_info AS C ON INV.tenant_id = C.tenant_id  ";
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

		$sql = "SELECT PAY.*, C.tenant_code, INV.eng_name AS 'tenant_eng_name' , B.eng_name AS 'build_eng_name', INV.inv_date, INV.inv_code, INV.period_date_from, INV.period_date_to ";
		$sql .= "  ,INV.amount AS inv_amount ";
		$sql .= "  FROM tbl_prop_rent_payment AS PAY ";
		$sql .= "  LEFT JOIN  tbl_prop_rent_inv AS INV ON PAY.inv_id = INV.inv_id  ";
		$sql .= "  LEFT JOIN  tbl_prop_tenant_info AS C ON INV.tenant_id = C.tenant_id  ";
		$sql .= "  LEFT JOIN  tbl_prop_build_master AS B ON C.build_id = B.build_id  ";
		$sql .= "  WHERE ".$this->primary_keyname. " = '$primary_id'";

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
		$sql ="SELECT COUNT(*) AS RecordCount FROM tbl_prop_rent_payment ";
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
		
		$sql ="SELECT COUNT(*) AS RecordCount FROM tbl_prop_rent_payment ";
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

    public function prop_tenant_info_viewall($build_id)
	{
		$sql ="SELECT * FROM tbl_prop_tenant_info ";
		$sql .= " WHERE ";
		$sql .= " build_id = ". $build_id;
		$sql .= " ORDER BY tenant_id ASC; ";
		
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


	
	public function update($primary_id, $general)
	{
		$payment_date = toYMD($general['payment_date']);
		$amount = (double) ($general['amount']);
		$status = $general['status'];
		
		$modify_user = $_SESSION['sUserID'];


		$sql ="SELECT * FROM tbl_prop_rent_inv ";
		$sql .= " WHERE ";
		$sql .= " inv_id = ";
		$sql .= " ( ";
		$sql .= "  SELECT inv_id FROM tbl_prop_rent_payment WHERE  ";
		$sql .='`'.$this->primary_keyname. '`='.'\''.addslashes($primary_id).'\''.' ';		
		$sql .= "  ) ";
		//echo '<br>'.$sql; // Debug used				

	
		$inv_row = array();
		try {
			$rows = $this->dbh->query($sql);
			while($row = $rows->fetch(PDO::FETCH_ASSOC)){
			  $inv_row[] = $row;
				}
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
			}
		
		
		$inv_rs = $inv_row[0];
		$inv_id = $inv_rs['inv_id'];
		$inv_amount = $inv_rs['amount'];
		$balance = $inv_rs['balance'];

		$sql ="SELECT * FROM tbl_prop_rent_payment ";
		$sql .= " WHERE ";
		$sql .='`'.$this->primary_keyname. '`='.'\''.addslashes($primary_id).'\''.' ';		
		//echo '<br>'.$sql; // Debug used				


		
		$payment_row = array();
		try {
			$rows = $this->dbh->query($sql);
			while($row = $rows->fetch(PDO::FETCH_ASSOC)){
			  $payment_row[] = $row;
				}
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
			}

		
		$payment_rs  = $payment_row[0];	
		$payment_amount_before_update	= 0;
		if($payment_rs['status'] == 1) $payment_amount_before_update = $payment_rs['amount'];

		//revert & re-calcuate balance
		$balance = $balance + $payment_amount_before_update;
		if($status == 1) $balance = $balance - $amount;

	
		$this->dbh->beginTransaction();
	
		$sql ='UPDATE  `tbl_prop_rent_payment` SET ';
		$sql.=' `payment_date`='.'\''.$payment_date.'\'';
		$sql.=',`amount`='.'\''.$amount.'\'';
		$sql.=',`status`='.'\''.$status.'\'';
		$sql.=',`modify_user`='.'\''.$modify_user.'\'';
		$sql.=',`modify_datetime`=NOW()'.' ';
		$sql.=' WHERE ';
		$sql.='`'.$this->primary_keyname. '`='.'\''.addslashes($primary_id).'\''.' ';
		//echo '<br>'.$sql; // Debug used				
	
	
		try {
			$rows = $this->dbh->query($sql);
			} catch (PDOException $e) {		
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		
		
		$sql ='UPDATE  `tbl_prop_rent_payment` SET ';
		$sql.=' `payment_date`='.'\''.$payment_date.'\'';
		$sql.=',`amount`='.'\''.$amount.'\'';
		$sql.=',`status`='.'\''.$status.'\'';
		$sql.=',`modify_user`='.'\''.$modify_user.'\'';
		$sql.=',`modify_datetime`=NOW()'.' ';
		$sql.=' WHERE ';
		$sql.='`'.$this->primary_keyname. '`='.'\''.addslashes($primary_id).'\''.' ';
		//echo '<br>'.$sql; // Debug used				
	
	
		try {
			$rows = $this->dbh->query($sql);
			} catch (PDOException $e) {		
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}	


		$sql ='UPDATE  `tbl_prop_rent_inv` SET ';
		$sql.=' `balance`='.'\''.$balance.'\'';
		$sql.=' WHERE ';
		$sql.='`'.'inv_id'. '`='.'\''.addslashes($inv_id).'\''.' ';
		echo '<br>'.$sql; // Debug used				
	
		try {
			$rows = $this->dbh->query($sql);
			} catch (PDOException $e) {		
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}	
		

		$this->dbh->commit();
		
		return $last_insert_id;
	}	
	


	public function search_outstanding_invoice($jsondata)
	{
		$json = json_decode($jsondata, true);
	
		$sql_filter = "";
		if($json['general']['build_id']<>"") {
			$sql_filter .= " INV.build_id = '".addslashes($json['general']['build_id'])."'" ;
		}	
		
		if($json['general']['tenant_code']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " C.tenant_code LIKE '%".addslashes($json['general']['tenant_code'])."%'" ;
		}

		if($json['general']['inv_code']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " INV.inv_code LIKE '%".addslashes($json['general']['inv_code'])."%'" ;
		}


		if($json['general']['inv_date_from']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " date(INV.inv_date) BETWEEN '". toYMD($json['general']['inv_date_from'])."' AND '". toYMD($json['general']['inv_date_to'])."'" ;
		}			

		if(!empty($sql_filter)) {
			$sql_filter.=" AND ";
			$sql_filter .= " INV.balance <> 0 AND INV.status = 1 " ;
		}			

		//echo "<br>sql_filter:".$sql_filter."<br>";
		$sql = " SELECT INV.inv_id FROM  tbl_prop_rent_inv AS INV ";
		$sql .= "  LEFT JOIN  tbl_prop_tenant_info AS C ON INV.tenant_id = C.tenant_id  ";
		$sql .= "  LEFT JOIN  tbl_prop_build_master AS B ON C.build_id = B.build_id  ";
		$sql .= "  WHERE ";
		$sql .= " (1) " ;
		if(!empty($sql_filter)) $sql .= " AND  ".$sql_filter ;
		$sql .= " ORDER BY "." INV.inv_id ". ";";
		//echo "<br>sql:".$sql."<br>";
		
		$arr_primary_id =array();
		try {
			$rs = $this->dbh->query($sql);
			while($row = $rs->fetch(PDO::FETCH_ASSOC)){
				$arr_primary_id[] = "'". addslashes($row['inv_id']) ."'";
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


	public function retreive_content_outstanding_invoice($lot_id,$page)
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
			
			$sql = "SELECT INV.*, C.tenant_code, INV.eng_name AS 'tenant_eng_name' , B.eng_name AS 'build_eng_name' FROM tbl_prop_rent_inv AS INV ";
			$sql .= "  LEFT JOIN  tbl_prop_tenant_info AS C ON INV.tenant_id = C.tenant_id  ";
			$sql .= "  LEFT JOIN  tbl_prop_build_master AS B ON C.build_id = B.build_id  ";
			if(!empty($arr_primary_id)) $sql .= "WHERE "." INV.inv_id ". " in (".$arr_primary_id.")" ;
			$sql .= " ORDER BY " ." INV.inv_id " ;
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




    public function close()
	{
		$this->dbh = null;
	}	
	
} //class
?>