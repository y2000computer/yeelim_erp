<?php
class gl_report_trial_balance_model extends dataManager      
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
    	$this->setErrorMsg('GL -> Report -> Trial Balance -> SQL error:');

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

		$sql = " SELECT C.chart_id, C.chart_code, C.chart_name, TY.type_name, C.brought_forward  ";
		$sql .= " FROM  tbl_gl_chart_master AS C  ";
		$sql .= " LEFT JOIN  tbl_gl_chart_type_master AS TY ON C.type_code = TY.type_code  ";
		$sql .= "  WHERE ";
		//$sql .= " C .comp_id = ". $_SESSION["target_comp_id"] ;
		$sql .= " C .comp_id = ". $comp_id ;
		$sql .= " AND C.status  =  1 ";
		$sql .= " ORDER  BY C.chart_code ASC ; ";
		
		//echo '<br>'.$sql.'<br>';

		$record = $this->runSQLAssoc($sql);	
		  
		return $record;
	}	
	
   	
	
	public function get_current_period_balance($chart_id, $criteria)
	{

		$sql = " SELECT SUM(JD.amount) AS current_period_balance ";
		$sql .= " FROM  tbl_gl_journal_entry AS J    ";
		$sql .= " LEFT JOIN  tbl_gl_journal_entry_detail AS JD ON J.journal_id = JD.journal_id  ";
		$sql .= "  WHERE ";
		//$sql .= " J.comp_id = ". $_SESSION["target_comp_id"] ;
		$sql .= " J.comp_id = ". $criteria['comp_id'] ;
		$sql .= " AND J.posting_is  =  1 ";
		$sql .= " AND J.status  =  1 ";
		$sql .= " AND J.year_end_is  =  0 ";
		$sql .= " AND JD.chart_id  = '". $chart_id. "'" ;
		//$sql .= " AND  date(J.journal_date) BETWEEN '". toYMD($journal_date_from_dmy)."' AND '". toYMD($journal_date_to_dmy)."'" ;
		$sql .= " AND  date(J.journal_date) BETWEEN '". toYMD($criteria['journal_date_from'])."' AND '". toYMD($criteria['journal_date_to'])."'" ;
		
		//echo '<br>'.$sql.'<br>';

		$record = $this->runSQLAssoc($sql);	

		$current_period_balance =0;
		if($record[0]['current_period_balance']<>null) $current_period_balance = $record[0]['current_period_balance'];
		
		return $current_period_balance;
	}		
	
	public function get_previous_balance($chart_id, $criteria)
	{

		//$journal_date_from_dmy, $journal_date_to_dmy, $comp_id
		
		$sql = " SELECT SUM(JD.amount) AS balance ";
		$sql .= " FROM  tbl_gl_journal_entry AS J    ";
		$sql .= " LEFT JOIN  tbl_gl_journal_entry_detail AS JD ON J.journal_id = JD.journal_id  ";
		$sql .= "  WHERE ";
		//$sql .= " J.comp_id = ". $_SESSION["target_comp_id"] ;
		$sql .= " J.comp_id = ". $criteria['comp_id'] ;
		$sql .= " AND J.posting_is  =  1 ";
		$sql .= " AND J.status  =  1 ";
		$sql .= " AND J.year_end_is  =  0 ";
		$sql .= " AND JD.chart_id  = '". $chart_id. "'" ;
		//$sql .= " AND  date(J.journal_date) < '". toYMD($journal_date_from_dmy)."'" ;
		$sql .= " AND  date(J.journal_date) < '". toYMD($criteria['journal_date_from'])."'" ;
		
		//echo '<br>'.$sql.'<br>';

		$record = $this->runSQLAssoc($sql);	

		$balance =0;
		if($record[0]['balance']<>null) $balance = $record[0]['balance'];
		
		return $balance;
	}		
	
    public function close()
	{
		$this->dbh = null;
	}	



}
?>