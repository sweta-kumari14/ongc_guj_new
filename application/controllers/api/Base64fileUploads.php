<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Base64fileUploads { 
    
    function is_base64($s){
        //print_r($s);die;
        // Check if there are valid base64 characters
       if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s)) return false;
        // Decode the string in strict mode and check the results

        $decoded = base64_decode($s, true);
       // print_r($s); die;
        if(false === $decoded) return false;
        // Encode the string again
        if(base64_encode($decoded) != $s) return false;
        return true;
    }
    
    public function du_uploads($path,$base64string){
        if($this->is_base64($base64string) == true){  
            $base64string = "data:image/jpeg;base64,".$base64string;
            //$this->check_size($base64string);
            //$this->check_dir($path);
            $this->check_file_type($base64string);
            
            /*=================uploads=================*/
            list($type, $base64string) = explode(';', $base64string);
            list(,$extension)          = explode('/',$type);
            list(,$base64string)       = explode(',', $base64string);
            $fileName                  = uniqid().date('Y_m_d').'.'.$extension;
            $base64string              = base64_decode($base64string);
            //print_r($fileName);die;
            file_put_contents($path.$fileName, $base64string);
            return $fileName;
        }else{
            print_r(json_encode(array('status' =>false,'message' => 'This Base64 String not allowed !')));exit;
        }
    }
    
    public function check_size($base64string){
        $file_size = 8000000;
        $size = @getimagesize($base64string);
        print_r($size);die;
        if($size['bits'] >= $file_size){
            print_r(json_encode(array('status' =>false,'message' => 'file size not allowed !')));exit;
        }
        return true;
    }
    
    public function check_dir($path){
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
            return true;
        }
        return true;
    }
    
    public function check_file_type($base64string){
        $mime_type = @mime_content_type($base64string);
        // print_r(json_encode(array('status' =>false,'message' => $mime_type)));exit;
        $allowed_file_types = ['image/jpg', 'image/jpeg','image/png'];
        if (! in_array($mime_type, $allowed_file_types)) {
            // File type is NOT allowed
           print_r(json_encode(array('status' =>false,'message' => 'File type is NOT allowed !')));exit;
        }
        return true;
    }
} ?>