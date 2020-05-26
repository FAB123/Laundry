<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
	dialog_support.init("a.modal-dlg");
</script>


<div id="page_title"><?php echo $this->lang->line('reports_report_input'); ?></div>

<?php
if(isset($error))
{
	echo "<div class='alert alert-dismissible alert-danger'>".$error."</div>";
}
?>

<?php echo form_open('#', array('id'=>'item_form', 'enctype'=>'multipart/form-data', 'class'=>'form-horizontal')); ?>
	<div class="form-group form-group-sm">
		<?php echo form_label($this->lang->line('reports_date_range'), 'report_date_range_label', array('class'=>'control-label col-xs-2 required')); ?>
		<div class="col-xs-3">
				<?php echo form_input(array('name'=>'daterangepicker', 'class'=>'form-control input-sm', 'id'=>'daterangepicker')); ?>
		</div>
	</div>

	<?php	
	if (!empty($employees) && count($employees) > 1)
	{
	?>
	<div class="form-group form-group-sm" id="report_specific_input_data">
		<?php echo form_label($specific_input_name, 'specific_input_name_label', array('class'=>'required control-label col-xs-2')); ?>
		<div class="col-xs-3">
			<?php echo form_dropdown('specific_input_data', $employees, '-1', 'id="specific_input_data" class="form-control"'); ?>
		</div>
	</div>
	<?php
	}
	else
	{
		echo form_input(array('name' => 'specific_input_data', 'value' => $employees, 'type'=>'hidden', 'id' =>'specific_input_data'));
	}
	?>

	<?php	
	if (!empty($stock_locations) && count($stock_locations) > 1)
	{
	?>
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('reports_stock_location'), 'reports_stock_location_label', array('class'=>'required control-label col-xs-2')); ?>
			<div id='report_stock_location' class="col-xs-3">
				<?php echo form_dropdown('stock_location', $stock_locations, 'all', array('id'=>'location_id', 'class'=>'form-control')); ?>
			</div>
		</div>
	<?php
	}
	?>

	<?php
	echo form_button(array(
		'name'=>'generate_report',
		'id'=>'generate_report',
		'content'=>$this->lang->line('common_submit'),
		'class'=>'btn btn-primary btn-sm')
	);
	?>
<?php echo form_close(); ?>

<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript">
$(document).ready(function()
{
	<?php $this->load->view('partial/daterangepicker'); ?>

	$("#generate_report").click(function()
	{		
		window.location = [window.location, start_date, end_date, $("#specific_input_data").val(), $("#location_id").val() || 0 ].join("/");
	});
});
</script>
