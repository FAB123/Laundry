<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Office extends Secure_Controller
{
	function __construct()
	{
		parent::__construct('office', NULL, 'office');
	}

	public function index()
	{
		$this->arabic->load('Date');
        $this->arabic->setMode(1);
        $hdate = $this->arabic->date('l dS F Y', time());	
		$data['hdate'] = $hdate;
		$this->load->view('home/office');
	}

	public function logout()
	{
		$this->Employee->logout();
	}
}
?>
