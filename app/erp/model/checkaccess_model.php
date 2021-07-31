<?php
class checkaccess_model
{

private $dbh;

	public function __construct()
    {
		try {
			$this->dbh = new PDO(DB_CONNECTION_STRING,DB_USERNAME,DB_PASSWORD);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->dbh->query("set names utf8");
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
			}
	}

	
	public function checkRight($policy)
	{

		$email = $_SESSION["sUserID"];
		$allow = 0; $level = 0; $add = 0; $change = 0; $delete = 0;
		$policy_module = $_SESSION["policy_module"];
		$module = explode(",", $policy_module);
		$module_array=array_map('trim',$module);  //trim array empty space

		if(in_array($policy, $module_array))
		  {
	  
			$arr_policy_id = array();

			  $sql = "SELECT policy_id FROM `tbl_sys_user_policy_grant` 
				WHERE status=1 AND user_id IN
				(SELECT user_id FROM `tbl_sys_user` WHERE email = '$email')";
			  	  
		try {
			$rows = $this->dbh->query($sql);
				while($list = $rows->fetch(PDO::FETCH_ASSOC)){				  
					$arr_policy_id[] = $list;	
					}
				}catch (PDOException $e) {
					print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql.'<br>';
					die();
		  }		
				
		foreach ($arr_policy_id as $policy_a) {	
			
			$policy_id = $policy_a['policy_id'];

			$sql2 = "SELECT rights_level,  rights_create, rights_update, rights_void 
			  FROM tbl_sys_policy_module 
			  WHERE module_code like '%$policy%' AND policy_id = '$policy_id' AND status = '1'";

			  
		try {
			$rows2 = $this->dbh->query($sql2);
				while($list2 = $rows2->fetch(PDO::FETCH_ASSOC)){				  
					$list = $list2;	
					}	
				}catch (PDOException $e) {
					print 'Error!: ' . $e->getMessage() . '<br>Script:'.$sql2.'<br>';
					die();
		  }					
				if ($list["rights_level"] > $level){
					$allow = 1;
					$level = $list["rights_level"];
					$add = $list["rights_create"];
					$change = $list["rights_update"];
					$delete = $list["rights_void"];		
				}		
	
			}
								
			return array($allow,$level,$add,$change,$delete);				
		}
		
		
		return array($allow,$level,$add,$change,$delete);
	}
	
}

?>
