<?php

namespace app\integrations;


class MagazineLuiza extends BaseIntegration {

    private $account_id;
    private $account_config;


    public function __construct($account_id) 
    {

        $this->setConfig($account_id);
        
        if($this->account_config['env'] == 'S') {
            $this->set_api_root_url('https://api-sandbox.magalu.com'); 
        } else if($this->account_config['env'] == 'P') {
            $this->set_api_root_url('https://services.magalu.com'); 
        }


    }

    private function setConfig($account_id)
    {

        $this->account_config = [];
    }

}