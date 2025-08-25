<?php
require_once APPPATH . '../vendor/autoload.php';

use ClickHouseDB\Client;

class ClickHouseDB {
    private $client;
    public function __construct() {
        $config = [
            'host' => '127.0.0.1',
            'port' => '8123',
            'username' => 'default',
            'password' => ''
        ];

        $this->client = new Client($config);
        $this->client->database('ongc_guj_db'); // Change this
    }

    public function getClient() {
        return $this->client;
    }
}

