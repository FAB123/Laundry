<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Home extends Secure_Controller 
{
	function __construct()
	{
		parent::__construct(NULL, NULL, 'home');
	}

	public function index()
	{
		$data['total_items']=$this->Item->count_all();
		$data['total_customers']=$this->Customer->count_all();
		$data['total_sales']=$this->Sale->count_all();
		$data['total_receivings']=$this->Receiving->count_all();
		$this->arabic->load('Date');
        $this->arabic->setMode(1);
        $hdate = $this->arabic->date('l dS F Y', time());	
		$data['hdate']        =    $hdate;
		$this->load->view("home/home",$data);
	}

	public function logout()
	{
		$this->Employee->logout();
	}

	/*
	Loads the change employee password form
	*/
	public function change_password($employee_id = -1)
	{
		$person_info = $this->Employee->get_info($employee_id);
		foreach(get_object_vars($person_info) as $property => $value)
		{
			$person_info->$property = $this->xss_clean($value);
		}
		$data['person_info'] = $person_info;

		$this->load->view('home/form_change_password', $data);
	}

	/*
	Change employee password
	*/
	public function save($employee_id = -1)
	{
		if($this->input->post('current_password') != '' && $employee_id != -1)
		{
			if($this->Employee->check_password($this->input->post('username'), $this->input->post('current_password')))
			{
				$employee_data = array(
					'username' => $this->input->post('username'),
					'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
					'hash_version' => 2
				);

				if($this->Employee->change_password($employee_data, $employee_id))
				{
					echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('employees_successful_change_password'), 'id' => $employee_id));
				}
				else//failure
				{
					echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('employees_unsuccessful_change_password'), 'id' => -1));
				}
			}
			else
			{
				echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('employees_current_password_invalid'), 'id' => -1));
			}
		}
		else
		{
			echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('employees_current_password_invalid'), 'id' => -1));
		}
	}
	
	public function utility()
	{
		$this->load->view('home/utility_form', $data);
	}
	
	public function convert_text()
	{
		$text_english = $this->input->post('text_english');
		$this->arabic->load('Transliteration');
        $text_arabic = $this->arabic->en2ar($text_english);
		echo json_encode(array('result' => $text_arabic));
	}
	
	public function calculate_number()
	{
		$calculate = $this->input->post('calculate');
		$num = preg_split("/[^0-9]+/", $calculate);
		$op = (array_filter(preg_split("/[0-9]+/", $calculate)));
		$a = $num[0];
		$res = 0;
		foreach ($op as $key => $val) {
			$b = $num[$key];
			$res = eval("return $a $val $b;");
			$a = $res;
		}		  
		echo json_encode(array('result' => $res));
	}
}
?>
