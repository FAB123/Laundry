<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Report.php");

abstract class Summary_cashonhand extends Report
{
	/**
	 * Private interface implementing the core basic functionality for all reports
	 */

	private function _common_select(array $inputs)
	{
		$where = '';

		if(empty($this->config->item('date_or_time_format')))
		{
			$where .= 'DATE(accounts.thedate) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']);
		}
		else
		{
			$where .= 'accounts.thedate BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date']));
		}
}

	private function _common_from()
	{
		$this->db->from('accounts AS accounts');
	}

	private function _common_where(array $inputs)
	{
		if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE(accounts.thedate) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']));
		}
		else
		{
			$this->db->where('accounts.thedate BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
		}

	}

	/**
	 * Protected class interface implemented by derived classes if necessary
	 */

	abstract protected function _get_data_columns();

	protected function _select(array $inputs)	{ $this->_common_select($inputs); }
	protected function _from()					{ $this->_common_from(); }
	protected function _where(array $inputs)	{ $this->_common_where($inputs); }
	protected function _group_order()			{}

	/**
	 * Public interface implementing the base abstract class, in general it should not be extended unless there is a valid reason like a non sale report (e.g. expenses)
	*/

	public function getDataColumns()
	{
		return $this->_get_data_columns();
	}

	public function getData(array $inputs)
	{
		$this->_select($inputs);

		$this->_from();

		$this->_where($inputs);

		$this->_group_order();

		return $this->db->get()->result_array();
	}

	public function getSummaryData(array $inputs)
	{
		$this->db->select('SUM(credit_amount) AS credit_amount, SUM(debit_amount) AS debit_amount, SUM(tax) AS tax_amt, SUM(cost) AS cost_amt');
		$this->db->from('accounts AS accounts');
        if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE(accounts.thedate) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']));
		}
		else
		{
			$this->db->where('accounts.thedate BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
		}    
        //$this->db->where('accounts.INTY','1');
		$employees = $inputs['employees'];
		if($employees != -1)
		{
			$this->db->where('employee_id', $employees);
		}
		
		$location_id = $inputs['location_id'];
		if($location_id != 'all')
		{
			$this->db->where('location_id', $location_id);
		}
		
		$this->db->where('accounts.deleted', '0');
		
		return $this->db->get()->row_array();
	}
	
	public function getSummaryBalance($inputs)
	{
		$this->db->select('SUM(credit_amount) AS credit_amount, SUM(debit_amount) AS debit_amount, SUM(tax) AS tax_amt, SUM(cost) AS cost_amt');
		$employees = $inputs['employees'];
		if($employees != -1)
		{
			$this->db->where('employee_id', $employees);
		}
		
		$location_id = $inputs['location_id'];
		if($location_id != 'all')
		{
			$this->db->where('location_id', $location_id);
		}
		
		$this->db->where('accounts.deleted', '0');
		
		$this->db->from('accounts AS accounts');
		return $this->db->get()->row_array();
	}
	
	
	public function getopeningBalance(array $inputs)
	{
		$this->db->select('SUM(credit_amount) AS credit_amount, SUM(debit_amount) AS debit_amount');
		$this->db->from('accounts AS accounts');
		
		$location_id = $inputs['location_id'];
		if($location_id != 'all')
		{
			$this->db->where('location_id', $location_id);
		}
		
		$employees = $inputs['employees'];
		if($employees != -1)
		{
			$this->db->where('employee_id', $employees);
		}

		
		//$end_date .=  date('Y-m-d H:i:s', strtotime(rawurldecode($inputs['start_date'].' -1 day')));
		$end_date .=  date('Y-m-d H:i:s', strtotime(rawurldecode($inputs['start_date'])));

        if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE(theda1te) BETWEEN ' . $this->db->escape('2010-01-01 00:00:00') . ' AND ' . $this->db->escape($end_date));
		}
		else
		{
			$this->db->where('thedate BETWEEN ' . $this->db->escape(rawurldecode('2010-01-01 00:00:00')) . ' AND ' . $this->db->escape(rawurldecode($end_date)));
		}
		
        $this->db->where('accounts.deleted', '0');
		
		//return $this->db->get()->row_array();
		return $this->db->get()->result_array();
	}
}
?>
