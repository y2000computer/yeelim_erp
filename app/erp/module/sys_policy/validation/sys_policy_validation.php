<?php
class sys_policy_validation
{
	private $action;   //Pass action=(create/update) from caller
	private $dmPolicy; //Pass data model instant for checking through database from caller
	private $problemMsg; //return to caller for any problem message
	
	public function __construct($action,$dmPolicy)
    {
		$this->action =$action;
		$this->problemMsg ='';
		$this->dmPolicy = $dmPolicy;
	
	}

    public function select_module($policy)
	{
		$icheck = true;

		//Common foam posting value checking without consider action is create or update 
		if (!valid::hasValue($policy['module_code'])) {
			$this->problemMsg .= '[module_code] Please select a module!<br>';
			$icheck = false;
		} 
			
		return $icheck;
	}
	
    public function ValidateForm($policy)
	{
		$icheck = true;

		//Common foam posting value checking without consider action is create or update 
		if (!valid::hasValue($policy['eng_name'])) {
			$this->problemMsg .= '[Policy Name] cannot empty!<br>';
			$icheck = false;
		} 
		
			
		return $icheck;
	}
	
	
    public function check_module_code($policy)
	{
		$icheck = true;

		//Common foam posting value checking without consider action is create or update 
		if (!valid::hasValue($policy['module_code'])) {
			$this->problemMsg .= 'Please select a Module!<br>';
			$icheck = false;
		} 
					
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
	


	
		
    public function getProblemMsg(){
		return $this->problemMsg;
	}
	
	
}
?>