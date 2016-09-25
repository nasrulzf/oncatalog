<?php


// Master Categories API

class OCMM006 extends API_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('OCMM006_Model', 'OCMM006DB');
    }

    public function lists()
    {

        $list = '';
        $result_code = '';

        try
        {
            if(parent::authorized_token_checking())
            {
                $list_result = $this->OCMM006DB->get_all();
                $list = $list_result;
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
                $list_result = $this->OCMM006DB->get($id);
                $list = $list_result;
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
                    'TITLE' => $this->input->post('title'),
                    'DESCRIPTION' => $this->input->post('description'),
                    'CREATED_BY' => $authorized_user['name']
                );

                $this->OCMM006DB->insert($insert);
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
                    'TITLE' => $this->input->post('title'),
                    'DESCRIPTION' => $this->input->post('description'),
                    'UPDATED_BY' => $authorized_user['name']
                );

                $this->OCMM006DB->update($condition, $value);
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

    public function delete()
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

                $this->OCMM006DB->delete($condition);
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