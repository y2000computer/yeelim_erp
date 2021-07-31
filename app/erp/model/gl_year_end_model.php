<?php
class gl_year_end_model  
{
	private $dbh;
	private $primary_table;
	private $primary_keyname;
	private $primary_indexname;
	
	public function __construct()
    {
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
		
		$sql_filter = "";

		$sql = " SELECT C.chart_id, C.chart_code, C.chart_name, TY.type_name, C.brought_forward  ";
		$sql .= " FROM  tbl_gl_chart_master AS C  ";
		$sql .= " LEFT JOIN  tbl_gl_chart_type_master AS TY ON C.type_code = TY.type_code  ";
		$sql .= "  WHERE ";
		$sql .= " C .comp_id = ". $_SESSION["target_comp_id"] ;
		$sql .= " AND C.status  =  1 ";
		$sql .= " AND TY.type_code   =  '".$type_code . "'";
		$sql .= " ORDER  BY C.chart_code ASC ; ";
		
		//echo '<br>'.$sql.'<br>';


		$record = array();
		
		try {
			$rows = $this->dbh->query($sql);
			while($row = $rows->fetch(PDO::FETCH_ASSOC)){
			  $record[] = $row;
			 }
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage();
				die();
		  }				
		  
		  
		  
		  
		return $record;
	}	
	
	
	public function chart_brought_forward_update($chart_id, $brought_forward)
	{
		$modify_user = $_SESSION['sUserID'];

		$this->dbh->beginTransaction();
	
		$sql ='UPDATE  `tbl_gl_chart_master` SET ';
		$sql.='`brought_forward`= '. $brought_forward  ;
		$sql.=' , ';
		$sql.='`balance`='. $brought_forward ;
		$sql.=' WHERE ';
		$sql.='`'.'chart_id'. '`='.'\''.addslashes($chart_id).'\''.' ';
		//echo '<br>'.$sql; // Debug used				
	
		try {
			$rows = $this->dbh->query($sql);
			} catch (PDOException $e) {		
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}		
		
		$this->dbh->commit();
		
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


		try {
			$rows = $this->dbh->query($sql);
			} catch (PDOException $e) {		
				print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
				die();
				}	
				
				
		return true;
	}		
	
	
	
    public function close()
	{
		$this->dbh = null;
	}	



}
?>