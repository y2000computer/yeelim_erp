<?php
class detail_validation
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

    public function ValidateFormActionCreate($form)
	{
		$icheck = true;
		//do checking for action create


		
		return $icheck;
	}
	

    public function ValidateFormActionUpdate($id, $form)
	{
		$icheck = true;
		//do checking for action update

		if (!valid::isDecimalNumber($form['amount'])) {
			$this->problemMsg .= '[Amount] format is not Valid!<br>';
			$icheck = false;
		} 

				
		if (!valid::isDate($form['chart_code'])) {
			$this->problemMsg .= '[Journal Date] format is not Valid!<br>';
			$icheck = false;
		} 

		
		if(!$this->dataModel->is_valid_chart_code($form['chart_code'])){
				$this->problemMsg .= '[Chart Code] is not Valid !<br>';
				$icheck = false;
		}

		
		
		
		return $icheck;
	}

	
	public function getProblemMsg(){
		return $this->problemMsg;
	}
	
	
}
?>