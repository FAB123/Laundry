<?php $this->load->view("partial/header"); ?>



<div id="toolbar">
	<div class="pull-left form-inline" role="toolbar">
		<?php echo form_input(array('name'=>'daterangepicker', 'class'=>'form-control input-sm', 'id'=>'daterangepicker')); ?>
	</div>
</div>

<div id="table_holder">
	<table id="table"></table>
</div>

<div id="report_summary">
	<?php
	foreach($overall_summary_data as $name=>$value)
	{
	?>
		<div class="summary_row"><?php echo $this->lang->line('reports_'.$name). ': '.to_currency($value); ?></div>
	<?php
	}
	?>
</div>

<script type="text/javascript">
	$(document).ready(function()
	{
	 	<?php $this->load->view('partial/bootstrap_tables_locale'); ?>

		var details_data = <?php echo json_encode($details_data); ?>;
		<?php
		if($this->config->item('customer_reward_enable') == TRUE && !empty($details_data_rewards))
		{
		?>
			var details_data_rewards = <?php echo json_encode($details_data_rewards); ?>;
		<?php
		}
		?>
		
		<?php $this->load->view('partial/daterangepicker'); ?>

		$("#daterangepicker").on('apply.daterangepicker', function(ev, picker) {
	    	init_dialog();
    	});
		
		var init_dialog = function() {
			table_support.submit_handler('<?php echo site_url("sales/get_detailed1_" . $editable . "_row")?>');
			dialog_support.init("a.modal-dlg");
		};

		$('#table').bootstrapTable({
			columns: <?php echo transform_headers($headers['summary'], TRUE); ?>,
			stickyHeader: true,
			pageSize: <?php echo $this->config->item('lines_per_page'); ?>,
			striped: true,
			pagination: true,
			sortable: true,
			showColumns: true,
			uniqueId: 'id',
			showExport: true,
			exportDataType: 'all',
			exportTypes: ['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],
			data: <?php echo json_encode($summary_data); ?>,
			iconSize: 'sm',
			paginationVAlign: 'bottom',
			detailView: true,
			escape: false,
			onPageChange: init_dialog,
			onPostBody: function() {
				dialog_support.init("a.modal-dlg");
			},
			onExpandRow: function (index, row, $detail) {
				$detail.html('<table></table>').find("table").bootstrapTable({
					columns: <?php echo transform_headers_readonly($headers['details']); ?>,
					data: details_data[(!isNaN(row.id) && row.id) || $(row[0] || row.id).text().replace(/(POS|RECV)\s*/g, '')]
				});

				<?php
				if($this->config->item('customer_reward_enable') == TRUE && !empty($details_data_rewards))
				{
				?>
					$detail.append('<table></table>').find("table").bootstrapTable({
						columns: <?php echo transform_headers_readonly($headers['details_rewards']); ?>,
						data: details_data_rewards[(!isNaN(row.id) && row.id) || $(row[0] || row.id).text().replace(/(POS|RECV)\s*/g, '')]
					});
				<?php
				}
				?>
			}
		});

		init_dialog();
	});
</script>

<?php $this->load->view("partial/footer"); ?>