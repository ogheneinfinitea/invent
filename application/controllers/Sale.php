<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->data['batches'] = $this->web->GetAll("batch_id", "batches");
        $this->data['batch_suggestions'] = "<option value=''>Batch No</option>";
        foreach ($this->data['batches'] as $batch) {
            $this->data['batch_suggestions'] .= "<option value='" . $batch->batch_no . "'>" . $batch->batch_no . "</option>";
        }
    }

    function index() {
        $this->data['prod_cat'] = $this->web->GetAll("product_category_id", "product_categories");
        if (isset($_POST['filter'])) {
            $date_from = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("from_date", true))));
            $date_to = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("to_date", true))));
            $prod_type = $this->input->post("pro_type", true);
            $category = $this->input->post("all_prod", true);
            $product = $this->input->post("all_prod_name", true);

            $totalRec = count($this->web->GetAllSales_filter($date_from, $date_to, $category, $product, $prod_type));
            //pagination configuration
            $config['target'] = '#postList';
            $config['base_url'] = base_url() . 'sale/ajaxPaginationData';
            $config['total_rows'] = $totalRec;
            $config['per_page'] = $this->perPage;
            $this->ajax_pagination->initialize($config);

            $this->data['sales'] = $this->web->GetAllSales_filter($date_from, $date_to, $category, $product, $prod_type, "$this->perPage");
            $this->data['total_sales'] = $this->web->GetTotalSales_filter($date_from, $date_to, $category, $product, $prod_type);
            $this->data['pro'] = $prod_type;
            $this->data['cate'] = $category;
            $this->data['pro_name'] = $product;
            $this->data['date_from'] = $this->input->post("from_date", true);
            $this->data['date_to'] = $this->input->post("to_date", true);
            $this->load->view("sale/all", $this->data);
        } else {
            $totalRec = count($this->web->GetAllSales());
            //pagination configuration
            $config['target'] = '#postList';
            $config['base_url'] = base_url() . 'sale/ajaxPaginationData';
            $config['total_rows'] = $totalRec;
            $config['per_page'] = $this->perPage;
            $this->ajax_pagination->initialize($config);

            $this->data['sales'] = $this->web->GetAllSales("$this->perPage");
            $this->data['total_sales'] = $this->web->GetTotalSales();
            $this->load->view("sale/all", $this->data);
        }
    }

    function ajaxPaginationData() {
        $page = $this->input->post('page');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $search = $this->input->post('search');
        $cat = $this->input->post('cat');
        $war = $this->input->post('war');
        $pro = $this->input->post('pro');
        if (!empty($date_from) && !empty($date_to)) {
            $date_from = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("date_from", true))));
            $date_to = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("date_to", true))));
        }

        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        //total rows count
        $totalRec = count($this->web->GetAllSales_filter($date_from, $date_to, $cat, $war, $pro, NULL, $search));
//
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'sale/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $this->ajax_pagination->initialize($config);

        //get the posts data
