<?php
$this->arabic->load('Date');
$this->arabic->setMode(1);
$hdate = $this->arabic->date('l dS F Y', time());	
$data['hdate']        =    $hdate;
$this->load->library('Pdf');
$this->load->library('Inv');
$this->load->library('En');
$this->load->library('Ar');
$con = new convert();
$Money=new Currency();
$pdf = new PDF_Invoice( 'P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();
if($this->config->item('company_logo')) {$pdf->Image($this->Appconfig->get_logo_image(), 80, 5, 25, 23, 'JPG','', '', true, 150, '', false, false, 0, false, false, false);} 
$pdf->addSociete( $this->config->item('company_ar'),
                  $this->config->item('address_ar'),
				  $this->config->item('phone'),
                  $this->config->item('vat_no'));		  
$pdf->fact_dev("فاتورة نقدية");
$pdf->temporaire($this->config->item('company'));
$pdf->addDate( $transaction_time , "تاريخ ميلادي");
$pdf->addHDate( $hdate, "تاريخ هجري");
$pdf->SetFont('helvetica', '', 11);
$style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => true,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 4
);
$pdf->SetXY( $r1 + 111, $y1+42 );
$pdf->write1DBarcode($sale_id, 'C128A', '', '', '', 17, 0.417, $style, 'N');

$pdf->SetFont('aefurat', '', 18);
$pdf->addCustomer($this->lang->line('customers_customer') , $customer, $this->lang->line('sales_id'), $sale_id, Page, 1, $this->lang->line('employees_employee'), $employee);
	foreach($payments as $payment_id=>$payment)
	{  
	    $splitpayment=explode(':',$payment['payment_type']); $splitpayment[0];
		to_currency( $payment['payment_amount'] );
		$pdf->addpayment($payment['payment_type'], $payment['payment_amount'] );
	}
$cols1=array("البند"    => 70,
             "السعر"  => 24,
             "كمية"     => 14,
             "خصم" => 17,
			 "إجمالي مبلغ" => 22,
			 "ضريبة" => 18,
             "إجمالي" => 27 );

$pdf->addColsar($cols1);
$cols=array( "ITEM"    => 70,
             "Price"  => 24,
             "Qty"     => 14,
             "Disc" => 17,
			 "Sub TOTAL" => 22,
			 "VAT" => 18,
             "TOTAL" => 25 );
$pdf->addCols( $cols);		 

$cols=array( "ITEM"    => "L",
             "Price"  => "C",
             "Qty"     => "C",
             "Disc" => "C",
			"Sub TOTAL" => "C",
			 "VAT" => "C",
             "TOTAL"          => "C" );
$pdf->addLineFormat( $cols);
//$pdf->addLineFormat($cols);
$y    = 89;
foreach(array_reverse($cart, true) as $line=>$item)
	{
	
		 $it_total = $item['discounted_total'];
		 
		 $n_tax = $item['taxed_rate'];;
		 
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

	$line = array("ITEM"    => $item['name'] ."\n ". $item['description']."\n ". $item['serialnumber'],
               "Price"  => $item['price'],
               "Qty"     => number_format($item['quantity'],0),
               "Disc" =>  ($item['discount_type']==FIXED)?$item['discount']:$item['discount'] . '%',
			   "Sub TOTAL" =>  number_format($item_sub_total,2),
			   "VAT"     => number_format($item['taxed_rate'],2),
			   "TOTAL" =>  number_format($item_total,2));
			   
	$size = $pdf->addLine( $y, $line );
    $y   += $size + 2;

		}
$pdf->addCadreTVAs();

//$pdf->addreturn($this->config->item('return_policy'));
if (($total > 0)) 
		{ 
		$pdf->addcurrency($con->convet($total));
		}
		else
		{
		$newtotal = ($total*-1);
		$pdf->addcurrency($con->convet($newtotal));
		}
$pdf->addarcurrency($Money->Sa($total));
$tax = ($total-$subtotal);
$pdf->addCadreEurosFrancs(to_currency($subtotal), to_currency($tax), to_currency($total));
$pdf->addCadRP();
$pdf->addRemarque($this->config->item('return_policy'));
$pdf->Output('My-Pdf.pdf', 'F');
$this->sale_lib->clear_all();
?>
<table align="center">
  <object height=1200px width=900px type="application/pdf" data="<?php echo base_url("My-Pdf.pdf?#zoom=100&scrollbar=0&toolbar=1&navpanes=1");?>" id="pdf_content">
  </object>
</table>