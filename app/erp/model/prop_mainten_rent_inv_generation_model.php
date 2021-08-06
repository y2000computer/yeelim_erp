<?php
class prop_mainten_rent_inv_generation_model  
{
	private $dbh;
	private $primary_table;
	private $primary_keyname;
	private $primary_indexname;
	
	public function __construct()
    {
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
		
		$build_id= $json['criteria']['build_id'];

		$inv_date_ymd = toYMD($json['criteria']['inv_date']);
		$time = strtotime($inv_date_ymd);
		$period_date_from_ymd = $inv_date_ymd;
		$time_next_month = strtotime("+1 month", $time) ;
		$time_lastday  = strtotime("-1 day", $time_next_month) ;
		$period_date_to_ymd = date("Y-m-d", $time_lastday);

		$create_user = $_SESSION['sUserID'];

		//start generate invoice

		//retreive all active tenant info and rent_amount >0
		$sql = "SELECT C.*, B.eng_name AS 'build_eng_name' FROM tbl_prop_tenant_info AS C ";
		$sql .= " LEFT JOIN  tbl_prop_build_master AS B ON C.build_id = B.build_id  ";
		$sql .= " WHERE C.build_id = " .$json['criteria']['build_id']  ;
		$sql .= " AND C.rent_amount > 0 " ;
		$sql .= " AND C.status = 1 " ;
		$sql .= " ORDER BY C.tenant_id ;" ;
		//echo "<br>sql:".$sql."<br>";
		

		$tenant_records = array();
		
		try {
			$rows = $this->dbh->query($sql);
			while($row = $rows->fetch(PDO::FETCH_ASSOC)){
			  $tenant_records[] = $row;
			 }
			} catch (PDOException $e) {
				print 'Error!: ' . $e->getMessage();
				die();
		  }				
		  
		foreach ($tenant_records as $tenant_record): 

			$codel_prefix	='RV';

			//Generate prefix
			$YY =substr($inv_date_ymd,2,2);
			$prefix_YY = $codel_prefix.$YY;
			//echo '<br>prefix_YY ='.$prefix_YY.'<br>'	;
			$sql = "SELECT MAX(inv_code) as max  FROM tbl_prop_rent_inv WHERE
						build_id=".$build_id." and left(inv_code,4)='".$prefix_YY."'";
			//echo '<br>'.$sql.'<br>';
			$prefix_max ='';
			try {
				$rows = $this->dbh->query($sql);
				while($now= $rows->fetch(PDO::FETCH_ASSOC)){				  
					$prefix_max = $now['max'];
					}
				} catch (PDOException $e) {		
					print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
					die();
					}
	
			//echo '<br>prefix_max ='.$prefix_max.'<br>'	;
			
			if($prefix_max ==null )	{
				$prefix_max_no = 0;	  
			} else {
				$prefix_max_no = substr($prefix_max, 4, 5); 
			}
			
			$prefix_max_no = $prefix_max_no+1;
			//echo 'prefix_max_no ='.$prefix_max_no.'<br>'	;
			$inv_code =$prefix_YY.str_pad($prefix_max_no,5,0,STR_PAD_LEFT);
			//echo 'payment_code ='.$payment_code.'<br>'	;
			
			//<end>Generate prefix
	
				
			$this->dbh->beginTransaction();
		
			$tenant_id = $tenant_record["tenant_id"];
			$eng_name = addslashes($tenant_record["eng_name"]);
			$add_1 = addslashes($tenant_record["add_1"]);
			$add_2 = addslashes($tenant_record["add_2"]);
			$add_3 = addslashes($tenant_record["add_3"]);
			$ref_no = addslashes($tenant_record["ref_no"]);
			$shop_no = addslashes($tenant_record["shop_no"]);
			$amount = addslashes($tenant_record["rent_amount"]);

			$sql = "INSERT INTO `tbl_prop_rent_inv`(
							`build_id`
							,`tenant_id`
							,`inv_code`
							,`inv_date`
							,`eng_name`
							,`add_1`
							,`add_2`
							,`add_3`
							,`ref_no`
							,`shop_no`
							,`period_date_from`
							,`period_date_to`
							,`amount`
							,`balance`
							,`print_is`
							,`status`
							,`create_user`
							,`modify_user`
							,`create_datetime`
							,`modify_datetime`
							) VALUES (
								'$build_id'
								,'$tenant_id'
								,'$inv_code'
								,'$inv_date_ymd'
								,'$eng_name'
								,'$add_1'
								,'$add_2'
								,'$add_3'
								,'$ref_no'
								,'$shop_no'
								,'$period_date_from_ymd'
								,'$period_date_to_ymd'
								,'$amount'
								,'$amount'
								,'0'
								,'1'
								,'$create_user'
								,'$create_user'
								,now()
								,now()
								)";
	
			//echo '<br>'.$sql.'<br>';		
									
			try {
				$rows = $this->dbh->query($sql);
				//$last_insert_id = $this->dbh->lastInsertId(); 
				} catch (PDOException $e) {		
					print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
					die();
					}		
			
	
			//update tenant info
			$sql ='UPDATE  `tbl_prop_tenant_info` SET ';
			$sql.=' `rent_date`='.'\''.$inv_date_ymd.'\'';
			$sql.=' WHERE ';
			$sql.='`'.'tenant_id'. '`='.'\''.addslashes($tenant_id).'\''.' ';
			//echo '<br>'.$sql; // Debug used				
		
			try {
				$rows = $this->dbh->query($sql);
				} catch (PDOException $e) {		
					print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
					die();
					}	
	
				
			


			$this->dbh->commit();



		endforeach;		  
		  
		  
		return true;
	}	
	
  

	
    public function prop_build_master_viewall($comp_id)
	{
		$sql ="SELECT * FROM tbl_prop_build_master ";
		$sql .= " WHERE ";
		$sql .= " comp_id = ". $comp_id;
		$sql .= " ORDER BY build_id ASC; ";
		
		//echo '<br>'.$sql; // Debug used		
		
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