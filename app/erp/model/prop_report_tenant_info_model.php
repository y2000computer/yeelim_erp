<?php
class prop_report_tenant_info_model  extends dataManager    
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
     	$this->setErrorMsg('PROP -> Report -> Tenant Information -> SQL error:');

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
		$json=$json['criteria'];
		$build_id = $json['build_id'];
	
		$sql = "SELECT C.*, B.eng_name AS 'build_eng_name' FROM tbl_prop_tenant_info AS C ";
		$sql .= "  LEFT JOIN  tbl_prop_build_master AS B ON C.build_id = B.build_id  ";
		$sql .= "  WHERE ";
		$sql .= " C.build_id = ". $build_id ;
		$sql .= " AND C.status  =  1 ";
		$sql .= " ORDER  BY C.tenant_code ASC ; ";
		
		//echo '<br>'.$sql.'<br>';

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