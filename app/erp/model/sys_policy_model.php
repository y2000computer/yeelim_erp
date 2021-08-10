<?php
class sys_policy_model extends dataManager
{
	private $dbh;
	
	private $table_field;  // variable for dataManager
	private $errorMsg;   // variable for dataManager
	private $mainTable;   // variable for dataManager


	public function __construct()
    {

		parent::__construct();
		$this->setErrorMsg('System -> Transaction -> Security Policy Information -> SQL error:');

		try {
			$this->dbh = new PDO(DB_CONNECTION_STRING,DB_USERNAME,DB_PASSWORD);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->dbh->query("set names utf8");
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
			}
	}
	
   public function search_policy($jsondata)
	{
		$json = json_decode($jsondata, true);
	
		$sql_filter = "";
		if($json['policy']['eng_name']<>"") {
			$sql_filter .= " eng_name LIKE '%".addslashes($json['policy']['eng_name'])."%'" ;
		}
		
		$sql = "SELECT policy_id FROM tbl_sys_policy ";
		if(!empty($sql_filter)) $sql .= "WHERE ".$sql_filter ;
		$sql .= " ORDER BY policy_id;";
		
		//echo '<br>'.$sql.'<br>';
		$sql_search_result_id =array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$sql_search_result_id[] = "'". addslashes($row['policy_id']) ."'";
		endforeach; 	

		/*
		$sql_search_result_id =array();
		try {
			$rs = $this->dbh->query($sql);
			while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$sql_search_result_id[] = "'". addslashes($row['policy_id']) ."'";
			 }

			} catch (PDOException $e){
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		
		*/

		$array_count = count($sql_search_result_id);
	
		if ($array_count > 0){	  
			$result_id = implode(",", $sql_search_result_id);
		}
		//$lot_id = strtotime(date("Y-m-d H:i:s"));
		$lot_id = strtotime(date("Y-m-d H:i:s")).rand(0, 10);;

		//$this->dbh->beginTransaction();

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

		$void = $this->runSQLReturnID($sql);
		/*
		try {
			$rows = $this->dbh->query($sql);
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		
				
		$this->dbh->commit();
		*/

	return $lot_id;
}


   public function search_module($jsondata)
	{
		$json = json_decode($jsondata, true);
	
		$sql_filter = "";
		if($json['network']['eng_name']<>"") {
			$sql_filter .= " eng_name LIKE '%".addslashes($json['network']['eng_name'])."%'" ;
		}
		if($json['network']['network']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " network LIKE '%".addslashes($json['network']['network'])."%'" ;
		}
		if($json['network']['range_from']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " range_from LIKE '%".addslashes($json['network']['range_from'])."%'" ;
		}


		
		$sql = "SELECT policy_id FROM tbl_sys_policy ";
		if(!empty($sql_filter)) $sql .= "WHERE ".$sql_filter ;
		$sql .= " ORDER BY network_id;";
		

		$sql_search_result_id = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$sql_search_result_id[] = $row;
		endforeach; 	


		/*
		try {
			$rs = $this->dbh->query($sql);
			while($row = $rs->fetch(PDO::FETCH_ASSOC)){
				$sql_search_result_id[] = "'". addslashes($row['network_id']) ."'";
				}
			} catch (PDOException $e){
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		
		
		*/		
		  
	$array_count = count($sql_search_result_id);

	if ($array_count > 0){	  
		$result_id = implode(",", $sql_search_result_id);
	}
		$lot_id = strtotime(date("Y-m-d H:i:s"));

		//$this->dbh->beginTransaction();

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

		$void = $this->runSQLReturnID($sql);	

		/*
		try {
			$rows = $this->dbh->query($sql);
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		
		
		$this->dbh->commit();
		*/

	return $lot_id;
	}

 


