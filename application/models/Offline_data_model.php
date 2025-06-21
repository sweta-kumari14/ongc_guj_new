<?php
class Offline_data_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function well_offline_data($well_id,$from_date, $to_date)
    {
	    if ($from_date != '' && $to_date != '') {
	        $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));
	        $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
	        
	    }
     
		    $sql = "
		        SELECT *
		        FROM (
		           SELECT 
	                id,
	                well_id,
	                imei_no,
	                last_log_datetime,
	                frame_number,
	                LAG(last_log_datetime, 1) OVER (ORDER BY last_log_datetime) AS previous_event_time,
	                LAG(frame_number, 1) OVER (ORDER BY last_log_datetime) AS previous_frame_number,
	                TIMESTAMPDIFF(MINUTE, LAG(last_log_datetime, 1) OVER (ORDER BY last_log_datetime), last_log_datetime) AS time_diff_minute
		            FROM (
		                SELECT
		                    id,
		                    well_id,
		                    imei_no,
		                    last_log_datetime,frame_number
		                FROM
		                    tbl_historical_device_log
		                WHERE
		                    well_id = ?
		                    AND last_log_datetime >= ?
		                    AND last_log_datetime < ?
		                ORDER BY
		                    last_log_datetime ASC
		            ) t1
		        ) t2
		        WHERE t2.time_diff_minute > 5;
		    ";

		    $query = $this->db->query($sql, array($well_id,$fromTime, $toTime));
		    $result = $query->result_array();

           return $result;
		   
		
    }




}
?>