<!DOCTYPE html>
<html lang="en">
  <head>
   <title><?php echo $this->config->item('company') . ' | ' . $this->lang->line('common_powered_by') . ' SalesTime ' . $this->config->item('application_version') ?></title>
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<base href="<?php echo base_url();?>" />
    <!-- Main CSS-->

    <!-- Font-icon css-->
   <link rel="stylesheet" type="text/css" href="<?php echo 'dist/themes/' . (empty($this->config->item('theme')) ? 'default' : $this->config->item('theme')) . '/main.css' ?>"/>
   <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
   <link rel="stylesheet" type="text/css" href="dist/bootstrap.min.css">
	<?php if ($this->input->cookie('debug') == 'true' || $this->input->get('debug') == 'true') : ?>
		<!-- bower:css -->
		<link rel="stylesheet" href="bower_components/jquery-ui/themes/base/jquery-ui.css" />
		<link rel="stylesheet" href="bower_components/bootstrap3-dialog/dist/css/bootstrap-dialog.min.css" />
		<link rel="stylesheet" href="bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.css" />
		<link rel="stylesheet" href="bower_components/smalot-bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" />
		<link rel="stylesheet" href="bower_components/bootstrap-select/dist/css/bootstrap-select.css" />
		<link rel="stylesheet" href="bower_components/bootstrap-table/src/bootstrap-table.css" />
		<link rel="stylesheet" href="bower_components/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.css" />
		<link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css" />
		<link rel="stylesheet" href="bower_components/chartist/dist/chartist.min.css" />
		<link rel="stylesheet" href="bower_components/chartist-plugin-tooltip/dist/chartist-plugin-tooltip.css" />
		<link rel="stylesheet" href="bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" />
		<link rel="stylesheet" href="bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" />
		<!-- endbower -->
		<!-- start css template tags -->
		<link rel="stylesheet" type="text/css" href="css/bootstrap.autocomplete.css"/>
		<link rel="stylesheet" type="text/css" href="css/invoice.css"/>
		<link rel="stylesheet" type="text/css" href="css/pos.css"/>
		<link rel="stylesheet" type="text/css" href="css/pos_print.css"/>
		<link rel="stylesheet" type="text/css" href="css/popupbox.css"/>
		<link rel="stylesheet" type="text/css" href="css/receipt.css"/>
		<link rel="stylesheet" type="text/css" href="css/register.css"/>
		<link rel="stylesheet" type="text/css" href="css/reports.css"/>
		<!-- end css template tags -->
		<!-- bower:js -->
		<script src="bower_components/jquery/dist/jquery.js"></script>
		<script src="bower_components/jquery-form/src/jquery.form.js"></script>
		<script src="bower_components/jquery-validate/dist/jquery.validate.js"></script>
		<script src="bower_components/jquery-ui/jquery-ui.js"></script>
		<script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>
		<script src="bower_components/bootstrap3-dialog/dist/js/bootstrap-dialog.min.js"></script>
		<script src="bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.js"></script>
		<script src="bower_components/smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
		<script src="bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
		<script src="bower_components/bootstrap-table/src/bootstrap-table.js"></script>
		<script src="bower_components/bootstrap-table/dist/extensions/export/bootstrap-table-export.js"></script>
		<script src="bower_components/bootstrap-table/dist/extensions/mobile/bootstrap-table-mobile.js"></script>
		<script src="bower_components/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.js"></script>
		<script src="bower_components/moment/moment.js"></script>
		<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
		<script src="bower_components/file-saver.js/FileSaver.js"></script>
		<script src="bower_components/html2canvas/build/html2canvas.js"></script>
		<script src="bower_components/jspdf/dist/jspdf.min.js"></script>
		<script src="bower_components/jspdf-autotable/dist/jspdf.plugin.autotable.js"></script>
		<script src="bower_components/tableExport.jquery.plugin/tableExport.min.js"></script>
		<script src="bower_components/chartist/dist/chartist.min.js"></script>
		<script src="bower_components/chartist-plugin-axistitle/dist/chartist-plugin-axistitle.min.js"></script>
		<script src="bower_components/chartist-plugin-pointlabels/dist/chartist-plugin-pointlabels.min.js"></script>
		<script src="bower_components/chartist-plugin-tooltip/dist/chartist-plugin-tooltip.min.js"></script>
		<script src="bower_components/chartist-plugin-barlabels/dist/chartist-plugin-barlabels.min.js"></script>
		<script src="bower_components/remarkable-bootstrap-notify/bootstrap-notify.js"></script>
		<script src="bower_components/js-cookie/src/js.cookie.js"></script>
		<script src="bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js"></script>
		<script src="bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
		<!-- endbower -->
		<!-- start js template tags -->
		<script type="text/javascript" src="js/imgpreview.full.jquery.js"></script>
		<script type="text/javascript" src="js/manage_tables.js"></script>
		<script type="text/javascript" src="js/nominatim.autocomplete.js"></script>
		<!-- end js template tags -->
	<?php else : ?>
		<!--[if lte IE 8]>
		<link rel="stylesheet" media="print" href="dist/print.css" type="text/css" />
		<![endif]-->
		<!-- start mincss template tags -->
		<link rel="stylesheet" type="text/css" href="dist/jquery-ui/jquery-ui.min.css"/>
		
		<link rel="stylesheet" type="text/css" href="dist/pos.min.css?rel=88039333a5"/>
		<link rel="stylesheet" type="text/css" href="css/register.css"/>
		
	   <link rel="stylesheet" type="text/css" href="css/pace.css">
				<!-- end mincss template tags -->
		<!-- start minjs template tags -->
		<script type="text/javascript" src="dist/pos.min.js?rel=fddb87c1d6"></script>
		<script type="text/javascript" src="js/plugins/sweetalert.min.js"></script>		
		<!-- end minjs template tags -->
	<?php endif; ?>
   	<?php $this->load->view('partial/header_js'); ?>
	<?php $this->load->view('partial/lang_lines'); ?>
		<style type="text/css">
		html {
			overflow: auto;
		}
	</style>
	
	<style>
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(images/loader/<?php echo $this->config->item('spinner'); ?>/preloader.svg) center no-repeat #fff;
}
</style>

