<?php
require APPPATH.'libraries/REST_Controller.php';
class Well_master extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Well_master_model');
	}

	public function AddWell_post()
	{
        $well_name = $this->input->post('well_name',true);
        $latitude = $this->input->post('latitude',true);
        $longitude = $this->input->post('longitude',true);
        $well_type = $this->input->post('well_type',true);

       	if($this->input->post('company_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'C Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('assets_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'A Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('area_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Area Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('site_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Site Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('well_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Well required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9-# ]*$/",$well_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Well should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('well_type',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Well type required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}
		elseif($this->input->post('c_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verify = $this->Well_master_model->verifyWellExist($this->input->post('well_name',true));
				if($verify == 0)
				{
					
					if($this->input->post('latitude',true)!='')
					{
						if(!preg_match("/^[0-9.]*$/",$latitude))
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Latitude should be decimal allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}
					}

					if($this->input->post('longitude',true)!='')
					{
						if(!preg_match("/^[0-9.]*$/",$longitude))
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Longitude should be decimal allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}
					}

					$id = $this->Well_master_model->getWellId();
					$data = [];
					$data['id'] = $id[0]['UUID()'];
					$data['company_id'] = $this->input->post('company_id',true);
					$data['assets_id'] = $this->input->post('assets_id',true);
					$data['area_id'] = $this->input->post('area_id',true);
					$data['site_id'] = $this->input->post('site_id',true);
					$data['well_name'] = $this->input->post('well_name',true);
					$data['well_type'] = $this->input->post('well_type',true);
					$data['lat'] = $this->input->post('latitude',true);
					$data['long'] = $this->input->post('longitude',true);
					$data['c_by'] = $this->input->post('c_by',true);
					$data['c_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Well_master_model->SaveWellData($data);
					$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Well Saved!!','response_code'=>REST_Controller::HTTP_OK]);
					
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Well Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    public function UpdateWell_post()
	{
        $well_name = $this->input->post('well_name',true);
        $well_type = $this->input->post('well_type',true);
        $latitude = $this->input->post('latitude',true);
        $longitude = $this->input->post('longitude',true);

       	if($this->input->post('id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('assets_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'A Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('area_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Area Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('site_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Site Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('well_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Well required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9-# ]*$/",$well_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Well should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}
		elseif($this->input->post('d_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'D kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verify = $this->Well_master_model->verifyWellExist_OR_not($this->input->post('well_name',true),$this->input->post('id',true));
				if($verify == 0)
				{
					if($this->input->post('latitude',true)!='')
					{
						if(!preg_match("/^[0-9.]*$/",$latitude))
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Latitude should be decimal allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}
					}

					if($this->input->post('longitude',true)!='')
					{
						if(!preg_match("/^[0-9.]*$/",$longitude))
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Longitude should be decimal allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}
					}
					$data = [];
					$data['assets_id'] = $this->input->post('assets_id',true);
					$data['area_id'] = $this->input->post('area_id',true);
					$data['site_id'] = $this->input->post('site_id',true);
					$data['well_name'] = $this->input->post('well_name',true);
					$data['well_type'] = $this->input->post('well_type',true);
					$data['lat'] = $this->input->post('latitude',true);
					$data['long'] = $this->input->post('longitude',true);
					$data['d_by'] = $this->input->post('d_by',true);
					$data['d_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Well_master_model->UpdateWell($data,['id'=>$this->input->post('id',true)]);
					$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Well Updated!!','response_code'=>REST_Controller::HTTP_OK]);
					
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Well Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    public function Well_List_post()
	{
		try {
			$id = $this->input->post('id',true)!=""?$this->input->post('id',true):"";
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$assets_id = $this->input->post('assets_id',true)!=""?$this->input->post('assets_id',true):"";
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$well_type = $this->input->post('well_type',true)!=""?$this->input->post('well_type',true):"";


			$result = $this->Well_master_model->WellList($id,$company_id,$assets_id,$area_id,$site_id,$well_type);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  
	}

	public function deleteWell_post()
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
				$this->Well_master_model->Delete_Well($data,['id'=>$this->input->post('id',true)]);
				$this->response(['status'=>true,'data'=>[],'msg'=>'successfully delete!!','response_code'=>REST_Controller::HTTP_OK]);
					
				
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }
}
?>