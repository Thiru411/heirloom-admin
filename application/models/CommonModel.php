<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

class CommonModel extends CI_Model{
	
    public function __construct() 
	{
		parent::__construct();
		$this->load->library("session");
		$this->load->library('form_validation');	
	}
	 
	 

     /*********************** Crud Opertaions *********************************/
	function Save($data,$table)
	{
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}

	function Update($table,$cond,$email,$data)
	{
		$this->db->where($cond,$email);
		$this->db->update($table,$data);
	}
	function Delete($table,$idcolumn,$idvalue)
	{
		$query=$this->db->query("delete from $table where $idcolumn='$idvalue'");
	}
	public function getRecords($where,$table) {
		$this->db->select("*");
		$query = $this->db->get_where($table, $where);
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}
	}
	public function getSelectedRecords($where,$table,$selected) {
		$this->db->select($selected);
		$query = $this->db->get_where($table, $where);
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}
	}
	function updateRecords($data,$where,$table) {
		$this->db->where($where);
		$this->db->update($table,$data);
		if($this->db->affected_rows()>0) {
			return true;
		}
		else {
			return false;
		}
	}
	function getProductListing($categoryid)
	{
		$query=$this->db->query("SELECT * FROM `mst_product` where FIND_IN_SET('$categoryid',category_id)");
		$result = $query->result();
		return $result;
	}
	/* function getProductCategoryListing($categoryid)
	{
		$query=$this->db->query("SELECT * FROM `mst_product` where FIND_IN_SET('$categoryid',category_id)");
		$result = $query->result();
		return $result;
	} */
	
	function getMaxRecord($table,$user_id,$order_id) {
		
		$query=$this->db->query("SELECT * FROM txn_order_detail where user_id='$user_id'");
		$result = $query->result();
		return $result;
	}
	public function DataUpdate($data,$idcolumn,$idvalue,$table)
	{
		$this -> db -> select('*');
		$this -> db -> from($table);
		$this -> db -> where($idcolumn,$idvalue);
		$query = $this -> db -> get();
		if($query -> num_rows() > 0)
		{
			$this->db->where($idcolumn,$idvalue);
			$this->db->update($table,$data);
		}
		else
		{
			$id=$this->db->insert($table, $data);
			return $this->db->insert_id();
		}
	}
	
}	



