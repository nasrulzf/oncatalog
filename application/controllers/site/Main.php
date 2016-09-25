<?php

class Main extends API_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        parent::set_function_id('NZ001');

        $arr = array(1, 2, 3, 4, 5, 6, 7, 8, 9);

        try
        {
            parent::generate_result($arr);
        }
        catch(Exception $e)
        {
            echo "error";
        }

        parent::load();
    }

}