<?php
date_default_timezone_set('Asia/Kolkata');
class OfflineDeviceandWellModel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function checkOffline_Status($date)
	{
	    $from_date_time = date('Y-m-d H:i:s', strtotime($date . ' 06:00:00'));
	    $to_date_time = date('Y-m-d H:i:s', strtotime($date . ' 1 day'));

	    $allWell = $this->db->distinct()->select("well_id,last_date_time")
	        ->from("tbl_site_device_installation")->where(['status'=>1,'last_date_time >=' => $from_date_time, 'last_date_time <' => $to_date_time])->get()->result_array();
	        // print_r(count($allWell));die;
	    if(!empty($allWell))
	    {
	    	foreach ($allWell as $row) {
	        	$well_id = $row['well_id'];
	        	$last_date_time = $row['last_date_time'];
	        	
	        	$result = $this->db->select("well_id,imei_no, output_Average_Current, output_Kwh, last_date_time,output_Average_Voltage_P2P,output_Kwh,olr_status,elr_status,spp_status,battery_Voltage,smps_Voltage ")
	                ->from("tbl_site_device_installation")
	                ->where(['well_id' => $well_id, 'last_date_time >=' => $from_date_time, 'last_date_time <' => $to_date_time])
	                ->get()->result_array();
	           
	            // print_r($result);
	            $resultSet = count($result);
	            
	            for ($i = 0; $i < $resultSet; $i++) 
	            {  
					$offLineData = $this->getOfflinelast_data($well_id,$from_date_time,$to_date_time);
	           	
					$count=count($offLineData);
					// print_r($count);die;

					$currentTime = date("Y-m-d H:i:s");
		            
		            $diff_minute = floor(abs(strtotime($currentTime) - strtotime($result[$i]['last_date_time'])) / 60);

		            
		            // print_r($diff_minute2);die;
		            

		            // print_r($diff_minute);die;

		            if($count == 0)
		            {
		            	if($result[$i]['smps_Voltage'] > 5 && $result[$i]['battery_Voltage'] > 2 && $diff_minute >5)
		            	{
		            	// print_r("hiii");
		            		$dataNetwork = [];
		            		$dataNetwork['well_id'] = $result[$i]['well_id'];
		            		$dataNetwork['imei_no'] = $result[$i]['imei_no'];
		            		$dataNetwork['log_date'] = $result[$i]['last_date_time'];
		            		$dataNetwork['start_smps_voltage'] = $result[$i]['smps_Voltage'];
		            		$dataNetwork['start_battery_voltage'] = $result[$i]['battery_Voltage'];
		            		$dataNetwork['start_date_time'] = $result[$i]['last_date_time'];
		            		$dataNetwork['end_smps_voltage'] = $result[$i]['smps_Voltage'];
		            		$dataNetwork['end_battery_voltage'] = $result[$i]['battery_Voltage'];
		            		$dataNetwork['end_date_time'] = $result[$i]['last_date_time'];
		            		$dataNetwork['complete_status'] = 0;
		            		$dataNetwork['offline_reason'] = 2;
		            		$this->Savedata($dataNetwork);
		            	}

		            	if($result[$i]['smps_Voltage'] < 5 && $result[$i]['battery_Voltage'] < 2)
		            	{
		            	// print_r("hiii");
		            		$dataBattery = [];
		            		$dataBattery['well_id'] = $result[$i]['well_id'];
		            		$dataBattery['imei_no'] = $result[$i]['imei_no'];
		            		$dataBattery['log_date'] = $result[$i]['last_date_time'];
		            		$dataBattery['start_smps_voltage'] = $result[$i]['smps_Voltage'];
		            		$dataBattery['start_battery_voltage'] = $result[$i]['battery_Voltage'];
		            		$dataBattery['start_date_time'] = $result[$i]['last_date_time'];
		            		$dataBattery['end_smps_voltage'] = $result[$i]['smps_Voltage'];
		            		$dataBattery['end_battery_voltage'] = $result[$i]['battery_Voltage'];
		            		$dataBattery['end_date_time'] = $result[$i]['last_date_time'];
		            		$dataBattery['complete_status'] = 0;
		            		$dataBattery['offline_reason'] = 1;
		            		$this->Savedata($dataBattery);
		            	}

		            	if($result[$i]['output_Kwh'] == 0 && $result[$i]['output_Average_Current'] == 0 && $result[$i]['output_Average_Voltage_P2P'] == 0)
		            	{
		            		$dataModbus = [];
		            		$dataModbus['well_id'] = $result[$i]['well_id'];
		            		$dataModbus['imei_no'] = $result[$i]['imei_no'];
		            		$dataModbus['log_date'] = $result[$i]['last_date_time'];
		            		$dataModbus['start_smps_voltage'] = $result[$i]['smps_Voltage'];
		            		$dataModbus['start_battery_voltage'] = $result[$i]['battery_Voltage'];
		            		$dataModbus['start_date_time'] = $result[$i]['last_date_time'];
		            		$dataModbus['end_smps_voltage'] = $result[$i]['smps_Voltage'];
		            		$dataModbus['end_battery_voltage'] = $result[$i]['battery_Voltage'];
		            		$dataModbus['end_date_time'] = $result[$i]['last_date_time'];
		            		$dataModbus['output_Kwh'] = $result[$i]['output_Kwh'];
		            		$dataModbus['avg_current'] = $result[$i]['output_Average_Current'];
		            		$dataModbus['output_Average_Voltage_P2P'] = $result[$i]['output_Average_Voltage_P2P'];
		            		$dataModbus['complete_status'] = 0;
		            		$dataModbus['offline_reason'] = 3;
		            		$this->Savedata($dataModbus);
		            	}

		            	if($result[$i]['smps_Voltage'] < 5 && $diff_minute < 2)
		            	{
		            	// print_r("hiii");
		            		$dataPower = [];
		            		$dataPower['well_id'] = $result[$i]['well_id'];
		            		$dataPower['imei_no'] = $result[$i]['imei_no'];
		            		$dataPower['log_date'] = $result[$i]['last_date_time'];
		            		$dataPower['start_smps_voltage'] = $result[$i]['smps_Voltage'];
		            		$dataPower['start_battery_voltage'] = $result[$i]['battery_Voltage'];
		            		$dataPower['start_date_time'] = $result[$i]['last_date_time'];
		            		$dataPower['end_smps_voltage'] = $result[$i]['smps_Voltage'];
		            		$dataPower['end_battery_voltage'] = $result[$i]['battery_Voltage'];
		            		$dataPower['end_date_time'] = $result[$i]['last_date_time'];
		            		$dataPower['complete_status'] = 0;
		            		$dataPower['offline_reason'] = 4;
		            		$this->Savedata($dataPower);
		            	}
		            }else{
		            	if($offLineData[0]['complete_status'] == 0)
		            	{
		            		$diff_minute2 = floor(abs(strtotime($result[$i]['last_date_time']) - strtotime($offLineData[0]['start_date_time'])) / 60);

			            	if($result[$i]['smps_Voltage'] > 5 && $result[$i]['battery_Voltage'] > 2 && $diff_minute2 >5 && $offLineData[0]['offline_reason'] == 2)
			            	{
			            		$updateNetwork = [];
			            		$updateNetwork['end_smps_voltage'] = $result[$i]['smps_Voltage'];
			            		$updateNetwork['end_battery_voltage'] = $result[$i]['battery_Voltage'];
			            		$updateNetwork['end_date_time'] = $result[$i]['last_date_time'];
			            		$updateNetwork['complete_status'] = 1;

			            		if (!empty($updateNetwork)) {
		                         	$this->db->set($updateNetwork);
		                         	$this->db->where('id', $offLineData[0]['id']);
		                         	$this->db->update('tbl_device_and_well_offline_log');
		                    	}
		                    }

		                    if($result[$i]['smps_Voltage'] > 5 && $result[$i]['battery_Voltage'] > 2 && $offLineData[0]['offline_reason'] == 1)
			            	{
			            		$updateBattery = [];
			            		$updateBattery['end_smps_voltage'] = $result[$i]['smps_Voltage'];
			            		$updateBattery['end_battery_voltage'] = $result[$i]['battery_Voltage'];
			            		$updateBattery['end_date_time'] = $result[$i]['last_date_time'];
			            		$updateBattery['complete_status'] = 1;

			            		if (!empty($updateBattery)) {
		                         	$this->db->set($updateBattery);
		                         	$this->db->where('id', $offLineData[0]['id']);
		                         	$this->db->update('tbl_device_and_well_offline_log');
		                    	}
		                    }

		                    if(($result[$i]['output_Kwh'] > 0 || $result[$i]['output_Average_Current'] > 0 || $result[$i]['output_Average_Voltage_P2P'] > 0) && $offLineData[0]['offline_reason'] == 3)
			            	{
			            		$updateModbus = [];
			            		$updateModbus['end_smps_voltage'] = $result[$i]['smps_Voltage'];
			            		$updateModbus['end_battery_voltage'] = $result[$i]['battery_Voltage'];
			            		$updateModbus['end_date_time'] = $result[$i]['last_date_time'];
			            		$updateModbus['output_Kwh'] = $result[$i]['output_Kwh'];
			            		$updateModbus['avg_current'] = $result[$i]['output_Average_Current'];
			            		$updateModbus['output_Average_Voltage_P2P'] = $result[$i]['output_Average_Voltage_P2P'];
			            		$updateModbus['complete_status'] = 1;

			            		if (!empty($updateModbus)) {
		                         	$this->db->set($updateModbus);
		                         	$this->db->where('id', $offLineData[0]['id']);
		                         	$this->db->update('tbl_device_and_well_offline_log');
		                    	}
		                    }

		                    if($result[$i]['smps_Voltage'] > 5 && $diff_minute < 2 && $offLineData[0]['offline_reason'] == 4)
			            	{
			            		$updatePower = [];
			            		$updatePower['end_smps_voltage'] = $result[$i]['smps_Voltage'];
			            		$updatePower['end_battery_voltage'] = $result[$i]['battery_Voltage'];
			            		$updatePower['end_date_time'] = $result[$i]['last_date_time'];
			            		$updatePower['complete_status'] = 1;

			            		if (!empty($updatePower)) {
		                         	$this->db->set($updatePower);
		                         	$this->db->where('id', $offLineData[0]['id']);
		                         	$this->db->update('tbl_device_and_well_offline_log');
		                    	}
		                    }

		            	}elseif($offLineData[0]['complete_status'] == 1)
		            	{
			            	if($result[$i]['smps_Voltage'] > 5 && $result[$i]['battery_Voltage'] > 2 && $diff_minute >5){

			            		$dataNetwork = [];
			            		$dataNetwork['well_id'] = $result[$i]['well_id'];
			            		$dataNetwork['imei_no'] = $result[$i]['imei_no'];
			            		$dataNetwork['log_date'] = $result[$i]['last_date_time'];
			            		$dataNetwork['start_smps_voltage'] = $result[$i]['smps_Voltage'];
			            		$dataNetwork['start_battery_voltage'] = $result[$i]['battery_Voltage'];
			            		$dataNetwork['start_date_time'] = $result[$i]['last_date_time'];
			            		$dataNetwork['end_smps_voltage'] = $result[$i]['smps_Voltage'];
			            		$dataNetwork['end_battery_voltage'] = $result[$i]['battery_Voltage'];
			            		$dataNetwork['end_date_time'] = $result[$i]['last_date_time'];
			            		$dataNetwork['complete_status'] = 0;
			            		$dataNetwork['offline_reason'] = 2;
			            		$this->Savedata($dataNetwork);
			            	}

			            	if($result[$i]['smps_Voltage'] < 5 && $result[$i]['battery_Voltage'] < 2){

			            		$dataBattery = [];
			            		$dataBattery['well_id'] = $result[$i]['well_id'];
			            		$dataBattery['imei_no'] = $result[$i]['imei_no'];
			            		$dataBattery['log_date'] = $result[$i]['last_date_time'];
			            		$dataBattery['start_smps_voltage'] = $result[$i]['smps_Voltage'];
			            		$dataBattery['start_battery_voltage'] = $result[$i]['battery_Voltage'];
			            		$dataBattery['start_date_time'] = $result[$i]['last_date_time'];
			            		$dataBattery['end_smps_voltage'] = $result[$i]['smps_Voltage'];
			            		$dataBattery['end_battery_voltage'] = $result[$i]['battery_Voltage'];
			            		$dataBattery['end_date_time'] = $result[$i]['last_date_time'];
			            		$dataBattery['complete_status'] = 0;
			            		$dataBattery['offline_reason'] = 1;
			            		$this->Savedata($dataBattery);
			            	}

			            	if($result[$i]['output_Kwh'] == 0 && $result[$i]['output_Average_Current'] == 0 && $result[$i]['output_Average_Voltage_P2P'] == 0)
			            	{
			            	// print_r("hiii");
			            		$dataModbus = [];
			            		$dataModbus['well_id'] = $result[$i]['well_id'];
			            		$dataModbus['imei_no'] = $result[$i]['imei_no'];
			            		$dataModbus['log_date'] = $result[$i]['last_date_time'];
			            		$dataModbus['start_smps_voltage'] = $result[$i]['smps_Voltage'];
			            		$dataModbus['start_battery_voltage'] = $result[$i]['battery_Voltage'];
			            		$dataModbus['start_date_time'] = $result[$i]['last_date_time'];
			            		$dataModbus['end_smps_voltage'] = $result[$i]['smps_Voltage'];
			            		$dataModbus['end_battery_voltage'] = $result[$i]['battery_Voltage'];
			            		$dataModbus['end_date_time'] = $result[$i]['last_date_time'];
			            		$dataModbus['output_Kwh'] = $result[$i]['output_Kwh'];
			            		$dataModbus['avg_current'] = $result[$i]['output_Average_Current'];
			            		$dataModbus['output_Average_Voltage_P2P'] = $result[$i]['output_Average_Voltage_P2P'];
			            		$dataModbus['complete_status'] = 0;
			            		$dataModbus['offline_reason'] = 3;
			            		$this->Savedata($dataModbus);
			            	}

			            	if($result[$i]['smps_Voltage'] < 5 && $diff_minute < 2)
			            	{
			            	// print_r("hiii");
			            		$dataPower = [];
			            		$dataPower['well_id'] = $result[$i]['well_id'];
			            		$dataPower['imei_no'] = $result[$i]['imei_no'];
			            		$dataPower['log_date'] = $result[$i]['last_date_time'];
			            		$dataPower['start_smps_voltage'] = $result[$i]['smps_Voltage'];
			            		$dataPower['start_battery_voltage'] = $result[$i]['battery_Voltage'];
			            		$dataPower['start_date_time'] = $result[$i]['last_date_time'];
			            		$dataPower['end_smps_voltage'] = $result[$i]['smps_Voltage'];
			            		$dataPower['end_battery_voltage'] = $result[$i]['battery_Voltage'];
			            		$dataPower['end_date_time'] = $result[$i]['last_date_time'];
			            		$dataPower['complete_status'] = 0;
			            		$dataPower['offline_reason'] = 4;
			            		$this->Savedata($dataPower);
			            	}
		            	}
		            }

		        } 
	            
	        }
	    }
	}

	public function getOfflinelast_data($wellId,$from_date_time, $to_date_time)
	{
		// print_r($to_date_time);
		return $this->db->select("id,start_date_time,end_date_time,complete_status,offline_reason")
		->from("tbl_device_and_well_offline_log")->where(['well_id'=>$wellId,'start_date_time>='=>$from_date_time,'end_date_time<'=>$to_date_time])
		->order_by('id','DESC')->limit(1)->get()->result_array();
	}


	public function Savedata($data)
	{
		return $this->db->insert('tbl_device_and_well_offline_log',$data);
	}
	public function updatedata($data,$where)
	{
		return $this->db->update('tbl_device_and_well_offline_log',$data,$where);
	}

	public function getMaintainanceDashboard_Count($company_id,$area_id,$well_id)
	{
		if($company_id!='')
			$this->db->where('sd.company_id',$company_id);

		if($area_id!='')
			$this->db->where('sd.area_id',$area_id);

		if($well_id!='')
			$this->db->where('dl.well_id',$well_id);

		$start_date_time = date("Y-m-d 06:00:00");
	    $end_date_time = date("Y-m-d 06:00:00", strtotime("+1 day"));

	    $this->db->where('dl.log_date >=', $start_date_time);
	    $this->db->where('dl.log_date <', $end_date_time);

		$result = [];

		$result['batteryPrb'] = $this->db->select("count(DISTINCT dl.well_id) as total")
		->from('tbl_device_and_well_offline_log dl')
		->join('tbl_site_device_installation sd','dl.well_id=sd.well_id','left')
		->where(['dl.offline_reason'=>1,'dl.complete_status'=>0])->get()->result_array();

		// ================================================================================

		if($company_id!='')
			$this->db->where('sd.company_id',$company_id);

		if($area_id!='')
			$this->db->where('sd.area_id',$area_id);

		if($well_id!='')
			$this->db->where('dl.well_id',$well_id);

		$start_date_time = date("Y-m-d 06:00:00");
	    $end_date_time = date("Y-m-d 06:00:00", strtotime("+1 day"));

	   	$this->db->where('dl.log_date >=', $start_date_time);
	    $this->db->where('dl.log_date <', $end_date_time);

		$result['networkPrb'] = $this->db->select("count(DISTINCT dl.well_id) as total")
		->from('tbl_device_and_well_offline_log dl')
		->join('tbl_site_device_installation sd','dl.well_id=sd.well_id','left')
		->where(['dl.offline_reason'=>2,'dl.complete_status'=>0])->get()->result_array();
		// ===========================================================================

		if($company_id!='')
			$this->db->where('sd.company_id',$company_id);

		if($area_id!='')
			$this->db->where('sd.area_id',$area_id);

		if($well_id!='')
			$this->db->where('dl.well_id',$well_id);

		$start_date_time = date("Y-m-d 06:00:00");
	    $end_date_time = date("Y-m-d 06:00:00", strtotime("+1 day"));

	   	$this->db->where('dl.log_date >=', $start_date_time);
	    $this->db->where('dl.log_date <', $end_date_time);

		$result['modbusPrb'] = $this->db->select("count(DISTINCT dl.well_id) as total")
		->from('tbl_device_and_well_offline_log dl')
		->join('tbl_site_device_installation sd','dl.well_id=sd.well_id','left')
		->where(['dl.offline_reason'=>3,'dl.complete_status'=>0])->get()->result_array();

		// ======================================================================

		if($company_id!='')
			$this->db->where('sd.company_id',$company_id);

		if($area_id!='')
			$this->db->where('sd.area_id',$area_id);

		if($well_id!='')
			$this->db->where('dl.well_id',$well_id);

		$start_date_time = date("Y-m-d 06:00:00");
	    $end_date_time = date("Y-m-d 06:00:00", strtotime("+1 day"));

	   	$this->db->where('dl.log_date >=', $start_date_time);
	    $this->db->where('dl.log_date <', $end_date_time);

		$result['powerPrb'] = $this->db->select("count(DISTINCT dl.well_id) as total")
		->from('tbl_device_and_well_offline_log dl')
		->join('tbl_site_device_installation sd','dl.well_id=sd.well_id','left')
		->where(['dl.offline_reason'=>4,'dl.complete_status'=>0])->get()->result_array();

		return $result;
		
	}

	public function getMaintainanceDetails($company_id, $area_id, $well_id)
	{
	    if ($company_id != '') {
	        $this->db->where('sd.company_id', $company_id);
	    }

	    if ($area_id != '') {
	        $this->db->where('sd.area_id', $area_id);
	    }

	    if ($well_id != '') {
	        $this->db->where('of.well_id', $well_id);
	    }

	    $this->db->where('of.log_date >=', date("Y-m-d 06:00:00"));
	    $this->db->where('of.log_date <', date("Y-m-d 06:00:00", strtotime("+1 day")));

	    // Subquery to get the latest record for each well
	    $subQuery = '(SELECT MAX(log_date) FROM tbl_device_and_well_offline_log WHERE well_id = of.well_id)';
    	$this->db->where("of.log_date = $subQuery");

    	return $this->db->select("of.well_id, wm.well_name, of.imei_no, of.start_smps_voltage, of.start_battery_voltage, of.start_date_time, of.end_smps_voltage, of.end_battery_voltage, of.end_date_time, of.offline_reason, sd.olr_status, sd.elr_status, sd.spp_status, sd.output_Average_Current, sd.output_Average_Voltage_P2P, sd.output_System_Frequency, sd.output_Kwh")
	        ->from('tbl_device_and_well_offline_log of')
	        ->join('tbl_site_device_installation sd', 'of.well_id = sd.well_id', 'left')
	        ->join('tbl_well_master wm', 'of.well_id = wm.id', 'left')
	        ->where(['of.complete_status' => 0])
	        ->get()
	        ->result_array();
	}


	public function MaintananceDashboardMis_Report($company_id,$area_id,$well_id,$from_date,$to_date,$offline_reason)
	{
		if($company_id!='')
			$this->db->where('sd.company_id',$company_id);

		if($area_id!='')
			$this->db->where('sd.area_id',$area_id);

		if($well_id!='')
			$this->db->where('of.well_id',$well_id);

		if ($from_date != '' && $to_date != '') {
            $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));
            if ($from_date == $to_date) {
                $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            } else {
                $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            }
            $this->db->where('of.log_date >=', $fromTime);
            $this->db->where('of.log_date <', $toTime);
        }

        if($offline_reason!='')
			$this->db->where('of.offline_reason',$offline_reason);

		return $this->db->select("of.well_id,wm.well_name,of.imei_no,of.start_smps_voltage,of.start_battery_voltage,of.start_date_time,of.end_smps_voltage,of.end_battery_voltage,of.end_date_time,of.offline_reason,of.output_Kwh,of.avg_current,of.output_Average_Voltage_P2P,of.complete_status")
		->from('tbl_device_and_well_offline_log of')
		->join('tbl_site_device_installation sd','of.well_id=sd.well_id and sd.status = 1','left')
		->join('tbl_well_master wm','of.well_id=wm.id and wm.status = 1','left')
		->where(['of.status'=>1])
		->get()->result_array();

		
	}

	public function BatteryProblemGraph($well_id,$from_date,$to_date)
    {
        
       $result = [];

        if($well_id!='')
            $this->db->where('dl.well_id',$well_id);
        
        if ($from_date != '' && $to_date != '') {

            if($from_date == $to_date)
            {
                $to_datetime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            }else{
                $to_datetime = date('Y-m-d 06:00:00', strtotime($to_date));
            }

            $from_datetime = date('Y-m-d 06:00:00', strtotime($from_date));
            
            $this->db->where("dl.log_date >= '$from_datetime' AND dl.log_date < '$to_datetime'");
        }

        $result = $this->db->select("DATE_FORMAT(dl.log_date,'%Y-%m-%d') as x,dl.start_smps_voltage as y")
        ->from('tbl_device_and_well_offline_log dl')
        ->where(['dl.status' => 1,'dl.offline_reason'=>1])->order_by('dl.log_date','ASC')->get()->result_array();

        return $result;
        
    }
	    
}
?>