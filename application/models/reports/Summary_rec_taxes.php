<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Summary_rec_report.php");

class Summary_rec_taxes extends Summary_rec_report
{
	protected function _get_data_columns()
	{
		return array(
			array('tax_percent' => $this->lang->line('reports_tax_percent'), 'sorter' => 'number_sorter'),
			array('report_count' => $this->lang->line('reports_count')),
			array('subtotal' => $this->lang->line('reports_subtotal'), 'sorter' => 'number_sorter'),
			array('tax' => $this->lang->line('reports_tax'), 'sorter' => 'number_sorter'),
			array('total' => $this->lang->line('reports_total'), 'sorter' => 'number_sorter'));
	}

	protected function _where(array $inputs)
	{
		if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE(receivings.receiving_time) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']));
		}
		else
		{
			$this->db->where('receivings.receiving_time BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
		}
	}

	public function getData(array $inputs)
	{
		$where = '';

		
		if(empty($this->config->item('date_or_time_format')))
		{
			$where .= 'WHERE DATE(receiving_time) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']);
		}
		else
		{
			$where .= 'WHERE receiving_time BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date']));
		}

			$sale_total = '(CASE WHEN receivings_items.discount_type = ' . PERCENT . ' THEN receivings_items.item_unit_price * receivings_items.quantity_purchased * (1 - receivings_items.discount / 100) ELSE receivings_items.item_unit_price * receivings_items.quantity_purchased - receivings_items.discount END * (1 + (receivings_items_taxes.percent / 100)))';
			$sale_subtotal = '(CASE WHEN receivings_items.discount_type = ' . PERCENT . ' THEN receivings_items.item_unit_price * receivings_items.quantity_purchased * (1 - receivings_items.discount / 100) ELSE receivings_items.item_unit_price * receivings_items.quantity_purchased - receivings_items.discount END)';
		
		$decimals = totals_decimals();

		$query = $this->db->query("SELECT percent, count(*) AS count, ROUND(SUM(subtotal), $decimals) AS subtotal, ROUND(SUM(tax), $decimals) AS tax, ROUND(SUM(total), $decimals) AS total
			FROM (
				SELECT
					CONCAT(IFNULL(ROUND(percent, $decimals), 0), '%') AS percent,
					$sale_subtotal AS subtotal,
					IFNULL(receivings_items_taxes.item_tax_amount, 0) AS tax,
					IFNULL($sale_total, $sale_subtotal) AS total
					FROM " . $this->db->dbprefix('receivings_items') . ' AS receivings_items
					INNER JOIN ' . $this->db->dbprefix('receivings') . ' AS receivings
						ON receivings_items.receiving_id = receivings.receiving_id
					LEFT OUTER JOIN ' . $this->db->dbprefix('receivings_items_taxes') . ' AS receivings_items_taxes
						ON receivings_items.receiving_id = receivings_items_taxes.receiving_id AND receivings_items.item_id = receivings_items_taxes.item_id AND receivings_items.line = receivings_items_taxes.line
					' . $where . '
				) AS temp_taxes
			GROUP BY percent'
		);
		
		

		return $query->result_array();
	}
}
?>
