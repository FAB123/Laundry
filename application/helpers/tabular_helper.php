<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Tabular views helper
 */

/*
Basic tabular headers function
*/
function transform_headers_readonly($array)
{
	$result = array();

	foreach($array as $key => $value)
	{
		$result[] = array('field' => $key, 'title' => $value, 'sortable' => $value != '', 'switchable' => !preg_match('(^$|&nbsp)', $value));
	}

	return json_encode($result);
}

/*
Basic tabular headers function
*/
function transform_headers($array, $readonly = FALSE, $editable = TRUE)
{
	$result = array();

	if(!$readonly)
	{
		$array = array_merge(array(array('checkbox' => 'select', 'sortable' => FALSE)), $array);
	}

	if($editable)
	{
		$array[] = array('edit' => '');
	}

	foreach($array as $element)
	{
		reset($element);
		$result[] = array('field' => key($element),
			'title' => current($element),
			'switchable' => isset($element['switchable']) ? $element['switchable'] : !preg_match('(^$|&nbsp)', current($element)),
			'sortable' => isset($element['sortable']) ? $element['sortable'] : current($element) != '',
			'checkbox' => isset($element['checkbox']) ? $element['checkbox'] : FALSE,
			'class' => isset($element['checkbox']) || preg_match('(^$|&nbsp)', current($element)) ? 'print_hide' : '',
			'sorter' => isset($element['sorter']) ? $element ['sorter'] : '');
	}

	return json_encode($result);
}


/*
Get the header for the sales tabular view
*/
function get_sales_manage_table_headers()
{
	$CI =& get_instance();

	$headers = array(
		array('sale_id' => $CI->lang->line('common_id')),
		array('sale_time' => $CI->lang->line('sales_sale_time')),
		array('customer_name' => $CI->lang->line('customers_customer')),
		array('amount_due' => $CI->lang->line('sales_amount_due')),
		array('amount_tendered' => $CI->lang->line('sales_amount_tendered')),
		array('change_due' => $CI->lang->line('sales_change_due')),
		array('payment_type' => $CI->lang->line('sales_payment_type'))
	);

	if($CI->config->item('invoice_enable') == TRUE)
	{
		$headers[] = array('invoice_number' => $CI->lang->line('sales_invoice_number'));
		$headers[] = array('invoice' => '&nbsp', 'sortable' => FALSE);
	}

	$headers[] = array('receipt' => '&nbsp', 'sortable' => FALSE);

	return transform_headers($headers);
}

/*
Get the html data row for the sales
*/
function get_sale_data_row($sale)
{
	$CI =& get_instance();
	$controller_name = $CI->uri->segment(1);

	$row = array (
		'sale_id' => $sale->sale_id,
		'sale_time' => date($CI->config->item('dateformat') . ' ' . $CI->config->item('timeformat'), strtotime($sale->sale_time)),
		'customer_name' => $sale->customer_name,
		'amount_due' => to_currency($sale->amount_due),
		'amount_tendered' => to_currency($sale->amount_tendered),
		'change_due' => to_currency($sale->change_due),
		'payment_type' => $sale->payment_type
	);

	if($CI->config->item('invoice_enable'))
	{
		$row['invoice_number'] = $sale->invoice_number;
		$row['invoice'] = empty($sale->invoice_number) ? '' : anchor($controller_name."/invoice/$sale->sale_id", '<span class="glyphicon glyphicon-list-alt"></span>',
			array('title'=>$CI->lang->line('sales_show_invoice'))
		);
	}

	$row['receipt'] = anchor($controller_name."/receipt/$sale->sale_id", '<span class="glyphicon glyphicon-usd"></span>',
		array('title' => $CI->lang->line('sales_show_receipt'))
	);
	$row['edit'] = anchor($controller_name."/edit/$sale->sale_id", '<span class="glyphicon glyphicon-edit"></span>',
		array('class' => 'modal-dlg print_hide', 'data-btn-delete' => $CI->lang->line('common_delete'), 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name.'_update'))
	);

	return $row;
}

/*
Get the html data last row for the sales
*/
function get_sale_data_last_row($sales)
{
	$CI =& get_instance();
	$sum_amount_due = 0;
	$sum_amount_tendered = 0;
	$sum_change_due = 0;

	foreach($sales->result() as $key=>$sale)
	{
		$sum_amount_due += $sale->amount_due;
		$sum_amount_tendered += $sale->amount_tendered;
		$sum_change_due += $sale->change_due;
	}

	return array(
		'sale_id' => '-',
		'sale_time' => '<b>'.$CI->lang->line('sales_total').'</b>',
		'amount_due' => '<b>'.to_currency($sum_amount_due).'</b>',
		'amount_tendered' => '<b>'. to_currency($sum_amount_tendered).'</b>',
		'change_due' => '<b>'.to_currency($sum_change_due).'</b>'
	);
}

/*
Get the sales payments summary
*/
function get_sales_manage_payments_summary($payments, $sales)
{
	$CI =& get_instance();
	$table = '<div id="report_summary">';

	foreach($payments as $key=>$payment)
	{
		$amount = $payment['payment_amount'];

		// WARNING: the strong assumption here is that if a change is due it was a cash transaction always
		// therefore we remove from the total cash amount any change due
		if( $payment['payment_type'] == $CI->lang->line('sales_cash') )
		{
			foreach($sales->result_array() as $key=>$sale)
			{
				$amount -= $sale['change_due'];
			}
		}
		$table .= '<div class="summary_row">' . $payment['payment_type'] . ': ' . to_currency($amount) . '</div>';
	}
	$table .= '</div>';

	return $table;
}


/*
Get the header for the people tabular view
*/
function get_people_manage_table_headers()
{
	$CI =& get_instance();

	$headers = array(
		array('people.person_id' => $CI->lang->line('common_id')),
		array('last_name' => $CI->lang->line('common_last_name')),
		array('first_name' => $CI->lang->line('common_first_name')),
		array('email' => $CI->lang->line('common_email')),
		array('phone_number' => $CI->lang->line('common_phone_number'))
	);

	if($CI->Employee->has_grant('messages', $CI->session->userdata('person_id')))
	{
		$headers[] = array('messages' => '', 'sortable' => FALSE);
	}

	return transform_headers($headers);
}

