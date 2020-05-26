<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Expenses_lib
{
	private $CI;

  	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function get_expenses_location()
	{
		if(!$this->CI->session->userdata('expenses_location'))
		{
			$location_id = $this->CI->Stock_location->get_default_location_id();
			$this->set_expenses_location($location_id);
		}

		return $this->CI->session->userdata('expenses_location');
	}

	public function set_expenses_location($location)
	{
		$this->CI->session->set_userdata('expenses_location',$location);
	}

	public function clear_expenses_location()
	{
		$this->CI->session->unset_userdata('expenses_location');
	}
}

?>
