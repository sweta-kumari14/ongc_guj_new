<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Graph_data_log_model extends CI_Model
{
		
	public function __construct() 
	{
        parent::__construct(); 
    }

    
    public function AlreadyexistImei($imei_no)
    {
        $result = $this->db->select("count(id) as total")
            ->from('tbl_graph_data_log')
            ->where(['imei_no'=>$imei_no])
            ->get()->result_array();

        if($result!='')
        {
            return $result[0]['total'];
        }else{
            return 0;
        }
    }

    public function ExistDetails($imei_no)
    {
       if($imei_no!='')
            $this->db->where('imei_no',$imei_no);

        return $this->db->select('*')->from('tbl_device_log')
        ->order_by('offline_device_timestamp', 'desc')->limit(1)->get()->result_array();
    }

    public function Device_log_detail_Save($data)
    {
        // print_r($data);die;
       return $this->db->insert('tbl_graph_data_log',$data);
    }

    public function log_time_less($imei_no)
    {
         if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);
        return $this->db->select('dl.*')
        ->from('tbl_device_log dl')
        ->join('tbl_graph_data_log gd' ,'dl.imei_no = gd.imei_no','left')
        ->where('TIMESTAMPDIFF(MINUTE, gd.log_date_time, dl.offline_device_timestamp ) >=',1 )
        ->order_by('dl.offline_device_timestamp', 'desc')
        ->limit(1)->get()->result_array();
    }

    public function Device_Details_Save($details)
    {
        return $this->db->insert('tbl_graph_data_log',$details);
    }

 


}
?>