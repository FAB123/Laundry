<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Summary_receiving_payments extends Summary_report
{
	protected function _get_data_columns()
	{
		return array(
			array('payment_type' => $this->lang->line('reports_payment_type')),
			array('report_count' => $this->lang->line('reports_count')),
			array('amount_due' => $this->lang->line('sales_amount_due'), 'sorter' => 'number_sorter'));
	}

	public function getData(array $inputs)
	{
		$this->db->select('receivings_payments.payment_type, COUNT(DISTINCT receivings_payments.receiving_id) AS count, SUM(payment_amount) AS amount, SUM(CASE WHEN receivings_items.discount_type = ' . PERCENT . ' THEN receivings_items.item_unit_price * receivings_items.quantity_purchased * (1 - receivings_items.discount / 100) ELSE receivings_items.item_unit_price * receivings_items.quantity_purchased - receivings_items.discount END) AS payment_amount');
		$this->db->from('receivings_payments AS receivings_payments');
		$this->db->join('receivings AS receivings', 'receivings.receiving_id = receivings_payments.receiving_id');
		$this->db->join('receivings_items AS receivings_items', 'receivings_items.receiving_id = receivings_payments.receiving_id', 'left');

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

		$this->db->group_by("payment_type");

		$payments = $this->db->get()->result_array();

		return $payments;
	}
}
?>
