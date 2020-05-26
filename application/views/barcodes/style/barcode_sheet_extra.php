<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $this->lang->line('items_generate_barcodes'); ?></title>
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
	<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/barcode.css" />
</head>

<body>
	<div id='barcode-con'>
		<div class="barcode">
			<?php
			$count = 0;
			$multi = 1;
			foreach($items as $item)
			{
				for($i=1; $i<=$counts; $i++){					
					if ($barcode_config['barcode_method'] * $multi == $count and $count != 0)
					{
						echo "</div><div class='clearfix'></div><div class='barcode'>";
						++$multi;
					}
					echo $this->barcode_lib->display_barcode_style($item, $barcode_config);
					++$count;
				}
			}
			?>
		</div>
	</div>
</body>

</html>