/*
Get the html data row for the person
*/
function get_person_data_row($person)
{
	$CI =& get_instance();
	$controller_name = strtolower(get_class($CI));

	return array (
		'people.person_id' => $person->person_id,
		'last_name' => $person->last_name,
		'first_name' => $person->first_name,
		'email' => empty($person->email) ? '' : mailto($person->email, $person->email),
		'phone_number' => $person->phone_number,
		'messages' => empty($person->phone_number) ? '' : anchor("Messages/view/$person->person_id", '<span class="glyphicon glyphicon-phone"></span>',
			array('class'=>'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line('messages_sms_send'))),
		'edit' => anchor($controller_name."/view/$person->person_id", '<span class="glyphicon glyphicon-edit"></span>',
			array('class'=>'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_update'))
	));
}


/*
Get the header for the customer tabular view
*/
function get_customer_manage_table_headers()
{
	$CI =& get_instance();

	$headers = array(
		array('people.person_id' => $CI->lang->line('common_id')),
		array('last_name' => $CI->lang->line('common_last_name')),
		array('first_name' => $CI->lang->line('common_first_name')),
		array('email' => $CI->lang->line('common_email')),
		array('phone_number' => $CI->lang->line('common_phone_number')),
		array('total' => $CI->lang->line('common_total_spent'), 'sortable' => FALSE)
	);

	if($CI->Employee->has_grant('messages', $CI->session->userdata('person_id')))
	{
		$headers[] = array('messages' => '', 'sortable' => FALSE);
	}

	return transform_headers($headers);
}

/*
Get the html data row for the customer
*/
function get_customer_data_row($person, $stats)
{
	$CI =& get_instance();
	$controller_name = strtolower(get_class($CI));

	return array (
		'people.person_id' => $person->person_id,
		'last_name' => $person->last_name,
		'first_name' => $person->first_name,
		'email' => empty($person->email) ? '' : mailto($person->email, $person->email),
		'phone_number' => $person->phone_number,
		'total' => to_currency($stats->total),
		'messages' => empty($person->phone_number) ? '' : anchor("Messages/view/$person->person_id", '<span class="glyphicon glyphicon-phone"></span>',
			array('class'=>'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line('messages_sms_send'))),
		'edit' => anchor($controller_name."/view/$person->person_id", '<span class="glyphicon glyphicon-edit"></span>',
			array('class'=>'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_update'))
	));
}


/*
Get the header for the suppliers tabular view
*/
function get_suppliers_manage_table_headers()
{
	$CI =& get_instance();

	$headers = array(
		array('people.person_id' => $CI->lang->line('common_id')),
		array('company_name' => $CI->lang->line('suppliers_company_name')),
		array('agency_name' => $CI->lang->line('suppliers_agency_name')),
		array('category' => $CI->lang->line('suppliers_category')),
		array('last_name' => $CI->lang->line('common_last_name')),
		array('first_name' => $CI->lang->line('common_first_name')),
		array('email' => $CI->lang->line('common_email')),
		array('phone_number' => $CI->lang->line('common_phone_number'))
	);

	if($CI->Employee->has_grant('messages', $CI->session->userdata('person_id')))
	{
		$headers[] = array('messages' => '');
	}

	return transform_headers($headers);
}

/*
Get the html data row for the supplier
*/
function get_supplier_data_row($supplier)
{
	$CI =& get_instance();
	$controller_name = strtolower(get_class($CI));

	return array (
		'people.person_id' => $supplier->person_id,
		'company_name' => $supplier->company_name,
		'agency_name' => $supplier->agency_name,
		'category' => $supplier->category,
		'last_name' => $supplier->last_name,
		'first_name' => $supplier->first_name,
		'email' => empty($supplier->email) ? '' : mailto($supplier->email, $supplier->email),
		'phone_number' => $supplier->phone_number,
		'messages' => empty($supplier->phone_number) ? '' : anchor("Messages/view/$supplier->person_id", '<span class="glyphicon glyphicon-phone"></span>',
			array('class'=>"modal-dlg", 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line('messages_sms_send'))),
		'edit' => anchor($controller_name."/view/$supplier->person_id", '<span class="glyphicon glyphicon-edit"></span>',
			array('class'=>"modal-dlg", 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_update')))
		);
}


/*
Get the header for the items tabular view
*/
function get_items_manage_table_headers()
{
	$CI =& get_instance();

	$definition_names = $CI->Attribute->get_definitions_by_flags(Attribute::SHOW_IN_ITEMS);

	$headers = array(
		array('items.item_id' => $CI->lang->line('common_id')),
		array('item_number' => $CI->lang->line('items_item_number')),
		array('name' => $CI->lang->line('items_name')),
		array('category' => $CI->lang->line('items_category')),
		array('company_name' => $CI->lang->line('suppliers_company_name')),
		array('cost_price' => $CI->lang->line('items_cost_price')),
		array('minimum_price' => $CI->lang->line('items_minimum_price')),
		array('unit_price' => $CI->lang->line('items_unit_price')),
		array('quantity' => $CI->lang->line('items_quantity')),
		array('tax_percents' => $CI->lang->line('items_tax_percents'), 'sortable' => FALSE),
		array('item_pic' => $CI->lang->line('items_image'), 'sortable' => FALSE)
	);

	foreach($definition_names as $definition_id => $definition_name)
	{
		$headers[] = array($definition_id => $definition_name);
	}

	$headers[] = array('damages' => '');
	$headers[] = array('inventory' => '');
	$headers[] = array('stock' => '');

	return transform_headers($headers);
}

/*
Get the html data row for the item
*/
function get_item_data_row($item)
{
	$CI =& get_instance();
	$item_tax_info = $CI->Item_taxes->get_info($item->item_id);
	$tax_percents = '';
	foreach($item_tax_info as $tax_info)
	{
		$tax_percents .= to_tax_decimals($tax_info['percent']) . '%, ';
	}
	// remove ', ' from last item
	$tax_percents = substr($tax_percents, 0, -2);
	$controller_name = strtolower(get_class($CI));

	$image = NULL;
	if($item->pic_filename != '')
	{
		$ext = pathinfo($item->pic_filename, PATHINFO_EXTENSION);
		if($ext == '')
		{
			// legacy
			$images = glob('./uploads/item_pics/' . $item->pic_filename . '.*');
		}
		else
		{
			// preferred
			$images = glob('./uploads/item_pics/' . $item->pic_filename);
		}

		if(sizeof($images) > 0)
		{
			$image .= '<a class="rollover" href="'. base_url($images[0]) .'"><img src="'.site_url('items/pic_thumb/' . pathinfo($images[0], PATHINFO_BASENAME)) . '"></a>';
		}
	}

	if ($CI->config->item('multi_pack_enabled') == '1')
	{
		$item->name .= NAME_SEPARATOR . $item->pack_name;
	}

	$definition_names = $CI->Attribute->get_definitions_by_flags(Attribute::SHOW_IN_ITEMS);

	$columns = array (
		'items.item_id' => $item->item_id,
		'item_number' => $item->item_number,
		'name' => $item->name,
		'category' => $item->category,
		'company_name' => $item->company_name,
		'cost_price' => to_currency($item->cost_price),
		'minimum_price' => to_currency($item->minimum_price),
		'unit_price' => to_currency($item->unit_price),
		'quantity' => to_quantity_decimals($item->quantity)  .' '.$item->unit_type,
		'tax_percents' => !$tax_percents ? '-' : $tax_percents,
		'item_pic' => $image
	);

	$icons = array(
		'damages' => anchor($controller_name."/damages_warranty/$item->item_id", '<span class="glyphicon glyphicon-trash"></span>',
			array('class' => 'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name.'_damages_and_warranty'))
		),
		'inventory' => anchor($controller_name."/inventory/$item->item_id", '<span class="glyphicon glyphicon-pushpin"></span>',
			array('class' => 'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name.'_count'))
		),
		'stock' => anchor($controller_name."/count_details/$item->item_id", '<span class="glyphicon glyphicon-list-alt"></span>',
			array('class' => 'modal-dlg', 'title' => $CI->lang->line($controller_name.'_details_count'))
		),
		'edit' => anchor($controller_name."/view/$item->item_id", '<span class="glyphicon glyphicon-edit"></span>',
			array('class' => 'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name.'_update'))
		)
	);

	$attribute_values = (property_exists($item, 'attribute_values')) ? $item->attribute_values : "";
	return $columns + expand_attribute_values($definition_names, $attribute_values) + $icons;
}


/*
Get the header for the giftcard tabular view
*/
function get_giftcards_manage_table_headers()
{
	$CI =& get_instance();

	$headers = array(
		array('giftcard_id' => $CI->lang->line('common_id')),
		array('last_name' => $CI->lang->line('common_last_name')),
		array('first_name' => $CI->lang->line('common_first_name')),
		array('giftcard_number' => $CI->lang->line('giftcards_giftcard_number')),
		array('value' => $CI->lang->line('giftcards_card_value'))
	);

	return transform_headers($headers);
}

/*
Get the html data row for the giftcard
*/
function get_giftcard_data_row($giftcard)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));

	return array (
		'giftcard_id' => $giftcard->giftcard_id,
		'last_name' => $giftcard->last_name,
		'first_name' => $giftcard->first_name,
		'giftcard_number' => $giftcard->giftcard_number,
		'value' => to_currency($giftcard->value),
		'edit' => anchor($controller_name."/view/$giftcard->giftcard_id", '<span class="glyphicon glyphicon-edit"></span>',
			array('class'=>'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_update'))
		));
}


/*
Get the header for the taxes tabular view
*/
function get_taxes_manage_table_headers()
{
	$CI =& get_instance();

	$headers = array(
		array('tax_code' => $CI->lang->line('taxes_tax_code')),
		array('tax_code_name' => $CI->lang->line('taxes_tax_code_name')),
		array('tax_code_type_name' => $CI->lang->line('taxes_tax_code_type')),
		array('tax_rate' => $CI->lang->line('taxes_tax_rate')),
		array('rounding_code_name' => $CI->lang->line('taxes_rounding_code')),
		array('city' => $CI->lang->line('common_city')),
		array('state' => $CI->lang->line('common_state'))
	);

	return transform_headers($headers);
}

/*
Get the html data row for the tax
*/
function get_tax_data_row($tax_code_row)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));

	return array (
		'tax_code' => $tax_code_row->tax_code,
		'tax_code_name' => $tax_code_row->tax_code_name,
		'tax_code_type' => $tax_code_row->tax_code_type,
		'tax_rate' => $tax_code_row->tax_rate,
		'rounding_code' =>$tax_code_row->rounding_code,
		'tax_code_type_name' => $CI->Tax->get_tax_code_type_name($tax_code_row->tax_code_type),
		'rounding_code_name' => Rounding_mode::get_rounding_code_name($tax_code_row->rounding_code),
		'city' => $tax_code_row->city,
		'state' => $tax_code_row->state,
		'edit' => anchor($controller_name."/view/$tax_code_row->tax_code", '<span class="glyphicon glyphicon-edit"></span>',
			array('class'=>'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_update'))
		));
}


