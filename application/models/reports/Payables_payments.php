`<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Summary_payables_payments.php");

class Payables_payments extends Summary_payables_payments
{
	protected function _get_data_columns()
	{
		return array(
				array('tid' => $this->lang->line('expenses_expense_id')),
				array('created_by' => $this->lang->line('reports_created_by')),
				array('debit_amount' => $this->lang->line('reports_debit_amount'), 'sorter' => 'number_sorter'),
				array('credit_amount' => $this->lang->line('reports_credit_amount'), 'sorter' => 'number_sorter'),
				array('balance' => $this->lang->line('reports_balance'), 'sorter' => 'number_sorter'));
	}


	public function getData(array $inputs)
	{
		$this->db->from('receivings_accounts AS receivings_accounts');
		$this->db->select('account_id, SUM(credit_amount) AS credit_amount, SUM(debit_amount) AS debit_amount, party.first_name AS first_name, party.last_name AS last_name');
		
		if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE(thedate) BETWEEN ' . $this->db->escape('2010-01-01 00:00:00') . ' AND ' . $this->db->escape($inputs['end_date']));
		}
		else
		{
			$this->db->where('thedate BETWEEN ' . $this->db->escape(rawurldecode('2010-01-01 00:00:00')) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
		}   
		
		$this->db->order_by('account_id');
		
		  $this->db->join('people AS party', 'party.person_id = receivings_accounts.account_id', 'LEFT'); 
				
		if($inputs['suppliers'][0] != 'all')
		{
			$this->db->where_in('account_id', $inputs['suppliers']);
		}
		
		$this->db->group_by('account_id');
        
		return $this->db->get()->result_array();
		//return $this->db->get();
		
	}
}
?>
