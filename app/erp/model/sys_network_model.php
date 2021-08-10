<?php
class sys_network_model extends dataManager
{
	private $dbh;
	
	private $table_field;  // variable for dataManager
	private $errorMsg;   // variable for dataManager
	private $mainTable;   // variable for dataManager


	public function __construct()
    {

		parent::__construct();
		$this->setErrorMsg('System -> Transaction -> Network Information -> SQL error:');

		try {
			$this->dbh = new PDO(DB_CONNECTION_STRING,DB_USERNAME,DB_PASSWORD);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->dbh->query("set names utf8");
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
			}
	}
	
   public function search($jsondata)
	{
		$json = json_decode($jsondata, true);
	
		$sql_filter = "";
		if($json['network']['eng_name']<>"") {
			//echo "json['network']['eng_name']:".$json['network']['eng_name']."<br>";
			$sql_filter .= " eng_name LIKE '%".addslashes($json['network']['eng_name'])."%'" ;
		}
		if($json['network']['fixed_ip']<>"") {
			//echo "json['network']['fixed_ip']:".$json['network']['fixed_ip']."<br>";
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " network LIKE '%".addslashes($json['network']['fixed_ip'])."%'" ;
		}
		if($json['network']['ip_range_from']<>"") {
			//echo "json['network']['ip_range_from']:".$json['network']['ip_range_from']."<br>";
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " ip_range_from LIKE '%".addslashes($json['network']['ip_range_from'])."%'" ;
		}

		//echo "<br>sql_filter:".$sql_filter."<br>";
		
		$sql = "SELECT network_id FROM tbl_sys_network ";
		if(!empty($sql_filter)) $sql .= "WHERE ".$sql_filter ;
		$sql .= " ORDER BY network_id;";
		
		//echo "<br>sql:".$sql."<br>";
		$sql_search_result_id =array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$sql_search_result_id[] = "'". addslashes($row['network_id']) ."'";
		endforeach; 	

		  
	$array_count = count($sql_search_result_id);

	if ($array_count > 0){	  
		$result_id = implode(",", $sql_search_result_id);
	}
		//Save result_id into paging control table 
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


		$sql = "SELECT * FROM tbl_sys_network ";
		if(!empty($record_id_set)) $sql .= "WHERE network_id in (".$record_id_set.")" ;
		$sql .= " ORDER BY network_id ";
		$sql .= " LIMIT ". SYSTEM_PAGE_ROW_LIMIT . " OFFSET  ".($page-1)*SYSTEM_PAGE_ROW_LIMIT ;
		
		//echo "<br>sql:".$sql."<br>";
		$record = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$record[] = $row;
		endforeach; 	

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

		//$this->dbh->beginTransaction();

		$sql ="UPDATE `tbl_sys_paging_control` SET modify_datetime =now()
		WHERE lot_id ='$lot_id'";
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
 		$sql ="SELECT * FROM tbl_sys_network WHERE network_id = '$id'";
		$record = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$record[] = $row;
		endforeach; 	
	 
	
		
		return $record;
	}		
	
 
	public function create($network_arr,$sUserID)
		{
		$user_id = $_SESSION["sUserID"];
		$eng_name = $network_arr['eng_name'];
		$net_type = $network_arr['net_type'];
		$fixed_ip = $network_arr['fixed_ip'];
		$ip_range_from = $network_arr['ip_range_from'];
		$ip_range_to = $network_arr['ip_range_to'];
		$network_mask = $network_arr['network_mask'];
		$status = $network_arr['status'];
		

		//$this->dbh->beginTransaction();

		$eng_name = addslashes($eng_name);
		$sql = "INSERT INTO `tbl_sys_network`(
						`eng_name`,
						`net_type`,
						`fixed_ip`,
						`ip_range_from`,
						`ip_range_to`,
						`network_mask`,
						`status`,
						`create_user`,		
						`create_datetime`,
						`last_modify_user`,		
						`last_modify_datetime`
						) VALUES (
							'$eng_name',
							'$net_type',
							'$fixed_ip',
							'$ip_range_from',
							'$ip_range_to',
							'$network_mask',						
							'$status',
							'$user_id',
							now(),
							'$user_id',
							now())";

			//echo '<br>'.$query.'<br>';
			$last_insert_id = $this->runSQLReturnID($sql);

			
			return $last_insert_id;
	}
	
	
	public function update($network_arr,$sUserID,$id)
	{
		//$this->dbh->beginTransaction();

		$sql ='UPDATE  `tbl_sys_network` SET ';
		$sql.='`eng_name`='.'\''.addslashes($network_arr['eng_name']).'\''.',';
		$sql.='`net_type`='.'\''.addslashes($network_arr['net_type']).'\''.',';
		$sql.='`fixed_ip`='.'\''.addslashes($network_arr['fixed_ip']).'\''.',';
		$sql.='`ip_range_from`='.'\''.addslashes($network_arr['ip_range_from']).'\''.',';
		$sql.='`ip_range_to`='.'\''.addslashes($network_arr['ip_range_to']).'\''.',';
		$sql.='`network_mask`='.'\''.addslashes($network_arr['network_mask']).'\''.',';		
		$sql.='`status`='.'\''.addslashes($network_arr['status']).'\''.',';
		$sql.='`last_modify_datetime`=NOW()'.',';
		$sql.='`last_modify_user`='.'\''.addslashes($sUserID).'\''.' ';
		$sql.=' WHERE ';
		$sql.='`network_id`='.'\''.addslashes($id).'\''.' ';
		//echo '<br>'.$sql; // Debug used	
		$void = $this->runSQLReturnID($sql);
		
		
		return true;
	}	
	
	

    public function close()
	{
		$this->dbh = null;
	}	
	
}
?>