/*
Get the header for the item kits tabular view
*/
function get_item_kits_manage_table_headers()
{
	$CI =& get_instance();

	$headers = array(
		array('item_kit_id' => $CI->lang->line('item_kits_kit')),
		array('name' => $CI->lang->line('item_kits_name')),
		array('description' => $CI->lang->line('item_kits_description')),
		array('total_cost_price' => $CI->lang->line('items_cost_price'), 'sortable' => FALSE),
		array('total_unit_price' => $CI->lang->line('items_unit_price'), 'sortable' => FALSE)
	);

	return transform_headers($headers);
}

/*
Get the html data row for the item kit
*/
function get_item_kit_data_row($item_kit)
{
	$CI =& get_instance();
	$controller_name = strtolower(get_class($CI));

	return array (
		'item_kit_id' => $item_kit->item_kit_id,
		'name' => $item_kit->name,
		'description' => $item_kit->description,
		'total_cost_price' => to_currency($item_kit->total_cost_price),
		'total_unit_price' => to_currency($item_kit->total_unit_price),
		'edit' => anchor($controller_name."/view/$item_kit->item_kit_id", '<span class="glyphicon glyphicon-edit"></span>',
			array('class'=>'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_update'))
		));
}

function expand_attribute_values($definition_names, $attribute_values)
{
	$values = explode('|', $attribute_values);

	$indexed_values = array();
	foreach($values as $attribute_value)
	{
		$exploded_value = explode(':', $attribute_value);
		$indexed_values[$exploded_value[0]] = isset($exploded_value[1]) ? $exploded_value[1] : '-';
	}

	$attribute_values = array();
	foreach($definition_names as $definition_id => $definition_name)
	{
		$attribute_value = isset($indexed_values[$definition_id]) ? $indexed_values[$definition_id] : '-';
		$attribute_values["$definition_id"] = $attribute_value;
	}
	return $attribute_values;
}

