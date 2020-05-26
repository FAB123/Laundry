<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Receiving class
 */

class Receiving extends CI_Model
{
	public function get_info($receiving_id)
	{
		$this->db->from('receivings');
		$this->db->join('people', 'people.person_id = receivings.supplier_id', 'LEFT');
		$this->db->join('suppliers', 'suppliers.person_id = receivings.supplier_id', 'LEFT');
		$this->db->where('receiving_id', $receiving_id);

		return $this->db->get();
	}

	public function get_receiving_by_reference($reference)
	{
		$this->db->from('receivings');
		$this->db->where('reference', $reference);

		return $this->db->get();
	}

	public function is_valid_receipt($receipt_receiving_id)
	{
		if(!empty($receipt_receiving_id))
		{
			//RECV #
			$pieces = explode(' ', $receipt_receiving_id);

			if(count($pieces) == 2 && preg_match('/(RECV|KIT)/', $pieces[0]))
			{
				return $this->exists($pieces[1]);
			}
			else
			{
				return $this->get_receiving_by_reference($receipt_receiving_id)->num_rows() > 0;
			}
		}

		return FALSE;
	}

	public function exists($receiving_id)
	{
		$this->db->from('receivings');
		$this->db->where('receiving_id', $receiving_id);

		return ($this->db->get()->num_rows() == 1);
	}

	public function update($receiving_data, $receiving_id)
	{
		$this->db->where('receiving_id', $receiving_id);

		return $this->db->update('receivings', $receiving_data);
	}

