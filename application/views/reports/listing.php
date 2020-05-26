<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
	dialog_support.init("a.modal-dlg");
</script>
<div class="app-title">
      <div>
          <h1><i class="fa fa-bar-chart"></i> <?php echo $this->lang->line("module_" . $controller_name) ?></h1>
      </div>
		
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><?php echo $this->lang->line("module_" . $controller_name) ?></li>
        </ul>
    </div>


<?php
if(isset($error))
{
	echo "<div class='alert alert-dismissible alert-danger'>".$error."</div>";
}
?>

<div class="row">
	<div class="col-md-4">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="glyphicon glyphicon-list">&nbsp</span><?php echo $this->lang->line('reports_summary_reports'); ?></h3>
			</div>
			<div class="list-group">
				<?php 
				foreach($grants as $grant) 
				{
					if (preg_match('/reports_/', $grant['permission_id']) && !preg_match('/(track|damages|inventory|receivings|cashonhands|taxfullreport|payable|receivables|taxgeneratereport)/', $grant['permission_id']))
					{
						show_report('summary', $grant['permission_id']);
					}
				}
				?>
			 </div>
		</div>
		
		<?php
		if ($this->Employee->has_grant('reports_inventory', $this->session->userdata('person_id')))
		{
		?>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><span class="glyphicon glyphicon-book">&nbsp</span><?php echo $this->lang->line('reports_inventory_reports'); ?></h3>
				</div>
				<div class="list-group">
				<?php 
				show_report('', 'reports_inventory_low');
				show_report('', 'reports_inventory_summary');
				?>
				</div>
			</div>
		<?php 
		}
		?>
	</div>

	<div class="col-md-4">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="glyphicon glyphicon-stats">&nbsp</span><?php echo $this->lang->line('reports_graphical_reports'); ?></h3>
			</div>
			<div class="list-group">
				<?php
				foreach($grants as $grant) 
				{
					if (preg_match('/reports_/', $grant['permission_id']) && !preg_match('/(track|damages|inventory|receivings|receivingtaxes|taxfullreport|cashonhands|payable|receivables|taxgeneratereport)/', $grant['permission_id']))
					{
						show_report('graphical_summary', $grant['permission_id']);
					}
				}
				?>
			 </div>
		</div>

		<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><span class="glyphicon glyphicon-book">&nbsp</span><?php echo $this->lang->line('reports_tax_reports'); ?></h3>
				</div>
				<div class="list-group">
				<?php 
				show_report('', 'reports_taxfullreport');
				show_report('', 'reports_taxgeneratereport');
				?>
				</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="glyphicon glyphicon-list-alt">&nbsp</span><?php echo $this->lang->line('reports_detailed_reports'); ?></h3>
			</div>
			<div class="list-group">
				<?php 			
				$person_id = $this->session->userdata('person_id');
				show_report_if_allowed('detailed', 'sales', $person_id);
				show_report_if_allowed('detailed', 'receivings', $person_id);
				show_report_if_allowed('specific', 'customer', $person_id, 'reports_customers');
				show_report_if_allowed('specific', 'discount', $person_id, 'reports_discounts');
				show_report_if_allowed('specific', 'employee', $person_id, 'reports_employees');
				?>
			 </div>
		</div>


		

		
		<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><span class="glyphicon glyphicon-book">&nbsp</span><?php echo $this->lang->line('reports_accounts'); ?></h3>
				</div>
				<div class="list-group">
				<?php 
				show_report('', 'reports_cash_flow');
				?>
				<?php 
				foreach($grants as $grant) 
				{
				if (preg_match('/reports_/', $grant['permission_id']) && !preg_match('/(track|damages|inventory|sales|categories|customers|discounts|employees|items|payments|receivingtaxes|suppliers|taxes|receivings|taxfullreport|taxgeneratereport)/', $grant['permission_id']))
					{
						show_report('summary', $grant['permission_id']);
					}
				}
				?>
				</div>
		</div>
		
		<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><span class="glyphicon glyphicon-book">&nbsp</span><?php echo $this->lang->line('reports_damages_warranty'); ?></h3>
				</div>
				<div class="list-group">
				<?php 
				foreach($grants as $grant) 
				{
				if (preg_match('/reports_/', $grant['permission_id']) && !preg_match('/(inventory|cashonhands|payable|receivables|sales|categories|customers|discounts|employees|items|payments|receivingtaxes|suppliers|taxes|receivings|taxfullreport|taxgeneratereport)/', $grant['permission_id']))
					{
						show_report('summary', $grant['permission_id']);
					}
				}
				?>
				</div>
		</div>
		
	</div>
</div>

<?php $this->load->view("partial/footer"); ?>