function get_attribute_definition_manage_table_headers()
{
	$CI =& get_instance();

	$headers = array(
		array('definition_id' => $CI->lang->line('attributes_definition_id')),
		array('definition_name' => $CI->lang->line('attributes_definition_name')),
		array('definition_type' => $CI->lang->line('attributes_definition_type')),
		array('definition_flags' => $CI->lang->line('attributes_definition_flags')),
		array('definition_group' => $CI->lang->line('attributes_definition_group')),
	);

	return transform_headers($headers);
}

function get_attribute_definition_data_row($attribute)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));

	if (count($attribute->definition_flags) == 0)
	{
		$definition_flags = $CI->lang->line('common_none_selected_text');
	}
	else if ($attribute->definition_type == GROUP)
	{
		$definition_flags = "-";
	}
	else
	{
		$definition_flags = implode(', ', $attribute->definition_flags);
	}

	return array (
		'definition_id' => $attribute->definition_id,
		'definition_name' => $attribute->definition_name,
		'definition_type' => $attribute->definition_type,
		'definition_group' => $attribute->definition_group,
		'definition_flags' => $definition_flags,
		'edit' => anchor("$controller_name/view/$attribute->definition_id", '<span class="glyphicon glyphicon-edit"></span>',
			array('class'=>'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_update'))
		));
}

/*
Get the header for the expense categories tabular view
*/
function get_expense_category_manage_table_headers()
{
	$CI =& get_instance();

	$headers = array(
		array('expense_category_id' => $CI->lang->line('expenses_categories_category_id')),
		array('category_name' => $CI->lang->line('expenses_categories_name')),
		array('category_description' => $CI->lang->line('expenses_categories_description'))
	);

	return transform_headers($headers);
}

function get_accounts_manage_table_headers()
{
	$CI =& get_instance();
	$headers = array(
		array('trans_id' => $CI->lang->line('expenses_expense_id')),
		array('date' => $CI->lang->line('expenses_date')),
		array('description' => $CI->lang->line('account_description')),
		array('debit_amount' => $CI->lang->line('account_debits')),
		array('credit_amount' => $CI->lang->line('account_credits')),
		array('balance_amount' => $CI->lang->line('account_balance_amount')),
		array('notes' => $CI->lang->line('accounts_notes')),
		array('createdBy' => $CI->lang->line('expenses_employee'))
	);
	$headers[] = array('receipt' => '');
	return transform_headers($headers);
}

/*
Gets the html data row for the expenses
*/

function get_accounts_data_row($account, $balance_amount)
{
	$CI =& get_instance();
	$controller_name = strtolower(get_class($CI));
	return array (
		'trans_id' => $account->trans_id,
		'date' => date($CI->config->item('dateformat') . ' ' . $CI->config->item('timeformat'), strtotime($account->thedate)),
		'description' =>  empty($account->description) ? 'CPAY ' .$account->trans_id : $account->description,
		'debit_amount' => to_currency($account->debit_amount),
		'credit_amount' => to_currency($account->credit_amount),
		'balance_amount' => to_currency($balance_amount),
		'notes' => $account->notes,
		'createdBy' => $account->first_name.' '. $account->last_name,
		'receipt' => anchor($controller_name."/receipt/0/$account->trans_id/$balance_amount", '<span class="glyphicon glyphicon-print"></span>',
			array('data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_print_receipt'))),
		'edit' => empty($account->description) ? anchor($controller_name."/edit_pay/0/$account->trans_id", '<span class="glyphicon glyphicon-edit"></span>',
			array('class'=>'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_update'))) :''
		);
}

function get_accounts_data_last_row($accounts, $balance)
{
	$CI =& get_instance();
	$table_data_rows = '';
	
	foreach($accounts->result() as $key=>$account)
	{
		$sum_credit_amount += $account->credit_amount;
	}
	
	foreach($accounts->result() as $key=>$account)
	{
		$sum_debit_amount += $account->debit_amount;
	}

	return array(
		'trans_id' => '-',
		'date' => '-',
		'description' => '-',
		'credit_amount' => '<b>'. to_currency($sum_credit_amount).'</b>',
		'debit_amount' => '<b>'. to_currency($sum_debit_amount).'</b>',
		'balance_amount' => '<b>'. $balance.'</b>', 
		'createdBy' => '-',
	);
}

