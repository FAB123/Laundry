<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Summary_tax_report.php");

class Tax_full extends Summary_tax_report
{
	protected function _get_data_columns()
	{
		return array(
				array('thedate' => $this->lang->line('reports_date'), 'sortable' => FALSE),
				array('description' => $this->lang->line('reports_description')),
				array('created_by' => $this->lang->line('reports_created_by')),
				array('party' => $this->lang->line('reports_party')),
				array('vat' => $this->lang->line('reports_vat_no')),
				array('typ' => $this->lang->line('reports_type')),
				array('tax' => $this->lang->line('reports_tax'), 'sorter' => 'number_sorter'),
				array('subtotal' => $this->lang->line('reports_subtotal'), 'sorter' => 'number_sorter'),				
				array('total' => $this->lang->line('reports_total'), 'sorter' => 'number_sorter'));
	}


	public function getData(array $inputs)
	{
		//$where = '';
        $this->db->from('total_tax');
		$this->db->select('thedate, description, employee_id, customer_id, typ, tax, subtotal, total, taxed');
        $this->db->where('taxed', 1);//add this
		$this->db->where('deleted', 0);
		
		 if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE(pos_total_tax.thedate) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']));
		}
		else
		{
			$this->db->where('pos_total_tax.thedate BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
		}    

        $this->db->order_by('typ');	  
        
		if($inputs['tr_type'] == 'Purchase')
		{
			$this->db->where('total_tax.typ','Purchase');
		}
		elseif($inputs['tr_type'] == 'Sales')
		{
			$this->db->where('total_tax.typ','Sales');
		}
		return $this->db->get()->result_array();
		
	}
}
?>
