<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $category = "";
        $warehouse = "";
        $prod_type = "";
        $this->data['prod_cat'] = $this->web->GetAll("product_category_id", "product_categories");
        $this->data['all_warehouse'] = $this->web->GetAll("warehouse_id", "warehouses");
        if ($this->input->post()) {
            $category = $this->input->post("all_prod", true);
            $warehouse = $this->input->post("all_house", true);
            $prod_type = $this->input->post("pro_type", true);

            $totalRec = count($this->web->filter_products($category, $warehouse, $prod_type));
            //pagination configuration
            $config['target'] = '#postList';
            $config['base_url'] = base_url() . 'products/ajaxPaginationData';
            $config['total_rows'] = $totalRec;
            $config['per_page'] = $this->perPage;
            $this->ajax_pagination->initialize($config);

            //get the posts data
            $this->data['products'] = $this->web->filter_products($category, $warehouse, $prod_type, " {$this->perPage}");

//            $this->data['products'] = $this->web->filter_products($category, $warehouse, $prod_type);
        } else {
            $totalRec = count((array)$this->web->getRows(array('table1' => 'products', 'table2' => 'units', 'table2_primary_key' => 'unit_id', 'search_column_id' => 'products.product_id', 'search_column1' => 'products.product_name', 'search_column2' => 'products.instock', 'search_column3' => 'units.unit_symbol')));
            //pagination configuration
            $config['target'] = '#postList';
            $config['base_url'] = base_url() . 'products/ajaxPaginationData';
            $config['total_rows'] = $totalRec;
            $config['per_page'] = $this->perPage;
            $this->ajax_pagination->initialize($config);

            //get the posts data
            $this->data['products'] = $this->web->getRows(array('table1' => 'products', 'table2' => 'units', 'table2_primary_key' => 'unit_id', 'search_column_id' => 'products.product_id', 'search_column1' => 'products.product_name', 'search_column2' => 'products.instock', 'search_column3' => 'units.unit_symbol', 'limit' => $this->perPage));



//            $this->data['products'] = $this->web->GetAllWithInner("product_id", "products", "units", "unit_id", NULL, NULL);
        }
        $this->data['cate'] = $category;
        $this->data['war'] = $warehouse;
        $this->data['pro'] = $prod_type;
       // print_r($this->data);
       // die();
        $this->load->view("products/all", $this->data);
    }

    function ajaxPaginationData() {
        $page = $this->input->post('page');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $search = $this->input->post('search');
        $cat = $this->input->post('cat');
        $war = $this->input->post('war');
        $pro = $this->input->post('pro');


        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        //total rows count
        $totalRec = count($this->web->filter_products($cat, $war, $pro, NULL, $search));

        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'Products/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['products'] = $this->web->filter_products($cat, $war, $pro, " {$offset},{$this->perPage}", $search);
//        print_r($data['issues']);
//        die();
        //load the view
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        $data['search'] = $search;
        $data['cat'] = $cat;
        $data['war'] = $war;
        $data['pro'] = $pro;
        $data['count'] = $offset + 1;


        $this->load->view('Products/ajax-pagination-data', $data, false);
    }

    public function search() {
        $search_text = $this->input->post('id');
        $totalRec = count($this->web->filter_products(NULL, NULL, NULL, NULL, $search_text));
//        $totalRec = 222;
        //pagination configuration
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'Products/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $this->data['products'] = $this->web->filter_products(NULL, NULL, NULL, " 0,{$this->perPage}", $search_text);
//        print_r($this->data['products']);
//        die();
        $this->data['search'] = $search_text;

        $this->load->view("Products/all", $this->data);
    }

    function view() {
        $product_id = $this->uri->segment(3);
        $this->data['product'] = $this->web->GetOneWithInner("product_id", "products", "units", "unit_id", "warehouses", "warehouse_id", $product_id);
        $this->data['warehouses'] = $this->web->GetAll("warehouse_id", "warehouses");
        $this->data['units'] = $this->web->GetAll("unit_id", "units");
        $this->data['product_categories'] = $this->web->GetAll("product_category_id", "product_categories");
//        print_r($this->data['product']);
//        die();
        $this->load->view("products/edit", $this->data);
    }

    function edit() {
        $data = array();
        $data['product_name'] = $this->db->escape_str($this->input->post("name", true));
        $data['warehouse_id'] = $this->db->escape_str($this->input->post("warehouse", true));
        $data['type'] = $this->db->escape_str($this->input->post("product_type", true));
        $data['unit_id'] = $this->db->escape_str($this->input->post("product_unit", true));
        $data['purchase_unit_id'] = $this->db->escape_str($this->input->post("purchase_unit", true));
        $data['sale_unit_id'] = $this->db->escape_str($this->input->post("sale_unit", true));
        $data['product_category_id'] = $this->db->escape_str($this->input->post("product_category", true));
        $data['instock'] = $this->input->post("instock", true);
        $data['product_rate'] = $this->input->post("product_rate", true);
        $data['description'] = htmlentities($this->input->post("desc", true));
        $id = $this->input->post("product_id", true);
        $this->web->Update("product_id", "products", $id, $data);
        redirect("products", "refresh");
    }

    function delete() {
        $product_id = $this->input->post("id", true);
        if ($this->web->Delete("product_id", "products", $product_id)) {
            echo "done";
        }
    }

    function add() {
        if ($this->input->post()) {
            $data = array();
            $data['product_name'] = $this->db->escape_str($this->input->post("name", true));
            $data['warehouse_id'] = $this->db->escape_str($this->input->post("warehouse", true));
            $data['type'] = $this->db->escape_str($this->input->post("product_type", true));
            $data['unit_id'] = $this->db->escape_str($this->input->post("product_unit", true));
            $data['purchase_unit_id'] = $this->db->escape_str($this->input->post("purchase_unit", true));
            $data['sale_unit_id'] = $this->db->escape_str($this->input->post("sale_unit", true));
            $data['product_category_id'] = $this->db->escape_str($this->input->post("product_category", true));
            $data['instock'] = $this->input->post("instock", true);
            $data['product_rate'] = $this->input->post("product_rate", true);
            $data['description'] = htmlentities($this->input->post("desc", true));
            if ($this->web->Add("products", $data)) {
                redirect("products", "refresh");
            }
        } else {
            $this->data['warehouses'] = $this->web->GetAll("warehouse_id", "warehouses");
            $this->data['units'] = $this->web->GetAll("unit_id", "units");
            $this->data['product_categories'] = $this->web->GetAll("product_category_id", "product_categories");
//            print_r($this->data['warehouses']);
//            die();
            $this->load->view("products/add", $this->data);
        }
    }

}
