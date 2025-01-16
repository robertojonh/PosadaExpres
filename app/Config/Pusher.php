<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pusher extends BaseConfig
{
    public $app_id = '';
    public $key = '';
    public $secret = '';
    public $cluster = '';
    public $useTLS = true;
}
