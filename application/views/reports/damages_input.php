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
	if (!empty($stock_locations) && count($stock_locations) > 1)
	{
	?>
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('reports_stock_location'), 'reports_stock_location_label', array('class'=>'required control-label col-xs-2')); ?>
			<div id='report_stock_location' class="col-xs-3">
				<?php echo form_multiselect('filters[]', $stock_locations, '', array('id'=>'filters', 'class'=>'form-control selectpicker', 'data-live-search'=>'true', 'data-none-selected-text'=>$this->lang->line('common_none_selected_text'), 'data-selected-text-format'=>'count > 1')); ?>
			</div>
		</div>
	<?php
	}
	?>

	<div class="form-group form-group-sm">
		<?php echo form_label($this->lang->line('reports_sale_type'), 'reports_sale_type_label', array('class'=>'required control-label col-xs-2')); ?>
		<div id='report_sale_type' class="col-xs-3">
			<?php echo form_dropdown('type',$types, '', 'id="type" class="form-control"'); ?>
		</div>
	</div>

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

		window.location = [window.location, start_date, end_date, $("#filters").val().join(':') || 0, $("#type").val() || 0].join("/");
	});
});

</script>
