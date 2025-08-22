<?php

namespace app\controllers\config;

class MarketplaceController extends ConfigController
{
    public function indexAccounts()
    { 
        $this->view('account', ['title' => 'Contas', 'name' => 'account']);
    }

}
