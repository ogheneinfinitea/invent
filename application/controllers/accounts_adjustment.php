<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class accounts_adjustment extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $this->data['ledger'] = $this->web->GetAllAdjustment();


        // print_r($this->data['ledger']); die();
        $this->load->view("accounts_adjustment/all", $this->data);
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
        $totalRec = count($this->web->getRows(array('table1' => 'accounts', 'search_column_id' => 'ledger_id', 'search_column1' => 'account_name', 'search_column2' => 'ph_number', 'search_column3' => 'date',
         'search_column4' => 'description', 'search_column5' => 'account_address', 'where' => 'accounts.account_number LIKE "%' . $search . '%"'), $date_from, $date_to, $search));

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'accounts_adjustment/ajaxPaginationData';
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


        $this->load->view('accounts_adjustment/ajax-pagination-data', $data, false);
    }





    function view() {
        $batch_id = $this->uri->segment(3);
//        $this->data['batch'] = $this->web->GetOneWithInner("product_id", "products", "batches", "product_id", "units", "unit_id", $batch_id);
         $this->data['ledger'] = $this->web->GetAllAdjustment();
        // $this->data['batch'] = $this->web->GetBatches($batch_id);
       // $this->data['products'] = $this->web->GetAllWithInner("product_id", "products", "units", "unit_id", "product_categories", "product_category_id");
        $this->load->view("accounts_adjustment/edit", $this->data);
    }

function view_adjustment() {
        $ledger_id = $this->uri->segment(3);
    //     $this->data['ledger'] = $this->web->GetAllAdjustment();
//        $this->data['invoice'] = $this->web->GetOneWithInner('invoice_id', 'invoice', "accounts", "account_id", NULL, NULL, $invoice_id);
         $query = "SELECT ledger.*,accounts.*, ledger.description as ledger_desc, accounts.description as account_desc,ledger.date as ledger_date,ledger.description as ledger_desc FROM ledger INNER JOIN accounts ON ledger.account_id = accounts.account_id WHERE ledger.ledger_id = '" . $ledger_id . "' ORDER BY ledger.ledger_id ASC";

        $query = $this->db->query($query);
        $this->data['ledger'] = $query->result();
//        $this->data['invoice_items'] = $this->web->GetInvoiceItems($invoice_id);
        $this->load->view("accounts_adjustment/view_adjustment", $this->data);
    }

    function print_adjustment() {
        $ledger_id = $this->uri->segment(3);
          $this->data['ledger'] = $this->web->GetAllAdjustment();
//        $this->data['invoice'] = $this->web->GetOneWithInner('invoice_id', 'invoice', "accounts", "account_id", NULL, NULL, $invoice_id);
        $query = "SELECT ledger.*,accounts.*, ledger.description as ledger_desc, accounts.description as account_desc,ledger.date as ledger_date,ledger.description as ledger_desc FROM ledger INNER JOIN accounts ON ledger.account_id = accounts.account_id WHERE ledger.ledger_id = '" . $ledger_id . "' ORDER BY ledger.ledger_id ASC";
        $query = $this->db->query($query);
        $this->data['ledger'] = $query->result();
       // $this->data['invoice_items'] = $this->web->GetInvoiceItems($invoice_id);
        $this->load->view("accounts_adjustment/print_adjustment", $this->data);
    }



    function edit($id) {
        $data = array();
        $data['batch_no'] = $this->db->escape_str($this->input->post("number", true));
        $data['product_id'] = $this->db->escape_str($this->input->post("product", true));
        $data['max_qty'] = $this->db->escape_str($this->input->post("qty", true));
//        $id = $this->input->post("batch_id", true);
        $this->web->Update("batch_id", "batches", $id, $data);
        redirect("batch", "refresh");
    }

    function delete() {
        $batch_id = $this->input->post("id", true);
        if ($this->web->Delete("batch_id", "batches", $batch_id)) {
            echo "done";
        }
    }

    function add() {
        if ($this->input->post()) {
            $data = array();
            $data['date'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("date", true)))) . " " . date("H:i:s");
            $data['account_id'] = $this->db->escape_str($this->input->post("account", true));
            $data['debit_amount'] = $this->db->escape_str($this->input->post("debit_amount", true));
            $data['credit_amount'] = $this->db->escape_str($this->input->post("credit_amount", true));
            $data['description'] = $this->db->escape_str($this->input->post("adj_no", true));
            $data['description'] = $this->db->escape_str($this->input->post("desc", true));
            $data['type'] = 'adjustment';
            if ($this->web->Add("ledger", $data)) {
                redirect("accounts_adjustment", "refresh");
            }
        } else {
            $this->data['accounts'] = $this->web->GetAll("account_id", "accounts");

        //    $this->data['products'] = $this->web->GetAllWithInner("product_id", "products", "units", "unit_id", "product_categories", "product_category_id");
            $this->load->view("accounts_adjustment/add", $this->data);
        }
    }

}
