<?php
$this->arabic->load('Date');
$this->arabic->setMode(1);
$hdate = $this->arabic->date('l dS F Y', time());	
$data['hdate'] = $hdate;
$this->load->library('Pdf');
$this->load->library('Inva5');
$this->load->library('En');
$this->load->library('Ar');
$con = new convert();
$Money=new Currency();
$pdf = new PDF_Invoicea5( 'P', 'mm', 'A5', true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);
$pdf->setFooterData(array(0,64,0), array(0,64,128));
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->AddPage();

if($this->config->item('arabic_support'))
{
if($this->config->item('company_logo')) {$pdf->Image(base_url('uploads/' . $this->config->item('company_logo')), 58.5, 15, 25, 25, '', '', '', true, 150, '', false, false, 0, false, false, false);} 
$pdf->addCompany_ar( $this->config->item('company_ar'),
                  $this->config->item('address_ar'),
				  $this->config->item('phone'));		
}
else
{
if($this->config->item('company_logo')) {$pdf->Image(base_url('uploads/' . $this->config->item('company_logo')), 112.5, 10, 25, 25, '', '', '', true, 150, '', false, false, 0, false, false, false);} 
}
$pdf->addCompany( $this->config->item('company'),
                  $this->config->item('address'),
				  $this->config->item('phone'));	

				  
$pdf->head_formats("Receipt");
$pdf->watermark($this->config->item('company'));
//$pdf->addDate( $hdate, $transaction_time , "تاريخ ميلادي");
//$pdf->addHDate( $hdate, "تاريخ هجري");
$pdf->addHeader($this->lang->line('sales_id') , $sale_id, $transaction_time, $this->lang->line('employees_employee'), $employee);
$pdf->SetFont('helvetica', '', 11);
$style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false,
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 6,
    'stretchtext' => 6
);
$pdf->SetXY( $r1 + 64, $y1+43 );
$pdf->write1DBarcode($sale_id, 'C128A', '', '', '46', 15, 0.377, $style, 'N');

$pdf->SetFont('aefurat', '', 18);
//$pdf->addCustomer($this->lang->line('customers_customer') , $customer, $customer_vatno, $this->lang->line('sales_id'), $sale_id, $this->lang->line('employees_employee'), $employee);
//$pdf->adddates( $hdate, $transaction_time , Invoice);
    $order = 0;
	foreach($payments as $payment_id=>$payment)
	{  
	    $order = $order + 1;
	    $splitpayment=explode(':',$payment['payment_type']); $splitpayment[0];
		to_currency( $payment['payment_amount'] );
		$pdf->addpayment($payment['payment_type'], $payment['payment_amount'], $order );
	}

$pdf->SetFont('aefurat', '', 12);
if($this->config->item('arabic_support'))
{
    $pdf->customer_name( $first_name.' '.$last_name, '1' );
}
else
{
	$pdf->customer_name( $first_name.' '.$last_name, '0' );
}

$cols1=array("البند"    => 32,
             "كمية"     => 10,
             "السعر"  => 16,
             "خصم" => 12,
			 "إجمالي مبلغ" => 20,
			 "ضريبة" => 14,
             "إجمالي" => 24 );

$pdf->addColsar($cols1);
$pdf->SetFont( "dejavusans", "B", 9);
$cols=array( "ITEM"    => 32,
             "Qty"     => 10,
             "Price"  => 16,
             "Disc" => 12,
			 "Sub TOTAL" => 20,
			 "VAT" => 14,
             "TOTAL" => 24 );
$pdf->addCols( $cols);		 

$cols=array( "ITEM"    => "L",
             "Qty"     => "C",
             "Price"  => "C",
             "Disc" => "C",
			"Sub TOTAL" => "C",
			 "VAT" => "C",
             "TOTAL"          => "C" );

$pdf->SetFont('helvetica', '', 8);

$y    = 82;
foreach(array_reverse($cart, true) as $line=>$item)
	{
	
		$it_total = $item['discounted_total'];
		
		$x_tax = $item['taxed_rate'];;
		$n_tax = $item['quantity']*$x_tax;
		
		if($this->config->item('tax_included'))
		{
			$item_sub_total = $it_total-$n_tax;
		   	$item_total = $it_total;
		}
        else
		{
		    $item_sub_total = $it_total;
			$item_total = $it_total+$n_tax;
		}
		
	    $description = ($item['description'])? "\nDesc: ". $item['description']: '';
	    $serialnumber = ($item['serialnumber'])? "\nSerial: ". $item['serialnumber']: '';
   
	    $line = array("ITEM"    => $item['name'] .''. $description .''. $serialnumber,
		    "Qty"     => number_format($item['quantity'],0),
            "Price"  => $item['price'],
            "Disc" =>  ($item['discount_type']==FIXED)?$item['discount']:$item['discount'] . '%',
		    "Sub TOTAL" =>  number_format($item_sub_total,2),
			"VAT"     => number_format($item['taxed_rate']*$item['quantity'],2),
			"TOTAL" =>  number_format($item_total,2));
	    $size = $pdf->addLine( $y, $line );
        $y   += $size + 2;
	}
	

$pdf->addcurrency($con->convet(abs($total)), $Money->Sa($total));

$tax = ($total-$subtotal);
$pdf->addtotalcash(to_currency($subtotal), to_currency($tax), to_currency($total));
$pdf->returnpolicyboarder();

if($this->config->item('arabic_support'))
{
	$pdf->addpolicy($this->config->item('return_policy_ar'), 1);
}
else
{
	$pdf->addpolicy($this->config->item('return_policy'), 0);
}

$pdf->Output('Invoice.pdf', 'F');
$this->sale_lib->clear_all();
?>
<table align="center">
  <object height=1200px width=900px type="application/pdf" data="<?php echo base_url("Invoice.pdf?#zoom=100&scrollbar=0&toolbar=1&navpanes=1");?>" id="pdf_content">
  </object>
</table>