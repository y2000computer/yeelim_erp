<?php
class sys_company_master_model
{
	private $dbh;
	private $primary_keyname;
	
	public function __construct()
    {
		$this->primary_keyname = 'comp_id';
		
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
		if($json['general']['name_eng']<>"") {
			$sql_filter .= " name_eng LIKE '%".addslashes($json['general']['name_eng'])."%'" ;
		}

		//echo "<br>sql_filter:".$sql_filter."<br>";
		
		$sql = "SELECT ".$this->primary_keyname. " FROM tbl_sys_company_master ";
		if(!empty($sql_filter)) $sql .= "WHERE ".$sql_filter ;
		$sql .= " ORDER BY ".$this->primary_keyname.  ";";
		
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

			$sql = "SELECT * FROM tbl_sys_company_master ";
			if(!empty($arr_primary_id)) $sql .= "WHERE ".$this->primary_keyname. " in (".$arr_primary_id.")" ;
			$sql .= " ORDER BY " .$this->primary_keyname ;
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
 		$sql ="SELECT * FROM tbl_sys_company_master WHERE ".$this->primary_keyname. " = '$primary_id'";
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
	
 
	public function create($general)
	{
		$name_eng = trim(addslashes($general['name_eng']));
		$name_chn = trim(addslashes($general['name_chn']));
		$add_eng_1 = trim(addslashes($general['add_eng_1']));
		$add_eng_2 = trim(addslashes($general['add_eng_2']));
		$add_eng_3 = trim(addslashes($general['add_eng_3']));
		$add_eng_4 = trim(addslashes($general['add_eng_4']));
		$add_chn_1 = trim(addslashes($general['add_chn_1']));
		$add_chn_2 = trim(addslashes($general['add_chn_2']));
		$add_chn_3 = trim(addslashes($general['add_chn_3']));
		$add_chn_4 = trim(addslashes($general['add_chn_4']));
		$tel = addslashes($general['tel']);
		$fax = addslashes($general['fax']);
		$email = addslashes($general['email']);
		$journal_prefix = strtoupper(addslashes($general['journal_prefix']));
		$status = $general['status'];
		
		$create_user = $_SESSION['sUserID'];

		$this->dbh->beginTransaction();
		
		$sql = "INSERT INTO `tbl_sys_company_master`(
						`name_eng`
						,`name_chn`
						,`add_eng_1`
						,`add_eng_2`
						,`add_eng_3`
						,`add_eng_4`
						,`add_chn_1`
						,`add_chn_2`
						,`add_chn_3`
						,`add_chn_4`
						,`tel`
						,`fax`
						,`email`
						,`journal_prefix`
						,`status`
						,`create_user`
						,`modify_user`
						,`create_datetime`
						,`modify_datetime`
						) VALUES (
							'$name_eng'
							,'$name_chn'
							,'$add_eng_1'
							,'$add_eng_2'
							,'$add_eng_3'
							,'$add_eng_4'
							,'$add_chn_1'
							,'$add_chn_2'
							,'$add_chn_3'
							,'$add_chn_4'
							,'$tel'
							,'$fax'
							,'$email'
							,'$journal_prefix'
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
		$name_eng = trim(addslashes($general['name_eng']));
		$name_chn = trim(addslashes($general['name_chn']));
		$add_eng_1 = trim(addslashes($general['add_eng_1']));
		$add_eng_2 = trim(addslashes($general['add_eng_2']));
		$add_eng_3 = trim(addslashes($general['add_eng_3']));
		$add_eng_4 = trim(addslashes($general['add_eng_4']));
		$add_chn_1 = trim(addslashes($general['add_chn_1']));
		$add_chn_2 = trim(addslashes($general['add_chn_2']));
		$add_chn_3 = trim(addslashes($general['add_chn_3']));
		$add_chn_4 = trim(addslashes($general['add_chn_4']));
		$tel = addslashes($general['tel']);
		$fax = addslashes($general['fax']);
		$email = addslashes($general['email']);
		$journal_prefix = strtoupper(addslashes($general['journal_prefix']));
		$status = $general['status'];

		$modify_user = $_SESSION['sUserID'];


		$this->dbh->beginTransaction();
		
	
		$sql ='UPDATE  `tbl_sys_company_master` SET ';
		$sql.='`name_eng`='.'\''.$name_eng.'\'';
		$sql.=',`name_chn`='.'\''.$name_chn.'\'';
		$sql.=',`add_eng_1`='.'\''.$add_eng_1.'\'';
		$sql.=',`add_eng_2`='.'\''.$add_eng_2.'\'';
		$sql.=',`add_eng_3`='.'\''.$add_eng_3.'\'';
		$sql.=',`add_eng_4`='.'\''.$add_eng_4.'\'';
		$sql.=',`add_chn_1`='.'\''.$add_chn_1.'\'';
		$sql.=',`add_chn_2`='.'\''.$add_chn_2.'\'';
		$sql.=',`add_chn_3`='.'\''.$add_chn_3.'\'';
		$sql.=',`add_chn_4`='.'\''.$add_chn_4.'\'';
		$sql.=',`tel`='.'\''.$tel.'\'';
		$sql.=',`fax`='.'\''.$fax.'\'';
		$sql.=',`email`='.'\''.$email.'\'';
		$sql.=',`journal_prefix`='.'\''.$journal_prefix.'\'';
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

	
	public function is_duplicate_field($field_name, $para)
	{
		$para = addslashes($para);
		$sql ="SELECT COUNT(*) AS RecordCount FROM tbl_sys_company_master where $field_name = '$para'";
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
			
			
	public function is_duplicate_field_myself($myself_id_para , $field_name, $field_para)
	{
		$myself_id_para = addslashes($myself_id_para);
		$field_name = addslashes($field_name);
		$field_para = addslashes($field_para);
		
		$sql ="SELECT COUNT(*) AS RecordCount FROM tbl_sys_company_master WHERE $field_name = '$field_para' AND ".$this->primary_keyname. "<>'$myself_id_para' ";
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
			
    public function close()
	{
		$this->dbh = null;
	}	
	
} //class
?>