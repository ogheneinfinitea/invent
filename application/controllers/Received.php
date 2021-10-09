<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Received extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        if (isset($_POST['filter'])) {
            $date_from = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("from_date", true))));
            $date_to = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("to_date", true))));
            $totalRec = count($this->web->getRows(array('table1' => 'issue', 'table2' => 'warehouses', 'table3' => 'sections', 'table2_primary_key' => 'warehouse_id', 'table3_primary_key' => 'section_id', 'date_filter_table' => 'issue.date', 'search_column_id' => 'issue_id', 'search_column1' => 'warehouse_name', 'search_column2' => 'section_name', 'search_column3' => 'date', 'where' => 'issue.warehouse_id IS NOT NULL'), $date_from, $date_to));

            //pagination configuration
            $config['target'] = '#postList';
            $config['base_url'] = base_url() . 'received/ajaxPaginationData';
            $config['total_rows'] = $totalRec;
            $config['per_page'] = $this->perPage;
            $this->ajax_pagination->initialize($config);

            //get the posts data
            $this->data['issues'] = $this->web->getRows(array('table1' => 'issue', 'table2' => 'warehouses', 'table3' => 'sections', 'table2_primary_key' => 'warehouse_id', 'table3_primary_key' => 'section_id', 'date_filter_table' => 'issue.date', 'search_column_id' => 'issue_id', 'search_column1' => 'warehouse_name', 'search_column2' => 'section_name', 'search_column3' => 'date', 'where' => 'issue.warehouse_id IS NOT NULL', 'limit' => $this->perPage), $date_from, $date_to);
