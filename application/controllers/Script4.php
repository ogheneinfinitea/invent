<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// error_reporting(0);
class Script4 extends CI_Controller {
	public function index(){
		ini_set('max_execution_time', 0); 
		ini_set('memory_limit','2048M');
		$query = "SELECT journal_id,description FROM journals WHERE description IS NOT NULL";
		$query = $this->db->query($query);
		$res = $query->result();
		// print_r($res);
		// die();
		$count = 1;
		foreach ($res as $each) {
			$re=explode('&lt;/p',$each->description);
			$desc1=substr($re[0],9);
			// die($desc1);
			$update_query = "UPDATE journals SET voucher_no = '{$desc1}' where journal_id={$each->journal_id}";
		
			$update_query = $this->db->query($update_query);
			$count++;
		}
		die("DONE");
	}
}