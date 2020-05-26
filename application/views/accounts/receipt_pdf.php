<?php
$this->load->view("partial/header");
$this->arabic->load('Date');
$this->arabic->setMode(1);
$hdate = $this->arabic->date('l dS F Y', time());	
$data['hdate'] = $hdate;
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

if($this->config->item('company_logo')) {$pdf->Image(base_url('uploads/' . $this->config->item('company_logo')), 92.5, 5, 25, 25, '', '', '', true, 150, '', false, false, 0, false, false, false);} 
$pdf->addaddress( $this->config->item('company'),
                  $this->config->item('address'),
				  $this->config->item('phone'),
                  $this->config->item('vat_no'));
				  
$pdf->addaddress_ar( $this->config->item('company_ar'),
                  $this->config->item('address_ar'),
				  $this->config->item('phone'),
                  $this->config->item('vat_no'));		

$pdf->company_watermark($this->config->item('company'));

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
    'bgcolor' => false,
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 4
);

$pdf->adddates( $hdate, $payment_info->thedate , ($mode == 0 ? 'CPAY '.$trans_id : 'SPAY '.$trans_id));

$pdf->SetFont('aefurat', '', 12);

	$cols1=array("شخص"    => 75,
             "مقدار الأجر"  => 35,
             "رصيد" => 35,
			 "رواية" => 40 );

    $pdf->addColsar($cols1);
    $pdf->SetFont( "dejavusans", "B", 9);
    $cols=array( "Party"    => 75,
             "Pay Amount"  => 35,
             "Balance" => 35,
			 "Narration" => 40 );
    $pdf->addCols( $cols);		 

    $cols=array( "Party"    => "L",
             "Pay Amount"  => "C",
             "Balance" => "C",
			"Narration" => "C" );
	$pdf->addLineFormat( $cols);
	
	$pdf->SetFont('aefurat', '', 12);

    $y    = 89;
	
	$line = array("Party"    => $payment_info->accounts_first_name.' '.$payment_info->accounts_last_name,
        "Pay Amount"  => number_format($payment_info->amount,2),
        "Balance" =>  number_format($balance_amount,2),
		"Narration" =>  $payment_info->notes);
	$pdf->addLine( $y, $line );


$pdf->addCashBoarder();

$pdf->addarcurrency($Money->Sa($payment_info->amount));

$pdf->addreceipttotalcash(to_currency($payment_info->amount));
$pdf->receiptsign();
$pdf->addcurrency($con->convet(abs($payment_info->amount)));

//$pdf->addpolicy($this->config->item('return_policy'), $this->config->item('return_policy_ar'));
$pdf->Output('Invoice.pdf', 'F');
?>
<table align="center">
  <object height=1200px width=900px type="application/pdf" data="<?php echo base_url("Invoice.pdf?#zoom=100&scrollbar=0&toolbar=1&navpanes=1");?>" id="pdf_content">
  </object>
</table>
<?php $this->load->view("partial/footer"); ?>