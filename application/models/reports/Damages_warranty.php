<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Report.php");

class Damages_warranty extends Report
{
	public function getDataColumns()
	{
		return array(array('item_name' => $this->lang->line('reports_item_name')),
					array('quantity' => $this->lang->line('reports_quantity')),
					array('thedate' => $this->lang->line('reports_date')),
					array('location_name' => $this->lang->line('reports_stock_location')),
					array('type' => $this->lang->line('reports_type'), 'sorter' => 'number_sorter'),
					array('employee_id' => $this->lang->line('reports_employee'), 'sorter' => 'number_sorter'),
					array('value' => $this->lang->line('reports_total_inventory_value'), 'sorter' => 'number_sorter'),
					array('cost_price' => $this->lang->line('reports_cost_price'), 'sorter' => 'number_sorter'));
	}

	public function getData(array $inputs)
	{
		$this->db->select($this->Item->get_item_name('name') . ', item_damages.quantity, item_damages.thedate, stock_locations.location_name, item_damages.type, item_damages.employee_id, item_damages.value, people.first_name, people.last_name, items.cost_price');
		$this->db->from('item_damages AS item_damages');	

		$this->db->join('stock_locations AS stock_locations', 'item_damages.location_id = stock_locations.location_id');
		$this->db->join('people AS people', 'item_damages.employee_id = people.person_id');
		$this->db->join('items AS items', 'item_damages.item_id = items.item_id');
		$this->db->where('item_damages.type', 0);

		if($inputs['stock_locations'][0] != 'all')
		{
			$this->db->where_in('stock_locations.location_id', $inputs['stock_locations']);
		}

        $this->db->order_by('name');
		$this->db->order_by('item_damages.thedate');

		return $this->db->get()->result_array();
	}

	/**
	 * calculates the total value of the given inventory summary by summing all sub_total_values (see Inventory_summary::getData())
	 *
	 * @param array $inputs expects the reports-data-array which Inventory_summary::getData() returns
	 * @return array
	 */
	public function getSummaryData(array $inputs)
	{
		$return = array('total_value' => 0, 'total_quantity' => 0);

		foreach($inputs as $input)
		{
			$return['total_value'] += $input['value'];
			$return['total_quantity'] += $input['quantity'];
		}

		return $return;
	}
	
	public function get_item_type($type)
	{
		if($type == '0')
		{
			return $this->lang->line('items_permanent_damage');
		}
		elseif($type == '1')
		{
			return $this->lang->line('items_sent_for_waranty');
		}
		elseif($type == '2')
		{
			return $this->lang->line('items_received_from_waranty');
		}
	}
}
?>
