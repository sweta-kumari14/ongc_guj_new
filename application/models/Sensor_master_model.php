<?php
class Sensor_master_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function verify_sensorExist($sensor_no)
    {
        $res = $this->db->select("count(id) as total")
                        ->from('tbl_sensor_master')
                        ->where(['sensor_no' => $sensor_no, 'status' => 1])
                        ->get()->result_array();

        return !empty($res) ? $res[0]['total'] : 0;
    }
    public function getDevID()
    {
        return $this->db->select("UUID()")->get()->result_array();
    }

    // Add a new device (sensor)
    public function AddDevice($data)
    {
        return $this->db->insert('tbl_sensor_master', $data);
    }
    public function DEviceList($id = null)
    {
        $this->db->select('*');
        $this->db->from('tbl_sensor_master');
        $this->db->where('status', 1);

        if (!empty($id)) {
            $this->db->where('id', $id);
        }

        return $this->db->get()->result_array();
    }
    public function verify_sensorExist_OrNot($sensor_no, $id)
    {
        $this->db->where('sensor_no', $sensor_no);
        $this->db->where('id !=', $id);
        return $this->db->count_all_results('tbl_sensor_master');
    }

    // Update sensor data
    public function Update_DeviceData($data, $where)
    {
        $this->db->where($where);
        return $this->db->update('tbl_sensor_master', $data);
    }

    // Get device by its ID
    public function get_device_by_id($id)
    {
        return $this->db->get_where('tbl_sensor_master', ['id' => $id])->row_array();
    }

    // Soft delete (or update) a sensor
    public function Delete_Device($data, $where)
    {
        return $this->db->update('tbl_sensor_master', $data, $where);
    }

    public function getSensorTypeBySensorId($sensor_id)
    {
        $this->db->select('sm.*, im.item_name as sensor_type');
        $this->db->from('tbl_sensor_master sm');
        $this->db->join('tbl_item_master im', 'sm.item_id = im.id', 'left');
        $this->db->where('sm.id', $sensor_id);

        return $this->db->get()->row_array();
    }
    public function getAllSensorsWithType()
    {
        $this->db->select('sm.*, im.item_name as sensor_type');
        $this->db->from('tbl_sensor_master sm');
        $this->db->join('tbl_item_master im', 'sm.item_id = im.id', 'left');
        $this->db->where('sm.status', 1);
        return $this->db->get()->result_array();
    }
}
?>