	public function save($items, $supplier_id, $employee_id, $receivings_type, $comment, $taxes, $reference, $payment_type, $mode, $location_id, $receiving_id = FALSE)
	{
		$tax_decimals = tax_decimals();
		
		if(count($items) == 0)
		{
			return -1;
		}

		$receivings_data = array(
			'receiving_time' => date('Y-m-d H:i:s'),
			'supplier_id' => $this->Supplier->exists($supplier_id) ? $supplier_id : NULL,
			'employee_id' => $employee_id,
			'payment_type' => $payment_type,
			'comment' => $comment,
			'reference' => $reference,
			'receivings_type' => $receivings_type
		);

		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();

		$this->db->insert('receivings', $receivings_data);
		$receiving_id = $this->db->insert_id();
				
		$sales_taxes = array();

		foreach($items as $line=>$item)
		{
			$cur_item_info = $this->Item->get_info($item['item_id']);

			$receivings_items_data = array(
				'receiving_id' => $receiving_id,
				'item_id' => $item['item_id'],
				'line' => $item['line'],
				'description' => $item['description'],
				'serialnumber' => $item['serialnumber'],
				'quantity_purchased' => $item['quantity'],
				'receiving_quantity' => $item['receiving_quantity'],
				'discount' => $item['discount'],
				'discount_type' => $item['discount_type'],
				'item_cost_price' => $cur_item_info->cost_price,
				'item_unit_price' => $item['price'],
				'item_location' => $item['item_location']
			);

			$this->db->insert('receivings_items', $receivings_items_data);

			$items_received = $item['receiving_quantity'] != 0 ? $item['quantity'] * $item['receiving_quantity'] : $item['quantity'];

			// update cost price, if changed AND is set in config as wanted
			if($cur_item_info->cost_price != $item['price'] && $this->config->item('receiving_calculate_average_price') != FALSE)
			{
				$this->Item->change_cost_price($item['item_id'], $items_received, $item['price'], $cur_item_info->cost_price);
			}

			//Update stock quantity
			$item_quantity = $this->Item_quantity->get_item_quantity($item['item_id'], $item['item_location']);
			$this->Item_quantity->save(array('quantity' => $item_quantity->quantity + $items_received, 'item_id' => $item['item_id'],
											  'location_id' => $item['item_location']), $item['item_id'], $item['item_location']);

			$recv_remarks = 'RECV ' . $receiving_id;
			$inv_data = array(
				'trans_date' => date('Y-m-d H:i:s'),
				'trans_items' => $item['item_id'],
				'trans_user' => $employee_id,
				'trans_location' => $item['item_location'],
				'trans_comment' => $recv_remarks,
				'trans_inventory' => $items_received
			);

			$this->Inventory->insert($inv_data);

			$this->Attribute->copy_attribute_links($item['item_id'], 'receiving_id', $receiving_id);

			$supplier = $this->Supplier->get_info($supplier_id);
			
			// Calculate taxes and save the tax information for the sale.  Return the result for printing
		if($mode != 'requisition')
		{
			if($supplier_id == -1 || $supplier->taxable)
			{
				{
					$tax_type = Tax_lib::TAX_TYPE_SALES;
				}
				$rounding_code = Rounding_mode::HALF_UP; // half adjust
				$tax_group_sequence = 0;
				$item_total = $this->receiving_lib->get_item_total($item['quantity'], $item['price'], $item['discount'], $item['discount_type'], $item['receiving_quantity']);
				$tax_basis = $item_total;
				$item_tax_amount = 0;

				foreach($this->Item_taxes->get_info($item['item_id']) as $row)
				{
					$sales_items_taxes = array(
						'receiving_id'		=> $receiving_id,
						'item_id'			=> $item['item_id'],
						'line'				=> $item['line'],
						'name'				=> character_limiter($row['name'], 255),
						'percent'			=> $row['percent'],
						'tax_type'			=> $tax_type,
						'rounding_code'		=> $rounding_code,
						'cascade_tax'		=> 0,
						'cascade_sequence'	=> 0,
						'item_tax_amount'	=> 0
					);

					// This computes tax for each line item and adds it to the tax type total
					$tax_group = (float)$row['percent'] . '% ' . $row['name'];
					$tax_basis = $this->receiving_lib->get_item_total($item['quantity'], $item['price'], $item['discount'], $item['discount_type'], $item['receiving_quantity']);

					//if($this->config->item('tax_included'))
					{
						//$tax_type = Tax_lib::TAX_TYPE_VAT;
						//$item_tax_amount = $this->receiving_lib->get_item_tax($item['quantity'], $item['price'], $item['discount'], $item['discount_type'], $row['percent']);
					}
					if($this->config->item('customer_sales_tax_support') == '0')
					{
						$tax_type = Tax_lib::TAX_TYPE_SALES;
						$item_tax_amount = $this->tax_lib->get_sales_tax_for_amount($tax_basis, $row['percent'], '0', $tax_decimals);
					}
					else
					{
						$tax_type = Tax_lib::TAX_TYPE_SALES;
					}

					$sales_items_taxes['item_tax_amount'] = $item_tax_amount;
					if($item_tax_amount != 0)
					{
						$this->db->insert('receivings_items_taxes', $sales_items_taxes);
						$this->tax_lib->update_receiving_taxes($sales_taxes, $tax_type, $tax_group, $row['percent'], $tax_basis, $item_tax_amount, $tax_group_sequence, $rounding_code, $receiving_id,  $row['name'], '');
						$tax_group_sequence += 1;
					}

				}

				if($this->config->item('customer_sales_tax_support') == '1')
				{
					$this->save_receiving_item_tax($supplier, $receiving_id, $item, $item_total, $sales_taxes, $sequence, $cur_item_info->tax_category_id);
				}
			}
		}
		}

		if($supplier_id == -1 || $supplier->taxable)
		{
			$this->tax_lib->round_sales_taxes($sales_taxes);
			$this->save_receiving_tax($sales_taxes);
		}


		$this->db->trans_complete();
		
	if($mode != 'requisition')
	{
		
	//	if($supplier_id != -1)
	//	{
		$current_balance = $this->Account->get_supplier_balance($supplier_id);
		$total_amount = $this->receiving_lib->get_total();
		
			$receiving_payments_data = array(
			'receiving_id'		 => $receiving_id,
			'payment_type'	 => $payment_type,
			'payment_amount' => $total_amount
		);
		$this->db->insert('receivings_payments', $receiving_payments_data);
		
		$current_amount = bcadd($current_balance, $total_amount);
		
		$subtotal=$this->receiving_lib->calculate_subtotal();
		 
		$total_tax = $total_amount-$subtotal;
		
		
		if($supplier_id != -1)
	 	{
		
		if ($payment_type == $this->lang->line('sales_as_credit'))
        {
            $credit_amount = $total_amount;
			$debit_amount = '0';
        }
        else
        {
           $credit_amount = $total_amount;
		   $debit_amount = $total_amount;
        }
		//$credit_amount = round($credit_amount);
		$c_balance = bcsub($current_amount, $debit_amount);
		
	    $receivings_accounts_data = array
			(
			    'thedate'=> date('Y-m-d H:i:s'),
				'description'=>'RINV - RECV '.$receiving_id,
				'employee_id' => $employee_id,	
				'account_id' => $supplier_id,		
                'debit_amount'=> $debit_amount,
		        'credit_amount' => $credit_amount,
				'balance_amount'=> $c_balance
			);
		$this->db->insert('receivings_accounts',$receivings_accounts_data);
		}
		
		if ($payment_type != $this->lang->line('sales_as_credit'))
         {
            $expanse_data = array
			(
				'thedate'=> date('Y-m-d H:i:s'),
		        'type'=>'Purchase',	
				'employee_id' => $employee_id,	
		        'accounts' => $supplier_id,	
                'description'=>$recv_remarks,
				'tax'=> -$total_tax,
				'location_id'=> $location_id,
                'credit_amount'=> $total_amount,
		        );
		$this->db->insert('accounts',$expanse_data);
         }

		if ($total_tax == 0)
		{
			$taxed = 0;
		}
		else
		{
			$taxed = 1;
		}
		
    	 $tax_data = array
			(
				'thedate'=> date('Y-m-d H:i:s'),
		        'typ'=>'Purchase',	
				'employee_id' => $employee_id,	
		        'customer_id' => $supplier_id,	
                'description'=>$recv_remarks,
                'tax'=> $total_tax,
				'subtotal'=> $subtotal,
				//'total'=> $amount,
				'total'=> $total_amount,
				'taxed' => $taxed,
		        );
		$this->db->insert('total_tax',$tax_data);
		
	}

		if($this->db->trans_status() === FALSE)
		{
			return -1;
		}

		return $receiving_id;
	}

	
		public function save_receiving_item_tax(&$supplier, &$supplier_id, &$item, $tax_basis, &$sales_taxes, &$sequence, $tax_category_id)
	{
		// if customer sales tax is enabled then update  sales_items_taxes with the
		if($this->config->item('customer_sales_tax_support') == '1')
		{
			$register_mode = $this->config->item('default_register_mode');
			$tax_details = $this->tax_lib->apply_sales_tax($item, $customer->city, $customer->state, $customer->sales_tax_code, $register_mode, $sale_id, $sales_taxes);

			$receiving_items_taxes = array(
				'receiving_id'			=> $receiving_id,
				'item_id'			=> $item['item_id'],
				'line'				=> $item['line'],
				'name'				=> $tax_details['tax_name'],
				'percent'			=> $tax_details['tax_rate'],
				'tax_type'			=> Tax_lib::TAX_TYPE_SALES,
				'rounding_code'		=> $tax_details['rounding_code'],
				'cascade_tax'		=> 0,
				'cascade_sequence'	=> 0,
				'item_tax_amount'	=> $tax_details['item_tax_amount']
			);

			$this->db->insert('receivings_items_taxes', $receiving_items_taxes);
		}
	}

/**
	 * Saves Receiving tax
	 */

public function save_receiving_tax(&$receiving_taxes)
	{
		foreach($receiving_taxes as $line=>$receiving_tax)
		{
			$this->db->insert('receivings_taxes', $receiving_tax);
		}
	}	
	

