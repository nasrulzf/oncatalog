<?php

// Login API

class OCMM000 extends API_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('OCMM000_Model', 'OCMM000DB');  
    }

    public function lists()
    {
        $list = '';
        $status_code = '';

        try
        {
            $authorize_token = parent::authorized_token_checking();
            if($authorize_token)
            {
                $list = $this->OCMM000DB->get_all($authorize_token->user_id);
                $status_code = '200';
            }
            else
            {
                $status_code = '400';
            }
        }
        catch(Exception $e)
        {
            $status_code = '400';
        }

        parent::generate_result($list, $status_code, Response::$CODE[$status_code]);
        parent::load();

    }

    public function find($id)
    {
        $list = '';
        $status_code = '';

        try
        {
            $authorize_token = parent::authorized_token_checking();
            if($authorize_token)
            {
                $list = $this->OCMM000DB->get($id);
                $status_code = '200';
            }
            else
            {
                $status_code = '400';
            }
        }
        catch(Exception $e)
        {
            $status_code = '400';
        }

        parent::generate_result($list, $status_code, Response::$CODE[$status_code]);
        parent::load();

    }

    public function insert()
    {
        $list = '';
        $status_code = '';

        try
        {
            $authorize_token = parent::authorized_token_checking();
            if($authorize_token)
            {
                $authorize_user = $this->OCMM000DB->get_username($authorize_token->user_id);
                
                $insert = array(
                    'NAME' => $this->input->post('name'),
                    'USERNAME' => $this->input->post('username'),
                    'ROLE_ID' => $this->input->post('roleid'),
                    'CREATED_BY' => $authorize_user['name']
                );

                $this->OCMM000DB->insert($insert);

                $status_code = '201';
            }
            else
            {
                $status_code = '400';
            }
        }
        catch(Exception $e)
        {
            $status_code = '400';
        }

        parent::generate_result($list, $status_code, Response::$CODE[$status_code]);
        parent::load();
    }

    public function update()
    {
        $list = '';
        $status_code = '';

        try
        {
            $authorize_token = parent::authorized_token_checking();
            if($authorize_token)
            {
                $authorize_user = $this->OCMM000DB->get_username($authorize_token->user_id);
                
                $condition = $this->input->post('id');

                $value = array(
                    'NAME' => $this->input->post('name'),
                    'PASSWORD' => $this->input->post('password'),
                    'ROLE_ID' => $this->input->post('roleid'),
                    'UPDATED_BY' => $authorize_user['name']
                );

                $this->OCMM000DB->update($condition, $value);

                $status_code = '200';
            }
            else
            {
                $status_code = '400';
            }
        }
        catch(Exception $e)
        {
            $status_code = '400';
        }

        parent::generate_result($list, $status_code, Response::$CODE[$status_code]);
        parent::load();
    }

    public function delete()
    {
        $list = '';
        $status_code = '';

        try
        {
            $authorize_token = parent::authorized_token_checking();
            if($authorize_token)
            {
                $authorize_user = $this->OCMM000DB->get_username($authorize_token->user_id);
                
                $condition = $this->input->post('id');

                $this->OCMM000DB->delete($condition);

                $status_code = '200';
            }
            else
            {
                $status_code = '400';
            }
        }
        catch(Exception $e)
        {
            $status_code = '400';
        }

        parent::generate_result($list, $status_code, Response::$CODE[$status_code]);
        parent::load();
    }

    public function login()
    {

        $code_result = '';
        $result = '';

        try
        {
            $authorize_token = parent::authorized_token_checking();
            if(!$authorize_token)
            {
                $username = $this->input->post('username');
                $password = $this->input->post('password');

                $result = $this->OCMM000DB->get_username($username);
                if($result)
                {
                    if($this->OCMM000DB->get_password($username, $password) > 0)
                    {

                        $current_date = new DateTime();
                        $valid_until = $current_date->add(new DateInterval('PT10M0S'));
                        $token = new UserToken(
                            $result['id'], 
                            $valid_until,
                            $current_date,
                            $this->input->ip_address()
                        );
                        
                        $result = array(
                            'token' => parent::token_encrypt($token)
                        );
                        $code_result = "200";

                    }
                    else
                    {
                        // Username Found but Incorrect Password
                        $code_result = '400';
                    }
                }
                else
                {
                    // Username Not Found
                    $code_result = '400';
                }
            }
            else
            {
                $result = array(
                    'token' => parent::token_encrypt($authorize_token)
                );
                $code_result = "200";
            }
        }
        catch(Exception $e)
        {
            $code_result = '400';
        }

        parent::generate_result($result, $code_result, Response::$CODE[$code_result]);
        parent::load();

    }

}