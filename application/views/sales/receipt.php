<?php $this->load->view("partial/header"); ?>

<?php
if (isset($error_message))
{
	echo "<div class='alert alert-dismissible alert-danger'>".$error_message."</div>";
	exit;
}
?>

<script type="text/javascript">
	$(document).ready(function()
	{
    	$('#generate_arabic_bill').click(function()
        {
        window.open(
            '<?php echo site_url() . "sales/generate_arabic_bill/".$sale_id_num; ?>',
            '_self' // <- This is what makes it open in a new window.
        );
    });
	});
</script>

<?php if(!empty($customer_email)): ?>
	<script type="text/javascript">
	$(document).ready(function()
	{
		var send_email = function()
		{
			$.get('<?php echo site_url() . "/sales/send_receipt/" . $sale_id_num; ?>',
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

<?php $this->load->view('partial/print_receipt', array('print_after_sale'=>$print_after_sale, 'selected_printer'=>'receipt_printer')); ?>

<div class="print_hide" id="control_buttons" style="text-align:right">
<?php 
$templates = $this->config->item(receipt_template);
    if ($templates != receipt_pdf)
    { 
    if($_SERVER['HTTP_X_REQUESTED_WITH'] == "com.ahcjed.salestime") { ?>
            <a href="javascript:printandroid();"><div class="btn btn-info btn-sm", id="show_print_button"><?php echo '<span class="glyphicon glyphicon-print">&nbsp</span>' . $this->lang->line('common_print'); ?></div></a> 
	<?php 
	}
	else
	{
		?>
		<a href="javascript:printdoc();"><div class="btn btn-info btn-sm", id="show_print_button"><?php echo '<span class="glyphicon glyphicon-print">&nbsp</span>' . $this->lang->line('common_print'); ?></div></a> 
	<?php
	}
} ?>
	
	<?php if(!empty($customer_email)): ?>
		<a href="javascript:void(0);"><div class="btn btn-info btn-sm", id="show_email_button"><?php echo '<span class="glyphicon glyphicon-envelope">&nbsp</span>' . $this->lang->line('sales_send_receipt'); ?></div></a>
	<?php endif; ?>
	<button id="generate_arabic_bill" class="btn btn-info btn-sm print_hide" data-href='<?php echo site_url($controller_name."/generate_arabic_bill"); ?>' title='<?php echo $this->lang->line('sales_generate_arabic_bill');?>'>
        <span class="glyphicon glyphicon-barcode">&nbsp</span><?php echo $this->lang->line("sales_generate_arabic_bill"); ?>
    </button>
	<?php echo anchor("sales", '<span class="glyphicon glyphicon-shopping-cart">&nbsp</span>' . $this->lang->line('sales_register'), array('class'=>'btn btn-info btn-sm', 'id'=>'show_sales_button')); ?>
	<?php echo anchor("sales/manage", '<span class="glyphicon glyphicon-list-alt">&nbsp</span>' . $this->lang->line('sales_takings'), array('class'=>'btn btn-info btn-sm', 'id'=>'show_takings_button')); ?>
</div>

<?php
    if($this->Employee->has_grant('sales_pdfprint', $this->Employee->get_logged_in_employee_info()->person_id))
	{
        $this->load->view("invoice/receipt_pdf_no_discount"); 
	}
    else
    {
        if(!$print_as_pdf)
        {
	        $this->load->view("invoice/" . $this->config->item('receipt_template'));
        }
        else
        {
            $this->load->view("invoice/receipt_pdf_no_discount"); 
        }
	}
?>
<?php $this->load->view("partial/footer"); ?>