	public function delete_list($receiving_ids, $employee_id, $update_inventory = TRUE)
	{
		$success = TRUE;

		// start a transaction to assure data integrity
		$this->db->trans_start();

		foreach($receiving_ids as $receiving_id)
		{
			$success &= $this->delete($receiving_id, $employee_id, $update_inventory);
		}

		// execute transaction
		$this->db->trans_complete();

		$success &= $this->db->trans_status();

		return $success;
	}

	public function delete($receiving_id, $employee_id, $update_inventory = TRUE)
	{
		// start a transaction to assure data integrity
		$this->db->trans_start();

		if($update_inventory)
		{
			// defect, not all item deletions will be undone??
			// get array with all the items involved in the sale to update the inventory tracking
			$items = $this->get_receiving_items($receiving_id)->result_array();
			foreach($items as $item)
			{
				// create query to update inventory tracking
				$inv_data = array(
					'trans_date' => date('Y-m-d H:i:s'),
					'trans_items' => $item['item_id'],
					'trans_user' => $employee_id,
					'trans_comment' => 'Deleting receiving ' . $receiving_id,
					'trans_location' => $item['item_location'],
					'trans_inventory' => $item['quantity_purchased'] * -1
				);
				// update inventory
				$this->Inventory->insert($inv_data);

				// update quantities
				$this->Item_quantity->change_quantity($item['item_id'], $item['item_location'], $item['quantity_purchased'] * -1);
			}
		}

		// delete all items
		$this->db->delete('accounts', array('description' => 'RECV '.$receiving_id));
		
		$this->db->delete('total_tax', array('description' => 'RECV '.$receiving_id));
		
		$this->db->delete('receivings_accounts', array('description' => 'RINV - RECV '.$receiving_id));
		
		$this->db->delete('receivings_payments', array('receiving_id' => $receiving_id));
		
		$this->db->delete('receivings_items_taxes', array('receiving_id' => $receiving_id));
		
		$this->db->delete('receivings_taxes', array('receiving_id' => $receiving_id));
		
		$this->db->delete('receivings_items', array('receiving_id' => $receiving_id));
		// delete sale itself
		$this->db->delete('receivings', array('receiving_id' => $receiving_id));

		// execute transaction
		$this->db->trans_complete();
	
		return $this->db->trans_status();
	}

