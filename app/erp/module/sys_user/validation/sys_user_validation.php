<?php
class sys_user_validation
{
	private $action;   
	private $dataModel; 
	private $problemMsg; 
	
	public function __construct($action,$dataModel)
    {
		$this->action =$action;
		$this->dataModel = $dataModel;
		$this->problemMsg ='';
	
	}

    public function ValidateFormActionCreate($user)
	{
		$icheck = true;
		//do checking for action create

		//Common foam posting value checking without consider action is create or update 
		if (!valid::hasValue($user['email'])) {
			$this->problemMsg .= '[email] cannot empty!<br>';
			$icheck = false;
		}  else {
			if (valid::isTooLong($user['email'], 50)) {
				$this->problemMsg .= '[email] too long, max length=50 !<br>';
				$icheck = false;
			}
			if (!valid::isTooShort($user['email'], 1)) {
				$this->problemMsg .= '[email] too short, min length=1 !<br>';
				$icheck = false;
			}

			if($this->dataModel->is_duplicate_field('email', $user['email'])){
					$this->problemMsg .= '[email]  cannot duplicate !<br>';
					$icheck = false;
			}
			
			
		}
		
		if (!valid::hasValue($user['password'])) {
		$this->problemMsg .= '[password] cannot empty!<br>';
		$icheck = false;
		}

		if (!valid::hasValue($user['last_name'])) {
		$this->problemMsg .= '[Last Name] cannot empty!<br>';
		$icheck = false;
		} 

		
		return $icheck;
	}
	

    public function ValidateFormActionUpdate($id, $user)
	{
		$icheck = true;
		//do checking for action update

		
		if($this->dataModel->is_duplicate_field_myself($id, 'email', $user['email'])){
				$this->problemMsg .= '[email] cannot duplicate !<br>';
				$icheck = false;
		}
	

		
		return $icheck;
	}

	
	public function getProblemMsg(){
		return $this->problemMsg;
	}
	
	
}
?>