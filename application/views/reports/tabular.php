<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
	dialog_support.init("a.modal-dlg");
</script>

<div id="page_title"><?php echo $title ?></div>

<div id="page_subtitle"><?php echo $subtitle ?></div>

<div id="report_summary">
<?php
	if ($title == $this->lang->line('reports_cash_flow_report'))
	{
     	echo '<div class="summary_row">'. $report_title .'</div>';
	}
?>
</div>

<div id="table_holder">
	<table id="table"></table>
</div>


<div id="report_summary">
	<?php
	foreach($summary_data as $name => $value)
	{ 
	    if ($title == $this->lang->line('reports_cash_flow_report'))
	    {
     		$$name = $value;
	    }
	    else
	    {
	    	if($name == "total_quantity")
		    {
	        ?>
			    <div class="summary_row"><?php echo $this->lang->line('reports_'.$name) . ': ' .$value; ?></div>
         	<?php
		    }
		    else
	      	{
	        ?>
			    <div class="summary_row"><?php echo $this->lang->line('reports_'.$name) . ': ' . to_currency($value); ?></div>
	        <?php
	     	}
	    }
	}
	?>
	
	<?php 
	if ($title == $this->lang->line('reports_cash_flow_report'))
    {
	?>
	    <div class="summary_row"><?php echo $this->lang->line('reports_opening_balance_amount') . ': ' .to_currency($opening_balance_data); ?></div>
	    <div class="summary_row"><?php echo $this->lang->line('reports_debit_amount') . ': ' .to_currency($debit_amount); ?></div>
	    <div class="summary_row"><?php echo $this->lang->line('reports_credit_amount') . ': ' .to_currency($credit_amount); ?></div>
	    <div class="summary_row"><?php echo $this->lang->line('reports_balance_amount') . ': ' .to_currency($closing_balance_data); ?></div>
	<?php 
	
	}
	?>
</div>

<script type="text/javascript">
	$(document).ready(function()
	{
		<?php $this->load->view('partial/bootstrap_tables_locale'); ?>

		$('#table').bootstrapTable({
			columns: <?php echo transform_headers($headers, TRUE, FALSE); ?>,
			stickyHeader: true,
			pageSize: <?php echo $this->config->item('lines_per_page'); ?>,
			striped: true,
			sortable: true,
			showExport: true,
			exportDataType: 'all',
			exportTypes: ['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],
			pagination: true,
			showColumns: true,
			data: <?php echo json_encode($data); ?>,
			iconSize: 'sm',
			paginationVAlign: 'bottom',
			escape: false
		});

	});
</script>

<?php $this->load->view("partial/footer"); ?>
