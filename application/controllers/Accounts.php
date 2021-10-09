<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

////////////// index account controller  ///////////////////////////////////

 function index() {

 $totalRec = count((array)$this->web->getRows(array('table1' => 'accounts', 'search_column_id' => 'account_id', 'search_column1' => 'account_name', 'search_column2' => 'ph_number', 'search_column3' => 'date', 'search_column4' => 'description', 'search_column5' => 'account_number', 'where' => 'NULL')));
 //pagination configuration
 $config['target'] = '#postList';
 $config['base_url'] = base_url() . 'Accounts/ajaxPaginationData';
 $config['total_rows'] = $totalRec;
 $config['per_page'] = $this->perPage;
 $this->ajax_pagination->initialize($config);

 //get the posts data
 $this->data['accounts'] = $this->web->getRows(array('table1' => 'accounts', 'search_column_id' => 'account_id', 'search_column1' => 'account_name', 'search_column2' => 'ph_number', 'search_column3' => 'date', 'search_column4' => 'description', 'search_column5' => 'account_number', 'where' => 'NULL', 'limit' => $this->perPage));



// $this->data['accounts'] = $this->web->GetAll("account_id", "accounts");

 $this->load->view("accounts/all", $this->data);
 }


    function ajaxPaginationData() {

        $page = $this->input->post('page');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $search = $this->input->post('search');

        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        //total rows count
        $totalRec = count($this->web->getRows(array('table1' => 'accounts', 'search_column_id' => 'account_id', 'search_column1' => 'account_name', 'search_column2' => 'ph_number', 'search_column3' => 'date',
         'search_column4' => 'description', 'search_column5' => 'account_address', 'where' => 'accounts.account_number LIKE "%' . $search . '%"'), $date_from, $date_to, $search));

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'Accounts/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['accounts'] = $this->web->getRows(array('table1' => 'accounts', 'search_column_id' => 'account_id', 'search_column1' => 'account_name', 'search_column2' => 'ph_number', 'search_column3' => 'date', 'search_column4' => 'description', 'search_column5' => 'account_address',  'where' => 'accounts.account_number LIKE "%' . $search . '%"', 'start' => $offset, 'limit' => $this->perPage), $date_from, $date_to, $search);

        //load the view
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        $data['search'] = $search;
        $data['count'] = $offset + 1;


        $this->load->view('accounts/ajax-pagination-data', $data, false);
    }

    public function search() {
        $search_text = $this->input->post('id');
        $totalRec = count($this->web->getRows(array('table1' => 'accounts', 'search_column_id' => 'account_id', 'search_column1' => 'account_name', 'search_column2' => 'ph_number', 'search_column3' => 'date', 'search_column4' => 'description', 'search_column5' => 'account_address',  'where' => 'accounts.account_number LIKE "%' . $search_text . '%"'), NULL, NULL, $search_text));
//        $totalRec = 222;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'Accounts/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $this->ajax_pagination->initialize($config);

        //get the posts data

        $this->data['accounts'] = $this->web->getRows(array('table1' => 'accounts', 'search_column_id' => 'account_id', 'search_column1' => 'account_name', 'search_column2' => 'ph_number', 'search_column3' => 'date', 'search_column4' => 'description', 'search_column5' => 'account_address',  'where' => 'accounts.account_number LIKE "%' . $search_text . '%"', 'limit' => $this->perPage), NULL, NULL, $search_text);
        $this->data['search'] = $search_text;

        $this->load->view("accounts/all", $this->data);
    }

    function view() {
        $account_id = $this->uri->segment(3);
        $this->data['account'] = $this->web->GetOne("account_id", "accounts", $account_id);
        $this->data['account_type'] = $this->web->GetAll("account_type_id", "account_type");

        $this->load->view("accounts/edit", $this->data);
    }

    function edit() {
        $data = array();
        $data['account_name'] = $this->db->escape_str($this->input->post("name", true));
        $data['account_number'] = $this->db->escape_str($this->input->post("account_number", true));
        $data['ph_number'] = $this->db->escape_str($this->input->post("phone_number", true));
        $data['account_address'] = $this->db->escape_str($this->input->post("account_address", true));
        $data['opening_balance'] = $this->db->escape_str($this->input->post("opening_balance", true));
         $data['account_type'] = $this->db->escape_str($this->input->post("account_type", true));
        $data['description'] = htmlentities($this->input->post("desc", true));
        $id = $this->input->post("account_id", true);
        $this->web->Update("account_id", "accounts", $id, $data);
        redirect("accounts", "refresh");
    }

    function delete() {
        $account_id = $this->input->post("id", true);
        if ($this->web->Delete("account_id", "accounts", $account_id)) {
            echo "done";
        }
    }

    function add() {
        if ($this->input->post()) {
            $data = array();
            $data['account_name'] = $this->db->escape_str($this->input->post("name", true));
            $data['account_number'] = $this->db->escape_str($this->input->post("account_number", true));
            $data['ph_number'] = $this->db->escape_str($this->input->post("phone_number", true));
             $data['account_address'] = $this->db->escape_str($this->input->post("account_address", true));
            $data['opening_balance'] = $this->db->escape_str($this->input->post("opening_balance", true));
            $data['account_type'] = $this->db->escape_str($this->input->post("account_type", true));
            $data['description'] = htmlentities($this->input->post("desc", true));
            
            if ($this->web->Add("accounts", $data)) {
                redirect("accounts", "refresh");
            }
        } else {
            $this->data['account_number'] = $this->web->GetLastInsertedRow("account_number", "accounts");
            $this->data['account_type'] = $this->web->GetAll("account_type_id", "account_type");
//            $this->data['account_groups'] = $this->web->GetAll("account_group_id", "account_groups");
            $this->load->view("accounts/add", $this->data);
        }
    }

}
