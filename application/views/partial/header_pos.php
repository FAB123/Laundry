<!DOCTYPE html>
<html lang="en">
  <head>
   <title><?php echo $this->config->item('company') . ' | ' . $this->lang->line('common_powered_by') . ' SalesTime ' . $this->config->item('application_version') ?></title>
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<base href="<?php echo base_url();?>" />
   
   <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script src="js/jquery-3.2.1.min.js"></script>
   <script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>
   
	<link rel="stylesheet" type="text/css" href="dist/jquery-ui/jquery-ui.min.css"/>

   	<?php $this->load->view('partial/header_js'); ?>
	<?php $this->load->view('partial/lang_lines'); ?>
		<style type="text/css">
		html {
			overflow: auto;
		}
	</style>
