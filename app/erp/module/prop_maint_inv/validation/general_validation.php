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

		if (!valid::isDecimalNumber($form['amount'])) {
			$this->problemMsg .= '[Invoice Amount] format is not Valid!<br>';
			$icheck = false;
		} 
		
		if (!valid::isDate($form['inv_date'])) {
			$this->problemMsg .= '[Invoice Date] format is not Vaild!<br>';
			$icheck = false;
		} 

		if (!valid::isDate($form['period_date_from'])) {
			$this->problemMsg .= '[Period Date From] format is not Vaild!<br>';
			$icheck = false;
		} 

		if (!valid::isDate($form['period_date_to'])) {
			$this->problemMsg .= '[Period Date To] format is not Vaild!<br>';
			$icheck = false;
		} 

		/*
		if (!valid::isDecimalNumber($form['rent_amount'])) {
			$this->problemMsg .= '[Rent. Amount] format is not Valid!<br>';
			$icheck = false;
		} 		
		if (!valid::isDecimalNumber($form['maint_amount'])) {
			$this->problemMsg .= '[Maint. Amount] format is not Valid!<br>';
			$icheck = false;
		} 

		if($this->dataModel->is_duplicate_field('tenant_code', $form['tenant_code'], $form['build_id']))
		{
				$this->problemMsg .= '[Tenant Code] cannot duplicate !<br>';
				$icheck = false;
		}
		*/

		
		return $icheck;
	}
	

    public function ValidateFormActionUpdate($id, $form)
	{
		$icheck = true;
		//do checking for action update

		/*
		if (!valid::isDecimalNumber($form['rent_amount'])) {
			$this->problemMsg .= '[Rent. Amount] format is not Valid!<br>';
			$icheck = false;
		} 		
		if (!valid::isDecimalNumber($form['maint_amount'])) {
			$this->problemMsg .= '[Maint. Amount] format is not Valid!<br>';
			$icheck = false;
		}  
		
		if($this->dataModel->is_duplicate_field_myself($id, 'tenant_code', $form['tenant_code'], $form['build_id']))
		{
				$this->problemMsg .= '[Tenant Code] cannot duplicate !<br>';
				$icheck = false;
		}
		*/

		
		return $icheck;
	}

	
	public function getProblemMsg(){
		return $this->problemMsg;
	}
	
	
}
?>