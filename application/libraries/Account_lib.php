<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account_lib
{
	private $CI;

  	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function get_account_location()
	{
		if(!$this->CI->session->userdata('account_location'))
		{
			$location_id = $this->CI->Stock_location->get_default_location_id();
			$this->set_account_location($location_id);
		}

		return $this->CI->session->userdata('account_location');
	}

	public function set_account_location($location)
	{
		$this->CI->session->set_userdata('account_location',$location);
	}

	public function clear_account_location()
	{
		$this->CI->session->unset_userdata('account_location');
	}
}

?>
