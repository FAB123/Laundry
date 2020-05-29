<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once("Secure_Controller.php");

class Services extends Secure_Controller
{
	public function __construct()
	{
		parent::__construct('services');
		$this->load->library('sms_lib');
	}

	public function index()
	{
		$data['table_headers'] = $this->xss_clean(get_services_manage_table_headers());
		$this->arabic->load('Date');
        $this->arabic->setMode(1);
        $hdate = $this->arabic->date('l dS F Y', time());	
		$data['hdate'] = $hdate;
		$data['available_status'] = array(
		    '0' => $this->lang->line('status_all'),
		   	'1' => $this->lang->line('status_booked'),
			'2' => $this->lang->line('status_assigned_job'),
			'3' => $this->lang->line('status_picked'),
			'4' => $this->lang->line('status_delivery'),
			'5' => $this->lang->line('status_return'),
			'6' => $this->lang->line('status_dumped'),
			'7' => $this->lang->line('status_job_finished'));
					
		$data['prioritys'] = array(
		    '10' => $this->lang->line('status_all'),
			'0' => $this->lang->line('service_normal'),
			'1' => $this->lang->line('service_fast'),
			'2' => $this->lang->line('services_ultra_fast'));
		
		$data['onetimes'] = array(
		    '2' => $this->lang->line('status_all'),
			'0' => $this->lang->line('services_type_onetime'),
			'1' => $this->lang->line('services_type_contract'));		
			
		$data['stock_locations'] = $this->Stock_location->get_allowed_locations();
        $data['stock_locations'][100] = $this->lang->line('status_all');
		$current_employee_id = $this->session->userdata('person_id');
        if($this->Employee->has_grant('services_alluser', $current_employee_id))
		{
			$data['engineers'] = array(0 => $this->lang->line('status_all'));
		    foreach($this->Employee->get_all_engineer()->result() as $engineer)
		    {
			    foreach(get_object_vars($engineer) as $property => $value)
			    {
				   $engineer->$property = $this->xss_clean($value);
			    }
			$data['engineers'][$engineer->person_id] = $engineer->first_name . ' ' . $engineer->last_name;
        	}
		}
		else
		{
			$data['engineers'] = array($current_employee_id => $this->lang->line('status_me'));
		}
		
		if($this->Employee->has_grant('services_accessdeliverd', $current_employee_id))
		{
		    $data['pendings'] = array(
		       '0' => $this->lang->line('services_pending'),
			   '1' => $this->lang->line('service_job_done'));	
		}
		else
		{
		    $data['pendings'] = array('0' => $this->lang->line('services_pending'));	
		}

		$this->load->view('service/manage', $data);
	}

	/*
	Gets one row for a supplier manage table. This is called using AJAX to update one row.
	*/
	public function get_row($row_id)
	{
		$data_row = $this->xss_clean(get_services_data_row($this->Service->get_info($row_id)));

		echo json_encode($data_row);
	}
	
	/*
	Returns Service table data rows. This will be called with AJAX.
	*/
	public function search()
	{
		$search = $this->input->get('search');
		$limit  = $this->input->get('limit');
		$offset = $this->input->get('offset');
		$sort   = $this->input->get('sort');
		$order  = $this->input->get('order');
		$engineer = $this->input->get('engineer');
		$location = $this->input->get('location');
		$status = $this->input->get('status');
		$pending = $this->input->get('pending');
		$onetime = $this->input->get('onetime');
		$priority = $this->input->get('priority');
				
		$filters  = array(
					'start_date' => $this->input->get('start_date'),
					'end_date' => $this->input->get('end_date'));

		$services = $this->Service->search($search, $onetime, $engineer, $location, $status, $pending, $priority, $filters, $limit, $offset, $sort, $order);
		$total_rows = $this->Service->get_found_rows($search, $onetime, $engineer, $location, $status, $pending, $priority, $filters);
		
		foreach($this->Employee->get_all_engineer()->result() as $engineer)
		{
			foreach(get_object_vars($engineer) as $property => $value)
			{
				$engineer->$property = $this->xss_clean($value);
			}

			$data['engineers'][$engineer->person_id] = $engineer->first_name . ' ' . $engineer->last_name;
		}

		$data_rows = array();
		foreach($services->result() as $service)
		{
			$row = $this->xss_clean(get_services_data_row($service));
			$row['priority'] = $this->xss_clean($this->Receiving->get_priority_name($row['priority']));
			$row['due_date'] = $this->xss_clean($this->Service->get_due_date_color($row['due_date']));
			$row['start_date'] = $this->xss_clean($this->Service->get_start_date_color($row['start_date']));
			//$row['service_status'] = $this->Service->get_status_name($row['status']);
			$data_rows[] = $row;
		}

		echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
	}
	
