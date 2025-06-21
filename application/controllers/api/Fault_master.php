<?php
require APPPATH.'libraries/REST_Controller.php';
class Fault_master extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Fault_master_model');
	}

	public function Add_Fault_post()
	{
        $fault_name = $this->input->post('fault_name',true);
        $color_code = $this->input->post('color_code',true);

       	if($this->input->post('company_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'C Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('fault_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Fault required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-z-.()\/ ]*$/",$fault_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Fault should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('color_code',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Hash code required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^#[0-9A-Za-z]{6}$/",$color_code))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Color should be hash code allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('c_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verify = $this->Fault_master_model->verifyFaultExist($this->input->post('fault_name',true));
				if($verify == 0)
				{
					
					$id = $this->Fault_master_model->getFalutId();
					$data = [];
					$data['id'] = $id[0]['UUID()'];
					$data['company_id'] = $this->input->post('company_id',true);
					$data['fault_name'] = $this->input->post('fault_name',true);
					$data['color_code'] = $this->input->post('color_code',true);
					$data['fault_number'] = $this->Fault_master_model->getFault_Number();
					$data['c_by'] = $this->input->post('c_by',true);
					$data['c_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Fault_master_model->SaveFault($data);
					$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Saved!!','response_code'=>REST_Controller::HTTP_OK]);
					
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'This type fault Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    public function Update_Fault_post()
	{
        $fault_name = $this->input->post('fault_name',true);
        $color_code = $this->input->post('color_code',true);

       	if($this->input->post('id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('fault_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Fault required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-z-.()\/ ]*$/",$fault_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Fault should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('color_code',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Hash code required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^#[0-9A-Za-z]{6}$/",$color_code))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Color should be hash code allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('d_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'d kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verify = $this->Fault_master_model->verifyFaultExist_OR_not($this->input->post('fault_name',true),$this->input->post('id',true));
				if($verify == 0)
				{
					$data = [];
					$data['fault_name'] = $this->input->post('fault_name',true);
					$data['color_code'] = $this->input->post('color_code',true);
					$data['d_by'] = $this->input->post('d_by',true);
					$data['d_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Fault_master_model->UpdateFault($data,['id'=>$this->input->post('id',true)]);
					$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Updated!!','response_code'=>REST_Controller::HTTP_OK]);
					
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'This type fault Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    
    public function FaultList_post()
	{
		try {
			$id = $this->input->post('id',true)!=""?$this->input->post('id',true):"";
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			
			$result = $this->Fault_master_model->FaultList($id,$company_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  
	}

	public function deleteFault_post()
	{	    
        if($this->input->post('id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'ID required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('d_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'d kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$data = [];
				$data['d_by'] = $this->input->post('d_by',true);
				$data['d_date'] = date('Y-m-d H:i:s');
				$data['status'] = 0;
				$this->Fault_master_model->DeleteFault($data,['id'=>$this->input->post('id',true)]);
				$this->response(['status'=>true,'data'=>[],'msg'=>'successfully delete!!','response_code'=>REST_Controller::HTTP_OK]);
					
				
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }
}
?>