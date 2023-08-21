<?php
    // Do not confuse this bootstrap with the framework
    // used for initialization
    // load config 
    require_once 'config/config.php';
    // load helpers
    require_once 'helpers/urlHelper.php';
    require_once 'helpers/sessionHelper.php';

    // autoload core libraries
    spl_autoload_register(function($className){
        require_once 'libraries/' . $className . '.php';
    });