	public function get_receiving_items($receiving_id)
	{
		$this->db->from('receivings_items');
		$this->db->where('receiving_id', $receiving_id);

		return $this->db->get();
	}
	
	public function get_supplier($receiving_id)
	{
		$this->db->from('receivings');
		$this->db->where('receiving_id', $receiving_id);

		return $this->Supplier->get_info($this->db->get()->row()->supplier_id);
	}

	public function get_payment_options($enable_credit = FALSE)
	{
		if($enable_credit == TRUE)
		{
			return array(
			$this->lang->line('sales_cash') => $this->lang->line('sales_cash'),
			$this->lang->line('sales_check') => $this->lang->line('sales_check'),
			$this->lang->line('sales_debit') => $this->lang->line('sales_debit'),
			$this->lang->line('sales_credit') => $this->lang->line('sales_credit'),
			$this->lang->line('sales_as_credit') => $this->lang->line('sales_as_credit'),
			$this->lang->line('sales_due') => $this->lang->line('sales_due')
			);
		}
        else
		{
		return array(
			$this->lang->line('sales_cash') => $this->lang->line('sales_cash'),
			$this->lang->line('sales_check') => $this->lang->line('sales_check'),
			$this->lang->line('sales_debit') => $this->lang->line('sales_debit'),
			$this->lang->line('sales_credit') => $this->lang->line('sales_credit'),
			$this->lang->line('sales_due') => $this->lang->line('sales_due')
		);
		}
	}
	