function get_cash_flow_manage_table_headers()
{
	$CI =& get_instance();
	$headers = array(
		array('trans_id' => $CI->lang->line('expenses_expense_id')),
		array('date' => $CI->lang->line('expenses_date')),
		array('party' => $CI->lang->line('reports_party')),
		array('type' => $CI->lang->line('reports_type')),
		array('description' => $CI->lang->line('account_description')),
		array('location_id' => $CI->lang->line('reports_stock_location')),
		array('debit_amount' => $CI->lang->line('account_debits')),
		array('credit_amount' => $CI->lang->line('account_credits')),
		array('createdBy' => $CI->lang->line('expenses_employee'))
	);

	return transform_headers($headers, TRUE, TRUE);
}

function get_cash_flow_data_row($account)
{
	$CI =& get_instance();
	$controller_name = strtolower(get_class($CI));
	return array (
		'trans_id' => $account->trans_id,
		'date' => date($CI->config->item('dateformat') . ' ' . $CI->config->item('timeformat'), strtotime($account->thedate)),
		'party' =>  $account->party_first_name.' '. $account->party_last_name,
		'type' => $account->type,
		'description' =>  empty($account->description) ? 'CPAY ' .$account->trans_id : $account->description,
		'location_id' => $CI->Stock_location->get_location_name($account->location_id),
		'credit_amount' => to_currency($account->credit_amount),
		'debit_amount' => to_currency($account->debit_amount),
		'createdBy' => $account->first_name.' '. $account->last_name,
		'edit' => anchor($controller_name."/edit_transfer_fund/$account->trans_id", '<span class="glyphicon glyphicon-edit"></span>',
			array('class'=>'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_update'))));
}

function get_cash_flow_data_last_row($accounts, $balance)
{
	$CI =& get_instance();
	$table_data_rows = '';
	
	foreach($accounts->result() as $key=>$account)
	{
		$sum_credit_amount += $account->credit_amount;
	}
	
	foreach($accounts->result() as $key=>$account)
	{
		$sum_debit_amount += $account->debit_amount;
	}


	return array(
		'trans_id' => '-',
		'date' => '-',
		'description' => '-',
		'credit_amount' => '<b>'. to_currency($sum_credit_amount).'</b>',
		'debit_amount' => '<b>'. to_currency($sum_debit_amount).'</b>',
		'balance_amount' => '<b>'. $balance.'</b>', 
		'createdBy' => '-',
	);
}

function get_supplier_accounts_manage_table_headers()
{
	$CI =& get_instance();
	$headers = array(
		array('trans_id' => $CI->lang->line('expenses_expense_id')),
		array('date' => $CI->lang->line('expenses_date')),
		array('description' => $CI->lang->line('account_description')),
		array('credit_amount' => $CI->lang->line('account_credits')),
		array('debit_amount' => $CI->lang->line('account_debits')),
		array('balance_amount' => $CI->lang->line('account_balance_amount')),
		array('notes' => $CI->lang->line('accounts_notes')),
		array('createdBy' => $CI->lang->line('expenses_employee'))
	);
	$headers[] = array('receipt' => '');
	return transform_headers($headers, TRUE, TRUE);
}

function get_supplier_accounts_data_row($account, $balance_amount)
{
	$CI =& get_instance();
	$controller_name = strtolower(get_class($CI));
	return array (
		'trans_id' => $account->trans_id,
		'date' => date($CI->config->item('dateformat') . ' ' . $CI->config->item('timeformat'), strtotime($account->thedate)),
		'description' => empty($account->description) ? 'SPAY ' .$account->trans_id : $account->description,
		'credit_amount' => to_currency($account->credit_amount),
		'debit_amount' => to_currency($account->debit_amount),
		'balance_amount' => to_currency($balance_amount),
		'notes' => $account->notes,
		'createdBy' => $account->first_name.' '. $account->last_name,
		'receipt' => anchor($controller_name."/receipt/1/$account->trans_id/$balance_amount", '<span class="glyphicon glyphicon-print"></span>',
			array('data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_print_payment'))
		),
		
		'edit' => empty($account->description) ? anchor($controller_name."/edit_pay/1/$account->trans_id", '<span class="glyphicon glyphicon-edit"></span>',
			array('class'=>'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_update'))) :''
   );
}

function get_supplier_accounts_data_last_row($accounts, $balance)
{
	$CI =& get_instance();
	$table_data_rows = '';
	
	foreach($accounts->result() as $key=>$account)
	{
		$sum_credit_amount += $account->credit_amount;
	}
	
	foreach($accounts->result() as $key=>$account)
	{
		$sum_debit_amount += $account->debit_amount;
	}


	return array(
		'trans_id' => '-',
		'date' => '-',
		'description' => '-',
		'debit_amount' => '<b>'. to_currency($sum_debit_amount).'</b>',
		'credit_amount' => '<b>'. to_currency($sum_credit_amount).'</b>',
		'balance_amount' => '<b>'. $balance.'</b>', 
		'createdBy' => '-',
	);
}

/*
Gets the html data row for the expenses category
*/
function get_expense_category_data_row($expense_category)
{
	$CI =& get_instance();
	$controller_name = strtolower(get_class($CI));

	return array (
		'expense_category_id' => $expense_category->expense_category_id,
		'category_name' => $expense_category->category_name,
		'category_description' => $expense_category->category_description,
		'edit' => anchor($controller_name."/view/$expense_category->expense_category_id", '<span class="glyphicon glyphicon-edit"></span>',
			array('class'=>'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_update'))
		));
}


/*
Get the header for the expenses tabular view
*/
function get_expenses_manage_table_headers()
{
	$CI =& get_instance();
	$headers = array(
		array('expense_id' => $CI->lang->line('expenses_expense_id')),
		array('date' => $CI->lang->line('expenses_date')),
		//array('supplier_name' => $CI->lang->line('expenses_supplier_name')),
		array('supplier_tax_code' => $CI->lang->line('expenses_supplier_tax_code')),
		array('amount' => $CI->lang->line('expenses_amount')),
		array('tax_amount' => $CI->lang->line('expenses_tax_amount')),
		array('payment_type' => $CI->lang->line('expenses_payment')),
		array('category_name' => $CI->lang->line('expenses_categories_name')),
		array('description' => $CI->lang->line('expenses_description')),
		array('createdBy' => $CI->lang->line('expenses_employee'))
	);

	return transform_headers($headers);
}

