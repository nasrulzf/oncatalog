<?php

class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

}


class API_Controller extends MY_Controller {
    
    private $function_id = '';
    private $resultObject;

    public function __construct()
    {
        parent::__construct();

        $this->config->load('nocs');
        $this->load->library('encryption');
        $this->load->helper('jwt');
    }

    private function get_session()
    {
        return array(
            'UID' => 'NZ001',
            'RID' => 'ADM',
            'NAME' => 'Nasrul Aziz Gifari'
        );
    }

    private function set_json_ouput($result)
    {
        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
    }

    public function token_encrypt($object)
    {
        $key = $this->config->item('encrypt_key');
        $tokenResult = JWT::encode($object, $key);
        return $tokenResult;
    }

    private function token_decrypt($token)
    {
        $key = $this->config->item('encrypt_key');
        $object = JWT::decode($token, $key);
        return $object;
    }

    protected function authorized_token_checking()
    {
        $token = $this->input->get_request_header('token', true);

        // Algorithm
        // Get Token -> Decrypt Token -> Check Session and User ID -> If Valid Return TRUE Else Return FALSE
        
        date_default_timezone_set('Asia/Jakarta');

        if(isset($token))
        {
            $obj = $this->token_decrypt($token);
            $valid_datetime = new DateTime($obj->valid_until->date);

            if($valid_datetime > new DateTime())
            {
                return $obj;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }

    }

    protected function authorize_role_checking($UserTokenObject)
    {
        
    }

    protected function set_function_id($function_id)
    {
        $this->function_id = $function_id;
    }

    protected function generate_result($param, $result_status = null, $result_message = null)
    {
        if(empty($result_status) || empty($result_message))
        {
            $this->resultObject = new API_Result($param, '200', 'OK');
        }
        else
        {
            $this->resultObject = new API_Result($param, $result_status, $result_message);
        }
    }

    protected function load()
    {
        if(is_object($this->resultObject))
        {
            $this->set_json_ouput($this->resultObject);
        }
        else
        {
            echo json_encode('');
        }
    }

}

class API_Result {

    public $list;
    public $total;
    public $status_result;
    public $status_message;

    public function __construct($list, $status_result, $status_message)
    {
        $this->list = $list;
        if(is_array($list))
        {
            $this->total = count($list);
        }
        $this->status_result = $status_result;
        $this->status_message = $status_message;
    }


}

class UserToken {
    
    public $user_id;
    public $valid_until;
    public $create_date;
    public $ip_address;

    public function __construct($user_id, $valid_until, $create_date, $ip_address)
    {
        $this->user_id      = $user_id;
        $this->valid_until  = $valid_until;
        $this->create_date  = $create_date;
        $this->ip_address   = $ip_address;
    }

}

class Response {

    public static $CODE = array(
        "200" => "OK",
        "201" => "Created",
        "202" => "Accepted",
        "203" => "Non-Authoritative Information",
        "204" => "No Content",
        "400" => "Bad Request",
        "404" => "Not Found",
        "500" => "Internal Server Error"
    );

}