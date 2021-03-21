<?php 

    require_once('./vendor/autoload.php');
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    define("API",  $_ENV["DEBUG"] );

    if($_ENV["ENVIRONMENT"] == "dev"){  
        $path = 'localhost/apiv1/';
    }else{
        $path =  $_SERVER['REMOTE_ADDR'];
    }
    define('PATH', $path );
    define('VIEWS', PATH . '/views/'); 

    if( $_ENV["DEBUG"] ){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting( E_ALL );
    }
