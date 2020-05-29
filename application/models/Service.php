<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Supplier class
 */

class Service extends CI_Model
{
	const STATUS_BOOKED = 1;
	const STATUS_ASSIGNJOB = 2;
	const STATUS_PICKED = 3;
	const STATUS_DELIVERY = 4;
	const STATUS_RETURN = 5;
	const STATUS_JOB_DUMPED = 6;
	const STATUS_JOB_FINISH = 7;
	const STATUS_NO = 0;
    const STATUS_YES = 1;
	const STATUS_WORK_TYPE_TRASH = 0;
	const STATUS_WORK_TYPE_RUBBLE = 1;

	/*
	Determines if a given person_id is a customer
	*/
	public function exists($person_id)
	{
		$this->db->from('services_items');	
		$this->db->join('people', 'people.person_id = services_items.customer_id');
		$this->db->where('services_items.customer_id', $person_id);
		
		return ($this->db->get()->num_rows() == 1);
	}
    
	function count_all()
	{
		$this->db->from('services_items');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}
	
	/*
	Gets total of rows
	*/
	public function get_total_rows()
	{
		$this->db->from('services_items');
		$this->db->where('deleted', 0);

		return $this->db->count_all_results();
	}
	
	/*
	Returns all the suppliers
	*/
	public function get_all($limit_from = 0, $rows = 0)
	{
		$this->db->from('services_items');
		$this->db->join('people', 'services_items.customer_id = people.person_id');
		$this->db->where('deleted', 0);
		//$this->db->order_by('company_name', 'asc');
		if($rows > 0)
		{
			$this->db->limit($rows, $limit_from);
		}

		return $this->db->get();		
	}
	
	public function get_report($order_id)
	{
		$this->db->select('services_items_details.order_id AS order_id');
		$this->db->select('services_items_details.transfer_date AS transfer_date');
		$this->db->select('services_items_details.status AS status');
		$this->db->select('people.first_name AS first_name');
		$this->db->select('people.last_name AS last_name');
		
		$this->db->where('services_items_details.order_id', $order_id);
		$this->db->from('services_items_details AS services_items_details');
		//$this->db->join('services_items AS services_items', 'services_items_details.order_id = services_items.order_id', 'left');
		$this->db->join('people AS people', 'people.person_id = services_items_details.employee_id', 'left');

	
		$this->db->order_by('order_id', 'asc');
		return $this->db->get();		
	}
	
	/*
	Gets information about a particular supplier
	*/
	public function get_info($order_id)
	{
		$this->db->from('services_items AS services_items');
	    $this->db->join('services_payments AS services_payments', 'services_items.service_id = services_payments.receiving_id', 'left');
		$this->db->join('people AS people', 'people.person_id = services_items.customer_id', 'left');
		$this->db->where('services_items.order_id', $order_id);
		$query = $this->db->get();
		
		return $query->row();
	}
	
	/*
	Gets information about multiple suppliers
	*/
	public function get_multiple_info($order_ids)
	{
		$this->db->from('services_items');
		$this->db->join('people', 'people.person_id = services_items.customer_id');	
		//$this->db->where_in('suppliers.person_id', $suppliers_ids);
		$this->db->where_in('services_items.order_id', $order_ids);
		//$this->db->order_by('last_name', 'asc');

		return $this->db->get();
	}
	

 	
 	/*
	Get search suggestions to find suppliers
	*/
public function get_search_suggestions($search, $unique = FALSE, $limit = 25)
	{
		$suggestions = array();

		$this->db->from('services_items');
		$this->db->join('people', 'services_items.customer_id = people.person_id');
		$this->db->like('company', $search);
		$this->db->order_by('company', 'asc');
		foreach($this->db->get()->result() as $row)
		{
			$suggestions[] = array('value' => $row->order_id, 'label' => $row->company);
		}


		$this->db->from('services_items');
		$this->db->join('people', 'services_items.customer_id = people.person_id');
		$this->db->like('model', $search);
		$this->db->order_by('model', 'asc');
		foreach($this->db->get()->result() as $row)
		{
			$suggestions[] = array('value' => $row->order_id, 'label' => $row->model);
		}


		$this->db->from('services_items');
		$this->db->join('people', 'services_items.customer_id = people.person_id');
		$this->db->group_start();
			$this->db->like('first_name', $search);
			$this->db->or_like('last_name', $search); 
			$this->db->or_like('CONCAT(first_name, " ", last_name)', $search);
		$this->db->group_end();
		$this->db->order_by('last_name', 'asc');
		foreach($this->db->get()->result() as $row)
		{
			$suggestions[] = array('value' => $row->person_id, 'label' => $row->first_name . ' ' . $row->last_name);
		}

		if(!$unique)
		{
			$this->db->from('suppliers');
			$this->db->join('people', 'suppliers.person_id = people.person_id');
			$this->db->where('deleted', 0);
			$this->db->like('email', $search);
			$this->db->order_by('email', 'asc');
			foreach($this->db->get()->result() as $row)
			{
				$suggestions[] = array('value' => $row->person_id, 'label' => $row->email);
			}

			$this->db->from('suppliers');
			$this->db->join('people', 'suppliers.person_id = people.person_id');
			$this->db->where('deleted', 0);
			$this->db->like('phone_number', $search);
			$this->db->order_by('phone_number', 'asc');
			foreach($this->db->get()->result() as $row)
			{
				$suggestions[] = array('value' => $row->person_id, 'label' => $row->phone_number);
			}

			$this->db->from('suppliers');
			$this->db->join('people', 'suppliers.person_id = people.person_id');
			$this->db->where('deleted', 0);
			$this->db->like('account_number', $search);
			$this->db->order_by('account_number', 'asc');
			foreach($this->db->get()->result() as $row)
			{
				$suggestions[] = array('value' => $row->person_id, 'label' => $row->account_number);
			}
		}

		//only return $limit suggestions
		if(count($suggestions) > $limit)
		{
			$suggestions = array_slice($suggestions, 0, $limit);
		}

		return $suggestions;
	}

