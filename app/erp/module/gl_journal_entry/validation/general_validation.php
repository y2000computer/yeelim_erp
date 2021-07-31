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

    public function ValidateFormActionCreate($form)
	{
		$icheck = true;
		//do checking for action create

		if (!valid::isDate($form['journal_date'])) {
			$this->problemMsg .= '[Journal Date] format is not Vaild!<br>';
			$icheck = false;
		} 

		
		if($this->dataModel->is_duplicate_field('journal_code', $form['journal_code'])){
				$this->problemMsg .= '[Journal Code] cannot duplicate !<br>';
				$icheck = false;
		}


		
		return $icheck;
	}
	

    public function ValidateFormActionUpdate($id, $form)
	{
		$icheck = true;
		//do checking for action update

		/*
		if($this->dataModel->is_duplicate_field_myself($id, 'chart_name', $form['chart_name'])){
				$this->problemMsg .= 'Chart Name cannot duplicate !<br>';
				$icheck = false;
		}
		*/
	
		if (!valid::isDate($form['journal_date'])) {
			$this->problemMsg .= '[Journal Date] format is not Vaild!<br>';
			$icheck = false;
		} 

		if($this->dataModel->is_duplicate_field_myself($id, 'journal_code', $form['journal_code'])){
				$this->problemMsg .= '[Journal Code] cannot duplicate !<br>';
				$icheck = false;
		}
	
		
		
		return $icheck;
	}

	
	public function getProblemMsg(){
		return $this->problemMsg;
	}
	
	
}
?>