<script>
	$(window).load(function() {
		$(".se-pre-con").fadeOut("slow");;
	});
</script>

  </head>
  <script type="text/javascript">
	dialog_support.init("a.modal-dlg");
</script>

<?php 
$host= gethostname();
$ip = gethostbyname($host);     
?>
<!--
 <body class="app sidebar-mini sidenav-toggled rtl"> 
  <body class="app sidebar-mini sidenav-toggled rtl"> -->
 <body class="app sidebar-mini sidebar-collapse rtl"> 
  <div class="se-pre-con"></div>
  
  
  
  
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="<?php echo base_url();?>">SalesTime</a>
        <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <h3 class="app-company"><?php echo implode(' ', array_slice(explode(' ', $this->config->item('company')), 0, 1)); ?></h3>
	    <h3 id="liveclock"><?php echo date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat')) ?></h3>
	    <h3 class="app-clock-arabic"><?php echo $hdate; ?></h3>
      <ul class="app-nav">
	    <li class="app-search">
          <input class="app-search__input" type="search" placeholder="<?php echo 'Server IP :' .$ip; ?>">
        </li>

        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li> <a href="<?php echo 'home/change_password/'.$user_info->person_id; ?>" class="modal-dlg" data-btn-submit="<?php echo $this->lang->line('common_submit'); ?>" title="<?php echo $this->lang->line('employees_change_password'); ?>"><i class="fa fa-cog fa-lg"></i>&nbsp<?php echo $this->lang->line('employees_change_password'); ?></a></li>        
			<li> <a href="home/utility/" class="modal-dlg" data-btn-cancel="<?php echo $this->lang->line('common_close'); ?>" title="<?php echo $this->lang->line('home_utility'); ?>"><i class="fa fa-cog fa-lg"></i>&nbsp<?php echo $this->lang->line('home_utility'); ?></a></li>        
            <li><a class="dropdown-item" href="home/logout"><i class="fa fa-sign-out fa-lg"></i> <?php echo  $this->lang->line('common_logout'); ?></a></li>
          </ul>
        </li>
		</ul>
    </header>
	  
	  
	  
	  
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="images/48.jpg" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"><?php echo $user_info->first_name . ' ' . $user_info->last_name;?></p>
         </div>
      </div>
      <ul class="app-menu">
	        		<?php foreach($allowed_modules as $module): ?>
							<li><a href="<?php echo site_url("$module->module_id"); ?>"  class="app-menu__item <?php echo $module->module_id == $this->uri->segment(1) ? 'active' : ''; ?>">
							<i class="app-menu__icon fa fa-<?php echo $module->icon; ?>"></i>
									<span class="app-menu__label"><?php echo $this->lang->line("module_" . $module->module_id) ?></span>
								</a></li>					
		        <?php endforeach; ?>
	   </ul>
    </aside>
    <main class="app-content">