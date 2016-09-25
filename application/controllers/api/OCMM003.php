<?php

class OCMM003 extends API_Controller
{
    public function __constructor()
    {
        parent::__construct();
        $this->load->model('OCMM003_Model', 'OCMM003DB');
    }

    public function lists()
    {
        $list = '';
        $result_code = '';

        try
        {
            if(parent::authorized_token_checking())
            {
                $list = $this->OCMM003DB->get_all();
                $result_code = '200';
            }
            else
            {
                $result_code = '400';
            }
        }
        catch(Exception $e)
        {
            $result_code = '400';
        }
        
        parent::generate_result($list, $result_code, Response::$CODE[$result_code]);
        parent::load();

    }

    public function find($id)
    {
        $list = '';
        $result_code = '';

        try
        {
            if(parent::authorized_token_checking())
            {
                $list = $this->OCMM003DB->get($id);
                $result_code = '200';
            }
            else
            {
                $result_code = '400';
            }
        }
        catch(Exception $e)
        {
            $result_code = '400';
        }
        
        parent::generate_result($list, $result_code, Response::$CODE[$result_code]);
        parent::load();
    }

    public function insert()
    {
        $list = '';
        $result_code = '';

        try
        {
            $authorized_token = parent::authorized_token_checking();
            if($authorized_token)
            {
                $authorized_user = $this->OCMM000DB->get_id($authorized_token->user_id);

                $insert = array(
                    'NAME' => $this->input->post('name'),
                    'DESCRIPTION' => $this->input->post('description'),
                    'CREATED_BY' => $authorized_user['name']
                );

                $list = $this->OCMM003DB->insert($insert);
                $result_code = '201';
            }
            else
            {
                $result_code = '400';
            }
        }
        catch(Exception $e)
        {
            $result_code = '400';
        }
        
        parent::generate_result($list, $result_code, Response::$CODE[$result_code]);
        parent::load();
    }

    public function update()
    {
        $list = '';
        $result_code = '';

        try
        {
            $authorized_token = parent::authorized_token_checking();
            if($authorized_token)
            {
                $authorized_user = $this->OCMM000DB->get_id($authorized_token->user_id);

                $condition = $this->input->post('id');

                $value = array(
                    'NAME' => $this->input->post('name'),
                    'DESCRIPTION' => $this->input->post('description'),
                    'UPDATED_BY' => $authorized_user['name']
                );

                $list = $this->OCMM003DB->update($condition, $value);
                $result_code = '200';
            }
            else
            {
                $result_code = '400';
            }
        }
        catch(Exception $e)
        {
            $result_code = '400';
        }
        
        parent::generate_result($list, $result_code, Response::$CODE[$result_code]);
        parent::load();
    }

}