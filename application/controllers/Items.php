<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Items extends Secure_Controller
{
	public function __construct()
	{
		parent::__construct('items');

		$this->load->library('item_lib');
	}
	
	public function index()
	{
		$this->session->set_userdata('allow_temp_items', 0);

		$data['table_headers'] = $this->xss_clean(get_items_manage_table_headers());
		
		$data['stock_location'] = $this->xss_clean($this->item_lib->get_item_location());
		$data['stock_locations'] = $this->xss_clean($this->Stock_location->get_allowed_locations());

		// filters that will be loaded in the multiselect dropdown
		$data['filters'] = array('empty_upc' => $this->lang->line('items_empty_upc_items'),
			'low_inventory' => $this->lang->line('items_low_inventory_items'),
			'is_serialized' => $this->lang->line('items_serialized_items'),
			'no_description' => $this->lang->line('items_no_description_items'),
			'search_custom' => $this->lang->line('items_search_attributes'),
			'is_deleted' => $this->lang->line('items_is_deleted'),
			'temporary' => $this->lang->line('items_temp'),
			'is_damaged' => $this->lang->line('items_damages'));
		$this->arabic->load('Date');
        $this->arabic->setMode(1);
        $hdate = $this->arabic->date('l dS F Y', time());	
		$data['hdate'] = $hdate;
		$this->load->view('items/manage', $data);
	}

	/*
	Returns Items table data rows. This will be called with AJAX.
	*/
	public function search()
	{
		$search = $this->input->get('search');
		$limit = $this->input->get('limit');
		$offset = $this->input->get('offset');
		$sort = $this->input->get('sort');
		$order = $this->input->get('order');

		$this->item_lib->set_item_location($this->input->get('stock_location'));

		$definition_names = $this->Attribute->get_definitions_by_flags(Attribute::SHOW_IN_ITEMS);

		$filters = array('start_date' => $this->input->get('start_date'),
						'end_date' => $this->input->get('end_date'),
						'stock_location_id' => $this->item_lib->get_item_location(),
						'empty_upc' => FALSE,
						'low_inventory' => FALSE, 
						'is_serialized' => FALSE,
						'no_description' => FALSE,
						'search_custom' => FALSE,
						'is_deleted' => FALSE,
						'temporary' => FALSE,
						'is_damaged' => FALSE,
						'definition_ids' => array_keys($definition_names));
		
		// check if any filter is set in the multiselect dropdown
		$filledup = array_fill_keys($this->input->get('filters'), TRUE);
		$filters = array_merge($filters, $filledup);

		$items = $this->Item->search($search, $filters, $limit, $offset, $sort, $order);

		$total_rows = $this->Item->get_found_rows($search, $filters);

		$data_rows = array();
		foreach($items->result() as $item)
		{
			$row = $this->xss_clean(get_item_data_row($item));
			if($filters['is_damaged'])
			{
		    	$row['inventory'] = '';
		    	$row['stock'] = '';
		    	$row['edit'] = '';
			}
			$data_rows[] = $row;
			if($item->pic_filename!='')
			{
				$this->_update_pic_filename($item);
			}
		}

		echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
	}
	
	public function pic_thumb($pic_filename)
	{
		$this->load->helper('file');
		$this->load->library('image_lib');

		// in this context, $pic_filename always has .ext
		$ext = pathinfo($pic_filename, PATHINFO_EXTENSION);
		$images = glob('./uploads/item_pics/' . $pic_filename);

		// make sure we pick only the file name, without extension
		$base_path = './uploads/item_pics/' . pathinfo($pic_filename, PATHINFO_FILENAME);
		if(sizeof($images) > 0)
		{
			$image_path = $images[0];
			$thumb_path = $base_path . $this->image_lib->thumb_marker . '.' . $ext;
			if(sizeof($images) < 2)
			{
				$config['image_library'] = 'gd2';
				$config['source_image']  = $image_path;
				$config['maintain_ratio'] = TRUE;
				$config['create_thumb'] = TRUE;
				$config['width'] = 52;
				$config['height'] = 32;
				$this->image_lib->initialize($config);
				$image = $this->image_lib->resize();
				$thumb_path = $this->image_lib->full_dst_path;
			}
			$this->output->set_content_type(get_mime_by_extension($thumb_path));
			$this->output->set_output(file_get_contents($thumb_path));
		}
	}

	/*
	Gives search suggestions based on what is being searched for
	*/
	public function suggest_search()
	{
		$suggestions = $this->xss_clean($this->Item->get_search_suggestions($this->input->post_get('term'),
			array('search_custom' => $this->input->post('search_custom'), 'is_deleted' => $this->input->post('is_deleted') != NULL), FALSE));

		echo json_encode($suggestions);
	}

	public function suggest()
	{
		$suggestions = $this->xss_clean($this->Item->get_search_suggestions($this->input->post_get('term'),
			array('search_custom' => FALSE, 'is_deleted' => FALSE), TRUE));

		echo json_encode($suggestions);
	}


	public function suggest_low_sell()
	{
		$suggestions = $this->xss_clean($this->Item->get_low_sell_suggestions($this->input->post_get('name')));

		echo json_encode($suggestions);
	}


	public function suggest_kits()
	{
		$suggestions = $this->xss_clean($this->Item->get_kit_search_suggestions($this->input->post_get('term'),
			array('search_custom' => FALSE, 'is_deleted' => FALSE), TRUE));

		echo json_encode($suggestions);
	}

	/*
	Gives search suggestions based on what is being searched for
	*/
	public function suggest_category()
	{
		$suggestions = $this->xss_clean($this->Item->get_category_suggestions($this->input->get('term')));

		echo json_encode($suggestions);
	}

	/*
	 Gives search suggestions based on what is being searched for
	*/
	public function suggest_location()
	{
		$suggestions = $this->xss_clean($this->Item->get_location_suggestions($this->input->get('term')));

		echo json_encode($suggestions);
	}

	public function get_row($item_ids)
	{
		$item_infos = $this->Item->get_multiple_info(explode(":", $item_ids), $this->item_lib->get_item_location());

		$result = array();
		foreach($item_infos->result() as $item_info)
		{
			$result[$item_info->item_id] = $this->xss_clean(get_item_data_row($item_info));
		}

		echo json_encode($result);
	}

	public function view($item_id = -1)
	{
		if($item_id == -1)
		{
			$data = array();
		}

		// allow_temp_items is set in the index function of items.php or sales.php
		$data['allow_temp_item'] = $this->session->userdata('allow_temp_items');
		$data['item_tax_info'] = $this->xss_clean($this->Item_taxes->get_info($item_id));
		$data['default_tax_1_rate'] = '';
		$data['default_tax_2_rate'] = '';
		$data['item_kits_enabled'] = $this->Employee->has_grant('item_kits', $this->Employee->get_logged_in_employee_info()->person_id);
		$data['definition_values'] = $this->Attribute->get_attributes_by_item($item_id);
		$data['definition_names'] = $this->Attribute->get_definition_names();

		foreach($data['definition_values'] as $definition_id => $definition)
		{
			unset($data['definition_names'][$definition_id]);
		}

		$item_info = $this->Item->get_info($item_id);
		foreach(get_object_vars($item_info) as $property => $value)
		{
			$item_info->$property = $this->xss_clean($value);
		}

		if($data['allow_temp_item'] == 1)
		{
			if($item_id != -1)
			{
				if($item_info->item_type != ITEM_TEMP)
				{
					$data['allow_temp_item'] = 0;
				}
			}
		}
		else
		{
			if($item_info->item_type == ITEM_TEMP)
			{
				$data['allow_temp_item'] = 1;
			}
		}


		if($item_id == -1)
		{
			$data['default_tax_1_rate'] = $this->config->item('default_tax_1_rate');
			$data['default_tax_2_rate'] = $this->config->item('default_tax_2_rate');

			$item_info->receiving_quantity = 1;
			$item_info->reorder_level = 1;
			$item_info->item_type = ITEM; // standard
			$item_info->item_id = $item_id;
			$item_info->stock_type = HAS_STOCK;
			$item_info->tax_category_id = 1;  // Standard
			$item_info->qty_per_pack = 1;
			$item_info->pack_name = $this->lang->line('items_default_pack_name');
		}

		$data['item_info'] = $item_info;

		$suppliers = array('' => $this->lang->line('items_none'));
		foreach($this->Supplier->get_all()->result_array() as $row)
		{
			$suppliers[$this->xss_clean($row['person_id'])] = $this->xss_clean($row['company_name']);
		}
		$data['suppliers'] = $suppliers;
		$data['selected_supplier'] = $item_info->supplier_id;

		$customer_sales_tax_support = $this->config->item('customer_sales_tax_support');
		if($customer_sales_tax_support == '1')
		{
			$data['customer_sales_tax_enabled'] = TRUE;
			$tax_categories = array();
			foreach($this->Tax->get_all_tax_categories()->result_array() as $row)
			{
				$tax_categories[$this->xss_clean($row['tax_category_id'])] = $this->xss_clean($row['tax_category']);
			}
			$data['tax_categories'] = $tax_categories;
			$data['selected_tax_category'] = $item_info->tax_category_id;
		}
		else
		{
			$data['customer_sales_tax_enabled'] = FALSE;
			$data['tax_categories'] = array();
			$data['selected_tax_category'] = '';
		}

		$data['logo_exists'] = $item_info->pic_filename != '';
		$ext = pathinfo($item_info->pic_filename, PATHINFO_EXTENSION);
		if($ext == '')
		{
			// if file extension is not found guess it (legacy)
			$images = glob('./uploads/item_pics/' . $item_info->pic_filename . '.*');
		}
		else
		{
			// else just pick that file
			$images = glob('./uploads/item_pics/' . $item_info->pic_filename);
		}
		$data['image_path'] = sizeof($images) > 0 ? base_url($images[0]) : '';
		$stock_locations = $this->Stock_location->get_undeleted_all()->result_array();
		foreach($stock_locations as $location)
		{
			$location = $this->xss_clean($location);

			$quantity = $this->xss_clean($this->Item_quantity->get_item_quantity($item_id, $location['location_id'])->quantity);
			$quantity = ($item_id == -1) ? 0 : $quantity;
			$location_array[$location['location_id']] = array('location_name' => $location['location_name'], 'quantity' => $quantity);
			$data['stock_locations'] = $location_array;
		}

		$data['selected_low_sell_item_id'] = $item_info->low_sell_item_id;

		if($item_id != -1 && $item_info->item_id != $item_info->low_sell_item_id)
		{
			$low_sell_item_info = $this->Item->get_info($item_info->low_sell_item_id);
			$data['selected_low_sell_item'] = implode(NAME_SEPARATOR, array($low_sell_item_info->name, $low_sell_item_info->pack_name));
		}
		else
		{
			$data['selected_low_sell_item'] = '';
		}

		$this->load->view('items/form', $data);
	}

	public function inventory($item_id = -1)
	{
		$item_info = $this->Item->get_info($item_id);
		foreach(get_object_vars($item_info) as $property => $value)
		{
			$item_info->$property = $this->xss_clean($value);
		}
		$data['item_info'] = $item_info;

		$data['stock_locations'] = array();
		$stock_locations = $this->Stock_location->get_undeleted_all()->result_array();
		foreach($stock_locations as $location)
		{
			$location = $this->xss_clean($location);
			$quantity = $this->xss_clean($this->Item_quantity->get_item_quantity($item_id, $location['location_id'])->quantity);
		
			$data['stock_locations'][$location['location_id']] = $location['location_name'];
			$data['item_quantities'][$location['location_id']] = $quantity;
		}

		$this->load->view('items/form_inventory', $data);
	}
	
	public function damages_warranty($item_id = -1)
	{
		$item_info = $this->Item->get_info($item_id);
		foreach(get_object_vars($item_info) as $property => $value)
		{
			$item_info->$property = $this->xss_clean($value);
		}
		$data['item_info'] = $item_info;

		$data['stock_locations'] = array();
		$stock_locations = $this->Stock_location->get_undeleted_all()->result_array();
		
		$data['actions'] = array('0' => $this->lang->line('items_permanent_damage'),
			'1' => $this->lang->line('items_sent_for_waranty'),
			'2' => $this->lang->line('items_received_from_waranty'));
		
		foreach($stock_locations as $location)
		{
			$location = $this->xss_clean($location);
			$quantity = $this->xss_clean($this->Item_quantity->get_damaged_item_quantity($item_id, $location['location_id'])->quantity);
		
			$data['stock_locations'][$location['location_id']] = $location['location_name'];
			$data['item_quantities'][$location['location_id']] = $quantity;
		}

		$this->load->view('items/form_damages_warranty', $data);
	}
	
	public function count_details($item_id = -1)
	{
		$item_info = $this->Item->get_info($item_id);
		foreach(get_object_vars($item_info) as $property => $value)
		{
			$item_info->$property = $this->xss_clean($value);
		}
		$data['item_info'] = $item_info;

		$data['stock_locations'] = array();
		$stock_locations = $this->Stock_location->get_undeleted_all()->result_array();
		foreach($stock_locations as $location)
		{
			$location = $this->xss_clean($location);
			$quantity = $this->xss_clean($this->Item_quantity->get_item_quantity($item_id, $location['location_id'])->quantity);
		
			$data['stock_locations'][$location['location_id']] = $location['location_name'];
			$data['item_quantities'][$location['location_id']] = $quantity;
		}

		$this->load->view('items/form_count_details', $data);
	}

	public function generate_barcodes($counts = 1, $item_ids)
	{
		$this->load->library('barcode_lib');

		$item_ids = explode(':', $item_ids);
		$result = $this->Item->get_multiple_info($item_ids, $this->item_lib->get_item_location())->result_array();
		$config = $this->barcode_lib->get_barcode_config();

		$data['counts'] = $counts;
		$data['barcode_config'] = $config;

		// check the list of items to see if any item_number field is empty
		foreach($result as &$item)
		{
			$item = $this->xss_clean($item);
			
			// update the barcode field if empty / NULL with the newly generated barcode
			if(empty($item['item_number']) && $this->config->item('barcode_generate_if_empty'))
			{
				// get the newly generated barcode
				$barcode_instance = Barcode_lib::barcode_instance($item, $config);
				$item['item_number'] = $barcode_instance->getData();
				
				$save_item = array('item_number' => $item['item_number']);

				// update the item in the database in order to save the barcode field
				$this->Item->save($save_item, $item['item_id']);
			}
		}
		$data['items'] = $result;
		
		$barcode_media_type = $this->config->item('barcode_method');

		// display barcodes
		
		if($barcode_media_type == 'css_sheet')
		{
			$this->load->view('barcodes/style/barcode_sheet_css', $data);
		}
		elseif($barcode_media_type == '50')
		{
			$this->load->view('barcodes/style/barcode_sheet_50', $data);
		}
		elseif($barcode_media_type == '30' || $barcode_media_type == '20' || $barcode_media_type == '14' || $barcode_media_type == '10')
		{
			$this->load->view('barcodes/style/barcode_sheet_extra', $data);
		}
		else
		{
			$this->load->view('barcodes/style/barcode_sheet_a4', $data);
		}
	}

	public function attributes($item_id)
	{
		$data['item_id'] = $item_id;
		$definition_ids = json_decode($this->input->post('definition_ids'), TRUE);
		$data['definition_values'] = $this->Attribute->get_attributes_by_item($item_id) + $this->Attribute->get_values_by_definitions($definition_ids);
		$data['definition_names'] = $this->Attribute->get_definition_names();

		foreach($data['definition_values'] as $definition_id => $definition_value)
		{
			$attribute_value = $this->Attribute->get_attribute_value($item_id, $definition_id);
			$attribute_id = (empty($attribute_value) || empty($attribute_value->attribute_id)) ? NULL : $attribute_value->attribute_id;
			$values = &$data['definition_values'][$definition_id];
			$values['attribute_id'] = $attribute_id;
			$values['attribute_value'] = $attribute_value;
			$values['selected_value'] = '';
			
			if ($definition_value['definition_type'] == DROPDOWN)
			{
				$values['values'] = $this->Attribute->get_definition_values($definition_id);
				$link_value = $this->Attribute->get_link_value($item_id, $definition_id);
				$values['selected_value'] = (empty($link_value)) ? '' : $link_value->attribute_id;
			}

			if (!empty($definition_ids[$definition_id]))
			{
				$values['selected_value'] = $definition_ids[$definition_id];
			}

			unset($data['definition_names'][$definition_id]);
		}

 		$this->load->view('attributes/item', $data);
	}

	public function bulk_edit()
	{
		$suppliers = array('' => $this->lang->line('items_none'));
		foreach($this->Supplier->get_all()->result_array() as $row)
		{
			$row = $this->xss_clean($row);

			$suppliers[$row['person_id']] = $row['company_name'];
		}
		$data['suppliers'] = $suppliers;
		$data['allow_alt_description_choices'] = array(
			'' => $this->lang->line('items_do_nothing'), 
			1  => $this->lang->line('items_change_all_to_allow_alt_desc'),
			0  => $this->lang->line('items_change_all_to_not_allow_allow_desc'));

		$data['serialization_choices'] = array(
			'' => $this->lang->line('items_do_nothing'), 
			1  => $this->lang->line('items_change_all_to_serialized'),
			0  => $this->lang->line('items_change_all_to_unserialized'));

		$this->load->view('items/form_bulk', $data);
	}

	public function save($item_id = -1)
	{
		$upload_success = $this->_handle_image_upload();
		$upload_data = $this->upload->data();

		$receiving_quantity = parse_decimals($this->input->post('receiving_quantity'));
		$item_type = $this->input->post('item_type') == NULL ? ITEM : $this->input->post('item_type');

		if($receiving_quantity == '0' && $item_type!= ITEM_TEMP)
		{
			$receiving_quantity = '1';
		}
		$default_pack_name = $this->lang->line('items_default_pack_name');

		//Save item data
		$item_data = array(
			'name' => $this->input->post('name'),
			'description' => $this->input->post('description'),
			'category' => $this->input->post('category'),
			'item_type' => $item_type,
			'stock_type' => $this->input->post('stock_type') == NULL ? HAS_STOCK : $this->input->post('stock_type'),
			'supplier_id' => $this->input->post('supplier_id') == '' ? NULL : $this->input->post('supplier_id'),
			'item_number' => $this->input->post('item_number') == '' ? NULL : $this->input->post('item_number'),
			'cost_price' => parse_decimals($this->input->post('cost_price')),
			'minimum_price' => parse_decimals($this->input->post('minimum_price')),
			'unit_price' => parse_decimals($this->input->post('unit_price')),
			'wholesale_price' => parse_decimals($this->input->post('wholesale_price')),
			'reorder_level' => parse_decimals($this->input->post('reorder_level')),
			'receiving_quantity' => $receiving_quantity,
			'allow_alt_description' => $this->input->post('allow_alt_description') != NULL,
			'is_serialized' => $this->input->post('is_serialized') != NULL,
			'unit_type' => $this->input->post('unit_type'),
			'qty_per_pack' => $this->input->post('qty_per_pack') == NULL ? 1 : $this->input->post('qty_per_pack'),
			'pack_name' => $this->input->post('pack_name') == NULL ? $default_pack_name : $this->input->post('pack_name'),
			'low_sell_item_id' => $this->input->post('low_sell_item_id') == NULL ? -1 : $this->input->post('low_sell_item_id'),
			'deleted' => $this->input->post('is_deleted') != NULL,
			'sp' => $this->input->post('sp') != NULL,
			'custom_label' => $this->input->post('custom_label')
		);

		if($item_data['item_type'] == ITEM_TEMP)
		{
			$item_data['stock_type'] = HAS_NO_STOCK;
			$item_data['receiving_quantity'] = 0;
			$item_data['reorder_level'] = 0;
		}

		$x = $this->input->post('tax_category_id');
		if(!isset($x))
		{
			$item_data['tax_category_id'] = '';
		}
		else
		{
			$item_data['tax_category_id'] = $this->input->post('tax_category_id');
		}
		
		if(!empty($upload_data['orig_name']))
		{
			// XSS file image sanity check
			if($this->xss_clean($upload_data['raw_name'], TRUE) === TRUE)
			{
				$item_data['pic_filename'] = $upload_data['raw_name'];
			}
		}
		
		$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;

		if($this->Item->save($item_data, $item_id))
		{
			$success = TRUE;
			$new_item = FALSE;
			//New item
			if($item_id == -1)
			{
				$item_id = $item_data['item_id'];
				$new_item = TRUE;
			}

			$items_taxes_data = array();
			$tax_names = $this->input->post('tax_names');
			$tax_percents = $this->input->post('tax_percents');
			$count = count($tax_percents);
			for($k = 0; $k < $count; ++$k)
			{
				$tax_percentage = parse_decimals($tax_percents[$k]);
				if(is_numeric($tax_percentage))
				{
					$items_taxes_data[] = array('name' => $tax_names[$k], 'percent' => $tax_percentage);
				}
			}
			$success &= $this->Item_taxes->save($items_taxes_data, $item_id);

			//Save item quantity
			$stock_locations = $this->Stock_location->get_undeleted_all()->result_array();
			foreach($stock_locations as $location)
			{
				$updated_quantity = parse_decimals($this->input->post('quantity_' . $location['location_id']));
				if($item_data['item_type'] == ITEM_TEMP)
				{
					$updated_quantity = 0;
				}
				$location_detail = array('item_id' => $item_id,
										'location_id' => $location['location_id'],
										'quantity' => $updated_quantity);


				$item_quantity = $this->Item_quantity->get_item_quantity($item_id, $location['location_id']);
				if($item_quantity->quantity != $updated_quantity || $new_item)
				{
					$success &= $this->Item_quantity->save($location_detail, $item_id, $location['location_id']);

					$inv_data = array(
						'trans_date' => date('Y-m-d H:i:s'),
						'trans_items' => $item_id,
						'trans_user' => $employee_id,
						'trans_location' => $location['location_id'],
						'trans_comment' => $this->lang->line('items_manually_editing_of_quantity'),
						'trans_inventory' => $updated_quantity - $item_quantity->quantity
					);

					$success &= $this->Inventory->insert($inv_data);
				}
			}

			// Save item attributes
			$attribute_links = $this->input->post('attribute_links') != NULL ? $this->input->post('attribute_links') : array();
			$attribute_ids = $this->input->post('attribute_ids');
			$this->Attribute->delete_link($item_id);
			foreach($attribute_links as $definition_id => $attribute_id)
			{
				$definition_type = $this->Attribute->get_info($definition_id)->definition_type;
				if($definition_type != DROPDOWN)
				{
					$attribute_id = $this->Attribute->save_value($attribute_id, $definition_id, $item_id, $attribute_ids[$definition_id], $definition_type);
				}
				$this->Attribute->save_link($item_id, $definition_id, $attribute_id);
			}

			if($success && $upload_success)
			{
				$message = $this->xss_clean($this->lang->line('items_successful_' . ($new_item ? 'adding' : 'updating')) . ' ' . $item_data['name']);

				echo json_encode(array('success' => TRUE, 'message' => $message, 'id' => $item_id));
			}
			else
			{
				$message = $this->xss_clean($upload_success ? $this->lang->line('items_error_adding_updating') . ' ' . $item_data['name'] : strip_tags($this->upload->display_errors()));

				echo json_encode(array('success' => FALSE, 'message' => $message, 'id' => $item_id));
			}
		}
		else // failure
		{
			$message = $this->xss_clean($this->lang->line('items_error_adding_updating') . ' ' . $item_data['name']);
			
			echo json_encode(array('success' => FALSE, 'message' => $message, 'id' => -1));
		}
	}
	
	public function check_item_number()
	{
		$exists = $this->Item->item_number_exists($this->input->post('item_number'), $this->input->post('item_id'));
		echo !$exists ? 'true' : 'false';
	}

	/*
	If adding a new item check to see if an item kit with the same name as the item already exists.
	*/
	public function check_kit_exists()
	{
		if($this->input->post('item_number') === -1)
		{
			$exists = $this->Item_kit->item_kit_exists_for_name($this->input->post('name'));
		}
		else
		{
			$exists = FALSE;
		}
		echo !$exists ? 'true' : 'false';
	}

	private function _handle_image_upload()
	{
		/* Let files be uploaded with their original name */
		
		// load upload library
		$config = array('upload_path' => './uploads/item_pics/',
			'allowed_types' => 'gif|jpg|png',
			'max_size' => '100',
			'max_width' => '640',
			'max_height' => '480'
		);
		$this->load->library('upload', $config);
		$this->upload->do_upload('item_image');
		
		return strlen($this->upload->display_errors()) == 0 || !strcmp($this->upload->display_errors(), '<p>'.$this->lang->line('upload_no_file_selected').'</p>');
	}

	public function remove_logo($item_id)
	{
		$item_data = array('pic_filename' => NULL);
		$result = $this->Item->save($item_data, $item_id);

		echo json_encode(array('success' => $result));
	}

	public function save_inventory($item_id = -1)
	{	
		$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		$cur_item_info = $this->Item->get_info($item_id);
		$location_id = $this->input->post('stock_location');
		$inv_data = array(
			'trans_date' => date('Y-m-d H:i:s'),
			'trans_items' => $item_id,
			'trans_user' => $employee_id,
			'trans_location' => $location_id,
			'trans_comment' => $this->input->post('trans_comment'),
			'trans_inventory' => parse_decimals($this->input->post('newquantity'))
		);
		
		$this->Inventory->insert($inv_data);
		
		//Update stock quantity
		$item_quantity = $this->Item_quantity->get_item_quantity($item_id, $location_id);
		$item_quantity_data = array(
			'item_id' => $item_id,
			'location_id' => $location_id,
			'quantity' => $item_quantity->quantity + parse_decimals($this->input->post('newquantity'))
		);
		
		$acc_quantity = parse_decimals($this->input->post('newquantity'));
		$cost_price = parse_decimals($this->input->post('cost_price'));
		$total_cost_price = bcmul($acc_quantity, $cost_price, 2);
		
		if($total_cost_price > 0)
		{
	    	$item_account_data = array(
		        'thedate'=> date('Y-m-d H:i:s'),
        	    'description'=>'Qty ADJ Item ID '.$item_id,
		        'type'=>'Qty ADJ',
	    		'employee_id' => $employee_id,
                'debit_amount'=> abs($total_cost_price),
	    		'location_id' => $location_id
		    );
		}
		else
		{
			$item_account_data = array(
		        'thedate'=> date('Y-m-d H:i:s'),
        	    'description'=>'Qty ADJ Item ID '.$item_id,
		        'type'=>'Qty ADJ',
	    		'employee_id' => $employee_id,	
                'credit_amount'=> abs($total_cost_price),
	    		'location_id' => $location_id
		    );	
		}
				
      //  $this->Account->insert_stock_adj($item_account_data);

		if($this->Item_quantity->save($item_quantity_data, $item_id, $location_id))
		{
			$message = $this->xss_clean($this->lang->line('items_successful_updating') . ' ' . $cur_item_info->name);
			
			echo json_encode(array('success' => TRUE, 'message' => $message, 'id' => $item_id));
		}
		else//failure
		{
			$message = $this->xss_clean($this->lang->line('items_error_adding_updating') . ' ' . $cur_item_info->name);
			
			echo json_encode(array('success' => FALSE, 'message' => $message, 'id' => -1));
		}
	}

	public function save_damages($item_id = -1)
	{	
		$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		$cur_item_info = $this->Item->get_info($item_id);
		$location_id = $this->input->post('stock_location');
		$action = $this->input->post('action');
		$newquantity = parse_decimals($this->input->post('newquantity'));
		if($action == '2')
		{
			$inv_data = array(
			'trans_date' => date('Y-m-d H:i:s'),
			'trans_items' => $item_id,
			'trans_user' => $employee_id,
			'trans_location' => $location_id,
			'trans_comment' => $this->input->post('trans_comment') == NULL ? 'Warranty Received' : $this->input->post('trans_comment'),
			'trans_inventory' => $newquantity);
			
	    	$this->Inventory->insert($inv_data);
		
	    	//Update stock quantity
	    	$item_quantity = $this->Item_quantity->get_item_quantity($item_id, $location_id);
	    	$item_quantity_data = array(
	    		'item_id' => $item_id,
	    		'location_id' => $location_id,
	    		'quantity' => $item_quantity->quantity + parse_decimals($this->input->post('newquantity')));
		}
		else
		{
		   $inv_data = array(
		    	'trans_date' => date('Y-m-d H:i:s'),
		    	'trans_items' => $item_id,
		    	'trans_user' => $employee_id,
		    	'trans_location' => $location_id,
		    	'trans_comment' => $this->input->post('trans_comment') == NULL ? 'Warranty Sent/Permanent Damage' : $this->input->post('trans_comment'),
		    	'trans_inventory' => -$newquantity);
			
	    	$this->Inventory->insert($inv_data);
		
            //Update stock quantity
	     	$item_quantity = $this->Item_quantity->get_item_quantity($item_id, $location_id);
	    	$item_quantity_data = array(
	    		'item_id' => $item_id,
		    	'location_id' => $location_id,
		    	'quantity' => $item_quantity->quantity - parse_decimals($this->input->post('newquantity')));
		}

		$acc_quantity = parse_decimals($this->input->post('newquantity'));
		$cost_price = parse_decimals($this->input->post('cost_price'));
		$total_cost_price = bcmul($acc_quantity, $cost_price, 2);
		
	   	$item_damages_data = array(
	        'thedate'=> date('Y-m-d H:i:s'),
			'item_id' => $item_id,
	   		'location_id' => $location_id,
	   		'quantity' => parse_decimals($this->input->post('newquantity')),
	        'type'=> $action,
	   		'employee_id' => $employee_id,
            'value'=> $action == 0 ? $total_cost_price : '0'
			);
	
        $this->Item->insert_damage_goods($item_damages_data);

		if($this->Item_quantity->save($item_quantity_data, $item_id, $location_id))
		{
			$message = $this->xss_clean($this->lang->line('items_successful_updating') . ' ' . $cur_item_info->name);
			
			echo json_encode(array('success' => TRUE, 'message' => $message, 'id' => $item_id));
		}
		else//failure
		{
			$message = $this->xss_clean($this->lang->line('items_error_adding_updating') . ' ' . $cur_item_info->name);
			
			echo json_encode(array('success' => FALSE, 'message' => $message, 'id' => -1));
		}
	}
	
	public function bulk_update()
	{
		$items_to_update = $this->input->post('item_ids');
		$item_data = array();

		foreach($_POST as $key => $value)
		{		
			//This field is nullable, so treat it differently
			if($key == 'supplier_id' && $value != '')
			{	
				$item_data["$key"] = $value;
			}
			elseif($value != '' && !(in_array($key, array('item_ids', 'tax_names', 'tax_percents'))))
			{
				$item_data["$key"] = $value;
			}
		}

		//Item data could be empty if tax information is being updated
		if(empty($item_data) || $this->Item->update_multiple($item_data, $items_to_update))
		{
			$items_taxes_data = array();
			$tax_names = $this->input->post('tax_names');
			$tax_percents = $this->input->post('tax_percents');
			$tax_updated = FALSE;
			$count = count($tax_percents);
			for($k = 0; $k < $count; ++$k)
			{		
				if(!empty($tax_names[$k]) && is_numeric($tax_percents[$k]))
				{
					$tax_updated = TRUE;
					
					$items_taxes_data[] = array('name' => $tax_names[$k], 'percent' => $tax_percents[$k]);
				}
			}
			
			if($tax_updated)
			{
				$this->Item_taxes->save_multiple($items_taxes_data, $items_to_update);
			}

			echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('items_successful_bulk_edit'), 'id' => $this->xss_clean($items_to_update)));
		}
		else
		{
			echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('items_error_updating_multiple')));
		}
	}

	public function delete()
	{
		$items_to_delete = $this->input->post('ids');

		if($this->Item->delete_list($items_to_delete))
		{
			$message = $this->lang->line('items_successful_deleted') . ' ' . count($items_to_delete) . ' ' . $this->lang->line('items_one_or_multiple');
			echo json_encode(array('success' => TRUE, 'message' => $message));
		}
		else
		{
			echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('items_cannot_be_deleted')));
		}
	}

	/*
	Items import from excel spreadsheet
	*/
	public function excel()
	{
		$name = 'import_items.csv';
		$data = file_get_contents('../' . $name);
		force_download($name, $data);
	}
	
	public function excel_import()
	{
		$this->load->view('items/form_excel_import', NULL);
	}

	public function do_excel_import()
	{
		if($_FILES['file_path']['error'] != UPLOAD_ERR_OK)
		{
			echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('items_excel_import_failed')));
		}
		else
		{
			if(($handle = fopen($_FILES['file_path']['tmp_name'], 'r')) !== FALSE)
			{
				// Skip the first row as it's the table description
				fgetcsv($handle);
				$i = 1;
				
				$failCodes = array();
		
				while(($data = fgetcsv($handle)) !== FALSE)
				{
					// XSS file data sanity check
					$data = $this->xss_clean($data);
					
					if(sizeof($data) >= 18)
					{
						$item_data = array(
							'name'					=> $data[1],
							'description'			=> $data[11],
							'category'				=> $data[2],
							'cost_price'			=> $data[4],
							'minimum_price'			=> $data[5],
							'unit_price'			=> $data[6],
							'reorder_level'			=> $data[11],
							'supplier_id'			=> $this->Supplier->exists($data[3]) ? $data[3] : NULL,
							'allow_alt_description'	=> $data[13] != '' ? '1' : '0',
							'is_serialized'			=> $data[14] != '' ? '1' : '0'
						);

						/* we could do something like this, however, the effectiveness of
						  this is rather limited, since for now, you have to upload files manually
						  into that directory, so you really can do whatever you want, this probably
						  needs further discussion  */

						$pic_file = $data[15];
						/*if(strcmp('.htaccess', $pic_file)==0)
						{
							$pic_file='';
						}*/
						$item_data['pic_filename'] = $pic_file;

						$item_number = $data[0];
						$invalidated = FALSE;
						if($item_number != '')
						{
							$item_data['item_number'] = $item_number;
							$invalidated = $this->Item->item_number_exists($item_number);
						}
					}
					else 
					{
						$invalidated = TRUE;
					}

					if(!$invalidated && $this->Item->save($item_data))
					{
						$items_taxes_data = NULL;
						//tax 1
						if(is_numeric($data[7]) && $data[6] != '')
						{
							$items_taxes_data[] = array('name' => $data[6], 'percent' => $data[7] );
						}

						//tax 2
						if(is_numeric($data[9]) && $data[8] != '')
						{
							$items_taxes_data[] = array('name' => $data[8], 'percent' => $data[9] );
						}

						// save tax values
						if(count($items_taxes_data) > 0)
						{
							$this->Item_taxes->save($items_taxes_data, $item_data['item_id']);
						}

						// quantities & inventory Info
						$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
						$emp_info = $this->Employee->get_info($employee_id);
						$comment ='Qty CSV Imported';

						$cols = count($data);

						// array to store information if location got a quantity
						$allowed_locations = $this->Stock_location->get_allowed_locations();
						for($col = 16; $col < $cols; $col = $col + 2)
						{
							$location_id = $data[$col];
							if(array_key_exists($location_id, $allowed_locations))
							{
								$item_quantity_data = array(
									'item_id' => $item_data['item_id'],
									'location_id' => $location_id,
									'quantity' => $data[$col + 1],
								);
								$this->Item_quantity->save($item_quantity_data, $item_data['item_id'], $location_id);

								$excel_data = array(
									'trans_items' => $item_data['item_id'],
									'trans_user' => $employee_id,
									'trans_comment' => $comment,
									'trans_location' => $data[$col],
									'trans_inventory' => $data[$col + 1]
								);
								
								$this->Inventory->insert($excel_data);
								unset($allowed_locations[$location_id]);
							}
						}

						/*
						 * now iterate through the array and check for which location_id no entry into item_quantities was made yet
						 * those get an entry with quantity as 0.
						 * unfortunately a bit duplicate code from above...
						 */
						foreach($allowed_locations as $location_id => $location_name)
						{
							$item_quantity_data = array(
								'item_id' => $item_data['item_id'],
								'location_id' => $location_id,
								'quantity' => 0,
							);
							$this->Item_quantity->save($item_quantity_data, $item_data['item_id'], $data[$col]);

							$excel_data = array(
								'trans_items' => $item_data['item_id'],
								'trans_user' => $employee_id,
								'trans_comment' => $comment,
								'trans_location' => $location_id,
								'trans_inventory' => 0
							);

							$this->Inventory->insert($excel_data);
						}
					}
					else //insert or update item failure
					{
						$failCodes[] = $i;
					}

					++$i;
				}

				if(count($failCodes) > 0)
				{
					$message = $this->lang->line('items_excel_import_partially_failed') . ' (' . count($failCodes) . '): ' . implode(', ', $failCodes);
					
					echo json_encode(array('success' => FALSE, 'message' => $message));
				}
				else
				{
					echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('items_excel_import_success')));
				}
			}
			else 
			{
				echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('items_excel_import_nodata_wrongformat')));
			}
		}
	}

	/**
	 * Guess whether file extension is not in the table field,
	 * if it isn't, then it's an old-format (formerly pic_id) field,
	 * so we guess the right filename and update the table
	 * @param $item the item to update
	 */
	private function _update_pic_filename($item)
	{
		$filename = pathinfo($item->pic_filename, PATHINFO_FILENAME);

		// if the field is empty there's nothing to check
		if(!empty($filename))
		{
			$ext = pathinfo($item->pic_filename, PATHINFO_EXTENSION);
			if(empty($ext))
			{
				$images = glob('./uploads/item_pics/' . $item->pic_filename . '.*');
				if(sizeof($images) > 0)
				{
					$new_pic_filename = pathinfo($images[0], PATHINFO_BASENAME);
					$item_data = array('pic_filename' => $new_pic_filename);
					$this->Item->save($item_data, $item->item_id);
				}
			}
		}
	}
	
	public function check_low_sell_item_name()
	{
		$exists = $this->Item->check_low_sell_item_name($this->input->post('items_id'));

		echo $exists ? 'true' : 'false';
	}
	
	public function calculate_vat()
	{
		$cost_price = $this->input->post('cost_price');
		$vat = (5 / 100) * $cost_price;
		$res = to_quantity_decimals(bcadd($cost_price, $vat));	  
		echo json_encode(array('result' => $res));
	}
	
	public function convert_text()
	{
		$text_english = $this->input->post('text_english');
		$this->arabic->load('Transliteration');
        $text_arabic = $this->arabic->en2ar($text_english);
		echo json_encode(array('result' => $text_arabic));
	}
}
?>