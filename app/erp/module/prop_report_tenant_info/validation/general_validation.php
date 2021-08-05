<?php
class general_validation
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

	
    public function ValidateForm($form)
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