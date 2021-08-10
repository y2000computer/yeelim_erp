<?php
class sys_log_login_model extends dataManager
{
	private $dbh;
	
	private $table_field;  // variable for dataManager
	private $errorMsg;   // variable for dataManager
	private $mainTable;   // variable for dataManager
	
	public function __construct()
    {

		try {
			
			parent::__construct();
			$this->setErrorMsg('SYS -> Security -> Login -> SQL error:');
	
			$this->dbh = new PDO(DB_CONNECTION_STRING,DB_USERNAME,DB_PASSWORD);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->dbh->query("set names utf8");
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
			}

	}

    public function login_newset()
	{
		$security = array();
		$security['sUserID'] ='admin';
		$security['sPassword'] ='password';
		return $security;
	}
	
    public function hasSecurityUserID($sUserID)
	{
	
		$_SESSION["sUserID"] = $sUserID;
		$sUserID = addslashes($sUserID);

		
		$hasFind = false;
		$iRecordCount = 0;
		
		$sql ='SELECT COUNT(*) AS RecordCount FROM tbl_sys_user
					WHERE email=\''.$sUserID.'\'';
		//echo '<br>'.$sql.'<br>';
		$arr_security_item = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_security_item[] = $row;
		endforeach; 	

		$security_item  = $arr_security_item[0];
		
		if($security_item['RecordCount'] == 1) $hasFind = true;	 		
		if($security_item['RecordCount'] == 0) $hasFind = false;

		return $hasFind;
	}

    public function hasSecurityCheckLogin($sUserID,$sPassword)
	{
		$hasFind = false;
		$iRecordCount = 0;
		$sUserID = addslashes($sUserID);
		$sPassword = addslashes($sPassword);
		
 		$sql ="SELECT COUNT(*) AS RecordCount, last_visit_date, concat(last_name,' ',last_name) as eng_name ,email
		FROM tbl_sys_user WHERE email='$sUserID' AND  Password='$sPassword' ";
		//echo '<br>'.$sql.'<br>';
		$arr_security_item = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_security_item[] = $row;
		endforeach; 	


		$security_item  = $arr_security_item[0];
		$last_visit_date  = $security_item[1];

		$_SESSION["last_visit_date"] = $security_item['last_visit_date'];
		$_SESSION["eng_name"] = $security_item['eng_name'];
		$_SESSION["chn_name"] = "";
		$_SESSION["email"] = $security_item['email'];
		$arr_company = $this->default_company_select($sUserID );
		foreach ($arr_company as $company): 
		endforeach;		
		$_SESSION["target_comp_id"] = $company['comp_id'];
		$_SESSION["target_comp_name"] = $company['name_eng'];
		
		if($security_item['RecordCount'] == 1) $hasFind = true;	 
		if($security_item['RecordCount'] == 0) $hasFind = false;	 
	
		return $hasFind;
	}

    public function isSecurityCheckUserBlock($sUserID)
	{
		$isBlock = false;
		$sUserID = addslashes($sUserID);
		
 		$sql ='SELECT status AS status FROM tbl_sys_user 
					WHERE email=\''.$sUserID.'\'';
		//echo '<br>'.$sql.'<br>';
		$arr_security_item = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_security_item[] = $row;
		endforeach; 	


		$security_item  = $arr_security_item[0];
		
		if($security_item['status'] == 1) $isBlock = false;	 
		if($security_item['status'] == 0) $isBlock = true;	 
		
		return $isBlock;
	}
	
	
	public function faillogincounter($sUserID, $time)
	{
	
		$fromtime = strtotime("-1 minutes", strtotime($time));
		$fromtime = date('Y-m-d H:i:s', $fromtime);
		$totime = date('Y-m-d H:i:s', strtotime($time));

 		$sql ="SELECT count(*) as counter FROM tbl_sys_log_login 
					WHERE inputted_email='$sUserID' AND log_datetime BETWEEN '$fromtime' AND '$totime'";
		//echo $sql;
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$counter = $row["counter"];
		endforeach; 	

		if ($counter > 10){
			$sql ="UPDATE tbl_sys_user SET status = 0 where email = '$sUserID'";
			//echo $sql;
			$void = $this->runSQLReturnID($sql);			
			//$rows = $this->dbh->query($sql);	
			return true;
		} 		


		return true;
	}	
	
   public function updateLastVisitDate($security)
	{
		$now = date("Y-m-d H:i:s");
		
		$sql ='UPDATE  `tbl_sys_user` SET ';
		$sql.='`last_visit_date`='.'\''.addslashes($now).'\''.' ';		
		$sql.=' WHERE ';
		$sql.='`email`='.'\''.addslashes($security['sUserID']).'\''.' ';

		$void = $this->runSQLReturnID($sql);			

	
		return true;
	}

