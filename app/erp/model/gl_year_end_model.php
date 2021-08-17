<?php
class gl_year_end_model extends dataManager        
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
    	$this->setErrorMsg('GL -> Maintenance -> Year End -> SQL error:');

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
	
	
   public function charts_type($type_code, $jsondata)
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
		$sql .= " AND TY.type_code   =  '".$type_code . "'";
		$sql .= " ORDER  BY C.chart_code ASC ; ";
		
		//echo '<br>'.$sql.'<br>';

		$record = $this->runSQLAssoc($sql);	

		$record = array();
		
		  
		return $record;
	}	
	
	
	public function chart_brought_forward_update($chart_id, $brought_forward)
	{
		$modify_user = $_SESSION['sUserID'];

	
		$sql ='UPDATE  `tbl_gl_chart_master` SET ';
		$sql.='`brought_forward`= '. $brought_forward  ;
		$sql.=' , ';
		$sql.='`balance`='. $brought_forward ;
		$sql.=' WHERE ';
		$sql.='`'.'chart_id'. '`='.'\''.addslashes($chart_id).'\''.' ';
		//echo '<br>'.$sql; // Debug used				
	
		$void = $this->runSQLReturnID($sql);
		
		return true;
	}	
	

	public function journal_entry_marked_year_end($journal_date_from_dmy, $journal_date_to_dmy)
	{
		
		$sql ='UPDATE  `tbl_gl_journal_entry` SET ';
		$sql .=' `year_end_is`= 1 ';
		$sql .=' WHERE ';
		$sql .= " comp_id = ". $_SESSION["target_comp_id"] ;
		$sql .= " AND  date(journal_date) BETWEEN '". toYMD($journal_date_from_dmy)."' AND '". toYMD($journal_date_to_dmy)."'" ;
		//echo '<br>'.$sql; // Debug used				

		$void = $this->runSQLReturnID($sql);
	
				
		return true;
	}		
	
	

	public function is_previous_journal_unpost_found($form)
	{
		
		$comp_id = $form['comp_id'];

		$sql_filter = "";
		

		//echo "<br>sql_filter:".$sql_filter."<br>";
		
		$sql ="SELECT COUNT(*) AS RecordCount FROM tbl_gl_journal_entry AS J ";
		$sql .= "  WHERE ";
		$sql .= " J.comp_id = ". $comp_id ;
		$sql .= " AND ";
		$sql .= " date(J.journal_date) < '". toYMD($form['journal_date_from'])."'";
		$sql .= " AND ";
		$sql .= " J.posting_is = 1 ";
		$sql .= " AND ";
		$sql .= " J.year_end_is <> 1 ";
		$sql .= " AND ";
		$sql .= " J.status = 1 ";
		//echo '<br>'.$sql; // Debug used		
		
		$arr_record = $this->runSQLAssoc($sql);	

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