/*
Gets the html data row for the expenses
*/
function get_expenses_data_row($expense)
{
	$CI =& get_instance();
	$controller_name = strtolower(get_class($CI));
	return array (
		'expense_id' => $expense->expense_id,
		'date' => date($CI->config->item('dateformat') . ' ' . $CI->config->item('timeformat'), strtotime($expense->date)),
		//'supplier_name' => $expense->supplier_name,
		'supplier_tax_code' => $expense->supplier_tax_code,
		'amount' => to_currency($expense->amount),
		'tax_amount' => to_currency($expense->tax_amount),
		'payment_type' => $expense->payment_type,
		'category_name' => $expense->category_name,
		'description' => $expense->description,
		'createdBy' => $expense->first_name.' '. $expense->last_name,
		'edit' => anchor($controller_name."/view/$expense->expense_id", '<span class="glyphicon glyphicon-edit"></span>',
			array('class'=>'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_update'))
		));
}

/*
Get the html data last row for the expenses
*/
function get_expenses_data_last_row($expense)
{
	$CI =& get_instance();
	$table_data_rows = '';
	$sum_amount_expense = 0;
	$sum_tax_amount_expense = 0;

	foreach($expense->result() as $key=>$expense)
	{
		$sum_amount_expense += $expense->amount;
		$sum_tax_amount_expense += $expense->tax_amount;
	}

	return array(
		'expense_id' => '-',
		'date' => '<b>'.$CI->lang->line('sales_total').'</b>',
		'amount' => '<b>'. to_currency($sum_amount_expense).'</b>',
		'tax_amount' => '<b>'. to_currency($sum_tax_amount_expense).'</b>'
	);
}

/*
Get the expenses payments summary
*/
function get_expenses_manage_payments_summary($payments, $expenses)
{
	$CI =& get_instance();
	$table = '<div id="report_summary">';

	foreach($payments as $key=>$payment)
	{
		$amount = $payment['amount'];
		$table .= '<div class="summary_row">' . $payment['payment_type'] . ': ' . to_currency($amount) . '</div>';
	}
	$table .= '</div>';

	return $table;
}


/*
Get the header for the cashup tabular view
*/
function get_cashups_manage_table_headers()
{
	$CI =& get_instance();
	$headers = array(
		array('cashup_id' => $CI->lang->line('cashups_id')),
		array('open_date' => $CI->lang->line('cashups_opened_date')),
		array('open_employee_id' => $CI->lang->line('cashups_open_employee')),
		array('open_amount_cash' => $CI->lang->line('cashups_open_amount_cash')),
		array('transfer_amount_cash' => $CI->lang->line('cashups_transfer_amount_cash')),
		array('close_date' => $CI->lang->line('cashups_closed_date')),
		array('close_employee_id' => $CI->lang->line('cashups_close_employee')),
		array('closed_amount_cash' => $CI->lang->line('cashups_closed_amount_cash')),
		array('note' => $CI->lang->line('cashups_note')),
		array('closed_amount_due' => $CI->lang->line('cashups_closed_amount_due')),
		array('closed_amount_card' => $CI->lang->line('cashups_closed_amount_card')),
		array('closed_amount_check' => $CI->lang->line('cashups_closed_amount_check')),
		array('closed_amount_total' => $CI->lang->line('cashups_closed_amount_total'))
	);

	return transform_headers($headers);
}

/*
Gets the html data row for the cashups
*/
function get_cash_up_data_row($cash_up)
{
	$CI =& get_instance();
	$controller_name = strtolower(get_class($CI));
	return array (
		'cashup_id' => $cash_up->cashup_id,
		'open_date' => date($CI->config->item('dateformat') . ' ' . $CI->config->item('timeformat'), strtotime($cash_up->open_date)),
		'open_employee_id' => $cash_up->open_first_name . ' ' . $cash_up->open_last_name,
		'open_amount_cash' => to_currency($cash_up->open_amount_cash),
		'transfer_amount_cash' => to_currency($cash_up->transfer_amount_cash),
		'close_date' => date($CI->config->item('dateformat') . ' ' . $CI->config->item('timeformat'), strtotime($cash_up->close_date)),
		'close_employee_id' => $cash_up->close_first_name . ' ' . $cash_up->close_last_name,
		'closed_amount_cash' => to_currency($cash_up->closed_amount_cash),
		'note' => $cash_up->note ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>',
		'closed_amount_due' => to_currency($cash_up->closed_amount_due),
		'closed_amount_card' => to_currency($cash_up->closed_amount_card),
		'closed_amount_check' => to_currency($cash_up->closed_amount_check),
		'closed_amount_total' => to_currency($cash_up->closed_amount_total),
		'edit' => anchor($controller_name."/view/$cash_up->cashup_id", '<span class="glyphicon glyphicon-edit"></span>',
			array('class'=>'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_update'))
	));
}

function get_accounts_chart_manage_table_headers()
{
	$CI =& get_instance();
	$headers = array(
        array('trans_id' => $CI->lang->line('account_head_id')),
		array('name' => $CI->lang->line('account_name')),
		array('nature' => $CI->lang->line('account_nature')),
		array('type' => $CI->lang->line('account_type')),
		array('description' => $CI->lang->line('account_description'))
	);

	return transform_headers($headers);
}

function get_accounts_chart_data_row($chart)
{
	$CI =& get_instance();
	$controller_name = strtolower(get_class($CI));
	return array (
		'trans_id' => $chart->trans_id,
		'name' => $chart->name,
		'nature' => $chart->nature,
		'type' => $chart->type,
		'description' =>  $chart->description,
		'edit' => anchor($controller_name."/create_head/$chart->trans_id", '<span class="glyphicon glyphicon-edit"></span>',
			array('class'=>'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_update'))));
}

/*
Get the header for the workorders tabular view
*/