    function count_all()
	{
		$this->db->from('receivings');
		return $this->db->count_all_results();
	}
	/*
	We create a temp table that allows us to do easy report/receiving queries
	*/
	public function create_temp_table(array $inputs)
	{
		if(empty($inputs['receiving_id']))
		{
			if(empty($this->config->item('date_or_time_format')))
			{
				$where = 'WHERE DATE(receiving_time) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']);
			}
			else
			{
				$where = 'WHERE receiving_time BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date']));
			}
		}
		else
		{
			$where = 'WHERE receivings_items.receiving_id = ' . $this->db->escape($inputs['receiving_id']);
		}
		$decimals = totals_decimals();
		$purchase_price = 'CASE WHEN receivings_items.discount_type = ' . PERCENT . ' THEN receivings_items.item_unit_price * receivings_items.quantity_purchased * receivings_items.receiving_quantity - receivings_items.item_unit_price * receivings_items.quantity_purchased * receivings_items.receiving_quantity * discount / 100 ELSE receivings_items.item_unit_price * receivings_items.quantity_purchased * receivings_items.receiving_quantity - receivings_items.discount END';
		$tax = 'IFNULL(SUM(receivings_items_taxes.tax), 0)';

		//if($this->config->item('tax_included'))
		{
			//$purchase_total = 'ROUND(SUM(' . $purchase_price . '), ' . $decimals . ')';
			//$purchase_subtotal = $purchase_total . ' - ' . $tax;
		}
		//else
		{
			$purchase_subtotal = 'ROUND(SUM(' . $purchase_price . '), ' . $decimals . ')';
			$purchase_total = $purchase_subtotal . ' + ' . $tax;
		}

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
				' . $where . '
				GROUP BY receiving_id, item_id, line
			)'
		);
		
		$this->db->query('CREATE TEMPORARY TABLE IF NOT EXISTS ' . $this->db->dbprefix('receivings_items_temp') .
			' (INDEX(receiving_date), INDEX(receiving_time), INDEX(receiving_id))
			(
				SELECT 
					MAX(DATE(receiving_time)) AS receiving_date,
					MAX(receiving_time) AS receiving_time,
					receivings_items.receiving_id,
					MAX(comment) AS comment,
					MAX(item_location) AS item_location,
					MAX(reference) AS reference,
					MAX(payment_type) AS payment_type,
					MAX(receivings_type) AS receivings_type,
					MAX(employee_id) AS employee_id, 
					items.item_id,
					MAX(receivings.supplier_id) AS supplier_id,
					MAX(quantity_purchased) AS quantity_purchased,
					MAX(receivings_items.receiving_quantity) AS receiving_quantity,
					MAX(item_cost_price) AS item_cost_price,
					MAX(item_unit_price) AS item_unit_price,
					MAX(discount) AS discount,
					discount_type as discount_type,
					receivings_items.line,
					MAX(serialnumber) AS serialnumber,
					MAX(receivings_items.description) AS description,
					' . "
					IFNULL($purchase_subtotal, $purchase_total) AS subtotal,
					$tax AS tax,
					IFNULL($purchase_total, $purchase_subtotal) AS total,
					" . '
					MAX((CASE WHEN receivings_items.discount_type = ' . PERCENT . ' THEN item_unit_price * quantity_purchased * receivings_items.receiving_quantity - item_unit_price * quantity_purchased * receivings_items.receiving_quantity * discount / 100 ELSE item_unit_price * quantity_purchased * receivings_items.receiving_quantity - discount END) - (item_cost_price * quantity_purchased)) AS profit,
					MAX(item_cost_price * quantity_purchased * receivings_items.receiving_quantity ) AS cost
				FROM ' . $this->db->dbprefix('receivings_items') . ' AS receivings_items
				INNER JOIN ' . $this->db->dbprefix('receivings') . ' AS receivings
					ON receivings_items.receiving_id = receivings.receiving_id
				INNER JOIN ' . $this->db->dbprefix('items') . ' AS items
					ON receivings_items.item_id = items.item_id
				LEFT OUTER JOIN ' . $this->db->dbprefix('receivings_items_taxes_temp') . ' AS receivings_items_taxes
					ON receivings_items.receiving_id = receivings_items_taxes.receiving_id AND receivings_items.item_id = receivings_items_taxes.item_id AND receivings_items.line = receivings_items_taxes.line
				' . "
				$where
				" . '
				GROUP BY receivings_items.receiving_id, items.item_id, receivings_items.line
			)'
		);
	}
	
	public function get_stock_mode($receiving_id)
	{
		$this->db->from('receivings');
		$this->db->where('receiving_id', $receiving_id);

		return $this->db->get()->row()->receivings_type;
	}
	
	public function get_cost_item_info($item_id)
	{
		$this->db->select('receivings_items.item_unit_price AS item_unit_price');
		$this->db->select('receivings_items.quantity_purchased AS quantity_purchased');
		$this->db->select('receivings.receiving_time AS receiving_time');
		$this->db->from('receivings_items AS receivings_items');
        $this->db->join('receivings AS receivings', 'receivings.receiving_id = receivings_items.receiving_id', 'LEFT'); 
		$this->db->like('receivings_items.item_id', $item_id);
		$this->db->order_by(receiving_time, "desc");
		$this->db->limit(10);
		return $this->db->get();
	}
	
					//MAX(CASE WHEN receivings_items.discount_type = ' . PERCENT . ' THEN item_unit_price * quantity_purchased * receivings_items.receiving_quantity - item_unit_price * quantity_purchased * receivings_items.receiving_quantity * discount / 100 ELSE item_unit_price * quantity_purchased * receivings_items.receiving_quantity - discount END) AS subtotal,
					//MAX(CASE WHEN receivings_items.discount_type = ' . PERCENT . ' THEN item_unit_price * quantity_purchased * receivings_items.receiving_quantity - item_unit_price * quantity_purchased * receivings_items.receiving_quantity * discount / 100 ELSE item_unit_price * quantity_purchased * receivings_items.receiving_quantity - discount END) AS total,
}
?>
