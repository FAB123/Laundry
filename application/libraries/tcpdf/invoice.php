<?php

// Xavier Nicolay 2004
// Version 1.02

class PDF_Invoice extends TCPDF
{
// private variables
var $colonnes;
var $format;
var $angle=0;

// private functions
function RoundedRect($x, $y, $w, $h, $r, $style = '')
{
	$k = $this->k;
	$hp = $this->h;
	if($style=='F')
		$op='f';
	elseif($style=='FD' || $style=='DF')
		$op='B';
	else
		$op='S';
	$MyArc = 4/3 * (sqrt(2) - 1);
	$this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
	$xc = $x+$w-$r ;
	$yc = $y+$r;
	$this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));

	$this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
	$xc = $x+$w-$r ;
	$yc = $y+$h-$r;
	$this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
	$this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
	$xc = $x+$r ;
	$yc = $y+$h-$r;
	$this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
	$this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
	$xc = $x+$r ;
	$yc = $y+$r;
	$this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
	$this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
	$this->_out($op);
}

function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
{
	$h = $this->h;
	$this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
						$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
}

function Rotate($angle, $x=-1, $y=-1)
{
	if($x==-1)
		$x=$this->x;
	if($y==-1)
		$y=$this->y;
	if($this->angle!=0)
		$this->_out('Q');
	$this->angle=$angle;
	if($angle!=0)
	{
		$angle*=M_PI/180;
		$c=cos($angle);
		$s=sin($angle);
		$cx=$x*$this->k;
		$cy=($this->h-$y)*$this->k;
		$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
	}
}

function _endpage()
{
	if($this->angle!=0)
	{
		$this->angle=0;
		$this->_out('Q');
	}
	parent::_endpage();
}

// public functions
function sizeOfText( $texte, $largeur )
{
	$index    = 0;
	$nb_lines = 0;
	$loop     = TRUE;
	while ( $loop )
	{
		$pos = strpos($texte, "\n");
		if (!$pos)
		{
			$loop  = FALSE;
			$ligne = $texte;
		}
		else
		{
			$ligne  = substr( $texte, $index, $pos);
			$texte = substr( $texte, $pos+1 );
		}
		$length = floor( $this->GetStringWidth( $ligne ) );
		$res = 1 + floor( $length / $largeur) ;
		$nb_lines += $res;
	}
	return $nb_lines;
}

// Company
function addaddress( $company, $address, $tel, $vat )
{
	$x1 = 10;
	$y1 = 8;
	$this->setRTL(false);
	//Positionnement en bas
	$this->SetXY( $x1, $y1 );
	$this->SetFont('dejavusans','B',17);
	$length = $this->GetStringWidth( $company );
	$this->Cell( $length, 2, $company);
	$this->SetXY( $x1, $y1 + 8 );
	$this->SetFont('dejavusans','',9);
	$length = $this->GetStringWidth( $address );
	//Coordonnées de la société
	$lignes = $this->sizeOfText( $address, $length) ;
	$this->MultiCell($length, 4, $address);
	$this->SetXY( $x1, $y1 + 22 );
	$this->SetFont('dejavusans','',9);
	$length = $this->GetStringWidth( $tel );
	$this->Cell( $length, 2, "TEL : ". $tel);
	$this->SetXY( $x1, $y1 + 27 );
	$this->SetFont('dejavusans','',9);
	$length = $this->GetStringWidth( $vat );
	$this->Cell( $length, 2, "VAT NO: ". $vat);
	$this->setRTL(true);
}

function addaddress_ar( $company, $address, $tel, $vat )
{
	$x1 = 10;
	$y1 = 8;
	$this->setRTL(true);
	//Positionnement en bas
	$this->SetXY( $x1, $y1 );
	$this->SetFont('aefurat','B',24);
	$length = $this->GetStringWidth( $company );
	//$this->Cell( $length, 2, $company);
	$this->Cell($length,2, "$company " , 0, 0, "R");
	
	$this->SetXY( $x1, $y1 + 9 );
	$this->SetFont('aefurat','',15);
	$length = $this->GetStringWidth( $address );
	//Coordonnées de la société
	$lignes = $this->sizeOfText( $address, $length) ;
	//$this->MultiCell($length, 4, $address);
	$this->MultiCell(82, 5, $address, 0, "R");
	
	$this->SetXY( 92, $y1 + 22 );
	$this->SetXY( $x1, $y1 + 22 );
	$this->SetFont('aefurat','',12);
	$length = $this->GetStringWidth( $tel );
	//$this->Cell( $length, 2, "تليفون : ". $tel);
	$this->Cell(82,2, "تليفون : ". $tel , 0, 0, "R");
	$this->SetXY( $x1, $y1 + 27 );
	$this->SetFont('aefurat','',12);
	$length = $this->GetStringWidth( $vat );
	//$this->Cell( $length, 2, "رقم ضريبة : ". $vat);
	$this->Cell(82,2, "رقم ضريبة : ". $vat , 0, 0, "R");
	$this->setRTL(false);
}

