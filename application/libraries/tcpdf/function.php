<?php
class convert
{ 
	function _construct()
	{
		$db = new DB_Class();	
	}
	public function convert_number($number) 
	{ 
		if (($number < 0) || ($number > 999999999)) 
		{ 
		throw new Exception("Number is out of range");
		} 
		$Gn = floor($number / 1000000);  /* Millions (giga) */ 
		$number -= $Gn * 1000000; 
		$kn = floor($number / 1000);     /* Thousands (kilo) */ 
		$number -= $kn * 1000; 
		$Hn = floor($number / 100);      /* Hundreds (hecto) */ 
		$number -= $Hn * 100; 
		$Dn = floor($number / 10);       /* Tens (deca) */ 
		$n = $number % 10;               /* Ones */ 
		$res = ""; 
		if ($Gn) 
		{ 
			$res .= $this->convert_number($Gn) . " Million"; 
		} 
		if ($kn) 
		{ 
			$res .= (empty($res) ? "" : " ") . 
				$this->convert_number($kn) . " Thousand"; 
		} 
		if ($Hn) 
		{ 
			$res .= (empty($res) ? "" : " ") . 
				$this->convert_number($Hn) . " Hundred"; 
		} 
		$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
			"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
			"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
			"Nineteen"); 
		$tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
			"Seventy", "Eigthy", "Ninety"); 

		if ($Dn || $n) 
		{ 
			if (!empty($res)) 
			{ 
				$res .= " and "; 
			} 
			if ($Dn < 2) 
			{ 
				$res .= $ones[$Dn * 10 + $n]; 
			} 
			else 
			{ 
				$res .= $tens[$Dn]; 
				if ($n) 
				{ 
					$res .= "-" . $ones[$n]; 
				} 
			} 
		} 
		if (empty($res)) 
		{ 
			$res = "zero"; 
		} 

		return $res; 
	} 
	
	public function convet($c)
	{
		$num2 = 0;
		if(strpos($c, ".") == TRUE)
		{
		$d = explode(".", $c);

			if($d[1] > 10)
			{
				//add 0 to front
				$r = round($c, 2);
				$d1 = explode(".", $r);
				if(empty($d1[1]))
				{
					$num2 = $this->convert_number($d1[0])." Riyal Only";
				}
				else
				{
					if(strlen($d1[1]) == 1)
					{
						$fd = $d1[1]."0";
						$num2 = $this->convert_number($d1[0])." Riyal ".$this->convert_number($fd)." Halala Only";
					}
					else
					{
						$num2 = $this->convert_number($d1[0])." Riyal ".$this->convert_number($d1[1])." Halala Only";
					}
				}
			}
			else
			{
			//add 0 to back
				$r = round($c, 2);
				$d1 = explode(".", $r);
				if(empty($d1[1]))
				{
					$num2 = $this->convert_number($d1[0])." Riyal Only";
				}
				else
				{				
					if(strlen($d1[1]) == 1)
					{
						$num2 = $d1[0].".".$d1[1]."0" ;
						$fd = $d1[1]."0";
						$num2 = $this->convert_number($d1[0])." Riyal ".$this->convert_number($fd)." Halala Only";
					}
					else
					{
						$num2 = $d1[0].".".$d1[1];
						$num2 = $this->convert_number($d1[0])." Riyal ".$this->convert_number($d1[1])." Halala Only";
					}
				}
			}
		}
		else
		{
			$num2 = $this->convert_number($c)." Riyal Only";
		}
		return $num2;
	}
}
?>