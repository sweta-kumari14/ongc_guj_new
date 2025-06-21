<?php
require APPPATH . 'libraries/REST_Controller.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once APPPATH . 'third_party/PHPMailer/Exception.php';
require_once APPPATH . 'third_party/PHPMailer/PHPMailer.php';
require_once APPPATH . 'third_party/PHPMailer/SMTP.php';
class Maintence_crone extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Maintenance_crone_model');
    }
     
     // For Purpose Mail
    public function get_case_details_for_mail_get()
    {
    
        $case_details = $this->Maintenance_crone_model->get_well_case_details();
        
        if(!empty($case_details))
        {

            $count_details = $this->Maintenance_crone_model->get_total_case_count();

            $total_open = $total_in_progress = $total_closed = 0;

            $total_open = $count_details['total_open'];
            $total_in_progress = $count_details['total_in_progress'];
            $total_closed = $count_details['total_closed'];

            $issue_counts = [];

            foreach ($case_details as $case) {
                
                $issue_type = $case['issue_type'];
                if (!isset($issue_counts[$issue_type])) {
                    $issue_counts[$issue_type] = 0;
                }
                $issue_counts[$issue_type]++;
            }

            $total_cases = count($case_details);
            $content = '';

            $content  = '<html><head>';
            $content .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            $content .= '<title>ONGC Cambay Assets Case Details</title>';
            $content .= '<style> 
                        body { font-family: Arial, sans-serif; background:#f4f4f4; padding:20px; margin:0; color:#333; }
                        .container { max-width: 900px; margin: auto; background:#fff; padding:20px; border-radius:8px; box-shadow: 0px 4px 8px rgba(0,0,0,0.1); }
                        table { width: 100%; border-collapse: collapse; border: 2px solid black; margin-top: 20px; }
                        th, td { padding: 10px; border: 1px solid black; text-align: center; }
                        th { background-color: #2786f1; color: white; }
                        .status-open { color: red; font-weight: bold; }
                        .status-in-progress { color: orange; font-weight: bold; }
                        .status-closed { color: green; font-weight: bold; }
                        </style>';
            $content .= '</head><body>';
            $content .= '<div class="container">';

            $content .= '<table>';
            $content .= '<tr><th colspan="8" style="font-size: 20px; padding: 15px;">ONGC Cambay Assets Case Details - ' . date('d-m-Y h:i A') . '</th></tr>';


            $content .= '<tr><th colspan="8" style="height: 20px; background-color: white;"></th></tr>';

            $content .= '<tr>';

            $content .= '<th colspan=2>Total Case</th><th colspan=2>Open Case</th><th colspan=2>In Progress Case</th><th colspan=2>Closed Case</th>';
            $content .= '</tr>';
            $content .= '<tr>';
            $content .= '<td colspan=2>' . $total_cases . '</td>';
            $content .= '<td colspan=2>' . $total_open . '</td>';
            $content .= '<td colspan=2>' . $total_in_progress . '</td>';
            $content .= '<td colspan=2>' . $total_closed . '</td>';
            $content .= '</tr>';

            $content .= '<tr><th colspan="8" style="height: 20px; background-color: white;"></th></tr>';

            $content .= '<tr><th colspan="8">Issue Type</th></tr>';
            $content .= '<tr><th colspan=4>Issue</th><th colspan=4>Total Count</th></tr>';
            foreach ($issue_counts as $type => $count) {
                $content .= '<tr>';
                $content .= '<td colspan= 4>' . htmlspecialchars($type) . '</td>';
                $content .= '<td colspan = 4>' . $count . '</td>';
                $content .= '</tr>';
            }

            $content .= '<tr><th colspan="8" style="height: 20px; background-color: white;"></th></tr>';
            $content .= '<tr><th>Maintenance ID</th><th>Area</th><th>Well</th><th>Site</th><th>Issue</th><th>Pending</th><th>In Progress</th><th>Closed</th></tr>';
            foreach ($case_details as $case) {
                $open = $in_progress = $closed = '-';
                
                if (!empty($case['case_status']['open'])) {
                    $open_case = $case['case_status']['open'][0];
                    $open = '<span class="status-open">' . date('d-m-Y h:i A', strtotime($open_case['open_time'])) . '<br>' . htmlspecialchars($open_case['user_data']).'</span>';
                }
                if (!empty($case['case_status']['in_progress'])) {
                    $in_progress_case = $case['case_status']['in_progress'][0];
                    $in_progress =  '<span class="status-in-progress">'.date('d-m-Y h:i A', strtotime($in_progress_case['in_progress_time'])) . '<br>' . htmlspecialchars($in_progress_case['user_data']).'</span>';
                }
                if (!empty($case['case_status']['closed'])) {
                    $closed_case = $case['case_status']['closed'][0];
                    $action = $closed_case['action_taken'] == 1 ? 'Repaired' : ($closed_case['action_taken'] == 2 ? 'Replaced' : '');
                    $closed = '<span class="status-closed">' . date('d-m-Y h:i:A', strtotime($closed_case['closed_time'])) . '<br>' . htmlspecialchars($closed_case['user_data']) . '<br>' . $action.'</span>';
                    if ($closed_case['action_taken'] == 2) {
                        $closed .= ' ( <strong>Quantity:</strong> ' . $closed_case['quantity'] . 
                            ' | <strong>Item Serial:</strong> ' . htmlspecialchars($closed_case['item_serial']) . ' )';
                    }
                }
                
                $content .= '<tr>';
                $content .= '<td>' . htmlspecialchars($case['maintance_id']) . '</td>';
                $content .= '<td>' . htmlspecialchars($case['area_name']) . '</td>';
                $content .= '<td>' . htmlspecialchars($case['well_name']) . '</td>';
                $content .= '<td>' . htmlspecialchars($case['site_name']) . '</td>';
                $content .= '<td>' . htmlspecialchars($case['issue_type']) . '</td>';
                $content .= '<td>' . $open . '</td>';
                $content .= '<td>' . $in_progress . '</td>';
                $content .= '<td>' . $closed . '</td>';
                $content .= '</tr>';
            }

            $content .= '</table>';
            $content .= '</div></body></html>';

                  
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->Mailer = "smtp";
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;
            $mail->Host = "ssl://smtp.gmail.com";
            $mail->Username = "nonreplyongc@gmail.com";
            $mail->Password = "fdgxdljgmgcrjcaj";
            $mail->IsHTML(true);
            $mail->SetFrom("nonreplyongc@gmail.com",'ONGC');
            $mail->AddAddress('iotassolutions@outlook.com');
            $mail->AddAddress('iotasbhola@gmail.com');
            // $mail->AddAddress('sweta1409kumari@gmail.com');
            $mail->Subject = "Ongc Cambay case details.";
            $mail->MsgHTML($content);
            // print_r($content);die;
            
            if(!$mail->Send()) {
               
                $this->response(['status'=>false,'data'=>$mail->ErrorInfo,'msg'=>'Mail Not Send!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);

            } else {

               $this->response(['status'=>true,'data'=>[],'msg'=>'successfully Send!!','response_code'=>REST_Controller::HTTP_OK]);
            }

            }else{

                $this->response(['status'=>false,'data'=>[],'msg'=>'Mail Not Send!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);

            }
    }


      // Case generate static  

    public function case_generate_system_get()
    {
        try {
           
            $active_wells = $this->Maintenance_crone_model->get_active_wells();

            if (!empty($active_wells)) {
                foreach ($active_wells as $well) {
                    $well_id = $well['well_id'];
                    $is_online = $this->Maintenance_crone_model->is_well_online($well_id);

                    if ($is_online) { 
                        $details = [];
                        
                        $details['issue_status'] = 3;
                        $details['d_date'] = date('Y-m-d H:i:s');
                        $details['d_by'] = 'system_generate';

                        $this->Maintenance_crone_model->UpdateMiantance($details,['maintance_id'=>$is_online['maintance_id']]);


                        $data = [];
                        $data = [
                            'site_id'       => $is_online['site_id'],
                            'area_id'       => $is_online['area_id'],
                            'well_id'       => $is_online['well_id'],
                            'issue_type_id' => 1,
                            'maintance_id'  => $is_online['maintance_id'],
                            'issue_status'  => 3,
                            'c_by'          => 'system_generate',
                            'c_date'        => date('Y-m-d H:i:s'),
                            'status'        => 1
                        ];
                        $this->Maintenance_crone_model->Save_Maintancelog($data);
                    }
                }
            }
            $offline_wells = $this->Maintenance_crone_model->get_offline_well_details();
            
            if (!empty($offline_wells)) {
                foreach ($offline_wells as $well) {
                    $well_id = $well['well_id'];

                    $existing_case = $this->Maintenance_crone_model->get_existing_case($well_id);

                    if (!$existing_case) {
                        $data = [
                            'site_id'       => $well['site_id'],
                            'area_id'       => $well['area_id'],
                            'well_id'       => $well_id,
                            'issue_type_id' => 1,
                            'maintance_id'  => $this->Maintenance_crone_model->get_next_ref_no(),
                            'issue_status'  => 1,
                            'c_by'          => 'system_generate',
                            'c_date'        => date('Y-m-d H:i:s'),
                            'status'        => 1
                        ];
                        $this->Maintenance_crone_model->Save_Maintance($data);

                        $Logdata = $data; 
                        $this->Maintenance_crone_model->Save_Maintancelog($Logdata);
                    }
                }
            }

            $this->response(['status' => true,'data' => [],'msg' => 'Successfully Processed!','response_code' => REST_Controller::HTTP_OK
            ]);

        } catch (Exception $e) {
            $this->response(['status' => false,'data' => [],'msg' => 'Something went wrong!','response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }
}
?>
