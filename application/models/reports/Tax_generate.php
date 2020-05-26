<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Expense class
 */

class Tax_generate extends CI_Model

{
		
	public function getsalesData(array $inputs)
	{
		$this->db->select('sum(tax) as tax, sum(subtotal) as subtotal, sum(total) as total');
        $this->db->from('total_tax');
		$this->db->where('taxed', 1);
        $this->db->where('deleted', 0);//add this
        $this->db->where('total_tax.typ','Sales');
		if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE(pos_total_tax.thedate) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']));
		}
		else
		{
			$this->db->where('pos_total_tax.thedate BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
		}
		return $this->db->get()->row_array();
	}
	public function getpurchaseData(array $inputs)
	{
		$this->db->select('sum(tax) as tax, sum(subtotal) as subtotal, sum(total) as total');
        $this->db->from('total_tax');
		$this->db->where('taxed', 1);
        $this->db->where('deleted', 0);//add this
        $this->db->where('total_tax.typ','Purchase');
		if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE(pos_total_tax.thedate) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']));
		}
		else
		{
			$this->db->where('pos_total_tax.thedate BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
		}
		return $this->db->get()->row_array();
	}
	public function getzerosalesData(array $inputs)
	{
		$this->db->select('sum(tax) as tax, sum(subtotal) as subtotal, sum(total) as total');
        $this->db->from('total_tax');
		$this->db->where('taxed', 0);
        $this->db->where('deleted', 0);//add this
        $this->db->where('total_tax.typ','Sales');
		if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE(pos_total_tax.thedate) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']));
		}
		else
		{
			$this->db->where('pos_total_tax.thedate BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
		}
		return $this->db->get()->row_array();
	}
	public function getzeropurhaseData(array $inputs)
	{
		$this->db->select('sum(tax) as tax, sum(subtotal) as subtotal, sum(total) as total');
        $this->db->from('total_tax');
		$this->db->where('taxed', 0);
        $this->db->where('deleted', 0);//add this
        $this->db->where('total_tax.typ','Purchase');
		if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE(pos_total_tax.thedate) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']));
		}
		else
		{
			$this->db->where('pos_total_tax.thedate BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
		}
		return $this->db->get()->row_array();
	}
}
?>