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

		if($this->dataModel->is_duplicate_field('name_eng', $form['name_eng'])){
				$this->problemMsg .= '[Name (Eng)] cannot duplicate !<br>';
				$icheck = false;
		}
			
		return $icheck;
	}
	

    public function ValidateFormActionUpdate($id, $form)
	{
		$icheck = true;
		//do checking for action update

		if($this->dataModel->is_duplicate_field_myself($id, 'name_eng', $form['name_eng'])){
				$this->problemMsg .= '[Name (Eng)] cannot duplicate !<br>';
				$icheck = false;
		}
		
		
		return $icheck;
	}

	
	public function getProblemMsg(){
		return $this->problemMsg;
	}
	
	
}
?>