<?php
    //DB Params
    define('DB_HOST', 'localhost');
    define('DB_USER', 'dbadmin');
    define('DB_PASS', 'MuniB0nds!001');
    define('DB_NAME', 'mhddb');
    
    define('API_USER', 'Authorization: Basic YXBpdXNlci1mMGYwMzEyN2U5ODBAYXBpY29ubmVjdG9yLmNvbTpTYTFsMHIhMDAx');
    
    // app root
    define('APPROOT', dirname(dirname(__FILE__)));
    //define('APPROOT', 'https://munihubdev.com/development/reports/app');
    // URL root
    define('URLROOT', 'https://munihubdev.com/development/reports');
    
    define('MUNIHUBURL', 'https://munihubdev.com/');
    // Site Name
    define('SITENAME', 'MuniHub MuniTrack Reports');
    // App Version
    define('APPVERSION', '1.1.0');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);