//            $this->data['issues'] = $this->web->GetAllWithInner("issue_id", "issue", "warehouses", "warehouse_id", "sections", "section_id", " WHERE issue.warehouse_id IS NOT NULL AND  (DATE(issue.date) between {$date_from} and {$date_to})");
            $this->data['date_from'] = $date_from;
            $this->data['date_to'] = $date_to;
            $this->load->view("received/all", $this->data);
        } else {
//            $this->data['issues'] = $this->web->GetAllWithInner("issue_id", "issue", "warehouses", "warehouse_id", "sections", "section_id", " WHERE issue.warehouse_id IS NOT NULL ");
//            print_r($this->data['issues']);
//            die();
            $totalRec = count((array)$this->web->getRows(array('table1' => 'issue', 'table2' => 'warehouses', 'table3' => 'sections', 'table2_primary_key' => 'warehouse_id', 'table3_primary_key' => 'section_id', 'date_filter_table' => 'issue.date', 'search_column_id' => 'issue_id', 'search_column1' => 'warehouse_name', 'search_column2' => 'section_name', 'search_column3' => 'date', 'where' => 'issue.warehouse_id IS NOT NULL')));
            //pagination configuration
            $config['target'] = '#postList';
            $config['base_url'] = base_url() . 'received/ajaxPaginationData';
            $config['total_rows'] = $totalRec;
            $config['per_page'] = $this->perPage;
            $this->ajax_pagination->initialize($config);

            //get the posts data
            $this->data['issues'] = $this->web->getRows(array('table1' => 'issue', 'table2' => 'warehouses', 'table3' => 'sections', 'table2_primary_key' => 'warehouse_id', 'table3_primary_key' => 'section_id', 'date_filter_table' => 'issue.date', 'search_column_id' => 'issue_id', 'search_column1' => 'warehouse_name', 'search_column2' => 'section_name', 'search_column3' => 'date', 'where' => 'issue.warehouse_id IS NOT NULL', 'limit' => $this->perPage));

            $this->load->view("received/all", $this->data);
        }
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
        $totalRec = count($this->web->getRows(array('table1' => 'issue', 'table2' => 'warehouses', 'table3' => 'sections', 'table2_primary_key' => 'warehouse_id', 'table3_primary_key' => 'section_id', 'date_filter_table' => 'issue.date', 'search_column_id' => 'issue_id', 'search_column1' => 'warehouse_name', 'search_column2' => 'section_name', 'search_column3' => 'date', 'where' => 'issue.warehouse_id IS NOT NULL'), $date_from, $date_to, $search));

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'received/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['issues'] = $this->web->getRows(array('table1' => 'issue', 'table2' => 'warehouses', 'table3' => 'sections', 'table2_primary_key' => 'warehouse_id', 'table3_primary_key' => 'section_id', 'date_filter_table' => 'issue.date', 'search_column_id' => 'issue_id', 'search_column1' => 'warehouse_name', 'search_column2' => 'section_name', 'search_column3' => 'date', 'where' => 'issue.warehouse_id IS NOT NULL', 'start' => $offset, 'limit' => $this->perPage), $date_from, $date_to, $search);

        //load the view
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        $data['search'] = $search;
        $data['count'] = $offset + 1;


        $this->load->view('received/ajax-pagination-data', $data, false);
    }

    public function search() {
        $search_text = $this->input->post('id');
        $totalRec = count($this->web->getRows(array('table1' => 'issue', 'table2' => 'warehouses', 'table3' => 'sections', 'table2_primary_key' => 'warehouse_id', 'table3_primary_key' => 'section_id', 'date_filter_table' => 'issue.date', 'search_column_id' => 'issue_id', 'search_column1' => 'warehouse_name', 'search_column2' => 'section_name', 'search_column3' => 'date', 'where' => 'issue.warehouse_id IS NOT NULL'), NULL, NULL, $search_text));
//        $totalRec = 222;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'received/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $this->data['issues'] = $this->web->getRows(array('table1' => 'issue', 'table2' => 'warehouses', 'table3' => 'sections', 'table2_primary_key' => 'warehouse_id', 'table3_primary_key' => 'section_id', 'date_filter_table' => 'issue.date', 'search_column_id' => 'issue_id', 'search_column1' => 'warehouse_name', 'search_column2' => 'section_name', 'search_column3' => 'date', 'where' => 'issue.warehouse_id IS NOT NULL', 'limit' => $this->perPage), NULL, NULL, $search_text);
        $this->data['search'] = $search_text;

        $this->load->view("received/all", $this->data);
    }

    public function GetProductsByWarehouse() {
        $warehouse_id = $this->input->post("warehouse_id");
        $options = GetProductsByWarehouse($warehouse_id);
        echo $options;
    }

    public function GetInstock() {
        $product_id = $this->input->post("product_id");
        $instock = GetInstock($product_id);
        print_r(json_encode($instock));
    }

    function view() {
        $issue_id = $this->uri->segment(3);
        $this->data['issue'] = $this->web->GetOne('issue_id', 'issue', $issue_id);
        $this->data['issue_items'] = $this->web->GetOne('issue_id', 'product_ledger', $issue_id, " AND debit_qty IS NULL");

        $this->data['products'] = $this->web->GetAllWithInner("product_id", "products", "units", "unit_id", "product_categories", "product_category_id");
        $this->data['products_suggestions'] = "<option value=''>Select or Type Product</option>";
        foreach ($this->data['products'] as $product) {
            $this->data['product_suggestions'][$product->product_category_name][] = $product;
//                $this->data['products_suggestions'] .= "'" . $product->product_id . " - " . $product->product_name . "',";
        }
        foreach ($this->data['product_suggestions'] as $key => $value) {
            $this->data['products_suggestions'] .= "<optgroup label='" . $key . "'>";
//                echo $key . "<br>";
            foreach ($this->data['product_suggestions'][$key] as $value) {
                $this->data['products_suggestions'] .= "<option value='" . $value->product_id . "'>" . $value->product_name . "</option>";
            }
            $this->data['products_suggestions'] .= "</optgroup>";
        }
//            $this->data['products_suggestions'] = rtrim($this->data['products_suggestions'], ",");
        $this->data['warehouses'] = $this->web->GetAll("warehouse_id", "warehouses");
        $this->data['sections'] = $this->web->GetAll("section_id", "sections");
        $this->load->view("received/edit", $this->data);
    }

    function view_slip() {
        $issue_id = $this->uri->segment(3);
        $this->data['issue'] = $this->web->GetOneWithInner('issue_id', 'issue', 'sections', 'section_id', 'warehouses', 'warehouse_id', $issue_id);
        $this->data['issue_items'] = $this->web->GetIssuedItems($issue_id);
        $this->load->view("received/view_slip", $this->data);
    }

    function print_slip() {
        $issue_id = $this->uri->segment(3);
        $this->data['issue'] = $this->web->GetOneWithInner('issue_id', 'issue', 'sections', 'section_id', 'warehouses', 'warehouse_id', $issue_id);
        $this->data['issue_items'] = $this->web->GetIssuedItems($issue_id);
        $this->load->view("received/print_slip", $this->data);
    }

    function edit() {
        $data = array();
        $data_items = array();
        $data['issue_id'] = $this->db->escape_str($this->input->post("issue_id", true));
        $data['warehouse_id'] = $this->db->escape_str($this->input->post("warehouse", true));
        $data['date'] = date("Y-m-d", strtotime(str_replace("-", "/", $this->input->post("date", true)))) . " " . date("H:i:s");
        $data_items['product_id'] = $this->input->post("product_name", true);
        $data_items['qty'] = $this->input->post("qty", true);

        $data_items['all_rec'] = $this->input->post("all_rec", true);
//        $data_items['remaining_qty'] = $this->input->post("remaining_qty", true);
//        $data_items['lost_qty'] = $this->input->post("lost_qty", true);
//        $data_items['lost_notes'] = $this->input->post("lost_notes", true);
        $data['section_id'] = $this->db->escape_str($this->input->post("section", true));
        $data['description'] = htmlentities($this->input->post("desc", true));
//        print_r($data);
//        echo "<br>";
//        print_r($data_items);
//        die();

        if ($this->web->Update("issue_id", "issue", $data['issue_id'], $data)) {

            $old_data = $this->web->GetAll('issue_id', 'product_ledger', " WHERE issue_id= {$data['issue_id']} AND type= 'WAREHOUSE'");

//            print_r($old_data);
//            die();

            $this->web->Delete('issue_id', 'product_ledger', $data['issue_id']);
            $product_count = sizeof($data_items['product_id']);
            $insert_items_debit = "INSERT INTO product_ledger (issue_id, product_id, debit_qty, type, description ,ref_id, date_ledger) VALUES ";
            for ($i = 0; $i < $product_count; $i++) {
                $insert_items_debit .= "('" . $data['issue_id'] . "','" . $data_items['product_id'][$i] . "','" . $data_items['qty'][$i] . "','WAREHOUSE','" . $data['description'] . "','" . $data['warehouse_id'] . "','" . $data['date'] . "'),";
            }

            $insert_items_credit = "INSERT INTO product_ledger (issue_id, product_id, credit_qty, type, description ,ref_id, date_ledger,lost_qty,lost_notes) VALUES ";
            for ($j = 0; $j < $product_count; $j++) {
                $all_rec = explode("*", $data_items['all_rec'][$j]);
                if ($all_rec[1] == "") {
                    $all_rec[1] = 0;
                }

                $insert_items_credit .= "('" . $data['issue_id'] . "','" . $data_items['product_id'][$j] . "','" . $all_rec[2] . "','SECTION','" . $data['description'] . "','" . $data['section_id'] . "','" . $data['date'] . "','" . $all_rec[1] . "','" . $all_rec[3] . "'),";


                if ($old_data[$j]->debit_qty != $data_items['product_id'][$j]) {
                    // die($data_items['product_id'][$j]);

                    $update_old_data = "update products set instock=instock+{$old_data[$j]->debit_qty} WHERE product_id= {$data_items['product_id'][$j]}";


//                    print_r($update_old_data);
//                    die();
                    $this->db->query($update_old_data);

                    // die("successful");
                    $update_instock = "update products set instock=instock-{$data_items['qty'][$j]} WHERE product_id ={$data_items['product_id'][$j]}";
                    $this->db->query($update_instock);
                }
            }
            $insert_items_debit = rtrim($insert_items_debit, ",");
            $insert_items_credit = rtrim($insert_items_credit, ",");
//                echo $insert_items_credit . "<br>";
//                echo $insert_items_debit;
            if (($this->db->query($insert_items_debit)) && ($this->db->query($insert_items_credit))) {
                redirect("received", "refresh");
            }
        }
    }

}
