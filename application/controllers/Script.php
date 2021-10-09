<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// error_reporting(0);
class Script extends CI_Controller {
	public function index(){
		ini_set('max_execution_time', 0); 
		ini_set('memory_limit','2048M');
		$query = "SELECT * FROM journals WHERE to_account = 0 ORDER BY journal_id ASC";
		$query = $this->db->query($query);
		$res = $query->result();
		// print_r($res);
		// die();
		$count = 1;
		foreach ($res as $each) {
			$update_query = "UPDATE journals SET CRV = 'CRV#".sprintf('%05d', $count)."' WHERE journal_id = ".$each->journal_id;
			// if($count==2){
			// 	die($update_query);
			// }
			$update_query = $this->db->query($update_query);
			// $res_update = $update_query->result();
			$count++;
		}
		die("DONE");
	}
}