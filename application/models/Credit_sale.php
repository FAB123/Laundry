<?php
class Credit_sale extends CI_Model
{
	function get_all()
	{
		$this->db->from('accounts');
		$this->db->order_by('tid');
		$this->db->where('deleted',0);
        $this->db->where('type','Sales');
		$this->db->where('payed',0);
		return $this->db->get();
	}
	
	public function get_info($tid)
	{
		$this->db->from('accounts');
		$this->db->where('tid',$tid);
		$this->db->where('deleted',0);
        $this->db->where('type','Sales');
		$this->db->where('payed',0);
		return $this->db->get();
	}

    function savepaydata(&$paydata_data,$tid=false)
	    {
          $this->db->insert('accounts',$paydata_data);
	    }
    function saveupdatedata(&$payupdate_data,$tid=false)
	    {
	    $this->db->where('tid',$tid);		
		return $this->db->update('accounts',$payupdate_data);
		}
	
    function update($tid)
	   {
		$this->db->where('tid',$tid);		
	  	return $this->db->update('accounts', array('payed' => 1, 'thedate'=> date('Y-m-d H:i:s')));
	   }
	   
	function get_all_recive()
	{
		$this->db->from('accounts');
		$this->db->order_by('tid');
		$this->db->where('deleted',0);
        $this->db->where('type','Purchase');
		$this->db->where('payed',0);
		return $this->db->get();
	}
	public function get_info_recive($tid)
	{
		$this->db->from('accounts');
		$this->db->where('tid',$tid);
		$this->db->where('deleted',0);
        $this->db->where('type','Purchase');
		$this->db->where('payed',0);
		return $this->db->get();
	}
}
?>
