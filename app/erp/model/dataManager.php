<?php 
class dataManager{
	private $table;
	protected $data;
	private $result;
	private $errorMsg;
	private $lot_id;

	public function __construct(){
		$this->errorMsg='dataManager->Connection error:';

		try {
			$this->data = new PDO(DB_CONNECTION_STRING,DB_USERNAME,DB_PASSWORD);
			$this->data->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->data->query("set names utf8");


		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			$sNewLog = new LoggerManager( 'error_sql', '1' );
			$sNewLog -> add( ('dataManager->Connection error:'.$e->getMessage().'--Statement:'.$query) );
			die();
		}
	}

	public function __destruct(){
		if ($this->data)
			$this->data=null;
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function setTable($table){
		$this->table=$table;
	}

	public function getTableField($table=''){
		$this->loadTableField($table);
		return $this->result;
	}

	public function createInsertSql($input_para,$fieldnametype,$table){
		$this->genInsertSql($input_para,$fieldnametype,$table);
		return $this->result;

	}
	public function createUpdateSql($update_para,$fieldnametype,$table,$idField,$value){
		$this->genUpdateSql($update_para,$fieldnametype,$table,$idField,$value);
		return $this->result;

	}

	public function searchResult($sql,$jsondata,$createUser,$id_field){
		$this->getSearchResultLotId($sql,$jsondata,$createUser,$id_field);
		return $this->lot_id;
	}
	public function searchResultFixedInjection($sql,$bind,$jsondata,$createUser,$id_field){
		$this->getSearchResultLotIdFixedInjection($sql,$bind,$jsondata,$createUser,$id_field);
		return $this->lot_id;
	}
	
	public function retreive_resultId($lot_id,$user){
		$this->getretreive_resultId($lot_id,$user);
		return $this->result;

	}

	public function runSQLAssocFixedInjection($sql,$bind){
		$record = array();	
		try {
				//$rs = $this->data->query($sql);

				$rs=$this->data->prepare($sql);
				
				foreach ($bind as $bindElm) {
					
					$rs->bindValue($bindElm['para'],$bindElm['value']);

				}
				
				$rs->execute();

				while($row = $rs->fetch(PDO::FETCH_ASSOC)){

					$record[] = $row;
				 }

			} catch (PDOException $e){
					print "Error!: " . $e->getMessage() . "<br/>";
					$sNewLog = new LoggerManager( 'error_sql', '1' );
					$sNewLog -> add( ($this->errorMsg.$e->getMessage().'--Statement:'.$query) );
					die();
			  }	
		return $record;
	}

	public function runSQLAssoc($sql, $debug=false){

		if($debug) echo '<br>dataManage:runSQLAssoc() para: sql :'.$sql.'<br>';
		$record = array();	
		try {
				$rs = $this->data->query($sql);
				while($row = $rs->fetch(PDO::FETCH_ASSOC)){
				$record[] = $row;
				 }
			} catch (PDOException $e){
					print "Error!: " . $e->getMessage() . "<br/>";
					$sNewLog = new LoggerManager( 'error_sql', '1' );
					$sNewLog -> add( ($this->errorMsg.$e->getMessage().'--Statement:'.$query) );
					die();
			  }	
		return $record;
	}
	public function runSQLReturnID($sql){
		$this->data->beginTransaction();
			try {
				$rows = $this->data->query($sql);
				$last_insert_id = $this->data->lastInsertId(); 
				
				} catch (PDOException $e) {		
					print "Error!: " . $e->getMessage() . "<br/>";
					$sNewLog = new LoggerManager( 'error_sql', '1' );
					$sNewLog -> add( ($this->errorMsg.$e->getMessage().'--Statement:'.$query) );
					//die();
			  }		
			$this->data->commit();
		return $last_insert_id;
	}



	public function runSQL($sql){
		
			try {
				$rows = $this->data->query($sql);
				//echo '<br>sql:'.$sql.'<br>';
				
				} catch (PDOException $e) {		
					print "Error!: " . $e->getMessage() . "<br/>";
					$sNewLog = new LoggerManager( 'error_sql', '1' );
					$sNewLog -> add( ($this->errorMsg.$e->getMessage().'--Statement:'.$query) );
					//die();
			  }		
			
		return true;
	}

	public function runSQLFixedInjection($sql,$bind){
		$record = array();	
		try {

				$rs=$this->data->prepare($sql);
				
				foreach ($bind as $bindElm) {
					
					$rs->bindValue($bindElm['para'],$bindElm['value']);

				}
				
				$rs->execute();
			} catch (PDOException $e){
					print "Error!: " . $e->getMessage() . "<br/>";
					$sNewLog = new LoggerManager( 'error_sql', '1' );
					$sNewLog -> add( ($this->errorMsg.$e->getMessage().'--Statement:'.$query) );
					die();
			  }	
		return $record;
	}

	public function setErrorMsg($errorMsg){
		$this->errorMsg=$errorMsg;

	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	private function loadTableField($table){
		
		if ($table =='')$table=$this->table;

		try {
			$sql = "SHOW COLUMNS FROM ".$table;
			$result = $this->data->query($sql);
			$result = $result->fetchall(PDO::FETCH_ASSOC);
			$fieldStructure=array();
			foreach ($result as $arrayField){
				if ($startPoint=strpos($arrayField['Type'],"("))
				$fieldStructure[$arrayField['Field']]=substr($arrayField['Type'],0,$startPoint);
				else 
				$fieldStructure[$arrayField['Field']]=$arrayField['Type'];
			}
			$this->result = $fieldStructure;
			//var_dump($fieldStructure);
		} catch (PDOException $e) {
			echo 'dataManager->Connection error:'.$e->getMessage().'--Statement:'.$sql;
		}
	}


	private function getretreive_resultId($lot_id,$user){
		$sql = "SELECT * FROM tbl_sys_paging_control WHERE lot_id = '".$lot_id."' AND create_user =	'".$user."';";
		//echo "<br>sql:".$sql."<br>";
		$record = array();	
		$record=$this->runSQLAssoc($sql);
		$arr =  $record[0];
		
		$this->result = $arr['result_id'];
	}

	private function getSearchResultLotIdFixedInjection($sql,$bind,$jsondata,$createUser,$id_field){
			$sql_search_result_id=array();
			$reRow=$this->runSQLAssocFixedInjection($sql,$bind);
			foreach($reRow as $row){
				
				$sql_search_result_id[]="'". addslashes($row[$id_field]) ."'";
			}
		
			$array_count = count($sql_search_result_id);
				if ($array_count > 0){	 
					$result_id = implode(",", $sql_search_result_id);
			}
					$lot_id = strtotime(date("Y-m-d H:i:s"));

					$this->data->beginTransaction();

					$query = 'INSERT INTO `tbl_sys_paging_control`(
								`searchphrase`,
								`lot_id`,
								`result_id`,
								`create_user`,
								`create_datetime`
								) VALUES (';
					$query.='\''.addslashes($jsondata).'\''.',';
					$query.='\''.addslashes($lot_id).'\''.',';
					$query.='\''.addslashes($result_id).'\''.',';
					$query.='\''.addslashes($_SESSION["sUserID"]).'\''.',';
					$query.='now()'.')';

					$this->runSQL($query);
					$this->data->commit();
					$this->lot_id=$lot_id;
	}

	private function getSearchResultLotId($sql,$jsondata,$createUser,$id_field){
			$sql_search_result_id=array();
			$reRow=$this->runSQLAssoc($sql);
			foreach($reRow as $row){
				
				$sql_search_result_id[]="'". addslashes($row[$id_field]) ."'";
			}
		
			$array_count = count($sql_search_result_id);
				if ($array_count > 0){	 
					$result_id = implode(",", $sql_search_result_id);
			}
					$lot_id = strtotime(date("Y-m-d H:i:s"));

					$this->data->beginTransaction();

					$query = 'INSERT INTO `tbl_sys_paging_control`(
								`searchphrase`,
								`lot_id`,
								`result_id`,
								`create_user`,
								`create_datetime`
								) VALUES (';
					$query.='\''.addslashes($jsondata).'\''.',';
					$query.='\''.addslashes($lot_id).'\''.',';
					$query.='\''.addslashes($result_id).'\''.',';
					$query.='\''.addslashes($_SESSION["sUserID"]).'\''.',';
					$query.='now()'.')';

					$this->runSQL($query);
					$this->data->commit();
					$this->lot_id=$lot_id;


	}
	private function genUpdateSql($update_para,$fieldnametype,$table,$idField,$idvalue){
		if (count($update_para)&&count($fieldnametype)&&$table!=''){
			$updateField=array();
			
			foreach ($update_para as $FieldName => $value) {
				if ($FieldName!=$idField)   //ignore the checking update field (table 's id)
				switch($fieldnametype[$FieldName]){
					case 'varchar':
					case 'char':
						$updateField[]="`".$FieldName."`='".addslashes($value)."'";
					break;
					case 'text':
						$updateField[]="`".$FieldName."`='".addslashes(trim($value))."'";
					break;
					case 'int':
					case 'tinyint':
					case 'decimal':
						$updateField[]="`".$FieldName."`='".addslashes($value)."'";
					break;
					case 'datetime':
						if ($value=='now()'){
							$updateField[]="`".$FieldName."`=".$value ;
						}else {
							$updateField[]="`".$FieldName."`='".addslashes($value)."'";
						}
					break;					
					default:
						$updateField[]='`'.$FieldName.'`='.$value;

				}
				
			}
			$result="update `".$table."` set ".
						join(' , ',$updateField).' '.
						"where ".$idField."='".$idvalue."'";
						
			//var_dump($result);			
			$this->result=$result;
		}



	}
	private function genInsertSql($input_para,$fieldnametype,$table){
		if (count($input_para)&&count($fieldnametype)&&$table!=''){
			$insertField=array();
			$insertValue=array();
			foreach ($input_para as $FieldName => $value) {
				switch($fieldnametype[$FieldName]){
					case 'varchar':
					case 'char':
					
						$insertField[]='`'.$FieldName.'`';
						$insertValue[]="'".addslashes($value)."'";
					break;
					case 'text':
						$insertField[]='`'.$FieldName.'`';
						$insertValue[]="'".addslashes(trim($value))."'";
					break;
					case 'int':
					case 'decimal':
					case 'tinyint':
						$insertField[]='`'.$FieldName.'`';
						$insertValue[]="'".addslashes($value)."'";
					break;
					case 'datetime':
						if ($value=='now()'){
							$insertField[]='`'.$FieldName.'`';
							$insertValue[]=$value;
						}else {
							$insertField[]='`'.$FieldName.'`';
							$insertValue[]="'".addslashes($value)."'";
						}
					break;
					default:
						$insertField[]='`'.$FieldName.'`';
						$insertValue[]=$value;

				}
				
			}
			$result="Insert into `".$table."` (".
						join(' , ',$insertField).' '.
						') VALUES ( ' .
						join(' , ',$insertValue).' )';
			$this->result=$result;
		}
	}

	
}
?>