  public function retreive_content($lot_id,$page)
	{

		$sql = "SELECT * FROM tbl_sys_paging_control WHERE lot_id = '".$lot_id."' AND create_user =	'".$_SESSION['sUserID']."';";
		//echo "<br>sql:".$sql."<br>";
		$record = array();	
		try {
				$rs = $this->dbh->query($sql);
				while($row = $rs->fetch(PDO::FETCH_ASSOC)){
				$record[] = $row;
				 }
			} catch (PDOException $e){
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		

		$arr =  $record[0];
		$record_id_set = $arr['result_id']; 
		
		
	if ($record_id_set != '')		{


		$sql = "SELECT * FROM tbl_sys_policy ";
		if(!empty($record_id_set)) $sql .= "WHERE policy_id in (".$record_id_set.")" ;
		$sql .= " ORDER BY policy_id ";
		$sql .= " LIMIT ". SYSTEM_PAGE_ROW_LIMIT . " OFFSET  ".($page-1)*SYSTEM_PAGE_ROW_LIMIT ;
		
		//echo "<br>sql:".$sql."<br>";
		$record = array();	
		try {
				$rs = $this->dbh->query($sql);
				while($row = $rs->fetch(PDO::FETCH_ASSOC)){
				$record[] = $row;
				 }
			} catch (PDOException $e){
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		
				return $record;
		}
		

		return $record;
	}

  public function paging_config($lot_id)
	{
		$sql = "SELECT * FROM tbl_sys_paging_control WHERE lot_id = '".$lot_id."' AND create_user =	'".$_SESSION['sUserID']."';";
		//echo "<br>sql:".$sql."<br>";
		$record = array();	

		try {
			$rows = $this->dbh->query($sql);
			while($row = $rows->fetch(PDO::FETCH_ASSOC)){
				$record[] = $row;
			 }
			} catch (PDOException $e){
				print "Error!: " . $e->getMessage() . "<br/>";
				$sNewLog = new LoggerManager( 'error_sql', '1' );
				$sNewLog -> add( ('ERP->system->policy->SQL error:'.$e->getMessage().'--Statement:'.$query) );
				die();
		  }		
		  
		$result_id = $record[0]['result_id'];

		$this->dbh->beginTransaction();

		$sql ="UPDATE `tbl_sys_paging_control` SET modify_datetime =now()
		WHERE lot_id ='$lot_id'";


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

		$searchphrase = $record[0]['searchphrase'];
		
		return $searchphrase;
	}		

    public function find($id)
	{
 		$sql ="SELECT * FROM tbl_sys_policy WHERE policy_id = '$id'";
		//echo "<br>sql:".$sql."<br>";
		
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
	
	
	public function find_policy_module($id)
	{
		$sql ="SELECT a.irow_id, a.policy_id, a.module_code, a.rights_level, a.rights_create, 
				a.rights_update, a.rights_void, a.status, a.create_user, a.create_datetime, 
				a.last_modify_user, a.last_modify_datetime, b.eng_name
				FROM tbl_sys_policy_module a, tbl_sys_module b
				WHERE a.policy_id = '$id' AND a.module_code= b.module_code
				 ORDER BY a.module_code;
				";

		//echo '<br>'.$sql.'<br>';
		//'LIMIT '.$startRow.' , '.$MaxRow.';'; // Un-used proprietary statement
		$arr_policy_module = array();

		try {
			$rows = $this->dbh->query($sql);
			while($row = $rows->fetch(PDO::FETCH_ASSOC)){
			  $arr_policy_module[] = $row;
			 }
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		

		return $arr_policy_module;
	}	
	
public function policy_status_module_list_all($id)
	{
		
 		$sql ="SELECT * FROM `tbl_sys_module` 
			WHERE status=1 AND module_code NOT IN
			(SELECT module_code FROM `tbl_sys_policy_module`
			 WHERE policy_id = '$id' GROUP BY module_code)
			 ORDER BY module_code ASC";

		 //echo $sql;
		$arr_policy_status = array();

		try {
			$rows = $this->dbh->query($sql);
			while($row = $rows->fetch(PDO::FETCH_ASSOC)){
			  $arr_policy_status[] = $row;
			 }
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		
		
		
		return $arr_policy_status;
	}
	
public function attachmoduletopolicy($policy_id,$module_code,$rights_level,$rights_create,$rights_update,$rights_void,$status,$user)
	{

		$this->dbh->beginTransaction();

		$sql = "INSERT INTO `tbl_sys_policy_module`(
					`policy_id`,
					`module_code`,
					`rights_level`,		
					`rights_create`,		
					`rights_update`,		
					`rights_void`,			
					`status`,		
					`create_user`,		
					`create_datetime`,
					`last_modify_user`,		
					`last_modify_datetime`
					) VALUES (
					'$policy_id',
					'$module_code',
					'$rights_level',
					'$rights_create',
					'$rights_update',
					'$rights_void',
					'$status',
					'$user',
					NOW(),
					'$user',
					NOW())";
		//echo '<br>'.$sql; // Debug used only
		//die();
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
	
 
public function create($eng_name,$status,$sUserID)
	{
	
		$this->dbh->beginTransaction();
		$eng_name = addslashes($eng_name);
	
		$sql = "INSERT INTO `tbl_sys_policy`(
					`eng_name`,
					`status`,
					`create_user`,		
					`create_datetime`,
					`last_modify_user`,		
					`last_modify_datetime`
					) VALUES (
						'$eng_name',
						'$status',
						'$sUserID',
						now(),
						'$sUserID',
						now())";

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
	
	
	public function update_policy($network_arr,$sUserID,$id)
	{
		$this->dbh->beginTransaction();

		$sql ='UPDATE  `tbl_sys_policy` SET ';
		$sql.='`eng_name`='.'\''.addslashes($network_arr['eng_name']).'\''.',';	
		$sql.='`status`='.'\''.addslashes($network_arr['status']).'\''.',';
		$sql.='`last_modify_datetime`=NOW()'.',';
		$sql.='`last_modify_user`='.'\''.addslashes($sUserID).'\''.' ';
		$sql.=' WHERE ';
		$sql.='`policy_id`='.'\''.addslashes($id).'\''.' ';
		/*	echo '<br>'.$sql; // Debug used		
			die();
		*/
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
	 
	 public function checkduplicatepolicy($eng_name)
	{
	
		$hasFind = false;
		$iRecordCount = 0;

 		$sql ='SELECT COUNT(*) AS RecordCount FROM tbl_sys_policy 
					WHERE eng_name=\''.$eng_name.'\'';
		
		$arr_policy_item = array();

		try {
			$rows = $this->dbh->query($sql);
			while($row = $rows->fetch(PDO::FETCH_ASSOC)){
			  $arr_policy_item[] = $row;
			 }
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		
		  
		
		$policy_item  = $arr_policy_item[0];

		
		if($policy_item['RecordCount'] == 1) $hasFind = true;	 
		if($policy_item['RecordCount'] == 0) $hasFind = false;	 
		
		return $hasFind;
	}	
	
	
    public function findby_policy_module($id)
	{

 		$sql ='SELECT * FROM tbl_sys_policy_module
					WHERE irow_id = '.$id ;

		$arr_policy = array();

		try {
			$rows = $this->dbh->query($sql);
			while($row = $rows->fetch(PDO::FETCH_ASSOC)){
			  $arr_policy[] = $row;
			 }
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
		  }		
		
		return $arr_policy;
	}		

	 public function updatemoduletopolicy($irow_id,$policy_id,$module_code,$rights_level,$rights_create,$rights_update,$rights_void,$status,$user)
	{

		$this->dbh->beginTransaction();
					
		$sql ='UPDATE  `tbl_sys_policy_module` SET ';
		$sql.='`rights_level`='.'\''.addslashes($rights_level).'\''.',';
		$sql.='`rights_create`='.'\''.addslashes($rights_create).'\''.',';
		$sql.='`rights_update`='.'\''.addslashes($rights_update).'\''.',';
		$sql.='`rights_void`='.'\''.addslashes($rights_void).'\''.',';
		$sql.='`status`='.'\''.addslashes($status).'\''.',';
		$sql.='`last_modify_user`='.'\''.addslashes($user).'\''.',';
		$sql.='`last_modify_datetime`=NOW()'.' ';
		$sql.=' WHERE ';
		$sql.='`irow_id`='.'\''.addslashes($irow_id).'\''.' ';					
		//echo '<br>'.$sql; // Debug used only
		try {
			$rows = $this->dbh->query($sql);
			} catch (PDOException $e) {		
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		
		
		$this->dbh->commit();
		
	
		return true;
	}	
	

    public function close()
	{
		$this->dbh = null;
	}	
	
}
?>