	/*
	Gives search suggestions based on what is being searched for
	*/
	public function suggest()
	{
		$suggestions = $this->xss_clean($this->Service->get_search_suggestions($this->input->get('term'), TRUE));

		echo json_encode($suggestions);
	}

	public function suggest_search()
	{
		$suggestions = $this->xss_clean($this->Service->get_search_suggestions($this->input->post('term'), FALSE));

		echo json_encode($suggestions);
	}
	
	public function view($service_id = -1)
	{
		$data['engineers'] = array();
		foreach($this->Employee->get_all_engineer()->result() as $engineer)
		{
			foreach(get_object_vars($engineer) as $property => $value)
			{
				$engineer->$property = $this->xss_clean($value);
			}

			$data['engineers'][$engineer->person_id] = $engineer->first_name . ' ' . $engineer->last_name;
		}
		
		$data['payment_options'] = get_payment_options();
		
		$info = $this->Service->get_info($service_id);
		foreach(get_object_vars($info) as $property => $value)
		{
			$info->$property = $this->xss_clean($value);
		}
		$data['service_info'] = $info;
		$this->load->view("service/update", $data);	
	}
	
	public function report($service_id = -1)
	{
		$data['engineers'] = array();
		foreach($this->Employee->get_all_engineer()->result() as $engineer)
		{
			foreach(get_object_vars($engineer) as $property => $value)
			{
				$engineer->$property = $this->xss_clean($value);
			}
			$data['engineers'][$engineer->person_id] = $engineer->first_name . ' ' . $engineer->last_name;
		}
        $data['reports'] = $this->Service->get_report($service_id)->result_array();

		$info = $this->Service->get_info($service_id);
		foreach(get_object_vars($info) as $property => $value)
		{
			$info->$property = $this->xss_clean($value);
		}
		$data['service_info'] = $info;
	    
		$this->load->view("service/report", $data);
	}
	
	public function transfer($service_id = -1)
	{
		$data['engineers'] = array();
		foreach($this->Employee->get_all_engineer()->result() as $engineer)
		{
			foreach(get_object_vars($engineer) as $property => $value)
			{
				$engineer->$property = $this->xss_clean($value);
			}

			$data['engineers'][$engineer->person_id] = $engineer->first_name . ' ' . $engineer->last_name;
		}

		$info = $this->Service->get_info($service_id);
		foreach(get_object_vars($info) as $property => $value)
		{
			$info->$property = $this->xss_clean($value);
		}
		$data['service_info'] = $info;
		//$data['categories'] = $this->Supplier->get_categories();

		$this->load->view("service/transfer", $data);
	}
	
	public function whatsapp_send($mobile, $first_name, $order_id)
	{
		$message = $this->config->item('wait_msg');
		$service_add = str_replace("==","",base64_encode($order_id));
		
		if($this->config->item('use_ahc_ddns'))
		{
		    $webadd = $this->config->item('web_add')."/7/". $service_add;
		}
		else
		{
			$webadd = $this->config->item('web_add')."/on/id/". $service_add;  
		}
		$replace = array('{CU}' => $first_name, '{CO}' => $this->config->item('company'), '{web_add}' => $webadd, '{ID}' => $order_id);
		$data['message'] = $this->get_msg($replace,$message);
		$data['mobile'] = $mobile;
		$data['first_name'] = $first_name;
		$data['company'] = $company;
		$data['order_id'] = $order_id;
		$this->load->view("service/whatsapp", $data);
	}
	
