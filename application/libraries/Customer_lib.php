<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_lib
{
	private $CI;

  	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function get_customer_location()
	{
		if(!$this->CI->session->userdata('customer_location'))
		{
			$location_id = $this->CI->Stock_location->get_default_location_id();
			$this->set_customer_location($location_id);
		}

		return $this->CI->session->userdata('customer_location');
	}

	public function set_customer_location($location)
	{
		$this->CI->session->set_userdata('customer_location',$location);
	}

	public function clear_customer_location()
	{
		$this->CI->session->unset_userdata('customer_location');
	}
}

?>
