<?php
require APPPATH.'libraries/REST_Controller.php';
date_default_timezone_set('Asia/Kolkata');
class Well_configuration extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Well_configuration_model');
	}

  public function Add_Well_configuration_post()
  {
    $well_id = $this->input->post('well_id', true);
    $company_id = $this->input->post('company_id', true);

    if ($company_id == '') {
        $this->response(['status' => false, 'data' => [], 'msg' => 'Company Id required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
    } elseif ($well_id == '') {
        $this->response(['status' => false, 'data' => [], 'msg' => 'Well Id required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
    } elseif ($this->input->post('c_by', true) == '') {
        $this->response(['status' => false, 'data' => [], 'msg' => 'c kon required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
    } else {
        try {
            $verify_well_id = $this->Well_configuration_model->Verify_Well_configuration($well_id);

            if ($verify_well_id == 0) {
                $well_type = $this->input->post('well_type', true);
                $assign_date = $this->input->post('assign_date', true);

                if ($well_type == '') {
                    $this->response(['status' => false, 'data' => [], 'msg' => 'well type required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                } elseif (!preg_match('/^[0-1]{1}$/', $well_type)) {
                    $this->response(['status' => false, 'data' => [], 'msg' => 'well type should be integer!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                } elseif ($assign_date == '') {
                    $this->response(['status' => false, 'data' => [], 'msg' => 'Assign Date required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                } else {
                    if ($well_type == 0) {
                        $id = $this->Well_configuration_model->getWCId();
                        $data = [];
                        $data['id'] = $id[0]['UUID()'];
                        $data['company_id'] = $company_id;
                        $data['well_id'] = $well_id;
                        $data['well_type'] = $well_type;
                        $data['running_hours'] = 1440;
                        $data['assign_date'] = $assign_date;
                        $data['c_by'] = $this->input->post('c_by', true);
                        $data['c_date'] = date('Y-m-d H:i:s');
                        $data['status'] = 1;
                        $this->Well_configuration_model->Save_well($data);

                        $well_log = [];
                        $well_log['unique_id'] = $data['id'];
                        $well_log['company_id'] = $company_id;
                        $well_log['well_id'] = $well_id;
                        $well_log['well_type'] = $well_type;
                        $well_log['schdule_minutes'] = 1440;
                        $well_log['assign_date'] = $assign_date;
                        $well_log['from_active_date_time'] = date('Y-m-d H:i:s');
                        $well_log['c_by'] = $this->input->post('c_by', true);
                        $well_log['c_date'] = date('Y-m-d H:i:s');
                        $well_log['status'] = 1;

                        $this->Well_configuration_model->Save_well_log($well_log);

                        $this->response(['status' => true, 'data' => [], 'msg' => 'Well Scheduling Successfully!!', 'response_code' => REST_Controller::HTTP_OK]);
                    }else{
                        if ($this->input->post('periodic_time', true) == '') {
                            $this->response(['status' => false, 'data' => [], 'msg' => 'Periodic Time required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                        } else {
                            $periodic_time = json_decode($this->input->post('periodic_time', true), true);

                            // print_r($periodic_time);die;

                            foreach ($periodic_time as $value) {
                                $verify = $this->Well_configuration_model->Verify_Well_configuration_Exist($well_id, $value['start_time'], $value['stop_time']);

                                // print_r($verify);die;

                                if ($verify == 0) {
                                    $start = new DateTime($value['start_time']);
                                    $stop = new DateTime($value['stop_time']);

                                    if ($stop < $start) {
                                        $stop->modify('+1 day');
                                    }

                                    $interval = $start->diff($stop);

                                    $running_hours = $interval->format('%H:%I:%S');
                                    $totalMinutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;

                                    $id = $this->Well_configuration_model->getWCId();
                                    $data = [];
                                    $data['id'] = $id[0]['UUID()'];
                                    $data['company_id'] = $company_id;
                                    $data['well_id'] = $well_id;
                                    $data['well_type'] = $well_type;
                                    $data['start_time'] = $value['start_time'];
                                    $data['stop_time'] = $value['stop_time'];
                                    $data['assign_date'] = $assign_date;
                                    $data['running_hours'] = $totalMinutes;
                                    $data['c_by'] = $this->input->post('c_by', true);
                                    $data['c_date'] = date('Y-m-d H:i:s');
                                    $data['status'] = 1;
                                    $this->Well_configuration_model->Save_well($data);

                                    $well_log = [];
                                    $well_log['unique_id'] = $data['id'];
                                    $well_log['company_id'] = $company_id;
                                    $well_log['well_id'] = $well_id;
                                    $well_log['well_type'] = $well_type;
                                    $well_log['start_time'] = $value['start_time'];
                                    $well_log['stop_time'] = $value['stop_time'];
                                    $well_log['schdule_minutes'] = $totalMinutes;
                                    $well_log['assign_date'] = $assign_date;
                                    $well_log['from_active_date_time'] = date('Y-m-d H:i:s');
                                    $well_log['c_by'] = $this->input->post('c_by', true);
                                    $well_log['c_date'] = date('Y-m-d H:i:s');
                                    $well_log['status'] = 1;

                                    $this->Well_configuration_model->Save_well_log($well_log);
                                } else {
                                    $this->response(['status' => false, 'data' => [], 'msg' => 'Well Time Slot Already Exists!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                                }
                            }
                            
                            $this->response(['status' => true, 'data' => [], 'msg' => 'Well Scheduling Successfully!!', 'response_code' => REST_Controller::HTTP_OK]);
                        }
                    }
                }
            } else {
                $this->response(['status' => false, 'data' => [], 'msg' => 'Well Scheduling Already Exists!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
            }
        } catch (Exception $e) {
            $this->response(['status' => false, 'data' => [], 'msg' => 'Something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }
}


    public function get_Well_Configration_list_post()
    {
        try{
            $id = $this->input->post('id',true)!=""?$this->input->post('id',true):"";
            $company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
            $user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
            $search = $this->input->post('search',true)!=''? $this->input->post('search','true'):'';

            $result = $this->Well_configuration_model->get_configration_data($id,$company_id,$user_id,$search);

            $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully Well configuration Setup!!','response_code'=>REST_Controller::HTTP_OK]);

        }catch (Exception $e){
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
    }


    public function Delete_Well_Configration_post()
    {
        try{

            $well_id = $this->input->post('well_id',true);

            if($this->input->post('well_id',true) == '')
            {
                 $this->response(['status'=>false,'data'=>[],'msg'=>' Well Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
            }elseif($this->input->post('d_by',true) == '')
            {

                $this->response(['status'=>false,'data'=>[],'msg'=>'D kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
            }else{



                $data = [];
                $data['d_by'] = $this->input->post('d_by',true);
                $data['d_date'] = date('Y-m-d H:i:s');
                $data['to_deactive_date_time'] = date('Y-m-d H:i:s');
                $data['status'] = 0;
    
            $this->Well_configuration_model->UpdateWell_logConfigration($data,['well_id'=>$this->input->post('well_id',true),'status'=>1]);
             $this->Well_configuration_model->Update_dataWell_Configration(['well_id'=>$this->input->post('well_id',true)]);
            

            $this->response(['status'=>true,'data'=>[],'msg'=>' Delete Well Sheduling Successfully!!','response_code'=>REST_Controller::HTTP_OK]);
           }
        }catch (Exception $e){
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
    }

    public  function Delete_Well_Details_through_id_post()
    {
        try{

            $id = $this->input->post('id',true);

            if($this->input->post('id',true) == '')
            {
                 $this->response(['status'=>false,'data'=>[],'msg'=>' Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
            }elseif($this->input->post('d_by',true) == '')
            {

                $this->response(['status'=>false,'data'=>[],'msg'=>'D kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
            }else{

                $verify_well = $this->Well_configuration_model->verify_exists_well_data($this->input->post('id',true));
                    if($verify_well == 0)
                    {
                       
                       $this->response(['status'=>false,'data'=>[],'msg'=>' id not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]); 
                    }else{
                 

                         $well_id = $verify_well[0]['well_id'];
                         $verify_well_details = $this->Well_configuration_model->verify_exists_recode_or_not($this->input->post('id',true),$well_id);

                         if($verify_well_details == 0)
                         {
                            $data = [];
                            $data['d_by'] = $this->input->post('d_by',true);
                            $data['to_deactive_date_time'] = date('Y-m-d H:i:s');
                            $data['d_date'] =  date('Y-m-d H:i:s');
                            $data['status']  = 0;
    
                           $this->Well_configuration_model->UpdateWell_logConfigration($data,['well_id'=>$well_id]);

                           $this->Well_configuration_model->Update_dataWell_Configration(['well_id'=>$well_id]);

                             $this->response(['status'=>true,'data'=>[],'msg'=>' Delete Well Sheduling Successfully!!','response_code'=>REST_Controller::HTTP_OK]);

                         }else{
                            foreach($verify_well_details as $value)
                            {
                                $id = $this->Well_configuration_model->getWCId();
                                $data = [];
                                $data['id'] = $id[0]['UUID()'];
                                $data['company_id'] = $value['company_id'];
                                $data['well_id'] = $value['well_id'];
                                $data['well_type'] =  $value['well_type'];
                                $data['start_time'] = $value['start_time'];
                                $data['stop_time'] = $value['stop_time'];
                                $data['assign_date'] =  date('Y-m-d');
                                $data['running_hours'] = $value['running_hours'];
                                $data['c_by'] = $this->input->post('d_by', true);
                                $data['c_date'] = date('Y-m-d H:i:s');
                                $data['status'] = 1;
                                $this->Well_configuration_model->Save_well($data);

                                $well_log = [];
                                $well_log['unique_id'] =  $data['id'];
                                $well_log['company_id'] = $value['company_id'];
                                $well_log['well_id'] = $value['well_id'];
                                $well_log['well_type'] = $value['well_type'];
                                $well_log['start_time'] = $value['start_time'];
                                $well_log['stop_time'] = $value['stop_time'];
                                $well_log['schdule_minutes'] = $value['running_hours'];
                                $well_log['assign_date'] = date('Y-m-d');
                                $well_log['from_active_date_time'] = date('Y-m-d H:i:s');
                                $well_log['c_by'] = $this->input->post('d_by', true);
                                $well_log['c_date'] = date('Y-m-d H:i:s');
                                $well_log['status'] = 1;

                                 $this->Well_configuration_model->Save_well_log($well_log);



                            }

                            $data = [];
                            $data['d_by'] = $this->input->post('d_by',true);
                            $data['to_deactive_date_time'] = date('Y-m-d H:i:s');
                            $data['d_date'] =  date('Y-m-d H:i:s');
                            $data['status']  = 0;
    
                           $this->Well_configuration_model->UpdateWell_logConfigration($data,['well_id'=>$well_id,'from_active_date_time !='=>date('Y-m-d H:i:s'),'status'=>1]);

                           $this->Well_configuration_model->Update_dataWell_Configration(['well_id'=>$well_id,'c_date !='=>date('Y-m-d H:i:s')]);

                           $this->response(['status'=>true,'data'=>[],'msg'=>' Delete Well Sheduling Successfully!!','response_code'=>REST_Controller::HTTP_OK]);


                          
                         }
                         

                    }
                
           }
        }catch (Exception $e){
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
    }

    public function Update_Well_single_Configuration_post()
    {
        $id = $this->input->post('id',true);
        $well_id = $this->input->post('well_id', true);
        $company_id = $this->input->post('company_id', true);
        $assign_date = $this->input->post('assign_date',true);
        $well_type = $this->input->post('well_type',true);
        $d_by = $this->input->post('d_by', true);

        if($this->input->post('company_id',true) == '') 
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Company Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('well_id',true) == '') 
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Well Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif ($this->input->post('well_type',true) == '') 
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'well type required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif ($this->input->post('assign_date',true) == '') 
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Assign Date required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif ($this->input->post('d_by',true) == '') 
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'D Kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {
                        $well_type = $this->input->post('well_type',true);
                        if($well_type == 0)
                        {
                             $data = [];
                             $data['assign_date'] = $this->input->post('assign_date',true);
                             $data['d_by'] = $this->input->post('d_by',true);
                             $data['d_date'] = date('Y-m-d H:i:s');
                             $data['status'] = 1;
                             $this->Well_configuration_model->updateWellConfiguration($data,['id'=>$this->input->post('id',true)]);

                             $well_log = [];
                             $well_log['assign_date'] = $this->input->post('assign_date',true);
                             $well_log['d_by'] = $this->input->post('d_by',true);
                             $well_log['d_date'] = date('Y-m-d H:i:s');
                             $well_log['status'] = 1;

                             $this->Well_configuration_model->UpdateWell_logConfigration($well_log,['unique_id'=>$this->input->post('id',true)]);

                        }else{

                        $verify_slot = $this->Well_configuration_model->   Verify_Well_configuration_Exist_or_Not($this->input->post('id',true),$this->input->post('well_id',true),$this->input->post('start_time',true),$this->input->post('stop_time',true));

                        if($verify_slot == 0)
                        {

                            $verify_well_details = $this->Well_configuration_model->verify_exists_recode_or_not($this->input->post('id',true),$this->input->post('well_id',true));
                            if($verify_well_details == 0)
                            {
                               
                                 $start = new DateTime($this->input->post('start_time',true));
                                 $stop = new DateTime($this->input->post('stop_time',true));

                                 if ($stop < $start) 
                                 {
                                    $stop->modify('+1 day');
                                 }

                                 $interval = $start->diff($stop);

                                 $running_hours = $interval->format('%H:%I:%S');
                                 $totalMinutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;

                                $id = $this->Well_configuration_model->getWCId();
                                $data = [];
                                $data['id'] = $id[0]['UUID()'];
                                $data['company_id'] = $this->input->post('company_id',true);
                                $data['well_id'] = $this->input->post('well_id',true);
                                $data['well_type'] = $this->input->post('well_type',true);
                                $data['assign_date'] = $this->input->post('assign_date',true);
                                $data['start_time'] = $this->input->post('start_time',true);
                                $data['stop_time'] = $this->input->post('stop_time',true);
                                $data['running_hours'] = $totalMinutes;
                                $data['c_by'] = $this->input->post('d_by',true);
                                $data['c_date'] = date('Y-m-d H:i:s');
                                $data['status'] = 1;
                                $this->Well_configuration_model->Save_well($data);

                                $well_log = [];
                                $well_log['unique_id'] =  $data['id'];
                                $well_log['company_id'] = $data['company_id'];
                                $well_log['well_id'] = $data['well_id'];
                                $well_log['well_type'] = $data['well_type'];
                                $well_log['start_time'] = $data['start_time'];
                                $well_log['stop_time'] = $data['stop_time'];
                                $well_log['schdule_minutes'] = $data['running_hours'];
                                $well_log['assign_date'] = date('Y-m-d');
                                $well_log['from_active_date_time'] = date('Y-m-d H:i:s');
                                $well_log['c_by'] = $this->input->post('d_by', true);
                                $well_log['c_date'] = date('Y-m-d H:i:s');
                                $well_log['status'] = 1;

                                $this->Well_configuration_model->Save_well_log($well_log);

                                $data = [];
                                $data['d_by'] = $this->input->post('d_by',true);
                                $data['to_deactive_date_time'] = date('Y-m-d H:i:s');
                                $data['d_date'] =  date('Y-m-d H:i:s');
                                $data['status']  = 0;
        
                              $this->Well_configuration_model->UpdateWell_logConfigration($data,['well_id'=>$this->input->post('well_id',true),'from_active_date_time !='=>date('Y-m-d H:i:s'),'status'=>1]);

                              $this->Well_configuration_model->Update_dataWell_Configration(['well_id'=>$this->input->post('well_id',true),'c_date !='=>date('Y-m-d H:i:s')]);
                            }else{

                                 foreach($verify_well_details  as $value)
                                 {
                                    $id = $this->Well_configuration_model->getWCId();
                                    $data = [];
                                    $data['id'] = $id[0]['UUID()'];
                                    $data['company_id'] = $value['company_id'];
                                    $data['well_id'] = $value['well_id'];
                                    $data['well_type'] =  $value['well_type'];
                                    $data['start_time'] = $value['start_time'];
                                    $data['stop_time'] = $value['stop_time'];
                                    $data['assign_date'] =  date('Y-m-d');
                                    $data['running_hours'] = $value['running_hours'];
                                    $data['c_by'] = $this->input->post('d_by', true);
                                    $data['c_date'] = date('Y-m-d H:i:s');
                                    $data['status'] = 1;
                                    $this->Well_configuration_model->Save_well($data);

                                    $well_log = [];
                                    $well_log['unique_id'] =  $data['id'];
                                    $well_log['company_id'] = $value['company_id'];
                                    $well_log['well_id'] = $value['well_id'];
                                    $well_log['well_type'] = $value['well_type'];
                                    $well_log['start_time'] = $value['start_time'];
                                    $well_log['stop_time'] = $value['stop_time'];
                                    $well_log['schdule_minutes'] = $value['running_hours'];
                                    $well_log['assign_date'] = date('Y-m-d');
                                    $well_log['from_active_date_time'] = date('Y-m-d H:i:s');
                                    $well_log['c_by'] = $this->input->post('d_by', true);
                                    $well_log['c_date'] = date('Y-m-d H:i:s');
                                    $well_log['status'] = 1;

                                     $this->Well_configuration_model->Save_well_log($well_log);

                                 }

                                 $start = new DateTime($this->input->post('start_time',true));
                                 $stop = new DateTime($this->input->post('stop_time',true));

                                 if ($stop < $start) 
                                 {
                                    $stop->modify('+1 day');
                                 }

                                 $interval = $start->diff($stop);

                                 $running_hours = $interval->format('%H:%I:%S');
                                 $totalMinutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;

                                $id = $this->Well_configuration_model->getWCId();
                                $data = [];
                                $data['id'] = $id[0]['UUID()'];
                                $data['company_id'] = $this->input->post('company_id',true);
                                $data['well_id'] = $this->input->post('well_id',true);
                                $data['well_type'] = $this->input->post('well_type',true);
                                $data['assign_date'] =  date('Y-m-d');
                                $data['start_time'] = $this->input->post('start_time',true);
                                $data['stop_time'] = $this->input->post('stop_time',true);
                                $data['running_hours'] = $totalMinutes;
                                $data['c_by'] = $this->input->post('d_by',true);
                                $data['c_date'] = date('Y-m-d H:i:s');
                                $data['status'] = 1;
                                $this->Well_configuration_model->Save_well($data);

                                $well_log = [];
                                $well_log['unique_id'] =  $data['id'];
                                $well_log['company_id'] = $data['company_id'];
                                $well_log['well_id'] = $data['well_id'];
                                $well_log['well_type'] = $data['well_type'];
                                $well_log['start_time'] = $data['start_time'];
                                $well_log['stop_time'] = $data['stop_time'];
                                $well_log['schdule_minutes'] = $data['running_hours'];
                                $well_log['assign_date'] = date('Y-m-d');
                                $well_log['from_active_date_time'] = date('Y-m-d H:i:s');
                                $well_log['c_by'] = $this->input->post('d_by', true);
                                $well_log['c_date'] = date('Y-m-d H:i:s');
                                $well_log['status'] = 1;

                                $this->Well_configuration_model->Save_well_log($well_log);

                                $data = [];
                                $data['d_by'] = $this->input->post('d_by',true);
                                $data['to_deactive_date_time'] = date('Y-m-d H:i:s');
                                $data['d_date'] =  date('Y-m-d H:i:s');
                                $data['status']  = 0;
        
                              $this->Well_configuration_model->UpdateWell_logConfigration($data,['well_id'=>$this->input->post('well_id',true),'from_active_date_time !='=>date('Y-m-d H:i:s'),'status'=>1]);

                              $this->Well_configuration_model->Update_dataWell_Configration(['well_id'=>$this->input->post('well_id',true),'c_date !='=>date('Y-m-d H:i:s')]);

  
                            }


                        }else{
                            $this->response(['status'=>false,'data'=>[],'msg'=>'slot Already Exists!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                        }

                    }
                        
                       
                        $this->response(['status'=>true,'data'=>[],'msg'=>'successfully updated!!','response_code'=>REST_Controller::HTTP_OK]);

                $this->response(['status' => true, 'data' => [], 'msg' => 'Well Sheduling updated successfully!', 'response_code' => REST_Controller::HTTP_OK]);

            }catch (Exception $e) {
                $this->response(['status' => false, 'data' => [], 'msg' => 'Something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
    }


    public function Well_configuration_log_report_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
            $to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
            $well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $sort_by = $this->input->post('sort_by',true)!=''?$this->input->post('sort_by',true):'';

            $result = $this->Well_configuration_model->Well_configuration_report($company_id,$from_date,$to_date,$well_id,$user_id,$sort_by);

            $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        }catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function get_well_details_configration_post()
    {
        try{

          $well_id =  $this->input->post('well_id');
        
          $result = $this->Well_configuration_model->get_welldetails_list($well_id);

          if(!empty($result))
          {
            $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);

        }else{
             $this->response(['status'=>false,'data'=>$result,'msg'=>'No Recod Found!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }
          
         }catch(Exception $e)
         {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
         }
    }


    public function get_well_list_configration_post()
    {

         try{

            $id = $this->input->post('id',true)!=""?$this->input->post('id',true):"";
            $company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
            $user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
        
          $result = $this->Well_configuration_model->get_well_config_list($id,$company_id,$user_id);

          if(!empty($result))
          {
            $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);

        }else{
             $this->response(['status'=>false,'data'=>$result,'msg'=>'No Recod Found!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }
          
         }catch(Exception $e)
         {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
         }
   

    }

    public function Update_Well_Configuration_post()
    {   
        $well_id = $this->input->post('well_id', true);
        $company_id = $this->input->post('company_id', true);
        $d_by = $this->input->post('d_by', true);

        if ($this->input->post('company_id', true) == '') {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Company Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        } elseif ($this->input->post('well_id', true) == '') {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Well Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        } elseif ($this->input->post('d_by', true) == '') {
            $this->response(['status'=>false,'data'=>[],'msg'=>'C Kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        } else {
            try {
                $verify = $this->Well_configuration_model->verify_well_details($this->input->post('well_id'));
                $well_type =  $verify[0]['well_type'];

                // print_r($verify);die;

                if ($this->input->post('well_type') == '') {
                    $this->response(['status'=>false,'data'=>[],'msg'=>'well_type required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                } else {
                    if ($well_type == 0) 
                    {
                     
                        
                        if ($this->input->post('well_type', true) == $verify[0]['well_type']) 
                        {
                            $data = [];
                            $data['assign_date'] = $this->input->post('assign_date', true);
                            $data['d_by'] = $this->input->post('d_by', true);
                            $data['d_date'] = date('Y-m-d H:i:s');
                            $data['status'] = 1;
                            $this->Well_configuration_model->updateWellConfiguration($data,['well_id'=>$this->input->post('well_id', true)]);

                             $well_log = [];
                             $well_log['assign_date'] = $this->input->post('assign_date',true);
                             $well_log['d_by'] = $this->input->post('d_by',true);
                             $well_log['d_date'] = date('Y-m-d H:i:s');
                             $well_log['status'] = 1;

                             $this->Well_configuration_model->UpdateWell_logConfigration($well_log,['well_id'=>$this->input->post('well_id',true)]);

                            $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Update Regular!!','response_code'=>REST_Controller::HTTP_OK]);
                        }else {
                            if ($this->input->post('periodic_time') == '') {
                                $this->response(['status'=>false,'data'=>[],'msg'=>'periodic time required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                            } else {
                                $periodic_time = json_decode($this->input->post('periodic_time', true), true);
                                

                                foreach ($periodic_time as $value) 
                                {
                                    $verify = $this->Well_configuration_model->Verify_Well_configuration_Exist($this->input->post('well_id'), $value['start_time'], $value['stop_time']);
                                    if ($verify == 0) {

                                         $start = new DateTime($value['start_time']);
                                           $stop = new DateTime($value['stop_time']);

                                            if ($stop < $start) {
                                                $stop->modify('+1 day');
                                            }

                                            $interval = $start->diff($stop);

                                           $running_hours = $interval->format('%H:%I:%S');
                                           $totalMinutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;

                                        $id = $this->Well_configuration_model->getWCId();
                                        $data = [];
                                        $data['id'] = $id[0]['UUID()'];
                                        $data['company_id'] = $this->input->post('company_id', true);
                                        $data['well_id'] = $this->input->post('well_id', true);
                                        $data['well_type'] = $this->input->post('well_type', true);
                                        $data['start_time'] = $value['start_time'];
                                        $data['stop_time'] = $value['stop_time'];
                                        $data['assign_date'] = $this->input->post('assign_date', true);
                                        $data['running_hours'] = $totalMinutes;
                                        $data['c_by'] = $this->input->post('d_by', true);
                                        $data['c_date'] = date('Y-m-d H:i:s');
                                        $data['status'] = 1;
                                        $this->Well_configuration_model->Save_well($data);

                                        $well_log = [];
                                        $well_log['unique_id'] = $data['id'];
                                        $well_log['company_id'] = $this->input->post('company_id', true);
                                        $well_log['well_id'] =  $this->input->post('well_id', true);
                                        $well_log['well_type'] = $this->input->post('well_type', true);
                                        $well_log['start_time'] = $value['start_time'];
                                        $well_log['stop_time'] = $value['stop_time'];
                                        $well_log['schdule_minutes'] = $totalMinutes;
                                        $well_log['assign_date'] = $this->input->post('assign_date', true);
                                        $well_log['c_by'] = $this->input->post('d_by', true);
                                        $well_log['from_active_date_time'] = date('Y-m-d H:i:s');
                                        $well_log['c_date'] = date('Y-m-d H:i:s');
                                        $well_log['status'] = 1;

                                        $this->Well_configuration_model->Save_well_log($well_log);

                                        // $data = [];
                                        // $data['d_by'] = $this->input->post('d_by',true);
                                        // $data['d_date'] = date('Y-m-d H:i:s');
                                        // $data['status'] = 0;
                                        // $this->Well_configuration_model->updateWellConfiguration($data,['well_id'=>$this->input->post('well_id',true),'well_type'=>0]);
                                        $data = [];
                                        $data['d_by'] = $this->input->post('d_by',true);
                                        $data['d_date'] = date('Y-m-d H:i:s');
                                        $data['to_deactive_date_time'] = date('Y-m-d H:i:s');
                                        $data['status'] = 0;
                    
                                       $this->Well_configuration_model->UpdateWell_logConfigration($data,['well_id'=>$this->input->post('well_id',true),'well_type'=>0]);


                                        $this->Well_configuration_model->Update_dataWell_Configration(['well_id'=>$this->input->post('well_id',true),'well_type'=>0]);

                                        
                                    }else{
                                        $this->response(['status' => false, 'data' => [], 'msg' => 'Well Time Slot Already Exists!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                                    }
                                }

                                $this->response(['status' => true, 'data' => [], 'msg' => 'Well Sheduling Successfully!!', 'response_code' => REST_Controller::HTTP_OK]);
                            }
                        }
                    } else {

                        if ($this->input->post('well_type', true) == $verify[0]['well_type']) 
                        {

                            $verify_well = $this->Well_configuration_model->verify_well_recode($this->input->post('well_id',true));
                            if($verify_well == 0)
                            {
                                $this->response(['status' => false, 'data' => [], 'msg' => 'Well id not valid !!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                            }else{
                                foreach($verify_well  as $well_value)
                                 {
                                    $id = $this->Well_configuration_model->getWCId();
                                    $data = [];
                                    $data['id'] = $id[0]['UUID()'];
                                    $data['company_id'] = $well_value['company_id'];
                                    $data['well_id'] = $well_value['well_id'];
                                    $data['well_type'] =  $well_value['well_type'];
                                    $data['start_time'] = $well_value['start_time'];
                                    $data['stop_time'] = $well_value['stop_time'];
                                    $data['assign_date'] =  date('Y-m-d');
                                    $data['running_hours'] = $well_value['running_hours'];
                                    $data['c_by'] = $this->input->post('d_by', true);
                                    $data['c_date'] = date('Y-m-d H:i:s');
                                    $data['status'] = 1;
                                    $this->Well_configuration_model->Save_well($data);

                                    $well_log = [];
                                    $well_log['unique_id'] =  $data['id'];
                                    $well_log['company_id'] = $well_value['company_id'];
                                    $well_log['well_id'] = $well_value['well_id'];
                                    $well_log['well_type'] = $well_value['well_type'];
                                    $well_log['start_time'] = $well_value['start_time'];
                                    $well_log['stop_time'] = $well_value['stop_time'];
                                    $well_log['schdule_minutes'] = $well_value['running_hours'];
                                    $well_log['assign_date'] = date('Y-m-d');
                                    $well_log['from_active_date_time'] = date('Y-m-d H:i:s');
                                    $well_log['c_by'] = $this->input->post('d_by', true);
                                    $well_log['c_date'] = date('Y-m-d H:i:s');
                                    $well_log['status'] = 1;

                                     $this->Well_configuration_model->Save_well_log($well_log);

                                 }

                                $data = [];
                                $data['d_by'] = $this->input->post('d_by',true);
                                $data['to_deactive_date_time'] = date('Y-m-d H:i:s');
                                $data['d_date'] =  date('Y-m-d H:i:s');
                                $data['status']  = 0;
        
                                $this->Well_configuration_model->UpdateWell_logConfigration($data,['well_id'=>$this->input->post('well_id',true),'from_active_date_time !='=>date('Y-m-d H:i:s'),'status'=>1]);

                               $this->Well_configuration_model->Update_dataWell_Configration(['well_id'=>$this->input->post('well_id',true),'c_date !='=>date('Y-m-d H:i:s')]);
                            }


                            $periodic_time = json_decode($this->input->post('periodic_time', true), true);
                              // print_r($periodic_time);die;
                                    
                            foreach ($periodic_time as $value) 
                            {
                                $verify = $this->Well_configuration_model->Verify_Well_configuration_Exist($this->input->post('well_id'), $value['start_time'], $value['stop_time']);
                                if ($verify == 0) 
                                {
                                            
                                           $start = new DateTime($value['start_time']);
                                           $stop = new DateTime($value['stop_time']);

                                            if ($stop < $start) {
                                                $stop->modify('+1 day');
                                            }

                                            $interval = $start->diff($stop);

                                           $running_hours = $interval->format('%H:%I:%S');
                                           $totalMinutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;

                                        $id = $this->Well_configuration_model->getWCId();
                                        $data = [];
                                        $data['id'] = $id[0]['UUID()'];
                                        $data['company_id'] = $this->input->post('company_id', true);
                                        $data['well_id'] = $this->input->post('well_id', true);
                                        $data['well_type'] = $this->input->post('well_type', true);
                                        $data['start_time'] = $value['start_time'];
                                        $data['stop_time'] = $value['stop_time'];
                                        $data['assign_date'] = $this->input->post('assign_date', true);
                                        $data['running_hours'] = $totalMinutes;
                                        $data['c_by'] = $this->input->post('d_by', true);
                                        $data['c_date'] = date('Y-m-d H:i:s');
                                        $data['status'] = 1;
                                        $this->Well_configuration_model->Save_well($data);

                                        $well_log = [];
                                        $well_log['unique_id'] = $data['id'];
                                        $well_log['company_id'] = $this->input->post('company_id', true);
                                        $well_log['well_id'] =  $this->input->post('well_id', true);
                                        $well_log['well_type'] = $this->input->post('well_type', true);
                                        $well_log['start_time'] = $value['start_time'];
                                        $well_log['stop_time'] = $value['stop_time'];
                                        $well_log['schdule_minutes'] = $totalMinutes;
                                        $well_log['assign_date'] = $this->input->post('assign_date', true);
                                        $well_log['c_by'] = $this->input->post('d_by', true);
                                        $well_log['from_active_date_time'] = date('Y-m-d H:i:s');
                                        $well_log['c_date'] = date('Y-m-d H:i:s');
                                        $well_log['status'] = 1;

                                        $this->Well_configuration_model->Save_well_log($well_log);

                                        
                                    }else{

                                     $this->response(['status' => false, 'data' => [], 'msg' => 'Well Time Slot Already Exists!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                                }
                            }

                            $this->response(['status' => true, 'data' => [], 'msg' => 'Well Sheduling Successfully periodic to periodic!!', 'response_code' => REST_Controller::HTTP_OK]);
                           
                        } else {

                      

                                $id = $this->Well_configuration_model->getWCId();
                                $data = [];
                                $data['id'] = $id[0]['UUID()'];
                                $data['company_id'] = $this->input->post('company_id', true);
                                $data['well_id'] = $this->input->post('well_id', true);
                                $data['well_type'] = $this->input->post('well_type', true);
                                $data['running_hours'] = 1440;
                                $data['assign_date'] = $this->input->post('assign_date', true);
                                $data['c_by'] = $this->input->post('c_by', true);
                                $data['c_date'] = date('Y-m-d H:i:s');
                                $data['status'] = 1;
                                $this->Well_configuration_model->Save_well($data);

                                $well_log = [];
                                $well_log['unique_id'] = $data['id'];
                                $well_log['company_id'] = $this->input->post('company_id', true);
                                $well_log['well_id'] =  $this->input->post('well_id', true);
                                $well_log['well_type'] = $this->input->post('well_type', true);
                                $well_log['schdule_minutes'] = 1440;
                                $well_log['assign_date'] = $this->input->post('assign_date', true);
                                $well_log['c_by'] = $this->input->post('d_by', true);
                                $well_log['from_active_date_time'] = date('Y-m-d H:i:s');
                                $well_log['c_date'] = date('Y-m-d H:i:s');
                                $well_log['status'] = 1;

                                $this->Well_configuration_model->Save_well_log($well_log);



                                $data = [];
                                $data['d_by'] = $this->input->post('d_by',true);
                                $data['to_deactive_date_time'] = date('Y-m-d H:i:s');
                                $data['d_date'] = date('Y-m-d H:i:s');
                                $data['status'] = 0;
                                $this->Well_configuration_model->UpdateWell_logConfigration($data,['well_id'=>$this->input->post('well_id',true),'well_type'=>1]);

                                $this->Well_configuration_model->Update_dataWell_Configration(['well_id'=>$this->input->post('well_id',true),'well_type'=>1]);

                                  
                               $this->response(['status' => true, 'data' => [], 'msg' => 'Well Sheduling Successfully periodic to regular!!', 'response_code' => REST_Controller::HTTP_OK]);
                        }
                    }
                }
            } catch (Exception $e) {
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
    }

} 
?>