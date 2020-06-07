<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {

    }

    public function index()
    {
        $arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);    

   //add the header here
    header('Content-Type: application/json');
    echo json_encode( $arr );
    }

    public function check_database()
    {
        
        ini_set('display_errors', 'Off');
        
        //  Load the database config file.
        if(file_exists($file_path = APPPATH.'config/database.php'))
        {
            include($file_path);
        }
        
        $config = $db[$active_group];
        
        //  Check database connection if using mysqli driver
        if( $config['dbdriver'] === 'mysqli' )
        {
            $mysqli = new mysqli( getenv('DB_HOSTNAME') , getenv('DB_USERNAME') , getenv('DB_PASSWORD') , getenv('DB_DATABASE') );
            if( !$mysqli->connect_error )
            {
                echo "true";
            }
            else{
                echo "false";
            }
        }
        else
        {
            return false;
        }
    } 

}

/* End of file Controllername.php */
