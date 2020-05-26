<script type="text/javascript">
function printdoc()
{
	// install firefox addon in order to use this plugin
	if (window.jsPrintSetup)
	{
		// set top margins in millimeters
		jsPrintSetup.setOption('marginTop', '');
		jsPrintSetup.setOption('marginLeft', '');
		jsPrintSetup.setOption('marginBottom', '');
		jsPrintSetup.setOption('marginRight', '');

					// set page header
			jsPrintSetup.setOption('headerStrLeft', '');
			jsPrintSetup.setOption('headerStrCenter', '');
			jsPrintSetup.setOption('headerStrRight', '');
					// set empty page footer
			jsPrintSetup.setOption('footerStrLeft', '');
			jsPrintSetup.setOption('footerStrCenter', '');
			jsPrintSetup.setOption('footerStrRight', '');
		
		var printers = jsPrintSetup.getPrintersList().split(',');
		// get right printer here..
		for(var index in printers) {
			var default_ticket_printer = window.localStorage && localStorage['invoice_printer'];
			var selected_printer = printers[index];
			if (selected_printer == default_ticket_printer) {
				// select epson label printer
				jsPrintSetup.setPrinter(selected_printer);
				// clears user preferences always silent print value
				// to enable using 'printSilent' option
				jsPrintSetup.clearSilentPrint();
									// Suppress print dialog (for this context only)
					jsPrintSetup.setOption('printSilent', 1);
								// Do Print
				// When print is submitted it is executed asynchronous and
				// script flow continues after print independently of completetion of print process!
				jsPrintSetup.print();
			}
		}
	}
	else
	{
		//window.print();
		printandroid();
	}
}


function printandroid()
{
	Android.printBTs(<?php echo $sale_id_num; ?>);
}

<?php
if($print_after_sale)
{
?>
	$(window).load(function()
	{
		// executes when complete page is fully loaded, including all frames, objects and images
		printdoc();

		// after a delay, return to sales view
		setTimeout(function () {
				window.location.href = "<?php echo site_url('sales'); ?>";
			}, <?php echo $this->config->item('print_delay_autoreturn') * 1000; ?>);
	});
<?php
}
?>
</script>