// Label and number of invoice/estimate
function invoice_type( $libelle )
{
    $r1  = $this->w - 130;
    $r2  = $r1 + 45;
    $y1  = 26;
    $y2  = 8;
    $mid = ($r1 + $r2 ) / 2;
    
    $texte  = $libelle ;    
    $szfont = 12;
    $loop   = 0;
    
    while ( $loop == 0 )
    {
       $this->SetFont( "dejavusans", "B", $szfont );
       $sz = $this->GetStringWidth( $texte );
       if ( ($r1+$sz) > $r2 )
          $szfont --;
       else
          $loop ++;
    }

    $this->SetLineWidth(0.1);
    $this->SetFillColor(192);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 1.5, 'DF');
    $this->SetXY( $r1+1, $y1+2);
    $this->Cell($r2-$r1 -1,5, $texte, 0, 0, "C" );
}

function addDate( $hdate, $date , $da )
{
	$r1  = $this->w - 130;
	$r2  = $r1 + 55;
	$y1  = 23;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 1.5, 'D');
	$this->Line( $r1, $mid, $r2, $mid);
	
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
	$this->SetFont( "dejavusans", "B", 10);
	$this->Cell(10,2, $da, 0, 0, "C");
	
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+9 );
	$this->SetFont( "dejavusans", "", 10);
	$this->Cell(10,5,$date, 0,0, "C");
	
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+9 );
	$this->SetFont( "dejavusans", "", 10);
	$this->Cell(10,15,$hdate, 0,0, "C");
}

function addHDate( $date , $ardate)
{
	$r1  = $this->w - 95;
	$r2  = $r1 + 43;
	$y1  = 17;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
	$this->Line( $r1, $mid, $r2, $mid);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
	$this->SetFont( "dejavusans", "B", 10);
	$this->Cell(10,5, $ardate, 0, 0, "C");
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+9 );
	$this->SetFont( "dejavusans", "", 10);
	$this->Cell(10,5,$date, 0,0, "C");
}

function adddates($hdate , $transaction_time, $invoice_name)
{
	$r1  = $this->w - 200;
	$r2  = $r1 +190;
	$y1  = 61;
	$y2  = 10 ;
	$mid = $y1 + ($y2 / 2);

	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, .5, 'D');
	//$this->Line( $r1+65,  $y1, $r1+65, 59); // avant EUROS
	
	//$this->Line( $r1+72,  $y1, $r1+72, 66); // avant EUROS
	
	//$this->Line( $r1+100,  $y1, $r1+100, 59); // Entre Euros & Francs
	//$this->Line( $r1+150,  $y1, $r1+150, 59); 
	
	$this->SetXY( $r1 + 15, $y1+3 );
	$this->SetFont( "aefurat", "B", 12);
	$this->Cell(10,5, $hdate , 0, 0, "C");
		
	$this->SetXY( $r1 + 90, $y1+3 );
	$this->SetFont( "dejavusans", "B", 10);
	$this->Cell(10,5, $invoice_name, 0, 0, "C");
	
	$this->SetXY( $r1 + 160, $y1+3 );
	$this->SetFont( "dejavusans", "", 10);
	$this->Cell(10,5, $transaction_time, 0, 0, "C");
}

