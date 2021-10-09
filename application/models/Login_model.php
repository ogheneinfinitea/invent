<?php

class Login_model extends CI_Model {

    function CheckLogin($email, $password) {
        $query = "SELECT * FROM users WHERE email = '" . $email . "' AND password = '" . sha1($password) . "' AND status = 1";
        // die($query);
        $result = $this->db->query($query);
        return $result->result();
//        foreach ($query->result() as $row) {
//            echo $row->title;
//        }
    }

}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