	public function save_transfer($service_id = -1)
	{
		$engineer_id = $this->xss_clean($this->input->post('engineer_id'));
		$description = $this->xss_clean($this->input->post('description'));
		$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		
		$transfer_data = array(
		    'transfer_date' => date('Y-m-d H:i:s'),
			'engineer_id' => $engineer_id,
			'employee_id' => $employee_id,
			'description' => $description,
			'order_id' => $service_id
		);

		$service_data = array(
			'engineer_id' => $engineer_id
		);

		if($this->Service->save_transfer($transfer_data, $service_data, $service_id))
		{
			$service_data = $this->xss_clean($service_data);
				echo json_encode(array('success' => TRUE,
								'message' => $this->lang->line('transfer_successful_updating') . ' ' . $service_data['company_name'],
								'id' => $service_id));
		}
		else//failure
		{
			$service_data = $this->xss_clean($service_data);

			echo json_encode(array('success' => FALSE,
							'message' => $this->lang->line('transfer_error_adding_updating') . ' ' . 	$service_data['company_name'],
							'id' => -1));
		}
	}
	
	public function save_actions($service_id = -1)
	{
		$status = $this->xss_clean($this->input->post('status'));
		$customer_id = $this->xss_clean($this->input->post('customer_id'));
		$engineer_id = $this->xss_clean($this->input->post('engineer_id'));
		$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;		
		
	if ($status == '1' || $status == '2' || $status == '4' || $status == '5')
	{
		if ($status == '1')
		{
			if (empty($engineer_id))
	     	{
			    $service_data = array(
			    'status' => '2'
		        );
	      	}
			else
	     	{
			    $service_data = array(
				'engineer_id' => $engineer_id,
			    'status' => '2'
		        );
				$subject = 'New Job Assigned';
				$this->Service->save_notification($subject, $engineer_id, $service_id);
	      	}
		}
		
		elseif ($status == '2')
		{
		    $service_data = array(
		    'status' => '3'
	        );
			$subject = 'New Work Picked';
			$this->Service->save_notification($subject, $engineer_id, $service_id);
		}
		
		elseif ($status == '4')
		{
		    $service_data = array(
		    'status' => '5'
	        );
			$subject = 'Container Returnd';
			$this->Service->save_notification($subject, $engineer_id, $service_id);
		}
		
		elseif ($status == '5')
		{
		    $service_data = array(
		    'status' => '6'
	        );
			$subject = 'Container Dumped';
			$this->Service->save_notification($subject, $engineer_id, $service_id);
		}
		
		$new_status = bcadd(1, $status);
		
		$detailed_data = array(
			'order_id' => $service_id,
			'transfer_date' => date('Y-m-d H:i:s'),
			'employee_id' => $employee_id,
		    'status' => $new_status
	        );
			
		if($this->Service->save_actions($service_data, $detailed_data, $service_id))
		{
    		$service_data = $this->xss_clean($service_data);
				echo json_encode(array('success' => TRUE,
								'message' => $this->lang->line('services_successful_updating') . ' ' . $service_data['status'],
								'id' => $service_id));
		}
		else//failure
		{
			$service_data = $this->xss_clean($service_data);

			echo json_encode(array('success' => FALSE,
							'message' => $this->lang->line('services_error_adding_updating') . ' ' . 	$service_data['status'],
							'id' => -1));
		}
	}
	elseif ($status == '3')
	{
	    $service_data = array(
	    'status' => '4',
	    'payed' => '1'
	    );
			
		$service_payment = $this->xss_clean($this->input->post('service_payment'));
		$payment_type = $this->xss_clean($this->input->post('payment_type'));
		if($payment_type != '4')
		{
			$payment_data = array(
    			'accounts' => $customer_id,
    			'thedate' => date('Y-m-d H:i:s'),
    			'description' => 'Payment From '. $service_id ,
	    		'employee_id' => $employee_id,
    			'type' => 'Service',
	    	    'debit_amount' => $service_payment,
    			'payment_type' => $payment_type
    	    );
			
			$service_account_data = array(
			    'thedate'=> date('Y-m-d H:i:s'),
				'description'=>'Payment From '.$service_id,
				'employee_id' => $employee_id,	
				'account_id' => $customer_id,		
				'credit_amount' => $service_payment,
				'payment_type' => $payment_type
			);
			
			$this->Service->save_actions_pay($payment_data, $service_account_data);
		}

		$new_status = bcadd(1, $status);
		
		$detailed_data = array(
			'order_id' => $service_id,
			'transfer_date' => date('Y-m-d H:i:s'),
			'employee_id' => $employee_id,
		    'status' => $new_status
	    );
		
		$subject = 'Container Deliverd';
		$this->Service->save_notification($subject, $engineer_id, $service_id);
			
		if($this->Service->save_actions($service_data, $detailed_data, $service_id))
	   	{
       		$service_data = $this->xss_clean($service_data);
			
			$data['transaction_time'] = date('Y-m-d H:i:s');
			$data['service_payment'] = $service_payment;
			$employees_info = $this->Employee->get_info($employee_id);
			$data['employees'] = $employees_info->first_name . ' ' . $employees_info->last_name;
			
			$info = $this->Service->get_info($service_id);
	     	foreach(get_object_vars($info) as $property => $value)
	     	{
	      		$info->$property = $this->xss_clean($value);
	       	}
	        $data['service_info'] = $info;
			$this->load->view('service/receipt', $data);

	   	}
	   	else//failure
	   	{
      		$service_data = $this->xss_clean($service_data);

       			echo json_encode(array('success' => FALSE,
							'message' => $this->lang->line('services_error_adding_updating') . ' ' . 	$service_data['status'],
							'id' => -1));
	    }
			
	}
	else
	{
		echo json_encode(array('success' => FALSE,
				'message' => $this->lang->line('services_error_adding_updating') . ' ' . 	$service_data['status'],
				'id' => -1));
	}
			
	}
	
