<?php
require APPPATH.'libraries/REST_Controller.php';
class Area_master extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Area_master_model');
	}

	public function AddArea_post()
	{
        $area_name = $this->input->post('area_name',true);

       	if($this->input->post('company_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'C Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('assets_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'A Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('area_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Area required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z-. ]*$/",$area_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Area should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('c_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verify = $this->Area_master_model->verifyAreaExist($this->input->post('area_name',true));
				if($verify == 0)
				{
					
					$id = $this->Area_master_model->getClsId();
					$data = [];
					$data['id'] = $id[0]['UUID()'];
					$data['company_id'] = $this->input->post('company_id',true);
					$data['assets_id'] = $this->input->post('assets_id',true);
					$data['area_name'] = $this->input->post('area_name',true);
					$data['c_by'] = $this->input->post('c_by',true);
					$data['c_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Area_master_model->SaveArea($data);
					$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Area Saved!!','response_code'=>REST_Controller::HTTP_OK]);
					
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Area Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    public function UpdateArea_post()
	{
        $area_name = $this->input->post('area_name',true);

       	if($this->input->post('id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('area_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Area required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z-. ]*$/",$area_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Area should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('d_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'D kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verify = $this->Area_master_model->verifyAreaExist_OR_not($this->input->post('area_name',true),$this->input->post('id',true));
				if($verify == 0)
				{
					
					$data = [];
					$data['area_name'] = $this->input->post('area_name',true);
					$data['d_by'] = $this->input->post('d_by',true);
					$data['d_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Area_master_model->UpdateArea($data,['id'=>$this->input->post('id',true)]);
					$this->response(['status'=>true,'data'=>[],'msg'=>'successfully updated!!','response_code'=>REST_Controller::HTTP_OK]);
					
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Area Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    public function AreaList_post()
	{
		try {
			$id = $this->input->post('id',true)!=""?$this->input->post('id',true):"";
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$assets_id = $this->input->post('assets_id',true)!=""?$this->input->post('assets_id',true):"";
			$result = $this->Area_master_model->AreaList($id,$company_id,$assets_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  
	}

	public function deleteArea_post()
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
				$this->Area_master_model->DeleteArea($data,['id'=>$this->input->post('id',true)]);
				$this->response(['status'=>true,'data'=>[],'msg'=>'successfully delete!!','response_code'=>REST_Controller::HTTP_OK]);
					
				
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }
}
?>