<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    var $data;

    public function __construct() {
        parent::__construct();

        $this->load->model("web_model", "web");
        $this->load->library('Ajax_pagination');
        $this->perPage = 10;

        if (CheckSess() == FALSE) {
            redirect('login', 'refresh');
        }
        // print_r($this->session->userdata());
        // die();
        $sidebar_modules = $this->web->GetSidebarMenu();
        // print_r($sidebar_modules); die();
        $this->data['menu'] = GenerateMenu($sidebar_modules);
//        $this->data['sidebar_modules'] = $this
    }

    function logout() {
        // $this->session->sess_destroy();
        // redirect('login', 'refresh');
    }

}
