<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('Secure_Controller.php');

class Reports extends Secure_Controller
{
	public function __construct()
	{
		parent::__construct('reports');

		$method_name = $this->uri->segment(2);
		$exploder = explode('_', $method_name);
		
		if ($method_name == 'cash_flow')
		{
			if(sizeof($exploder) > 1)
		    {
		    	preg_match('/(?:cash_flow)|([^_.]*)(?:_graph|_row)?$/', $method_name, $matches);
		    	preg_match('/^(.*?)([sy])?$/', array_pop($matches), $matches);
		    	$submodule_id = $matches[1] . ((count($matches) > 2) ? $matches[2] : 's');
			
			    // check access to report submodule
			    if(!$this->Employee->has_grant('reports_' . $submodule_id, $this->Employee->get_logged_in_employee_info()->person_id))
		    	{
		    		redirect('no_access/reports/reports_' . $submodule_id);
			    }
		    }
		}
		else
		{
		
		    if(sizeof($exploder) > 1)
		    {
		    	preg_match('/(?:inventory)|([^_.]*)(?:_graph|_row)?$/', $method_name, $matches);
		    	preg_match('/^(.*?)([sy])?$/', array_pop($matches), $matches);
		    	$submodule_id = $matches[1] . ((count($matches) > 2) ? $matches[2] : 's');
			
			    // check access to report submodule
			    if(!$this->Employee->has_grant('reports_' . $submodule_id, $this->Employee->get_logged_in_employee_info()->person_id))
		    	{
		    		redirect('no_access/reports/reports_' . $submodule_id);
			    }
		    }
		}

		$this->load->helper('report');
	}

	//Initial Report listing screen
	public function index()
	{
		$data['grants'] = $this->xss_clean($this->Employee->get_employee_grants($this->session->userdata('person_id')));
		$this->arabic->load('Date');
        $this->arabic->setMode(1);
        $hdate = $this->arabic->date('l dS F Y', time());	
		$data['hdate'] = $hdate;
		$this->load->view('reports/listing', $data);
	}

	//Summary sales report
	public function summary_sales($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id);

