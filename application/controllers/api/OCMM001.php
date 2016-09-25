<?php


// Master System API

class OCMM001 extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('OCMM001_Model', 'OCMM001DB');
        $this->load->model('OCMM000_Model', 'OCMM000DB');
    }

    public function find($sys_cat = '', $sys_sub_cat = '', $sys_code = '')
    {
        $row = $this->OCMM001DB->get($sys_cat, $sys_sub_cat, $sys_code);
        parent::generate_result($row, "200", Response::$CODE["200"]);
        parent::load();
    }

    public function get()
    {
        $list = $this->OCMM001DB->get_all();
        parent::generate_result($list, 200, 'OK');
        parent::load();
    }

    public function insert()
    {
        $code_result = "";

        $result = array();

        try
        {
            $authorized_token = parent::authorized_token_checking();
            if($authorized_token)
            {
                $authorized_user = $this->OCMM000DB->get_id($authorized_token->user_id);
                // Perform insert operation
                $insert = array(
                    'SYS_CATEGORY' => $this->input->post('sys_category'),
                    'SYS_SUB_CATEGORY' => $this->input->post('sys_sub_category'),
                    'SYS_CODE' => $this->input->post('sys_code'),
                    'SYS_VALUE' => $this->input->post('sys_value'),
                    'CREATED_BY' => $authorized_user['name']
                );
                $list = $this->OCMM001DB->insert($insert);
                $code_result = "201";
            }
            else
            {
                $code_result = "400";
            }
        }
        catch(Exception $e)
        {
            $code_result = "400";
        }
        
        parent::generate_result($result, $code_result, Response::$CODE[$code_result]);
        parent::load();
    }

    public function update()
    {
        $code_result = "";

        $result = array();

        try
        {
            $authorized_token = parent::authorized_token_checking();
            if($authorized_token)
            {

                $authorized_user = $this->OCMM000DB->get_id($authorized_token->user_id);

                // Perform an update operation

                $value = $this->input->post('sys_value');

                $condition = array(
                    'SYS_CATEGORY' => $this->input->post('sys_category'),
                    'SYS_SUB_CATEGORY' => $this->input->post('sys_sub_category'),
                    'SYS_CODE' => $this->input->post('sys_code'),
                    'CREATED_BY' => $authorized_user['name']
                );
                $list = $this->OCMM001DB->update($condition, $value);
                $code_result = "200";
            }
            else
            {
                $code_result = "400";
            }
        }
        catch(Exception $e)
        {
            $code_result = "400";
        }

        parent::generate_result($result, $code_result, Response::$CODE[$code_result]);
        parent::load();
    }

    public function delete()
    {
        $code_result = "";

        $result = array();

        if(parent::authorized_token_checking())
        {
            // Perform delete operation
            $condition = array(
                'SYS_CATEGORY' => $this->input->post('sys_category'),
                'SYS_SUB_CATEGORY' => $this->input->post('sys_sub_category'),
                'SYS_CODE' => $this->input->post('sys_code')
            );
            $list = $this->OCMM001DB->delete($condition);
            $code_result = "200";
        }
        else
        {
            $code_result = "400";
        }
        
        parent::generate_result($result, $code_result, Response::$CODE[$code_result]);
        parent::load();
    }

}