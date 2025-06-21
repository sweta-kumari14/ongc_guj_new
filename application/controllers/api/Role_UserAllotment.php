<?php
require APPPATH.'libraries/REST_Controller.php';
class Role_UserAllotment extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('SiteUser_Allotment_model');
	}

    public function User_Allotment_post()
    {
        $role_type = $this->input->post('role_type',true);
        if($this->input->post('company_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'C Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('role_type',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Role required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match('/^[1-5]{1}$/',$role_type))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Role should be 1,2 and 3 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('user_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'User required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('c_by',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {

                if($role_type == 1 || $role_type == 4 || $role_type == 5)
                {
                    if($this->input->post('assign_assets',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Assets required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }else{
                        $assign_assets = json_decode($this->input->post('assign_assets',true),true);
                        if(empty($assign_assets))
                        {
                           $dataArray = [];
                            $dataArray['d_by'] = $this->input->post('d_by',true);
                            $dataArray['d_date'] = date('Y-m-d H:i:s');
                            $dataArray['status'] = 0;
                            $this->SiteUser_Allotment_model->assign_UserUpdate($dataArray,['company_id'=>$this->input->post('company_id',true),'user_id'=>$this->input->post('user_id',true),'role_type'=>1]);
                            
                        }else
                        {
                            $dataArray = [];
                            $dataArray['d_by'] = $this->input->post('d_by',true);
                            $dataArray['d_date'] = date('Y-m-d H:i:s');
                            $dataArray['status'] = 0;
                            $dataArray['d_by'] = $this->input->post('c_by',true);
                            $dataArray['d_date'] = date('Y-m-d H:i:s');
                            $this->SiteUser_Allotment_model->assign_UserUpdate($dataArray,['company_id'=>$this->input->post('company_id',true),'user_id'=>$this->input->post('user_id',true),'role_type'=>1,'status'=>1]);

                            foreach($assign_assets as $key=>$value)
                            {
 
                               $area = $this->SiteUser_Allotment_model->getAll_area($this->input->post('company_id',true),$value);
                                // print_r($area);die; 
                                foreach ($area as $key => $value1) 
                                {

                                    $A_id = $value1['id'];
                                    $Site = $value1['well_site_id'];
                                    $Well = $value1['well_id'];
                                    $id = $this->SiteUser_Allotment_model->getsite_userId();
                                    $dataArray = [];
                                    $dataArray['id'] = $id[0]['UUID()'];
                                    $dataArray['company_id'] = $this->input->post('company_id',true);
                                    $dataArray['user_id'] = $this->input->post('user_id',true);
                                    $dataArray['role_type'] = $this->input->post('role_type',true);
                                    $dataArray['assets_id'] = $value;
                                    $dataArray['area_id'] = $A_id;
                                    $dataArray['site_id'] = $Site;
                                    $dataArray['well_id'] = $Well;
                                    $dataArray['allotment_datetime'] = date('Y-m-d H:i:s');
                                    $dataArray['c_by'] = $this->input->post('c_by',true);
                                    $dataArray['c_date'] = date('Y-m-d H:i:s');
                                    $dataArray['status'] = 1;
                                    $this->SiteUser_Allotment_model->Site_UserAllotment($dataArray);
                                }        
                            }
                            
                        }
                    }
                    
                }

                if($role_type == 2)
                {
                    if($this->input->post('assets_id',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Assets required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }elseif($this->input->post('assign_area',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Area required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }else{
                        $assign_area = json_decode($this->input->post('assign_area',true),true);
                        // print_r($assign_area);die;
                        if(empty($assign_area))
                        {
                           $dataArray = [];
                            $dataArray['d_by'] = $this->input->post('d_by',true);
                            $dataArray['d_date'] = date('Y-m-d H:i:s');
                            $dataArray['status'] = 0;
                            $this->SiteUser_Allotment_model->assign_UserUpdate($dataArray,['company_id'=>$this->input->post('company_id',true),'assets_id'=>$this->input->post('assets_id',true),'user_id'=>$this->input->post('user_id',true),'role_type'=>2]);
                            
                        }else
                        {
                            $dataArray = [];
                            $dataArray['d_by'] = $this->input->post('d_by',true);
                            $dataArray['d_date'] = date('Y-m-d H:i:s');
                            $dataArray['status'] = 0;
                            $dataArray['d_by'] = $this->input->post('c_by',true);
                            $dataArray['d_date'] = date('Y-m-d H:i:s');
                            $this->SiteUser_Allotment_model->assign_UserUpdate($dataArray,['company_id'=>$this->input->post('company_id',true),'assets_id'=>$this->input->post('assets_id',true),'user_id'=>$this->input->post('user_id',true),'role_type'=>2,'status'=>1]);

                            foreach($assign_area as $key=>$value)
                            {

                                $site = $this->SiteUser_Allotment_model->getAll_site($this->input->post('company_id',true),$this->input->post('assets_id',true),$value);
                                // print_r($site);die; 
                                foreach ($site as $key => $value1) 
                                {
                                    $S_id = $value1['id'];
                                    $W_id = $value1['well_id'];

                                    $id = $this->SiteUser_Allotment_model->getsite_userId();
                                   
                                    $dataArray = [];
                                    $dataArray['id'] = $id[0]['UUID()'];
                                    $dataArray['company_id'] = $this->input->post('company_id',true);
                                    $dataArray['user_id'] = $this->input->post('user_id',true);
                                    $dataArray['role_type'] = $this->input->post('role_type',true);
                                    $dataArray['assets_id'] = $this->input->post('assets_id',true);
                                    $dataArray['area_id'] = $value;
                                    $dataArray['site_id'] = $S_id;
                                    $dataArray['well_id'] = $W_id;
                                    $dataArray['allotment_datetime'] = date('Y-m-d H:i:s');
                                    $dataArray['c_by'] = $this->input->post('c_by',true);
                                    $dataArray['c_date'] = date('Y-m-d H:i:s');
                                    $dataArray['status'] = 1;
                                    $this->SiteUser_Allotment_model->Site_UserAllotment($dataArray);
                                } 

        
                            }
                            
                        }
                    }
                    
                }

                if($role_type == 3)
                {
                    if($this->input->post('assets_id',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Assets required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }elseif($this->input->post('area_id',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Area required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }elseif($this->input->post('assign_site',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Site required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }else{
                        $assign_site = json_decode($this->input->post('assign_site',true),true);
                        if(empty($assign_site))
                        {
                           $dataArray = [];
                            $dataArray['d_by'] = $this->input->post('d_by',true);
                            $dataArray['d_date'] = date('Y-m-d H:i:s');
                            $dataArray['status'] = 0;
                            $this->SiteUser_Allotment_model->assign_UserUpdate($dataArray,['company_id'=>$this->input->post('company_id',true),'assets_id'=>$this->input->post('assets_id',true),'area_id'=>$this->input->post('area_id',true),'user_id'=>$this->input->post('user_id',true),'role_type'=>3]);
                            
                        }else
                        {
                            $dataArray = [];
                            $dataArray['d_by'] = $this->input->post('d_by',true);
                            $dataArray['d_date'] = date('Y-m-d H:i:s');
                            $dataArray['status'] = 0;
                            $dataArray['d_by'] = $this->input->post('c_by',true);
                            $dataArray['d_date'] = date('Y-m-d H:i:s');
                            $this->SiteUser_Allotment_model->assign_UserUpdate($dataArray,['company_id'=>$this->input->post('company_id',true),'assets_id'=>$this->input->post('assets_id',true),'area_id'=>$this->input->post('area_id',true),'user_id'=>$this->input->post('user_id',true),'role_type'=>3,'status'=>1]);

                            foreach($assign_site as $key=>$value)
                            {

                                $well = $this->SiteUser_Allotment_model->getAll_Well($this->input->post('company_id',true),$this->input->post('assets_id',true),$this->input->post('area_id',true),$value);
                                // print_r($well);die; 
                                foreach ($well as $key => $value1) 
                                {
                                    $W_id = $value1['id'];

                                    $id = $this->SiteUser_Allotment_model->getsite_userId();
                               
                                    $dataArray = [];
                                    $dataArray['id'] = $id[0]['UUID()'];
                                    $dataArray['company_id'] = $this->input->post('company_id',true);
                                    $dataArray['user_id'] = $this->input->post('user_id',true);
                                    $dataArray['role_type'] = $this->input->post('role_type',true);
                                    $dataArray['assets_id'] = $this->input->post('assets_id',true);
                                    $dataArray['area_id'] = $this->input->post('area_id',true);
                                    $dataArray['site_id'] = $value;
                                    $dataArray['well_id'] = $W_id;
                                    $dataArray['allotment_datetime'] = date('Y-m-d H:i:s');
                                    $dataArray['c_by'] = $this->input->post('c_by',true);
                                    $dataArray['c_date'] = date('Y-m-d H:i:s');
                                    $dataArray['status'] = 1;
                                    $this->SiteUser_Allotment_model->Site_UserAllotment($dataArray);   
                                }     
                            }
                            
                        }
                    }
                    
                }

                $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Alloted !!','response_code'=>REST_Controller::HTTP_OK]);
            } catch (Exception $e) {
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
    }

    // ============ code for assets ==========================
    public function get_asset_for_allotment_post()
    {
        try{
            $user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
            $company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
            $assign_assets = $this->SiteUser_Allotment_model->getAssignAssetList($user_id,$company_id);
            $result_data = $this->SiteUser_Allotment_model->get_assets_list_to_allot($company_id);
            $this->response(['status'=>true,'data'=>$result_data,'assign_assets'=>$assign_assets,'msg'=>'successfully','response_code' => REST_Controller::HTTP_OK]);
        }catch(Exception $e)
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !','response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    // ============ code for area ==========================
    public function get_area_for_allotment_post()
    {
        try{
            $user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
            $company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
            $assets_id = $this->input->post('assets_id',true)!=""?$this->input->post('assets_id',true):"";
            $assign_area = $this->SiteUser_Allotment_model->getAssignAreaList($user_id,$company_id,$assets_id);
            $result_data = $this->SiteUser_Allotment_model->get_area_list_to_allot($company_id,$assets_id);
            $this->response(['status'=>true,'data'=>$result_data,'assign_area'=>$assign_area,'msg'=>'successfully','response_code' => REST_Controller::HTTP_OK]);
        }catch(Exception $e)
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !','response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    // ============ code for Site ==========================
    public function get_site_for_allotment_post()
    {
        try{
            $user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
            $company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
            $assets_id = $this->input->post('assets_id',true)!=""?$this->input->post('assets_id',true):"";
            $area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
            $assign_site = $this->SiteUser_Allotment_model->getAssignSiteList($user_id,$company_id,$assets_id,$area_id);
            $result_data = $this->SiteUser_Allotment_model->get_Site_list_to_allot($company_id,$assets_id,$area_id);
            $this->response(['status'=>true,'data'=>$result_data,'assign_site'=>$assign_site,'msg'=>'successfully','response_code' => REST_Controller::HTTP_OK]);
        }catch(Exception $e)
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !','response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }


}
?>