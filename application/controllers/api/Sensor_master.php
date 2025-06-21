<?php
require APPPATH.'libraries/REST_Controller.php';
include('asset/Classes/PHPExcel/IOFactory.php');
class Sensor_master extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Sensor_master_model');
	}
	public function SensorAdd_post()
	{
        $sensor_no = $this->input->post('sensor_no',true);
        $sensor_name = $this->input->post('sensor_name',true);
        $item_name = $this->input->post('item_name',true);
        $sensor_allotment_year  = $this->input->post('sensor_allotment_year',true);
        $sensor_allotment_month = $this->input->post('sensor_allotment_month',true);
        $allotment_date_time = $this->input->post('allotment_date_time',true);

      //  if($this->input->post('id',true) == '')
		//{
			//$this->response(['status'=>false,'data'=>[],'msg'=>'ID required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		//}
        if($this->input->post('sensor_no',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Sensor number  required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9]{10,20}$/",$sensor_no))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Sensor should be 10 to 20 digit and character allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}
		elseif($this->input->post('sensor_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Sensor Name required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}if($this->input->post('item_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'item id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}
		elseif($this->input->post('sensor_allotment_year',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Year required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-9]{4}$/",$sensor_allotment_year))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Year should be 4 digit !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('sensor_allotment_month',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Manufacturer month required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z ]*$/",$sensor_allotment_month))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Manufacturer month not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}//elseif($this->input->post('c_by',true) == '')
		//{
		//$this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
	//}
		else{
			try 
			{	
				$verify = $this->Sensor_master_model->verify_sensorExist($this->input->post('sensor_no',true));
				if($verify == 0)
				{
					$id = $this->Sensor_master_model->getDevID();
					if($this->input->post('sensor_no',true)!='')
					{
						if(!preg_match("/^[a-zA-Z0-9- ]*$/",$sensor_no))
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Serial No not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}
					}
		
					$data = [];
					$data['id'] = $id[0]['UUID()'];
					$data['sensor_no'] = $this->input->post('sensor_no', true);
					$data['sensor_name'] = $this->input->post('sensor_name',true);
					$data['item_name'] = $this->input->post('item_name',true);
					$data['sensor_allotment_month'] = $this->input->post('sensor_allotment_month',true);
					$data['sensor_allotment_year'] = $this->input->post('sensor_allotment_year',true);
					$data['c_by'] = $this->input->post('c_by',true);
					$data['c_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Sensor_master_model->AddDevice($data);

					$this->response([
    'status' => true,
    'data' => $data,
    'msg' => 'successfully saved!!',
    'response_code' => REST_Controller::HTTP_OK
]);

							
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

   public function List_post()
	{
		try {
			$id = $this->input->post('id',true)!=""?$this->input->post('id',true):"";
			$result = $this->Sensor_master_model->DEviceList($id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  
	}
	public function update_Device_post()
{
    // Trim all inputs to avoid trailing spaces
    $id = trim($this->input->post('id', true));
    $sensor_no = trim($this->input->post('sensor_no', true));
    $sensor_name = trim($this->input->post('sensor_name', true));
    $item_name = $this->input->post('item_name',true);
    $sensor_allotment_year = trim($this->input->post('sensor_allotment_year', true));
    $sensor_allotment_month = trim($this->input->post('sensor_allotment_month', true));
    $d_by = trim($this->input->post('d_by', true));  // Make sure this field is in your form

    // Validation
    if (empty($id)) {
        $this->response(['status' => false, 'data' => [], 'msg' => 'ID required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        return;
    }
    if (empty($sensor_no)) {
        $this->response(['status' => false, 'data' => [], 'msg' => 'Sensor number required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        return;
    }
    if (!preg_match("/^[a-zA-Z0-9]{10,20}$/", $sensor_no)) {
        $this->response(['status' => false, 'data' => [], 'msg' => 'Sensor number should be 10 to 20 alphanumeric characters!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        return;
    }
    if (empty($sensor_allotment_year)) {
        $this->response(['status' => false, 'data' => [], 'msg' => 'Year required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        return;
    }
    if (!preg_match("/^[0-9]{4}$/", $sensor_allotment_year)) {
        $this->response(['status' => false, 'data' => [], 'msg' => 'Year should be 4 digits!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        return;
    }
    if (empty($sensor_allotment_month)) {
        $this->response(['status' => false, 'data' => [], 'msg' => 'Manufacturer month required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        return;
    }
    if (!preg_match("/^[a-zA-Z ]*$/", $sensor_allotment_month)) {
        $this->response(['status' => false, 'data' => [], 'msg' => 'Manufacturer month not valid!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        return;
    }
    if (empty($sensor_name)) {
        $this->response(['status' => false, 'data' => [], 'msg' => 'Sensor name required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        return;
    }
    if (!preg_match('/^[a-zA-Z]+-\d+$/', $sensor_name)) {
        $this->response(['status' => false, 'data' => [], 'msg' => 'Invalid sensor name format. Expected format: Letters-Digits (e.g. ABC-123)', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        return;
    }
    if($this->input->post('item_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'item id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}
    if (empty($d_by)) {
        $this->response(['status' => false, 'data' => [], 'msg' => 'd_by field required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        return;
    }

    try {
        // Check if sensor number already exists excluding current ID
        $exists = $this->Sensor_master_model->verify_sensorExist_OrNot($sensor_no, $id);
        if ($exists == 0) {
            // Additional validation for sensor_no characters (optional since regex done earlier)
            if (!preg_match("/^[a-zA-Z0-9- ]*$/", $sensor_no)) {
                $this->response(['status' => false, 'data' => [], 'msg' => 'Sensor number contains invalid characters!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                return;
            }

            $data = [
                'sensor_no' => $sensor_no,
                'sensor_name' => $sensor_name,
                'item_name'=>$item_name,
                'sensor_allotment_month' => $sensor_allotment_month,
                'sensor_allotment_year' => $sensor_allotment_year,
                'd_by' => $d_by,
                'd_date' => date('Y-m-d H:i:s'),
                'status' => 1
            ];

            $this->Sensor_master_model->Update_DeviceData($data, ['id' => $id]);

            $updated_data = $this->Sensor_master_model->get_device_by_id($id);

            $this->response([
                'status' => true,
                'data' => $updated_data,
                'msg' => 'Successfully updated!!',
                'response_code' => REST_Controller::HTTP_OK
            ]);
        } else {
            $this->response(['status' => false, 'data' => [], 'msg' => 'Device already exists!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }
    } catch (Exception $e) {
        $this->response(['status' => false, 'data' => [], 'msg' => 'Something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
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
				$this->Sensor_master_model->Delete_Device($data,['id'=>$this->input->post('id',true)]);
				$this->response(['status'=>true,'data'=>[],'msg'=>'successfully delete!!','response_code'=>REST_Controller::HTTP_OK]);
					
				
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }


}
?>