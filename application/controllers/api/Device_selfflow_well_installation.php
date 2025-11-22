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
        $company_id   = $this->input->post('company_id', true);
        $installed_by = $this->input->post('installed_by', true);
        $c_by         = $this->input->post('c_by', true);
        $device_name  = $this->input->post('device_name', true);
        $imei_no      = $this->input->post('imei_no', true);
        $sim_provider = $this->input->post('sim_provider', true);
        $sim_no       = $this->input->post('sim_no', true);
        $network_type = $this->input->post('network_type', true);
        $gps_lat      = $this->input->post('latitude', true);
        $gps_long     = $this->input->post('longitude', true);
        $wells        = json_decode($this->input->post('wells', true), true);
   

        if($this->input->post('company_id',true) == '')
        {
                $this->response(['status'=>false,'data'=>[],'msg'=>'Company required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('installed_by',true) == '')
        {
                $this->response(['status'=>false,'data'=>[],'msg'=>'User required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
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
        }elseif($this->input->post('longitude',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'longitude required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('latitude',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'latitude required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('wells',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'wells required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('c_by',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Created By required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {
   

                foreach ($wells as $well) {

                    $well_id   = $well['well_id'];
                    $well_type = $well['well_type_id'];

                    $wellMaster = $this->Device_selfflow_installation_model->Get_WellMaster_By_ID($well_id);
                    if (!$wellMaster) {
                        $this->response(['status'=>false,'data'=>[],'msg'=>"Well not found",'response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }

                    $assets_id = $wellMaster['assets_id'];
                    $area_id   = $wellMaster['area_id'];
                    $site_id   = $wellMaster['site_id'];

                    $verifyWell = $this->Device_selfflow_installation_model->CheckWell_id_Exist($well_id);
                    if (count($verifyWell) > 0) {
                        $this->response(['status'=>false,'data'=>[],'msg'=>"Well Already Installed",'response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }
                   $image = '';

                    if (!empty($well['image'])) {

                        $uploadPath = 'album/';
                        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

                        $imgData = str_replace(' ', '+', $well['image']);
                        if (!preg_match('/^data:image\/(\w+);base64,/', $imgData)) {
                            if (strpos($imgData, '/') === 0 || strpos($imgData, 'iVBORw0KG') === 0) {
                                $imgData = 'data:image/png;base64,' . $imgData;
                            } elseif (strpos($imgData, '/9j/') === 0) {
                                $imgData = 'data:image/jpeg;base64,' . $imgData;
                            } else {
                                $this->response([
                                    'status' => false,
                                    'data'   => [],
                                    'response_code' => REST_Controller::HTTP_BAD_REQUEST,
                                    'msg'    => 'Invalid image format (prefix missing).'
                                ]);
                            }
                        }

                        if (preg_match('/^data:image\/(\w+);base64,/', $imgData, $match)) {

                            $ext = strtolower($match[1]);
                            $allowedTypes = ['jpg', 'jpeg', 'png'];

                            if (!in_array($ext, $allowedTypes)) {
                                $this->response([
                                    'status'=>false,
                                    'data'=>[],
                                    'response_code'=>REST_Controller::HTTP_BAD_REQUEST,
                                    'msg' => 'Only JPG, JPEG, PNG images are allowed.'
                                ]);
                            }

                            $imgData = substr($imgData, strpos($imgData, ',') + 1);
                            $imgBinary = base64_decode($imgData);

                            // 2MB limit
                            if (strlen($imgBinary) > 2 * 1024 * 1024) {
                                $this->response([
                                    'status'=>false,
                                    'data'=>[],
                                    'response_code'=>REST_Controller::HTTP_BAD_REQUEST,
                                    'msg' => 'Maximum image size allowed is 2MB.'
                                ]);
                            }

                            // Save file
                            $fileName = uniqid('well_', true) . '.' . $ext;
                            $filePath = $uploadPath . $fileName;

                            if (file_put_contents($filePath, $imgBinary)) {
                                $image = $fileName;
                            } else {
                                $this->response([
                                    'status'=>false,
                                    'data'=>[],
                                    'response_code'=>REST_Controller::HTTP_BAD_REQUEST,
                                    'msg' => 'Failed To upload image'
                                ]);
                            }
                        }
                    }


                    $sensors = $well['components'];
                    $no_of_sensor = 0;
                    foreach ($sensors as $tag) {
                        if (!empty($tag['tag_number'])) {
                           $no_of_sensor++;
                        }
                    }

                    $newId = $this->Device_selfflow_installation_model->get_Ins_id();
                    $installation_id = $newId[0]['UUID()'];

                    $data = [
                        'id' => $installation_id,
                        'well_type' => $well_type,
                        'company_id' => $company_id,
                        'installed_by' => $installed_by,
                        'assets_id' => $assets_id,
                        'area_id' => $area_id,
                        'site_id' => $site_id,
                        'well_id' => $well_id,
                        'device_name' => $device_name,
                        'imei_no' => $imei_no,
                        'sim_no' => $sim_no,
                        'sim_provider' => $sim_provider,
                        'network_type' => $network_type,
                        'image' => $image,
                        'well_installation_status' => 1,
                        'no_of_installed_sensor' => $no_of_sensor,
                        'date_time' => date('Y-m-d H:i:s'),
                        'c_by' => $c_by,
                        'c_date' => date('Y-m-d H:i:s'),
                        'status' => 1
                    ];

                    $this->Device_selfflow_installation_model->Save_Installation_Data($data);

                     $datalog = [
                        'installation_id' => $installation_id,
                        'well_type' => $well_type,
                        'company_id' => $company_id,
                        'installed_by' => $installed_by,
                        'assets_id' => $assets_id,
                        'area_id' => $area_id,
                        'site_id' => $site_id,
                        'well_id' => $well_id,
                        'device_name' => $device_name,
                        'imei_no' => $imei_no,
                        'sim_no' => $sim_no,
                        'sim_provider' => $sim_provider,
                        'network_type' => $network_type,
                        'image' => $image,
                        'well_installation_status' => 1,
                        'no_of_installed_sensor' => $no_of_sensor,
                        'from_date_time' => date('Y-m-d H:i:s'),
                        'c_by' => $c_by,
                        'c_date' => date('Y-m-d H:i:s'),
                        'status' => 1
                    ];
                                
                    $this->Device_selfflow_installation_model->SaveWell_installationlog($datalog);

                    foreach ($sensors as $tag) {

                        if (!empty($tag['tag_number'])) {
                            $compMaster = $this->Device_selfflow_installation_model->Get_Component_Master_By_ID($tag['component_id']);

                           $max_value   = $compMaster['max_value'] ?? null;
                           $upper_value = $compMaster['upper_value'] ?? null;
                           $lower_value = $compMaster['lower_value'] ?? null;
                           $multiplier  = $compMaster['multiplier'] ?? null;
                           $offset      = $compMaster['offset'] ?? null;
                            $sensorData = [
                                'installation_id' => $installation_id,
                                'well_id' => $well_id,
                                'well_type' => $well_type,
                                'component_id' => $tag['component_id'],
                                'sensor_no' => $tag['tag_number'],
                                'from_date_time' => date('Y-m-d H:i:s'),
                                'c_by' => $c_by,
                                'c_date' => date('Y-m-d H:i:s'),
                                'status' => 1
                            ];

                            $ThresholdData = [
                                'area_id' => $area_id,
                                'site_id' => $site_id,
                                'well_id' => $well_id,
                                'component_id' => $tag['component_id'],
                                'tag_no' => $tag['tag_number'],
                                'max_value'=>$max_value,
                                'upper_value'=>$upper_value,
                                'lower_value'=>$lower_value,
                                'multiplier'=>$multiplier,
                                'offset'=>$offset,
                                'c_by' => $c_by,
                                'c_date' => date('Y-m-d H:i:s'),
                                'status' => 1
                            ];

                            $this->Device_selfflow_installation_model->Save_Threshold_data($ThresholdData);


                            $ThresholdlogData = [
                                'area_id' => $area_id,
                                'site_id' => $site_id,
                                'well_id' => $well_id,
                                'component_id' => $tag['component_id'],
                                'tag_no' => $tag['tag_number'],
                                 'max_value'=>$max_value,
                                'upper_value'=>$upper_value,
                                'lower_value'=>$lower_value,
                                'multiplier'=>$multiplier,
                                'offset'=>$offset,
                                'c_by' => $c_by,
                                'c_date' => date('Y-m-d H:i:s'),
                                'status' => 1
                            ];

                            $this->Device_selfflow_installation_model->Save_Threshold_logdata($ThresholdlogData);

                            $this->Device_selfflow_installation_model->Save_Tag_Detail($sensorData);

                            $this->Device_selfflow_installation_model->update_Tag_installation_status(
                                    ['installation_status' => 1, 'installation_date_time' => date('Y-m-d H:i:s')],
                                    ['id' => $tag['tag_number']]
                                );
                        }
                    }

          
                $this->Device_selfflow_installation_model->Well_Wise_Device_installation_Status(
                    ['lat'=>$gps_lat,'long'=>$gps_long,'device_setup_status'=>1,'device_setup_datetime'=>date('Y-m-d H:i:s')],
                    ['id'=>$well_id]
                );

                $this->Device_selfflow_installation_model->Device_setup_mater(
                    ['node_scan_time'=>30,'node_log_time'=>300,'gateway_log_time'=>60,'d_date'=>date('Y-m-d H:i:s')],
                    ['imei_no'=>$imei_no]
                );
           }      

            $this->response(['status' => true,'data' => [],'msg' => 'Device Installtion Successfully!','response_code' => REST_Controller::HTTP_OK]);
                
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
                                        'id' => $value['tag_number'],
                                        'installation_status' => 1
                                    ]
                                );

                                $updateThreshold = [];
                                $updateThreshold['d_by'] = $this->input->post('c_by', true);
                                $updateThreshold['d_date'] = date("Y-m-d H:i:s");
                                $updateThreshold['status'] = 0;

                                $this->Device_selfflow_installation_model->Update_threshold_log($updateThreshold,['well_id'=>$well_id,'tag_no'=>$value['tag_number'],'status'=>1]);

                                $this->Device_selfflow_installation_model->Delete_threshold_master([
                                        'component_id' => $value['component_id'],
                                        'tag_no'       => $value['tag_number'],
                                        'well_id'      => $well_id
                                    ]);
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


                        $this->Device_selfflow_installation_model->update_Tag_installation_status(['installation_status'=>0,'installation_date_time'=>null],['tag_number'=>$value['tag_number'],'installation_status'=>1]);

                        
                          $this->Device_selfflow_installation_model->Update_threshold_log(['status'=>0,'d_date'=>date('Y-m-d H:i:s'),'d_by'=>$c_by],['component_id'=>$value['component_id'],'tag_number'=>$value['tag_number'],'well_id'=>$well_id]);

                        
                         $this->Device_selfflow_installation_model->Delete_threshold_master(['component_id'=>$value['component_id'],'tag_no'=>$value['tag_number'],'well_id'=>$well_id]);

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

                                $compMaster = $this->Device_selfflow_installation_model->Get_Component_Master_By_ID($value['component_id']);

                               $max_value   = $compMaster['max_value'] ?? null;
                               $upper_value = $compMaster['upper_value'] ?? null;
                               $lower_value = $compMaster['lower_value'] ?? null;
                               $multiplier  = $compMaster['multiplier'] ?? null;
                               $offset      = $compMaster['offset'] ?? null;
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
                                    ['id' => $value['tag_number']]
                                );

                                $tagCounts++; 
                            }

                            $ThresholdData = [
                                'area_id' => $verifyWell_data[0]['area_id'],
                                'site_id' => $verifyWell_data[0]['site_id'],
                                'well_id' => $this->input->post('well_id',true),
                                'component_id' => $value['component_id'],
                                'tag_no' => $value['tag_number'],
                                'max_value'=>$max_value,
                                'upper_value'=>$upper_value,
                                'lower_value'=>$lower_value,
                                'multiplier'=>$multiplier,
                                'offset'=>$offset,
                                'c_by' => $c_by,
                                'c_date' => date('Y-m-d H:i:s'),
                                'status' => 1
                            ];

                            $this->Device_selfflow_installation_model->Save_Threshold_data($ThresholdData);


                            $ThresholdlogData = [
                                'area_id' => $verifyWell_data[0]['area_id'],
                                'site_id' => $verifyWell_data[0]['site_id'],
                                'well_id' => $this->input->post('well_id',true),
                                'component_id' => $value['component_id'],
                                'tag_no' => $value['tag_number'],
                                 'max_value'=>$max_value,
                                'upper_value'=>$upper_value,
                                'lower_value'=>$lower_value,
                                'multiplier'=>$multiplier,
                                'offset'=>$offset,
                                'c_by' => $c_by,
                                'c_date' => date('Y-m-d H:i:s'),
                                'status' => 1
                            ];

                            $this->Device_selfflow_installation_model->Save_Threshold_logdata($ThresholdlogData);

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