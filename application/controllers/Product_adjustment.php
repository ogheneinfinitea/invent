<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_adjustment extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $this->data['product_ledger'] = $this->web->GetAllProductAdjustment();


        // print_r($this->data['ledger']); die();
        $this->load->view("product_adjustment/all", $this->data);
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
        $product_ledger_id = $this->uri->segment(3);
    //     $this->data['ledger'] = $this->web->GetAllAdjustment();
//        $this->data['invoice'] = $this->web->GetOneWithInner('invoice_id', 'invoice', "accounts", "account_id", NULL, NULL, $invoice_id);
         $query = "SELECT product_ledger.*,products.*, product_ledger.description as product_ledger_desc, products.description as product_ledger_desc,product_ledger.date_ledger as ledger_date, product_ledger.description as product_ledger_desc FROM product_ledger INNER JOIN products ON product_ledger.product_id = products.product_id WHERE product_ledger.product_ledger_id = '" . $product_ledger_id . "' ORDER BY product_ledger.product_ledger_id ASC";

        $query = $this->db->query($query);
        $this->data['product_ledger'] = $query->result();
//        $this->data['invoice_items'] = $this->web->GetInvoiceItems($invoice_id);
        $this->load->view("product_adjustment/view_adjustment", $this->data);
    }

    function print_adjustment() {
        $product_ledger_id = $this->uri->segment(3);
          $this->data['product_ledger'] = $this->web->GetAllAdjustment();
//        $this->data['invoice'] = $this->web->GetOneWithInner('invoice_id', 'invoice', "accounts", "account_id", NULL, NULL, $invoice_id);
        $query = "SELECT product_ledger.*,products.*, product_ledger.description as product_ledger_desc, products.description as product_ledger_desc,product_ledger.date_ledger as ledger_date, product_ledger.description as product_ledger_desc FROM product_ledger INNER JOIN products ON product_ledger.product_id = products.product_id WHERE product_ledger.product_ledger_id = '" . $product_ledger_id . "' ORDER BY product_ledger.product_ledger_id ASC";
        $query = $this->db->query($query);
        $this->data['product_ledger'] = $query->result();
       // $this->data['invoice_items'] = $this->web->GetInvoiceItems($invoice_id);
        $this->load->view("product_adjustment/print_adjustment", $this->data);
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
            $data['date_ledger'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("date_ledger", true)))) . " " . date("H:i:s");
            $data['product_id'] = $this->db->escape_str($this->input->post("product", true));
            $data['debit_qty'] = $this->db->escape_str($this->input->post("debit_qty", true));
            $data['credit_qty'] = $this->db->escape_str($this->input->post("credit_qty", true));    
            $data['description'] = $this->db->escape_str($this->input->post("desc", true))."<br>adjustment";
            $data['type']='WAREHOUSE';
            // print_r($data);
            // die();
            
            if ($this->web->Add("product_ledger", $data)) {
                 ////////udate instoke///////////

    if(!empty($data['credit_qty'])){
         $update_instock = "Update products set instock=instock+{$data['credit_qty']} WHERE product_id ={$data['product_id']}";
     }
     else{
         $update_instock = "Update products set instock=instock-{$data['debit_qty']} WHERE product_id ={$data['product_id']}";
     }
                       //print_r($update_instock);
                       //die();
                       $this->db->query($update_instock);
                       
                    }
                         redirect("product_adjustment", "refresh");
         }
                  /////update instoke//////////         
         else {
            $this->data['products'] = $this->web->GetAll("product_id", "products");

            $this->data['products'] = $this->web->GetAllWithInner("product_id", "products", "units", "unit_id", "product_categories", "product_category_id");
            $this->load->view("product_adjustment/add", $this->data);
        }
    }

}