//        print_r($offset);
//        print_r($this->perPage);
//        die();
        $data['sales'] = $this->web->GetAllSales_filter($date_from, $date_to, $cat, $war, $pro, " {$offset},{$this->perPage}", $search);
        // print_r($data['sales']);
        // die();
        //load the view
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        $data['search'] = $search;
        $data['cat'] = $cat;
        $data['pro_name'] = $war;
        $data['pro'] = $pro;
        $data['count'] = $offset + 1;


        $this->load->view('sale/ajax-pagination-data', $data, false);
    }

    public function search() {
        $search_text = $this->input->post('id');
        $totalRec = count($this->web->GetAllSales_filter(NULL, NULL, NULL, NULL, NULL, NULL, $search_text));
//        $totalRec = 222;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'sale/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $this->data['sales'] = $this->web->GetAllSales_filter(NULL, NULL, NULL, NULL, NULL, " 0,{$this->perPage}", $search_text);
        $this->data['total_sales'] = $this->web->GetTotalSales_filter(NULL, NULL, NULL, NULL, NULL, $search_text);
// print_r($this->data['sales']);
        // die();
        $this->data['search'] = $search_text;

        $this->load->view("sale/all", $this->data);
    }

    function GetProducts() {
        $cat_id = $this->input->post("cat_id");
        $pro_type = $this->input->post("pro_type");
        $result = $this->web->GetAll("product_id", "products", " where products.product_category_id=$cat_id");
        if (!empty($pro_type)) {
            $result = $this->web->GetAll("product_id", "products", " where products.product_category_id=$cat_id AND products.type='{$pro_type}'");
        }
//        print_r($result);
        $options = "";
        foreach ($result as $res) {

            $options .= "<option value='" . $res->product_id . "'>" . $res->product_name . "</option>";
        }
        echo json_encode($result);
//        print_r($result);
        die();
    }

    public function GetInstock() {
        $product_id = $this->input->post("product_id");
        $instock = GetInstock($product_id);
        print_r(json_encode($instock));
    }

    function view() {
        $invoice_id = $this->uri->segment(3);
        $this->data['invoice'] = $this->web->GetOne('invoice_id', 'invoice', $invoice_id);
        $this->data['invoice_items'] = $this->web->GetAll('invoice_id', 'invoice_items', ' WHERE invoice_id = "' . $invoice_id . '"');
        // print_r($this->data['invoice_items']); die();
        $this->data['products'] = $this->web->GetAllWithInner("product_id", "products", "units", "unit_id", "product_categories", "product_category_id", NULL);
        $this->data['products_suggestions'] = "<option value=''>Select or Type Product</option>";
        foreach ($this->data['products'] as $product) {
            $this->data['product_suggestions'][$product->product_category_name][] = $product;
//                $this->data['products_suggestions'] .= "'" . $product->product_id . " - " . $product->product_name . "',";
        }
        foreach ($this->data['product_suggestions'] as $key => $value) {
            $this->data['products_suggestions'] .= "<optgroup label='" . $key . "'>";
//                echo $key . "<br>";
            foreach ($this->data['product_suggestions'][$key] as $value) {
                $this->data['products_suggestions'] .= "<option unit_symbol='" . $value->unit_symbol . "' value='" . $value->product_id . "'>" . $value->product_name . "</option>";
            }
            $this->data['products_suggestions'] .= "</optgroup>";
        }
        // print_r($this->data['products_suggestions']); die();
//            $this->data['products_suggestions'] = rtrim($this->data['products_suggestions'], ",");
        $this->data['accounts'] = $this->web->GetAll("account_id", "accounts");
//        print_r($this->data['accounts']);
//        die();
        $this->load->view("sale/edit", $this->data);
    }

    function view_return() {
        $invoice_id = $this->uri->segment(3);
        $this->data['invoice'] = $this->web->GetOne('invoice_id', 'invoice', $invoice_id);
        $this->data['invoice_items'] = $this->web->GetOne('invoice_id', 'invoice_items', $invoice_id);

        $this->data['products'] = $this->web->GetAllWithInner("product_id", "products", "units", "unit_id", "product_categories", "product_category_id", "  AND products.instock > '0'");
        $this->data['products_suggestions'] = "<option value=''>Select or Type Product</option>";
        foreach ($this->data['products'] as $product) {
            $this->data['product_suggestions'][$product->product_category_name][] = $product;
//                $this->data['products_suggestions'] .= "'" . $product->product_id . " - " . $product->product_name . "',";
        }
        foreach ($this->data['product_suggestions'] as $key => $value) {
            $this->data['products_suggestions'] .= "<optgroup label='" . $key . "'>";
//                echo $key . "<br>";
            foreach ($this->data['product_suggestions'][$key] as $value) {
                $this->data['products_suggestions'] .= "<option unit_symbol='" . $value->unit_symbol . "' value='" . $value->product_id . "'>" . $value->product_name . "</option>";
            }
            $this->data['products_suggestions'] .= "</optgroup>";
        }
//            $this->data['products_suggestions'] = rtrim($this->data['products_suggestions'], ",");
        $this->data['accounts'] = $this->web->GetAll("account_id", "accounts");
//        print_r($this->data['accounts']);
//        die();
        $this->load->view("sale/return", $this->data);
    }

    function view_invoice() {
        $invoice_id = $this->uri->segment(3);
        $query = "SELECT invoice.*,accounts.*, invoice.description as invoice_desc, accounts.description as account_desc FROM invoice INNER JOIN accounts ON invoice.account_id = accounts.account_id WHERE invoice.invoice_id = '" . $invoice_id . "' ORDER BY invoice.invoice_id ASC";
        $query = $this->db->query($query);
        $this->data['invoice'] = $query->result();
//        $this->data['invoice'] = $this->web->GetOneWithInner('invoice_id', 'invoice', "accounts", "account_id", NULL, NULL, $invoice_id);
//        $this->data['invoice'] = $this->web->GetOneWithInner('invoice_id', 'invoice', "accounts", "account_id", NULL, NULL, $invoice_id);
//        echo $this->db->last_query();

        $this->data['invoice_items'] = $this->web->GetInvoiceItems($invoice_id);
        $this->load->view("sale/view_invoice", $this->data);
    }

    function print_inv_with_ntn() {
        $invoice_id = $this->uri->segment(3);
//        $this->data['invoice'] = $this->web->GetOneWithInner('invoice_id', 'invoice', "accounts", "account_id", NULL, NULL, $invoice_id);
        $query = "SELECT invoice.*,accounts.*, invoice.description as invoice_desc, accounts.description as account_desc FROM invoice INNER JOIN accounts ON invoice.account_id = accounts.account_id WHERE invoice.invoice_id = '" . $invoice_id . "' ORDER BY invoice.invoice_id ASC";
        $query = $this->db->query($query);
        $this->data['invoice'] = $query->result();
        $this->data['invoice_items'] = $this->web->GetInvoiceItems($invoice_id);
        $this->load->view("sale/print_invoice_with_ntn", $this->data);
    }

        function print_inv_without_ntn() {
        $invoice_id = $this->uri->segment(3);
//        $this->data['invoice'] = $this->web->GetOneWithInner('invoice_id', 'invoice', "accounts", "account_id", NULL, NULL, $invoice_id);
        $query = "SELECT invoice.*,accounts.*, invoice.description as invoice_desc, accounts.description as account_desc FROM invoice INNER JOIN accounts ON invoice.account_id = accounts.account_id WHERE invoice.invoice_id = '" . $invoice_id . "' ORDER BY invoice.invoice_id ASC";
        $query = $this->db->query($query);
        $this->data['invoice'] = $query->result();
        $this->data['invoice_items'] = $this->web->GetInvoiceItems($invoice_id);
        $this->load->view("sale/print_invoice_without_ntn", $this->data);
    }

    function print_gatepass() {
        $invoice_id = $this->uri->segment(3);
//        $this->data['invoice'] = $this->web->GetOneWithInner('invoice_id', 'invoice', "accounts", "account_id", NULL, NULL, $invoice_id);
        $query = "SELECT invoice.*,accounts.*, invoice.description as invoice_desc, accounts.description as account_desc FROM invoice INNER JOIN accounts ON invoice.account_id = accounts.account_id WHERE invoice.invoice_id = '" . $invoice_id . "' ORDER BY invoice.invoice_id ASC";
        $query = $this->db->query($query);
        $this->data['invoice'] = $query->result();
        $this->data['invoice_items'] = $this->web->GetInvoiceItems($invoice_id);
        $this->load->view("sale/print_gatepass", $this->data);
    }

    function edit() {
        if ($this->input->post()) {
            $data = array();
            $data_items = array();
            $data['invoice_id'] = $this->db->escape_str($this->input->post("invoice_id", true));
            $data['account_id'] = $this->db->escape_str($this->input->post("account", true));
            $data['date_created'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("date", true)))) . " " . date("H:i:s");
            $data_items['product_id'] = $this->input->post("product_name", true);
            $data_items['qty'] = $this->input->post("qty", true);
            $data_items['sale_price'] = $this->input->post("sale_price", true);
            $data_items['discount'] = $this->input->post("discount", true);
            $data_items['batch'] = $this->input->post("batch", true);
            $data_items['sub_total'] = $this->input->post("sub_total", true);
            $data['payment_status'] = $this->db->escape_str($this->input->post("payment_status", true));
            $data['payment_method'] = $this->db->escape_str($this->input->post("paying_by", true));
            $data['invoice_total'] = $this->db->escape_str($this->input->post("invoice_total", true));
            $data['total_discount'] = $this->db->escape_str($this->input->post("total_discount", true));
            $data['tax'] = $this->db->escape_str($this->input->post("tax", true));
            $data['voucher_no'] = $this->db->escape_str($this->input->post("sv_no", true));
            $data['description'] = htmlentities($this->input->post("desc", true));
            $data['type'] = "Sale";
            $data['bag'] = $this->input->post("bag");
            $data['carton'] = $this->input->post("carton");
            $data['cargo'] = $this->input->post("cargo");
            $data['builty_no'] = $this->input->post("builty_no");
            $data['destination'] = $this->input->post("destination");
            $data['driver_name'] = $this->input->post("driver_name");
            $data['mobile_no'] = $this->input->post("mobile_no");

            $update_stock = "";
            if ($this->web->Update("invoice_id", "invoice", $data['invoice_id'], $data)) {
                $invoice = $this->web->GetOne("invoice_id", "invoice", $data['invoice_id']);
//                $invoice = $this->web->GetLastInsertedRow("invoice_id", "invoice");
                $old_data = $this->web->GetAll('invoice_item_id', 'invoice_items', " where invoice_id={$data['invoice_id']}");
                // print_r($data_items['qty']);
                // die();
                $this->web->Delete('invoice_id', 'invoice_items', $data['invoice_id']);
                $this->web->Delete('invoice_id', 'product_ledger', $data['invoice_id']);
                $this->web->Delete('invoice_ref', 'ledger', $data['invoice_id']);
                $product_count = sizeof($data_items['product_id']);
                $insert_items = "INSERT INTO invoice_items (invoice_id, product_id, qty, discount,batch, product_sale_price, invoice_subtotal) VALUES ";
                $product_ledger = "INSERT INTO product_ledger (product_id,debit_qty,description,ref_id,type,date_ledger,invoice_id) VALUES ";
                for ($i = 0; $i < $product_count; $i++) {

                    $insert_items .= "('" . $data['invoice_id'] . "','" . $data_items['product_id'][$i] . "','" . $data_items['qty'][$i] . "','" . $data_items['discount'][$i] . "','" . $data_items['batch'][$i] . "','" . $data_items['sale_price'][$i] . "','" . $data_items['sub_total'][$i] . "'),";
                    $check_type = $this->web->GetOne("product_id", "products", "{$data_items['product_id'][$i]}");
                    if ($check_type[0]->type == 'raw') {
                        $product_ledger .= "('" . $data_items['product_id'][$i] . "','" . $data_items['qty'][$i] . "','" . $invoice[0]->description . "','" . $check_type[0]->warehouse_id . "','" . 'WAREHOUSE' . "','" . $invoice[0]->date_created . "','" . $invoice[0]->invoice_id . "'),";
                    }
                    if ($check_type[0]->type == 'production') {
                        $product_ledger .= "('" . $data_items['product_id'][$i] . "','" . $data_items['qty'][$i] . "','" . $invoice[0]->description . "','" . '1' . "','" . 'PRODUCTION' . "','" . $invoice[0]->date_created . "','" . $invoice[0]->invoice_id . "'),";
                    }
//                    $product_ledger .= "('" . $data_items['product_id'][$i] . "','" . $data_items['qty'][$i] . "','" . $invoice[0]->description . "','" . $invoice[0]->invoice_id . "','" . 'Invoice' . "'),";
                    // print_r($data_items['product_id'][$i]);
                    // die();
                    // print_r($old_data);
                    // print_r($data_items['product_id'][$i]);
                    // die();
                    // if()
                    if ((array_key_exists($i, $old_data)) && ($old_data[$i]->product_id == $data_items['product_id'][$i]) && ($old_data[$i]->qty != $data_items['qty'][$i])) {
                        // die($data_items['product_id'][$j]);

                        $update_old_data = "Update products set instock=instock+{$old_data[$i]->qty} WHERE product_id= {$data_items['product_id'][$i]}";


//                        print_r($update_old_data);
//                        die();
                        $this->db->query($update_old_data);

                        //die("successful");
                        $update_instock = "Update products set instock=instock-{$data_items['qty'][$i]} WHERE product_id ={$data_items['product_id'][$i]}";
                        $this->db->query($update_instock);
                    }
                }
                $insert_items = rtrim($insert_items, ",");
                // die($insert_items);
                $product_ledger = rtrim($product_ledger, ",");
                if ($data['payment_status'] == "Confirmed") {
                    $ledger_query = "INSERT INTO ledger (debit_amount,credit_amount,description,type,invoice_ref,account_id,date) ";
                    $ledger_query .= "VALUES ('" . $data['invoice_total'] . "',NULL,'" . $data['description'] . "','Invoice','" . $data['invoice_id'] . "','" . $data['account_id'] . "','" . $data['date_created'] . "'),";
                    $ledger_query .= "(NULL,'" . $data['invoice_total'] . "','" . $data['description'] . "','Invoice','" . $data['invoice_id'] . "','" . $data['account_id'] . "','" . $data['date_created'] . "') ";
                } else {
                    $ledger_query = "INSERT INTO ledger (debit_amount,credit_amount,description,type,invoice_ref,account_id,date) ";
                    $ledger_query .= "VALUES ('" . $data['invoice_total'] . "',NULL,'" . $data['description'] . "','Invoice','" . $data['invoice_id'] . "','" . $data['account_id'] . "','" . $data['date_created'] . "')";
                }
                if ($this->db->query($insert_items) && $this->db->query($ledger_query) && $this->db->query($product_ledger)) {
                    // die();
                    redirect("sale", "refresh");
                }
            }
        }
    }

    function delete() {
        $invoice_id = $this->input->post("id", true);
        if (($this->web->Delete("invoice_id", "invoice", $invoice_id)) && ($this->web->Delete("invoice_ref", "ledger", $invoice_id)) && ($this->web->Delete("invoice_id", "product_ledger", $invoice_id))) {
            $before_items = $this->web->GetAll('invoice_item_id', 'invoice_items', " where invoice_id={$invoice_id}");

            foreach ($before_items as $b_f) {
                $qty = $b_f->qty;
                $update_stock = "update products set instock=(instock+{$qty}) where product_id={$b_f->product_id}";

                $this->db->query($update_stock);
            }

            $this->web->Delete("invoice_id", "invoice_items", $invoice_id);
            echo "done";
        }
    }

    function add() {
        if ($this->input->post()) {
            $data = array();
            $data_items = array();
            $data['account_id'] = $this->db->escape_str($this->input->post("account", true));
            $data['date_created'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("date", true)))) . " " . date("H:i:s");
            $data_items['product_id'] = $this->input->post("product_name", true);
            $data_items['qty'] = $this->input->post("qty", true);
            $data_items['sale_price'] = $this->input->post("sale_price", true);
            $data_items['discount'] = $this->input->post("discount", true);
            $data_items['batch'] = $this->input->post("batch", true);
            $data_items['sub_total'] = $this->input->post("sub_total", true);
            $data['payment_status'] = $this->db->escape_str($this->input->post("payment_status", true));
            $data['payment_method'] = $this->db->escape_str($this->input->post("paying_by", true));
            $data['invoice_total'] = $this->db->escape_str($this->input->post("invoice_total", true));
            $data['total_discount'] = $this->db->escape_str($this->input->post("total_discount", true));
            $data['tax'] = $this->db->escape_str($this->input->post("tax", true));
            $data['voucher_no'] = $this->db->escape_str($this->input->post("sv_no", true));
            $data['description'] = htmlentities($this->input->post("desc", true));
            $inv = $this->web->GetLastInsertedRow("invoice_id", "invoice", " where type='Sale'");
            $data['bag'] = $this->input->post("bag");
            $data['carton'] = $this->input->post("carton");
            $data['cargo'] = $this->input->post("cargo");
            $data['builty_no'] = $this->input->post("builty_no");
            $data['destination'] = $this->input->post("destination");
            $data['driver_name'] = $this->input->post("driver_name");
            $data['mobile_no'] = $this->input->post("mobile_no");

            if (!($inv)) {
                $data['invoice_no'] = 'S-00001';
            } else {
                $inv = explode("-", ($inv[0]->invoice_no));
                $data['invoice_no'] = 'S-' . sprintf('%05d', ($inv[1] + 1));
            }

            $data['type'] = "Sale";
            $update_stock = $stock_counter = 0;
            $product_count = sizeof($data_items['product_id']);
            for ($j = 0; $j < $product_count; $j++) {

                $pro_res = $this->web->GetOne("product_id", "products", $data_items['product_id'][$j]);
//                print_r($pro_res[0]->instock);
//                die();
                if (($pro_res[0]->instock) < $data_items['qty'][$j]) {

                    $stock_counter ++;
                }
            }

            if ($stock_counter == 0) {
                if ($this->web->Add("invoice", $data)) {
                    $invoice = $this->web->GetLastInsertedRow("invoice_id", "invoice");
                    $product_count = sizeof($data_items['product_id']);
                    $insert_items = "INSERT INTO invoice_items (invoice_id, product_id, qty, discount,batch, product_sale_price, invoice_subtotal) VALUES ";
                    $product_ledger = "INSERT INTO product_ledger (product_id,debit_qty,description,ref_id,type,date_ledger,invoice_id) VALUES ";
                    for ($i = 0; $i < $product_count; $i++) {
                        $insert_items .= "('" . $invoice[0]->invoice_id . "','" . $data_items['product_id'][$i] . "','" . $data_items['qty'][$i] . "','" . $data_items['discount'][$i] . "','" . $data_items['batch'][$i] . "','" . $data_items['sale_price'][$i] . "','" . $data_items['sub_total'][$i] . "'),";
                        $check_type = $this->web->GetOne("product_id", "products", "{$data_items['product_id'][$i]}");
                        if ($check_type[0]->type == 'raw') {
                            $product_ledger .= "('" . $data_items['product_id'][$i] . "','" . $data_items['qty'][$i] . "','" . $invoice[0]->voucher_no . '<br>' . $invoice[0]->builty_no . '<br>' . $invoice[0]->description . '<br>' . "','" . $check_type[0]->warehouse_id . "','" . 'WAREHOUSE' . "','" . $invoice[0]->date_created . "','" . $invoice[0]->invoice_id . "'),";
                        }
                        if ($check_type[0]->type == 'production') {
                            $product_ledger .= "('" . $data_items['product_id'][$i] . "','" . $data_items['qty'][$i] . "','" . $invoice[0]->voucher_no . '<br>' . $invoice[0]->builty_no . '<br>' . $invoice[0]->description . '<br>' . "','1','" . 'PRODUCTION' . "','" . $invoice[0]->date_created . "','" . $invoice[0]->invoice_id . "'),";
                        }
//                    $product_ledger .= "('" . $data_items['product_id'][$i] . "','" . $data_items['qty'][$i] . "','" . $invoice[0]->description . "','" . $invoice[0]->invoice_id . "','" . 'Invoice' . "'),";
                        $update_stock = "Update products set instock=(instock-{$data_items['qty'][$i]}) where product_id='{$data_items['product_id'][$i]}'";
                        $this->db->query($update_stock);

                        $data['ordr_id'] = $this->input->post("ordr_id", true);
                        if ($data['ordr_id'] != "") {
                            $update_sale_order_invoice_id = "Update ordr set invoice_id={$invoice[0]->invoice_id} where ordr_id={$data['ordr_id']}";
                            $this->db->query($update_sale_order_invoice_id);
                        }
                    }

                    // echo $update_stock; die();
                    $insert_items = rtrim($insert_items, ",");
                    $product_ledger = rtrim($product_ledger, ",");
                    if ($data['payment_status'] == "Confirmed") {
                        $ledger_query = "INSERT INTO ledger (debit_amount,credit_amount,description,type,invoice_ref,account_id,date) ";
                        $ledger_query .= "VALUES ('" . $data['invoice_total'] . "',NULL,'" . $invoice[0]->voucher_no . '<br>' . $invoice[0]->builty_no . '<br>' . $invoice[0]->description . '<br>' . "','Invoice','" . $invoice[0]->invoice_id . "','" . $data['account_id'] . "','" . $data['date_created'] . "'),";
                        $ledger_query .= "(NULL,'" . $data['invoice_total'] . "','" . $invoice[0]->voucher_no . '<br>' . $invoice[0]->builty_no . '<br>' . $invoice[0]->description . '<br>' . "','Invoice','" . $invoice[0]->invoice_id . "','" . $data['account_id'] . "','" . $data['date_created'] . "') ";
                    } else {
                        $ledger_query = "INSERT INTO ledger (debit_amount,credit_amount,description,type,invoice_ref,account_id,date) ";
                        $ledger_query .= "VALUES ('" . $data['invoice_total'] . "',NULL,'" . $invoice[0]->voucher_no . '<br>' . $invoice[0]->builty_no . '<br>' . $invoice[0]->description . '<br>' . "','Invoice','" . $invoice[0]->invoice_id . "','" . $data['account_id'] . "','" . $data['date_created'] . "')";
                    }
                    if ($this->db->query($insert_items) && $this->db->query($ledger_query) && $this->db->query($product_ledger)) {
                        redirect("sale", "refresh");
                    }
                }
            } else {
                $this->data['products'] = $this->web->GetAllWithInner("product_id", "products", "units", "unit_id", "product_categories", "product_category_id", "  AND products.instock > '0'");
                $this->data['products_suggestions'] = "<option value=''>Select or Type Product</option>";
                if ($this->data['products']) {
                    foreach ($this->data['products'] as $product) {
                        $product_suggestions[$product->product_category_name][] = $product;
//                $this->data['products_suggestions'] .= "'" . $product->product_id . " - " . $product->product_name . "',";
                    }
                    foreach ($product_suggestions as $key => $value) {
                        $this->data['products_suggestions'] .= "<optgroup label='" . $key . "'>";
//                echo $key . "<br>";
                        foreach ($product_suggestions[$key] as $value) {
                            $this->data['products_suggestions'] .= "<option unit_symbol='" . $value->unit_symbol . "' value='" . $value->product_id . "'>" . $value->product_name . "</option>";
                        }
                        $this->data['products_suggestions'] .= "</optgroup>";
                    }
                }
//            $this->data['products_suggestions'] = rtrim($this->data['products_suggestions'], ",");
                $this->data['accounts'] = $this->web->GetAll("account_id", "accounts");
//            print_r($this->data['warehouses']);
//            die();
                $last_invoice = $this->web->GetLastInsertedRow("invoice_id", "invoice", " where type='Sale'");


                if (!empty($last_invoice)) {
                    $p_no = explode("\n", $last_invoice[0]->voucher_no);
                    $inc = explode("#", $p_no[0]);
                    $no = $inc[1] + 1;
                    $no = sprintf('%05d', $no);
                    $p_no = $inc[0] . " # " . $no;
                    // die($p_no);
                    $this->data['last_sale_no'] = $p_no;
                } else {
                    $this->data['last_sale_no'] = 'S-V # 00001';
                }
                $this->session->set_flashdata('stock_error', 'Stock has not enough quantity for  your product/products');
                $this->load->view("sale/add", $this->data);
            }
        } else {
            $this->data['products'] = $this->web->GetAllWithInner("product_id", "products", "units", "unit_id", "product_categories", "product_category_id", "  AND products.instock > '0'");
            $this->data['products_suggestions'] = "<option value=''>Select or Type Product</option>";
            if ($this->data['products']) {
                foreach ($this->data['products'] as $product) {
                    $product_suggestions[$product->product_category_name][] = $product;
//                $this->data['products_suggestions'] .= "'" . $product->product_id . " - " . $product->product_name . "',";
                }
                foreach ($product_suggestions as $key => $value) {
                    $this->data['products_suggestions'] .= "<optgroup label='" . $key . "'>";
//                echo $key . "<br>";
                    foreach ($product_suggestions[$key] as $value) {
                        $this->data['products_suggestions'] .= "<option unit_symbol='" . $value->unit_symbol . "' value='" . $value->product_id . "'>" . $value->product_name . "</option>";
                    }
                    $this->data['products_suggestions'] .= "</optgroup>";
                }
            }
//            $this->data['products_suggestions'] = rtrim($this->data['products_suggestions'], ",");
            $this->data['accounts'] = $this->web->GetAll("account_id", "accounts");
            $this->data['ordr_id'] = "";
//            print_r($this->data['warehouses']);
//            die();
            $last_invoice = $this->web->GetLastInsertedRow("invoice_id", "invoice", " where type='Sale'");
            if (!empty($last_invoice)) {
                $p_no = explode("\n", $last_invoice[0]->voucher_no);
                $inc = explode("#", $p_no[0]);
                $no = $inc[1] + 1;
                $no = sprintf('%05d', $no);
                $p_no = str_replace(' ', '', $inc[0]) . " # " . $no;
                // $p_no=html_entity_decode($p_no);


                $this->data['last_sale_no'] = $p_no;
            } else {
                $this->data['last_sale_no'] = 'S-V # 00001';
            }
            $this->load->view("sale/add", $this->data);
        }
    }

    function add_return() {
        if ($this->input->post()) {
            $data = array();
            $data_items = array();
            $data['account_id'] = $this->db->escape_str($this->input->post("account", true));
            $data['date_created'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("date", true)))) . " " . date("H:i:s");
            $data_items['product_id'] = $this->input->post("product_name", true);
            $data_items['qty'] = $this->input->post("qty", true);
            $data_items['sale_price'] = $this->input->post("sale_price", true);
            $data_items['discount'] = $this->input->post("discount", true);
            $data_items['batch'] = $this->input->post("batch", true);
            $data_items['sub_total'] = $this->input->post("sub_total", true);
            $data['payment_status'] = $this->db->escape_str($this->input->post("payment_status", true));
            $data['payment_method'] = $this->db->escape_str($this->input->post("paying_by", true));
            $data['invoice_total'] = $this->db->escape_str($this->input->post("invoice_total", true));
            $data['total_discount'] = $this->db->escape_str($this->input->post("total_discount", true));
            $data['tax'] = $this->db->escape_str($this->input->post("tax", true));
            $data['voucher_no'] = $this->db->escape_str($this->input->post("sv_no", true));
            $data['description'] = htmlentities($this->input->post("desc", true));
            $data['invoice_no'] = $this->input->post("invoice_no", true);
            $data['bag'] = $this->input->post("bag");
            $data['carton'] = $this->input->post("carton");
            $data['cargo'] = $this->input->post("cargo");
            $data['builty_no'] = $this->input->post("builty_no");
            $data['destination'] = $this->input->post("destination");
            $data['driver_name'] = $this->input->post("driver_name");
            $data['mobile_no'] = $this->input->post("mobile_no");
            $data['return_invoice_id'] = $this->input->post("invoice_id", true);
            if (!empty($data['return_invoice_id'])) {
                $query_ret = "update invoice set return_invoice_id={$data['return_invoice_id']} where invoice_id={$data['return_invoice_id']}";
                $this->db->query($query_ret);
            }
