<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function()
{
	// when any filter is clicked and the dropdown window is closed
	$('#filters').on('hidden.bs.select', function(e) {
		table_support.refresh();
	});
	
	// load the preset datarange picker
	<?php $this->load->view('partial/daterangepicker'); ?>

	$("#daterangepicker").on('apply.daterangepicker', function(ev, picker) {
		table_support.refresh();
	});
	
	$("#engineer").change(function() {
    table_support.refresh();
    });
	
	$("#status").change(function() {
    table_support.refresh();
    });	
	
	$("#location").change(function() {
    table_support.refresh();
    });
	
	$("#pending").change(function() {
    table_support.refresh();
    });
	
	$("#onetime").change(function() {
    table_support.refresh();
    });
	
	$("#priority").change(function() {
    table_support.refresh();
    });
	
	  $('#generate_barcodes').click(function()
    {
        window.open(
            'index.php/services/generate_barcodes/'+table_support.selected_ids().join(':'),
            '_blank' // <- This is what makes it open in a new window.
        );
    });
	
	<?php $this->load->view('partial/bootstrap_tables_locale'); ?>

	table_support.init({
		resource: '<?php echo site_url($controller_name);?>',
		headers: <?php echo $table_headers; ?>,
		pageSize: <?php echo $this->config->item('lines_per_page'); ?>,
		uniqueId: 'order_id',
		onLoadSuccess: function(response) {
			if($("#table tbody tr").length > 1) {
				$("#table tbody tr:last t:first").html("");
			}
			$('a.rollover').imgPreview({
				imgCSS: { width: 200 },
				distanceFromCursor: { top:10, left:-210 }
			})
		},
		queryParams: function() {
			return $.extend(arguments[0], {
				start_date: start_date,
				end_date: end_date,
				engineer: $("#engineer").val(),
				status: $("#status").val(),
				location: $("#location").val(),
				pending: $("#pending").val(),
				onetime: $("#onetime").val(),
				priority: $("#priority").val() || [""]
			});
		}
	});
});
</script>
<?php $this->load->view('partial/print_receipt', array('print_after_sale'=>false, 'selected_printer'=>'takings_printer')); ?>

<div id="title_bar" class="print_hide btn-toolbar">
	<button onclick="javascript:printdoc()" class='btn btn-info btn-sm pull-right'>
		<span class="glyphicon glyphicon-print">&nbsp;</span><?php echo $this->lang->line('common_print'); ?>
	</button>
</div>

<div id="toolbar">
	<div class="pull-left form-inline" role="toolbar">
	        <button id="generate_barcodes" class="btn btn-default btn-sm print_hide" data-href='<?php echo site_url($controller_name."/generate_barcodes"); ?>' title='<?php echo $this->lang->line('items_generate_barcodes');?>'>
            <span class="glyphicon glyphicon-barcode">&nbsp</span><?php echo $this->lang->line("services_generate_barcodes"); ?>
        </button>
		
        <?php echo form_input(array('name'=>'daterangepicker', 'class'=>'form-control input-sm', 'id'=>'daterangepicker')); ?>
		<?php //echo form_multiselect('filters[]', $filters, '', array('id'=>'filters', 'data-none-selected-text'=>$this->lang->line('common_none_selected_text'), 'class'=>'selectpicker show-menu-arrow', 'data-selected-text-format'=>'count > 1', 'data-style'=>'btn-default btn-sm', 'data-width'=>'fit')); ?>		
		<?php echo form_dropdown('engineer', $engineers, '', array('id'=>'engineer', 'class'=>'selectpicker show-menu-arrow', 'data-style'=>'btn-default btn-sm', 'data-width'=>'fit')); ?>
		<?php echo form_dropdown('status', $available_status, '11', array('id'=>'status', 'class'=>'selectpicker show-menu-arrow', 'data-style'=>'btn-default btn-sm', 'data-width'=>'fit')); ?>
		<?php echo form_dropdown('location', $stock_locations, '100', array('id'=>'location', 'class'=>'selectpicker show-menu-arrow', 'data-style'=>'btn-default btn-sm', 'data-width'=>'fit')); ?>
		<?php echo form_dropdown('pending', $pendings, '', array('id'=>'pending', 'class'=>'selectpicker show-menu-arrow', 'data-style'=>'btn-default btn-sm', 'data-width'=>'fit')); ?>
		<?php echo form_dropdown('priority', $prioritys, '', array('id'=>'priority', 'class'=>'selectpicker show-menu-arrow', 'data-style'=>'btn-default btn-sm', 'data-width'=>'fit')); ?>
		<?php echo form_dropdown('onetime', $onetimes, '2', array('id'=>'onetime', 'class'=>'selectpicker show-menu-arrow', 'data-style'=>'btn-default btn-sm', 'data-width'=>'fit')); ?>
	</div>
</div>

<div id="table_holder">
	<table id="table"></table>
</div>

<div id="payment_summary">
</div>
<script type="text/javascript" src='https://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
<?php $this->load->view("partial/footer"); ?>