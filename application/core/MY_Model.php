<?php

class MY_Model extends CI_Model {

    function getRows($params = array(), $date_from = NULL, $date_to = NULL, $search = NULL, $product_id = NULL) {
        $this->db->select('*');
        $this->db->from("{$params['table1']}");
        if (array_key_exists("table2", $params)) {
            $this->db->join("{$params['table2']}", "{$params['table1']}.{$params['table2_primary_key']} = {$params['table2']}.{$params['table2_primary_key']}");
        }
        if (array_key_exists("table3", $params)) {
            $this->db->join("{$params['table3']}", "{$params['table1']}.{$params['table3_primary_key']} = {$params['table3']}.{$params['table3_primary_key']}");
        }
        if (array_key_exists("table4", $params)) {
            $this->db->join("{$params['table4']}", "{$params['table1']}.{$params['table4_primary_key']} = {$params['table4']}.{$params['table4_primary_key']}", "left");
        }
        if (array_key_exists("where", $params)) {

            $where = " {$params['where']}";
        }
        $where_and = "";
        $where_or = "";
        if (array_key_exists("where", $params)) {
            if ($params['where'] != NULL) {
                $where_and .= " AND ";
                $where_or .= " OR ";
            }
        }
        if ($date_from != NULL && $date_to != NULL) {
            $where .= $where_and . "(DATE({$params['date_filter_table']}) between " . "'{$date_from}'" . " and " . "'{$date_to}'" . ")";
        }
        if ($product_id != NULL) {
            $where .= $where_and . "{$params['table4']}.product_id={$product_id}";
        }

        if ($search != NULL) {
            if ($params['where'] == 'accounts.account_number LIKE "%' . $search . '%"') {

                $where .= $where_or;
            } else {
                $where .= $where_and;
            }

            $where .= "{$params['search_column1']} LIKE '%$search%' OR {$params['search_column2']} LIKE '%$search%' OR {$params['search_column3']} LIKE '%$search%' OR {$params['table1']}.{$params['search_column_id']} LIKE '%$search%'";
        }
        if (array_key_exists("search_column4", $params)) {
            $where .= $where_or . "{$params['search_column4']} LIKE '%$search%' ";
        }
        if (array_key_exists("search_column5", $params)) {
            $where .= $where_or . "{$params['search_column5']} LIKE '%$search%' ";
        }



        if (array_key_exists("where", $params)) {
            $this->db->where($where);
        }
        if (array_key_exists("group", $params)) {
            $this->db->group_by("{$params['group']}");
        }
        $for_order_by = substr("{$params['table1']}", -1);
        $for_order_by == 's' ? $primary = rtrim($params['table1'], 's') . '_id' : $primary = $params['table1'] . '_id';
        $this->db->order_by("{$params['table1']}.{$primary}", 'desc');

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    function GetSidebarMenu() {
        $query = "SELECT modules.* FROM users INNER JOIN user_group_modules ON user_group_modules.user_group_id = users.user_group_id INNER JOIN modules ON modules.module_id = user_group_modules.module_id WHERE modules.status = 1 AND users.id = " . $this->session->userdata('user_id') . " ORDER BY sort_order ASC";
        // die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetLastInsertedRow($primary, $table, $where = NULL) {
        $query = "SELECT * FROM " . $table . $where . " ORDER BY " . $primary . " DESC LIMIT 1";

        $query = $this->db->query($query);
        return $query->result();
    }

    function GetAll($primary, $table, $where = NULL) {
        $query = "SELECT * FROM " . $table . $where . " ORDER BY " . $primary . " ASC";
//        die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

    function GetOne($primary, $table, $value, $and_where = NULL) {
        $query = "SELECT * FROM " . $table . " WHERE " . $primary . " = '" . $value . "'" . $and_where;

        $query = $this->db->query($query);
        return $query->result();
    }

    function Update($primary, $table, $value, $data) {

        if ($this->db->where($primary, $value)->update($table, $data)) {
            return TRUE;
        }
    }

    function Delete($primary, $table, $value) {
        if ($this->db->where($primary, $value)->delete($table)) {
            return TRUE;
        }
    }

    function Add($table, $data) {
        if ($this->db->insert($table, $data)) {
            return TRUE;
        }
    }

    function GetAllWithInner($primary, $table1, $table2, $join_key, $table3, $join_key2, $where = NULL, $limit = NULL, $search = NULL) {
        $query = "SELECT " . $table1 . ".*," . $table2 . ".*";
        if ($table3 !== NULL) {
            $query .= ", " . $table3 . ".*";
        }
        $query .= " FROM " . $table1 .
                " INNER JOIN " . $table2 . " ON " . $table1 . "." . $join_key . " = " . $table2 . "." . $join_key;
        if ($table3 !== NULL) {
            $query .= " INNER JOIN " . $table3 . " ON " . $table1 . "." . $join_key2 . " = " . $table3 . "." . $join_key2;
        }
        if ($where !== NULL) {
            $query .= $where;
        }
        if ($search !== NULL) {
            $query .= $search;
        }
        $query .= " ORDER BY " . $table1 . "." . $primary . " Desc ";
        if ($limit !== NULL) {
            $query .= " limit $limit ";
        }
        // die($query);
        $query = $this->db->query($query);
//        echo $this->db->last_query();
        return $query->result();
    }

    function GetOneWithInner($primary, $table1, $table2, $join_key, $table3, $join_key2, $value) {
        $query = "SELECT " . $table1 . ".*," . $table2 . ".*";
        if ($table3 !== NULL) {
            $query .= ", " . $table3 . ".*";
        }
        $query .= " FROM " . $table1 .
                " INNER JOIN " . $table2 . " ON " . $table1 . "." . $join_key . " = " . $table2 . "." . $join_key;
        if ($table3 !== NULL) {
            $query .= " INNER JOIN " . $table3 . " ON " . $table1 . "." . $join_key2 . " = " . $table3 . "." . $join_key2;
        }
        $query .= " WHERE " . $table1 . "." . $primary . " = '" . $value . "'";
        $query .= " ORDER BY " . $table1 . "." . $primary . " ASC";
//        die($query);
        $query = $this->db->query($query);
        return $query->result();
    }

}
