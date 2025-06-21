<?php
require APPPATH.'libraries/REST_Controller.php';
class Assets_Master extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Assets_Master_model');
	}

	public function Add_Asset_post()
	{
        $assets_name = $this->input->post('assets_name',true);

       	if($this->input->post('company_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'C Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('assets_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Name required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z ]*$/",$assets_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Name should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('c_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verify = $this->Assets_Master_model->verifyAssetExist($this->input->post('assets_name',true));
				if($verify == 0)
				{
					
					$id = $this->Assets_Master_model->getAssetId();
					$data = [];
					$data['id'] = $id[0]['UUID()'];
					$data['company_id'] = $this->input->post('company_id',true);
					$data['assets_name'] = $this->input->post('assets_name',true);
					$data['c_by'] = $this->input->post('c_by',true);
					$data['c_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Assets_Master_model->SaveAssets($data);
					$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Assets Saved!!','response_code'=>REST_Controller::HTTP_OK]);
					
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Assets Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    public function Update_Asset_post()
	{
        $assets_name = $this->input->post('assets_name',true);

       	if($this->input->post('id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('assets_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Name required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z ]*$/",$assets_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Name should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('d_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'D kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verify = $this->Assets_Master_model->verifyAssetExist_OR_not($this->input->post('assets_name',true),$this->input->post('id',true));
				if($verify == 0)
				{
					
					$data = [];
					$data['assets_name'] = $this->input->post('assets_name',true);
					$data['d_by'] = $this->input->post('d_by',true);
					$data['d_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Assets_Master_model->UpdateAssets($data,['id'=>$this->input->post('id',true)]);
					$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Assets Updated!!','response_code'=>REST_Controller::HTTP_OK]);
					
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Assets Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    public function AssetsList_post()
	{
		try {
			$id = $this->input->post('id',true)!=""?$this->input->post('id',true):"";
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$result = $this->Assets_Master_model->AssetsList($id,$company_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  
	}

	public function deleteAssets_post()
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
				$this->Assets_Master_model->DeleteAssets($data,['id'=>$this->input->post('id',true)]);
				$this->response(['status'=>true,'data'=>[],'msg'=>'successfully delete!!','response_code'=>REST_Controller::HTTP_OK]);
					
				
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }
}
?>