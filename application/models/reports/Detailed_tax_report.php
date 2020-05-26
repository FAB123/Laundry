<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Report.php");

abstract class Detailed_tax_report extends Report
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

		$decimals = totals_decimals();

		$sale_price = 'CASE WHEN receivings_items.discount_type = ' . PERCENT . ' THEN receivings_items.item_unit_price * receivings_items.quantity_purchased * (1 - receivings_items.discount / 100) ELSE receivings_items.item_unit_price * receivings_items.quantity_purchased - receivings_items.discount END';
		$sale_cost = 'SUM(receivings_items.item_cost_price * receivings_items.quantity_purchased)';
		$tax = 'IFNULL(SUM(receivings_items_taxes.tax), 0)';

		if($this->config->item('tax_included'))
		{
			$sale_total = 'ROUND(SUM(' . $sale_price . '), ' . $decimals . ')';
			$sale_subtotal = $sale_total . ' - ' . $tax;
		}
		else
		{
			$sale_subtotal = 'ROUND(SUM(' . $sale_price . '), ' . $decimals . ')';
			$sale_total = $sale_subtotal . ' + ' . $tax;
		}

		// create a temporary table to contain all the sum of taxes per sale item
		$this->db->query('CREATE TEMPORARY TABLE IF NOT EXISTS ' . $this->db->dbprefix('receivings_items_taxes_temp') .
			' (INDEX(receiving_id), INDEX(item_id))
			(
				SELECT receivings_items_taxes.receiving_id AS receiving_id,
					receivings_items_taxes.item_id AS item_id,
					receivings_items_taxes.line AS line,
					SUM(receivings_items_taxes.item_tax_amount) AS tax
				FROM ' . $this->db->dbprefix('receivings_items_taxes') . ' AS receivings_items_taxes
				INNER JOIN ' . $this->db->dbprefix('receivings') . ' AS receivings
					ON receivings.receiving_id = receivings_items_taxes.receiving_id
				INNER JOIN ' . $this->db->dbprefix('receivings_items') . ' AS receivings_items
					ON receivings_items.receiving_id = receivings_items_taxes.receiving_id AND receivings_items.line = receivings_items_taxes.line
				WHERE ' . $where . '
				GROUP BY receiving_id, item_id, line
			)'
		);

		$this->db->select("
				IFNULL($sale_subtotal, $sale_total) AS subtotal,
				$tax AS tax,
				IFNULL($sale_total, $sale_subtotal) AS total,
				$sale_cost AS cost,
				(IFNULL($sale_subtotal, $sale_total) - $sale_cost) AS profit
		");
	}

	private function _common_from()
	{
		$this->db->from('receivings_items AS receivings_items');
		$this->db->join('receivings AS receivings', 'receivings_items.receiving_id = receivings.receiving_id', 'inner');
		$this->db->join('receivings_items_taxes_temp AS receivings_items_taxes',
			'receivings_items.receiving_id = receivings_items_taxes.receiving_id AND receivings_items.item_id = receivings_items_taxes.item_id AND receivings_items.line = receivings_items_taxes.line',
			'left outer');
	}

	private function _common_where(array $inputs)
	{
		$this->db->where('deleted', 0);
		
		if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE(receivings.receiving_time) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']));
		}
		else
		{
			$this->db->where('receivings.receiving_time BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
		}

		if($inputs['location_id'] != 'all')
		{
			$this->db->where('receivings_items.item_location', $inputs['location_id']);
		}

		if($inputs['sale_type'] == 'receiving')
		{
			$this->db->where('receivings_items.quantity_purchased > 0');
		}
		elseif($inputs['sale_type'] == 'returns')
		{
			$this->db->where('receivings_items.quantity_purchased < 0');
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
		$this->_common_select($inputs);

		$this->_common_from();

		$this->_where($inputs);

		return $this->db->get()->row_array();
	}
}
?>
