<?php
class sys_user_model extends dataManager
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
		$this->setErrorMsg('System -> Transaction -> User Information -> SQL error:');


		$this->primary_keyname = 'user_id';
		$this->primary_indexname = 'user_id';
		try {
			$this->dbh = new PDO(DB_CONNECTION_STRING,DB_USERNAME,DB_PASSWORD);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->dbh->query("set names utf8");
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
			}
	}
	
    public function department_all()
	{
 		$sql ='SELECT * FROM tbl_sys_depart_master where status = 1 order by sorting ASC';
		//echo '<br>'.$sql.'<br>';
		$arr_depart = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_depart[] = $row;
		endforeach; 	

		return $arr_depart;
	}	
	
   public function search($jsondata)
	{
		$json = json_decode($jsondata, true);
	
		$sql_filter = "";
		if($json['user']['username']<>"") {
			$sql_filter .= " email LIKE '%".addslashes($json['user']['username'])."%'" ;
		}
		if($json['user']['eng_name']<>"") {
					if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " last_name LIKE '%".addslashes($json['user']['eng_name'])."%'" ;
		}
		
		$sql = "SELECT user_id FROM tbl_sys_user ";
		if(!empty($sql_filter)) $sql .= "WHERE ".$sql_filter ;
		$sql .= " ORDER BY user_id";
		
		//echo '<br>'.$sql.'<br>';
		$sql_search_result_id = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$sql_search_result_id[] = "'". addslashes($row['user_id']) ."'";
		endforeach; 	

		  
		$array_count = count($sql_search_result_id);
		

		if ($array_count > 0){	  
			$result_id = implode(",", $sql_search_result_id);
		}
			//$lot_id = strtotime(date("Y-m-d H:i:s"));
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

			//echo '<br>'.$sql.'<br>';
			$void = $this->runSQLReturnID($sql);


		return $lot_id;
	}



  public function retreive_content($lot_id,$page)
	{

		$sql = "SELECT * FROM tbl_sys_paging_control WHERE lot_id = '".$lot_id."' AND create_user =	'".$_SESSION['sUserID']."';";
		//echo "<br>sql:".$sql."<br>";
		$record = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$record[] = $row;
		endforeach; 


		$arr =  $record[0];
		$record_id_set = $arr['result_id']; 
		
		
		if ($record_id_set != '')		{

			$sql = "SELECT * FROM tbl_sys_user ";
			if(!empty($record_id_set)) $sql .= "WHERE user_id in (".$record_id_set.")" ;
			$sql .= " ORDER BY user_id ";
			$sql .= " LIMIT ". SYSTEM_PAGE_ROW_LIMIT . " OFFSET  ".($page-1)*SYSTEM_PAGE_ROW_LIMIT ;
			
			//echo "<br>sql:".$sql."<br>";
			$record = array();
			$rows = $this->runSQLAssoc($sql);	
			foreach ($rows as $row): 
				$record[] = $row;
			endforeach; 


			return $record;
		}
		

		return $record;
	}

  public function paging_config($lot_id)
	{
		$sql = "SELECT * FROM tbl_sys_paging_control WHERE lot_id = '".$lot_id."' AND create_user =	'".$_SESSION['sUserID']."';";
		//echo "<br>sql:".$sql."<br>";
		$record = array();	
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$record[] = $row;
		endforeach; 

		  
		$result_id = $record[0]['result_id'];
	
		$sql ="UPDATE `tbl_sys_paging_control` SET modify_datetime =now() WHERE lot_id ='$lot_id'";
		//echo "<br>sql:".$sql."<br>";
		$void = $this->runSQLReturnID($sql);			
		
		
		return $result_id;
	}	

    public function searchphrase($lot_id)
	{
		$sql = "SELECT searchphrase FROM tbl_sys_paging_control WHERE lot_id = '".$lot_id."' AND create_user =	'".$_SESSION['sUserID']."';";
		//echo "<br>sql:".$sql."<br>";
		$record = array();	
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$record[] = $row;
		endforeach; 


		$searchphrase = $record[0]['searchphrase'];
		return $searchphrase;
				
	
}		

    public function find($id)
	{
 		$sql ="SELECT * FROM tbl_sys_user WHERE user_id = '$id'";
		//echo "<br>sql:".$sql."<br>";
		$record = array();	
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$record[] = $row;
		endforeach; 
		
		
		return $record;
	}		
	
	
	 public function find_user_policy($id)
	{
 		$query ="SELECT * FROM tbl_sys_user_policy_grant WHERE user_id = '$id'";
		//echo '<br>'.$query.'<br>';
		$arr_policy_module = array();	
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_policy_module[] = $row;
		endforeach; 

		return $arr_user_policy;
	}	
	
    public function user_policy($id)
	{
 		$sql ="SELECT a.irow_id, b.eng_name , a.status, a.create_user, a.create_datetime, a.modify_user, a.modify_datetime
		FROM tbl_sys_user_policy_grant AS a, tbl_sys_policy AS b 
		WHERE  a.policy_id = b.policy_id AND a.user_id= '$id'";
		//echo '<br>'.$sql.'<br>';
		$arr_user_policy = array();	
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_user_policy[] = $row;
		endforeach; 

		
		return $arr_user_policy;
	}	
	
	
  public function user_ava_policy($id)
	{
 		$sql ="SELECT * FROM `tbl_sys_policy`  WHERE status=1 AND policy_id NOT IN	(SELECT policy_id FROM `tbl_sys_user_policy_grant`
		 WHERE user_id = '$id' )
		 ORDER BY policy_id ASC";
		//echo '<br>'.$sql.'<br>';
		$arr_user_policy = array();	
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_user_policy[] = $row;
		endforeach; 

		
		return $arr_user_policy;
	}	
	
	
  public function user_ava_network($id)
	{
 		$sql ="SELECT * FROM `tbl_sys_network`  WHERE status=1 AND network_id NOT IN	(SELECT network_id FROM `tbl_sys_user_network_grant`
		 WHERE user_id = '$id' )
		 ORDER BY network_id ASC";
		//echo '<br>'.$sql.'<br>';
		$arr_ava_network = array();	
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_ava_network[] = $row;
		endforeach; 

		
		return $arr_ava_network;
	}
	

    public function user_network($id)
	{
 		$sql ="SELECT a.irow_id, b.eng_name , a.status FROM tbl_sys_user_network_grant AS a, tbl_sys_network AS b 
		WHERE  a.network_id = b.network_id AND a.user_id= '$id'";
		//echo '<br>'.$sql.'<br>';
		$arr_user_network = array();	
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_user_network[] = $row;
		endforeach; 


		return $arr_user_network;
	}		
	
  
 
	public function create($email,$password,$last_name,$first_name,$depart_code,$status,$sUserID)
	{
	
	
		$email = addslashes($email);
		$password = addslashes($password);
		$staff_no = addslashes($staff_no);
		$last_name = addslashes($last_name);
		$first_name = addslashes($first_name);
		$email = addslashes($email);
		$cust_id_list = addslashes($cust_id_list);
	
		$sql = "INSERT INTO `tbl_sys_user`(
					`email`,
					`password`,
					`last_name`,
					`first_name`,
					`depart_code`,
					`status`,
					`create_user`,		
					`create_datetime`,
					`modify_user`,		
					`modify_datetime` 
					) VALUES (
						'$email',
						'$password',
						'$last_name',
						'$first_name',
						'$depart_code',
						'$status',
						'$sUserID',
						now(),
						'$sUserID',
						now())";
		//echo '<br>'.$sql.'<br>';
		$last_insert_id = $this->runSQLReturnID($sql);	

		
		return $last_insert_id;
	}
	
	
	public function update_user($user,$sUserID,$id)
	{
	
		$sql ='UPDATE  `tbl_sys_user` SET ';
		$sql.='`email`='.'\''.addslashes($user['email']).'\''.',';	
		$sql.='`password`='.'\''.addslashes($user['password']).'\''.',';
		$sql.='`last_name`='.'\''.addslashes($user['last_name']).'\''.',';
		$sql.='`first_name`='.'\''.addslashes($user['first_name']).'\''.',';
		$sql.='`depart_code`='.'\''.addslashes($user['depart_code']).'\''.',';
		$sql.='`status`='.'\''.addslashes($user['status']).'\''.',';
		$sql.='`modify_datetime`=NOW()'.',';
		$sql.='`modify_user`='.'\''.addslashes($sUserID).'\''.' ';
		$sql.=' WHERE ';
		$sql.='`user_id`='.'\''.addslashes($id).'\''.' ';
		//echo '<br>'.$sql; // Debug used		
		$void = $this->runSQLReturnID($sql);	

			
		return true;
	}	
	
	public function checkduplicatepolicy($user)
	{
	
		$hasFind = false;
		$iRecordCount = 0;

 		$sql ='SELECT COUNT(*) AS RecordCount FROM tbl_sys_user 
					WHERE email=\''.$email.'\'';
		//echo '<br>'.$sql.'<br>'; 	
		$arr_user_item = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_user_item[] = $row;
		endforeach; 	


		$user_item  = $arr_user_item[0];
		
		if($user_item['RecordCount'] == 1) $hasFind = true;	 
		if($user_item['RecordCount'] == 0) $hasFind = false;	 
		
		return $hasFind;
	}	
	
	
    public function findby_policy_module($id)
	{

 		$sql ='SELECT * FROM tbl_sys_policy_module
					WHERE policy_module_id = '.$id ;

		$arr_policy = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_policy[] = $row;
		endforeach;


		return $arr_policy;
	}		

	

	public function add_policy($policy_select,$user,$IS_para_id)
	{


		$sql = "INSERT INTO `tbl_sys_user_policy_grant`(
					`user_id`,
					`policy_id`,
					`status`,		
					`create_user`,		
					`create_datetime`
					) VALUES (
					'$IS_para_id',
					'$policy_select',
					'1',
					'$user',
					NOW())";

		$last_insert_id = $this->runSQLReturnID($sql);			

		return $IS_para_id;
	}
	
	public function add_network($network_select,$user,$IS_para_id)
	{
	
		$sql = "INSERT INTO `tbl_sys_user_network_grant`(
					`user_id`,
					`network_id`,
					`status`,		
					`create_user`,		
					`create_datetime`
					) VALUES (
					'$IS_para_id',
					'$network_select',
					'1',
					'$user',
					now())";
			//echo '<br>'.$sql; // Debug used		
			//exit;
		$last_insert_id = $this->runSQLReturnID($sql);			


		return $IS_para_id;
	}	
	
  public function updatePVTnetworkstatus($policy_grant_id,$policy_grant_status)
	{

		$status = $policy_grant_status;
	 

		if($status == 1){
		$changestatus = 0;
		}
		if($status == 0){
		$changestatus = 1;
		}
		$sUserID = $_SESSION["sUserID"];
		
		$sql ="UPDATE  `tbl_sys_user_network_grant` 
		SET status = '$changestatus',
		modify_user = '$sUserID',
		modify_datetime = NOW()		
		WHERE irow_id ='$policy_grant_id'";
	    //echo '<br>'.$sql; 
		$void = $this->runSQLReturnID($sql);			


		return true;
	}	

    public function updatePVTpolicystatus($policy_grant_id,$policy_grant_status)
	{

		$status = $policy_grant_status;

	
		if($status == 1){
		$changestatus = 0;
		}
		if($status == 0){
		$changestatus = 1;
		}
		$sUserID = $_SESSION["sUserID"];
		
		$sql ="UPDATE  `tbl_sys_user_policy_grant` 
		SET status = '$changestatus',
		modify_user = '$sUserID',
		modify_datetime = NOW()		
		WHERE irow_id ='$policy_grant_id'";
		
		//echo '<br>'.$sql; 
		$void = $this->runSQLReturnID($sql);			



		return true;
	}		
  
  
  public function user_ava_company($id)
	{
 		$sql ="SELECT * FROM `tbl_sys_company_master`  WHERE status=1 AND comp_id NOT IN	(SELECT comp_id FROM `tbl_sys_user_company_grant`
		 WHERE user_id = '$id' )
		 ORDER BY comp_id ASC";
		//echo '<br>'.$sql.'<br>';
	
		$arr_ava_network = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_ava_network[] = $row;
		endforeach; 	

		
		return $arr_ava_network;
	}
  
  
    public function user_company($id)
	{
 		$sql ="SELECT a.irow_id, b.name_eng , a.status FROM tbl_sys_user_company_grant AS a, tbl_sys_company_master AS b 
		WHERE  a.comp_id = b.comp_id AND a.user_id= '$id'";
		//echo '<br>'.$sql.'<br>';
		$arr_user_network = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_user_network[] = $row;
		endforeach; 	


		return $arr_user_network;
	}		
  
  
	public function add_company($company_select,$user,$IS_para_id)
	{
	
		$sql = "INSERT INTO `tbl_sys_user_company_grant`(
					`user_id`,
					`comp_id`,
					`status`,		
					`create_user`,		
					`create_datetime`
					) VALUES (
					'$IS_para_id',
					'$company_select',
					'1',
					'$user',
					now())";
			//echo '<br>'.$sql; // Debug used		
			//exit;
		
		$last_insert_id = $this->runSQLReturnID($sql);			

		return $IS_para_id;
	}	
  
  
  public function updatePVTcompanystatus($policy_grant_id,$policy_grant_status)
	{

		$status = $policy_grant_status;
	 

		if($status == 1){
		$changestatus = 0;
		}
		if($status == 0){
		$changestatus = 1;
		}
		$sUserID = $_SESSION["sUserID"];
	
		$sql ="UPDATE  `tbl_sys_user_company_grant` 
		SET status = '$changestatus',
		modify_user = '$sUserID',
		modify_datetime = NOW()		
		WHERE irow_id ='$policy_grant_id'";
	    //echo '<br>'.$sql; 
		$void = $this->runSQLReturnID($sql);	


		return true;
	}	

  
  
	public function is_duplicate_field($field_name, $para)
	{
		$para = addslashes($para);
		$sql ="SELECT COUNT(*) AS RecordCount FROM tbl_sys_user ";
		$sql .= "  WHERE ";
		$sql .="  $field_name = '$para'";
		//echo '<br>'.$sql; // Debug used		
		$arr_record = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_record[] = $row;
		endforeach; 

			

		$is_find = false;
		if ($arr_record[0]['RecordCount'] >=1) $is_find = true;
		
		return $is_find;
	}	
  
  
	public function is_duplicate_field_myself($myself_id_para , $field_name, $field_para)
	{
		$myself_id_para = addslashes($myself_id_para);
		$field_name = addslashes($field_name);
		$field_para = addslashes($field_para);
		
		$sql ="SELECT COUNT(*) AS RecordCount FROM tbl_sys_user ";
		$sql .= "  WHERE ";
		$sql .="  $field_name = '$field_para' AND ".$this->primary_keyname. "<>'$myself_id_para' ";
		
		//echo '<br>'.$sql; // Debug used		
		$arr_record = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_record[] = $row;
		endforeach; 
		

		$is_find = false;
		if ($arr_record[0]['RecordCount'] >=1) $is_find = true;
		
		return $is_find;
	}	
  
  
    public function close()
	{
		$this->dbh = null;
	}	
	
}
?>