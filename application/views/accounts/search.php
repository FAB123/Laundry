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
	<?php	
	if (isset($account_type_options))
	{
	?>
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('account_type'), 'reports_discount_type_label', array('class'=>'required control-label col-xs-2')); ?>
			<div id='report_discount_type' class="col-xs-3">
				<?php echo form_dropdown('account_type', $account_type_options, $this->config->item('default_sales_discount_type'), array('id'=>'account_type_id', 'class'=>'form-control selectpicker')); ?>
			</div>
		</div>
	<?php
	}
	?>

	<div class="form-group form-group-sm" id="report_specific_input_data">
		<?php echo form_label($this->lang->line('account_information'), 'specific_input_name_label', array('class'=>'required control-label col-xs-2')); ?>
		<div class="col-xs-3 supplier_data">
			<?php echo form_dropdown('specific_input_data', $specific_supplier_data, '', 'id="specific_input_data" class="form-control selectpicker" data-live-search="true"'); ?>
		</div>

		<?php	
		if (isset($account_type_options))
		{
		?>
		<div class="col-xs-3 customer_data">
			<?php echo form_dropdown('supplier_id', $specific_customer_data, '', 'id="supplier_id" class="form-control selectpicker" data-live-search="true"'); ?>
		</div>
		<?php
		}
		?>

	</div>

	    <?php
        if (count($stock_locations) > 1)
        {
	    ?>
		<div class="form-group form-group-sm">
			<?php echo form_label($this->lang->line('sales_stock_location'), 'reports_discount_type_label', array('class'=>'required control-label col-xs-2')); ?>
			<div id='report_discount_type' class="col-xs-3">
				<?php echo form_dropdown('stock_location', $stock_locations, $stock_location, array('id'=>'stock_location', 'class'=>'selectpicker show-menu-arrow', 'data-style'=>'btn-default btn-sm', 'data-width'=>'fit')); ?>
			</div>
		</div>
	    <?php
		}
		else
		{
			echo form_input(array('name' => 'stock_location', 'value' => $stock_location, 'type'=>'hidden', 'id' =>'stock_location'));
		}
        ?>
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
	<?php	
	if (isset($account_type_options))
	{
	?>
		$("#account_type_id").change(check_account_type).ready(check_account_type);
	<?php
	}
	?>

	<?php $this->load->view('partial/daterangepicker'); ?>

	$("#generate_report").click(function()
	{
		
		var specific_input_data = $('#specific_input_data').val();
		if(!$(".supplier_data").is(":visible")){
			specific_input_data = $('#supplier_id').val();
		}

		window.location = ['accounts', 'manage', $("#account_type_id").val() || 0, specific_input_data, $("#stock_location").val()].join("/");
	});
});

function check_account_type()
{
	var account_type = $("#account_type_id").val();

	if(account_type==0){
		$(".supplier_data").hide();
		$(".customer_data").show();
	}else{
		$(".supplier_data").show();
		$(".customer_data").hide();
	}
}
</script>
