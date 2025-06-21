<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Dashboard_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
            $module_name = 'Visit Area Dashboard';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8').'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api ='Area_Dashboard/AssetList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['assets_list'] = $result['data'];
            // echo '<pre>';
            // print_r($d['assets_list']);die;


            $api ='Area_Dashboard/AreaList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['area_list'] = $result['data'];

            $d['v'] = "dashboard_view";
            $this->load->view('templates',$d); 
        }

        public function well_card_data()
        {
            $api = 'Area_Dashboard/get_Well_ListPopup';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                    .'&assets_id='.htmlspecialchars((string)$this->session->userdata('assets_id'),ENT_QUOTES, 'UTF-8')
                    .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
                     .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
                     .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
                     .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
                     .'&feeder_id='.htmlspecialchars((string)$this->input->post('feeder_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        // public function area_list()
        // {
        //     $api ='Area_Dashboard/AreaList_forDashboard';
        //     $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8').'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8').'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
        //     $method = 'POST';
        //     $result = $this->CALLAPI($api,$data,$method);
        //     echo json_encode($result);
        // }

         public function feeder_list()
        {
            $api ='FeederMaster/FeederList';
            $data = 'area_id='.htmlspecialchars((string)$this->input->post('area_id',true));
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            
            echo json_encode($result);
        }

        

        public function site_list()
        {
            $api ='Area_Dashboard/SiteList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function Well_list()
        {
            $api ='Area_Dashboard/WellList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
            .'&feeder_id='.htmlspecialchars((string)$this->input->post('feeder_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }
        
        public function get_dashboard_count()
        {
            $api ='Area_Dashboard/get_Total_InstalledSite';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
            .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
             .'&feeder_id='.htmlspecialchars((string)$this->input->post('feeder_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }


        public function overall_details()
        {
            $module_name = 'Check overall details';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8').'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api ='Area_Dashboard/Dashboard_Well_Details';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->uri->segment(3),ENT_QUOTES, 'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['well_details'] = $result['data'];

            
           
            $d['v'] = "area_overall_dashboard_view";
            $this->load->view('templates',$d); 
        }

        public function faulty_details_data()
        {
             $d['v'] = "area_faulty_well_list_view";
            $this->load->view('templates',$d); 
        }

        public function faulty_well_ajax()
        {
            
            $api ='Area_Dashboard/get_FaultyWell_List';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
             .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function power_cut_details_data()
        {
             $d['v'] = "area_power_cut_wells_list";
            $this->load->view('templates',$d); 
        }


        public function power_cut_well_ajax()
        {
            $api ='Area_Dashboard/get_powercutWell_List';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function timer_off_details_data()
        {
             $d['v'] = "area_timer_off_well_list";
            $this->load->view('templates',$d); 
        }


        public function timer_off_well_ajax()
        {
            $api ='Area_Dashboard/get_timeroffWell_List';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function temp_off_details_data()
        {
             $d['v'] = "area_temperory_well";
            $this->load->view('templates',$d); 
        }

        public function temperory_well_ajax() 
        {
            $api ='Area_Dashboard/get_temperory_well_List';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }
        public function on_unit_details()
        {
            $module_name = 'Visit working unit data';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8').'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $sess_site = $this->session->userdata('site_id',true);
          
            $d['v'] = "area_on_unit_dashboard_view";
            $this->load->view('templates',$d); 
        }

        public function on_unit_ajax()
        {
           $api ='Area_Dashboard/get_FunctionalOr_NonfunctionalRTMS_List';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }


        public function off_unit_details()
        {
            $module_name = 'Visit Off unit data';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8').'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            

            $d['v'] = "area_off_unit_dashboard_view";
            $this->load->view('templates',$d); 
        }

        public function off_unit_ajax()
        {
            $api ='Area_Dashboard/get_FunctionalOr_NonfunctionalRTMS_List';
            $data = 'company_id='.htmlspecialchars((string)$this->input->post('company_id',true),ENT_QUOTES, 'UTF-8')
             .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->input->post('user_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
             
        }

        public function get_site_location_for_dashboard()
        {
            $api ='Area_Dashboard/SiteList_for_Map';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->session->userdata('assets_id'),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
            .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&feeder_id='.htmlspecialchars((string)$this->input->post('feeder_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }
       
        public function well_location()
        {
            $d['v'] = "well_google_map_location_view";
            $this->load->view('templates',$d); 
        }

        public  function get_site_location_for_new_tab()
        {
            $api ='Area_Dashboard/SiteList_for_Map';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        

        public function get_single_well_detail_dashboard()
        {
            $api ='Area_Dashboard/Well_WiseEquipmentDetails';
            $data = 'well_id='.htmlspecialchars((string)$this->uri->segment(3),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['single_well_details'] = $result['data'];

            // print_r($d['single_well_details']);die;
          
            $api ='Area_Dashboard/Single_Device_Data';
            $data ='well_id='.htmlspecialchars((string)$this->uri->segment(3),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['device_data'] = $result['data'];
            // echo "<pre>";
            // print_r($result);die;

            $api = 'Temporary_off_reason_master/ReasonList';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['reason_list'] = $result['data'];
            // echo '<pre>';
            // print_r($d['reason_list']);die;

                      
            $d['v'] = "single_dasboard_view";
            $this->load->view('templates',$d); 
        }

         public function add_well_reason()
        {
            
            $userid = htmlspecialchars($this->session->userdata('id'));

            $api = 'Temporary_off_reason_master/well_status_mark';
            $data = 'reason='.htmlspecialchars($this->input->post('reason',true))
                     .'&well_id='.htmlspecialchars($this->input->post('well_data_id',true))
                     .'&effective_date_time='.htmlspecialchars($this->input->post('effective_date_time',true))
                     .'&flag_status='.htmlspecialchars($this->input->post('flag_status',true))
                     .'&user_id='.htmlspecialchars($this->session->userdata('id')).
                    '&c_by='.$userid;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Dashboard_c/get_single_well_detail_dashboard/'.$this->input->post('well_data_id'));
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Dashboard_c/get_single_well_detail_dashboard/'.$this->input->post('well_data_id'));
            }
        }

        public function well_status_details()
        {
            $api = 'Temporary_off_reason_master/get_well_last_mark_status';
            $data = 'well_id='.htmlspecialchars($this->input->post('well_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }


         public function well_shifted_single_dashboard()
        {
            $api = 'Well_wiseDeviceShifting/well_shifting_details_through_well_id';
            $data = '&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }
        public function get_single_device_count()
        {
            $api ='Area_Dashboard/Single_Device_Data';
            $data ='well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&imei_no='.htmlspecialchars((string)$this->input->post('imei_no',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_single_device_alert_data()
        {
            $api ='Area_Dashboard/Well_Wise_Alert_Report';
            $data ='well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8').'&imei_no='.htmlspecialchars((string)$this->input->post('imei_no',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_single_device_alert_count()
        {
            $api ='Area_Dashboard/Well_Wise_Count';
            $data ='well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&imei_no='.htmlspecialchars((string)$this->input->post('imei_no',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_frequency_data()
        {
            $api ='Area_Dashboard/get_FrequencyReport';
            $data ='well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&hours='.htmlspecialchars((string)$this->input->post('hours',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_active_energy_data()
        {
            $api ='Area_Dashboard/getActive_EnergyGraph';
            $data ='well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8').'&hours='.htmlspecialchars((string)$this->input->post('hours',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_neutral_line_chart_data()
        {
            $api ='Area_Dashboard/getNeutral_VoltageGraph';
            $data ='well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&hours='.htmlspecialchars((string)$this->input->post('hours',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_output_neutral_line_chart_data()
        {
            $api ='Area_Dashboard/getOutputNeutral_VoltageGraph';
            $data ='well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&hours='.htmlspecialchars((string)$this->input->post('hours',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_line_voltage_chart_data()
        {
            $api ='Area_Dashboard/getLine_VoltageGraph';
            $data ='well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&hours='.htmlspecialchars((string)$this->input->post('hours',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_output_line_voltage_chart_data()
        {
            $api ='Area_Dashboard/getOutput_Line_VoltageGraph';
            $data ='well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&hours='.htmlspecialchars((string)$this->input->post('hours',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_input_current_chart_data()
        {
            $api ='Area_Dashboard/Input_CurrentGraph';
            $data ='well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&hours='.htmlspecialchars((string)$this->input->post('hours',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_output_current_chart_data()
        {
            $api ='Area_Dashboard/Output_CurrentGraph';
            $data ='well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&hours='.htmlspecialchars((string)$this->input->post('hours',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_active_power_chart_data()
        {
            $api ='Area_Dashboard/Active_PowerGraph';
            $data ='well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&hours='.htmlspecialchars((string)$this->input->post('hours',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function single_device_daily_log_details()
        {
            $module_name = 'Single Device Daily Log Details';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8').'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $d['v'] = "report/single_device_daily_log_view";
            $this->load->view('templates',$d); 
        }

        public function single_device_daily_log_data()
        {
            $api ='Area_Dashboard/Single_Imei_daily_report';
            $data ='start_datetime='.htmlspecialchars((string)$this->input->post('start_datetime',true),ENT_QUOTES, 'UTF-8')
            .'&end_datetime='.htmlspecialchars((string)$this->input->post('end_datetime',true),ENT_QUOTES, 'UTF-8')
            .'&imei_no='.htmlspecialchars((string)$this->uri->segment(4),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function single_device_hourly_log_details()
        {
            $module_name = 'Single Device Hourly Log Details';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8').'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $d['v'] = "report/single_device_hourly_log_view";
            $this->load->view('templates',$d); 
        }

        public function single_device_hourly_log_data()
        {
            $api ='Area_Dashboard/Single_Imei_hourly_report';
            $data ='start_datetime='.htmlspecialchars((string)$this->input->post('start_datetime',true),ENT_QUOTES, 'UTF-8')
            .'&end_datetime='.htmlspecialchars((string)$this->input->post('end_datetime',true),ENT_QUOTES, 'UTF-8')
            .'&imei_no='.htmlspecialchars((string)$this->uri->segment(4),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function area_running_well_list()
        {

            $d['v'] = "area_running_well_list";
            $this->load->view('templates',$d); 
        }

        public function running_well_ajax()
        {
           $api ='Area_Dashboard/get_RunningWell_List';
            $data ='company_id='.htmlspecialchars((string)$this->input->post('company_id',true),ENT_QUOTES, 'UTF-8')
                    .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
                    .'&user_id='.htmlspecialchars((string)$this->input->post('user_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function area_not_running_well_list()
        {
            
            // echo "<pre>";
            // print_r($d['running_list']);die;

            $d['v'] = "area_not_running_well_list";
            $this->load->view('templates',$d); 
        }

         public function not_running_well_ajax()
        {
           $api ='Area_Dashboard/get_Not_RunningWell_List';
            $data ='company_id='.htmlspecialchars((string)$this->input->post('company_id',true),ENT_QUOTES, 'UTF-8')
                    .'&user_id='.htmlspecialchars((string)$this->input->post('user_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        
        public function area_total_rtms_details()
        {  
            $d['v'] = "area_total_rtms_view";
            $this->load->view('templates',$d); 
        }

        public function area_total_rtms_ajax()
        {
            $api ='Area_Dashboard/get_RTMS_List';
            $data ='company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_popup_data()
        {
            
            $this->load->view('dashboard_popup_data');
        }

        public function get_popup_details()
        {
            $api = 'Area_Dashboard/get_Well_Popup_List';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES, 'UTF-8')
                    .'&user_id='.htmlspecialchars((string)$this->input->post('user_id',true),ENT_QUOTES, 'UTF-8')
                    .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
                   .'&search='.htmlspecialchars((string)$this->input->post('search'),ENT_QUOTES, 'UTF-8');               
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
             echo json_encode($result);
            
        }

       
        // ======================  graph with  mis data ======================

        public function get_mis_and_graph_data()
        {
            $api ='Area_Dashboard/Well_WiseEquipmentDetails';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
            .'&well_id='.htmlspecialchars((string)$this->uri->segment(3),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['single_well_details'] = $result['data'];

            $d['v'] = "site_graph_and_mis_pages_view";
            $this->load->view('templates',$d);
        }

        public function get_device_mis_table()
        {
            $api ='Historical_Data/Historial_data_Mis_Report';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
            .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8')
            .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&imei_no='.htmlspecialchars((string)$this->input->post('imei_no',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
           echo json_encode($result);
        }

        
        public function get_all_dashboard_data_card_ajax()
        {
            $api ='Web_Single_Dashboard_Data/Well_Single_Dashboard_Details';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }
        public function get_all_dashboard_data_graph_ajax()
        {
            $api ='Web_Single_Dashboard_Data/get_Alltype_Single_graphData';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&hours='.htmlspecialchars((string)$this->input->post('hours',true),ENT_QUOTES, 'UTF-8')
            .'&grapg_type='.htmlspecialchars((string)$this->input->post('graphtype',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }
        // =========== threshold details ===============

        public function get_device_threshold_details_ajax()
        {
            $api ='Device_Threshold_Details/Threshold_DetailsList';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
                 .'&imei_no='.htmlspecialchars((string)$this->input->post('imei_no',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }
        public function get_running_well_page()
        {

            $d['v'] = "running_well_report_view";
            $this->load->view('templates',$d);
        }

        public function get_running_report_ajax()
        {
            $api ='Single_Dashboard_allData/Device_Running_Details';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
            .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

	    public function get_historical_all_graph_ajax()
        {
            $api ='Historical_Data/Historical_All_Type_Graph';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
                   .'&graph_type='.htmlspecialchars((string)$this->input->post('graphtype',true),ENT_QUOTES, 'UTF-8')
                   .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
                   .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }


        public function get_Average_data_value()
        {
            $api ='Historical_Data/Historial_data_Average';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
                   .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
                   .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }



        public function insert_alert_data()
        {
            $api ='Alert_Dashboard/Save_AlertData';
            $data = 'imei_no='.htmlspecialchars((string)$this->input->post('imei_no',true),ENT_QUOTES, 'UTF-8')
            .'&alert_type='.htmlspecialchars((string)$this->input->post('alert_type',true),ENT_QUOTES, 'UTF-8')
            .'&alert_details='.htmlspecialchars((string)$this->input->post('alert_details',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }


        public function get_well_shifted_list_page()
        {
            $d['v'] = "area_shifting_report_view";
            $this->load->view('templates',$d); 
        }

        public function get_well_shifted_data()
        {
            $api ='Area_Dashboard/get_Shifted_WellList';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_schduling_details()
        {
           $api ='Web_Single_Dashboard_Data/well_sheduling_details';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result); 
        }

        
    }
?>

