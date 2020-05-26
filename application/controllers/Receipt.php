<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Receipt extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct('receipt');

		$this->load->library('sale_lib');
	}
	
	public function receiptbt($sale_id = '-1', $key = '-1')
	{
		$core_api_key = $this->config->item('core_api_key');
		if($core_api_key == base64_decode($key))
		{
			$data = $this->load_sale_data($sale_id);
			
			if(empty($data['customer']))
			{
				$data['customer'] = "Walking Customer";
			}
			
			$response["company"] = array();

				$apps = array();
				$apps["api"] = "0";
				$apps["company_name"] = $this->config->item('company');
				$apps["company_name_ar"] = $this->config->item('company_ar');
				$apps["address"] = $this->config->item('address'); 
				$apps["address_ar"] = $this->config->item('address_ar');
				$apps["vat"] = $this->config->item('vat');
				$apps["phone"] = $this->config->item('phone');
				$apps["sale_id"] = $data['sale_id'];
				$apps["customer_name"] = $data['customer'];

				// push single product into final response array
				array_push($response["company"], $apps);
		   
			
			
			

			$response["cart"] = array();

			foreach($data['cart'] as $line=>$item)
			{
				$it_total = $item['discounted_total'];
			
				$x_tax = $item['taxed_rate'];;
				$n_tax = $item['quantity']*$x_tax;
			
				if($this->config->item('tax_included'))
				{
					$item_sub_total = $it_total-$n_tax;
					$item_total = $it_total;
				}
				else
				{
					$item_sub_total = $it_total;
					$item_total = $it_total+$n_tax;
				}

				$apps = array();
				
				$total_qty = $total_qty + $item['quantity'];
				$apps["item"] = $item['name'];
				$apps["quantity"] = ($item['quantity'] * 1);
				$apps["price"] = to_currency_no_money($item['price']); 
				$apps["sub_total"] = to_currency_no_money($item_sub_total);
				$apps["vat"] = to_currency_no_money($item['taxed_rate']*$item['quantity']);
				$apps["total"] = to_currency_no_money($item_total);
				

				// push single product into final response array
				array_push($response["cart"], $apps);
			}
			// success
			
			$response["bill"] = array();
			$apps = array();
			$apps["total"] = to_currency_no_money($data['total']);
			$apps["subtotal"] = to_currency_no_money($data['subtotal']);
			$apps["vat"] = to_currency_no_money($data['total'] - $data['subtotal']);
			array_push($response["bill"], $apps);
			
			$response["success"] = 1;

			echo json_encode($response);
		}
		else
		{
			$response["company"] = array();

			$apps = array();
			$apps["api"] = "1";
			$apps["error"] = "Error API Key";
			
			array_push($response["company"], $apps);
			echo json_encode($response);
		}
	}
	
	private function load_sale_data($sale_id)
	{
		$this->sale_lib->clear_all();
		$this->sale_lib->reset_cash_flags();
		$sale_info = $this->Sale->get_info($sale_id)->row_array();
		$this->sale_lib->copy_entire_sale($sale_id);
		$data = array();
		$data['cart'] = $this->sale_lib->get_cart();
		$data['payments'] = $this->sale_lib->get_payments();
		$data['selected_payment_type'] = $this->sale_lib->get_payment_type();

		$data['taxes'] = $this->sale_lib->get_taxes();
		$data['discount'] = $this->sale_lib->get_discount();
		$data['transaction_time'] = date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'), strtotime($sale_info['sale_time']));
		$data['transaction_date'] = date($this->config->item('dateformat'), strtotime($sale_info['sale_time']));
		$data['show_stock_locations'] = $this->Stock_location->show_locations('sales');


		// Returns 'subtotal', 'total', 'cash_total', 'payment_total', 'amount_due', 'cash_amount_due', 'payments_cover_total'
		$totals = $this->sale_lib->get_totals();
		$data['subtotal'] = $totals['subtotal'];
		$data['total'] = $totals['total'];
		$data['payments_total'] = $totals['payment_total'];
		$data['payments_cover_total'] = $totals['payments_cover_total'];
		$data['cash_rounding'] = $this->session->userdata('cash_rounding');
		$data['prediscount_subtotal'] = $totals['prediscount_subtotal'];
		$data['cash_total'] = $totals['cash_total'];
		$data['non_cash_total'] = $totals['total'];
		$data['cash_amount_due'] = $totals['cash_amount_due'];
		$data['non_cash_amount_due'] = $totals['amount_due'];

		if($this->session->userdata('cash_rounding'))
		{
			$data['total'] = $totals['cash_total'];
			$data['amount_due'] = $totals['cash_amount_due'];
		}
		else
		{
			$data['total'] = $totals['total'];
			$data['amount_due'] = $totals['amount_due'];
		}
		$data['amount_change'] = $data['amount_due'] * -1;

		$employee_info = $this->Employee->get_info($this->sale_lib->get_employee());
		$data['employee'] = $employee_info->first_name . ' ' . mb_substr($employee_info->last_name, 0, 1);
		$this->load_customer_data($this->sale_lib->get_customer(), $data);

		$data['sale_id_num'] = $sale_id;
		$data['sale_id'] = 'POS ' . $sale_id;
		$data['comments'] = $sale_info['comment'];
		$data['invoice_number'] = $sale_info['invoice_number'];
		$data['quote_number'] = $sale_info['quote_number'];
		$data['sale_status'] = $sale_info['sale_status'];
		$data['company_info'] = implode("\n", array(
			$this->config->item('address'),
			$this->config->item('phone'),
			$this->config->item('account_number')
		));

		if($this->sale_lib->get_mode() == 'sale_invoice')
		{
			$data['mode_label'] = $this->lang->line('sales_invoice');
			$data['customer_required'] = $this->lang->line('sales_customer_required');
		}
		elseif($this->sale_lib->get_mode() == 'sale_quote')
		{
			$data['mode_label'] = $this->lang->line('sales_quote');
			$data['customer_required'] = $this->lang->line('sales_customer_required');
		}
		elseif($this->sale_lib->get_mode() == 'sale_work_order')
		{
			$data['mode_label'] = $this->lang->line('sales_work_order');
			$data['customer_required'] = $this->lang->line('sales_customer_required');
		}
		elseif($this->sale_lib->get_mode() == 'return')
		{
			$data['mode_label'] = $this->lang->line('sales_return');
			$data['customer_required'] = $this->lang->line('sales_customer_optional');
		}
		else
		{
			$data['mode_label'] = $this->lang->line('sales_receipt');
			$data['customer_required'] = $this->lang->line('sales_customer_optional');
		}

		return $data;
		//echo $sale_info;
		//echo '<pre>'; print_r($data); echo '</pre>';
	}
	
	private function load_customer_data($customer_id, &$data, $stats = FALSE)
	{
		$customer_info = '';

		if($customer_id != -1)
		{
			$customer_info = $this->Customer->get_info($customer_id);
			$data['customer_account_balance'] = $this->Account->get_customer_balance($customer_id);
			$data['customer_id'] = $customer_id;
			if(!empty($customer_info->company_name))
			{
				$data['customer'] = $customer_info->company_name;
			}
			else
			{
				$data['customer'] = $customer_info->first_name . ' ' . $customer_info->last_name;
			}
			$data['first_name'] = $customer_info->first_name;
			$data['last_name'] = $customer_info->last_name;
			$data['customer_email'] = $customer_info->email;
			$data['customer_address'] = $customer_info->address_1;
			$data['customer_vatno'] = $customer_info->Vat_no;
			if(!empty($customer_info->zip) || !empty($customer_info->city))
			{
				$data['customer_location'] = $customer_info->zip . ' ' . $customer_info->city;
			}
			else
			{
				$data['customer_location'] = '';
			}
			$data['customer_account_number'] = $customer_info->account_number;
			$data['customer_discount'] = $customer_info->discount;
			$data['customer_discount_type'] = $customer_info->discount_type;
			$package_id = $this->Customer->get_info($customer_id)->package_id;
			if($package_id != NULL)
			{
				$package_name = $this->Customer_rewards->get_name($package_id);
				$points = $this->Customer->get_info($customer_id)->points;
				$data['customer_rewards']['package_id'] = $package_id;
				$data['customer_rewards']['points'] = empty($points) ? 0 : $points;
				$data['customer_rewards']['package_name'] = $package_name;
			}

			if($stats)
			{
				$cust_stats = $this->Customer->get_stats($customer_id);
				$data['customer_total'] = empty($cust_stats) ? 0 : $cust_stats->total;
			}

			$data['customer_info'] = implode("\n", array(
				$data['customer'],
				$data['customer_address'],
				$data['customer_location'],
				$data['customer_account_number']
			));
		}

		return $customer_info;
	}
}
?>
