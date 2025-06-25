<?php
require APPPATH.'libraries/REST_Controller.php';
require APPPATH . 'controllers/api/Base64fileUploads.php';
class Device_selfflow_well_installation extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Device_selfflow_installation_model');
    }

   public function Save_wellDevice_Installation_Data_post()
    {
        $well_type = $this->input->post('well_type', true);
        $device_name = $this->input->post('device_name',true);
        $imei_no = $this->input->post('imei_no',true);
        $sim_no = $this->input->post('sim_no',true);
        $sim_provider = $this->input->post('sim_provider',true);
        $network_type = $this->input->post('network_type',true);
        $well_id = $this->input->post('well_id',true);
        $lat = $this->input->post('lat',true);
        $long = $this->input->post('long',true);
   

        if ($this->input->post('well_type') == '') 
        {
            $this->response(['status' => false,'data' => [],'msg' => 'Well type required!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        
        }elseif(!preg_match("/^[1-3]{1}$/",$well_type))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Well type should be 1,2 or 3 allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('company_id',true) == '')
        {
                $this->response(['status'=>false,'data'=>[],'msg'=>'Company required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
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
            $this->response(['status'=>false,'data'=>[],'msg'=>'Network Type required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match("/^[1-3]{1}$/",$network_type))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Network Type should be 1,2 or 3 allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('tag_data', true) == '') {
            $this->response(['status' => false,'data' => [],'msg' => 'Tag Data required!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('c_by',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Created By required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {
   

                $verify_wellformula = $this->Device_selfflow_installation_model->CheckWell_formula_Exist($well_type);
                if ($verify_wellformula == 0) {
                    $this->response(['status' => false,'data' => [],'msg' => 'Well Formula not exist!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                }

                $well_details = $this->Device_selfflow_installation_model->get_well_formula_list($well_type);

                $image = '';
                if ($this->input->post('image', true) != '') {
                    $base64file = new Base64fileUploads();
                    $imgData = str_replace(' ', '+', $this->input->post('image', true));
                    $image = $base64file->du_uploads('album/', $imgData);
                }

                $tagData = json_decode($this->input->post('tag_data', true), true);

                $tagCounts = [];
                $validTagData = [];
                foreach ($tagData as $tag) {
                    if (!empty($tag['tag_number'])) {
                        $compId = $tag['component_id'];
                        $tagCounts[$compId] = isset($tagCounts[$compId]) ? $tagCounts[$compId] + 1 : 1;
                        $validTagData[] = $tag; 
                    }
                }

                $componentLimits = [];
                $componentNames = [];
                foreach ($well_details as $detail) {
                    $componentLimits[$detail['component_id']] = $detail['quantity_required'];
                    $componentNames[$detail['component_id']] = $detail['component_name'];
                }

                foreach ($tagCounts as $compId => $count) 
                {
                    $allowed = isset($componentLimits[$compId]) ? $componentLimits[$compId] : 0;
                    if ($count > $allowed) {
                        $this->response([
                            'status' => false,
                            'data' => [],
                            'msg' => "Tag count for component '{$componentNames[$compId]}' exceeds allowed setup quantity ({$allowed})",
                            'response_code' => REST_Controller::HTTP_BAD_REQUEST
                        ]);
                    }
                }

                $verifyWell = $this->Device_selfflow_installation_model->CheckWell_id_Exist($this->input->post('well_id', true));
                // print_r($verifyWell);die;

                if (count($verifyWell) == 0) {      

                    if($this->input->post('lat',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Latitude required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }elseif($this->input->post('long',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Longitude required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }elseif(!preg_match("/^[0-9.]*$/",$lat))
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Latitude should be decimal allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }elseif(!preg_match("/^[0-9.]*$/",$long))
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Longitude should be decimal allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }       

                // Save installation data
                    $id = $this->Device_selfflow_installation_model->get_Ins_id();

                    $data = [
                        'id' => $id[0]['UUID()'],
                        'well_type' => $well_type,
                        'company_id' => $this->input->post('company_id', true),
                        'installed_by' => $this->input->post('installed_by', true),
                        'assets_id' => $this->input->post('assets_id', true),
                        'area_id' => $this->input->post('area_id', true),
                        'site_id' => $this->input->post('site_id', true),
                        'well_id' => $this->input->post('well_id', true),
                        'device_name' => $this->input->post('device_name', true),
                        'imei_no' => $imei_no,
                        'sim_no' => $this->input->post('sim_no', true),
                        'sim_provider' => $this->input->post('sim_provider', true),
                        'network_type' => $this->input->post('network_type', true),
                        'image' => $image,
                        'well_installation_status' => 1,
                        'no_of_installed_sensor' => count($validTagData),
                        'date_time' => date('Y-m-d H:i:s'),
                        'c_by' => $this->input->post('c_by', true),
                        'c_date' => date('Y-m-d H:i:s'),
                        'status' => 1
                    ];

                    $verifyRecord = $this->Device_selfflow_installation_model->Save_Installation_Data($data);
                    if ($verifyRecord == 200) 
                    {


                        $this->Device_selfflow_installation_model->Well_Wise_Device_installation_Status(['lat'=>$lat,'long'=>$long,'device_setup_status'=>1,'device_setup_datetime'=>date('Y-m-d H:i:s')],['id'=>$well_id]);

                        // Save tag details
                        foreach ($tagData as $value) {
                            if (!empty($value['tag_number'])) { 
                                $sensorData = [
                                    'installation_id' => $id[0]['UUID()'],
                                    'well_id' => $this->input->post('well_id', true),
                                    'well_type' => $well_type,
                                    'component_id' => $value['component_id'],
                                    'sensor_no' => $value['tag_number'],
                                    'from_date_time' => date('Y-m-d H:i:s'),
                                    'c_by' => $this->input->post('c_by', true),
                                    'c_date' => date('Y-m-d H:i:s'),
                                    'status' => 1
                                ];

                                $this->Device_selfflow_installation_model->Save_Tag_Detail($sensorData);

                                $this->Device_selfflow_installation_model->update_Tag_installation_status(
                                    ['installation_status' => 1, 'installation_date_time' => date('Y-m-d H:i:s')],
                                    ['component_id' => $value['component_id'], 'tag_number' => $value['tag_number']]
                                );
                            }
                        }


                        $datalog = [];
                                
                        $datalog['well_type'] = $this->input->post('well_type',true);
                        $datalog['installation_id'] = $id[0]['UUID()'];
                        $datalog['company_id'] = $this->input->post('company_id',true);
                        $datalog['installed_by'] = $this->input->post('installed_by',true);
                        $datalog['assets_id'] = $this->input->post('assets_id',true);
                        $datalog['area_id'] = $this->input->post('area_id',true);
                        $datalog['site_id'] = $this->input->post('site_id',true);
                        $datalog['well_id'] = $this->input->post('well_id',true);
                        $datalog['device_name'] = $this->input->post('device_name',true);
                        $datalog['imei_no'] = $this->input->post('imei_no',true);
                        $datalog['sim_no'] = $this->input->post('sim_no',true);
                        $datalog['sim_provider'] = $this->input->post('sim_provider',true);
                        $datalog['network_type'] = $this->input->post('network_type',true);
                        $datalog['well_installation_status'] = 1;
                        $datalog['image'] = $image;
                        $datalog['no_of_installed_sensor'] = count($validTagData);
                        $datalog['from_date_time'] = date('Y-m-d H:i:s');
                        $datalog['c_by'] = $this->input->post('c_by',true);
                        $datalog['c_date'] = date('Y-m-d H:i:s');
                        $datalog['status'] = 1;
                        $this->Device_selfflow_installation_model->SaveWell_installationlog($datalog);

                        $this->response(['status' => true,'data' => [],'msg' => 'Successfully Installation Done!!','response_code' => REST_Controller::HTTP_OK]);

                    } else {
                        $this->response(['status' => false,'data' => [],'msg' => 'Data not available!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                    }
                }else{

                    $this->response(['status' => false,'data' => [],'msg' => 'Well Already  Installed!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                   
                }

            } catch (Exception $e) {
                $this->response(['status' => false,'data' => [],'msg' => 'Something went wrong!','response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }

        }
    }
    public function save_device_andtag_removal_data_post()
    {
        $removal_type = $this->input->post('removal_type',true);
        $well_id = $this->input->post('well_id',true);
        $device_name = $this->input->post('device_name',true);
        $imei_no = $this->input->post('imei_no',true);
        $c_by = $this->input->post('c_by',true);

        if($this->input->post('removal_type',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Removal Type required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match("/^[1-3]{1}$/",$removal_type))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Removal type should be integer and 1,2 and 3 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('well_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Well required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('c_by',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Created By required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try{

                $verifyWell_data  = $this->Device_selfflow_installation_model->CheckWell_id_Exist($this->input->post('well_id',true));
                
                if($removal_type == 1)
                {
                    if($this->input->post('device_name',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Device required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }elseif($this->input->post('imei_no',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'IMEI No required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }elseif(!preg_match("/^[a-zA-Z0-9]{10,20}$/",$imei_no))
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'From IMEI should be 10 to 20 digit and character allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }

                    // print_r($verifyWell_data);die;

                    if(count($verifyWell_data) > 0 && $verifyWell_data[0]['imei_no'] !=null)
                    {


                        $data = [];
                        $data['device_name'] = null;
                        $data['imei_no'] = null;
                        $data['well_setup_status'] = 2;
                        $data['well_installation_status'] = 2;
                        $data['date_time'] = date('Y-m-d H:i:s');
                        $data['d_by'] = $c_by;
                        $data['d_date'] = date('Y-m-d H:i:s');

                        $this->Device_selfflow_installation_model->update_well_removal_record($data,['well_id'=>$well_id]);

                        $this->Device_selfflow_installation_model->update_installation_device_logData(['well_installation_status'=>2,'to_date_time'=>date('Y-m-d H:i:s'),'well_setup_status'=>2],['well_id'=>$well_id,'well_setup_status'=>1]);

                        $datalog = [];
                        $datalog['company_id'] = $verifyWell_data[0]['company_id'];
                        $datalog['installation_id'] = $verifyWell_data[0]['id'];
                        $datalog['installed_by'] = $this->input->post('c_by', true);
                        $datalog['assets_id'] = $verifyWell_data[0]['assets_id'];
                        $datalog['area_id'] = $verifyWell_data[0]['area_id'];
                        $datalog['site_id'] = $verifyWell_data[0]['site_id'];
                        $datalog['well_id'] = $this->input->post('well_id',true);
                        $datalog['well_type'] = $verifyWell_data[0]['well_type'];
                        $datalog['device_name'] = null;
                        $datalog['imei_no'] = null;
                        $datalog['no_of_installed_sensor'] = $verifyWell_data[0]['no_of_installed_sensor'];
                        $datalog['sim_no'] = $verifyWell_data[0]['sim_no'];
                        $datalog['network_type'] = $verifyWell_data[0]['network_type'];
                        $datalog['sim_provider'] = $verifyWell_data[0]['sim_provider'];
                        $datalog['from_date_time'] = date('Y-m-d H:i:s');
                        $datalog['c_by'] = $this->input->post('c_by', true);
                        $datalog['c_date'] = date('Y-m-d H:i:s');
                        $datalog['status'] = 1;

                        $this->Device_selfflow_installation_model->SaveWell_installationlog($datalog);


                        $this->response(['status' => true,'data' => [],'msg' => 'Successfully Device Removed!!','response_code' => REST_Controller::HTTP_OK]);

                        
                    }else{
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Device Record Not Found!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }

                }
                elseif($removal_type == 2)
                {
                    $tagData = json_decode($this->input->post('tag_data', true), true);
                    if($this->input->post('tag_data',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Tag Data required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }
                
                    if(count($verifyWell_data) > 0 && $verifyWell_data[0]['no_of_installed_sensor'] != 0 )
                    {
                        
                        // print_r($well_details);die;

                        $tagCounts = [];

                            foreach ($tagData as $key => $value) {

                                $compId = $value['component_id'];
                                $tagCounts[$compId] = isset($tagCounts[$compId]) ? $tagCounts[$compId] + 1 : 1;
                                $tagUpdateData = [];
                                $tagUpdateData['tag_status'] = 0;
                                $tagUpdateData['to_date_time'] = date('Y-m-d H:i:s');
                                $tagUpdateData['d_by'] = $c_by;
                                $tagUpdateData['d_date'] = date('Y-m-d H:i:s');

                                $this->Device_selfflow_installation_model->UpdateRemoved_sensorStatus(
                                    $tagUpdateData,
                                    [
                                        'well_id' => $well_id,
                                        'component_id' => $value['component_id'],
                                        'sensor_no' => $value['tag_number'],
                                        'tag_status' => 1
                                    ]
                                );

                                $this->Device_selfflow_installation_model->update_Tag_installation_status(
                                    ['installation_status' => 0, 'installation_date_time' => null],
                                    [
                                        'component_id' => $value['component_id'],
                                        'tag_number' => $value['tag_number'],
                                        'installation_status' => 1
                                    ]
                                );
                            }

                        $data = [];
                        $data['no_of_installed_sensor'] = (int) ($verifyWell_data[0]['no_of_installed_sensor'] - array_sum($tagCounts));
                        $data['well_installation_status'] = 3;
                        $data['date_time'] = date('Y-m-d H:i:s');
                        $data['d_by'] = $c_by;
                        $data['d_date'] = date('Y-m-d H:i:s');
                        
                        $this->Device_selfflow_installation_model->update_well_removal_record($data,['well_id'=>$well_id]);
                            
                        $this->Device_selfflow_installation_model->update_installation_device_logData(['well_installation_status'=>3,'to_date_time'=>date('Y-m-d H:i:s'),'well_setup_status'=>2],['well_id'=>$well_id,'well_setup_status'=>1]);

                        $datalog = [];
                        $datalog['company_id'] = $verifyWell_data[0]['company_id'];
                        $datalog['installation_id'] = $verifyWell_data[0]['id'];
                        $datalog['installed_by'] = $this->input->post('c_by', true);
                        $datalog['assets_id'] = $verifyWell_data[0]['assets_id'];
                        $datalog['area_id'] = $verifyWell_data[0]['area_id'];
                        $datalog['site_id'] = $verifyWell_data[0]['site_id'];
                        $datalog['well_id'] = $this->input->post('well_id',true);
                        $datalog['well_type'] = $verifyWell_data[0]['well_type'];
                        $datalog['device_name'] = $verifyWell_data[0]['device_name'];
                        $datalog['imei_no'] = $verifyWell_data[0]['imei_no'];
                        $datalog['no_of_installed_sensor'] = $data['no_of_installed_sensor'];
                        $datalog['sim_no'] = $verifyWell_data[0]['sim_no'];
                        $datalog['network_type'] = $verifyWell_data[0]['network_type'];
                        $datalog['sim_provider'] = $verifyWell_data[0]['sim_provider'];
                        $datalog['from_date_time'] = date('Y-m-d H:i:s');
                        $datalog['c_by'] = $this->input->post('c_by', true);
                        $datalog['c_date'] = date('Y-m-d H:i:s');
                        $datalog['status'] = 1;

                        // print_r($datalog);die;

                        $this->Device_selfflow_installation_model->SaveWell_installationlog($datalog);

                        $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Tag Removed!!','response_code'=>REST_Controller::HTTP_OK]);

                    }else{
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Tag Record not found!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }

                }
                elseif($removal_type == 3)
                {
                    if($this->input->post('device_name',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Device required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }elseif($this->input->post('imei_no',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'IMEI No required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }elseif(!preg_match("/^[a-zA-Z0-9]{10,20}$/",$imei_no))
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'From IMEI should be 10 to 20 digit and character allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }elseif($this->input->post('tag_data',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Tag Data required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }

                    $tagData = json_decode($this->input->post('tag_data', true), true);

                    $data = [];
                    $data['device_name'] = null;
                    $data['imei_no'] = null;
                    $data['no_of_installed_sensor'] = 0;
                    $data['well_installation_status'] = 4;
                    $data['well_setup_status'] = 2;
                    $data['date_time'] = date('Y-m-d H:i:s');
                    $data['d_by'] = $c_by;
                    $data['d_date'] = date('Y-m-d H:i:s');

                    $this->Device_selfflow_installation_model->update_well_removal_record($data,['well_id'=>$well_id]);

                    $this->Device_selfflow_installation_model->update_installation_device_logData(['well_installation_status'=>4,'to_date_time'=>date('Y-m-d H:i:s'),'well_setup_status'=>2],['well_id'=>$well_id,'well_setup_status'=>1]);

                    foreach ($tagData as $key => $value) {

                        $tagData = [];
                        $tagData['tag_status'] = 0;
                        $tagData['to_date_time'] = date('Y-m-d H:i:s');
                        $tagData['d_by'] = $c_by;
                        $tagData['d_date'] = date('Y-m-d H:i:s');

                        $this->Device_selfflow_installation_model->UpdateRemoved_sensorStatus($tagData,['well_id'=>$well_id,'component_id'=>$value['component_id'],'sensor_no'=>$value['tag_number'],'tag_status'=>1]);


                        $this->Device_selfflow_installation_model->update_Tag_installation_status(['installation_status'=>0,'installation_date_time'=>null],['component_id'=>$value['component_id'],'tag_number'=>$value['tag_number'],'installation_status'=>1]);

                    }

                    $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Device and Tag Removed!!','response_code'=>REST_Controller::HTTP_OK]);

                }
                else{
                    $this->response(['status'=>false,'data'=>[],'msg'=>'Removal Type not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                }

            }catch(Exception $ex){
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
    }

    public function save_device_and_tag_re_installtion_data_post()
    {
    
        $reinstallation_type = $this->input->post('reinstallation_type',true);
        $well_id = $this->input->post('well_id',true);
        $device_name = $this->input->post('device_name',true);
        $imei_no = $this->input->post('imei_no',true);
        $c_by = $this->input->post('c_by',true);

        if($this->input->post('reinstallation_type',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Re-installation Type required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match("/^[1-2]{1}$/",$reinstallation_type))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Re-installation type should be integer and 1,2 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('well_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Well required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('c_by',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Created By required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try{

                $verifyWell_data  = $this->Device_selfflow_installation_model->CheckWell_id_Exist($this->input->post('well_id',true));
                
                if($reinstallation_type == 1)
                {
                    if($this->input->post('device_name',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Device required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }elseif($this->input->post('imei_no',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'IMEI No required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }elseif(!preg_match("/^[a-zA-Z0-9]{10,20}$/",$imei_no))
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'From IMEI should be 10 to 20 digit and character allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }

                    // print_r($verifyWell_data);die;

                    if(count($verifyWell_data) > 0 && $verifyWell_data[0]['imei_no'] ==null)
                    {


                        $data = [];
                        $data['device_name'] = $this->input->post('device_name',true);
                        $data['imei_no'] = $this->input->post('imei_no',true); 
                        $data['well_installation_status'] = 5;
                        $data['well_setup_status'] = 1;
                        $data['date_time'] = date('Y-m-d H:i:s');
                        $data['d_by'] = $c_by;
                        $data['d_date'] = date('Y-m-d H:i:s');

                        $this->Device_selfflow_installation_model->update_well_reinstallation_record($data,['well_id'=>$well_id]);

                        $this->Device_selfflow_installation_model->update_installation_device_logData(['well_installation_status'=>5,'to_date_time'=>date('Y-m-d H:i:s'),'well_setup_status'=>2],['well_id'=>$well_id,'well_setup_status'=>1]);

                        $datalog = [];
                        $datalog['company_id'] = $verifyWell_data[0]['company_id'];
                        $datalog['installation_id'] = $verifyWell_data[0]['id'];
                        $datalog['installed_by'] = $this->input->post('c_by', true);
                        $datalog['assets_id'] = $verifyWell_data[0]['assets_id'];
                        $datalog['area_id'] = $verifyWell_data[0]['area_id'];
                        $datalog['site_id'] = $verifyWell_data[0]['site_id'];
                        $datalog['well_id'] = $this->input->post('well_id',true);
                        $datalog['well_type'] = $verifyWell_data[0]['well_type'];
                        $datalog['device_name'] = $this->input->post('device_name',true);
                        $datalog['imei_no'] = $this->input->post('imei_no',true);
                        $datalog['no_of_installed_sensor'] = $verifyWell_data[0]['no_of_installed_sensor'];
                        $datalog['sim_no'] = $verifyWell_data[0]['sim_no'];
                        $datalog['network_type'] = $verifyWell_data[0]['network_type'];
                        $datalog['sim_provider'] = $verifyWell_data[0]['sim_provider'];
                        $datalog['from_date_time'] = date('Y-m-d H:i:s');
                        $datalog['c_by'] = $this->input->post('c_by', true);
                        $datalog['c_date'] = date('Y-m-d H:i:s');
                        $datalog['status'] = 1;

                        $this->Device_selfflow_installation_model->SaveWell_installationlog($datalog);


                        $this->response(['status' => true,'data' => [],'msg' => 'Successfully Device Re-installation!!','response_code' => REST_Controller::HTTP_OK]);

                        
                    }else{
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Device Already Installed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }

                }
                elseif($reinstallation_type == 2)
                {
                    $verify_wellformula = $this->Device_selfflow_installation_model->check_well_formula_count($verifyWell_data[0]['well_type']);

                    $tagData = json_decode($this->input->post('tag_data', true), true);
                    if($this->input->post('tag_data',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Tag Data required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }

                    $id = $this->Device_selfflow_installation_model->get_Ins_id();

                    if ((int)$verifyWell_data[0]['no_of_installed_sensor'] >= (int)$verify_wellformula) {
                        $this->response([
                            'status' => false,
                            'data' => [],
                            'msg' => 'All sensors already installed for this well. No more sensors can be added.',
                            'response_code' => REST_Controller::HTTP_BAD_REQUEST
                        ]);
                    }
                
                    if(count($verifyWell_data) > 0 && $verifyWell_data[0]['no_of_installed_sensor'] >= 0 )
                    {
                        $tagCounts = 0; 

                        foreach ($tagData as $value) {
                            if (!empty($value['tag_number'])) {
                                $sensorData = [
                                    'installation_id' => $id[0]['UUID()'],
                                    'well_id' => $this->input->post('well_id', true),
                                    'well_type' =>  $verifyWell_data[0]['well_type'],
                                    'component_id' => $value['component_id'],
                                    'sensor_no' => $value['tag_number'],
                                    'from_date_time' => date('Y-m-d H:i:s'),
                                    'c_by' => $this->input->post('c_by', true),
                                    'c_date' => date('Y-m-d H:i:s'),
                                    'status' => 1
                                ];

                                $this->Device_selfflow_installation_model->Save_Tag_Detail($sensorData);

                                $this->Device_selfflow_installation_model->update_Tag_installation_status(
                                    ['installation_status' => 1, 'installation_date_time' => date('Y-m-d H:i:s')],
                                    ['component_id' => $value['component_id'], 'tag_number' => $value['tag_number']]
                                );

                                $tagCounts++; 
                            }
                        }
                        $data = [];
                        $data['no_of_installed_sensor'] = $verifyWell_data[0]['no_of_installed_sensor'] + $tagCounts;
                        $data['well_installation_status'] = 6;
                        $data['well_setup_status'] = 1;
                        $data['date_time'] = date('Y-m-d H:i:s');
                        $data['d_by'] = $c_by;
                        $data['d_date'] = date('Y-m-d H:i:s');
                        
                        $this->Device_selfflow_installation_model->update_well_reinstallation_record($data,['well_id'=>$well_id]);
                            
                        $this->Device_selfflow_installation_model->update_installation_device_logData(['well_installation_status'=>6,'to_date_time'=>date('Y-m-d H:i:s'),'well_setup_status'=>2],['well_id'=>$well_id,'well_setup_status'=>1]);

                        $datalog = [];
                        $datalog['company_id'] = $verifyWell_data[0]['company_id'];
                        $datalog['installation_id'] = $verifyWell_data[0]['id'];
                        $datalog['installed_by'] = $this->input->post('c_by', true);
                        $datalog['assets_id'] = $verifyWell_data[0]['assets_id'];
                        $datalog['area_id'] = $verifyWell_data[0]['area_id'];
                        $datalog['site_id'] = $verifyWell_data[0]['site_id'];
                        $datalog['well_id'] = $this->input->post('well_id',true);
                        $datalog['well_type'] = $verifyWell_data[0]['well_type'];
                        $datalog['device_name'] = $verifyWell_data[0]['device_name'];
                        $datalog['imei_no'] = $verifyWell_data[0]['imei_no'];
                        $datalog['no_of_installed_sensor'] = $data['no_of_installed_sensor'];
                        $datalog['sim_no'] = $verifyWell_data[0]['sim_no'];
                        $datalog['network_type'] = $verifyWell_data[0]['network_type'];
                        $datalog['sim_provider'] = $verifyWell_data[0]['sim_provider'];
                        $datalog['from_date_time'] = date('Y-m-d H:i:s');
                        $datalog['c_by'] = $this->input->post('c_by', true);
                        $datalog['c_date'] = date('Y-m-d H:i:s');
                        $datalog['status'] = 1;

                        // print_r($datalog);die;

                        $this->Device_selfflow_installation_model->SaveWell_installationlog($datalog);

                        $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Tag Re-installation!!','response_code'=>REST_Controller::HTTP_OK]);

                    }else{
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Tag Record not found!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }

                }
                else{
                    $this->response(['status'=>false,'data'=>[],'msg'=>'Re-installation Type not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                }

            }catch(Exception $ex){
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
    }

    
}
?>