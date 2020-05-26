<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Accounts extends Secure_Controller
{
	public function __construct()
	{
		parent::__construct('accounts');
		$this->load->library('account_lib');
	}
	
	public function index()
	{
		$this->arabic->load('Date');
        $this->arabic->setMode(1);
        $hdate = $this->arabic->date('l dS F Y', time());	
		$data['hdate'] = $hdate;
		$person_id = $this->session->userdata('person_id');
		$this->load->view('accounts/listing', $data);
	}
	
	public function accounts()
	{
		$this->arabic->load('Date');
        $this->arabic->setMode(1);
        $hdate = $this->arabic->date('l dS F Y', time());	
		$data['hdate'] = $hdate;
		$person_id = $this->session->userdata('person_id');
		
		if(!$this->Employee->has_grant('suppliers', $person_id))
		{
			$data['account_type_options'] = array(
			'0'=> $this->lang->line('account_customer'));
		}
		else
		{
			$data['account_type_options'] = array(
			'0' => $this->lang->line('account_customer'),
			'1'=> $this->lang->line('account_supplier'));
		}	

			
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
			
		$customers = $this->xss_clean($customers);

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
        $suppliers = $this->xss_clean($suppliers);
		$data['stock_locations'] = $this->Stock_location->get_allowed_locations('customers');
		$data['stock_location'] = $this->xss_clean($this->account_lib->get_account_location());
		$data['specific_supplier_data'] = $suppliers;
		$data['specific_customer_data'] = $customers;
		$this->load->view('accounts/search', $data);
	}
	
	function manage($mode = -1, $customer_id = -1, $location_id = -1)
    {
		if ($mode == 0)
		{
		$account_info = $this->Customer->get_info($customer_id);
		if(!empty($account_info->company_name))
		{
			$data['account'] = $account_info->company_name;
		}
		else
		{
			$data['account'] = $account_info->first_name . ' ' . $account_info->last_name;
		}   
		$data['account_id'] = $customer_id;
		$data['table_headers'] = $this->xss_clean(get_accounts_manage_table_headers());
		}
		elseif ($mode == 1)
		{
			$account_info = $this->Supplier->get_info($customer_id);
		    if(!empty($account_info->company_name))
			{
			    $data['account'] = $account_info->company_name;
			}
		    else
			{
			    $data['account'] = $account_info->first_name . ' ' . $customer_info->last_name;
			}   
		    $data['account_id'] = $customer_id;
			$data['table_headers'] = $this->xss_clean(get_supplier_accounts_manage_table_headers());
		}
		else
		{
			header('Location: /');
		}
		$balance = $this->get_customer_balance($customer_id);
		$data['balance'] = $this->xss_clean($balance);
		$data['location_id'] = $this->xss_clean($location_id);
		$data['mode'] = $this->xss_clean($mode);
		$this->load->view('accounts/manage', $data);
    }
	
	function receipt($mode = -1, $trans_id = -1, $balance_amount = -1)
    {
		$data = array();
    	if ($mode == 0)
		{
		    $data['payment_info'] = $this->Account->get_customer_info($trans_id);
		}
		elseif ($mode == 1)
		{
	    	$data['payment_info'] = $this->Account->get_receivings_info($trans_id);
		}
        $data['trans_id'] = $trans_id;
        $data['balance_amount'] = $balance_amount;
        $data['mode'] = $mode;
		$this->load->view("accounts/receipt_pdf", $data);
    }
	   
	public function search()
	{
		$search = $this->input->get('search');
		$limit = $this->input->get('limit');
		$offset = $this->input->get('offset');
		$sort = $this->input->get('sort');
		$order = $this->input->get('order');
		$mode = $this->input->get('mode');
		$account_id = $this->input->get('account');
		$location_id = $this->input->get('location_id');
		$filters  = array(
					 'start_date' => $this->input->get('start_date'),
					 'end_date' => $this->input->get('end_date'),
					 'account' => $account_id);
		$start_date = $this->input->get('start_date');
					 
		if ($mode == 0)
		{
			$balance = $this->Account->get_customer_balance($account_id);
			$opening_balance = $this->Account->get_customer_opening_balance($account_id, $start_date);
			$accounts = $this->Account->search($search, $filters, $limit, $offset, $sort, $order);

		    $total_rows = $this->Account->get_found_rows($search, $filters);

		    $data_rows = array();
			
		    $data_rows[] = $this->xss_clean(array(
				'description' => '<i>Opening Balance</i>',
				'balance_amount' => '<i>'. to_currency($opening_balance).'</i>'
			));
			
		    foreach($accounts->result() as $account)
		    {
				$debit_amount = $account->debit_amount;
				$credit_amount = $account->credit_amount;
				$balance_amount = bcsub($debit_amount, $credit_amount, 2);
				$opening_balance = bcadd($opening_balance, $balance_amount, 2);
			    $data_rows[] = $this->xss_clean(get_accounts_data_row($account, $opening_balance));
		    }

		    if($total_rows > 0)
		    {
			    $data_rows[] = $this->xss_clean(get_accounts_data_last_row($accounts, $balance));
		    }
		}
		else
		{
			$balance = $this->Account->get_supplier_balance($account_id);
			$opening_balance = $this->Account->get_supplier_opening_balance($account_id, $start_date);
			$accounts = $this->Account->search_supplier($search, $filters, $limit, $offset, $sort, $order);

		    $total_rows = $this->Account->get_supplier_found_rows($search, $filters);

		    $data_rows = array();
			
		    $data_rows[] = $this->xss_clean(array(
				'description' => '<i>Opening Balance</i>',
				'balance_amount' => '<i>'. to_currency($opening_balance).'</i>'
			));
			
		    foreach($accounts->result() as $account)
		    {
				$debit_amount = $account->debit_amount;
				$credit_amount = $account->credit_amount;
				$balance_amount = bcsub($debit_amount, $credit_amount, 2);
				$opening_balance = bcadd($opening_balance, $balance_amount, 2);
			    $data_rows[] = $this->xss_clean(get_supplier_accounts_data_row($account, $opening_balance));
		    }

		    if($total_rows > 0)
		    {
			    $data_rows[] = $this->xss_clean(get_supplier_accounts_data_last_row($accounts, $balance));
		    }
		}
	 
		//$filledup = array_fill_keys($this->input->get('filters'), TRUE);
		//$filters = array_merge($filters, $filledup);
		echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
	}
	
	public function ajax_check_amount()
	{
		$value = $this->input->post();
		$parsed_value = parse_decimals(array_pop($value));
		echo json_encode(array('success' => $parsed_value !== FALSE, 'amount' => to_currency_no_money($parsed_value)));
	}

    public function view($mode = -1, $account_id = -1, $location_id = -1)
	{
		$data = array();
		$data['stock_locations'] = $this->Stock_location->get_allowed_locations('customers');
        $data['stock_location'] = $this->xss_clean($location_id);
		$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		$data['employee_id'] = $employee_id;
		$employee_info = $this->Employee->get_info($employee_id);
		$data['employee'] = $employee_info->first_name . ' ' . mb_substr($employee_info->last_name, 0, 1);
		$data['company_info'] = implode("\n", array(
			$this->config->item('address'),
			$this->config->item('phone'),
			$this->config->item('account_number')
		));
		
		if ($mode == 0)
		{
		$account_info = $this->Customer->get_info($account_id);
		if(!empty($account_info->company_name))
		{
			$data['account'] = $account_info->company_name;
		}
		else
		{
			$data['account'] = $account_info->first_name . ' ' . $account_info->last_name;
		}   
		$data['account_id'] = $account_id;
		}
		elseif ($mode == 1)
		{
			$account_info = $this->Supplier->get_info($account_id);
		    if(!empty($account_info->company_name))
			    {
			        $data['account'] = $account_info->company_name;
	            }
		    else
		        {
			        $data['account'] = $account_info->first_name . ' ' . $customer_info->last_name;
			    }   
		    $data['account_id'] = $account_id;
		}
        $data['mode'] = $mode;
		$this->load->view("accounts/form", $data);
	}
	
	public function edit_pay($mode = -1, $trans_id = -1)
	{
		$data = array();
    	if ($mode == 0)
		{
		    $data['payment_info'] = $this->Account->get_customer_info($trans_id);
		}
		elseif ($mode == 1)
		{
	    	$data['payment_info'] = $this->Account->get_receivings_info($trans_id);
		}
		$data['employee_id'] = $this->Employee->get_logged_in_employee_info()->person_id;
        $data['trans_id'] = $trans_id;
        $data['mode'] = $mode;
		$this->load->view("accounts/edit_pay", $data);
	}
	
	public function update_account($account_id = -1)
	{
		$amount = $this->input->post('amount');
		$notes = $this->input->post('notes');
		$mode = $this->input->post('mode');
		//customer recipt
		if ($mode == '0')
		{
		    $account_data = array(
			'debit_amount' => parse_decimals($this->input->post('amount')));
			
			$sales_data = array(
			'notes' => $notes,
			'credit_amount' => parse_decimals($this->input->post('amount')));
			
			$receipt_data = array(
			'thedate'=> date('Y-m-d H:i:s'),
			'type'=> 'Receipt',
			'description'=> 'CPAY '.$account_id,
			'employee_id' =>  $this->input->post('employee_id'),
			'location_id' => $this->input->post('stock_location'),
			'accounts' => $account_id,
			'amount'=> parse_decimals($this->input->post('amount')));
			
			if($this->Account->update_account($account_data, $sales_data, $receipt_data, $mode, $account_id))
		    {
		     	$account_data = $this->xss_clean($account_data);
		     	$sales_data = $this->xss_clean($sales_data);
	    		$receipt_data = $this->xss_clean($receipt_data);
				
	    		if($account_id == -1)
	    		{
	    			echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('account_successful_adding'), 'id' => $expense_data['ins_id']));
		    	}
		    	else // Existing
		     	{
		    		echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('account_successful_updating'), 'id' => $ins_id));
		    	}
		    }
	    	else//failure
	    	{
	    		echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('account_error_adding_updating'), 'id' => -1));
	    	}
		}
		else
		{
			//supplier payment
		    $account_data = array(
			'credit_amount' => parse_decimals($this->input->post('amount')));
			
			$sales_data = array(
			'notes' => $notes,
			'debit_amount' => parse_decimals($this->input->post('amount')));
			
			$payment_data = array(
			'thedate'=> date('Y-m-d H:i:s'),
			'type'=> 'Payment',
			'description'=> 'SPAY '.account_id,
			'employee_id' =>  $this->input->post('employee_id'),
			'location_id' => $this->input->post('stock_location'),
			'accounts' => $account_id,
			'amount'=> parse_decimals($this->input->post('amount')));
			
			if($this->Account->update_account($account_data, $sales_data, $payment_data, $mode, $account_id))
		    {
		     	$account_data = $this->xss_clean($account_data);
		     	$sales_data = $this->xss_clean($sales_data);
	    		$payment_data = $this->xss_clean($payment_data);
				
	    		if($account_id == -1)
	    		{
	    			echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('expenses_successful_adding'), 'id' => $expense_data['ins_id']));
		    	}
		    	else // Existing
		     	{
		    		echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('expenses_successful_updating'), 'id' => $ins_id));
		    	}
		    }
	    	else//failure
	    	{
	    		echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('expenses_error_adding_updating'), 'id' => -1));
	    	}
		}
	}
	
	public function get_customer_balance($customer_id)
	{
		$balance = $this->Account->get_customer_balance($customer_id);
		return $balance;
	}
	
	public function get_supplier_balance($supplier_id)
	{
		$balance = $this->Account->get_supplier_balance($supplier_id);
		return $balance;
	}
	
	public function save($account_id = -1)
	{
		$amount = $this->input->post('amount');
		$notes = $this->input->post('notes');
		$mode = $this->input->post('mode');
		if ($mode == '0')
		{
			$cur_balance = $this->Account->get_customer_balance($account_id);
		    $balance = bcsub($cur_balance, $amount);
		    $account_data = array(
			'thedate'=> date('Y-m-d H:i:s'),
			'notes' => $notes,
			'employee_id' => $this->input->post('employee_id'),
			'account_id' => $account_id,
			'credit_amount' => parse_decimals($this->input->post('amount')),
			'balance_amount' => $balance);
			
			$payment_data = array(
			    'thedate'=> date('Y-m-d H:i:s'),
				'type'=>'Receipt',
				'employee_id' =>  $this->input->post('employee_id'),
				'location_id' => $this->input->post('stock_location'),
				'accounts' => $account_id,
				'debit_amount'=> parse_decimals($this->input->post('amount')),
		);
		}
		else
		{
			$cur_balance = $this->Account->get_supplier_balance($account_id);
		    $balance = bcsub($cur_balance, $amount);
		    $account_data = array(
			'thedate'=> date('Y-m-d H:i:s'),
			'notes' => $notes,
			'employee_id' => $this->input->post('employee_id'),
			'account_id' => $account_id,
			'debit_amount' => parse_decimals($this->input->post('amount')),
			'balance_amount' => $balance);
			
			$payment_data = array(
		        'thedate'=> date('Y-m-d H:i:s'),
				'type'=>'Payment',
				'employee_id' =>  $this->input->post('employee_id'),
				'location_id' => $this->input->post('stock_location'),
				'accounts' => $account_id,
				'credit_amount'=> parse_decimals($this->input->post('amount')),
		);
		}
		
		if($this->Account->save($account_data, $payment_data, $mode, $account_id))
		{
			$account_data = $this->xss_clean($account_data);
			$payment_data = $this->xss_clean($payment_data);
			//New expense_id
			if($account_id == -1)
			{
				echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('account_successful_adding'), 'id' => $expense_data['ins_id']));
			}
			else // Existing Expense
			{
				echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('account_successful_updating'), 'id' => $ins_id));
			}
		}
		else//failure
		{
			echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('account_error_adding_updating'), 'id' => -1));
		}
	}
	
	public function cashflow_search()
	{
		$search = $this->input->get('search');
		$limit = $this->input->get('limit');
		$offset = $this->input->get('offset');
		$sort = $this->input->get('sort');
		$order = $this->input->get('order');
		$location_id = $this->input->get('location_id');
		$filters  = array(
					 'start_date' => $this->input->get('start_date'),
					 'end_date' => $this->input->get('end_date'));
					 

		$accounts = $this->Account->search_cashflow($search, $filters, $limit, $offset, $sort, $order);

		$total_rows = $this->Account->get_found_cashflow_rows($search, $filters);

		$data_rows = array();
		foreach($accounts->result() as $account)
	    {
		    $data_rows[] = $this->xss_clean(get_cash_flow_data_row($account));
		}

		if($total_rows > 0)
	    {
		    $data_rows[] = $this->xss_clean(get_cash_flow_data_last_row($accounts, $balance));
		}
	
		echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
	}
	
	function cashflow()
    {
		
		$data['table_headers'] = $this->xss_clean(get_cash_flow_manage_table_headers());

		$data['stock_locations'] = $this->Stock_location->get_allowed_locations('customers');
		$data['stock_location'] = $this->xss_clean($this->account_lib->get_account_location());

		$this->load->view('accounts/manage_cashflow', $data);
    }
	
	public function transfer_fund($trans_id = -1)
	{
		$data = array();
		$data['stock_locations'] = $this->Stock_location->get_allowed_locations('customers');
        $data['stock_location'] = $this->xss_clean($location_id);
		$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		$data['employee_id'] = $employee_id;
		$employee_info = $this->Employee->get_info($employee_id);
		$data['employee'] = $employee_info->first_name . ' ' . mb_substr($employee_info->last_name, 0, 1);
		$data['company_info'] = implode("\n", array(
			$this->config->item('address'),
			$this->config->item('phone'),
			$this->config->item('account_number')
		));
		$data['transfer_info'] = $this->Account->get_cashflow_info($trans_id);
		$data['trans_id'] = $trans_id;
	    $this->load->view("accounts/transfer_form", $data);
	}
	
	public function edit_transfer_fund($trans_id = -1)
	{
		$data = array();
		$data['transfer_info'] = $this->Account->get_cashflow_info($trans_id);
		$data['trans_id'] = $trans_id;
	    $this->load->view("accounts/edit_transfer_form", $data);
	}
	
	public function update_transfer_fund($trans_id = -1)
	{
		$transfer_from1 = array(
		    'thedate'=> date('Y-m-d H:i:s'),
			'description'=>'Transfer From '.$this->Stock_location->get_location_name($transfer_from),
			'Type'=>'Transfer',
			'employee_id' =>  $this->input->post('employee_id'),
			'location_id' => $this->input->post('transfer_to'),
			'credit_amount'=> parse_decimals($this->input->post('amount')),
		);
		if ($this->input->post('credit_amount'))
		{
			$transfer = array('credit_amount'=> parse_decimals($this->input->post('credit_amount')));
		}
		if ($this->input->post('debit_amount'))
		{
			$transfer = array('debit_amount'=> parse_decimals($this->input->post('debit_amount')));
		}

		if($this->Account->update_transfer_fund($transfer, $trans_id))
		{
			$transfer = $this->xss_clean($transfer);
			echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('transfer_fund_successful_updating'), 'id' => $trans_id));
		}
		else//failure
		{
			echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('transfer_fund_error_adding_updating'), 'id' => -1));
		}
	}
	
	public function save_cashflow($account_id = -1)
	{
		$amount = $this->input->post('amount');
		$notes = $this->input->post('notes');
		$transfer_from = $this->input->post('transfer_from');
		$transfer_to = $this->input->post('transfer_to');

		$transfer_from = array(
		    'thedate'=> date('Y-m-d H:i:s'),
			'description'=>'Transfer From '.$this->Stock_location->get_location_name($transfer_from),
			'Type'=>'Transfer',
			'employee_id' =>  $this->input->post('employee_id'),
			'location_id' => $this->input->post('transfer_to'),
			'debit_amount'=> parse_decimals($this->input->post('amount')),
		);
			
		$transfer_to = array(
		    'thedate'=> date('Y-m-d H:i:s'),
			'description'=>'Transfer to '.$this->Stock_location->get_location_name($transfer_to),
			'Type'=>'Transfer',
			'employee_id' =>  $this->input->post('employee_id'),
			'location_id' => $this->input->post('transfer_from'),
			'credit_amount'=> parse_decimals($this->input->post('amount')),
		);
		
		if($this->Account->save_cashflow($transfer_from, $transfer_to))
		{
			$transfer_from = $this->xss_clean($transfer_from);
			$transfer_to = $this->xss_clean($transfer_to);
			//New expense_id
			if($account_id == -1)
			{
				echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('cashflow_successful_adding'), 'id' => $expense_data['ins_id']));
			}
			else // Existing Expense
			{
				echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('cashflow_successful_updating'), 'id' => $ins_id));
			}
		}
		else//failure
		{
			echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('cashflow_error_adding_updating'), 'id' => -1));
		}
	}
	
	
	function accounts_chart()
    {
        $data['table_headers'] = $this->xss_clean(get_accounts_chart_manage_table_headers());
		$this->load->view('accounts/manage_accounts_chart', $data);
    }
	
	public function chart_search()
	{
		$search = $this->input->get('search');
		$limit = $this->input->get('limit');
		$offset = $this->input->get('offset');
		$sort = $this->input->get('sort');
		$order = $this->input->get('order');

		$charts = $this->Account->search_chart($search, $limit, $offset, $sort, $order);

		$total_rows = $this->Account->get_found_chart_rows($search);

		$data_rows = array();
		foreach($charts->result() as $chart)
	    {
			$row = $this->xss_clean(get_accounts_chart_data_row($chart));
			$row['nature'] = $this->Account->head_natures($row['nature']);
			$row['type'] = $this->Account->head_types($row['type']);
			$data_rows[] = $row;
		}
	
		echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
	}
	
	public function create_head($trans_id = -1)
	{
		$data = array();
		
		$data['natures'] = array(
		    '0' => $this->lang->line('account_nature_income'),
		    '1' => $this->lang->line('account_nature_expense'),
		    '2' => $this->lang->line('account_nature_assets'),
		    '3' => $this->lang->line('account_nature_libility'),
			'4' => $this->lang->line('account_nature_equity'));	
			
		$data['types'] = array(
		    '0' => $this->lang->line('account_type_current'),
			'1' => $this->lang->line('account_type_non_current'));		
			
		$data['head_info'] = $this->Account->head_info($trans_id);
		
		$trans_id = $data['head_info']->trans_id;
		
		$this->load->view("accounts/create_head_form", $data);
	}
	
	public function save_head($trans_id = -1)
	{

		$head_data = array(
			'name' => $this->input->post('name'),
			'nature' => $this->input->post('nature'),
			'type' => $this->input->post('type'),
			'description' => $this->input->post('description'),
			'deleted' => $this->input->post('deleted') != NULL
		);

		if($this->Account->save_head($head_data, $trans_id))
		{
			$head_data = $this->xss_clean($expense_data);

			if($trans_id == -1)
			{
				echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('head_successful_adding'), 'id' => $head_data['trans_id']));
			}
			else // Existing Header
			{
				echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('head_successful_updating'), 'id' => $trans_id));
			}
		}
		else//failure
		{
			echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('head_error_adding_updating'), 'id' => -1));
		}
	}
	
}
?>