   public function writefailreason($sUserID, $sPassword, $reason, $source_ip, $browser_type, $url, $time)
	{
		$sUserID = addslashes($sUserID);
		$sPassword = addslashes($sPassword);
		$reason = addslashes($reason);
		$source_ip = addslashes($source_ip);
		$browser_type = addslashes($browser_type);
		$url = addslashes($url);
		$time = addslashes($time);
	
	
		$sql = 'INSERT INTO tbl_sys_log_login (
					inputted_email,
					auth_status,
					fail_reason,
					url,
					source_browser,
					source_ip,
					log_datetime ) VALUES ( ';
		$sql .= '"'.$sUserID.'"'.',';
		$sql .= '"'.'0'.'"'.',';
		$sql .= '"'.$reason.'"'.',';
		$sql .= '"'.$url.'"'.',';
		$sql .= '"'.$browser_type.'"'.',';
		$sql .= '"'.$source_ip.'"'.',';
		$sql .= '"'.$time.'"'.');';
	
		//echo '<br>'.$sql.'<br>';
		$void = $this->runSQLReturnID($sql);			
	
		return true;
	}
	
   public function writesuccess($sUserID, $sPassword, $source_ip, $browser_type, $url, $time)
	{
	
		$sUserID = addslashes($sUserID);
		$sPassword = addslashes($sPassword);
		$source_ip = addslashes($source_ip);
		$browser_type = addslashes($browser_type);
		$url = addslashes($url);
		$time = addslashes($time);
		
	
		$sql = 'INSERT INTO tbl_sys_log_login (
					inputted_email,
					auth_status,
					fail_reason,
					url,
					source_browser,
					source_ip,
					log_datetime ) VALUES ( ';
		$sql .= '"'.$sUserID.'"'.',';
		$sql .= '"'.'1'.'"'.',';
		$sql .= '"'.''.'"'.',';
		$sql .= '"'.$url.'"'.',';
		$sql .= '"'.$browser_type.'"'.',';
		$sql .= '"'.$source_ip.'"'.',';
		$sql .= '"'.$time.'"'.');';
	
		//echo '<br>'.$sql.'<br>';
		$void = $this->runSQLReturnID($sql);			

		return true;
	}
	
   public function security_policy_module($username)
	{
	
		$username = addslashes($username);
		$arr_policy_module = array();
		$arr_module = array();
		$this->dbh->beginTransaction();

		$sql = "SELECT DISTINCT module_code FROM tbl_sys_policy_module a, tbl_sys_policy b 
		WHERE b.policy_id = a.policy_id AND b.status = 1  AND a.status = 1
		AND a.policy_id IN 
		(SELECT policy_id FROM `tbl_sys_user_policy_grant` 
		WHERE status=1 AND user_id IN
		(SELECT user_id FROM `tbl_sys_user` WHERE email = '$username') )";
		
		//echo $sql;


		$arr_policy_module = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_policy_module[] = $row;
		endforeach; 	
		
			$count_arr =  count($arr_policy_module);
			for($x=0; $x<$count_arr; $x++)
				{
					$result = $arr_policy_module[$x];
					$arr_module[] =  $result['module_code'];
				}
			$inside_arr = implode(",",$arr_module);
		 	$_SESSION["policy_module"] = $inside_arr;
	


		return true;
	}	

	
		