 	/*
	Gets rows
	*/
	public function get_found_rows($search, $onetime, $engineer, $location, $status, $pending, $priority, $filters)
	{
		return $this->search($search, $onetime, $engineer, $location, $status, $pending, $priority, $filters, 0, 0, 'services_items.service_id', 'desc', TRUE);
	}
	
	public function search($search, $onetime, $engineer, $location, $status, $pending, $priority, $filters, $rows = 0, $limit_from = 0, $sort = 'services_items.service_id', $order = 'asc', $count_only = FALSE)
	{
		// get_found_rows case
		if($count_only == TRUE)
		{
			$this->db->select('COUNT(DISTINCT services_items.service_id) AS count');
			
		}
		else
		{
			$this->db->select('services_items.service_id AS service_id');
			$this->db->select('MAX(services_items.order_id) AS order_id');
			$this->db->select('MAX(services_items.receiving_time) AS receiving_time');
			$this->db->select('MAX(services_items.start_date) AS start_date');
			$this->db->select('MAX(services_items.due_date) AS due_date');
			$this->db->select('MAX(services_items.work_type) AS work_type');

			$this->db->select('MAX(services_items.customer_id) AS customer_id');
			$this->db->select('MAX(services_items.location) AS location');
			$this->db->select('MAX(services_items.priority) AS priority');
			$this->db->select('MAX(services_items.shelf) AS shelf');
			$this->db->select('MAX(services_items.delivery) AS delivery');
			$this->db->select('MAX(services_items.status) AS status');
			$this->db->select('MAX(services_items.engineer_id) AS engineer_id');
			$this->db->select('MAX(stock_locations.location_name) AS location');
	
			$this->db->select('MAX(customers.person_id) AS person_id');
			$this->db->select('MAX(customers.company_name) AS company_name');
			$this->db->select('MAX(customers.deleted) AS deleted');
			
			$this->db->select('MAX(services_payments.payment_type) AS payment_type');
			
			$this->db->select('MAX(people.phone_number) AS phone_number');
			$this->db->select('MAX(people.first_name) AS first_name');
			$this->db->select('MAX(people.address_1) AS customer_location');
			$this->db->select('MAX(services_geo_location.latitude) AS latitude');
			$this->db->select('MAX(services_geo_location.longitude) AS longitude');
			$this->db->select('MAX(shelfs.shelf_name) AS shelf_name');
			$this->db->select('MAX(people.last_name) AS last_name');
			$this->db->select('MAX(engineers.first_name) AS en_first_name');
			$this->db->select('MAX(engineers.last_name) AS en_last_name');
		}

		$this->db->from('services_items AS services_items');
		$this->db->join('customers AS customers', 'customers.person_id = services_items.customer_id', 'left');
		$this->db->join('people AS people', 'people.person_id = services_items.customer_id', 'left');
		$this->db->join('shelfs AS shelfs', 'shelfs.shelf_id = services_items.shelf', 'left');
		$this->db->join('services_payments AS services_payments', 'services_payments.receiving_id = services_items.service_id', 'left');
		
		$this->db->join('services_geo_location AS services_geo_location', 'services_geo_location.order_id = services_items.order_id', 'left');
		
		$this->db->join('people AS engineers', 'engineers.person_id = services_items.engineer_id', 'left');
		$this->db->join('stock_locations AS stock_locations', 'services_items.location = stock_locations.location_id', 'left');

		if(empty($this->config->item('date_or_time_format')))
		{
			$this->db->where('DATE_FORMAT(receiving_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
		}
		else
		{
			$this->db->where('receiving_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
		}
		
		if(!empty($search))
		{
			$this->db->group_start();
			$this->db->like('people.first_name', $search);
			$this->db->or_like('people.last_name', $search);
			$this->db->or_like('service_id', $search);
			$this->db->or_like('order_id', $search);
			$this->db->or_like('engineers.first_name', $search);
			$this->db->or_like('engineers.first_name', $search);
			$this->db->or_like('date', $search);
			$this->db->or_like('people.phone_number', $search);
			$this->db->or_like('shelfs.shelf_name', $search);
			$this->db->or_like('defect', $search);
			$this->db->or_like('CONCAT(people.first_name, " ", people.last_name)', $search);
			$this->db->or_like('CONCAT(engineers.first_name, " ", engineers.last_name)', $search);
			$this->db->group_end();
		}
		
		if($status == 8)
		{
			$this->db->where('canceled', '1');
    		$this->db->where('delivery', '1');
		}
        else
		{
			if($status == 7)
		    {
		        $this->db->where('status', '7');
    		    $this->db->where('delivery', '1');
	        }	
            else
		    {
		      	if($status != 0)
		        {
			        $this->db->where('status', $status);
	         	}	

	        	if($pending != 10)
	        	{
	         		$this->db->where('delivery', $pending);
	        	}	
			
		    }			
				
	     	if($priority != 10)
	    	{
    			$this->db->where('priority', $priority);
    		}
		
    		if($location != 100)
	     	{
	    		$this->db->where('location', $location);
	    	}

	     	if($engineer != 0)
	    	{
	    		$this->db->where('engineer_id', $engineer);
	     	}
			
	     	if($onetime != 2)
	    	{
	    		$this->db->where('service_type', $onetime);
	     	}				
		}
		
		// get_found_rows case
		if($count_only == TRUE)
		{
			return $this->db->get()->row()->count;
		}

		
		$this->db->group_by('services_items.order_id');

		
		$this->db->order_by($sort, $order);

		if($rows > 0)
		{
			$this->db->limit($rows, $limit_from);
		}

		return $this->db->get();
	}
	
	public function get_geo_info($order_id)
	{
		$this->db->select('MAX(services_items.order_id) AS order_id');
		$this->db->select('MAX(services_items.service_id) AS service_id');
		$this->db->select('MAX(services_items.receiving_time) AS receiving_time');
		
		$this->db->select('MAX(services_payments.payment_type) AS payment_type');
		
		$this->db->select('MAX(people.phone_number) AS phone_number');
		$this->db->select('MAX(people.first_name) AS first_name');
		$this->db->select('MAX(people.address_1) AS customer_location');
		$this->db->select('MAX(services_geo_location.latitude) AS latitude');
		$this->db->select('MAX(services_geo_location.longitude) AS longitude');
			
		$this->db->from('services_items AS services_items');
		$this->db->join('services_payments AS services_payments', 'services_items.service_id = services_payments.receiving_id', 'left');
		$this->db->join('people AS people', 'people.person_id = services_items.customer_id', 'left');
		$this->db->join('services_geo_location AS services_geo_location', 'services_geo_location.order_id = services_items.order_id', 'left');
		$this->db->where('services_items.order_id', $order_id);
		$query = $this->db->get();
		
		return $query->row();
	}
	
	
	public function save_transfer(&$transfer_data, &$service_data, $service_id)
	{
			if($this->db->insert('services_transfer', $transfer_data))
			{
				$item_data['item_id'] = $this->db->insert_id();
				{
					$this->db->where('order_id', $service_id);
					$this->db->update('services_items', $service_data);
				}
				return TRUE;
			}
			return FALSE;
	}
	
	public function save_feedback(&$details_data, &$service_data, $service_id)
	{
			if($this->db->insert('services_items_details', $details_data))
			{
				$item_data['item_id'] = $this->db->insert_id();
				{
					$this->db->where('order_id', $service_id);
					$this->db->update('services_items', $service_data);
				}
				return TRUE;
			}
			return FALSE;
	}	
	
	public function save_despatch(&$details_data, &$service_data, &$shelf, $service_id)
	{
			if($this->db->insert('services_items_details', $details_data))
			{
				$item_data['item_id'] = $this->db->insert_id();
				{
					$this->db->where('order_id', $service_id);
					$this->db->update('services_items', $service_data);
					{
					  $this->db->where('shelf_id', $shelf);
					  $this->db->update('shelfs',  array('shelf_status' => 0, 'occupied_with'=>''));
					}
				}
				return TRUE;
			}
		return FALSE;
	}
	
	public function save_image(&$item_data, $order_id)
	{

        $success = TRUE;
		$this->db->trans_start();

		$this->db->delete('services_items_pics', array('image_id' => $order_id));

		if($item_data != NULL)
		{
			//$item_data['service_id'] = $service_id;
			$success &= $this->db->insert('services_items_pics', $item_data);
		}

		$this->db->trans_complete();

		$success &= $this->db->trans_status();

		return $success;
	}
	
	public function delete_image($order_id)
	{

        $success = TRUE;
		$this->db->trans_start();

		$this->db->delete('services_items_pics', array('image_id' => $order_id));

		$this->db->trans_complete();

		$success &= $this->db->trans_status();

		return $success;
	}
	
	public function save_actions(&$service_data, &$detailed_data, $service_id)
	{
		if($this->db->insert('services_items_details', $detailed_data))
    		{
     			$this->db->where('order_id', $service_id);
	    		$this->db->update('services_items', $service_data);
				return TRUE;
	     	}
			return FALSE;
	}
	
	public function save_actions_pay(&$payment_data, &$service_account_data)
	{
		if($this->db->insert('accounts', $payment_data))
   		{
			$this->db->insert('sales_accounts', $service_account_data);
		    return TRUE;
     	}
		return FALSE;
	}

	public function get_status()
	{
		return array(
			self::STATUS_BOOKED => $this->lang->line('status_waiting'),
			self::STATUS_PICKED => $this->lang->line('status_processing'),
			self::STATUS_ASSIGNJOB => $this->lang->line('status_processing'),
			self::STATUS_DELIVERY => $this->lang->line('status_processing'),
			self::STATUS_RETURN => $this->lang->line('status_processing'),
			self::STATUS_JOB_DUMPED => $this->lang->line('status_dumped'),
			self::STATUS_JOB_FINISH => $this->lang->line('status_processing')

		);
	}

	public function get_status_name($id)
	{
		if($id == self::STATUS_BOOKED)
		{
			return $this->lang->line('status_booked');
		}
		elseif($id == self::STATUS_ASSIGNJOB)
		{
			return $this->lang->line('status_work_assigned');
		}
		elseif($id == self::STATUS_PICKED)
		{
			return $this->lang->line('status_picked');
		}
		elseif($id == self::STATUS_DELIVERY)
		{
			return $this->lang->line('status_delivered');
		}
		elseif($id == self::STATUS_RETURN)
		{
			return $this->lang->line('status_returned');
		}		
		elseif($id == self::STATUS_JOB_DUMPED)
		{
			return $this->lang->line('status_container_dumped');
		}
		elseif($id == self::STATUS_JOB_FINISH)
		{
			return $this->lang->line('status_job_finished');
		}
	}
	
	public function get_alert_title($id)
	{
		if($id == self::STATUS_BOOKED)
		{
			return $this->lang->line('status_do_you_want_assign');
		}
		elseif($id == self::STATUS_ASSIGNJOB)
		{
			return $this->lang->line('status_do_you_want_pick');
		}
		elseif($id == self::STATUS_PICKED)
		{
			return $this->lang->line('status_do_you_want_delivery');
		}
		elseif($id == self::STATUS_DELIVERY)
		{
			return $this->lang->line('status_do_you_want_return');
		}
		elseif($id == self::STATUS_RETURN)
		{
			return $this->lang->line('status_do_you_want_dump');
		}
		elseif($id == self::STATUS_JOB_DUMPED)
		{
			return $this->lang->line('status_do_from_desk');
		}
		elseif($id == self::STATUS_JOB_FINISH)
		{
			return $this->lang->line('status_job_finished');
		}
		else
		{
			return $this->lang->line('status_job_error');
		}
	}
	
	public function get_product_status($id)
	{
		if($id == self::STATUS_YES)
		{
			return $this->lang->line('reports_delivered');
		}
		elseif($id == self::STATUS_NO)
		{
			return $this->lang->line('reports_pending');
		}
	}

	public function get_avaiablity($id)
	{
		if($id == self::STATUS_YES)
		{
			return $this->lang->line('status_yes');
		}
		elseif($id == self::STATUS_NO)
		{
			return $this->lang->line('status_no');
		}
	}
	
	public function get_warranty($id)
	{
		if($id == self::STATUS_YES)
		{
			return 'Y';
		}
		else
		{
			return 'N';
		}
	}

	public function get_processing_name()
	{
		return array(
			self::STATUS_ASSIGNJOB => $this->lang->line('status_assign_job'),
			self::STATUS_PICKED => $this->lang->line('status_processing1'),
			self::STATUS_ONL_ORDERD => $this->lang->line('status_order_online')
			);
	}
	
	public function get_wcf_name()
	{
		return array(
			self::STATUS_PICKED => $this->lang->line('status_processing1'),
			self::STATUS_ENG_REJECTED => $this->lang->line('status_reject'),
			self::STATUS_ONL_ORDERD => $this->lang->line('status_order_online'),
			self::STATUS_CUSTOMER_RESPOND => $this->lang->line('status_customer_respond')
			);
	}
	
	public function get_fix_name()
	{
		return array(
		    self::STATUS_CUSTOMER_RESPOND => $this->lang->line('status_customer_respond'),
			self::STATUS_ONL_ORDERD => $this->lang->line('status_order_online'),
			self::STATUS_FIXING => $this->lang->line('status_fixing')
			);
	}
	
	public function get_rep_name()
	{
		return array(
			self::STATUS_FIXING => $this->lang->line('status_fixing'),
			self::STATUS_PARTS_SEND => $this->lang->line('status_parts_send'),
			self::STATUS_PARTS_RECV => $this->lang->line('status_parts_recv'),
			self::STATUS_ONL_ORDERD => $this->lang->line('status_order_online'),
			self::STATUS_ENG_REJECTED => $this->lang->line('status_reject'),
			self::STATUS_FIXED => $this->lang->line('status_fixed')
			);
	}
	
    public function get_onsite_name()
	{
		return array(
		    self::STATUS_PICKED => $this->lang->line('status_processing1'),
			self::STATUS_FIXING => $this->lang->line('status_fixing'),
			self::STATUS_PARTS_SEND => $this->lang->line('status_parts_send'),
			self::STATUS_PARTS_RECV => $this->lang->line('status_parts_recv'),
			self::STATUS_ONL_ORDERD => $this->lang->line('status_order_online'),
			self::STATUS_ENG_REJECTED => $this->lang->line('status_reject'),
			self::STATUS_FIXED => $this->lang->line('status_fixed')
			);
	}
	
	public function get_desp_name()
	{
		return array(
			self::STATUS_FIXING => $this->lang->line('status_fixing'),
			self::STATUS_ONL_ORDERD => $this->lang->line('status_order_online'),
			self::STATUS_FIXED => $this->lang->line('status_fixed')
			);
	}
	
	public function get_feedback_name()
	{
		return array(
			self::STATUS_APPROVED => $this->lang->line('status_approved'),
			self::STATUS_ONL_ORDERD => $this->lang->line('status_order_online'),
			self::STATUS_CUS_REJECTED => $this->lang->line('status_reject')
			);
	}
	
	public function get_work_type($id)
	{
		if($id == self::STATUS_WORK_TYPE_TRASH)
		{
			return $this->lang->line('services_trash');
		}
		elseif($id == self::STATUS_WORK_TYPE_RUBBLE)
		{
			return $this->lang->line('services_rubble');
		}
	}
		
	public function get_online_status($order_id)
	{
		$this->db->select('MAX(services_items.cust_feedback) AS cust_feedback');
		$this->db->select('MAX(services_items.est_amount) AS est_amount');
		$this->db->select('MAX(services_items.remarks) AS remarks');
		$this->db->select('MAX(services_items.canceled) AS canceled');
		$this->db->select('MAX(services_items.order_id) AS order_id');
		$this->db->select('MAX(services_items.delivery) AS delivery');
		$this->db->select('MAX(services_items.desp_date) AS desp_date');
		$this->db->select('MAX(engineers.phone_number) AS phone_number');
		$this->db->select('MAX(services_items.status) AS status');
		$this->db->select('people.first_name AS first_name');
		$this->db->select('people.last_name AS last_name');
		$this->db->from('services_items AS services_items');
		//$this->db->join('people', 'people.person_id = suppliers.person_id');
		$this->db->where('services_items.order_id', $order_id);
		$this->db->join('people AS engineers', 'engineers.person_id = services_items.engineer_id', 'left');
		$this->db->join('people AS people', 'people.person_id = services_items.customer_id', 'left');
		$query = $this->db->get();
		if($query->num_rows() == 0)
		{
			return "nodata";
		}
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			$status_up_obj = new stdClass();

			foreach($this->db->list_fields('services_items') as $field)
			{
				$status_up_obj->$field = '';
			}

			return $status_up_obj;
		}
	}
	
	public function online_search($search)
	{
		$this->db->select('services_items.order_id AS order_id');
		$this->db->select('MAX(services_items.receiving_time) AS receiving_time');
		$this->db->select('MAX(services_items.company) AS company');
		$this->db->select('MAX(services_items.model) AS model');
		$this->db->select('MAX(services_items.status) AS status');
		$this->db->select('MAX(customers.person_id) AS person_id');
		$this->db->select('MAX(customers.company_name) AS company_name');
		$this->db->select('MAX(customers.deleted) AS deleted');
		$this->db->select('MAX(people.phone_number) AS phone_number');
		$this->db->from('services_items AS services_items');
		$this->db->join('customers AS customers', 'customers.person_id = services_items.customer_id', 'left');
		$this->db->join('people AS people', 'people.person_id = services_items.customer_id', 'left');
		//$this->db->join('people AS people_e', 'people.person_id = services_items.engineer_id', 'left');

		if(!empty($search))
		{
			$this->db->group_start();
			$this->db->like('phone_number', $search);
			$this->db->group_end();
		}
			
		$this->db->group_by('services_items.order_id');
		$this->db->where('delivery', 0);
		
		return $this->db->get();
	}
	
	public function approve($order_id)
	{
		$engineer_id = $this->get_engineer_id($order_id);
		$this->db->where('order_id', $order_id);
        $notification_data = array(
		        'trans_date' => date('Y-m-d H:i:s'),
				'comment_subject' => "Online Approved",
				'comment_text' => 'Order ID ' .$order_id,
				'order_id' => $order_id,
				'person_id' => $engineer_id,
				'icons' => '<i class="fa fa-circle fa-stack-2x text-success"></i><i class="fa fa-hdd-o fa-stack-1x fa-inverse"></i>');
		
		$details_data = array(
		    'transfer_date' => date('Y-m-d H:i:s'),
			'status' => 8,
			'order_id' => $order_id
		);
		$this->db->insert('notification', $notification_data);
		$this->db->insert('services_items_details', $details_data);
		$this->db->where('order_id', $order_id);
		return $this->db->update('services_items', array('status' => 8));
	}
	
	public function reject($order_id)
	{
		$engineer_id = $this->get_engineer_id($order_id);
		$this->db->where('order_id', $order_id);
        $notification_data = array(
				'comment_subject' => "Online Rejected",
				'comment_text' => 'Order ID ' .$order_id,
				'order_id' => $order_id,
				'person_id' => $engineer_id,
				'icons' => '<i class="fa fa-circle fa-stack-2x text-danger"></i><i class="fa fa-hdd-o fa-stack-1x fa-inverse"></i>');
	    $details_data = array(
		    'transfer_date' => date('Y-m-d H:i:s'),
			'status' => 9,
			'order_id' => $order_id
		);
		$this->db->insert('notification', $notification_data);
		$this->db->insert('services_items_details', $details_data);
		$this->db->where('order_id', $order_id);
		return $this->db->update('services_items', array('status' => 9));
	}
	
	public function get_engineer_id($order_id)
	{
		$this->db->from('services_items');
		$this->db->where('order_id', $order_id);
		return $this->db->get()->row()->engineer_id;
	}
	
	public function get_service_report($order_id)
	{
		$this->db->select('services_items.service_id AS service_id');
		$this->db->select('MAX(services_items.order_id) AS order_id');
		$this->db->select('MAX(services_items.receiving_time) AS receiving_time');
		$this->db->select('MAX(services_items.company) AS company');
		$this->db->select('MAX(services_items.model) AS model');
		$this->db->select('MAX(services_items.customer_id) AS customer_id');
		$this->db->select('MAX(services_items.serial) AS serial');
		$this->db->select('MAX(services_items.defect) AS defect');
		$this->db->select('MAX(services_items.b_toggle) AS b_toggle');
		$this->db->select('MAX(services_items.c_toggle) AS c_toggle');
		$this->db->select('MAX(services_items.bag_toggle) AS bag_toggle');
		$this->db->select('MAX(services_items.warranty_type) AS warranty_type');
		$this->db->select('MAX(services_items.location) AS location');
		$this->db->select('MAX(services_items.priority) AS priority');
		$this->db->select('MAX(services_items.delivery) AS delivery');
		$this->db->select('MAX(services_items.desp_date) AS desp_date');
		$this->db->select('MAX(services_items.feedback) AS feedback');
		$this->db->select('MAX(services_items.status) AS status');
		$this->db->select('MAX(services_items.engineer_id) AS engineer_id');
		$this->db->select('MAX(stock_locations.location_name) AS location');
		$this->db->select('MAX(customers.person_id) AS person_id');
		$this->db->select('MAX(customers.company_name) AS company_name');
		$this->db->select('MAX(customers.deleted) AS deleted');
			
		$this->db->select('MAX(people.phone_number) AS phone_number');
		$this->db->select('MAX(people.first_name) AS first_name');
		$this->db->select('MAX(shelfs.shelf_name) AS shelf_name');
		$this->db->select('MAX(people.last_name) AS last_name');
		
		$this->db->select('MAX(employee.first_name) AS em_first_name');
		$this->db->select('MAX(employee.last_name) AS em_last_name');
		$this->db->select('MAX(engineers.first_name) AS en_first_name');
		$this->db->select('MAX(engineers.last_name) AS en_last_name');
		$this->db->select('MAX(payments.amount) AS service_payment');
			
		$this->db->from('services_items AS services_items');
		$this->db->where('services_items.order_id', $order_id);
			
		$this->db->join('customers AS customers', 'customers.person_id = services_items.customer_id', 'left');
		$this->db->join('people AS people', 'people.person_id = services_items.customer_id', 'left');
		$this->db->join('people AS employee', 'employee.person_id = services_items.employee_id', 'left');
		$this->db->join('shelfs AS shelfs', 'shelfs.shelf_id = services_items.shelf', 'left');
		$this->db->join('payments AS payments', 'payments.order_id = services_items.order_id', 'left');
		$this->db->join('services_items_pics AS services_items_pics', 'services_items_pics.image_id = services_items.order_id', 'left');
		$this->db->join('people AS engineers', 'engineers.person_id = services_items.engineer_id', 'left');
		$this->db->join('stock_locations AS stock_locations', 'services_items.location = stock_locations.location_id', 'left');
			
		return $this->db->get();	
	}
	
	function show_sign($order_id)
	{
    $this->db->select('image');
    $this->db->from('services_items_sign');
    $this->db->where('order_id',$order_id);
    $this->db->where('last_used','1');
	
    return $this->db->get()->row()->image;
   }
   
   	public function save_sign($image_data, $order_id)
	{
		$this->db->trans_start();
			$this->db->where_in('order_id', $order_id);
			$success = $this->db->update('services_items_sign', array('last_used'=>0));
		$this->db->trans_complete();
		
		if($this->db->insert('services_items_sign', $image_data))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
   
   	function get_mobile($order_id)
	{
        $this->db->select('people.phone_number AS phone_number, people.first_name AS first_name, people.last_name AS last_name');
        $this->db->from('services_items AS services_items');
        $this->db->where('services_items.order_id',$order_id);
	    $this->db->join('people AS people', 'people.person_id = services_items.customer_id', 'left');
        return $this->db->get()->result_array();
    }
	
	public function save_otp($otp_data, $order_id)
	{
		$this->db->trans_start();
			$this->db->where_in('order_id', $order_id);
			$success = $this->db->update('otp', array('active'=>0));
		$this->db->trans_complete();
		
		if($this->db->insert('otp', $otp_data))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function check_otp_exists($otp, $order_id = '')
	{
		$query = $this->db->get_where('otp', array('order_id' => $order_id, 'otp' => $otp, 'active' => 1), 1);

		if($query->num_rows() == 1)
		{
			$row = $query->row();
			$this->db->where_in('otp', $otp);
			$this->db->where_in('order_id', $order_id);
			$this->db->update('otp', array('verified'=>1));
			return TRUE;
		}

		return FALSE;
	}	
	
	public function check_otp_verified($order_id = '')
	{
		$query = $this->db->get_where('otp', array('order_id' => $order_id, 'verified' => 1), 1);

		if($query->num_rows() == 1)
		{
			$row = $query->row();
			return TRUE;
		}

		return FALSE;
	}	
	
	public function check_otp_signs($order_id = '')
	{
		$query = $this->db->get_where('services_items_sign', array('order_id' => $order_id, 'last_used' => 1), 1);

		if($query->num_rows() == 1)
		{
			$row = $query->row();
			return TRUE;
		}

		return FALSE;
	}
	
	public function feedback_exists($order_id)
	{
		$this->db->from('services_feedback');	
		$this->db->where('order_id', $order_id);
		
		return ($this->db->get()->num_rows() == 1);
	}
	
	public function geo_map_exists($order_id)
	{
		$this->db->from('services_geo_location');	
		$this->db->where('order_id', $order_id);
		
		return ($this->db->get()->num_rows() == 1);
	}
	
	public function make_feedback($feedback, $order_id, $customer_feedback)
	{
		$success = false;
		if(!$this->feedback_exists($order_id))
		{
			$success = $this->db->insert('services_feedback', array('order_id' => $order_id, 'feedback' => $feedback));
			if ($success == true)
			{
				$this->db->where('order_id', $order_id);
			    $success = $this->db->update('services_items', array('cust_feedback' => $customer_feedback));
			}
		}
		else
		{
			$this->db->where('order_id', $order_id);
			$success = $this->db->update('services_feedback', array('feedback' => $feedback));
			if ($success == true)
			{
				$this->db->where('order_id', $order_id);
			    $success = $this->db->update('services_items', array('cust_feedback' => $customer_feedback));
			}
		}
		return $success;
	}	
	
	public function save_geo_location($order_id, $latitude, $longitude)
	{
		$success = false;
		if(!$this->geo_location_exists($order_id))
		{
			$success = $this->db->insert('services_geo_location', array('order_id' => $order_id, 'latitude' => $latitude, 'longitude' => $longitude));
		}
		else
		{
			$this->db->where('order_id', $order_id);
			$success = $this->db->update('services_geo_location', array('latitude' => $latitude, 'longitude' => $longitude));
		}
		return $success;
	}
	
	public function geo_location_exists($order_id)
	{
		$this->db->from('services_geo_location');	
		$this->db->where('order_id', $order_id);
		
		return ($this->db->get()->num_rows() == 1);
	}
	
	public function driver_actions($delivery, $status)
	{
	    $success = '1';
        if($delivery == 0)
	    {
		   if($status == 3 || $status == 4 || $status == 2 || $status == 5)
		    {
			   $success = '0';
		    }
	    }
	   
	   return $success;
	}
	
	public function admin_actions($delivery, $status)
	{
	    $success = '1';
        if($delivery == 0)
	    {
		   if($status == 1 || $status == 6)
		    {
			   $success = '0';
		    }
	    }
	   
	   return $success;
	}
	
	public function save_new_shelf(&$shelf_data, &$shelf, $order_id)
	{
		$this->db->where('order_id', $order_id);
		if($this->db->update('services_items', $shelf_data))
		{
			$this->db->where('shelf_id', $shelf);   	
			if($this->db->update('shelfs', array('shelf_status'=>1, 'occupied_with'=>$order_id)))
			{
				return TRUE;
			}
		}
		return FALSE;
	}	
	
	public function save_notification(&$subject, &$engineer_id, $order_id)
	{
        $priority_items_data = array(
			'trans_date' => date('Y-m-d H:i:s'),
			'comment_subject' => $subject,
			'comment_text' => 'Order ID ' .$order_id,
			'person_id' => $engineer_id,
			'order_id' => $order_id
		);
		
		if($this->db->insert('notification', $priority_items_data))
		{
			return TRUE;
		}
		return FALSE;
	}
	
	public function save_notification2($orders_id, $engineer_id)
	{
		$priority_items_data = array(
			'trans_date' => date('Y-m-d H:i:s'),
			'comment_subject' => "Customer Approvel Required",
			'comment_text' => 'Order ID ' .$orders_id,
			'order_id' => $orders_id,
			'person_id' => $engineer_id,
			'icons' => '<i class="fa fa-circle fa-stack-2x text-danger"></i><i class="fa fa-hdd-o fa-stack-1x fa-inverse"></i>');
		$this->db->insert('notification', $priority_items_data);
	}
	
	public function save_notification_alert($orders_id, $status, $engineer_id)
	{
		if ($status == 7)
		{
			$priority_items_data = array(
			'trans_date' => date('Y-m-d H:i:s'),
			'comment_subject' => "Customer Rejected",
			'comment_text' => 'Order ID ' .$orders_id,
			'order_id' => $orders_id,
			'person_id' => $engineer_id,
			'icons' => '<i class="fa fa-circle fa-stack-2x text-danger"></i><i class="fa fa-hdd-o fa-stack-1x fa-inverse"></i>');
		}
		elseif ($status == 3)
		{
			$priority_items_data = array(
			'trans_date' => date('Y-m-d H:i:s'),
			'comment_subject' => "Customer Approved",
			'comment_text' => 'Order ID ' .$orders_id,
			'order_id' => $orders_id,
			'person_id' => $engineer_id,
			'icons' => '<i class="fa fa-circle fa-stack-2x text-success"></i><i class="fa fa-hdd-o fa-stack-1x fa-inverse"></i>');		
		}
		$this->db->insert('notification', $priority_items_data);
	}
	
	public function get_due_date_color($due_date)
	{
		$date_formatter = date_create_from_format($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'), $due_date);
		$due_date = $date_formatter->format('Y-m-d H:i:s');
        $end_date = strtotime($due_date);  
        $interval = ($end_date - strtotime(date('Y-m-d H:i:s')))/60/60/24;
		
		if($interval < 1)
		{
			return '<p class="bg-gradient-primary text-danger text-justify font-weight-bold">'. $due_date .'</p>';
		}
		elseif($interval < 3)
		{
			return '<p class="bg-gradient-primary text-warning text-justify font-weight-bold">'. $due_date .'</p>';
		}
	    else
		{
		    return '<p class="bg-gradient-primary text-success text-justify font-weight-bold">'. $due_date .'</p>';
		}
	}
	
	public function get_start_date_color($start_date)
	{
		$date_formatter = date_create_from_format($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'), $start_date);
		$start_date = $date_formatter->format('Y-m-d H:i:s');
        $end_date = strtotime($start_date);  
        $interval = ($end_date - strtotime(date('Y-m-d H:i:s')))/60/60/24;
		if ($interval < 1)
		{
			$interval = 0;
		}
		if($interval < 1)
		{
			return '<p class="bg-gradient-primary text-success text-justify font-weight-bold">'. $start_date .'</p>';
		}
	    else
		{
		    return $start_date;
		}
	}
	
	public function get_payment_type($type)
	{
		if($type == 1)
		{
			return $this->lang->line('common_cash');
		}
		elseif($type == 2)
		{
			return $this->lang->line('common_debit');
		}
		elseif($type == 3)
		{
			return $this->lang->line('common_check');
		}
		elseif($type == 4)
		{
			return $this->lang->line('common_credit');
		}
		elseif($type == 5)
		{
			return $this->lang->line('receivings_delivery_time');
		}
	}
	
	public function get_payment_type_ar($type)
	{
		if($type == 1)
		{
			return $this->lang->line('common_cash_ar');
		}
		elseif($type == 2)
		{
			return $this->lang->line('common_debit_ar');
		}
		elseif($type == 3)
		{
			return $this->lang->line('common_check_ar');
		}
		elseif($type == 4)
		{
			return $this->lang->line('common_credit_ar');
		}
		elseif($type == 5)
		{
			return $this->lang->line('common_delivery_time_ar');
		}
	}

	public function get_proirity_color($order_id, $priority)
	{
		if($priority == '0')
		{
			return $order_id;
		}
		elseif($priority == '1')
		{
			return '<p class="text-warning">'. $order_id .'</p>';
		}
		elseif($priority == '2')
		{
			return '<p class="text-danger">'. $order_id .'</p>';
		}
	}
	
}
?>