`<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Summary_cashonhand.php");

class Cashonhand extends Summary_cashonhand
{
	protected function _get_data_columns()
	{
		return array(
         		array('location_name' => $this->lang->line('reports_stock_location')),
				array('debit_amount' => $this->lang->line('reports_debit_amount'), 'sorter' => 'number_sorter'),
				array('credit_amount' => $this->lang->line('reports_credit_amount'), 'sorter' => 'number_sorter'),
				array('balance' => $this->lang->line('reports_balance'), 'sorter' => 'number_sorter'));
	}


	public function getData(array $inputs)
	{
		$this->db->from('accounts AS accounts');
		$this->db->select('SUM(credit_amount) AS credit_amount, SUM(debit_amount) AS debit_amount, accounts.location_id as location_id, stock_locations.location_name as location_name');
		
		if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE(accounts.thedate) BETWEEN ' . $this->db->escape('2010-01-01 00:00:00') . ' AND ' . $this->db->escape($inputs['end_date']));
		}
		else
		{
			$this->db->where('accounts.thedate BETWEEN ' . $this->db->escape(rawurldecode('2010-01-01 00:00:00')) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
		}   
		
		$this->db->where('accounts.deleted', '0');
		
		$this->db->order_by('accounts.location_id');
		
		  $this->db->join('stock_locations AS stock_locations', 'stock_locations.location_id = accounts.location_id', 'LEFT'); 
				
		if($inputs['stock_locations'][0] != 'all')
		{
			$this->db->where_in('accounts.location_id', $inputs['stock_locations']);
		}
		
		$this->db->group_by('accounts.location_id');
        
		return $this->db->get()->result_array();
		//return $this->db->get();
		
	}
}
?>
