<?php
require APPPATH.'libraries/REST_Controller.php';
class Master extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Master_model');
         $this->load->model('Selfflow_dashboard_model');
	}

	public function CountryList_post()
    {
        try {
            $result = $this->Master_model->CountryList();

            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }
    public function WellList_forDashboard_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
            $site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
            $result = $this->Master_model->getWelllist($company_id,$assets_id,$user_id,$well_id,$site_id);

            $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }
      public function getItemListforinstall_post()
    {
        try{
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $item_id = $this->input->post('item_id',true)!=''?$this->input->post('item_id',true):'';
            $result = $this->Master_model->getItemListforinstall($company_id,$user_id,$item_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }
    
    public function StateList_post()
    {
        try {
            $country_code = $this->input->post('country_code',true)!=''?$this->input->post('country_code',true):'';
            $result = $this->Master_model->State_List($country_code);

            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function Company_list_post()
    {
        try {
            $result = $this->Master_model->companyList();
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function Component_list_post()
    {
        try {
            $result = $this->Master_model->ComponentList();
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function Site_list_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
            $result = $this->Master_model->Site_List($company_id,$area_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function Device_list_for_company_post()
    {
        try {
            
            $result = $this->Master_model->Device_list_for_company();
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }



    public function User_list_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $result = $this->Master_model->user_List($company_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function Assets_list_post()
    {
        try {
            $id = $this->input->post('id',true)!=''?$this->input->post('id',true):'';
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            
            $result = $this->Master_model->AssetsList($id,$company_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function Arealist_post()
    {
        try {
            $id = $this->input->post('id',true)!=''?$this->input->post('id',true):'';
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
            $result = $this->Master_model->AreaList($id,$company_id,$assets_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    } 

    public function areaWiseSite_list_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
            $area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';

            $result = $this->Master_model->Area_WiseSite_List($company_id,$assets_id,$area_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function Well_list_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
            $area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
            $well_type=$this->input->post('well_type',true)!=''?$this->input->post('well_type',true):'';
            $site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $result = $this->Master_model->Well_List($company_id,$assets_id,$area_id,$site_id,$user_id,$well_type);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function RoleWise_User_list_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $role_type = $this->input->post('role_type',true)!=''?$this->input->post('role_type',true):'';
            $result = $this->Master_model->Rolewise_User_List($company_id,$role_type);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function AccessLog_post()
    {
        if($this->input->post('id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Id required','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('module_name',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'M Name required','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {
                $ID = $this->Master_model->getAccessId();
                $data = [];
                $data['id'] = $ID[0]['UUID()'];
                $data['user_id'] = $this->input->post('id',true);
                $data['module_name'] = $this->input->post('module_name',true);
                $data['access_date_time'] = date("Y-m-d H:i:s");
                $data['status'] = 1;
                $this->Master_model->SaveAccess_LogData($data);
                $this->response(['status'=>true,'data'=>[],'msg'=>'saved!!','response_code'=>REST_Controller::HTTP_OK]);
            } catch (Exception $e) {
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
    }

    public function Install_Well_List_post()
    {
        try {
            $result = $this->Master_model->get_install_Well_list();
            $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    // ================== code for installation ===========================
    public function get_AssetList_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $result = $this->Master_model->get_Asset_Listforinstall($company_id,$user_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

     public function get_Area_List_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
            $result = $this->Master_model->get_Area_Listforinstall($company_id,$user_id,$assets_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function getSite_List_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
            $area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
            $result = $this->Master_model->getSite_Listforinstall($company_id,$user_id,$assets_id,$area_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function getWell_List_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
            $area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
            $site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
            $result = $this->Master_model->getWell_Listforinstall($company_id,$user_id,$assets_id,$area_id,$site_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function get_well_list_for_installtion_post()
    {
        try {
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
            $area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
            $site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
            $well_type = $this->input->post('well_type',true)!=''?$this->input->post('well_type',true):'';
            $result = $this->Master_model->get_self_flow_Well_Listforinstall($user_id,$assets_id,$area_id,$site_id,$well_type);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function getinstallation_DeviceList_post()
    {
        try{
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $result = $this->Master_model->getDeviceListforinstall($company_id,$user_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    // ================== replacement code =================

    public function Device_Listfor_replacement_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
            $area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
            $site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
            $well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
            $result = $this->Master_model->Device_Listfor_Replacement($company_id,$user_id,$assets_id,$area_id,$site_id,$well_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function get_AssetList_for_replacement_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $installed_by = $this->input->post('installed_by',true)!=''?$this->input->post('installed_by',true):'';
            $result = $this->Master_model->get_Asset_List_for_replacement($company_id,$installed_by);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function getAreaList_forreplacement_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $installed_by = $this->input->post('installed_by',true)!=''?$this->input->post('installed_by',true):'';
            $assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
            $result = $this->Master_model->getArea_List_forreplacement($company_id,$installed_by,$assets_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function getSiteList_forreplacement_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $installed_by = $this->input->post('installed_by',true)!=''?$this->input->post('installed_by',true):'';
            $assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
            $area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
            $result = $this->Master_model->getSiteList_forreplacement($company_id,$installed_by,$assets_id,$area_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function getWellList_forreplacement_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $installed_by = $this->input->post('installed_by',true)!=''?$this->input->post('installed_by',true):'';
            $assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
            $area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
            $site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
            $result = $this->Master_model->getWellList_forreplacement($company_id,$installed_by,$assets_id,$area_id,$site_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    // ======================= shifting code starts ===================

    public function get_from_wellList_for_shifting_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $result = $this->Master_model->get_from_WellList_for_shifting_model($company_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }


    public function get_to_wellList_for_shifting_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $result = $this->Master_model->get_to_WellList_for_shifting_model($company_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function get_well_list_for_report_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $result = $this->Master_model->get_well_list_for_report_model($company_id,$user_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function get_well_list_for_Complain_raised_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $result = $this->Master_model->get_well_for_complain_raised($company_id,$user_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

     // ================== code for integartion ===========================
    
    public function get_AssetList_Data_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $result = $this->Master_model->get_Asset_List_data($company_id,$user_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

     public function get_Area_List_Data_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
            $result = $this->Master_model->get_Area_Listdata($company_id,$user_id,$assets_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function get_Site_List_Data_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
            $area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
            $result = $this->Master_model->getSite_ListData($company_id,$user_id,$assets_id,$area_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }


    // well type 

    public function get_well_type_List_post()
    {
        try {
            $company_id = $this->input->post('company_id', true) != '' ? $this->input->post('company_id', true) : '';
            $well_type_id = $this->input->post('well_type_id', true);
            $result = $this->Master_model->getwell_typelistData($company_id, $well_type_id);

            $this->response(['status' => true,'data' => $result,'msg' => 'Successfully Fetched!!','response_code' => REST_Controller::HTTP_OK ]);
        } catch (Exception $e) {$this->response([ 'status' => false,'data' => [],'msg' => 'Something went wrong!!','response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR ]);
        }
    }

    public function Not_installedTag_List_post()
    {
        try {
            
            $company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
            $component_id = $this->input->post('component_id',true)!=""?$this->input->post('component_id',true):"";
            $result = $this->Master_model->Not_installedTagList($company_id,$component_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        } 
    }

    public function Install_self_flow_Well_List_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $result = $this->Master_model->get_install_self_Well_list($company_id,);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function Install_Well_details_for_removed_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $remove_type = $this->input->post('remove_type',true)!=''?$this->input->post('remove_type',true):'';
            $well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
            $result = $this->Master_model->get_install_Well_for_removed_list($company_id,$remove_type,$well_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }


}
?>
