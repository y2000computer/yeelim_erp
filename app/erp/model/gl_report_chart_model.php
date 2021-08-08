<?php
class gl_report_chart_model  extends dataManager  
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
    	$this->setErrorMsg('GL -> Report -> Chart of Account -> SQL error:');


		$this->primary_keyname = 'chart_id';
		$this->primary_indexname = 'chart_code';
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
		//$json=$json['criteria'];
		$comp_id = $json['criteria']['comp_id'];
	
		$sql = "SELECT C.*, TY.type_name FROM tbl_gl_chart_master AS C  ";
		$sql .= " LEFT JOIN  tbl_gl_chart_type_master AS TY ON C.type_code = TY.type_code  ";
		$sql .= "  WHERE ";
		//$sql .= " comp_id = ". $_SESSION["target_comp_id"] ;
		$sql .= " comp_id = ". $comp_id ;
		$sql .= " AND C.status  =  1 ";
		$sql .= " ORDER  BY C.chart_code ASC ; ";
		
		//echo '<br>'.$sql.'<br>';

		$record = $this->runSQLAssoc($sql);	

		  
		return $record;
	}	
	
   	
	
    public function close()
	{
		$this->dbh = null;
	}	



}
?>