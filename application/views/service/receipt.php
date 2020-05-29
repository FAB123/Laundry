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
            '<?php echo site_url() . "service/generate_arabic_bill/".$sale_id_num; ?>',
            '_self' // <- This is what makes it open in a new window.
        );
    });
	});
</script>

<?php $this->load->view('partial/print_receipt', array('print_after_sale'=>$print_after_sale, 'selected_printer'=>'receipt_printer')); ?>

<div class="print_hide" id="control_buttons" style="text-align:right">

<a href="javascript:printandroid();"><div class="btn btn-info btn-sm", id="show_print_button"><?php echo '<span class="glyphicon glyphicon-print">&nbsp</span>' . $this->lang->line('common_print'); ?></div></a> 
	<?php echo anchor("services", '<span class="glyphicon glyphicon-shopping-cart">&nbsp</span>' . $this->lang->line('services_back'), array('class'=>'btn btn-info btn-sm', 'id'=>'show_sales_button')); ?>
</div>

<?php $this->load->view("service/receipt_default"); ?>
	
<?php $this->load->view("partial/footer"); ?>