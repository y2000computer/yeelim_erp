<?php
class prop_report_rent_overdue_model   extends dataManager           
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
     	$this->setErrorMsg('PROP -> Report -> Rent Overdue Report -> SQL error:');
	

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
	
	
   public function generate($jsondata)
	{

		$json = json_decode($jsondata, true);
		
		$sql_filter = "";

		if($json['criteria']['build_id']<>"") {
			$sql_filter .= " INV.build_id = '".addslashes($json['criteria']['build_id'])."'" ;
		}	
		

		if($json['criteria']['tenant_code']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " C.tenant_code LIKE '%".addslashes(trim($json['criteria']['tenant_code']))."%'" ;
		}		

		
		if($json['criteria']['inv_code_from']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " INV.inv_code BETWEEN '". $json['criteria']['inv_code_from']."' AND '". $json['criteria']['inv_code_to']."'" ;
		}
		

		if($json['criteria']['inv_date_from']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " date(INV.inv_date) BETWEEN '". toYMD($json['criteria']['inv_date_from'])."' AND '". toYMD($json['criteria']['inv_date_to'])."'" ;
		}			

		if(!empty($sql_filter)) $sql_filter.=" AND ";
		$sql_filter .= " INV.status = 1 AND INV.balance <> 0 " ;		

		$sql = "SELECT INV.*, C.tenant_code, B.eng_name AS 'build_eng_name' FROM tbl_prop_rent_inv AS INV ";
		$sql .= "  LEFT JOIN  tbl_prop_tenant_info AS C ON INV.tenant_id = C.tenant_id  ";
		$sql .= "  LEFT JOIN  tbl_prop_build_master AS B ON INV.build_id = B.build_id  ";
		$sql .= "  WHERE ";
		$sql .= " (1) " ;
		if(!empty($sql_filter)) $sql .= " AND  ".$sql_filter ;
		$sql .= " ORDER  BY C.tenant_code, INV.inv_date ASC ; ";
		//echo "<br>sql:".$sql."<br>";
		
		$record = $this->runSQLAssoc($sql);	

		return $record;
	}	
	
  
    public function prop_build_master_viewall($comp_id)
	{
		$sql ="SELECT * FROM tbl_prop_build_master ";
		$sql .= " WHERE ";
		$sql .= " comp_id = ". $comp_id;
		$sql .= " ORDER BY build_id ASC; ";
		
		//echo '<br>'.$sql; // Debug used		
		$record = $this->runSQLAssoc($sql);	

		return $record;
	}	
	
	//
    public function prop_build_master_select($primary_id)
	{
 		$sql ="SELECT * FROM tbl_prop_build_master WHERE "." build_id ". " = '$primary_id'";
		//echo "<br>sql:".$sql."<br>";
		$arr_record = $this->runSQLAssoc($sql);	
				
		return $arr_record[0];
	}	
	
    public function close()
	{
		$this->dbh = null;
	}	



}
?>