<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("login_model", 'login');
        $this->load->model("web_model", 'web');
    }

    public function index() {
        if (CheckSess() == TRUE) {
            redirect('dashboard', 'refresh');
        }
        $this->load->view('login');
    }

    public function confirm() {
         // die($_POST['email'] . " " . $_POST['password']);
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmed = $this->login->CheckLogin($email, $password);
        $general_setting = $this->web->GetAll("g_s_id", "general_setting");
        //die('we are here');
        if ($confirmed) {
            $newdata = array(
                'email' => $confirmed[0]->email,
                'name' => $confirmed[0]->name,
                'user_id' => $confirmed[0]->id,
                'user_group_id' => $confirmed[0]->user_group_id,
                'company_logo' => $general_setting[0]->company_logo,
                'company_view_logo' => $general_setting[0]->company_view_logo,
                'company_invoice_logo' => $general_setting[0]->company_invoice_logo,
                'company_name' => $general_setting[0]->company_name,
                'currency_symbol' => $general_setting[0]->currency_symbol,
                'company_address' => $general_setting[0]->company_address,
                'logged_in' => TRUE,
                'failed' => false
            );
            $this->session->set_userdata($newdata);
            echo "done";
        } else {
            $newdata = array(
                'failed' => TRUE
            );
            $this->session->set_userdata($newdata);
            echo "failed";
        }
      // die($email . " " . $password);
    }

    public function failed() {
        $newdata = array(
            'failed' => false
        );
        $this->session->set_userdata($newdata);
        echo "done";
    }

    function logout() {
        $this->session->sess_destroy();
        redirect("login", "refresh");
    }

}
