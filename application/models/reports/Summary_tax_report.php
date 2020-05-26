<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Report.php");

abstract class Summary_tax_report extends Report
{
	/**
	 * Private interface implementing the core basic functionality for all reports
	 */

	private function _common_select(array $inputs)
	{
		$where = '';

		if(empty($this->config->item('date_or_time_format')))
		{
			$where .= 'DATE(thedate) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']);
		}
		else
		{
			$where .= 'thedate BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date']));
		}
}

	private function _common_from()
	{
		$this->db->from('total_tax AS total_tax');
	}

	private function _common_where(array $inputs)
	{
		if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE(total_tax.thedate) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']));
		}
		else
		{
			$this->db->where('total_tax.thedate BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
		}

		if($inputs['tr_type'] == 'Purchase')
		{
			$this->db->where('total_tax.typ');
		}
		elseif($inputs['tr_type'] == 'Sales')
		{
			$this->db->where('total_tax.typ');
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
		$this->db->select('SUM(subtotal) AS subtotal, SUM(tax) AS tax, SUM(total) AS total');
		$this->db->from('total_tax');
		$this->db->where('taxed', 1);//add this
        if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE(pos_total_tax.thedate) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']));
		}
		else
		{
			$this->db->where('pos_total_tax.thedate BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
		}    
		if($inputs['tr_type'] == 'Purchase')
		{
			$this->db->where('total_tax.typ','Purchase');
		}
		elseif($inputs['tr_type'] == 'Sales')
		{
			$this->db->where('total_tax.typ','Sales');
		}
		
		$this->db->where('deleted', 0);

		return $this->db->get()->row_array();
	}
}
?>
