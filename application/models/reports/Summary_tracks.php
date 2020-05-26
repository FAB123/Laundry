<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Report.php");

class Summary_tracks extends Report
{
	public function getDataColumns()
	{
		return array(
			array('id' => $this->lang->line('reports_sale_id')),
			array('item_name' => $this->lang->line('reports_item_name')),
			array('time' => $this->lang->line('reports_date')),
			array('type' => $this->lang->line('reports_type')),
			array('description' => $this->lang->line('reports_description')),
			array('serialnumber' => $this->lang->line('reports_serial_number')),
			array('item_unit_price' => $this->lang->line('reports_item_price')),
			array('employee_id' => $this->lang->line('reports_employee')),
			array('location_name' => $this->lang->line('reports_stock_location')));
	}

	public function getData(array $inputs)
	{
		$this->db->select($this->Item->get_item_name('name') . ', receivings_items.description, receivings_items.receiving_id, receivings.receiving_time, serialnumber, item_unit_price, people.first_name, people.last_name, stock_locations.location_name');
		$this->db->from('receivings_items AS receivings_items');

		$this->db->join('stock_locations AS stock_locations', 'receivings_items.item_location = stock_locations.location_id');
		$this->db->join('receivings AS receivings', 'receivings.receiving_id = receivings_items.receiving_id');
		$this->db->join('items AS items', 'receivings_items.item_id = items.item_id');
		$this->db->join('people AS people', 'receivings.employee_id = people.person_id');

		if($inputs['stock_locations'][0] != 'all')
		{
			$this->db->where_in('stock_locations.location_id', $inputs['stock_locations']);
		}
		
		$this->db->like('receivings_items.serialnumber', $inputs['serial']);

        $this->db->order_by('items.name');
		//$this->db->order_by('items.qty_per_pack');

		return $this->db->get()->result_array();
	}

	public function getsaleData(array $inputs)
	{
		$this->db->select($this->Item->get_item_name('name') . ', sales_items.description, sales.sale_id, sales.sale_time, serialnumber, item_unit_price, people.first_name, people.last_name, stock_locations.location_name');
		$this->db->from('sales_items AS sales_items');

		$this->db->join('stock_locations AS stock_locations', 'sales_items.item_location = stock_locations.location_id');
		$this->db->join('sales AS sales', 'sales.sale_id = sales_items.sale_id');
		$this->db->join('items AS items', 'sales_items.item_id = items.item_id');
		$this->db->join('people AS people', 'sales.employee_id = people.person_id');

		if($inputs['stock_locations'][0] != 'all')
		{
			$this->db->where_in('stock_locations.location_id', $inputs['stock_locations']);
		}
		
		$this->db->like('sales_items.serialnumber', $inputs['serial']);

        $this->db->order_by('items.name');
		//$this->db->order_by('items.qty_per_pack');

		return $this->db->get()->result_array();
	}
	
	public function getSummaryData(array $inputs)
	{
		return array();
	}
}
?>