function get_workorders_manage_table_headers()
{
	$CI =& get_instance();
	$headers = array(
	    'summary' => array(
				array('id' => $CI->lang->line('reports_sale_id')),
				array('type_code' => $CI->lang->line('reports_code_type')),
				array('sale_date' => $CI->lang->line('reports_date'), 'sortable' => FALSE),
				array('quantity' => $CI->lang->line('reports_quantity')),
				array('employee_name' => $CI->lang->line('reports_sold_by')),
				array('customer_name' => $CI->lang->line('reports_sold_to')),
				array('subtotal' => $CI->lang->line('reports_subtotal'), 'sorter' => 'number_sorter'),
				array('tax' => $CI->lang->line('reports_tax'), 'sorter' => 'number_sorter'),
				array('total' => $CI->lang->line('reports_total'), 'sorter' => 'number_sorter'),
				array('cost' => $CI->lang->line('reports_cost'), 'sorter' => 'number_sorter'),
				array('profit' => $CI->lang->line('reports_profit'), 'sorter' => 'number_sorter'),
				array('payment_type' => $CI->lang->line('reports_payment_type'), 'sortable' => FALSE),
				array('comment' => $CI->lang->line('reports_comments'))),
			'details' => array(
				$CI->lang->line('reports_name'),
				$CI->lang->line('reports_category'),
				$CI->lang->line('reports_serial_number'),
				$CI->lang->line('reports_description'),
				$CI->lang->line('reports_quantity'),
				$CI->lang->line('reports_subtotal'),
				$CI->lang->line('reports_tax'),
				$CI->lang->line('reports_total'),
				$CI->lang->line('reports_cost'),
				$CI->lang->line('reports_profit'),
				$CI->lang->line('reports_discount')),
			'details_rewards' => array(
				$CI->lang->line('reports_used'),
				$CI->lang->line('reports_earned'))
	);
 
	return $headers;
}


/*
Get the html data row for the sales
*/

function get_workorders_data_row($report_data)
{
	$CI =& get_instance();
	$controller_name = $CI->uri->segment(1);
	
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
	
	return array('summary_data' => $summary_data, 'details_data' => $details_data, 'details_data_rewards' => $details_data_rewards);
}

function get_services_manage_table_headers()
{
	$CI =& get_instance();

	//if($CI->Employee->is_driver($CI->session->userdata('person_id')))
	if(1==2)
	{
		$headers = array(
		array('order_id' => $CI->lang->line('services_order_ids')),
		array('location' => $CI->lang->line('receivings_location')),
		array('shelf' => $CI->lang->line('services_shelf')),
		array('status' => $CI->lang->line('services_status')),
		array('start_date' => $CI->lang->line('services_start_date')),
		array('due_date' => $CI->lang->line('services_due_date'))
	    );	
		
    	if($CI->Employee->has_grant('messages', $CI->session->userdata('person_id')))
     	{
     		$headers[] = array('messages' => '');
    		$headers[] = array('whatsapp' => '');
    	}
	}
	else
	{
		$headers = array(
	        array('service_id' => $CI->lang->line('services_rec_id')),
	    	array('order_id' => $CI->lang->line('services_order_ids')),
    		array('receiving_time' => $CI->lang->line('receiving_time')),
			array('location' => $CI->lang->line('receivings_location')),
		    array('first_name' => $CI->lang->line('services_customer_name')),
		    array('phone_number' => $CI->lang->line('common_phone_number')),
		    array('priority' => $CI->lang->line('services_priority')),
		    array('shelf' => $CI->lang->line('services_shelf')),
		    array('status' => $CI->lang->line('services_status')),
		    array('work_type' => $CI->lang->line('services_work_type')),
		    array('start_date' => $CI->lang->line('services_start_date')),
		    array('due_date' => $CI->lang->line('services_due_date')),
			array('engineer_id' => $CI->lang->line('engineers_supplier'))
     	);	

        if($CI->Employee->has_grant('services_transfer', $CI->session->userdata('person_id')))
	    {
		    $headers[] = array('transfer' => '');
	    }
	
	    if($CI->Employee->has_grant('services_report', $CI->session->userdata('person_id')))
	    {
		    $headers[] = array('data' => '');
	    }

    	if($CI->Employee->has_grant('messages', $CI->session->userdata('person_id')))
     	{
     		$headers[] = array('messages' => '');
    		$headers[] = array('whatsapp' => '');
    	}
		
	}
	return transform_headers($headers);
}


