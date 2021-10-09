<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

//    function GetAccounts($val) {
//
//        $accounts = $this->web->GetAll("account_id", "accounts");
//        foreach ($accounts as $account) {
//            $acc .= '<option value="' . $account->account_id . '">' . $account->account_name . '</option>';
//        }
//
//        echo $acc;
//    }
}
