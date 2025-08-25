<?php
date_default_timezone_set('Asia/Kolkata');
class Selfflow_alert_model extends CI_Model
{
    private $client;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('ClickHouseDB'); 
        $this->client = $this->clickhousedb->getClient(); 

        if (!$this->client->ping()) {
            log_message('error', 'ClickHouse connection failed');
            show_error('ClickHouse not connected');
        }
    }
    public function date_wise_Alert_Report($well_id, $date, $site_id, $alert_type)
    {
        $this->db->select("sd.well_id, wm.well_name, ws.well_site_name")
                 ->from('tbl_site_device_installtion_self_flow sd')
                 ->join('tbl_well_master wm', 'sd.well_id = wm.id', 'left')
                 ->join('tbl_well_site_master ws', 'sd.site_id = ws.id', 'left')
                 ->where('sd.status', 1);

        if ($well_id != '') $this->db->where('sd.well_id', $well_id);
        if ($site_id != '') $this->db->where('sd.site_id', $site_id);

        $mysqlData = $this->db->get()->result_array();

        if (empty($mysqlData)) {
            return [];
        }

        $wellMap = [];
        $wellIds = [];
        foreach ($mysqlData as $row) {
            $wellMap[$row['well_id']] = $row;
            $wellIds[] = $row['well_id'];
        }
        $from_date = date('Y-m-d 06:00:00', strtotime($date));
        $to_date   = date('Y-m-d 06:00:00', strtotime($date . ' +1 day'));

        $quotedWellIds = array_map(function($id) {
            return "'" . $id . "'";
        }, $wellIds);

        $sql = "SELECT well_id, alert_type, alert_details, start_date_time, end_date_time,
                       dateDiff('second', start_date_time, end_date_time) AS duration
                FROM tbl_alert_log_self_flow
                WHERE start_date_time >= '{$from_date}'
                  AND start_date_time < '{$to_date}'
                  AND well_id IN (" . implode(',', $quotedWellIds) . ")";

        if ($alert_type != '') {
            $sql .= " AND alert_type = '{$alert_type}'";
        }

        try {
            $clickhouseData = $this->client->select($sql)->rows();
        } catch (\Exception $e) {
            return [];
        }

        if (empty($clickhouseData)) {
            return [];
        }

        $final = [];
        foreach ($clickhouseData as $alert) {
            $wellInfo = $wellMap[$alert['well_id']] ?? [
                'well_id' => $alert['well_id'],
                'well_name' => '',
                'well_site_name' => ''
            ];
            $final[] = array_merge($wellInfo, $alert);
        }
        return $final;
    }

    public function Well_wise_Alert_Report($well_id, $site_id, $from_date, $to_date, $alert_type)
    {
        $from_date = date('Y-m-d 06:00:00', strtotime($from_date));
        $to_date   = date('Y-m-d 06:00:00', strtotime($to_date . ' +1 day'));

        $this->db->select("sd.well_id, wm.well_name, ws.well_site_name")
                 ->from('tbl_site_device_installtion_self_flow sd')
                 ->join('tbl_well_master wm', 'sd.well_id = wm.id', 'left')
                 ->join('tbl_well_site_master ws', 'sd.site_id = ws.id', 'left')
                 ->where('wm.status', 1);

        if ($well_id != '') $this->db->where('sd.well_id', $well_id);
        if ($site_id != '') $this->db->where('sd.site_id', $site_id);

        $mysqlData = $this->db->get()->result_array();
        if (empty($mysqlData)) return [];

        $wellMap = [];
        $wellIds = [];
        foreach ($mysqlData as $row) {
            $wellMap[$row['well_id']] = $row;
            $wellIds[] = $row['well_id'];
        }

        $sql = "SELECT well_id, alert_type, alert_details, start_date_time, end_date_time,
                       dateDiff('second', start_date_time, end_date_time) AS duration
                FROM tbl_alert_log_self_flow
                WHERE 1=1";

        $quotedWellIds = array_map(function($id) { return "'" . $id . "'"; }, $wellIds);
        $sql .= " AND well_id IN (" . implode(',', $quotedWellIds) . ")";

        if (!empty($from_date) && !empty($to_date)) {
            $sql .= " AND ((start_date_time >= '{$from_date}' AND start_date_time < '{$to_date}')
                          OR (end_date_time >= '{$from_date}' AND end_date_time < '{$to_date}'))";
        }

        if ($alert_type != '') {
            $sql .= " AND alert_type = '{$alert_type}'";
        }

        try {
            $clickhouseData = $this->client->select($sql)->rows();
        } catch (\Exception $e) {
            return [];
        }

        if (empty($clickhouseData)) return [];

        $final = [];
        foreach ($clickhouseData as $alert) {
            $wellInfo = $wellMap[$alert['well_id']] ?? [
                'well_id' => $alert['well_id'],
                'well_name' => '',
                'well_site_name' => ''
            ];
            $final[] = array_merge($wellInfo, $alert);
        }

        return $final;
    }




}
?>