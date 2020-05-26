<?php $this->load->view("partial/header"); ?>

<?php
if (isset($error_message))
{
	echo "<div class='alert alert-dismissible alert-danger'>".$error_message."</div>";
	exit;
}
?>

<?php if(!empty($customer_email)): ?>
	<script type="text/javascript">
		$(document).ready(function()
		{
			var send_email = function()
			{
				$.get('<?php echo site_url() . "/sales/send_pdf/" . $sale_id_num . "/quote"; ?>',
					function(response)
					{
						$.notify(response.message, { type: response.success ? 'success' : 'danger'} );
					}, 'json'
				);
			};

			$("#show_email_button").click(send_email);

			<?php if(!empty($email_receipt)): ?>
			send_email();
			<?php endif; ?>
		});
	</script>
<?php endif; ?>

<?php
	$this->load->view('partial/print_receipt', array('print_after_sale'=>$print_after_sale, 'selected_printer'=>'invoice_printer'));

	// Temporarily loads the system language for _lang to print invoice in the system language rather than user defined.
	load_language(TRUE,array('sales','common'));
?>


<div class="print_hide" id="control_buttons" style="text-align:right">
<?php 
$templates = $this->config->item(receipt_template);
if ($templates != receipt_pdf) 
 { ?>
<a href="javascript:printdoc();"><div class="btn btn-info btn-sm", id="show_print_button"><?php echo '<span class="glyphicon glyphicon-print">&nbsp</span>' . $this->lang->line('common_print'); ?></div></a> 
<?php } ?>

	
	<?php if(isset($customer_email) && !empty($customer_email)): ?>
		<a href="javascript:void(0);"><div class="btn btn-info btn-sm", id="show_email_button"><?php echo '<span class="glyphicon glyphicon-envelope">&nbsp</span>' . $this->lang->line('sales_send_quote'); ?></div></a>
	<?php endif; ?>
	<?php echo anchor("sales", '<span class="glyphicon glyphicon-shopping-cart">&nbsp</span>' . $this->lang->line('sales_register'), array('class'=>'btn btn-info btn-sm', 'id'=>'show_sales_button')); ?>
	<?php echo anchor("sales/discard_suspended_sale", '<span class="glyphicon glyphicon-remove">&nbsp</span>' . $this->lang->line('sales_discard'), array('class'=>'btn btn-danger btn-sm', 'id'=>'discard_quote_button')); ?>
</div>

<?php $this->load->view("invoice/" . $this->config->item('quote_template')); ?>
<?php $this->load->view("partial/footer"); ?>