<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reg_lib
{
	private $CI;

  	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function reg_key()
	{
		ob_start();
        system('ipconfig /all');
        $mycom=ob_get_contents();
        ob_clean();
        $findme = "Physical";
        $pmac = strpos($mycom, $findme);
        $address=substr($mycom,($pmac+36),17);
		$address = base64_encode($address);
		$address = preg_replace("/[^a-zA-Z0-9]/", "", $address);
		return $address;
	}
	
	public function check($key_file ='')
	{
		$address = $this->reg_key();
		$address = $this->crypter($address);
		if (empty($key_file))
		{
		    $key_file = $this->CI->Appconfig->get('version_info');
		}
		
		if($address != $key_file)
		{
			$datediff = $this->check_version();
			if ($datediff <= 15)
			{
				//redirect('home/'.$datediff);
				return $address;
			}
		    return FALSE;
		}
		else
		{
			return $address;
		}
	}
	public function crypter($data)
	{
		$this->CI->load->helper('security');
		$data = do_hash($data, 'md5');
		return $data;
	}
	
	public function check_version()
	{
		$now = time();
		if(!$this->CI->Appconfig->get('version_code'))
		{
			$c_time = base64_encode($now);
			$batch_save_data = array(
		    'version_code' => $c_time);
		    $result = $this->CI->Appconfig->batch_save($batch_save_data);
		}
		$version_time = $this->CI->Appconfig->get('version_code');
		$version_time = base64_decode($version_time);
		
        $datediff = $now - $version_time;
        $datediff = round($datediff / (60 * 60 * 24));
		return $datediff;
	}
	
}

?>
