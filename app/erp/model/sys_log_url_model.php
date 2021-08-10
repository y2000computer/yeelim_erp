<?php

class sys_log_url_model extends dataManager
{
	private $dbh;
	
	private $table_field;  // variable for dataManager
	private $errorMsg;   // variable for dataManager
	private $mainTable;   // variable for dataManager


	public function __construct()
    {
		parent::__construct();
		$this->setErrorMsg('SYS -> Security -> Log url -> SQL error:');

		try {
			$this->dbh = new PDO(DB_CONNECTION_STRING,DB_USERNAME,DB_PASSWORD);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->dbh->query("set names utf8");
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
			}
	}

	
   public function url_log($sUserID, $url, $browser_type, $source_ip, $session_id, $time)
	{
	
		$sUserID = addslashes($sUserID);
		$url = addslashes($url);
		$browser_type = addslashes($browser_type);
		$source_ip = addslashes($source_ip);
		$session_id = addslashes($session_id);
		$time = addslashes($time);
		
	
		$sql = 'INSERT INTO tbl_sys_log_url (
					url,
					source_browser,
					source_ip,
					log_datetime
					) VALUES ( ';
		$sql .= '"'.$url.'"'.',';
		$sql .= '"'.$browser_type.'"'.',';
		$sql .= '"'.$source_ip.'"'.',';
		$sql .= '"'.$time.'"'.');';
		//echo $sql;
		$void = $this->runSQLReturnID($sql);	

		
		return true;
	}	
		
    public function close()
	{
		$this->dbh = null;
	}

}
?>