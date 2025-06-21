<?php
require APPPATH.'libraries/REST_Controller.php';
class Device_install_data extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Device_install_data_model');
	}

    public function AddDevice_Installation_Data_post()
	{
        $device_name = $this->input->post('device_name',true);
        $imei_no = $this->input->post('imei_no',true);
        $sim_no = $this->input->post('sim_no',true);
        $sim_provider = $this->input->post('sim_provider',true);
        $network_type = $this->input->post('network_type',true);
        $lat = $this->input->post('lat',true);
        $long = $this->input->post('long',true);
        $feeder_id = $this->input->post('feeder_id',true);
          
       	if($this->input->post('company_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Company Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('installed_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'User required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('assets_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Assets required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('area_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Area required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('site_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Site required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('well_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Well required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('device_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Device required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z-0-9-]*$/",$device_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Device not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('imei_no',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'IMEI required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z-0-9]{10,20}$/",$imei_no))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'IMEI should be 10 to 20 digits !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('sim_provider',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Sim required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[1-3]{1}$/",$sim_provider))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Sim type should be 1 or 2 allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('network_type',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'N Type required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[1-3]{1}$/",$network_type))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'N Type should be 1,2 or 3 allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('lat',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Latitude required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-9.]*$/",$lat))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Latitude not valid !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('long',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Longitude required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-9.]*$/",$long))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Longitude not valid !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('c_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
					$verify = $this->Device_install_data_model->CheckImei_no_Exist($this->input->post('imei_no',true));
					// print_r($verify);die;
					if($verify == 0)
					{

						$verifyWell = $this->Device_install_data_model->CheckWell_id_Exist($this->input->post('well_id',true));
						// print_r($verifyWell);die;
						if($verifyWell == 0)
                        {

					        $id = $this->Device_install_data_model->getInstall_id();
						    $data = [];
							$data['id'] = $id[0]['UUID()'];
							$data['company_id'] = $this->input->post('company_id',true);
							$data['installed_by'] = $this->input->post('installed_by',true);
							$data['assets_id'] = $this->input->post('assets_id',true);
							$data['area_id'] = $this->input->post('area_id',true);
							$data['site_id'] = $this->input->post('site_id',true);
							$data['feeder_id'] = $this->input->post('feeder_id',true);
							$data['well_id'] = $this->input->post('well_id',true);
							$data['device_name'] = $this->input->post('device_name',true);
							$data['imei_no'] = $this->input->post('imei_no',true);
							$data['sim_no'] = $this->input->post('sim_no',true);
							$data['sim_provider'] = $this->input->post('sim_provider',true);
							$data['network_type'] = $this->input->post('network_type',true);
							$data['date_of_installation'] = date('Y-m-d H:i:s');
							$data['lat'] = $this->input->post('lat',true);
							$data['long'] = $this->input->post('long',true);
							$data['cby'] = $this->input->post('c_by',true);
							$data['cdate'] = date('Y-m-d H:i:s');
							$data['status'] = 1;

							$this->Device_install_data_model->Add_InstallationData($data);

							$this->Device_install_data_model->WellWiseDevice_installation_Status(['device_setup_status'=>1,'device_setup_datetime'=>date('Y-m-d H:i:s')],['id'=>$data['well_id']]);

							$this->Device_install_data_model->Update_Setupstatus(['device_setup_status'=>2,'device_setup_datetime'=>date('Y-m-d H:i:s'),'d_by'=>$data['cby'],'d_date'=>date('Y-m-d H:i:s')],['imei_no'=>$data['imei_no']]);

							$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Installation Done.!!','response_code'=>REST_Controller::HTTP_OK]);
						}else{
			
						    $data = [];
							
							$data['device_name'] = $this->input->post('device_name',true);
							$data['imei_no'] = $this->input->post('imei_no',true);
							$data['sim_no'] = $this->input->post('sim_no',true);
							$data['sim_provider'] = $this->input->post('sim_provider',true);
							$data['network_type'] = $this->input->post('network_type',true);
							$data['feeder_id'] = $this->input->post('feeder_id',true);
							$data['date_of_installation'] = date('Y-m-d H:i:s');
							$data['lat'] = $this->input->post('lat',true);
							$data['long'] = $this->input->post('long',true);
							$data['dby'] = $this->input->post('c_by',true);
							$data['ddate'] = date('Y-m-d H:i:s');
							$data['device_shifted'] = 0;
							$data['status'] = 1;

							$this->Device_install_data_model->Update_WellData($data,['well_id'=>$this->input->post('well_id',true)]);

							$this->Device_install_data_model->WellWiseDevice_installation_Status(['device_setup_status'=>1,'device_setup_datetime'=>date('Y-m-d H:i:s')],['id'=>$this->input->post('well_id',true)]);

							$this->Device_install_data_model->Update_Setupstatus(['device_setup_status'=>2,'device_setup_datetime'=>date('Y-m-d H:i:s'),'d_by'=>$data['dby'],'d_date'=>date('Y-m-d H:i:s')],['imei_no'=>$data['imei_no']]);

							$reinstall = [];
							$reinstall['well_id'] = $this->input->post('well_id',true);
							$reinstall['installtion_date'] = date('Y-m-d H:i:s');
							$reinstall['status'] = 1;
							$this->Device_install_data_model->Save_details($reinstall);

							$checkAllotWell = $this->Device_install_data_model->CheckAllot_WellExist($this->input->post('well_id',true));
							if($checkAllotWell[0]['total'] == 1)
						    {
						    	$UpD = [];
						    	$UpD['d_by'] = $this->input->post('c_by',true);
							    $UpD['re_installation_date_time'] = date('Y-m-d H:i:s');
							    $UpD['d_date'] = date('Y-m-d H:i:s');
							    $UpD['re_install_status'] = 1;
						    	
						    	$this->Device_install_data_model->Update_Reinstall_Devicestatus($UpD,['well_id'=>$this->input->post('well_id')]);
						    }
						
							$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Installation Done.!!','response_code'=>REST_Controller::HTTP_OK]);
						}
						
					}else{
						$this->response(['status'=>false,'data'=>[],'msg'=>'IMEI Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}
				
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }
}
?>