	public function network_checking($sUserID, $source_ip)
	{
		$sUserID = addslashes($sUserID);
		$source_ip = addslashes($source_ip);
		$net_check_state = 0 ;

		//if ($source_ip == '127.0.0.1') {
		if (false) {			
			$net_check_state = -1 ;
		} else {
			
			  $sql ="SELECT a.network_id,a.net_type,a.fixed_ip,a.ip_range_from,a.ip_range_to,
						a.network_mask FROM tbl_sys_network a , tbl_sys_user_network_grant b, tbl_sys_user user
						WHERE 
						a.network_id = b.network_id
						AND
						b.user_id = user.user_id 
						AND
						a.status =1 
						AND
						user.email =" . "'" . $sUserID . "'" . " 
						AND
						b.status =1 ;";

			$rs_net = $this->dbh->query($sql);	
			//echo $sql.'<br>';
			
			while($line = $rs_net->fetch(PDO::FETCH_ASSOC))
			{
				$network_info = array_values($line);
				$net_code = $network_info[0];
				$net_type = $network_info[1];
				$network    = $network_info[2];
				$range_from = $network_info[3];
				$range_to = $network_info[4];
				$net_mask = $network_info[5];


				if ($network=='0.0.0.0') $net_check_state = -1;

				if ($net_type =='DEDIC' && $network<>'0.0.0.0' ) {
					$ar_ip = explode(".", $source_ip);
					$ar_network = explode(".", $network);
					$ar_net_mask = explode(".", $net_mask);
					$match = -1 ;
					if ($ar_net_mask[0] =='255') { if ($ar_ip[0] <> $ar_network[0]) $match = 0 ; }
					if ($ar_net_mask[1] =='255') { if ($ar_ip[1] <> $ar_network[1]) $match = 0 ; }
					if ($ar_net_mask[2] =='255') { if ($ar_ip[2] <> $ar_network[2]) $match = 0 ; }
					if ($ar_net_mask[3] =='255') { if ($ar_ip[3] <> $ar_network[3]) $match = 0 ; }
					//echo '<br>source_ip='.$source_ip.'<br>';
					//echo '<br>network='.$network.'<br>';
					if ($match==-1) $net_check_state = -1 ;

				  } //if ($net_type =='DEDIC' && $network<>'0.0.0.0' )

				if ($net_type =='RANGE' && $network<>'0.0.0.0' ) {
					$ar_ip = explode(".", $source_ip);
					$long_ip = ($ar_ip[0] * 16777216) + ($ar_ip[1] * 65536) + ($ar_ip[2] * 256) + $ar_ip[3]  ;
					$ar_network = explode(".", $network);
					$ar_range_from = explode(".", $range_from);
					$long_range_from = ($ar_range_from[0] * 16777216) + ($ar_range_from[1] * 65536) + ($ar_range_from[2] * 256) + $ar_range_from[3]  ;
					$ar_range_to = explode(".", $range_to);
					$long_range_to = ($ar_range_to[0] * 16777216) + ($ar_range_to[1] * 65536) + ($ar_range_to[2] * 256) + $ar_range_to[3]  ;
					$ar_net_mask = explode(".", $net_mask);
					//echo $long_ip . '<br>';
					//echo $long_range_from . '<br>';
					//echo $long_range_to . '<br>';
					$match = -1 ;

					if ($long_ip>=$long_range_from && $long_ip<=$long_range_to ) $net_check_state = -1 ;

				  } //if ($net_type =='RANGE' && $network<>'0.0.0.0' )

			} //while($line = $rs_net->fetch(PDO::FETCH_ASSOC))

		  } //if (false)

	  return $net_check_state ;
	}
				
				
	public function password_update($general,$sUserID)
	{

		$password= addslashes($general['new_password']);

		
		$sql ='UPDATE  tbl_sys_user SET ';
		$sql.='password='.'\''.$password.'\''.',';
		$sql.='modify_user='.'\''.addslashes($sUserID).'\''.',';
		$sql.='modify_datetime'.'='.'now()'.' ';
		$sql.='WHERE ';
		$sql.='email='.'\''.addslashes($sUserID).'\''.' ';
		
		//echo '<br>'.$sql; // Debug used		
		$void = $this->runSQLReturnID($sql);			


		return true;
	}		
	

    public function check_old_password($general, $sUserID)
	{
		$hasFind = false;
		$iRecordCount = 0;
		$sUserID = addslashes($sUserID);
		$sPassword = addslashes($general['old_password']);
		
	
 		$sql ="SELECT last_visit_date, concat(last_name,' ',last_name) as eng_name ,email, depart_code , user_id   
		FROM tbl_sys_user 
		WHERE email='$sUserID' AND  Password='$sPassword' ";
		//echo '<br>'.$sql.'<br>';
		$arr_security_item = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_security_item[] = $row;
		endforeach; 	
	

	$array_count = count($arr_security_item);

	if ($array_count > 0){	  
			$hasFind = true;
			} else {
				
			$hasFind = false;
	}
	
		return $hasFind;
	}
		
	
	public function default_company_select($sUserID)
	{
	
 		$sql ="SELECT b.comp_id, b.name_eng, b.journal_prefix FROM tbl_sys_user_company_grant AS a, tbl_sys_company_master AS b 
					, tbl_sys_user AS c WHERE  a.comp_id = b.comp_id AND a. user_id = c.user_id AND c.email= '$sUserID' ORDER BY default_is DESC LIMIT 1 ";

		//echo '<br>'.$sql.'<br>';
		$arr_rs = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_rs[] = $row;
		endforeach; 	


		return $arr_rs;
	
	}

	public function company_select($sUserID)
	{
	
 		$sql ="SELECT b.comp_id, b.name_eng FROM tbl_sys_user_company_grant AS a, tbl_sys_company_master AS b 
					, tbl_sys_user AS c WHERE  a.comp_id = b.comp_id AND a. user_id = c.user_id AND c.email= '$sUserID' ORDER BY default_is DESC LIMIT 1000 ";

		//echo '<br>'.$sql.'<br>';
		$arr_rs = array();
		$rows = $this->runSQLAssoc($sql);	
		foreach ($rows as $row): 
			$arr_rs[] = $row;
		endforeach; 

		return $arr_rs;
	
	}
		

	
    public function close()
	{
		$this->dbh = null;
	}

}
?>