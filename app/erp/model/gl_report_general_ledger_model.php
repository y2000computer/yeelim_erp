<?php
class gl_report_general_ledger_model extends dataManager    
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
	   	$this->setErrorMsg('GL -> Report -> General ledger -> SQL error:');

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
		$comp_id = $json['criteria']['comp_id'];
		
		$sql_filter = "";

		if($json['criteria']['chart_code_from']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " C.chart_code BETWEEN '". $json['criteria']['chart_code_from']."' AND '". $json['criteria']['chart_code_to']."'" ;
		}			


		$sql = " SELECT C.chart_id, C.chart_code, C.chart_name, C.brought_forward , TY.type_name ";
		$sql .= " FROM tbl_gl_chart_master AS C  ";
		$sql .= " LEFT JOIN  tbl_gl_chart_type_master AS TY ON C.type_code = TY.type_code  ";
		$sql .= "  WHERE ";
		$sql .= " C.comp_id = ". $comp_id ;
		if(!empty($sql_filter)) $sql .= " AND  ".$sql_filter ;
		$sql .= " ORDER  BY C.chart_code  ASC ; ";
		
		//echo '<br>'.$sql.'<br>';


		$record = $this->runSQLAssoc($sql);	
 		  
		  
		return $record;
	}	
	
   	
	
	public function current_trans($jsondata)
	{

		$json = json_decode($jsondata, true);
		$comp_id = $json['criteria']['comp_id'];
		
		$sql_filter = "";

		if($json['criteria']['chart_code_from']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " C.chart_code BETWEEN '". $json['criteria']['chart_code_from']."' AND '". $json['criteria']['chart_code_to']."'" ;
		}			

		
		if($json['criteria']['journal_date_from']<>"") {
			if(!empty($sql_filter)) $sql_filter.=" AND ";
			$sql_filter .= " date(J.journal_date) BETWEEN '". toYMD($json['criteria']['journal_date_from'])."' AND '". toYMD($json['criteria']['journal_date_to'])."'" ;
		}			

		$sql = " SELECT  C.chart_id, C.chart_code, C.chart_name, TY.type_name, J.journal_date, J.journal_code, JD.*  ";
		$sql .= " FROM  tbl_gl_journal_entry AS J    ";
		$sql .= " LEFT JOIN  tbl_gl_journal_entry_detail AS JD ON J.journal_id = JD.journal_id  ";
		$sql .= " LEFT JOIN  tbl_gl_chart_master AS C ON JD.chart_id = C.chart_id  ";
		$sql .= " LEFT JOIN  tbl_gl_chart_type_master AS TY ON C.type_code = TY.type_code  ";
		$sql .= "  WHERE ";
		$sql .= " J.comp_id = ". $comp_id ;
		$sql .= " AND J.posting_is  =  1 ";
		$sql .= " AND J.status  =  1 ";
		if(!empty($sql_filter)) $sql .= " AND  ".$sql_filter ;
		$sql .= " ORDER  BY C.chart_code, J.journal_date, JD.irow_id  ASC ; ";
		
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