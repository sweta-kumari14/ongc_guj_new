<?php
class Device_billing_report_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
  

    public function getDevice_BillingDetails($well_id, $from_date, $to_date)
    {
        if ($well_id != '') {
            $this->db->where('sd.well_id', $well_id);
        }

        if ($site_id != '') {
            $this->db->where('sd.site_id', $site_id);
        }

        if ($from_date != '' && $to_date != '') {
            $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));
            if ($from_date == $to_date) {
                $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            } else {
                $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            }
            $this->db->where('wrl.last_log_datetime >=', $fromTime);
            $this->db->where('wrl.last_log_datetime <', $toTime);
        }


        $result = [];

     
        $columns_count_query = $this->db->query("SELECT COUNT(*) as total_columns 
                                                 FROM INFORMATION_SCHEMA.COLUMNS 
                                                 WHERE table_schema = 'ongc_guj_db'
                                                 AND TABLE_NAME = 'tbl_historical_device_log'");
        $result['columns_count'] = $columns_count_query->row()->total_columns;

       
        $device_data = $this->db->select('wm.well_name, dm.device_name, ws.well_site_name, wrl.last_log_datetime, COUNT(wrl.id) as total')
                                ->from('tbl_historical_device_log wrl')
                                ->join('tbl_site_device_installation sd', 'wrl.well_id = sd.well_id', 'left')
                                ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                                ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
                                ->join('tbl_device_setup dm', 'sd.imei_no = dm.imei_no and dm.status = 1', 'left')
                                ->where(['wrl.status' => 1, 'sd.status' => 1])
                                ->group_by('sd.well_id, DATE(wrl.last_log_datetime)') 
                                ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                                ->order_by('wrl.last_log_datetime','ASC')
                                ->get()->result_array();

               $deviceDetails = [];

                foreach ($device_data as $row) {

                    $WellNo = $row['well_name'];
                    $deviceNo = $row['device_name'];
                    $areaName = $row['well_site_name'];
                    $formattedDate = date('j F y', strtotime($row['last_log_datetime']));
                    $multipliedValue = $result['columns_count'] * $row['total'];
                    $deviceDetails[$WellNo]['well_name'] = $WellNo;
                    $deviceDetails[$WellNo]['device_name'] = $deviceNo;
                    $deviceDetails[$WellNo]['well_site_name'] = $areaName;
                    $deviceDetails[$WellNo]['count_data'][] = [
                        'last_log_datetime' => $formattedDate,
                        'total' => $row['total'],
                        'total_value' => $multipliedValue,
                        
                    ];
                }
            $deviceDetails = array_values($deviceDetails);

             return $device_data;
    }



}
?>
