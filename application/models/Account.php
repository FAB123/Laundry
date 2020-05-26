<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Expense class
 */

class Account extends CI_Model
{
	/*
	Gets rows
	*/
	public function get_found_rows($search, $filters)
	{
		return $this->search($search, $filters, 0, 0, 'trans_id', 'asc', TRUE);
	}
	
	public function search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'sales_accounts.trans_id', $order = 'asc', $count_only = FALSE)
	{
		// get_found_rows case
		if($count_only == TRUE)
		{
			$this->db->select('COUNT(DISTINCT sales_accounts.trans_id) AS count');
		}
		else
		{
			$this->db->select('sales_accounts.trans_id AS trans_id');
			$this->db->select('MAX(sales_accounts.thedate) AS thedate');
			$this->db->select('MAX(sales_accounts.description) AS description');
			$this->db->select('MAX(sales_accounts.credit_amount) AS credit_amount');
			$this->db->select('MAX(sales_accounts.debit_amount) AS debit_amount');
			$this->db->select('MAX(sales_accounts.balance_amount) AS balance_amount');
			$this->db->select('MAX(sales_accounts.notes) AS notes');

			$this->db->select('MAX(employees.first_name) AS first_name');
			$this->db->select('MAX(employees.last_name) AS last_name');
		}

		$this->db->from('sales_accounts AS sales_accounts');
        $this->db->join('people AS employees', 'employees.person_id = sales_accounts.employee_id', 'LEFT'); 
		
			$this->db->group_start();
			$this->db->or_like('sales_accounts.thedate', $search);
			$this->db->or_like('sales_accounts.description', $search);
			$this->db->or_like('sales_accounts.credit_amount', $search);
			$this->db->or_like('sales_accounts.debit_amount', $search);
			$this->db->or_like('CONCAT(employees.first_name, " ", employees.last_name)', $search);
		$this->db->group_end();

		if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE_FORMAT(sales_accounts.thedate, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
		}
		else
		{
			$this->db->where('sales_accounts.thedate BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
		}
		if($filters['account'] != FALSE)
		{
			$this->db->like('sales_accounts.account_id', $filters['account']);
		}
		

		if($count_only == TRUE)
		{
			return $this->db->get()->row()->count;
		}

		// avoid duplicated entries with same name because of inventory reporting multiple changes on the same item in the same date range
		$this->db->group_by('sales_accounts.trans_id');

		// order by name of item by default
		$this->db->order_by($sort, $order);

		if($rows > 0)
		{
			$this->db->limit($rows, $limit_from);
		}

		return $this->db->get();
	}
	
	public function get_supplier_found_rows($search, $filters)
	{
		return $this->search_supplier($search, $filters, 0, 0, 'trans_id', 'asc', TRUE);
	}
	
	public function search_supplier($search, $filters, $rows = 0, $limit_from = 0, $sort = 'receivings_accounts.trans_id', $order = 'asc', $count_only = FALSE)
	{
		// get_found_rows case
		if($count_only == TRUE)
		{
			$this->db->select('COUNT(DISTINCT receivings_accounts.trans_id) AS count');
		}
		else
		{
			$this->db->select('receivings_accounts.trans_id AS trans_id');
			$this->db->select('MAX(receivings_accounts.thedate) AS thedate');
			$this->db->select('MAX(receivings_accounts.description) AS description');
			$this->db->select('MAX(receivings_accounts.credit_amount) AS credit_amount');
			$this->db->select('MAX(receivings_accounts.debit_amount) AS debit_amount');
			$this->db->select('MAX(receivings_accounts.notes) AS notes');

			$this->db->select('MAX(employees.first_name) AS first_name');
			$this->db->select('MAX(employees.last_name) AS last_name');
		}

		$this->db->from('receivings_accounts AS receivings_accounts');
        $this->db->join('people AS employees', 'employees.person_id = receivings_accounts.employee_id', 'LEFT'); 
		
			$this->db->group_start();
			$this->db->or_like('receivings_accounts.thedate', $search);
			$this->db->or_like('receivings_accounts.description', $search);
			$this->db->or_like('receivings_accounts.credit_amount', $search);
			$this->db->or_like('receivings_accounts.debit_amount', $search);
			$this->db->or_like('CONCAT(employees.first_name, " ", employees.last_name)', $search);
		$this->db->group_end();


		if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE_FORMAT(receivings_accounts.thedate, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
		}
		else
		{
			$this->db->where('receivings_accounts.thedate BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
		}
		if($filters['account'] != FALSE)
		{
			$this->db->like('receivings_accounts.account_id', $filters['account']);
		}
		

		if($count_only == TRUE)
		{
			return $this->db->get()->row()->count;
		}

		// avoid duplicated entries with same name because of inventory reporting multiple changes on the same item in the same date range
		$this->db->group_by('receivings_accounts.trans_id');

		// order by name of item by default
		$this->db->order_by($sort, $order);

		if($rows > 0)
		{
			$this->db->limit($rows, $limit_from);
		}

		return $this->db->get();
	}

	public function get_customer_balance($customer_id)
	{
		$this->db->from('sales_accounts');
		$this->db->select('sum(credit_amount) as credit_amount, sum(debit_amount) as debit_amount');
		$this->db->where('sales_accounts.account_id', $customer_id);
		
		$query = $this->db->get();
		
        foreach ($query->result() as $row)
        {
            $credit_amount = $row->credit_amount;
            $debit_amount = $row->debit_amount;
        }
        $balance = bcsub($debit_amount, $credit_amount);
		return $balance;
	}
	
	public function get_customer_opening_balance($customer_id, $start_date)
	{
		$this->db->from('sales_accounts');
		$this->db->select('sum(credit_amount) as credit_amount, sum(debit_amount) as debit_amount');
		$this->db->where('sales_accounts.account_id', $customer_id);
		
		//$start_date .=  date('Y-m-d H:i:s', strtotime(rawurldecode($start_date)));

        if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE(thedate) BETWEEN ' . $this->db->escape('2010-01-01 00:00:00') . ' AND ' . $this->db->escape($start_date));
		}
		else
		{
			$this->db->where('thedate BETWEEN ' . $this->db->escape(rawurldecode('2010-01-01 00:00:00')) . ' AND ' . $this->db->escape(rawurldecode($start_date)));
		}
		
		$query = $this->db->get();
		
        foreach ($query->result() as $row)
        {
            $credit_amount = $row->credit_amount;
            $debit_amount = $row->debit_amount;
        }
        $balance = bcsub($debit_amount, $credit_amount);
		return $balance;
	}
	
	public function get_supplier_opening_balance($supplier_id, $start_date)
	{
		$this->db->from('receivings_accounts');
		$this->db->select('sum(credit_amount) as credit_amount, sum(debit_amount) as debit_amount');
		$this->db->where('receivings_accounts.account_id', $supplier_id);
		
		if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE(thedate) BETWEEN ' . $this->db->escape('2010-01-01 00:00:00') . ' AND ' . $this->db->escape($start_date));
		}
		else
		{
			$this->db->where('thedate BETWEEN ' . $this->db->escape(rawurldecode('2010-01-01 00:00:00')) . ' AND ' . $this->db->escape(rawurldecode($start_date)));
		}

		$query = $this->db->get();
		
        foreach ($query->result() as $row)
        {
            $credit_amount = $row->credit_amount;
            $debit_amount = $row->debit_amount;
        }
        $balance = bcsub($debit_amount, $credit_amount);
		return $balance;	
	}
	
	public function get_supplier_balance($supplier_id)
	{
		$this->db->from('receivings_accounts');
		$this->db->select('sum(credit_amount) as credit_amount, sum(debit_amount) as debit_amount');
		$this->db->where('receivings_accounts.account_id', $supplier_id);

		$query = $this->db->get();
		
        foreach ($query->result() as $row)
        {
            $credit_amount = $row->credit_amount;
            $debit_amount = $row->debit_amount;
        }
        $balance = bcsub($debit_amount, $credit_amount);
		return $balance;	
	}
		
		/*
	Inserts or updates an expense
	*/
	public function save(&$account_data, $payment_data, $mode, $account_id = FALSE)
	{
		if ($mode == 0)
		{
			$desc_mode= "CPAY";
			if($this->db->insert('sales_accounts', $account_data))
			{
				$ids = $this->db->insert_id();
				$account_data['ins_id'] = $ids;
				$payment_data['description'] =  $desc_mode.' '.$ids;
				if($this->db->insert('accounts', $payment_data))
				{
         			return TRUE;
		        }
			return TRUE;
			}
		return FALSE;
		}
		elseif ($mode == 1)
		{
			$desc_mode= "SPAY";
			if($this->db->insert('receivings_accounts', $account_data))
			{
				$ids = $this->db->insert_id();
				$account_data['ins_id'] = $ids;
				$payment_data['description'] =  $desc_mode.' '.$ids;
				if($this->db->insert('accounts', $payment_data))
				{
         			return TRUE;
		        }
			return TRUE;
			}
		return FALSE;
		}
	}
	
	public function get_found_cashflow_rows($search, $filters)
	{
		return $this->search_cashflow($search, $filters, 0, 0, 'tid', 'asc', TRUE);
	}
	
	public function search_cashflow($search, $filters, $rows = 0, $limit_from = 0, $sort = 'sales_accounts.trans_id', $order = 'asc', $count_only = FALSE)
	{
		// get_found_rows case
		if($count_only == TRUE)
		{
			$this->db->select('COUNT(DISTINCT accounts.tid) AS count');
		}
		else
		{
			$this->db->select('accounts.tid AS trans_id');
			$this->db->select('MAX(accounts.thedate) AS thedate');
			$this->db->select('MAX(accounts.description) AS description');
			$this->db->select('MAX(accounts.employee_id) AS employee_id');
			$this->db->select('MAX(accounts.accounts) AS accounts');
			$this->db->select('MAX(accounts.type) AS type');
			$this->db->select('MAX(accounts.location_id) AS location_id');
			$this->db->select('MAX(accounts.credit_amount) AS credit_amount');
			$this->db->select('MAX(accounts.debit_amount) AS debit_amount');

			$this->db->select('MAX(employees.first_name) AS first_name');
			$this->db->select('MAX(employees.last_name) AS last_name');
			$this->db->select('MAX(party.last_name) AS party_last_name');
			$this->db->select('MAX(party.first_name) AS party_first_name');
		}

		$this->db->from('accounts AS accounts');
        $this->db->join('people AS employees', 'employees.person_id = accounts.employee_id', 'LEFT'); 
        $this->db->join('people AS party', 'party.person_id = accounts.accounts', 'LEFT'); 
	    
		$this->db->where('accounts.deleted', '0');
		
		$this->db->group_start();
			$this->db->or_like('accounts.thedate', $search);
			$this->db->or_like('accounts.description', $search);
			$this->db->or_like('accounts.credit_amount', $search);
			$this->db->or_like('accounts.debit_amount', $search);
			$this->db->or_like('accounts.accounts', $search);
			$this->db->or_like('CONCAT(employees.first_name, " ", employees.last_name)', $search);
		$this->db->group_end();


		if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE_FORMAT(accounts.thedate, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
		}
		else
		{
			$this->db->where('accounts.thedate BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
		}
		if($filters['account'] != FALSE)
		{
			//$this->db->like('accounts.account_id', $filters['account']);
		}
		
        $this->db->where('accounts.type', 'Transfer');
		
		if($count_only == TRUE)
		{
			return $this->db->get()->row()->count;
		}

		// avoid duplicated entries with same name because of inventory reporting multiple changes on the same item in the same date range
		$this->db->group_by('accounts.tid');

		// order by name of item by default
		$this->db->order_by($sort, $order);

		if($rows > 0)
		{
			$this->db->limit($rows, $limit_from);
		}

		return $this->db->get();
	}
	
	public function insert_stock_adj($item_account_data)
	{
		return $this->db->insert('accounts', $item_account_data);
	}
	
	public function save_cashflow(&$transfer_from, $transfer_to)
	{
		if($this->db->insert('accounts', $transfer_from))
		{
			if($this->db->insert('accounts', $transfer_to))
			{
         		return TRUE;
		    }
			return TRUE;
		}
		return FALSE;
	}
		
	public function get_customer_info($trans_id)
	{
		$this->db->select('
			sales_accounts.thedate AS thedate,
			sales_accounts.description AS description,
			sales_accounts.trans_id AS trans_id,
			sales_accounts.notes AS notes,
			sales_accounts.credit_amount AS amount,
			sales_accounts.employee_id AS employee_id,
			employees.first_name AS first_name,
			employees.last_name AS last_name,
			account.first_name AS accounts_first_name,
			account.last_name AS accounts_last_name
		');
		$this->db->from('sales_accounts AS sales_accounts');
		$this->db->join('people AS employees', 'employees.person_id = sales_accounts.employee_id', 'LEFT');
		$this->db->join('people AS account', 'account.person_id = sales_accounts.account_id', 'LEFT');
		$this->db->where('trans_id', $trans_id);

		$query = $this->db->get();
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object
			$accounts_obj = new stdClass();

			//Get all the fields from accounts table
			foreach($this->db->list_fields('sales_accounts') as $field)
			{
				$accounts_obj->$field = '';
			}

			return $accounts_obj;
		}
	}
	
    public function get_receivings_info($trans_id)
	{
		$this->db->select('
			receivings_accounts.trans_id AS trans_id,
			receivings_accounts.notes AS notes,
			receivings_accounts.debit_amount AS amount,
			receivings_accounts.employee_id AS employee_id,
			employees.first_name AS first_name,
			employees.last_name AS last_name,
			account.first_name AS accounts_first_name,
			account.last_name AS accounts_last_name
		');
		$this->db->from('receivings_accounts AS receivings_accounts');
		$this->db->join('people AS employees', 'employees.person_id = receivings_accounts.employee_id', 'LEFT');
		$this->db->join('people AS account', 'account.person_id = receivings_accounts.account_id', 'LEFT');
		$this->db->where('trans_id', $trans_id);

		$query = $this->db->get();
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object
			$accounts_obj = new stdClass();

			//Get all the fields from accounts table
			foreach($this->db->list_fields('sales_accounts') as $field)
			{
				$accounts_obj->$field = '';
			}

			return $accounts_obj;
		}
	}
	
	public function get_cashflow_info($trans_id )
	{
		$this->db->select('
			accounts.thedate AS thedate,
			accounts.description AS description,
			accounts.tid AS trans_id,
			accounts.credit_amount AS credit_amount,
			accounts.debit_amount AS debit_amount,
			accounts.employee_id AS employee_id,
			employees.first_name AS first_name,
			employees.last_name AS last_name,
			account.first_name AS accounts_first_name,
			account.last_name AS accounts_last_name
		');
		$this->db->from('accounts AS accounts');
		$this->db->join('people AS employees', 'employees.person_id = accounts.employee_id', 'LEFT');
		$this->db->join('people AS account', 'account.person_id = accounts.accounts', 'LEFT');
		$this->db->where('tid', $trans_id);
		
		$this->db->where('accounts.deleted', '0');

		$query = $this->db->get();
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object
			$accounts_obj = new stdClass();

			//Get all the fields from accounts table
			foreach($this->db->list_fields('accounts') as $field)
			{
				$accounts_obj->$field = '';
			}

			return $accounts_obj;
		}
	}
	
	public function update_account($account_data, $trans_data, $receipt_data, $mode, $trans_id)
	{
		if($mode == '0')
		{
			$this->db->where('description', 'CPAY '.$trans_id);
			if($this->db->update('accounts', $account_data))
			{
				$this->db->where('trans_id', $trans_id);
			    if($this->db->update('sales_accounts', $trans_data))
				{
					$this->db->insert('accounts_history', $receipt_data);
				}
				return TRUE;
			}
			else
			{
				return FALSE;
			}
			
		}
		elseif($mode == '1')
		{
			$this->db->where('description', 'SPAY '.$trans_id);
			if($this->db->update('accounts', $account_data))
			{
				$this->db->where('trans_id', $trans_id);
			    if($this->db->update('receivings_accounts', $trans_data))
				{
					$this->db->insert('accounts_history', $receipt_data);
				}
				return TRUE;
			}
			else
			{
				return FALSE;
			}
			
		}
		else
		{
			return FALSE;
		}
	}
	
	public function update_transfer_fund($transfer, $trans_id)
	{
		$this->db->where('tid', $trans_id);
		if($this->db->update('accounts', $transfer))
		{
			return TRUE;
		}
	    else
		{
			return FALSE;
		}
	}
	
	public function get_history_data_for_item($item_id, $mode = FALSE)
	{
		$this->db->from('accounts_history');
		if ($mode == '0')
		{
			$this->db->where('description', 'CPAY '.$item_id);
		}
		elseif ($mode == '1')
		{
			$this->db->where('description', 'SPAY '.$item_id);
		}
		
		$this->db->order_by('thedate', 'desc');

		return $this->db->get();
	}
	
	public function get_found_chart_rows($search)
	{
		return $this->search_chart($search, 0, 0, 'tid', 'asc', TRUE);
	}
	
	public function search_chart($search, $rows = 0, $limit_from = 0, $sort = 'chart_of_accounts.trans_id', $order = 'asc', $count_only = FALSE)
	{
		// get_found_rows case
		if($count_only == TRUE)
		{
			$this->db->select('COUNT(DISTINCT chart_of_accounts.tid) AS count');
		}
		else
		{
			$this->db->select('chart_of_accounts.tid AS trans_id');
			$this->db->select('MAX(chart_of_accounts.name) AS name');
			$this->db->select('MAX(chart_of_accounts.nature) AS nature');
			$this->db->select('MAX(chart_of_accounts.description) AS description');
			$this->db->select('MAX(chart_of_accounts.type) AS type');
		}

		$this->db->from('chart_of_accounts AS chart_of_accounts');
		
		$this->db->group_start();
			$this->db->or_like('chart_of_accounts.name', $search);
			$this->db->or_like('chart_of_accounts.nature', $search);
			$this->db->or_like('chart_of_accounts.description', $search);
			$this->db->or_like('chart_of_accounts.type', $search);
		$this->db->group_end();
		
		if($count_only == TRUE)
		{
			return $this->db->get()->row()->count;
		}
		
        $this->db->group_by('chart_of_accounts.tid');
		
		$this->db->order_by($sort, $order);

		if($rows > 0)
		{
			$this->db->limit($rows, $limit_from);
		}

		return $this->db->get();
	}
	
	public function head_info($trans_id)
	{
		$this->db->select('
			chart_of_accounts.tid AS trans_id,
			chart_of_accounts.name AS name,
			chart_of_accounts.nature AS nature,
			chart_of_accounts.description AS description,
			chart_of_accounts.type AS type
		');
		$this->db->from('chart_of_accounts AS chart_of_accounts');

		$this->db->where('tid', $trans_id);

		$query = $this->db->get();
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object
			$chart_of_accounts_obj = new stdClass();

			//Get all the fields from expenses table
			foreach($this->db->list_fields('chart_of_accounts') as $field)
			{
				$chart_of_accounts_obj->$field = '';
			}

			return $chart_of_accounts_obj;
		}
	}
	
	/*
	Inserts or updates an head
	*/
	public function save_head(&$head_data, $trans_id = FALSE)
	{
		if(!$trans_id || !$this->head_exists($trans_id))
		{
			if($this->db->insert('chart_of_accounts', $head_data))
			{
				$ids = $this->db->insert_id();
				$head_data['trans_id'] = $ids;

				return TRUE;
			}

			return FALSE;
		}
		
		$this->db->where('tid', $trans_id);
		return $this->db->update('chart_of_accounts', $head_data);
	}
	
	/*
	Determines if a given Expense_id is an Expense
	*/
	public function head_exists($trans_id)
	{
		$this->db->from('chart_of_accounts');
		$this->db->where('tid', $trans_id);

		return ($this->db->get()->num_rows() == 1);
	}
	
	public function head_natures($id)
	{
		if($id == '0')
		{
			return $this->lang->line('account_nature_income');
		}
		elseif($id == '1')
		{
			return $this->lang->line('account_nature_expense');
		}
		elseif($id == '2')
		{
			return $this->lang->line('account_nature_assets');
		}
		elseif($id == '3')
		{
			return $this->lang->line('account_nature_libility');
		}
		elseif($id == '4')
		{
			return $this->lang->line('account_nature_equity');
		}
		else
		{
			return $this->lang->line('account_unknown');
		}	
	}
	
	public function head_types($id)
	{
		if($id == '0')
		{
			return $this->lang->line('account_type_current');
		}
		elseif($id == '1')
		{
			return $this->lang->line('account_type_non_current');
		}
		else
		{
			return $this->lang->line('account_unknown');
		}	
	}
}
?>