		$this->load->model('reports/Summary_sales');
		$model = $this->Summary_sales;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$tabular_data = array();
		foreach($report_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
				'sale_date' => date($this->config->item('dateformat'), strtotime($row['sale_date'])),
				'quantity' => to_quantity_decimals($row['quantity_purchased']),
				'subtotal' => to_currency($row['subtotal']),
				'tax' => to_currency_tax($row['tax']),
				'total' => to_currency($row['total']),
				'cost' => to_currency($row['cost']),
				'profit' => to_currency($row['profit'])
			));
		}

		$data = array(
			'title' => $this->lang->line('reports_sales_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary
		);

		$this->load->view('reports/tabular', $data);
	}

	//Summary Categories report
	public function summary_categories($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id);

		$this->load->model('reports/Summary_categories');
		$model = $this->Summary_categories;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$tabular_data = array();
		foreach($report_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
				'category' => $row['category'],
				'quantity' => to_quantity_decimals($row['quantity_purchased']),
				'subtotal' => to_currency($row['subtotal']),
				'tax' => to_currency_tax($row['tax']),
				'total' => to_currency($row['total']),
				'cost' => to_currency($row['cost']),
				'profit' => to_currency($row['profit'])
			));
		}

		$data = array(
			'title' => $this->lang->line('reports_categories_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary
		);

		$this->load->view('reports/tabular', $data);
	}

	//Summary Expenses by Categories report
	public function summary_expenses_categories($start_date, $end_date, $sale_type)
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type);

		$this->load->model('reports/Summary_expenses_categories');
		$model = $this->Summary_expenses_categories;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$tabular_data = array();
		foreach($report_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
				'category_name' => $row['category_name'],
				'count' => $row['count'],
				'total_amount' => to_currency($row['total_amount']),
				'total_tax_amount' => to_currency($row['total_tax_amount'])
			));
		}

		$data = array(
			'title' => $this->lang->line('reports_expenses_categories_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary
		);

		$this->load->view('reports/tabular', $data);
	}

	//Summary Customers report
	public function summary_customers($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id);

		$this->load->model('reports/Summary_customers');
		$model = $this->Summary_customers;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$tabular_data = array();
		foreach($report_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
				'customer_name' => $row['customer'],
				'quantity' => to_quantity_decimals($row['quantity_purchased']),
				'subtotal' => to_currency($row['subtotal']),
				'tax' => to_currency_tax($row['tax']),
				'total' => to_currency($row['total']),
				'cost' => to_currency($row['cost']),
				'profit' => to_currency($row['profit'])
			));
		}

		$data = array(
			'title' => $this->lang->line('reports_customers_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary
		);

		$this->load->view('reports/tabular', $data);
	}

	//Summary Suppliers report
	public function summary_suppliers($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id);

		$this->load->model('reports/Summary_suppliers');
		$model = $this->Summary_suppliers;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$tabular_data = array();
		foreach($report_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
				'supplier_name' => $row['supplier'],
				'quantity' => to_quantity_decimals($row['quantity_purchased']),
				'subtotal' => to_currency($row['subtotal']),
				'tax' => to_currency_tax($row['tax']),
				'total' => to_currency($row['total']),
				'cost' => to_currency($row['cost']),
				'profit' => to_currency($row['profit'])
			));
		}

		$data = array(
			'title' => $this->lang->line('reports_suppliers_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary
		);

		$this->load->view('reports/tabular', $data);
	}

	//Summary Items report
	public function summary_items($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id);

		$this->load->model('reports/Summary_items');
		$model = $this->Summary_items;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$tabular_data = array();
		foreach($report_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
				'item_name' => $row['name'],
		        'quantity' => to_quantity_decimals($row['quantity_purchased']) .' '. $row['unit_type'],
				'subtotal' => to_currency($row['subtotal']),
				'tax'  => to_currency_tax($row['tax']),
				'total' => to_currency($row['total']),
				'cost' => to_currency($row['cost']),
				'profit' => to_currency($row['profit'])
			));
		}

		$data = array(
			'title' => $this->lang->line('reports_items_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary
		);

		$this->load->view('reports/tabular', $data);
	}

	//Summary Employees report
	public function summary_employees($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id);

		$this->load->model('reports/Summary_employees');
		$model = $this->Summary_employees;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$tabular_data = array();
		foreach($report_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
				'employee_name' => $row['employee'],
				'quantity' => to_quantity_decimals($row['quantity_purchased']),
				'subtotal' => to_currency($row['subtotal']),
				'tax' => to_currency_tax($row['tax']),
				'total' => to_currency($row['total']),
				'cost' => to_currency($row['cost']),
				'profit' => to_currency($row['profit'])
			));
		}

		$data = array(
			'title' => $this->lang->line('reports_employees_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary
		);

		$this->load->view('reports/tabular', $data);
	}

	//Summary Taxes report
	public function summary_taxes($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id);

		$this->load->model('reports/Summary_taxes');
		$model = $this->Summary_taxes;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$tabular_data = array();
		foreach($report_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
				'tax_percent' => $row['percent'],
				'report_count' => $row['count'],
				'subtotal' => to_currency($row['subtotal']),
				'tax' => to_currency_tax($row['tax']),
				'total' => to_currency($row['total'])
			));
		}

		$data = array(
			'title' => $this->lang->line('reports_taxes_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary
		);

		$this->load->view('reports/tabular', $data);
	}

	public function summary_receivingtaxes($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id);

		$this->load->model('reports/Summary_rec_taxes');
		$model = $this->Summary_rec_taxes;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$tabular_data = array();
		foreach($report_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
				'tax_percent' => $row['percent'],
				'report_count' => $row['count'],
				'subtotal' => to_currency($row['subtotal']),
				'tax' => to_currency_tax($row['tax']),
				'total' => to_currency($row['total'])
			));
		}

		$data = array(
			'title' => $this->lang->line('reports_taxes_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary
		);

		$this->load->view('reports/tabular', $data);
	}

	public function summary_discounts_input()
	{
		$data = array();
		$stock_locations = $data = $this->xss_clean($this->Stock_location->get_allowed_locations('sales'));
		$stock_locations['all'] = $this->lang->line('reports_all');
		$data['stock_locations'] = array_reverse($stock_locations, TRUE);
		$data['mode'] = 'sale';
		$data['discount_type_options'] = array(
			'0' => $this->lang->line('reports_discount_percent'),
			'1'=> $this->lang->line('reports_discount_fixed'));
		$data['sale_type_options'] = $this->get_sale_type_options();

		$this->load->view('reports/date_input', $data);
	}
	
	public function summary_receivables_input()
	{
		$data = array();
		$stock_locations = $data = $this->xss_clean($this->Stock_location->get_allowed_locations('sales'));
		$stock_locations['all'] = $this->lang->line('reports_all');
		$data['stock_locations'] = array_reverse($stock_locations, TRUE);
		$stock_locations = $this->Stock_location->get_allowed_locations('customers');
		
		$customers = array();
		foreach($stock_locations as $stock_location => $value)
		{
			foreach($this->Customer->get_all_by_location($stock_location)->result() as $customer)
		    {
			    if(isset($customer->company_name))
			    {
				    $customers[$customer->person_id] = $this->xss_clean($customer->first_name . ' ' . $customer->last_name. ' ' . ' [ '.$customer->company_name.' ] ');
		     	}
			    else
			    {
				    $customers[$customer->person_id] = $this->xss_clean($customer->first_name . ' ' . $customer->last_name);
			    }
	     	}
		}
			
		$customers['all'] = $this->lang->line('reports_all');
		$customers = array_reverse($customers, TRUE);
		$data['specific_customer_data'] = $this->xss_clean($customers);

		$this->load->view('reports/receivables_input', $data);
	}
	
	public function summary_receivables($end_date, $customers = 'all', $export_excel=0)
	{
		$customers = explode(':', $customers);
        $customers = $this->xss_clean($customers);
		
		$inputs = array('end_date' => $end_date, 'customers'=>$customers);

		$this->load->model('reports/Receivables_payments');
		$model = $this->Receivables_payments;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$tabular_data = array();
		foreach($report_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
                'tid' =>  anchor('accounts/manage/0/'. $row['account_id'], '<span > '.$row['account_id'].'</span>') ,
                'created_by' =>  $row['first_name'].' '.$row['last_name'],
				'credit_amount' => to_currency($row['credit_amount']),
				'debit_amount' => to_currency($row['debit_amount']),
				'balance' => to_currency($row['debit_amount'] - $row['credit_amount'])
			));
		}

		$data = array(
			'title' => $this->lang->line('reports_receivables_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary
		);

		$this->load->view('reports/tabular', $data);
	}
	
	public function summary_cashonhands_input()
	{
		$data = array();		

		$stock_locations = $data = $this->xss_clean($this->Stock_location->get_allowed_locations('sales'));
		$stock_locations['all'] = $this->lang->line('reports_all');
		$data['stock_locations'] = $this->xss_clean(array_reverse($stock_locations, TRUE));

		$this->load->view('reports/cashonhands_input', $data);
	}
	
	public function summary_cashonhands($end_date, $stock_locations = 'all', $export_excel=0)
	{
		$stock_locations = explode(':', $stock_locations);
        $stock_locations = $this->xss_clean($stock_locations);
		
		$inputs = array('end_date' => $end_date, 'stock_locations'=>$stock_locations);

		$this->load->model('reports/Cashonhand');
		$model = $this->Cashonhand;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$tabular_data = array();
		foreach($report_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
                'location_name' =>  $row['location_name'],
				'credit_amount' => to_currency($row['credit_amount']),
				'debit_amount' => to_currency($row['debit_amount']),
				'balance' => to_currency($row['debit_amount'] - $row['credit_amount'])
			));
		}

		$data = array(
			'title' => $this->lang->line('reports_cashonhands_summary'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary
		);

		$this->load->view('reports/tabular', $data);
	}
	
	public function summary_damages_input()
	{
		$data = array();		

		$stock_locations = $data = $this->xss_clean($this->Stock_location->get_allowed_locations('sales'));
		$stock_locations['all'] = $this->lang->line('reports_all');
		$data['stock_locations'] = $this->xss_clean(array_reverse($stock_locations, TRUE));
		$data['types'] = array('0' => $this->lang->line('items_permanent_damage'),
			'1' => $this->lang->line('items_sent_for_waranty'),
			'2' => $this->lang->line('items_received_from_waranty'));
		$this->load->view('reports/damages_input', $data);
	}
	
	public function summary_damages($start_date, $end_date, $stock_locations = 'all', $types, $export_excel=0)
	{
		$stock_locations = explode(':', $stock_locations);
        $stock_locations = $this->xss_clean($stock_locations);
		
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'stock_locations'=>$stock_locations, 'types'=>$types);

		$this->load->model('reports/Damages_warranty');
		$model = $this->Damages_warranty;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($report_data));

		$tabular_data = array();
		foreach($report_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
                'item_name' =>  $row['name'],
                'thedate' =>  $row['thedate'],
				'quantity' => $row['quantity'],
				'location_name' => $row['location_name'],
				'type' => $model->get_item_type($row['type']),
				'employee_id' => $row['first_name'].' '.$row['last_name'],
				'value' => to_currency($row['value']),
				'cost_price' => to_currency($row['cost_price'])
			));
		}

		$data = array(
			'title' => $this->lang->line('reports_damages_warranty_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary
		);

		$this->load->view('reports/tabular', $data);
	}
	
	public function summary_tracks_input()
	{
		$data = array();		

		$stock_locations = $data = $this->xss_clean($this->Stock_location->get_allowed_locations('sales'));
		$stock_locations['all'] = $this->lang->line('reports_all');
		$data['stock_locations'] = $this->xss_clean(array_reverse($stock_locations, TRUE));

		$this->load->view('reports/tracks_input', $data);
	}
	
	public function summary_tracks($start_date, $end_date, $stock_locations = 'all', $serial, $export_excel=0)
	{
		$stock_locations = explode(':', $stock_locations);
        $stock_locations = $this->xss_clean($stock_locations);
		
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'stock_locations'=>$stock_locations, 'serial'=>$serial);

		$this->load->model('reports/Summary_tracks');
		$model = $this->Summary_tracks;

		$report_receiving_data = $model->getData($inputs);
		$report_sale_data = $model->getsaleData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($report_receiving_data));

		$tabular_data = array();
		foreach($report_receiving_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
                'id' =>  'RECV '.$row['receiving_id'],
                'item_name' =>  $row['name'],
				'time' => $row['receiving_time'],
				'type' => $this->lang->line('reports_receivings'),
                'description' =>  $row['description'],
				'serialnumber' => $row['serialnumber'],
				'item_unit_price' => $row['item_unit_price'],
				'employee_id' => $row['first_name'].' '.$row['last_name'],
				'location_name' => $row['location_name']
			));
		}

		foreach($report_sale_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
                'id' =>  'POS '.$row['sale_id'],
                'item_name' =>  $row['name'],
				'time' => $row['sale_time'],
				'type' => $this->lang->line('reports_sales'),
                'description' =>  $row['description'],
				'serialnumber' => $row['serialnumber'],
				'item_unit_price' => $row['item_unit_price'],
				'employee_id' => $row['first_name'].' '.$row['last_name'],
				'location_name' => $row['location_name']
			));
		}
		
		$data = array(
			'title' => $this->lang->line('reports_summary_tracks_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary
		);

		$this->load->view('reports/tabular', $data);
	}
	
	public function summary_payables_input()
	{
		$data = array();		

		$suppliers = array();
		foreach($this->Supplier->get_all()->result() as $supplier)
		{
			if(isset($supplier->company_name))
			{
				$suppliers[$supplier->person_id] = $this->xss_clean($supplier->first_name . ' ' . $supplier->last_name. ' ' . ' [ '.$supplier->company_name.' ] ');
			}
			else
			{
				$suppliers[$supplier->person_id] = $this->xss_clean($supplier->first_name . ' ' . $supplier->last_name);
			}
		}
		
		$suppliers['all'] = $this->lang->line('reports_all');
		$suppliers = array_reverse($suppliers, TRUE);
		$data['specific_suppliers_data'] = $this->xss_clean($suppliers);

		$this->load->view('reports/payables_input', $data);
	}
	
	public function summary_payables($end_date, $suppliers = 'all', $export_excel=0)
	{
		$suppliers = explode(':', $suppliers);
        $suppliers = $this->xss_clean($suppliers);
		
		$inputs = array('end_date' => $end_date, 'suppliers'=>$suppliers);

		$this->load->model('reports/Payables_payments');
		$model = $this->Payables_payments;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$tabular_data = array();
		foreach($report_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
                'tid' =>  anchor('accounts/manage/1/'. $row['account_id'], '<span > '.$row['account_id'].'</span>') ,
                'created_by' =>  $row['first_name'].' '.$row['last_name'],
				'credit_amount' => to_currency($row['credit_amount']),
				'debit_amount' => to_currency($row['debit_amount']),
				'balance' => to_currency($row['debit_amount'] - $row['credit_amount'])
			));
		}

		$data = array(
			'title' => $this->lang->line('reports_payables_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary
		);

		$this->load->view('reports/tabular', $data);
	}
	
	//Summary Discounts report
	public function summary_discounts($start_date, $end_date, $sale_type, $location_id = 'all', $discount_type=0)
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id,'discount_type'=>$discount_type);

		$this->load->model('reports/Summary_discounts');
		$model = $this->Summary_discounts;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$tabular_data = array();
		foreach($report_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
				'total' => to_currency($row['total']),
				'discount' => $row['discount'],
				'count' => $row['count']
			));
		}

		$data = array(
			'title' => $this->lang->line('reports_discounts_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary
		);

		$this->load->view('reports/tabular', $data);
	}

	//Summary Payments report
	public function summary_payments($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id);

		$this->load->model('reports/Summary_payments');
		$model = $this->Summary_payments;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$tabular_data = array();
		foreach($report_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
				'payment_type' => $row['payment_type'],
				'report_count' => $row['count'],
				'amount_due' => to_currency($row['payment_amount'])
			));
		}

		$data = array(
			'title' => $this->lang->line('reports_payments_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary
		);

		$this->load->view('reports/tabular', $data);
	}

	//Input for reports that require only a date range. (see routes.php to see that all graphical summary reports route here)
	public function date_input()
	{
		$data = array();
		$stock_locations = $data = $this->xss_clean($this->Stock_location->get_allowed_locations('sales'));
		$stock_locations['all'] = $this->lang->line('reports_all');
		$data['stock_locations'] = array_reverse($stock_locations, TRUE);
		$data['mode'] = 'sale';
		$data['sale_type_options'] = $this->get_sale_type_options();

		$this->load->view('reports/date_input', $data);
	}

	//Input for reports that require only a date range. (see routes.php to see that all graphical summary reports route here)
	public function date_input_only()
	{
		$data = array();

		$this->load->view('reports/date_input', $data);
	}
	
	public function cash_flow_input_only()
	{
		$data = array();
		$data['specific_input_name'] = $this->lang->line('reports_employee');
		
		$stock_locations = $this->xss_clean($this->Stock_location->get_allowed_locations());
		$stock_locations['all'] = $this->lang->line('reports_all');
		$data['stock_locations'] = array_reverse($stock_locations, TRUE);
		
		$person_id = $this->session->userdata('person_id');
		if($this->Employee->has_grant('accounts_all', $person_id))
		{
		    $employees = array();
		    foreach($this->Employee->get_all()->result() as $employee)
		    {
			    $employees[$employee->person_id] = $this->xss_clean($employee->first_name . ' ' . $employee->last_name);
		    }
     		$data['employees'] = $employees;
			$data['employees']['-1'] = $this->lang->line('employees_all');
		}
		else
		{
			$data['employees'] = $person_id;
		}

		$this->load->view('reports/cash_flow_input', $data);
	}

	//Input for reports that require only a date range. (see routes.php to see that all graphical summary reports route here)
	public function date_input_sales()
	{
		$data = array();
		$stock_locations = $data = $this->xss_clean($this->Stock_location->get_allowed_locations('sales'));
		$stock_locations['all'] =  $this->lang->line('reports_all');
		$data['stock_locations'] = array_reverse($stock_locations, TRUE);
		$data['mode'] = 'sale';
		$data['sale_type_options'] = $this->get_sale_type_options();

		$this->load->view('reports/date_input', $data);
	}

	public function date_input_recv()
	{
		$data = array();
		$stock_locations = $data = $this->xss_clean($this->Stock_location->get_allowed_locations('receivings'));
		$stock_locations['all'] =  $this->lang->line('reports_all');
		$data['stock_locations'] = array_reverse($stock_locations, TRUE);
		$data['mode'] = 'receiving';

		$this->load->view('reports/date_input', $data);
	}

	//Graphical Expenses by Categories report
	public function graphical_summary_expenses_categories($start_date, $end_date, $sale_type)
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type);

		$this->load->model('reports/Summary_expenses_categories');
		$model = $this->Summary_expenses_categories;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$labels = array();
		$series = array();
		foreach($report_data as $row)
		{
			$row = $this->xss_clean($row);

			$labels[] = $row['category_name'];
			$series[] = array('meta' => $row['category_name'] . ' ' . round($row['total_amount'] / $summary['expenses_total_amount'] * 100, 2) . '%', 'value' => $row['total_amount']);
		}

		$data = array(
			'title' => $this->lang->line('reports_expenses_categories_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'chart_type' => 'reports/graphs/pie',
			'labels_1' => $labels,
			'series_data_1' => $series,
			'summary_data_1' => $summary,
			'show_currency' => TRUE
		);

		$this->load->view('reports/graphical', $data);
	}

	//Graphical summary sales report
	public function graphical_summary_sales($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id);

		$this->load->model('reports/Summary_sales');
		$model = $this->Summary_sales;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$labels = array();
		$series = array();
		foreach($report_data as $row)
		{
			$row = $this->xss_clean($row);

			$date = date($this->config->item('dateformat'), strtotime($row['sale_date']));
			$labels[] = $date;
			$series[] = array('meta' => $date, 'value' => $row['total']);
		}

		$data = array(
			'title' => $this->lang->line('reports_sales_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'chart_type' => 'reports/graphs/line',
			'labels_1' => $labels,
			'series_data_1' => $series,
			'summary_data_1' => $summary,
			'yaxis_title' => $this->lang->line('reports_revenue'),
			'xaxis_title' => $this->lang->line('reports_date'),
			'show_currency' => TRUE
		);

		$this->load->view('reports/graphical', $data);
	}

	//Graphical summary items report
	public function graphical_summary_items($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id);

		$this->load->model('reports/Summary_items');
		$model = $this->Summary_items;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$labels = array();
		$series = array();
		foreach($report_data as $row)
		{
			$row = $this->xss_clean($row);

			$labels[] = $row['name'];
			$series[] = $row['total'];
		}

		$data = array(
			'title' => $this->lang->line('reports_items_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'chart_type' => 'reports/graphs/hbar',
			'labels_1' => $labels,
			'series_data_1' => $series,
			'summary_data_1' => $summary,
			'yaxis_title' => $this->lang->line('reports_items'),
			'xaxis_title' => $this->lang->line('reports_revenue'),
			'show_currency' => TRUE
		);

		$this->load->view('reports/graphical', $data);
	}

	//Graphical summary customers report
	public function graphical_summary_categories($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id);

		$this->load->model('reports/Summary_categories');
		$model = $this->Summary_categories;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$labels = array();
		$series = array();
		foreach($report_data as $row)
		{
			$row = $this->xss_clean($row);

			$labels[] = $row['category'];
			$series[] = array('meta' => $row['category'] . ' ' . round($row['total'] / $summary['total'] * 100, 2) . '%', 'value' => $row['total']);
		}

		$data = array(
			'title' => $this->lang->line('reports_categories_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'chart_type' => 'reports/graphs/pie',
			'labels_1' => $labels,
			'series_data_1' => $series,
			'summary_data_1' => $summary,
			'show_currency' => TRUE
		);

		$this->load->view('reports/graphical', $data);
	}

	//Graphical summary suppliers report
	public function graphical_summary_suppliers($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id);

		$this->load->model('reports/Summary_suppliers');
		$model = $this->Summary_suppliers;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$labels = array();
		$series = array();
		foreach($report_data as $row)
		{
			$row = $this->xss_clean($row);

			$labels[] = $row['supplier'];
			$series[] = array('meta' => $row['supplier'] . ' ' . round($row['total'] / $summary['total'] * 100, 2) . '%', 'value' => $row['total']);
		}

		$data = array(
			'title' => $this->lang->line('reports_suppliers_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'chart_type' => 'reports/graphs/pie',
			'labels_1' => $labels,
			'series_data_1' => $series,
			'summary_data_1' => $summary,
			'show_currency' => TRUE
		);

		$this->load->view('reports/graphical', $data);
	}

	//Graphical summary employees report
	public function graphical_summary_employees($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id);

		$this->load->model('reports/Summary_employees');
		$model = $this->Summary_employees;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$labels = array();
		$series = array();
		foreach($report_data as $row)
		{
			$row = $this->xss_clean($row);

			$labels[] = $row['employee'];
			$series[] = array('meta' => $row['employee'] . ' ' . round($row['total'] / $summary['total'] * 100, 2) . '%', 'value' => $row['total']);
		}

		$data = array(
			'title' => $this->lang->line('reports_employees_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'chart_type' => 'reports/graphs/pie',
			'labels_1' => $labels,
			'series_data_1' => $series,
			'summary_data_1' => $summary,
			'show_currency' => TRUE
		);

		$this->load->view('reports/graphical', $data);
	}

	//Graphical summary taxes report
	public function graphical_summary_taxes($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id);

		$this->load->model('reports/Summary_taxes');
		$model = $this->Summary_taxes;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$labels = array();
		$series = array();
		foreach($report_data as $row)
		{
			$row = $this->xss_clean($row);

			$labels[] = $row['percent'];
			$series[] = array('meta' => $row['percent'] . ' ' . round($row['total'] / $summary['total'] * 100, 2) . '%', 'value' => $row['total']);
		}

		$data = array(
			'title' => $this->lang->line('reports_taxes_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'chart_type' => 'reports/graphs/pie',
			'labels_1' => $labels,
			'series_data_1' => $series,
			'summary_data_1' => $summary,
			'show_currency' => TRUE
		);

		$this->load->view('reports/graphical', $data);
	}

	//Graphical summary customers report
	public function graphical_summary_customers($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id);

		$this->load->model('reports/Summary_customers');
		$model = $this->Summary_customers;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$labels = array();
		$series = array();
		foreach($report_data as $row)
		{
			$row = $this->xss_clean($row);

			$labels[] = $row['customer'];
			$series[] = $row['total'];
		}

		$data = array(
			'title' => $this->lang->line('reports_customers_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'chart_type' => 'reports/graphs/hbar',
			'labels_1' => $labels,
			'series_data_1' => $series,
			'summary_data_1' => $summary,
			'yaxis_title' => $this->lang->line('reports_customers'),
			'xaxis_title' => $this->lang->line('reports_revenue'),
			'show_currency' => TRUE
		);

		$this->load->view('reports/graphical', $data);
	}

	//Graphical summary discounts report
	public function graphical_summary_discounts($start_date, $end_date, $sale_type, $location_id = 'all', $discount_type=0)
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id,'discount_type'=>$discount_type);

		$this->load->model('reports/Summary_discounts');
		$model = $this->Summary_discounts;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$labels = array();
		$series = array();
		foreach($report_data as $row)
		{
			$row = $this->xss_clean($row);

			$labels[] = $row['discount'];
			$series[] = $row['count'];
		}

		$data = array(
			'title' => $this->lang->line('reports_discounts_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'chart_type' => 'reports/graphs/bar',
			'labels_1' => $labels,
			'series_data_1' => $series,
			'summary_data_1' => $summary,
			'yaxis_title' => $this->lang->line('reports_count'),
			'xaxis_title' => $this->lang->line('reports_discount'),
			'show_currency' => FALSE
		);

		$this->load->view('reports/graphical', $data);
	}

	//Graphical summary payments report
	public function graphical_summary_payments($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id);

		$this->load->model('reports/Summary_payments');
		$model = $this->Summary_payments;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$labels = array();
		$series = array();
		foreach($report_data as $row)
		{
			$row = $this->xss_clean($row);

			$labels[] = $row['payment_type'];
			$series[] = array('meta' => $row['payment_type'] . ' ' . round($row['payment_amount'] / $summary['total'] * 100, 2) . '%', 'value' => $row['payment_amount']);
		}

		$data = array(
			'title' => $this->lang->line('reports_payments_summary_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'chart_type' => 'reports/graphs/pie',
			'labels_1' => $labels,
			'series_data_1' => $series,
			'summary_data_1' => $summary,
			'show_currency' => TRUE
		);

		$this->load->view('reports/graphical', $data);
	}

	public function specific_customer_input()
	{
		$data = array();
		$data['specific_input_name'] = $this->lang->line('reports_customer');
		$customers = array();
		foreach($this->Customer->get_all()->result() as $customer)
		{
			if(isset($customer->company_name))
			{
				$customers[$customer->person_id] = $this->xss_clean($customer->first_name . ' ' . $customer->last_name. ' ' . ' [ '.$customer->company_name.' ] ');
			}
			else
			{
				$customers[$customer->person_id] = $this->xss_clean($customer->first_name . ' ' . $customer->last_name);
			}
		}
		$data['specific_input_data'] = $customers;
		$data['sale_type_options'] = $this->get_sale_type_options();

		$data['payment_type'] = $this->get_payment_type();
		$this->load->view('reports/specific_customer_input', $data);
	}

	public function get_payment_type()
	{
			$payment_type = array( 'all' => $this->lang->line('common_none_selected_text'),
					'cash' => $this->lang->line('sales_cash'),
					'due' => $this->lang->line('sales_due'),
					'check' => $this->lang->line('sales_check'),
					'credit' => $this->lang->line('sales_credit'),
					'debit' => $this->lang->line('sales_debit'),
					'invoices' => $this->lang->line('sales_invoice'));
			return $payment_type;
	}

	public function specific_customer($start_date, $end_date, $customer_id, $sale_type, $payment_type)
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'customer_id' => $customer_id, 'sale_type' => $sale_type, 'payment_type' => $payment_type);

		$this->load->model('reports/Specific_customer');
		$model = $this->Specific_customer;

		$model->create($inputs);

		$headers = $this->xss_clean($model->getDataColumns());
		$report_data = $model->getData($inputs);

		$summary_data = array();
		$details_data = array();
		$details_data_rewards = array();

		foreach($report_data['summary'] as $key => $row)
		{
			if($row['sale_status'] == CANCELED)
			{
				$button_key = 'data-btn-restore';
				$button_label = $this->lang->line('common_restore');
			}
			else
			{
				$button_key = 'data-btn-delete';
				$button_label = $this->lang->line('common_delete');
			}

			$summary_data[] = $this->xss_clean(array(
				'id' => $row['sale_id'],
				'type_code' => $row['type_code'],
				'sale_date' => date($this->config->item('dateformat'), strtotime($row['sale_date'])),
				'quantity' => to_quantity_decimals($row['items_purchased']),
				'employee_name' => $row['employee_name'],
				'subtotal' => to_currency($row['subtotal']),
				'tax' => to_currency_tax($row['tax']),
				'total' => to_currency($row['total']),
				'cost' => to_currency($row['cost']),
				'profit' => to_currency($row['profit']),
				'payment_type' => $row['payment_type'],
				'comment' => $row['comment'],
				'edit' => anchor('sales/edit/'. $row['sale_id'], '<span class="glyphicon glyphicon-edit"></span>',
					array('class'=>'modal-dlg print_hide', $button_key => $button_label, 'data-btn-submit' => $this->lang->line('common_submit'), 'title' => $this->lang->line('sales_update')))
			));

			foreach($report_data['details'][$key] as $drow)
			{
				$details_data[$row['sale_id']][] = $this->xss_clean(array(
					$drow['name'],
					$drow['category'],
					$drow['serialnumber'],
					$drow['description'],
					to_quantity_decimals($drow['quantity_purchased']),
					to_currency($drow['subtotal']),
					to_currency_tax($drow['tax']),
					to_currency($drow['total']),
					to_currency($drow['cost']),
					to_currency($drow['profit']),
					($drow['discount_type'] == PERCENT)? $drow['discount'].'%':to_currency($drow['discount'])));
			}

			if(isset($report_data['rewards'][$key]))
			{
				foreach($report_data['rewards'][$key] as $drow)
				{
					$details_data_rewards[$row['sale_id']][] = $this->xss_clean(array($drow['used'], $drow['earned']));
				}
			}
		}

		$customer_info = $this->Customer->get_info($customer_id);
		if(!empty($customer_info->company_name))
		{
			$customer_name ='[ '.$customer_info->company_name.' ]';
		}
		else
		{
			$customer_name = $customer_info->company_name;
		}

		$data = array(
			'title' => $this->xss_clean($customer_info->first_name . ' ' . $customer_info->last_name . ' ' . $this->lang->line('reports_report')),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $headers,
			'editable' => 'sales',
			'summary_data' => $summary_data,
			'details_data' => $details_data,
			'details_data_rewards' => $details_data_rewards,
			'overall_summary_data' => $this->xss_clean($model->getSummaryData($inputs))
		);

		$this->load->view('reports/tabular_details', $data);
	}
	
	public function specific_tax_input()
	{
		$data = array();
		$data['specific_input_name'] = $this->lang->line('reports_transaction');

		$report_type = array('Sales' => $this->lang->line('reports_sales'),	'Purchase' => $this->lang->line('reports_purchase'));
		//$report_type = array('All' => $this->lang->line('reports_all'),'Sales' => $this->lang->line('reports_sales'),	'Purchase' => $this->lang->line('reports_purchase'));
		$data['specific_input_data'] = $report_type;
		
		$this->load->view('reports/specific_tax_input', $data);
	}
	
	public function taxfullreport($start_date, $end_date, $tr_type)
		{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'tr_type' => $tr_type);

		$this->load->model('reports/Tax_full');
		$model = $this->Tax_full;

		$report_data = $model->getData($inputs);
		$summary = $this->xss_clean($model->getSummaryData($inputs));

		$tabular_data = array();
		foreach($report_data as $row)
		{
			
			$employee_info = $this->Employee->get_info($row['employee_id']);
			$this->load->model('User_info');
			$party_info = $this->User_info->get_info($row['customer_id']);
			
			if($row['typ'] == 'Purchase')
			{
				$vat_info = $this->Supplier->get_info($row['customer_id']);
			}
			elseif($row['typ'] == 'Sales')
			{
				$vat_info = $this->Customer->get_info($row['customer_id']);
			}
			
			$tabular_data[] = $this->xss_clean(array(
				'thedate' => date($this->config->item('dateformat'), strtotime($row['thedate'])),
				'description' => $row['description'],
				'created_by' =>  $this->xss_clean($employee_info->first_name . ' ' . $employee_info->last_name . ' '),
				'party' => $this->xss_clean($party_info->first_name . ' ' . $party_info->last_name . ' '),
				'vat' => $this->xss_clean($vat_info->Vat_no),
				'typ' => $row['typ'],
				'tax' => to_currency_tax($row['tax']),
				'subtotal' => to_currency($row['subtotal']),
				'total' => to_currency($row['total'])
			));
		}
      
	  $data = array(
			'title' => $this->lang->line('reports_taxfullreport'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary
		);
		$this->load->view('reports/tabular', $data);
	}

	function cash_flow($start_date, $end_date, $employees = -1, $location_id, $export_excel=0)
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'employees' => $employees, 'location_id' => $location_id);

		$this->load->model('reports/Cash_flow');
		$model = $this->Cash_flow;
				
		if($employees == -1)
        {
			$employee_name = 'All';
		}
		else
		{
			$employee_name = $this->Employee->get_info($employees);
			$employee_name = $employee_name->first_name . ' ' . $employee_name->last_name;
		}
		if($location_id == 'all')
        {
			$location_name = 'All';
		}
		else
		{
			$location_name = $this->Stock_location->get_location_name($location_id);
		}
		$report_data = $model->getData($inputs);

		$summary = $this->xss_clean($model->getSummaryData($inputs));
		$opening_balance_data = $this->xss_clean($model->getopeningBalance($inputs));

		foreach($opening_balance_data as $name)
	    { 
   		    $credit_amount = $name['credit_amount'];
			$debit_amount = $name['debit_amount'];
     	}
		
		$opening_balance = bcsub($debit_amount, $credit_amount, 2);
		$closing_balance = $opening_balance;
				
		$tabular_data = array();
		    $tabular_data[] = $this->xss_clean(array(
				'description' => '<i>Opening Balance</i>',
				'balance' => '<i>'. to_currency($closing_balance).'</i>'
			));

		$count = '0';
		$count_2 = '1';
		foreach($report_data as $row)
		{
			$count += 1;
			$employee_info = $this->Employee->get_info($row['employee_id']);
			$this->load->model('User_info');
			$party_info = $this->User_info->get_info($row['accounts']);
			
		//	if ($count_2 * 25 == $count)
	//		{
		//		$count_2 += 1;
		//	    $tabular_data[] = $this->xss_clean(array(
		//		'description' => '<i>Opening Balance</i>',
		//		'balance' => '<i>'. to_currency($closing_balance).'</i>'
		//	));
		//	}

			$credit_amount = $row['credit_amount'];
			$debit_amount = $row['debit_amount'];
			
			$closing_balance = bcadd($closing_balance, $debit_amount);
			$closing_balance = bcsub($closing_balance, $credit_amount);

			$tabular_data[] = $this->xss_clean(array(
				'tid' =>  $row['tid'],
				'thedate' =>  date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'), strtotime($row['thedate'])),
				'description' => $row['description'],
				'created_by' =>  $this->xss_clean($employee_info->first_name . ' ' . $employee_info->last_name . ' '),
				'party' => $this->xss_clean($party_info->first_name . ' ' . $party_info->last_name . ' '),
				'typ' => $row['type'],
				'location_id' => $this->Stock_location->get_location_name($row['location_id']),
				'credit_amount' => $row['credit_amount'],
				'debit_amount' => to_currency($row['debit_amount']),
				'balance' => to_currency($closing_balance),
			));
		}
      
	  $data = array(
			'title' => $this->lang->line('reports_cash_flow_report'),
	        'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
	        'report_title' => 'Result From Employee: '.$employee_name.', Location: '.$location_name,
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $summary,
			'opening_balance_data' => $opening_balance,
			'closing_balance_data' => $closing_balance
		);
		$this->load->view('reports/tabular', $data);
	}
	
	function taxgeneratereport($start_date, $end_date, $sale_type, $export_excel=0)
	{
		$this->load->model('reports/Tax_generate');
	    $model = $this->Tax_generate;
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date);
		$sales = $this->xss_clean($model->getsalesData($inputs));
		$purchase = $this->xss_clean($model->getpurchaseData($inputs));
		$zerosales = $this->xss_clean($model->getzerosalesData($inputs));
		$zeropurchase = $this->xss_clean($model->getzeropurhaseData($inputs));
		$data = array(
			"title" => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			"sales" =>  $sales,
			"purchase" => $purchase,	
			"zero_sales" => $zerosales,	
			"zero_purchase" => $zeropurchase
		 );
	 $this->load->view("reports/generate_tax",$data);	
	}

	public function specific_employee_input()
	{
		$data = array();
		$data['specific_input_name'] = $this->lang->line('reports_employee');

		$employees = array();
		foreach($this->Employee->get_all()->result() as $employee)
		{
			$employees[$employee->person_id] = $this->xss_clean($employee->first_name . ' ' . $employee->last_name);
		}
		$data['specific_input_data'] = $employees;
		$data['sale_type_options'] = $this->get_sale_type_options();

		$this->load->view('reports/specific_input', $data);
	}

	public function specific_employee($start_date, $end_date, $employee_id, $sale_type)
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'employee_id' => $employee_id, 'sale_type' => $sale_type);

		$this->load->model('reports/Specific_employee');
		$model = $this->Specific_employee;

		$model->create($inputs);

		$headers = $this->xss_clean($model->getDataColumns());
		$report_data = $model->getData($inputs);

		$summary_data = array();
		$details_data = array();
		$details_data_rewards = array();

		foreach($report_data['summary'] as $key => $row)
		{
			if($row['sale_status'] == CANCELED)
			{
				$button_key = 'data-btn-restore';
				$button_label = $this->lang->line('common_restore');
			}
			else
			{
				$button_key = 'data-btn-delete';
				$button_label = $this->lang->line('common_delete');
			}

			$summary_data[] = $this->xss_clean(array(
				'id' => $row['sale_id'],
				'type_code' => $row['type_code'],
				'sale_date' => date($this->config->item('dateformat'), strtotime($row['sale_date'])),
				'quantity' => to_quantity_decimals($row['items_purchased']),
				'customer_name' => $row['customer_name'],
				'subtotal' => to_currency($row['subtotal']),
				'tax' => to_currency_tax($row['tax']),
				'total' => to_currency($row['total']),
				'cost' => to_currency($row['cost']),
				'profit' => to_currency($row['profit']),
				'payment_type' => $row['payment_type'],
				'comment' => $row['comment'],
				'edit' => anchor('sales/edit/'. $row['sale_id'], '<span class="glyphicon glyphicon-edit"></span>',
					array('class'=>'modal-dlg print_hide', $button_key => $button_label, 'data-btn-submit' => $this->lang->line('common_submit'), 'title' => $this->lang->line('sales_update')))
			));

			foreach($report_data['details'][$key] as $drow)
			{
				$details_data[$row['sale_id']][] = $this->xss_clean(array(
					$drow['name'],
					$drow['category'],
					$drow['serialnumber'],
					$drow['description'],
					to_quantity_decimals($drow['quantity_purchased']),
					to_currency($drow['subtotal']),
					to_currency_tax($drow['tax']),
					to_currency($drow['total']),
					to_currency($drow['cost']),
					to_currency($drow['profit']),
					($drow['discount_type'] == PERCENT)? $drow['discount'].'%':to_currency($drow['discount'])));
			}

			if(isset($report_data['rewards'][$key]))
			{
				foreach($report_data['rewards'][$key] as $drow)
				{
					$details_data_rewards[$row['sale_id']][] = $this->xss_clean(array($drow['used'], $drow['earned']));
				}
			}
		}

		$employee_info = $this->Employee->get_info($employee_id);
		$data = array(
			'title' => $this->xss_clean($employee_info->first_name . ' ' . $employee_info->last_name . ' ' . $this->lang->line('reports_report')),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $headers,
			'editable' => 'sales',
			'summary_data' => $summary_data,
			'details_data' => $details_data,
			'details_data_rewards' => $details_data_rewards,
			'overall_summary_data' => $this->xss_clean($model->getSummaryData($inputs))
		);

		$this->load->view('reports/tabular_details', $data);
	}

	public function specific_discount_input()
	{
		$data = array();
		$data['specific_input_name'] = $this->lang->line('reports_discount');

		$discounts = array();
		for($i = 0; $i <= 100; $i += 10)
		{
			$discounts[$i] = $i . '%';
		}
		$data['specific_input_data'] = $discounts;
		$data['discount_type_options'] = array(
			'0' => $this->lang->line('reports_discount_percent'),
			'1'=> $this->lang->line('reports_discount_fixed'));
		$data['sale_type_options'] = $this->get_sale_type_options();

		$data = $this->xss_clean($data);

		$this->load->view('reports/specific_input', $data);
	}

	public function specific_discount($start_date, $end_date, $discount, $sale_type, $discount_type)
	{
		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'discount' => $discount, 'sale_type' => $sale_type, 'discount_type' => $discount_type);

		$this->load->model('reports/Specific_discount');
		$model = $this->Specific_discount;

		$model->create($inputs);

		$headers = $this->xss_clean($model->getDataColumns());
		$report_data = $model->getData($inputs);

		$summary_data = array();
		$details_data = array();
		$details_data_rewards = array();

		foreach($report_data['summary'] as $key => $row)
		{
			if($row['sale_status'] == CANCELED)
			{
				$button_key = 'data-btn-restore';
				$button_label = $this->lang->line('common_restore');
			}
			else
			{
				$button_key = 'data-btn-delete';
				$button_label = $this->lang->line('common_delete');
			}

			$summary_data[] = $this->xss_clean(array(
				'id' => $row['sale_id'],
				'type_code' => $row['type_code'],
				'sale_date' => date($this->config->item('dateformat'), strtotime($row['sale_date'])),
				'quantity' => to_quantity_decimals($row['items_purchased']),
				'employee_name' => $row['employee_name'],
				'customer_name' => $row['customer_name'],
				'subtotal' => to_currency($row['subtotal']),
				'tax' => to_currency_tax($row['tax']),
				'total' => to_currency($row['total']),
				'cost' => to_currency($row['cost']),
				'profit' => to_currency($row['profit']),
				'payment_type' => $row['payment_type'],
				'comment' => $row['comment'],
				'edit' => anchor('sales/edit/'. $row['sale_id'], '<span class="glyphicon glyphicon-edit"></span>',
					array('class'=>'modal-dlg print_hide', $button_key => $button_label, 'data-btn-submit' => $this->lang->line('common_submit'), 'title' => $this->lang->line('sales_update')))
			));

			foreach($report_data['details'][$key] as $drow)
			{
				$details_data[$row['sale_id']][] = $this->xss_clean(array(
					$drow['name'],
					$drow['category'],
					$drow['serialnumber'],
					$drow['description'],
					to_quantity_decimals($drow['quantity_purchased']),
					to_currency($drow['subtotal']),
					to_currency_tax($drow['tax']),
					to_currency($drow['total']),
					to_currency($drow['cost']),
					to_currency($drow['profit']),
					($drow['discount_type'] == PERCENT)? $drow['discount'].'%':to_currency($drow['discount'])));
			}

			if(isset($report_data['rewards'][$key]))
			{
				foreach($report_data['rewards'][$key] as $drow)
				{
					$details_data_rewards[$row['sale_id']][] = $this->xss_clean(array($drow['used'], $drow['earned']));
				}
			}
		}

		$data = array(
			'title' => $discount . '% ' . $this->lang->line('reports_discount') . ' ' . $this->lang->line('reports_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $headers,
			'summary_data' => $summary_data,
			'details_data' => $details_data,
			'details_data_rewards' => $details_data_rewards,
			'overall_summary_data' => $this->xss_clean($model->getSummaryData($inputs))
		);

		$this->load->view('reports/tabular_details', $data);
	}

	public function get_detailed_sales_row($sale_id)
	{
		$inputs = array('sale_id' => $sale_id);

		$this->load->model('reports/Detailed_sales');
		$model = $this->Detailed_sales;

		$model->create($inputs);

		$report_data = $model->getDataBySaleId($sale_id);

		if($report_data['sale_status'] == CANCELED)
		{
			$button_key = 'data-btn-restore';
			$button_label = $this->lang->line('common_restore');
		}
		else
		{
			$button_key = 'data-btn-delete';
			$button_label = $this->lang->line('common_delete');
		}

		$summary_data = $this->xss_clean(array(
			'sale_id' => $report_data['sale_id'],
			'sale_date' => date($this->config->item('dateformat'), strtotime($report_data['sale_date'])),
			'quantity' => to_quantity_decimals($report_data['items_purchased']),
			'employee_name' => $report_data['employee_name'],
			'customer_name' => $report_data['customer_name'],
			'subtotal' => to_currency($report_data['subtotal']),
			'tax' => to_currency_tax($report_data['tax']),
			'total' => to_currency($report_data['total']),
			'cost' => to_currency($report_data['cost']),
			'profit' => to_currency($report_data['profit']),
			'payment_type' => $report_data['payment_type'],
			'comment' => $report_data['comment'],
			'edit' => anchor('sales/edit/'. $report_data['sale_id'], '<span class="glyphicon glyphicon-edit"></span>',
				array('class'=>'modal-dlg print_hide', $button_key => $button_label, 'data-btn-submit' => $this->lang->line('common_submit'), 'title' => $this->lang->line('sales_update')))
		));

		echo json_encode(array($sale_id => $summary_data));
	}

	public function get_sale_type_options()
	{
		$sale_type_options = array();
		$sale_type_options['complete'] = $this->lang->line('reports_complete');
		$sale_type_options['sales'] = $this->lang->line('reports_completed_sales');
		if($this->config->item('invoice_enable') == '1')
		{
			$sale_type_options['quotes'] = $this->lang->line('reports_quotes');
			if($this->config->item('work_order_enable') == '1')
			{
				$sale_type_options['work_orders'] = $this->lang->line('reports_work_orders');
			}
		}
		$sale_type_options['canceled'] = $this->lang->line('reports_canceled');
		$sale_type_options['returns'] = $this->lang->line('reports_returns');
		return $sale_type_options;
	}

	public function detailed_sales($start_date, $end_date, $sale_type, $location_id = 'all')
	{
		$definition_names = $this->Attribute->get_definitions_by_flags(Attribute::SHOW_IN_SALES);

		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'sale_type' => $sale_type, 'location_id' => $location_id, 'definition_ids' => array_keys($definition_names));

		$this->load->model('reports/Detailed_sales');
		$model = $this->Detailed_sales;

		$model->create($inputs);

		$columns = $model->getDataColumns();
		$columns['details'] = array_merge($columns['details'], $definition_names);

		$headers = $this->xss_clean($columns);

		$report_data = $model->getData($inputs);

		$summary_data = array();
		$details_data = array();
		$details_data_rewards = array();

		$show_locations = $this->xss_clean($this->Stock_location->multiple_locations());

		foreach($report_data['summary'] as $key => $row)
		{
			if($row['sale_status'] == CANCELED)
			{
				$button_key = 'data-btn-restore';
				$button_label = $this->lang->line('common_restore');
			}
			else
			{
				$button_key = 'data-btn-delete';
				$button_label = $this->lang->line('common_delete');
			}

			$summary_data[] = $this->xss_clean(array(
				'id' => $row['sale_id'],
				'type_code' => $row['type_code'],
				'sale_date' => date($this->config->item('dateformat'), strtotime($row['sale_date'])),
				'quantity' => to_quantity_decimals($row['items_purchased']),
				'employee_name' => $row['employee_name'],
				'customer_name' => $row['customer_name'],
				'subtotal' => to_currency($row['subtotal']),
				'tax' => to_currency_tax($row['tax']),
				'total' => to_currency($row['total']),
				'cost' => to_currency($row['cost']),
				'profit' => to_currency($row['profit']),
				'payment_type' => $row['payment_type'],
				'comment' => $row['comment'],
				'edit' => anchor('sales/edit/'.$row['sale_id'], '<span class="glyphicon glyphicon-edit"></span>',
					array('class' => 'modal-dlg print_hide', $button_key => $button_label, 'data-btn-submit' => $this->lang->line('common_submit'), 'title' => $this->lang->line('sales_update')))
			));

			foreach($report_data['details'][$key] as $drow)
			{
				$quantity_purchased = to_quantity_decimals($drow['quantity_purchased']);
				if($show_locations)
				{
					$quantity_purchased .= ' [' . $this->Stock_location->get_location_name($drow['item_location']) . ']';
				}

				$attribute_values = (isset($drow['attribute_values'])) ? $drow['attribute_values'] : '';
				$attribute_values = expand_attribute_values($definition_names, $attribute_values);

				$details_data[$row['sale_id']][] = $this->xss_clean(array_merge(array(
					$drow['name'],
					$drow['category'],
					$drow['serialnumber'],
					$drow['description'],
					$quantity_purchased,
					to_currency($drow['subtotal']),
					to_currency_tax($drow['tax']),
					to_currency($drow['total']),
					to_currency($drow['cost']),
					to_currency($drow['profit']),
					($drow['discount_type'] == PERCENT)? $drow['discount'].'%':to_currency($drow['discount'])), $attribute_values));

			}

			if(isset($report_data['rewards'][$key]))
			{
				foreach($report_data['rewards'][$key] as $drow)
				{
					$details_data_rewards[$row['sale_id']][] = $this->xss_clean(array($drow['used'], $drow['earned']));
				}
			}
		}

		$data = array(
			'title' => $this->lang->line('reports_detailed_sales_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $headers,
			'editable' => 'sales',
			'summary_data' => $summary_data,
			'details_data' => $details_data,
			'details_data_rewards' => $details_data_rewards,
			'overall_summary_data' => $this->xss_clean($model->getSummaryData($inputs))
		);
		$this->load->view('reports/tabular_details', $data);
	}

	public function get_detailed_receivings_row($receiving_id)
	{
		$inputs = array('receiving_id' => $receiving_id);

		$this->load->model('reports/Detailed_receivings');
		$model = $this->Detailed_receivings;

		$model->create($inputs);

		$report_data = $model->getDataByReceivingId($receiving_id);

		$summary_data = $this->xss_clean(array(
			'receiving_id' => $report_data['receiving_id'],
			'receiving_date' => date($this->config->item('dateformat'), strtotime($report_data['receiving_date'])),
			'quantity' => to_quantity_decimals($report_data['items_purchased']),
			'employee_name' => $report_data['employee_name'],
			'supplier_name' => $report_data['supplier_name'],
			'total' => to_currency($report_data['total']),
			'payment_type' => $report_data['payment_type'],
			'reference' => $report_data['reference'],
			'comment' => $report_data['comment'],
			'edit' => anchor('receivings/edit/'. $report_data['receiving_id'], '<span class="glyphicon glyphicon-edit"></span>',
				array('class'=>'modal-dlg print_hide', 'data-btn-submit' => $this->lang->line('common_submit'), 'data-btn-delete' => $this->lang->line('common_delete'), 'title' => $this->lang->line('receivings_update'))
			)
		));

		echo json_encode(array($receiving_id => $summary_data));
	}

	public function detailed_receivings($start_date, $end_date, $receiving_type, $location_id = 'all')
	{
		$definition_names = $this->Attribute->get_definitions_by_flags(Attribute::SHOW_IN_RECEIVINGS);

		$inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'receiving_type' => $receiving_type, 'location_id' => $location_id, 'definition_ids' => array_keys($definition_names));

		$this->load->model('reports/Detailed_receivings');
		$model = $this->Detailed_receivings;

		$model->create($inputs);

		$columns = $model->getDataColumns();
		$columns['details'] = array_merge($columns['details'], $definition_names);

		$headers = $this->xss_clean($columns);
		$report_data = $model->getData($inputs);

		$summary_data = array();
		$details_data = array();

		$show_locations = $this->xss_clean($this->Stock_location->multiple_locations());

		foreach($report_data['summary'] as $key => $row)
		{
			$summary_data[] = $this->xss_clean(array(
				'id' => $row['receiving_id'],
				'receiving_date' => date($this->config->item('dateformat'), strtotime($row['receiving_date'])),
				'quantity' => to_quantity_decimals($row['items_purchased']),
				'employee_name' => $row['employee_name'],
				'supplier_name' => $row['supplier_name'],
				'subtotal' => to_currency($row['subtotal']),
				'tax' => to_currency_tax($row['tax']),
				'total' => to_currency($row['total']),
				'profit' => to_currency($row['profit']),
				'payment_type' => $row['payment_type'],
				'reference' => $row['reference'],
				'comment' => $row['comment'],
				'edit' => anchor('receivings/edit/' . $row['receiving_id'], '<span class="glyphicon glyphicon-edit"></span>',
					array('class' => 'modal-dlg print_hide', 'data-btn-delete' => $this->lang->line('common_delete'), 'data-btn-submit' => $this->lang->line('common_submit'), 'title' => $this->lang->line('receivings_update'))
				)
			));

			foreach($report_data['details'][$key] as $drow)
			{
				$quantity_purchased = $drow['receiving_quantity'] > 1 ? to_quantity_decimals($drow['quantity_purchased']) . ' x ' . to_quantity_decimals($drow['receiving_quantity']) : to_quantity_decimals($drow['quantity_purchased']);
				if($show_locations)
				{
					$quantity_purchased .= ' [' . $this->Stock_location->get_location_name($drow['item_location']) . ']';
				}

				$attribute_values = (isset($drow['attribute_values'])) ? $drow['attribute_values'] : '';
				$attribute_values = expand_attribute_values($definition_names, $attribute_values);

				$details_data[$row['receiving_id']][] = $this->xss_clean(array_merge(array(
					$drow['item_number'],
					$drow['name'],
					$drow['category'],
					$quantity_purchased,
					to_currency($drow['subtotal']),
					to_currency_tax($drow['tax']),
					to_currency($drow['total']),
					($drow['discount_type'] == PERCENT)? $drow['discount'].'%':to_currency($drow['discount'])), $attribute_values));

			}
		}

		$data = array(
			'title' => $this->lang->line('reports_detailed_receivings_report'),
			'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date)),
			'headers' => $headers,
			'editable' => 'receivings',
			'summary_data' => $summary_data,
			'details_data' => $details_data,
			'overall_summary_data' => $this->xss_clean($model->getSummaryData($inputs))
		);

		$this->load->view('reports/tabular_details', $data);
	}

	public function inventory_low()
	{
		$inputs = array();

		$this->load->model('reports/Inventory_low');
		$model = $this->Inventory_low;

		$report_data = $model->getData($inputs);

		$tabular_data = array();
		foreach($report_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
				'item_name' => $row['name'],
				'item_number' => $row['item_number'],
				'quantity' => to_quantity_decimals($row['quantity']),
				'reorder_level' => to_quantity_decimals($row['reorder_level']),
				'location_name' => $row['location_name']
			));
		}

		$data = array(
			'title' => $this->lang->line('reports_inventory_low_report'),
			'subtitle' => '',
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $this->xss_clean($model->getSummaryData($inputs))
		);

		$this->load->view('reports/tabular', $data);
	}

	public function inventory_summary_input()
	{
		$this->load->model('reports/Inventory_summary');
		$model = $this->Inventory_summary;

		$data = array();
		$data['item_count'] = $model->getItemCountDropdownArray();

		$stock_locations = $this->xss_clean($this->Stock_location->get_allowed_locations());
		$stock_locations['all'] = $this->lang->line('reports_all');
		$data['stock_locations'] = array_reverse($stock_locations, TRUE);

		$this->load->view('reports/inventory_summary_input', $data);
	}

	public function inventory_summary($location_id = 'all', $item_count = 'all')
	{
		$inputs = array('location_id' => $location_id, 'item_count' => $item_count);

		$this->load->model('reports/Inventory_summary');
		$model = $this->Inventory_summary;

		$report_data = $model->getData($inputs);

		$tabular_data = array();
		foreach($report_data as $row)
		{
			$tabular_data[] = $this->xss_clean(array(
				'item_name' => $row['name'],
				'item_number' => $row['item_number'],
				'quantity' => to_quantity_decimals($row['quantity']),
				'low_sell_quantity' => to_quantity_decimals($row['low_sell_quantity']),
				'reorder_level' => to_quantity_decimals($row['reorder_level']),
				'location_name' => $row['location_name'],
				'cost_price' => to_currency($row['cost_price']),
				'unit_price' => to_currency($row['unit_price']),
				'wholesale_price' => to_currency($row['wholesale_price']),
				'subtotal' => to_currency($row['sub_total_value'])
			));
		}

		$data = array(
			'title' => $this->lang->line('reports_inventory_summary_report'),
			'subtitle' => '',
			'headers' => $this->xss_clean($model->getDataColumns()),
			'data' => $tabular_data,
			'summary_data' => $this->xss_clean($model->getSummaryData($report_data))
		);

		$this->load->view('reports/tabular', $data);
	}

	//	Returns subtitle for the reports
	private function _get_subtitle_report($inputs)
	{
		$subtitle = '';

		if(empty($this->config->item('date_or_time_format')))
		{
			$subtitle .= date($this->config->item('dateformat'), strtotime($inputs['start_date'])) . ' - ' .date($this->config->item('dateformat'), strtotime($inputs['end_date']));
		}
		else
		{
			$subtitle .= date($this->config->item('dateformat').' '.$this->config->item('timeformat'), strtotime(rawurldecode($inputs['start_date']))) . ' - ' . date($this->config->item('dateformat').' '.$this->config->item('timeformat'), strtotime(rawurldecode($inputs['end_date'])));
		}

		return $subtitle;
	}
}
?>
