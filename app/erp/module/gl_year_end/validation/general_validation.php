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

		if (!valid::isDate($form['journal_date_from'])) {
			$this->problemMsg .= 'Journal Date format is not Vaild!<br>';
			$icheck = false;
		} 

		if (!valid::isDate($form['journal_date_to'])) {
			$this->problemMsg .= 'Journal Date format is not Vaild!<br>';
			$icheck = false;
		} 


		if ($this->dataModel->is_previous_journal_unpost_found($form)) {
			$this->problemMsg .= 'Previously Unpost Journal had found!. Year end can\'t process<br>';
			$icheck = false;
		} 

		
		return $icheck;
	}
	

	
	public function getProblemMsg(){
		return $this->problemMsg;
	}
	
	
}
?>