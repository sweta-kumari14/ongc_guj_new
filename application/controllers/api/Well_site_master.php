<?php
require APPPATH.'libraries/REST_Controller.php';
class Well_site_master extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Well_site_model');
	}

	public function WellSiteAdd_post()
	{
        $well_site_name = $this->input->post('well_site_name',true);

        if($this->input->post('company_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Company required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('well_site_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Site required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9-. ]*$/",$well_site_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Site name not valid !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('area_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'C Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('assets_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Asset required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('c_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verify = $this->Well_site_model->verifySiteExist($this->input->post('well_site_name',true));
				if($verify == 0)
				{
					
					$id = $this->Well_site_model->getSiteID();
						// print_r($id);die;
					$data = [];
					$data['id'] = $id[0]['UUID()'];
					$data['company_id'] = $this->input->post('company_id',true);
					$data['well_site_name'] = $this->input->post('well_site_name',true);
					$data['assets_id'] = $this->input->post('assets_id',true);
					$data['area_id'] = $this->input->post('area_id',true);
					$data['c_by'] = $this->input->post('c_by',true);
					$data['c_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Well_site_model->Add_WellSite($data);

					$this->response(['status'=>true,'data'=>[],'msg'=>'successfully saved!!','response_code'=>REST_Controller::HTTP_OK]);
							
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Site Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    public function UpdateWellSite_post()
	{
        $well_site_name = $this->input->post('well_site_name',true);

        if($this->input->post('id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('well_site_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Site required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9-. ]*$/",$well_site_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Site name not valid !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('assets_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Asset required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('area_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'C Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('d_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'d kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verify = $this->Well_site_model->verifyWellSiteExist_OrNot($this->input->post('well_site_name',true),$this->input->post('id',true));
				if($verify == 0)
				{
					$data = [];
					$data['well_site_name'] = $this->input->post('well_site_name',true);
					$data['area_id'] = $this->input->post('area_id',true);
					$data['assets_id'] = $this->input->post('assets_id',true);
					$data['d_by'] = $this->input->post('d_by',true);
					$data['d_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Well_site_model->UpdateWellSiteData($data,['id'=>$this->input->post('id',true)]);

					$this->response(['status'=>true,'data'=>[],'msg'=>'successfully updated!!','response_code'=>REST_Controller::HTTP_OK]);
							
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Site Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

	public function Well_SiteList_post()
	{
		try {
			$id = $this->input->post('id',true)!=""?$this->input->post('id',true):"";
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";

			$result = $this->Well_site_model->SiteList($id,$company_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  
	}

	public function deleteSite_post()
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
				$this->Well_site_model->DeleteSite($data,['id'=>$this->input->post('id',true)]);
				$this->response(['status'=>true,'data'=>[],'msg'=>'successfully delete!!','response_code'=>REST_Controller::HTTP_OK]);
					
				
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }
	public function get_well_running_post(){
		if($this->input->post('from_date',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'from date required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}
		elseif($this->input->post('to_date',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'to date required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}
		else{
			try{
				$from_date=$this->input->post('from_date',true);
				$to_date=$this->input->post('to_date',true);
				$result = $this->Well_site_model->Well_Running_Details($from_date,$to_date);
				$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
			}
			catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
			}
			
		}
	}

}
?>