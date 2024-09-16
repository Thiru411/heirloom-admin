<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require __DIR__.'/../../vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


class Firebase {

    protected $config	= array();
    protected $serviceAccount;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    
    public function init()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/heirloom-cb3a0-firebase-adminsdk-e9n9r-5eb562224f.json');
        return $firebase = (new Factory)
           ->withServiceAccount($serviceAccount)
           ->withDatabaseUri('https://heirloom-cb3a0-default-rtdb.firebaseio.com/')
           ->create();
    }
}