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
				<h3 class="panel-title"><span class="glyphicon glyphicon-stats">&nbsp</span><?php echo $this->lang->line('account_information'); ?></h3>
			</div>
			<div class="list-group">
			    <a class="list-group-item" href="<?php echo site_url('accounts/accounts');?>"><?php echo $this->lang->line("module_accounts"); ?></a>
			</div>
			
			<div class="list-group">
			    <a class="list-group-item" href="<?php echo site_url('accounts/accounts_chart');?>"><?php echo $this->lang->line("account_chart_of_accounts"); ?></a>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="glyphicon glyphicon-list">&nbsp</span><?php echo $this->lang->line('account_cashflow'); ?></h3>
			</div>
			<div class="list-group">
                <a class="list-group-item" href="<?php echo site_url('accounts/cashflow');?>"><?php echo $this->lang->line("account_cashflow_tranfer"); ?></a> 
    		</div>
		</div>
	</div>
	
	<?php
	if ($this->Employee->has_grant('reports_cashonhands', $this->session->userdata('person_id')))
	{
	?>
	
	<div class="col-md-4">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="glyphicon glyphicon-list">&nbsp</span><?php echo $this->lang->line('reports_cashonhands'); ?></h3>
			</div>
			<div class="list-group">
                <a class="list-group-item" href="<?php echo site_url('reports/summary_cashonhands');?>"><?php echo $this->lang->line("reports_cashonhands"); ?></a> 
    		</div>
		</div>
	</div>

	<?php 
	}
	?>
		
</div>

<?php $this->load->view("partial/footer"); ?>
