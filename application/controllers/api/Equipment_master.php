<?php
require APPPATH.'libraries/REST_Controller.php';
class Equipment_master extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Equipment_master_model');
	}

	public function AddEquipment_post()
	{
        $equipment_name = $this->input->post('equipment_name',true);

       	if($this->input->post('company_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'C Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('equipment_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Equipment required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9- ]*$/",$equipment_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Equipment not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('c_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verify = $this->Equipment_master_model->verify_EquipmentExist($this->input->post('equipment_name',true));
				if($verify == 0)
				{
					
					$id = $this->Equipment_master_model->getEqpId();
					$data = [];
					$data['id'] = $id[0]['UUID()'];
					$data['company_id'] = $this->input->post('company_id',true);
					$data['equipment_name'] = $this->input->post('equipment_name',true);
					$data['c_by'] = $this->input->post('c_by',true);
					$data['c_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Equipment_master_model->SaveEquipment($data);
					$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Equipment Saved!!','response_code'=>REST_Controller::HTTP_OK]);
					
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Equipment Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    public function UpdateEquipment_post()
	{
        $equipment_name = $this->input->post('equipment_name',true);

       	if($this->input->post('id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('equipment_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Equipment required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9- ]*$/",$equipment_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Equipment not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('d_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'d kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verify = $this->Equipment_master_model->verifyEquimentExist_OR_not($this->input->post('equipment_name',true),$this->input->post('id',true));
				if($verify == 0)
				{
					
					$data = [];
					$data['equipment_name'] = $this->input->post('equipment_name',true);
					$data['d_by'] = $this->input->post('d_by',true);
					$data['d_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Equipment_master_model->UpdateEquipment($data,['id'=>$this->input->post('id',true)]);
					$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Equipment Updated!!','response_code'=>REST_Controller::HTTP_OK]);
					
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Equipment Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    public function EquipmentList_post()
	{
		try {
			$id = $this->input->post('id',true)!=""?$this->input->post('id',true):"";
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			
			$result = $this->Equipment_master_model->EquipmentList($id,$company_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  
	}

	public function deleteEquipment_post()
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
				$this->Equipment_master_model->DeleteEquipment($data,['id'=>$this->input->post('id',true)]);
				$this->response(['status'=>true,'data'=>[],'msg'=>'successfully delete!!','response_code'=>REST_Controller::HTTP_OK]);
					
				
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }
}
?>