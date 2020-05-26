<?php
class Addsp_sale extends CI_Model
{
	function get_all()
	{
		$this->db->from('items');
		$this->db->order_by('name');
		$this->db->where('deleted',0);
		$this->db->where('sp',1);
		return $this->db->get();
	}
	
	public function get_info($tid)
	{
		$this->db->from('items');
		$this->db->where('name',$tid);
		$this->db->where('deleted',0);
		$this->db->where('sp',1);
		return $this->db->get();
	}
}
?>
