<?php
class sys_log_model
{
	private $dbh;
	
	public function __construct()
    {
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
		if($json['log']['username']<>"") {
			$sql_filter .= " username LIKE '%".addslashes($json['log']['username'])."%'" ;
		}
		if($json['log']['source_ip']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " source_ip LIKE '%".addslashes($json['log']['source_ip'])."%'" ;
		}
                                                
		
		//echo "<br>sql_filter:".$sql_filter."<br>";
		
		$sql = "SELECT id FROM tbl_sys_log_login ";
		if(!empty($sql_filter)) $sql .= "WHERE ".$sql_filter ;
		$sql .= " ORDER BY id DESC LIMIT 500 ";
		
		//echo "<br>sql:".$sql."<br>";

		try {
			$rs = $this->dbh->query($sql);
			while($row = $rs->fetch(PDO::FETCH_ASSOC)){
				$sql_search_result_id[] = "'". addslashes($row['id']) ."'";
				}
			} catch (PDOException $e){
					print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
					die();
				}		
	
	$array_count = count($sql_search_result_id);


	if ($array_count > 0){	 

		$result_id = implode(",", $sql_search_result_id);

		/*	echo "<br>result_id:".$result_id."<br>";*/
	}

		//Save result_id into paging control table 
		//$lot_id = strtotime(date("Y-m-d H:i:s"));
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
		
		$sql ="SELECT * FROM tbl_sys_log_login ";
		if(!empty($record_id_set)) $sql .= "WHERE id in (".$record_id_set.")" ;
		$sql .= " ORDER BY id DESC ";
		$sql .= " LIMIT ". SYSTEM_PAGE_ROW_LIMIT . " OFFSET  ".($page-1)*SYSTEM_PAGE_ROW_LIMIT ;
		
	
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
					print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
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
 		$sql ="SELECT * FROM tbl_sys_log_login WHERE id = '$id'";
				
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
	
    public function close()
	{
		$this->dbh = null;
	}	
	
}
?>