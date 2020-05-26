<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
	dialog_support.init("a.modal-dlg");
</script>
 <div class="app-title">
      <div>
          <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
          <p><?php echo $this->lang->line('common_welcome_message'); ?></p>
        </div>
		
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h4><?php echo $this->lang->line('common_total_customers'); ?></h4>
              <p><b><?php echo $total_customers; ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-truck fa-3x"></i>
            <div class="info">
              <h4><?php echo $this->lang->line('common_total_receivings'); ?></h4>
              <p><b><?php echo $total_receivings; ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-tasks fa-3x"></i>
            <div class="info">
              <h4><?php echo $this->lang->line('common_total_items'); ?></h4>
              <p><b><?php echo $total_items; ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-shopping-cart fa-3x"></i>
            <div class="info">
              <h4><?php echo $this->lang->line('common_total_sales'); ?></h4>
              <p><b><?php echo $total_sales; ?></b></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Monthly Sales</h3>
            <div class="embed-responsive embed-responsive-16by9">
              <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Support Requests</h3>
            <div class="embed-responsive embed-responsive-16by9">
              <canvas class="embed-responsive-item" id="pieChartDemo"></canvas>
            </div>
          </div>
        </div>
      </div>
	  
	  <div id="office_module_list">
	<?php
	foreach($allowed_modules as $module)
	{
	?>
		<div class="module_item" title="<?php echo $this->lang->line('module_'.$module->module_id.'_desc');?>">
			<a href="<?php echo site_url("$module->module_id");?>"><img src="<?php echo base_url().'images/menubar/'.$module->module_id.'.png';?>" border="0" alt="Menubar Image" /></a>
			<a href="<?php echo site_url("$module->module_id");?>"><?php echo $this->lang->line("module_".$module->module_id) ?></a>
		</div>
	<?php
	}
	?>
</div>

 <script type="text/javascript" src="js/plugins/chart.js"></script>
    <script type="text/javascript">
      var data = {
      	labels: ["<?php echo $this->lang->line('common_total_customers'); ?>", "<?php echo $this->lang->line('common_total_items'); ?>", "<?php echo $this->lang->line('common_total_sales'); ?>", "<?php echo $this->lang->line('common_total_receivings'); ?>"],
      	datasets: [
      		{
      			label: "My Second dataset",
      			fillColor: "rgba(151,187,205,0.2)",
      			strokeColor: "rgba(151,187,205,1)",
      			pointColor: "rgba(151,187,205,1)",
      			pointStrokeColor: "#fff",
      			pointHighlightFill: "#fff",
      			pointHighlightStroke: "rgba(151,187,205,1)",
      			data: [<?php echo $total_customers; ?>, <?php echo $total_items; ?>, <?php echo $total_sales; ?>, <?php echo $total_receivings; ?>]
      		}
      	]
      };
      var pdata = [
      	{
      		value: <?php echo $total_receivings; ?>,
            color    : '#f56954',
            highlight: '#f56954',
      		label: "<?php echo $this->lang->line('common_total_receivings'); ?>"
      	},
      	{
      		value: <?php echo $total_sales; ?>,
            color    : '#f39c12',
            highlight: '#f39c12',
      		label: "<?php echo $this->lang->line('common_total_sales'); ?>"
      	},
		{
      		value: <?php echo $total_items; ?>,
            color    : '#3c8dbc',
            highlight: '#3c8dbc',
      		label: "<?php echo $this->lang->line('common_total_items'); ?>"
      	},
		{
      		value: <?php echo $total_customers; ?>,
            color    : '#d2d6de',
            highlight: '#d2d6de',
      		label: "<?php echo $this->lang->line('common_total_customers'); ?>"
      	}
	 ]
	 
		var pieOptions     = {
      
      segmentShowStroke    : true,
      segmentStrokeColor   : '#fff',  
      segmentStrokeWidth   : 2,
      percentageInnerCutout: 90, // This is 0 for Pie chart
      animationSteps       : 100,
      animationEasing      : 'easeOutBounce',
      animateRotate        : true,
      animateScale         : false,
      responsive           : true,
      maintainAspectRatio  : true,
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
   
      
      var ctxl = $("#lineChartDemo").get(0).getContext("2d");
      var lineChart = new Chart(ctxl).Line(data);
      
      var ctxp = $("#pieChartDemo").get(0).getContext("2d");
      var pieChart = new Chart(ctxp).Pie(pdata, pieOptions);
</script>

<?php $this->load->view("partial/footer"); ?>
