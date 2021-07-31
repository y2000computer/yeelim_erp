<?php
class sys_network_validation
{
	private $action;   //Pass action=(createng_desce/update) from caller
	private $dmnetwork; //Pass data model instant for checking through database from caller
	private $problemMsg; //return to caller for any problem message
	
	public function __construct($action,$dmnetwork)
    {
		$this->action =$action;
		$this->problemMsg ='';
		$this->dmnetwork = $dmnetwork;
		
		
		try {
			$this->dbh = new PDO(DB_CONNECTION_STRING,DB_USERNAME,DB_PASSWORD);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->dbh->query("set names utf8");
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			$sNewLog = new LoggerManager( 'error_sql', '1' );
			$sNewLog -> add( ('ERP->User->SQL error:'.$e->getMessage().'--Statement:'.$query) );
			die();
		}	
		
	}
    public function ValidateForm($network)
	{
		$icheck = true;

		
		//Common foam posting value checking without consider action is create or update 
		if (!valid::hasValue($network['eng_name'])) {
			$this->problemMsg .= '[Network Description] cannot empty!<br>';
			$icheck = false;
		}  else {
			if (valid::isTooLong($network['eng_name'], 50)) {
				$this->problemMsg .= '[Network Description] too long, max length=50 !<br>';
				$icheck = false;
			}
			if (!valid::isTooShort($network['eng_name'], 1)) {
				$this->problemMsg .= '[Network Description] too short, min length=1 !<br>';
				$icheck = false;
			}			
			$count_dup = $this->check_duplicate_eng_name($network['eng_name']);
			if ($count_dup  > 0 ) {	
				$this->problemMsg .= '[Network Description] duplicate !<br>';
				$icheck = false;
			}	
		}

		if (!valid::hasValue($network['net_type'])) {
			$this->problemMsg .= '[Type] cannot empty!<br>';
			$icheck = false;
		}  else {
			if (valid::isTooLong($network['net_type'], 30)) {
				$this->problemMsg .= '[Type] too long, max length=30 !<br>';
				$icheck = false;
			}
			if (!valid::isTooShort($network['net_type'], 1)) {
				$this->problemMsg .= '[Type] too short, min length=1 !<br>';
				$icheck = false;
			}
		}	
if($network['net_type'] == 'DEDIC') {
		if (!valid::hasValue($network['fixed_ip'])) {
			$this->problemMsg .= '[Fixed IP] cannot empty!<br>';
			$icheck = false;
		}  } else {
if($network['net_type'] != 'RANGE') {		
			if (valid::isTooLong($network['fixed_ip'], 30)) {
				$this->problemMsg .= '[Fixed IP] too long, max length=30 !<br>';
				$icheck = false;
			}
			if (!valid::isTooShort($network['fixed_ip'], 1)) {
				$this->problemMsg .= '[Fixed IP] too short, min length=1 !<br>';
				$icheck = false;
			}
			if(!filter_var($network['fixed_ip'], FILTER_VALIDATE_IP)) {

   				$this->problemMsg .= '[Fixed IP] not a valid IP address!<br>';
				$icheck = false;
			}
		}	}
	
if($network['net_type'] == 'RANGE') {
		if (!valid::hasValue($network['ip_range_from'])) {
			$this->problemMsg .= '[IP Range From] cannot empty!<br>';
			$icheck = false;
		}}  else {
if($network['net_type'] != 'DEDIC') {
			if (valid::isTooLong($network['ip_range_from'], 30)) {
				$this->problemMsg .= '[IP Range From] too long, max length=30 !<br>';
				$icheck = false;
			}
			if (!valid::isTooShort($network['ip_range_from'], 1)) {
				$this->problemMsg .= '[IP Range From] too short, min length=1 !<br>';
				$icheck = false;
			}
			if(!filter_var($network['ip_range_from'], FILTER_VALIDATE_IP)) {
   				$this->problemMsg .= '[IP Range From] not a valid IP address!<br>';
				$icheck = false;
			}		
}			
		}	
if($network['net_type'] == 'RANGE') {
		if (!valid::hasValue($network['ip_range_to'])) {
			$this->problemMsg .= '[IP Range To] cannot empty!<br>';
			$icheck = false;
		}}  else {
if($network['net_type'] != 'DEDIC') {		
			if (valid::isTooLong($network['ip_range_to'], 30)) {
				$this->problemMsg .= '[IP Range To] too long, max length=30 !<br>';
				$icheck = false;
			}
			if (!valid::isTooShort($network['ip_range_to'], 1)) {
				$this->problemMsg .= '[IP Range To] too short, min length=1 !<br>';
				$icheck = false;
			}
			if(!filter_var($network['ip_range_to'], FILTER_VALIDATE_IP)) {
   				$this->problemMsg .= '[IP Range To] not a valid IP address!<br>';
				$icheck = false;
			}	
}			
		}	
		
if($network['net_type'] == 'DEDIC' || $network['net_type'] == 'RANGE' ) {
		if (!valid::hasValue($network['network_mask'])) {
			$this->problemMsg .= '[Network Mask] cannot empty!<br>';
			$icheck = false;
		}}  else {
			if (valid::isTooLong($network['network_mask'], 30)) {
				$this->problemMsg .= '[Network Mask] too long, max length=30 !<br>';
				$icheck = false;
			}
			if (!valid::isTooShort($network['network_mask'], 1)) {
				$this->problemMsg .= '[Network Mask] too short, min length=1 !<br>';
				$icheck = false;
			}
			if(!filter_var($network['network_mask'], FILTER_VALIDATE_IP)) {
   				$this->problemMsg .= '[Network Mask] not a valid IP address!<br>';
				$icheck = false;
			}				
			
		}			
	
		
		//Pass to action update validation
		if($icheck && $this->action=='update') $icheck = $this->ValidateFormActionUpdate($network);
		//Pass to action create validation
		if($icheck && $this->action=='update') $icheck = $this->ValidateFormActionCreate($network);

		
		
		return $icheck;
	}
    public function ValidateForm2($network)
	{
		$icheck = true;
		
		//Common foam posting value checking without consider action is create or update 
		if (!valid::hasValue($network['eng_name'])) {
			$this->problemMsg .= '[Network Description] cannot empty!<br>';
			$icheck = false;
		}  else {
			if (valid::isTooLong($network['eng_name'], 30)) {
				$this->problemMsg .= '[Network Description] too long, max length=30 !<br>';
				$icheck = false;
			}
			if (!valid::isTooShort($network['eng_name'], 1)) {
				$this->problemMsg .= '[Network Description] too short, min length=1 !<br>';
				$icheck = false;
			}
			
			/*
			if($network['eng_name'] != $network['present_eng_name']) {
				$count_dup = $this->check_duplicate_eng_name($network['eng_name']);
				if ($count_dup  > 0 ) {	
					$this->problemMsg .= 'Network Description duplicate !<br>';
					$icheck = false;
				}	
			}
			*/
		}

		if (!valid::hasValue($network['net_type'])) {
			$this->problemMsg .= '[Type] cannot empty!<br>';
			$icheck = false;
		}  else {
			if (valid::isTooLong($network['net_type'], 30)) {
				$this->problemMsg .= '[Type] too long, max length=30 !<br>';
				$icheck = false;
			}
			if (!valid::isTooShort($network['net_type'], 1)) {
				$this->problemMsg .= '[Type] too short, min length=1 !<br>';
				$icheck = false;
			}
		}	
if($network['net_type'] == 'DEDIC') {
		if (!valid::hasValue($network['fixed_ip'])) {
			$this->problemMsg .= '[Fixed IP] cannot empty!<br>';
			$icheck = false;
		} } else {
if($network['net_type'] != 'RANGE') {			
			if (valid::isTooLong($network['fixed_ip'], 30)) {
				$this->problemMsg .= '[Fixed IP] too long, max length=30 !<br>';
				$icheck = false;
			}
			if (!valid::isTooShort($network['fixed_ip'], 1)) {
				$this->problemMsg .= '[Fixed IP] too short, min length=1 !<br>';
				$icheck = false;
			}
			if(!filter_var($network['fixed_ip'], FILTER_VALIDATE_IP)) {

   				$this->problemMsg .= '[Fixed IP] not a valid IP address!<br>';
				$icheck = false;
			}
		}	}
if($network['net_type'] == 'RANGE') {
		if (!valid::hasValue($network['ip_range_from'])) {
			$this->problemMsg .= '[IP Range From] cannot empty!<br>';
			$icheck = false;
		}}  else {
if($network['net_type'] != 'DEDIC') {		
			if (valid::isTooLong($network['ip_range_from'], 30)) {
				$this->problemMsg .= '[IP Range From] too long, max length=30 !<br>';
				$icheck = false;
			}
			if (!valid::isTooShort($network['ip_range_from'], 1)) {
				$this->problemMsg .= '[IP Range From] too short, min length=1 !<br>';
				$icheck = false;
			}
			if(!filter_var($network['ip_range_from'], FILTER_VALIDATE_IP)) {
   				$this->problemMsg .= '[IP Range From] not a valid IP address!<br>';
				$icheck = false;
			}			}
		}	
if($network['net_type'] == 'RANGE') {
		if (!valid::hasValue($network['ip_range_to'])) {
			$this->problemMsg .= '[IP Range To] cannot empty!<br>';
			$icheck = false;
		}}  else {
if($network['net_type'] != 'DEDIC') {				
			if (valid::isTooLong($network['ip_range_to'], 30)) {
				$this->problemMsg .= '[IP Range To] too long, max length=30 !<br>';
				$icheck = false;
			}
			if (!valid::isTooShort($network['ip_range_to'], 1)) {
				$this->problemMsg .= '[IP Range To] too short, min length=1 !<br>';
				$icheck = false;
			}
			if(!filter_var($network['ip_range_to'], FILTER_VALIDATE_IP)) {
   				$this->problemMsg .= '[IP Range To] not a valid IP address!<br>';
				$icheck = false;
			}	}		
		}	

if($network['net_type'] == 'DEDIC' || $network['net_type'] == 'RANGE' ) {
		if (!valid::hasValue($network['network_mask'])) {
			$this->problemMsg .= '[Network Mask] cannot empty!<br>';
			$icheck = false;
		}}  else {
			if (valid::isTooLong($network['network_mask'], 30)) {
				$this->problemMsg .= '[Network Mask] too long, max length=30 !<br>';
				$icheck = false;
			}
			if (!valid::isTooShort($network['network_mask'], 1)) {
				$this->problemMsg .= '[Network Mask] too short, min length=1 !<br>';
				$icheck = false;
			}
			if(!filter_var($network['network_mask'], FILTER_VALIDATE_IP)) {
   				$this->problemMsg .= '[Network Mask] not a valid IP address!<br>';
				$icheck = false;
			}				
			
		}			
		

		//Pass to action update validation
		if($icheck && $this->action=='update') $icheck = $this->ValidateFormActionUpdate($network);
		//Pass to action create validation
		if($icheck && $this->action=='update') $icheck = $this->ValidateFormActionCreate($network);
		
		return $icheck;
	}

