<?php

class security_validation
{
	private $action;   //Pass action=(create/update) from caller
	private $dmSecurity; //Pass data model instant for checking through database from caller
	private $problemMsg; //return to caller for any problem message

	public function __construct($action,$dmSecurity)
    {
		$this->action =$action;
		$this->problemMsg ='';
		$this->dmSecurity = $dmSecurity;
	}

    public function ValidateForm($security)
	{
		$icheck = true;
		//Common foam posting value checking without consider action is create or update 
		if (!valid::hasValue($security['sUserID'])) {

			$this->problemMsg .= 'Username cannot empty!<br>';
			$reason ='Username cannot empty!';
			$time = date("Y-m-d H:i:s");
			$source_ip = $_SESSION["source_ip"];
			$browser_type = $_SESSION["browser_type"];
			$url = $_SESSION["url"];
			$skip = true;
			$this->dmSecurity->writefailreason($security['sUserID'], $security['sPassword'], $reason, $source_ip, $browser_type, $url, $time);
			$icheck = false;
		}

		if (!valid::hasValue($security['sPassword'])) {
			$this->problemMsg .= 'Password cannot empty!<br>';
			$reason ='Password cannot empty!';
			$time = date("Y-m-d H:i:s");
			$source_ip = $_SESSION["source_ip"];
			$browser_type = $_SESSION["browser_type"];
			$url = $_SESSION["url"];
			$this->dmSecurity->writefailreason($security['sUserID'], $security['sPassword'], $reason,$source_ip, $browser_type, $url, $time);
			$icheck = false;
		} 

		//Pass to action checklogin validation
		if($icheck && $this->action=='checklogin') $icheck = $this->ValidateFormActionCheckLogin($security);
		return $icheck;
	}

	//if ValidateForm passed then goto checking upon action = update
    public function ValidateFormActionCheckLogin($security)
	{
		$icheck = true;
		//do checking for action update

		//Check sUserID existed at database 
		if (!$this->dmSecurity->hasSecurityUserID($security['sUserID'])) {
			$this->problemMsg .= 'Username not found !<br>';
			$reason ='Username not found !';
			$time = date("Y-m-d H:i:s");
			$source_ip = $_SESSION["source_ip"];
			$browser_type = $_SESSION["browser_type"];
			$url = $_SERVER["REQUEST_URI"];
			$this->dmSecurity->writefailreason($security['sUserID'], $security['sPassword'], $reason, $source_ip, $browser_type, $url, $time);
			$icheck = false;
			}
		else
			{
			//Check sUserID and sPassword match  at database 
			if ($this->dmSecurity->isSecurityCheckUserBlock($security['sUserID'])) {
						$this->problemMsg .= 'User account had been disable !<br>';
					$reason ='User account had been disable !';
					$time = date("Y-m-d H:i:s");
					$source_ip = $_SESSION["source_ip"];
					$browser_type = $_SESSION["browser_type"];
					$url = $_SERVER["REQUEST_URI"];
					$this->dmSecurity->writefailreason($security['sUserID'], $security['sPassword'], $reason, $source_ip, $browser_type, $url, $time);
					$icheck = false;
			} else {
					//Check sUserID is block at database 
					
					if (!$this->dmSecurity->network_checking($security['sUserID'], $_SESSION["source_ip"])) {
						$this->problemMsg .= 'IP ADDRESS FAIL<br>';
						$reason ='IP ADDRESS FAIL !';
						$time = date("Y-m-d H:i:s");
						$source_ip = $_SESSION["source_ip"];
						$browser_type = $_SESSION["browser_type"];
						$url = $_SERVER["REQUEST_URI"];
						$this->dmSecurity->writefailreason($security['sUserID'], $security['sPassword'], $reason, $source_ip, $browser_type, $url, $time);
						$this->dmSecurity->faillogincounter($security['sUserID'], $time);
						$icheck = false;
					}	
					
					if (!$this->dmSecurity->hasSecurityCheckLogin($security['sUserID'],$security['sPassword'])) {
						$this->problemMsg .= 'Wrong Password !<br>';
						$reason ='Wrong Password !';
						$time = date("Y-m-d H:i:s");
						$source_ip = $_SESSION["source_ip"];
						$browser_type = $_SESSION["browser_type"];
						$url = $_SERVER["REQUEST_URI"];
						$this->dmSecurity->writefailreason($security['sUserID'], $security['sPassword'], $reason, $source_ip, $browser_type, $url, $time);
						$this->dmSecurity->faillogincounter($security['sUserID'], $time);
						$icheck = false;
					}	
				}
			
		}	
		$this->dmSecurity->security_policy_module($security['sUserID']); //write session of security
		return $icheck;
	}


	
    public function Validate_Change_Password_Form($security)
	{
		$icheck = true;
		//Common foam posting value checking without consider action is create or update 
		if ($security['new_password']<>$security['repeat_password']) {	
			$this->problemMsg .= 'New Password invalid!<br>';
			$icheck = false;
		}

		//Check old password 
		if($icheck==true) {
		if (!$this->dmSecurity->check_old_password($security,$_SESSION["sUserID"])) {			
			$this->problemMsg .= 'Old password invalid !<br>';
			$icheck = false;
			}		
		}//if($icheck==true) {
			
		return $icheck;
	}		

    public function getProblemMsg(){
		return $this->problemMsg;
	}
	
	
}
?>