/*
Get the html data row for the service
*/
function get_services_data_row($service)
{
	$CI =& get_instance();
	$controller_name = strtolower(get_class($CI));
	
	//if($CI->Employee->is_driver($CI->session->userdata('person_id')))
	if(1==2)
	{
    	return array (
	        'service_id' => 'Recv '. $service->service_id,
    		'order_id' => $CI->Service->get_proirity_color($service->order_id, $service->priority),
		    'receiving_time' => date($CI->config->item('dateformat') . ' ' . $CI->config->item('timeformat'), strtotime($service->receiving_time)),
    		'location' => (empty($service->latitude)) ? anchor($controller_name."/show_map/$service->order_id", '<span class="glyphicon"> '.$service->customer_location.'</span>',
    			array('class'=>"modal-dlg btn-sm btn-warning", 'data-btn-submit' => $CI->lang->line('common_ok'), 'title'=>$CI->lang->line('services_customer_detailes'))) : anchor($controller_name."/show_map/$service->order_id", '<span class="glyphicon glyphicon-map-marker"> '.$service->customer_location.'</span>',
    			array('class'=>"modal-dlg btn-sm btn-success", 'data-btn-submit' => $CI->lang->line('common_ok'), 'data-btn-drive' => $CI->lang->line('services_drive'), 'title'=>$CI->lang->line('common_delivery_position'))),
    		'first_name' => empty($service->company_name) ? $service->first_name .' '. $service->last_name :$service->first_name .' '. $service->last_name .' ['.$service->company_name.']' ,
    		'phone_number' => $CI->config->item('calling_codes').''.$service->phone_number,
    		'shelf' => $CI->Shelf->shelf_name($service->shelf),
     		'status' => ($service->status != 4) ? $CI->Service->get_status_name($service->status) : anchor($controller_name."/reprint/$service->order_id", '<span>'.$CI->Service->get_status_name($service->status).'</span>'),
			'start_date' => date($CI->config->item('dateformat') . ' ' . $CI->config->item('timeformat'), strtotime($service->start_date)),
			'due_date' => date($CI->config->item('dateformat') . ' ' . $CI->config->item('timeformat'), strtotime($service->due_date)),
    		'engineer_id' => $service->en_first_name .' '. $service->en_last_name,
    		'transfer' => (empty($service->engineer_id)) ? '' : anchor($controller_name."/transfer/$service->order_id", '<span class="glyphicon glyphicon-retweet"></span>',
    			array('class'=>"modal-dlg btn-sm btn-success", 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_transfer_form'))),
    		'messages' => empty($service->phone_number) ? '' : anchor("Messages/view/$service->person_id", '<span class="glyphicon glyphicon-phone"></span>',
    			array('class'=>"modal-dlg btn-sm btn-info", 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line('messages_sms_send'))),
    		'whatsapp' => (empty($service->phone_number)) ? '' : anchor($controller_name."/whatsapp_send/$service->phone_number/$service->first_name/$service->order_id", '<span class="glyphicon glyphicon-comment"></span>',
    			array('class'=>"modal-dlg btn-sm btn-warning", 'title'=>$CI->lang->line($controller_name.'_whatsapp_send'))),
    		'edit' => (($CI->Service->admin_actions($service->delivery, $service->status) == 0) || (!$service->shelf)) ? '' : anchor($controller_name."/view/$service->order_id", '<span class="glyphicon glyphicon-edit">'.$CI->lang->line('services_actions').'</span>',
    			array('class'=>"modal-dlg btn-sm btn-warning", 'data-btn-submit' => $CI->lang->line('services_ok'), 'title'=>$CI->lang->line($controller_name.'_update'))),
    		'data' => anchor($controller_name."/report/$service->order_id", '<span class="glyphicon glyphicon glyphicon-list-alt"></span>',
    			array('class'=>"modal-dlg modal-dlg-wide  btn-sm btn-warning", 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_history')))
     	); 
	}
	else
	{
		return array (
	    'service_id' => 'Recv '. $service->service_id,
		'order_id' => $service->order_id,
		'receiving_time' => date($CI->config->item('dateformat') . ' ' . $CI->config->item('timeformat'), strtotime($service->receiving_time)),
		//'location' => $service->location,
		'location' => (empty($service->latitude)) ? $service->customer_location : anchor($controller_name."/show_map/$service->order_id", '<span class="glyphicon glyphicon-map-marker"> '.$service->customer_location.'</span>',
			array('class'=>"modal-dlg btn-sm btn-success", 'data-btn-submit' => $CI->lang->line('common_ok'), 'data-btn-drive' => $CI->lang->line('services_drive'), 'title'=>$CI->lang->line('common_delivery_position'))),
		'first_name' => empty($service->company_name) ? $service->first_name .' '. $service->last_name :$service->first_name .' '. $service->last_name .' ['.$service->company_name.']' ,
		'phone_number' => $CI->config->item('calling_codes').''.$service->phone_number,
		'priority' => $service->priority,
		'shelf' => (empty($service->shelf) && $service->delivery == '0') ? anchor($controller_name."/change_shelf/$service->order_id", '<span class="glyphicon glyphicon-tasks"></span>',
			array('class'=>"modal-dlg", 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line('shelfs_change_shelf'))) : $CI->Shelf->shelf_name($service->shelf),
		'status' => ($service->status != 4) ? $CI->Service->get_status_name($service->status) : anchor($controller_name."/reprint/$service->order_id", '<span>'.$CI->Service->get_status_name($service->status).'</span>'),
		'work_type' => $CI->Service->get_work_type($service->work_type),
		'start_date' => date($CI->config->item('dateformat') . ' ' . $CI->config->item('timeformat'), strtotime($service->start_date)),
		'due_date' => date($CI->config->item('dateformat') . ' ' . $CI->config->item('timeformat'), strtotime($service->due_date)),
		'engineer_id' => $service->en_first_name .' '. $service->en_last_name,
		'transfer' => (empty($service->engineer_id)) ? '' : anchor($controller_name."/transfer/$service->order_id", '<span class="glyphicon glyphicon-retweet"></span>',
			array('class'=>"modal-dlg btn-sm btn-success", 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_transfer_form'))),
		'messages' => empty($service->phone_number) ? '' : anchor("Messages/view/$service->person_id", '<span class="glyphicon glyphicon-phone"></span>',
			array('class'=>"modal-dlg btn-sm btn-info", 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line('messages_sms_send'))),
		'whatsapp' => (empty($service->phone_number)) ? '' : anchor($controller_name."/whatsapp_send/$service->phone_number/$service->first_name/$service->order_id", '<span class="glyphicon glyphicon-comment"></span>',
			array('class'=>"modal-dlg btn-sm btn-warning", 'title'=>$CI->lang->line($controller_name.'_whatsapp_send'))),
		'edit' => (($CI->Service->driver_actions($service->delivery, $service->status) == 0) || (!$service->shelf)) ? '' : anchor($controller_name."/view/$service->order_id", '<span class="glyphicon glyphicon-edit">'.$CI->lang->line('services_actions').'</span>',
			array('class'=>"modal-dlg btn-sm btn-warning", 'data-btn-submit' => $CI->lang->line('services_ok'), 'title'=>$CI->lang->line($controller_name.'_update'))),
		'data' => anchor($controller_name."/report/$service->order_id", '<span class="glyphicon glyphicon glyphicon-list-alt"></span>',
			array('class'=>"modal-dlg modal-dlg-wide  btn-sm btn-warning", 'data-btn-submit' => $CI->lang->line('common_submit'), 'title'=>$CI->lang->line($controller_name.'_history')))
    	);		
	}
}
?>
