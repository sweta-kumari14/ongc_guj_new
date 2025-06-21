<?php
require APPPATH.'libraries/REST_Controller.php';
include('asset/Classes/PHPExcel/IOFactory.php');
class Device_master extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Device_master_model');
	}

	public function DeviceAdd_post()
	{
        $imei_no = $this->input->post('imei_no',true);
        $serial_no = $this->input->post('serial_no',true);
        $year_of_manufacturer = $this->input->post('year_of_manufacturer',true);
        $manufacturer_month = $this->input->post('manufacturer_month',true);
        $model_name = $this->input->post('model_name',true);

        if($this->input->post('admin_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'A Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('imei_no',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'IMEI required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9]{10,20}$/",$imei_no))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'IMEI should be 10 to 20 digit and character allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('year_of_manufacturer',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Year required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-9]{4}$/",$year_of_manufacturer))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Year should be 4 digit !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('manufacturer_month',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Manufacturer month required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z ]*$/",$manufacturer_month))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Manufacturer month not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('model_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Model Name required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif (!preg_match('/^[a-zA-Z]+-\d+$/', $this->input->post('model_name', true))) {
		    $this->response(['status' => false, 'data' => [], 'msg' => 'Invalid Model Name format.', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('c_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verify = $this->Device_master_model->verify_imeiExist($this->input->post('imei_no',true));
				if($verify == 0)
				{
					$id = $this->Device_master_model->getDevID();
					if($this->input->post('serial_no',true)!='')
					{
						if(!preg_match("/^[a-zA-Z0-9- ]*$/",$serial_no))
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Serial No not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}
					}
		
					$data = [];
					$data['id'] = $id[0]['UUID()'];
					$data['admin_id'] = $this->input->post('admin_id',true);
					$data['manufacturer_name'] = 'IOTAS';
					$data['imei_no'] = $this->input->post('imei_no', true);
                    $last_eight_digits = substr($imei_no, -8);
                    $data['device_name'] = 'IOT-RTMS-' . $last_eight_digits;
					$data['model_name'] = $this->input->post('model_name',true);
					$data['manufacturer_month'] = $this->input->post('manufacturer_month',true);
					$data['serial_no'] = $this->input->post('serial_no',true);
					$data['year_of_manufacturer'] = $this->input->post('year_of_manufacturer',true);
					$data['c_by'] = $this->input->post('c_by',true);
					$data['c_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Device_master_model->AddDevice($data);

					$this->response(['status'=>true,'data'=>[],'msg'=>'successfully saved!!','response_code'=>REST_Controller::HTTP_OK]);
							
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'IMEI Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    public function update_Device_post()
	{
        $imei_no = $this->input->post('imei_no',true);
        $serial_no = $this->input->post('serial_no',true);
        $year_of_manufacturer = $this->input->post('year_of_manufacturer',true);
        $manufacturer_month = $this->input->post('manufacturer_month',true);
        $model_name = $this->input->post('model_name',true);

        if($this->input->post('id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'ID required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('imei_no',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'IMEI required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9]{10,20}$/",$imei_no))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'IMEI should be 10 to 20 digit and character allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('year_of_manufacturer',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Year required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-9]{4}$/",$year_of_manufacturer))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Year should be 4 digit !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('manufacturer_month',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Manufacturer month required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z ]*$/",$manufacturer_month))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Manufacturer month not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('model_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Model Name required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif (!preg_match('/^[a-zA-Z]+-\d+$/', $this->input->post('model_name', true))) {
		    $this->response(['status' => false, 'data' => [], 'msg' => 'Invalid Model Name format.', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('d_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'d kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$IMEI = $this->Device_master_model->verify_ImeitExist_OrNot($this->input->post('imei_no',true),$this->input->post('id',true));
				if($IMEI == 0)
				{
					if($this->input->post('serial_no',true)!='')
					{
						if(!preg_match("/^[a-zA-Z0-9- ]*$/",$serial_no))
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Serial No not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}
					}
					$data = [];
					$data['imei_no'] = $this->input->post('imei_no',true);
					$data['serial_no'] = $this->input->post('serial_no',true);
					$data['year_of_manufacturer'] = $this->input->post('year_of_manufacturer',true);
					$data['model_name'] = $this->input->post('model_name',true);
					$data['manufacturer_month'] = $this->input->post('manufacturer_month',true);
					$data['d_by'] = $this->input->post('d_by',true);
					$data['d_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Device_master_model->Update_DeviceData($data,['id'=>$this->input->post('id',true)]);

					$this->response(['status'=>true,'data'=>[],'msg'=>'successfully updated!!','response_code'=>REST_Controller::HTTP_OK]);
							
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Device Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

	public function DeviceList_post()
	{
		try {
			$id = $this->input->post('id',true)!=""?$this->input->post('id',true):"";
			$result = $this->Device_master_model->DEviceList($id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  
	}

	public function deleteDevice_post()
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
				$this->Device_master_model->Delete_Device($data,['id'=>$this->input->post('id',true)]);
				$this->response(['status'=>true,'data'=>[],'msg'=>'successfully delete!!','response_code'=>REST_Controller::HTTP_OK]);
					
				
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    // public function Device_Allotment_To_Comapany_post()
	// {
    //     $imei_no = $this->input->post('imei_no',true);
    //     $allot_device = json_decode($this->input->post('allot_device',true),true);
    //     // print_r($allot_device);die;

    //     if($this->input->post('company_id',true) == '')
	// 	{
	// 		$this->response(['status'=>false,'data'=>[],'msg'=>'C Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
	// 	}elseif($this->input->post('allot_device',true) == '')
	// 	{
	// 		$this->response(['status'=>false,'data'=>[],'msg'=>'Device Data required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
	// 	}elseif($this->input->post('c_by',true) == '')
	// 	{
	// 		$this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
	// 	}else{
	// 		try 
	// 		{	
			
	// 			if(!empty($allot_device))
	// 			{
					
	// 				foreach ($allot_device as $key => $value) 
	// 				{
	// 					$data = [];
	// 					$Aid = $this->Device_master_model->getDevID();
	// 					$data['id'] = $Aid[0]['UUID()'];
	// 					$data['company_id'] = $this->input->post('company_id',true);
	// 					$data['device_name'] = $value['device_name'];
	// 					$data['imei_no'] = $value['imei_no'];
	// 					$data['serial_no'] = $value['serial_no'];
	// 					$data['c_by'] = $this->input->post('c_by',true);
	// 					$data['c_date'] = date('Y-m-d H:i:s');
	// 					$data['status'] = 1;
	// 					$this->Device_master_model->SaveCompany_AllotmentData($data);

	// 					$this->Device_master_model->UpdateDevice_status(['company_id'=>$data['company_id'],'allot_status'=>1,'d_by'=>$this->input->post('c_by',true),'d_date'=>date('Y-m-d H:i:s')],['imei_no'=>$data['imei_no']]);
	// 				}
	// 				$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Device Alloted!!','response_code'=>REST_Controller::HTTP_OK]);
							
	// 			}else{
	// 				$this->response(['status'=>false,'data'=>[],'msg'=>'Device data not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
	// 			}	
        	
	// 		}catch (Exception $e){
	// 			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	// 			}
	// 	}
    // }

    public function Device_Allotment_To_Comapany_post()
	{
        $imei_no = $this->input->post('imei_no',true);
        $allot_device = json_decode($this->input->post('allot_device',true),true);
        // print_r($allot_device);die;

        if($this->input->post('company_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'C Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('allot_device',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Device Data required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('c_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				if(!empty($allot_device))
				{
					foreach ($allot_device as $key => $value) 
					{
						if (!empty($value['device_name'])) {
			                if (!preg_match('/^IOT-RTMS-[a-zA-Z0-9]{8}$/', $value['device_name'])) {
						        $this->response(['status' => false, 'data' => [], 'msg' => 'Device name should be in the format "IOT-RTMS-xxxxxxxx" (x represents 8 digits or alphabets)!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
						    }
			            }

						if (!empty($value['imei_no'])) {
			                if (!preg_match('/^[a-zA-Z0-9]{15,20}$/', $value['imei_no'])) {
			                    $this->response(['status' => false, 'data' => [], 'msg' => 'IMEI number and characters should be 15 to 20 digit allowed!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
			                }
			            }

			            $serial_no = null;
				        if (!empty($value['serial_no'])) {
				            if (!preg_match('/^[a-zA-Z0-9-]+$/', $value['serial_no'])) {
				                $this->response(['status' => false, 'data' => [], 'msg' => 'Serial number not valid!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
				            }
				            $serial_no = $value['serial_no']; // Set serial number if it's valid
				        }
						$data = [];
						$Aid = $this->Device_master_model->getDevID();
						$data['id'] = $Aid[0]['UUID()'];
						$data['company_id'] = $this->input->post('company_id',true);
						$data['device_name'] = $value['device_name'];
						$data['imei_no'] = $value['imei_no'];
						$data['serial_no'] = $serial_no;
						$data['c_by'] = $this->input->post('c_by',true);
						$data['c_date'] = date('Y-m-d H:i:s');
						$data['status'] = 1;
						$this->Device_master_model->SaveCompany_AllotmentData($data);

						$this->Device_master_model->UpdateDevice_status(['company_id'=>$data['company_id'],'allot_status'=>1,'d_by'=>$this->input->post('c_by',true),'d_date'=>date('Y-m-d H:i:s')],['imei_no'=>$data['imei_no']]);
					}
					$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Device Alloted!!','response_code'=>REST_Controller::HTTP_OK]);
							
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Device data not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    public function import_Device_post()
    {
        $file = json_decode($_POST['file'],TRUE);
        // print_r($file);die;
        //Use whatever path to an Excel file you need.
        $inputFileName = $file['tmp_name'];
        $allowed = array('xlsx');
        $filename = $file['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {

            $this->response(['status'=>false,'data'=>[],'message'=>'File is not excel format !','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                return 1;
        }
        
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
             // print_r($objReader);die;
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . 
            $e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $c = 0;
        $status = 0;
        for ($row = 1; $row <= $highestRow; $row++) { 
        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
                                        null, true, false);
        if($c!=0)
        {  
            $data = array();
            
            if($rowData[0][0]=='' || $rowData[0][1]=='' || $rowData[0][2]=='' || $rowData[0][3]=='' || $rowData[0][4]=='')
            {
                $this->response(['status'=>false,'data'=>[],'message'=>'Data Can Not Null On Row =>'.($c+1),'response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                return 1;
            }else{
                $imei = $this->Device_master_model->verify_imeiExist($rowData[0][1]);
                if($imei>0)
                {
                    $this->response(['status'=>false,'data'=>[],'message'=>'IMEI already exist','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                }else{
                	    $imei_no = (string)$rowData[0][1];
                	    $device_name = $rowData[0][2];
                		$manufacturer_name = $rowData[0][3];
                		$model_name = $rowData[0][4];
                	    $month_of_manufacture = $rowData[0][5];
                		$year_of_manufacturer = $rowData[0][6];
                		if(!preg_match('/^[a-zA-Z ]*$/',$manufacturer_name))
                		{
                			$this->response(['status'=>false,'data'=>[],'message'=>'Manufacturer should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                		}else{
                			$x =8;
	                        $randomNum = substr(str_shuffle("0123456789"),0,$x);
	                        $id = $this->Device_master_model->getDevID();

	                        $data['id'] = $id[0]['UUID()']; 
	                        $data['admin_id'] = $this->input->post('admin_id',true);
	                        $data['manufacturer_name'] = $rowData[0][3];
	                        $data['device_name'] = $rowData[0][2];	                        
	                        $data['imei_no'] = $rowData[0][1];
	                        $data['year_of_manufacturer'] = $rowData[0][6];
	                        $data['model_name'] = $rowData[0][4];
	                        $data['manufacturer_month'] = $rowData[0][5];
	                        $data['c_by'] = $this->input->post('c_by',true);
	                        $data['c_date'] = date('Y-m-d H:i:s');
	                        $data['status'] = 1;
	                        $this->Device_master_model->importDevice($data);
                		}
                    
                }
            }
           
        }
        $c++;
        }
        $this->response(['status'=>true,'data'=>[],'message'=>'success','response_code'=>REST_Controller::HTTP_OK]);

    }

}
?>