	/*
	This deletes suppliers from the suppliers table
	*/
	public function delete()
	{
		$suppliers_to_delete = $this->xss_clean($this->input->post('ids'));

		if($this->Supplier->delete_list($suppliers_to_delete))
		{
			echo json_encode(array('success' => TRUE,'message' => $this->lang->line('suppliers_successful_deleted').' '.
							count($suppliers_to_delete).' '.$this->lang->line('suppliers_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success' => FALSE,'message' => $this->lang->line('suppliers_cannot_be_deleted')));
		}
	}
	
	public function generate_barcodes($order_ids)
	{
		$this->load->library('barcode_lib');
		$result = array();

		$order_ids = explode(':', $order_ids);
		foreach($order_ids as $order_id)
		{		
			$service = $this->Service->get_info($order_id);
			$recv_id = 'Recv '. $service->service_id;
			$result[] = array('company' => $service->company, 'model' =>  $service->model, 'recv_id' => $recv_id,
							'order_id' => $service->order_id, 'shelf' => $service->shelf, 'customer_phone' => $service->phone_number, 'customer_name' => $service->model, 'first_name' => $service->first_name, 'last_name' => $service->last_name, 'item_id' => $service->order_id);
		}

		$data['items'] = $result;
		$barcode_config = $this->barcode_lib->get_barcode_config();
		// in case the selected barcode type is not Code39 or Code128 we set by default Code128
		// the rationale for this is that EAN codes cannot have strings as seed, so 'KIT ' is not allowed
		if($barcode_config['barcode_type'] != 'Code39' && $barcode_config['barcode_type'] != 'Code128')
		{
			$barcode_config['barcode_type'] = 'Code128';
		}
		$data['barcode_config'] = $barcode_config;

		// display barcodes
		$this->load->view("barcodes/barcode_sheet", $data);
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
	
	public function get_msg(array $replace, $message)
	{
		return str_replace(array_keys($replace), array_values($replace), $message);
	}
	
	public function save_despatch($service_id = -1)
	{
		$status = $this->xss_clean($this->input->post('status'));
		$shelf = $this->xss_clean($this->input->post('shelf'));
		$feedback = $this->xss_clean($this->input->post('feedback'));
		$service_payment = $this->xss_clean($this->input->post('service_payment'));
		$employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
		
		$details_data = array(
		    'transfer_date' => date('Y-m-d H:i:s'),
			'employee_id' => $employee_id,
			'remarks' => $feedback,
			'status' => $status,
			'order_id' => $service_id
		);
		
	   $payment_data = array(
			'order_id' => $service_id,
			'amount' => $service_payment
		);

		$service_data = array(
			'status' => $status,
			'desp_date' => date('Y-m-d'),
			'desp_time' => date('H:i:s'),
			'delivery' => '1',
			'feedback' => $feedback
		);

		if($this->Service->save_despatch($details_data, $service_data, $payment_data, $shelf, $service_id))
		{
			$service_data = $this->xss_clean($service_data);
				echo json_encode(array('success' => TRUE,
								'message' => $this->lang->line('desk_successful_updating') . ' ' . $service_data['company_name'],
								'id' => $service_id));	
		}
		else//failure
		{
			$service_data = $this->xss_clean($service_data);

			echo json_encode(array('success' => FALSE,
							'message' => $this->lang->line('desk_error_adding_updating') . ' ' . 	$service_data['company_name'],
							'id' => -1));
		}
	}
	
	public function create_sign()
	{
		$order_id = $this->xss_clean($this->input->post('order_id'));
		require_once(APPPATH.'libraries/signature-to-image.php');
		$json = $this->xss_clean($this->input->post('Output'));
        $img =  sigJsonToImage($json, array('imageSize'=>array(200, 155), 'bgColour'=>'transparent'));
		
		define("WIDTH", 200);
        define("HEIGHT", 155);
		$dest_image = imagecreatetruecolor(WIDTH, HEIGHT);
		imagesavealpha($dest_image, true);
		$trans_background = imagecolorallocatealpha($dest_image, 0, 0, 0, 127);
		imagefill($dest_image, 0, 0, $trans_background);
		$background = imagecreatefrompng('seal.png');
		imagecopy($dest_image, $img, 0, 0, 0, 0, WIDTH, HEIGHT);
		imagecopy($dest_image, $background, 0, 0, 0, 0, WIDTH, HEIGHT);
		ob_start();
        imagepng($dest_image);
        $data = ob_get_clean();
		$data = $this->encryption->encrypt($data);
		$image_data = array(
			'order_id' => $order_id,
			'create_date' => date('Y-m-d H:i:s'),
			'image' => $data
		);
		
        imagedestroy($img);
		if($this->Service->save_sign($image_data, $order_id))
		{
			$new_sign = $data;
			echo json_encode(array('success' => '1', 'message' => $this->lang->line('desk_sign_created'), 'data' => $data));
		}
	    else
		{
		   	echo json_encode(array('success' => '0', 'message' => $this->lang->line('desk_sign_error')));
		}
	}
	
	public function view_sign($order_id)
	{
		$data = $this->Service->show_sign($order_id);
		$data = $this->encryption->decrypt($data);
	    return $data;
	}
	
    public function send_otp()
	{
        $order_id = $this->xss_clean($this->input->post('order_id'));
		if(!$order_id)
		{
			echo json_encode(array('success' => '0', 'message' => $this->lang->line('desk_otp_error_sended'), 'id' => $order_id));
		}
		else
		{
		    foreach($this->Service->get_mobile($order_id) as $customer)
		    {
			    $mobile = $customer['phone_number'];
			    $first_name = $customer['first_name'];
			    $last_name = $customer['last_name'];
		    }

		    $mobile = $this->config->item('calling_codes').''.$mobile;
		    $otp = random_chars();
		    $message = $this->config->item('otp_msg');
    		$replace = array('{FIRSTNNAME}' => $first_name, '{LASTNAME}' => $last_name, '{CO}' => $this->config->item('company'), '{OTP}' => $otp);
	     	$message = $this->get_msg($replace,$message);
        
	    	$otp_data = array(
		     	'order_id' => $order_id,
	     		'transaction_time' => date('Y-m-d H:i:s'),
		     	'mobile' => $mobile,
	     		'otp' => $otp
	       	);
		    if($this->Service->save_otp($otp_data, $order_id))
	    	{
		    	$this->sms_lib->Send_SMS($mobile, $message);
		    	echo json_encode(array('success' => '1', 'message' => $this->lang->line('desk_otp_sended'), 'id' => $order_id));
		    } 
	    	else
		    {
		    	echo json_encode(array('success' => '0', 'message' => $this->lang->line('desk_otp_error_sended'), 'id' => $order_id));
		    }
		}
	}
	
	public function ajax_check_otp()
	{
		$exists = $this->Service->check_otp_exists($this->input->post('send_otp'), $this->input->post('order_id'));

		echo $exists ? 'true' : 'false';
	}
	
	public function ajax_check_sign()
	{
		if($this->config->item('sign_priority') == 1)
		{
			$exists = $this->Service->check_otp_signs($this->input->post('order_id'));
		}
		else
		{
			$exists = TRUE;
		}
		echo $exists ? 'true' : 'false';
	}
	
	public function show_map($service_id = -1)
	{
		$info = $this->Service->get_geo_info($service_id);
		foreach(get_object_vars($info) as $property => $value)
		{
			$info->$property = $this->xss_clean($value);
		}
		
		$data['service_info'] = $info;
		$data['service_id'] = $service_id;
	    
		$this->load->view("service/show_map", $data);
	}
	
	public function reprint($service_id = -1)
	{
		$info = $this->Service->get_info($service_id);
	    foreach(get_object_vars($info) as $property => $value)
	    {
	    	$info->$property = $this->xss_clean($value);
	    }
	    $data['service_info'] = $info;
		$this->load->view('service/receipt', $data);	
	}
	
	public function change_shelf($service_id = -1)
	{
		$info = $this->Service->get_info($service_id);
		
		foreach(get_object_vars($info) as $property => $value)
		{
			$info->$property = $this->xss_clean($value);
		}
		
		if($info->shelf_type == '0')
		{
		    $data['shelfs'] = array(0 => $this->lang->line('shelfs_select_type'));
		    foreach($this->Item_name->get_all_available()->result_array() as $row)
		    {
			    $types[$this->xss_clean($row['item_id'])] = $this->xss_clean($row['item_name']);
		    }

		    $data['types'] = $types;
		    $data['types'][0] = $this->xss_clean($this->lang->line('shelfs_select_type'));
		}
	    else
		{
	        foreach($this->Shelf->get_all_available($info->shelf_type)->result_array() as $row)
		    {
		    	$shelfs[$this->xss_clean($row['shelf_id'])] = $this->xss_clean($row['shelf_name']);
	    	}
	    	$data['shelfs'] = $shelfs;
			$data['shelfs'][0] = $this->xss_clean($this->lang->line('shelfs_select_type'));
		}
	
		$data['service_info'] = $info;
		$this->load->view("service/change_shelf", $data);	
	}
	
	public function check_shelf()
	{
		$shelf = $this->xss_clean($this->input->post('shelf'));
		if($shelf == '0')
		{
			$exists = 'false';
		}
		echo !$exists ? 'true' : 'false';
	}
	
	public function save_new_shelf($order_id)
	{
		$shelf = $this->xss_clean($this->input->post('shelf'));
		$shelf_type = $this->xss_clean($this->input->post('shelf_type'));
		
		$shelf_data = array(
		   	'shelf' => $shelf,
	    	'shelf_type' => $shelf_type
	    );
		if($this->Service->save_new_shelf($shelf_data, $shelf, $order_id))
	    {
	    	echo json_encode(array('success' => '1', 'message' => $this->lang->line('desk_otp_sended'), 'id' => $order_id));
		} 
	    else
		{
		   	echo json_encode(array('success' => '0', 'message' => $this->lang->line('desk_otp_error_sended'), 'id' => $order_id));
		}
	}
}
?>