		//if ValidateForm passed then goto checking upon action = update
    public function ValidateFormActionUpdate($policy)
	{
		$icheck = true;
		//do checking for action update

		return $icheck;
	}

	//if ValidateForm passed then goto checking upon action = create
    public function ValidateFormActionCreate($policy)
	{
		$icheck = true;
		//do checking for action create

		return $icheck;
	}
	
	
	 public function check_duplicate_eng_name($eng_name)
		{
			$eng_name = addslashes($eng_name);
			$query ="SELECT COUNT(*) AS RecordCount				
						FROM tbl_sys_network where eng_name = '$eng_name'";
				
			$arr_item = array();

			try {
				$rows = $this->dbh->query($query);
				while($row = $rows->fetch(PDO::FETCH_ASSOC)){
				  //print_r_html($row); // Debug used only
				  $arr_item[] = $row;
				 }
				} catch (PDOException $e) {
					print "Error!: " . $e->getMessage() . "<br/>";
					$sNewLog = new LoggerManager( 'error_sql', '1' );
					$sNewLog -> add( ('ERP->User->SQL error:'.$e->getMessage().'--Statement:'.$query) );
					die();
			  }		

			$user_item  = $arr_item[0];
			$count_dup = $user_item['RecordCount'];

			return $count_dup;
		}	
				
		
		public function getProblemMsg(){
			return $this->problemMsg;
	}
	
	
}
?>