//            $inv = $this->web->GetLastInsertedRow("invoice_id", "invoice", " where type='Sale'");
//            if (!($inv)) {
//                $data['invoice_no'] = 'S-00001';
//            } else {
//                $inv = explode("-", ($inv[0]->invoice_no));
//                $data['invoice_no'] = 'S-' . sprintf('%05d', ($inv[1] + 1));
//            }
            $data['type'] = "Sale Return";
            $update_stock = "";


            if ($this->web->Add("invoice", $data)) {
                $invoice = $this->web->GetLastInsertedRow("invoice_id", "invoice");
                $product_count = sizeof($data_items['product_id']);
                $insert_items = "INSERT INTO invoice_items (invoice_id, product_id, qty, discount,batch, product_sale_price, invoice_subtotal) VALUES ";
                $product_ledger = "INSERT INTO product_ledger (product_id,credit_qty,description,ref_id,type,date_ledger,invoice_id) VALUES ";
                for ($i = 0; $i < $product_count; $i++) {
                    $insert_items .= "('" . $invoice[0]->invoice_id . "','" . $data_items['product_id'][$i] . "','" . $data_items['qty'][$i] . "','" . $data_items['discount'][$i] . "','" . $data_items['batch'][$i] . "','" . $data_items['sale_price'][$i] . "','" . $data_items['sub_total'][$i] . "'),";
                    $check_type = $this->web->GetOne("product_id", "products", "{$data_items['product_id'][$i]}");
                    if ($check_type[0]->type == 'raw') {
                        $product_ledger .= "('" . $data_items['product_id'][$i] . "','" . $data_items['qty'][$i] . "','" . $invoice[0]->description . "','" . $check_type[0]->warehouse_id . "','" . 'WAREHOUSE' . "','" . $invoice[0]->date_created . "','" . $invoice[0]->invoice_id . "'),";
                    }
                    if ($check_type[0]->type == 'production') {
                        $product_ledger .= "('" . $data_items['product_id'][$i] . "','" . $data_items['qty'][$i] . "','" . $invoice[0]->description . "','1','" . 'PRODUCTION' . "','" . $invoice[0]->date_created . "','" . $invoice[0]->invoice_id . "'),";
                    }
//                    $product_ledger .= "('" . $data_items['product_id'][$i] . "','" . $data_items['qty'][$i] . "','" . $invoice[0]->description . "','" . $invoice[0]->invoice_id . "','" . 'Invoice' . "'),";
                    $update_stock = "Update products set instock=instock+{$data_items['qty'][$i]} where product_id={$data_items['product_id'][$i]}";
                    $this->db->query($update_stock);
                }
                $insert_items = rtrim($insert_items, ",");
                $product_ledger = rtrim($product_ledger, ",");
                if ($data['payment_status'] == "Confirmed") {
                    $ledger_query = "INSERT INTO ledger (credit_amount,debit_amount,description,type,invoice_ref,account_id,date) ";
                    $ledger_query .= "VALUES ('" . $data['invoice_total'] . "',NULL,'" . $data['description'] . "','Invoice','" . $invoice[0]->invoice_id . "','" . $data['account_id'] . "','" . $data['date_created'] . "'),";
                    $ledger_query .= "(NULL,'" . $data['invoice_total'] . "','" . $data['description'] . "','Invoice','" . $invoice[0]->invoice_id . "','" . $data['account_id'] . "','" . $data['date_created'] . "') ";
                } else {
                    $ledger_query = "INSERT INTO ledger (credit_amount,debit_amount,description,type,invoice_ref,account_id,date) ";
                    $ledger_query .= "VALUES ('" . $data['invoice_total'] . "',NULL,'" . $data['description'] . "','Invoice','" . $invoice[0]->invoice_id . "','" . $data['account_id'] . "','" . $data['date_created'] . "')";
                }
                if ($this->db->query($insert_items) && $this->db->query($ledger_query) && $this->db->query($product_ledger)) {
                    redirect("sale", "refresh");
                }
            }
        }
    }

    function GetBatchProCount() {
        $batch_no = $this->input->post("batch_no", true);
        $batch_count = $this->web->GetBatchProCount($batch_no);
        echo $batch_count[0]->total_sale_qty . "%" . $batch_count[0]->max_qty;
    }

}
