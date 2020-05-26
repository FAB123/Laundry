`<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Summary_cash_flow.php");

class Cash_flow extends Summary_cash_flow
{
	protected function _get_data_columns()
	{
		return array(
				array('tid' => $this->lang->line('expenses_expense_id')),
				array('thedate' => $this->lang->line('reports_date')),
				array('description' => $this->lang->line('reports_description')),
				array('created_by' => $this->lang->line('reports_created_by')),
				array('party' => $this->lang->line('reports_party')),
				array('typ' => $this->lang->line('reports_type')),
				array('location_id' => $this->lang->line('reports_stock_location')),
				array('debit_amount' => $this->lang->line('reports_debit_amount'), 'sorter' => 'number_sorter'),
				array('credit_amount' => $this->lang->line('reports_credit_amount'), 'sorter' => 'number_sorter'),
				array('balance' => $this->lang->line('reports_balance'), 'sorter' => 'number_sorter'));
	}


	public function getData(array $inputs)
	{
		//$where = '';
        $this->db->from('accounts');
		$this->db->select('tid, thedate, description, employee_id, location_id, accounts, type, debit_amount, credit_amount');
		
		 if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE(thedate) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']));
		}
		else
		{
			$this->db->where('thedate BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
		}    
        $employees = $inputs['employees'];
		if($employees != -1)
		{
			$this->db->where('employee_id', $employees);
		}
		
		$this->db->where('deleted', '0');
		
		$location_id = $inputs['location_id'];
		if($location_id != 'all')
		{
			$this->db->where('location_id', $location_id);
		}
		
        $this->db->order_by('tid');     
     
		return $this->db->get()->result_array();
		
	}
}
?>