function addCustomer($Customer_name , $customer, $customer_vatno, $invoice_name, $invoice, $employee_name, $employee)
{
	$r1  = $this->w - 200;
	$r2  = $r1 +190;
	$y1  = 43;
	$y2  = 17 ;
	$mid = $y1 + ($y2 / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
	//$this->Line( $r1+65,  $y1, $r1+65, 59); // avant EUROS
	
	$this->Line( $r1+72,  $y1, $r1+72, 60); // avant EUROS
	
	//$this->Line( $r1+100,  $y1, $r1+100, 59); // Entre Euros & Francs
	//$this->Line( $r1+150,  $y1, $r1+150, 59); 
	
	$this->Line( $r1, $mid, 111, $mid);
	$this->Line( 161, $mid, 200, $mid);
	
	$this->SetXY( $r1 + 15, $y1+3 );
	$this->SetFont( "dejavusans", "B", 10);
	$this->Cell(7,5, "$Customer_name " , 0, 0, "C");
	$this->SetFont( "aefurat", "B", 12);
	$this->Cell(70,5, " زبون" , 0, 0, "C");
	$this->SetXY( $r1 + 15, $y1+8.5 );
	$this->SetFont( "dejavusans", "", 10);
	$this->Cell(50,5,$customer , 0,0, "C");
	if ($customer_vatno)
	{
	$this->SetXY( $r1 + 15, $y1+13 );
	$this->SetFont( "dejavusans", "", 8);
	$this->Cell(50,5,'رقم ضريبة : '.$customer_vatno , 0,0, "C");
	}
	$this->SetXY( $r1 + 80, $y1+3 );
	$this->SetFont( "dejavusans", "B", 10);
	$this->Cell(10,5, $invoice_name, 0, 0, "C");
	$this->SetXY( $r1 + 80, $y1+9 );
	$this->SetFont( "dejavusans", "", 10);
	$this->Cell(10,5,$invoice, 0,0, "C");
	
	$this->SetXY( $r1 + 165, $y1+3 );
	$this->SetFont( "dejavusans", "B", 10);
	$this->Cell(10,5, $employee_name, 0, 0, "C");
	$this->SetXY( $r1 + 165, $y1+9 );
	$this->SetFont( "dejavusans", "", 10);
	$this->Cell(10,5,$employee, 0,0, "C");
}


// Mode of payment
function addRemarks( $mode )
{
	$r1  = 10;
	$r2  = $r1 + 120;
	$y1  = $this->h - 55;
	$y2  = $y1+10;
	$mid = $y1 + (($y2-$y1) / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
	
	$this->SetXY( $r1 + ($r2-$r1)/2 -5 , $y1+1 );
	$this->SetFont( "dejavusans", "B", 10);
	$this->Cell(10,5,$mode, 0,0, "C");
}

function addCols( $tab )
{
	global $colonnes;
	
	$r1  = 10;
	$r2  = $this->w - ($r1 * 2) ;
	$y1  = 73;
	$y2  = $this->h - 60 - $y1;
	$this->SetXY( $r1, $y1 );
	$this->Rect( $r1, $y1, $r2, $y2, "D");
	$this->Line( $r1, $y1+12, $r1+$r2, $y1+12);
	$colX = $r1;
	$colonnes = $tab;
	while ( list( $lib, $pos ) = each ($tab) )
	{
		$this->SetXY( $colX, $y1+2 );
		$this->Cell( $pos, 1, $lib, 0, 0, "C");
		$colX += $pos;
		$this->Line( $colX, $y1, $colX, $y1+$y2);
	}
}

function addColsar( $tab )
{
	global $colonnes;
	
	$r1  = 10;
	$r2  = $this->w - ($r1 * 2) ;
	$y1  = 77;
	$y2  = $this->h - 60 - $y1;
	$this->SetXY( $r1, $y1 );
	$colX = $r1;
	$colonnes = $tab;
	while ( list( $lib, $pos ) = each ($tab) )
	{
		$this->SetXY( $colX, $y1+2 );
		$this->Cell( $pos, 1, $lib, 0, 0, "C");
		$colX += $pos;
		//$this->Line( $colX, $y1, $colX, $y1+$y2);
	}
}

function addLineFormat( $tab )
{
	global $format, $colonnes;
	
	while ( list( $lib, $pos ) = each ($colonnes) )
	{
		if ( isset( $tab["$lib"] ) )
			$format[ $lib ] = $tab["$lib"];
	}
}

function lineVert( $tab )
{
	global $colonnes;

	reset( $colonnes );
	$maxSize=0;
	while ( list( $lib, $pos ) = each ($colonnes) )
	{
		$texte = $tab[ $lib ];
		$longCell  = $pos -2;
		$size = $this->sizeOfText( $texte, $longCell );
		if ($size > $maxSize)
			$maxSize = $size;
	}
	return $maxSize;
}

function addLine( $ligne, $tab )
{
	global $colonnes, $format;

	$ordonnee     = 10;
	$maxSize      = $ligne;

	reset( $colonnes );
	while ( list( $lib, $pos ) = each ($colonnes) )
	{
		$longCell  = $pos -2;
		$texte     = $tab[ $lib ];
		$length    = $this->GetStringWidth( $texte );
		$tailleTexte = $this->sizeOfText( $texte, $length );
		$formText  = $format[ $lib ];
		$this->SetXY( $ordonnee, $ligne-1);
		$this->MultiCell( $longCell, 4 , $texte, 0, $formText);
		if ( $maxSize < ($this->GetY()  ) )
			$maxSize = $this->GetY() ;
		$ordonnee += $pos;
	}
	return ( $maxSize - $ligne );
}

function addpolicy($remark, $remark_ar)
{
	//$this->SetFont( "dejavusans", "B", 10);
	$this->setRTL(true);
	$this->SetFont('aefurat', 'B', 8);
	$length = $this->GetStringWidth( $remark_ar );
	$r1  = 80;
	$r2  = $r1 + $length;
	$y1  = $this->h - 45;
	$y2  = $y1+5;
	$this->SetXY( $r1 , -55 );
	$lignes = $this->sizeOfText( $remark_ar, $length) ;
	$this->MultiCell($length, 4, $remark_ar);
	$this->setRTL(false);
		
	$length = $this->GetStringWidth( $remark );
	$r1  = 10;
	$r2  = $r1 + $length;
	$y1  = $this->h - 45;
	$y2  = $y1+5;
	$this->SetXY( $r1 , -48 );
	$lignes = $this->sizeOfText( $remark, $length) ;
	//$this->Cell($length,4, $remark_ar);

	$this->MultiCell(80,3, $remark);
}

function addcurrency($amount)
{
	//$this->SetFont( "dejavusans", "", 10);
	$this->SetFont('aefurat', '', 9);
	$length = $this->GetStringWidth($amount);
	$r1  = 10;
	$r2  = $r1 + $length;
	$y1  = $this->h - 35.5;
	$y2  = $y1+5;
	$this->SetXY( $r1 , $y1 );
	$this->Cell($length,4, $amount);
}


function addarcurrency($amount)
{
	$this->setRTL(true);
	$this->SetFont('aefurat', '', 9);
	$length = $this->GetStringWidth($amount );
	$r1  = 80;
	$r2  = $r1 + $length;
	$y1  = $this->h - 27.5;
	$y2  = $y1+5;
	$this->SetXY( $r1 , $y1 );
	$this->Cell($length,4, $amount);
	$this->setRTL(false);
}

function addCashBoarder()
{
	$this->SetFont( "dejavusans", "B", 8);
	$r1  = 10;
	$r2  = $r1 + 120;
	$y1  = $this->h - 40;
	$y2  = $y1+20;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
	
}

function returnpolicyboarder()
{
	$this->SetFont( "dejavusans", "B", 8);
	$r1  = 10;
	$r2  = $r1 + 120;
	$y1  = $this->h - 58;
	$y2  = $y1+16;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
}

function total_qty_boarder($total_qty)
{
	$this->SetFont( "dejavusans", "B", 8);
	$r1  = 102;
	$r2  = $r1 + 28;
	$y1  = $this->h - 58;
	$y2  = $y1+16;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->SetXY( $r1-1, $y1+2 );
	$this->SetFont( "dejavusans", "", 8);
	$this->Cell(30,4, "Total QTY", 0, 0, "C");
	$this->SetXY( $r1-1, $y1+10 );
	$this->Cell(30,4, $total_qty, 0, 0, "C");
}

function addtotalcash($sub, $total, $tax)
{
	$r1  = $this->w - 75;
	$r2  = $r1 + 65;
	$y1  = $this->h - 38;
	$y2  = $y1+18;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
	$this->Line( $r1+30,  $y1, $r1+30, $y2); // avant EUROS
	//$this->Line( $r1+20, $y1+4, $r2, $y1+4); // Sous Euros & Francs
	$this->SetFont( "dejavusans", "", 8);
	
	$this->SetXY( $r1, $y1+2 );
	$this->Cell(30,4, "Sub Total", 0, 0, "L");
	$this->SetXY( $r1, $y1+7 );
	$this->Cell(20,4, "Tax", 0, 0, "L");
	$this->SetXY( $r1, $y1+12 );
	$this->Cell(25,4, "Total", 0, 0, "L");
	
	$this->setRTL(true);
	$this->SetXY( $r1-90, $y1+1 );
    $this->Cell(30,4, "مبلغ إجمالي", 0, 0, "R");
	$this->SetXY( $r1-90, $y1+7 );
	$this->Cell(20,4, "ضريبة", 0, 0, "R");
	$this->SetXY( $r1-90, $y1+12 );
	$this->Cell(25,4, "إجمالي", 0, 0, "R");
	$this->setRTL(false);
	
	$this->SetXY( $r1, $y1+2 );
	$this->SetFont( "dejavusans", "", 10);
	$this->SetXY( $r1+30, $y1+2 );
	$this->Cell(30,4, $sub, 0, 0, "C");
	$this->SetXY( $r1+30, $y1+7 );
	$this->Cell(30,4, $total, 0, 0, "C");
	$this->SetXY( $r1+30, $y1+12 );
	$this->Cell(30,4, $tax, 0, 0, "C");
}

function receiptsign()
{
	$this->SetFont( "dejavusans", "B", 8);
	$r1  = $this->w - 75;
	$r2  = $r1 + 65;
	$y1  = $this->h - 58;
	$y2  = $y1+38;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
	
	$this->SetFont('aefurat', '', 11);
	$r1  = $this->w - 55;
	$r2  = $r1 + 65;
	$y1  = $this->h - 45;
	$y2  = $y1+5;
	$this->SetXY( $r1 , -55 );
	$this->Cell($length, 4, 'Receiver Sign' );
}

function addreceipttotalcash($total)
{
	
	$r1  = 10;
	$r2  = $r1 + 120;
	$y1  = $this->h - 59;
	$y2  = $y1+18;
	
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
	$this->Line( $r1+60,  $y1, $r1+60, $y2); 
	
	$this->SetFont( "dejavusans", "",10);
	
	$this->SetXY( $r1 + 5, $y1+8 );
    $this->Cell(25,4, "Total", 0, 0, "L");
	
	$this->setRTL(true);
	$this->SetXY( $r1-75, $y1+8 );
	$this->Cell(25,4, "إجمالي", 0, 0, "R");
	$this->setRTL(false);
	
	$this->SetXY( $r1, $y1+2 );
	$this->SetFont( "dejavusans", "", 10);
	$this->SetXY( $r1+75, $y1+7 );
	$this->Cell(30,4, $total, 0, 0, "C");
}

function addpayment( $mode, $amount, $order )
{
	$r1  = 135;
	$r2  = $r1 + 65;
	$y1  = $this->h - 58;
	$y2  = $y1+18;
	$mid = $y1 + (($y2-$y1) / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
	
	if ($order == 1)
	{
	$this->SetXY( $r1 + ($r2-$r1)/4 -5 , $y1+1 );
	//$this->SetFont( "dejavusans", "B", 10);
	$this->SetFont('aefurat', 'B', 11);
	$this->Cell(10,5,$mode, 0,0, "C");
	
	$this->Line( $r1+30,  $y1, $r1+30, $y2); 
	
	$this->SetXY( $r1 + ($r2-$r1)/1.5 -5 , $y1+1 );
	$this->SetFont('aefurat', 'B', 11);
	$this->Cell(10,5, to_currency($amount) , 0,0, "C");
	}
	elseif ($order == 2)
	{
	$this->SetXY( $r1 + ($r2-$r1)/4 -5 , $y1+1 );
	$this->SetFont('aefurat', 'B', 11);
	$this->Cell(10,12,$mode, 0,0, "C");
	
	$this->SetXY( $r1 + ($r2-$r1)/1.5 -5 , $y1+1 );
	$this->SetFont('aefurat', 'B', 11);
	$this->Cell(10,12, to_currency($amount) , 0,0, "C");
	}
	elseif ($order == 3)
	{
	$this->SetXY( $r1 + ($r2-$r1)/4 -5 , $y1+1 );
	$this->SetFont('aefurat', 'B', 11);
	$this->Cell(10,19,$mode, 0,0, "C");
	
	$this->SetXY( $r1 + ($r2-$r1)/1.5 -5 , $y1+1 );
	$this->SetFont('aefurat', 'B', 11);
	$this->Cell(10,19, to_currency($amount) , 0,0, "C");
	}
	elseif ($order == 4)
	{
	$this->SetXY( $r1 + ($r2-$r1)/4 -5 , $y1+1 );
	$this->SetFont('aefurat', 'B', 11);
	$this->Cell(10,26,$mode, 0,0, "C");
	
	$this->SetXY( $r1 + ($r2-$r1)/1.5 -5 , $y1+1 );
	$this->SetFont('aefurat', 'B', 11);
	$this->Cell(10,26, to_currency($amount) , 0,0, "C");
	}
}

// add a watermark (temporary estimate, DUPLICATA...)
// call this method first
function company_watermark($company)
{
	$this->SetFont('dejavusans','B',40);
	$this->SetTextColor(203,203,203);
	$this->Rotate(45,55,190);
	$this->Text(55,190,$company);
	$this->Rotate(0);
	$this->SetTextColor(0,0,0);
}

}
?>
