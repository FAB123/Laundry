<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Item library
 *
 * Library with utilities to manage items
 */

class Tab_lib
{
	private $CI;

  	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function get_tab_location()
	{
		if(!$this->CI->session->userdata('tab_location'))
		{
			$tab_location = '#item';
			$this->set_tab_location($tab_location);
		}
		//elseif($this->CI->session->userdata('tab_location') == '.tab0')
	//	{
		//	$tab_location = '.tab1';
		//	$this->set_tab_location($tab_location);
		//}
		elseif($this->CI->session->userdata('tab_location') == '#item')
		{
			$tab_location = '.tab2';
			$this->set_tab_location($tab_location);
		}
		else
		{
			$tab_location = '#item';
			$this->set_tab_location($tab_location);
		}
		return $this->CI->session->userdata('tab_location');
	}

	public function set_tab_location($tab_location)
	{
		$this->CI->session->set_userdata('tab_location',$tab_location);
	}

	public function clear_tab_location()
	{
		$this->CI->session->unset_userdata('tab_location');
	}
}

?>
