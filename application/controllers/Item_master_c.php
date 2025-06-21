<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Item_master_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {    
            $d['v'] = "item_list";
            $this->load->view('templates',$d); 
        }
            public function items_list_data()
        {
            $api = 'Item_master/Item_List';
            $data = '';
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
        public function add_item_name()
        {
            $api = 'Item_master/AddItem';
            $data = 'company_id='."10a542c3-b393-11ee-a6d4-5cb9"
                    .'&item_name='.$this->input->post('item_name',true)
                    .'&c_by='."1"
                    ."&item_type=".$this->input->post('item_type',true);
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
         public function getitems_details()
        {
            $api = 'Item_master/Item_List';
            $data = 'id='.$this->input->post('id',true);
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function update_item_data()
        {
            $userId = htmlspecialchars((string)$this->session->userdata('id'));
            $api = 'Item_master/UpdateItem';
            $data ='id='.htmlspecialchars((string)$this->input->post('id',true),ENT_QUOTES,'UTF-8')
            .'&item_name='.htmlspecialchars((string)$this->input->post('item_name',true),ENT_QUOTES,'UTF-8')
            .'&d_by='.$userId;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
public function delete_item_data()
{
    // Start session or use CodeIgniter session library
    $userId = $this->session->userdata('user_id'); // adjust 'user_id' to your session key

    if (!$userId) {
        // If user is not logged in or session expired, send error response
        header('Content-Type: application/json');
        echo json_encode([
            'response_code' => 401,
            'msg' => 'Unauthorized. Please login first.',
            'status' => false
        ]);
        return;
    }

    $id = $this->input->post('id', true);

    $result = $this->CallAPI('Item_master/deleteItem', 'id=' . $id . '&d_by=' . $userId, 'POST');

    header('Content-Type: application/json');
    echo json_encode($result);
}

    }
?>