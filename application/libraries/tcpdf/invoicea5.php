<?php

class PDF_Invoicea5 extends TCPDF
{
// private variables
var $colonnes;
var $format;
var $angle=0;

    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

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
function addCompany( $company, $address, $tel)
{
	$x1 = 10;
	$y1 = 15;
	//Positionnement en bas
	$this->SetXY( $x1, $y1 );
	$this->SetFont('dejavusans','B',14);
	$length = $this->GetStringWidth( $company );
	$this->Cell( $length, 2, $company);
	$this->SetXY( $x1, $y1 + 8 );
	$this->SetFont('dejavusans','',8);
	$length = $this->GetStringWidth( $address );
	//Coordonnées de la société
	$lignes = $this->sizeOfText( $address, $length) ;
	$this->MultiCell($length, 4, $address);
	$this->SetXY( $x1, $y1 + 22 );
	$this->SetFont('dejavusans','',8);
	$length = $this->GetStringWidth( $tel );
	$this->Cell( $length, 2, "Tel : ". $tel);
	$this->SetXY( $x1, $y1 + 27 );
}

function addCompany_ar( $company, $address, $tel)
{
	$x1 = 10;
	$y1 = 15;
	$this->setRTL(true);
	$this->SetXY( $x1, $y1 );
	$this->SetFont('dejavusans','B',14);
	$length = $this->GetStringWidth( $company );
	$this->Cell( $length, 2, $company);
	$this->SetXY( $x1, $y1 + 8 );
	$this->SetFont('dejavusans','',8);
	$length = $this->GetStringWidth( $address );
	//Coordonnées de la société
	$lignes = $this->sizeOfText( $address, $length) ;
	//$this->MultiCell($length, 4, $address);
	$this->MultiCell(55, 4, $address, 0, "R");
	$this->SetXY( $x1, $y1 + 22 );
	$this->SetFont('dejavusans','',8);
	$length = $this->GetStringWidth( $tel );
	$this->Cell( $length, 2, "تليفون : ". $tel);
	$this->SetXY( $x1, $y1 + 27 );
	$this->setRTL(false);
}


// Label and number of invoice/estimate
function head_formats( $libelle )
{
    $r1  = $this->w - 100;
    $r2  = $r1 + 48;
    $y1  = 6;
    $y2  = $y1 + 2;
    $mid = ($r1 + $r2 ) / 2;
    
    $texte  = $libelle ;    
    $szfont = 9;
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
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 2.5, 'DF');
    $this->SetXY( $r1+1, $y1+2);
    $this->Cell($r2-$r1 -1,5, $texte, 0, 0, "C" );
}

// Estimate
function addDevis( $numdev )
{
	$string = sprintf("DEV%04d",$numdev);
	$this->fact_dev( "Devis", $string );
}

// Invoice
function addFacture( $numfact )
{
	$string = sprintf("FA%04d",$numfact);
	$this->fact_dev( "Facture", $string );
}

function addDate( $date , $da)
{
	$r1  = $this->w - 51;
	$r2  = $r1 + 40;
	$y1  = 17;
	$y2  = $y1 ;
	$mid = $y1 + ($y2 / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
	$this->Line( $r1, $mid, $r2, $mid);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
	$this->SetFont( "dejavusans", "B", 10);
	$this->Cell(10,5, $da, 0, 0, "C");
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+9 );
	$this->SetFont( "dejavusans", "", 10);
	$this->Cell(10,5,$date, 0,0, "C");
}

function customer_name($customer_name, $arabic)
{
	$r1  = $this->w - 138;
	$r2  = $r1 +128;
	$y1  = 61;
	$y2  = 10 ;
	$mid = $y1 + ($y2 / 2);

	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, .5, 'D');
	//$this->Line( $r1+65,  $y1, $r1+65, 59); // avant EUROS
	
	//$this->Line( $r1+72,  $y1, $r1+72, 66); // avant EUROS
	
	//$this->Line( $r1+100,  $y1, $r1+100, 59); // Entre Euros & Francs
	//$this->Line( $r1+150,  $y1, $r1+150, 59); 
	
	$this->SetXY( $r1 + 7, $y1+3 );
	$this->SetFont( "aefurat", "B", 12);
	$this->Cell(10,5, 'Customer:' , 0, 0, "C");
	
	if($arabic == 1)
	{
		$this->setRTL(true);
		$this->Cell(10,5, 'زبون:' , 0, 0, "C");
		$this->setRTL(false);
	}
		
	$this->SetXY( $r1 + 25, $y1+3 );
	$this->SetFont( "dejavusans", "C", 10);
	$this->Cell(10,5, $customer_name, 0, 0, "L");
	

}



function addHDate( $date , $ardate)
{
	$r1  = $this->w - 105;
	$r2  = $r1 + 49;
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

function addHeader($receivings_id , $receiving_id, $transaction_time, $employee_name, $employee)
{
	$r1  = $this->w - 138;
	$r2  = $r1 +128;
	$y1  = 42;
	$y2  = 17 ;
	$mid = $y1 + ($y2 / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
	$this->Line( $r1+35,  $y1, $r1+35, 59); // avant EUROS
	$this->Line( $r1+54,  $y1, $r1+54, 59); // Entre Euros & Francs
	$this->Line( $r1+100,  $y1, $r1+100, 59); 

	
	$this->Line( $r1, $mid, 64, $mid);
	$this->Line( 110, $mid, 138, $mid);
	
	$this->SetXY( $r1 + 15, $y1+3 );
	$this->SetFont( "dejavusans", "B", 10);
	$this->Cell(9,5, "Date" , 0, 0, "C");
	$this->SetXY( $r1 + 15, $y1+9 );
	$this->SetFont( "dejavusans", "", 8);
	$this->Cell(9,5,$transaction_time, 0,0, "C");
	
	$this->SetXY( $r1 + 38, $y1+3 );
	$this->SetFont( "dejavusans", "B", 10);
	$this->Cell(10,5, $receivings_id, 0, 0, "C");
	$this->SetXY( $r1 + 38, $y1+9 );
	$this->SetFont( "dejavusans", "", 8);
	$this->Cell(10,5,$receiving_id, 0,0, "C");
	
	$this->SetXY( $r1 + 105, $y1+3 );
	$this->SetFont( "dejavusans", "B", 10);
	$this->Cell(10,5, $employee_name, 0, 0, "C");
	$this->SetXY( $r1 + 105, $y1+9 );
	$this->SetFont( "dejavusans", "", 7);
	$this->Cell(10,5,$employee, 0,0, "L");
}


function addClient($ref, $INV)
{
    $r1  = $this->w - 31;
	$r2  = $r1 + 25;
	$y1  = 17;
	$y2  = $y1;
	$mid = $y1 + ($y2 / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');

	
	$this->Line( $r1, $mid, $r2, $mid);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
	$this->SetFont( "dejavusans", "B", 10);
	//$this->Cell(10,5, $INV, 0, 0, "C");
	$this->Cell(10,5,$INV, 0,0, "C");
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1 + 9 );
	$this->SetFont( "dejavusans", "", 10);
	$this->Cell(10,5,$ref, 0,0, "C");
}

function addPageNumber( $page )
{
	$r1  = $this->w - 130;
	$r2  = $r1 + 19;
	$y1  = 40;
	$y2  = 19;
	$mid = $y1 + ($y2 / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
	$this->Line( $r1, $mid, $r2, $mid);


	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
	$this->SetFont( "dejavusans", "B", 10);
	$this->Cell(10,5, "PAGE", 0, 0, "C");
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1 + 9 );
	$this->SetFont( "dejavusans", "", 10);
	$this->Cell(10,5,$page, 0,0, "C");
}

// Client address
function addClientAdresse( $adresse )
{
	$r1     = $this->w - 80;
	$r2     = $r1 + 68;
	$y1     = 40;
	$this->SetXY( $r1, $y1);
	$this->MultiCell( 60, 4, $adresse);
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

function addpayment( $mode, $amount, $order )
{
	$r1  = $this->w - 98;
	$r2  = $r1 + 40;
	$y1  = $this->h - 48;
	$y2  = $y1+18;
	$mid = $y1 + (($y2-$y1) / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
	
	if ($order == 1)
	{
	$this->SetXY( $r1 + ($r2-$r1)/4 -5 , $y1+1 );
	//$this->SetFont( "dejavusans", "B", 10);
	$this->SetFont('aefurat', 'B', 9);
	$this->Cell(10,5,$mode, 0,0, "C");
	
//	$this->Line( $r1+20,  $y1, $r1+20, $y2); 
	
	$this->SetXY( $r1 + ($r2-$r1)/1.5 -5 , $y1+1 );
	$this->SetFont('aefurat', 'B', 9);
	$this->Cell(10,5, to_currency($amount) , 0,0, "C");
	}
	elseif ($order == 2)
	{
	$this->SetXY( $r1 + ($r2-$r1)/4 -5 , $y1+1 );
	$this->SetFont('aefurat', 'B', 9);
	$this->Cell(10,12,$mode, 0,0, "C");
	
	$this->SetXY( $r1 + ($r2-$r1)/1.5 -5 , $y1+1 );
	$this->SetFont('aefurat', 'B', 9);
	$this->Cell(10,12, to_currency($amount) , 0,0, "C");
	}
	elseif ($order == 3)
	{
	$this->SetXY( $r1 + ($r2-$r1)/4 -5 , $y1+1 );
	$this->SetFont('aefurat', 'B', 9);
	$this->Cell(10,19,$mode, 0,0, "C");
	
	$this->SetXY( $r1 + ($r2-$r1)/1.5 -5 , $y1+1 );
	$this->SetFont('aefurat', 'B', 9);
	$this->Cell(10,19, to_currency($amount) , 0,0, "C");
	}
	elseif ($order == 4)
	{
	$this->SetXY( $r1 + ($r2-$r1)/4 -5 , $y1+1 );
	$this->SetFont('aefurat', 'B', 9);
	$this->Cell(10,26,$mode, 0,0, "C");
	
	$this->SetXY( $r1 + ($r2-$r1)/1.5 -5 , $y1+1 );
	$this->SetFont('aefurat', 'B', 9);
	$this->Cell(10,26, to_currency($amount) , 0,0, "C");
	}
}

function addtotalcash($sub, $total, $tax)
{	
	$r1  = $this->w - 55;
	$r2  = $r1 + 45;
	$y1  = $this->h - 48;
	$y2  = $y1+18;

	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
	$this->Line( $r1+25,  $y1, $r1+25, $y2); 
	$this->SetFont( "dejavusans", "", 7);
	
	$this->SetXY( $r1, $y1+2 );
	$this->Cell(30,4, "Sub Total", 0, 0, "L");
	$this->SetXY( $r1, $y1+7 );
	$this->Cell(20,4, "Tax", 0, 0, "L");
	$this->SetXY( $r1, $y1+12 );
	$this->Cell(25,4, "Total", 0, 0, "L");
	
	$this->setRTL(true);
	$this->SetXY( $r1-64, $y1+2 );
    $this->Cell(30,4, "مبلغ إجمالي", 0, 0, "R");
	$this->SetXY( $r1-63, $y1+7 );
	$this->Cell(20,4, "ضريبة", 0, 0, "R");
	$this->SetXY( $r1-63, $y1+12 );
	$this->Cell(25,4, "إجمالي", 0, 0, "R");
	$this->setRTL(false);
	
	$this->SetXY( $r1, $y1+2 );
	//$this->SetFont( "dejavusans", "", 10);
	$this->SetXY( $r1+20, $y1+2 );
	$this->Cell(30,4, $sub, 0, 0, "C");
	$this->SetXY( $r1+20, $y1+5 );
	$this->Cell(30,4, $total, 0, 0, "C");
	$this->SetXY( $r1+20, $y1+12 );
	$this->Cell(30,4, $tax, 0, 0, "C");
}

function addReference($ref)
{
	$this->SetFont( "dejavusans", "", 10);
	$length = $this->GetStringWidth( "Références : " . $ref );
	$r1  = 10;
	$r2  = $r1 + $length;
	$y1  = 65;
	$y2  = $y1+5;
	$this->SetXY( $r1 , $y1 );
	$this->Cell($length,4, "Références : " . $ref);
}

function addCols( $tab )
{
	global $colonnes;
	
	$r1  = 10;
	$r2  = $this->w - ($r1 * 2) ;
	$y1  = 72;
	$y2  = $this->h - 50 - $y1;
	$this->SetXY( $r1, $y1 );
	$this->Rect( $r1, $y1, $r2, $y2, "D");
	$this->Line( $r1, $y1+8, $r1+$r2, $y1+8);
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
	$y1  = 74;
	$y2  = $this->h - 60 - $y1;
	$this->SetXY( $r1, $y1 );
	$colX = $r1;
	$colonnes = $tab;
	while ( list( $lib, $pos ) = each ($tab) )
	{
		$this->SetXY( $colX, $y1+2 );
		$this->SetFont( "dejavusans", "", 8);
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

function addRemarque($remarque)
{
	$this->SetFont( "dejavusans", "B", 10);
	$length = $this->GetStringWidth( "Return Policy : " . $remarque );
	$r1  = 10;
	$r2  = $r1 + $length;
	$y1  = $this->h - 45;
	$y2  = $y1+5;
	$this->SetXY( $r1 , -55 );
	$lignes = $this->sizeOfText( $remarque, $length) ;
	//$this->MultiCell($length, 4, $remarque);
	$this->MultiCell(80,3, $remarque);
}

function addCadRP()
{
	$this->SetFont( "dejavusans", "B", 8);
	$r1  = 10;
	$r2  = $r1 + 95;
	$y1  = $this->h - 48;
	$y2  = $y1+30;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
	
}

function returnpolicyboarder()
{
	$this->SetFont( "dejavusans", "B", 8);
	$r1  = 10;
	$r2  = $r1 + 38;
	$y1  = $this->h - 48;
	$y2  = $y1+29;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
}

function addpolicy($remark, $arabic_support)
{
	if($arabic_support == '1')
	{
		$this->setRTL(true);
		$this->SetFont('aefurat', '', 8);
	    $length = $this->GetStringWidth( $remark );
	    $r1  = -45;
	    $r2  = $r1 + $length;
    	$y1  = $this->h - 45;
    	$y2  = $y1+5;
    	$this->SetXY( $r1 , -48 );
    	$lignes = $this->sizeOfText( $remark, $length) ;
    	$this->MultiCell(35, 4, $remark);
		$this->setRTL(false);
	}
	else
	{
		$this->SetFont('aefurat', '', 8);
	    $length = $this->GetStringWidth( $remark );
	    $r1  = 10;
	    $r2  = $r1 + $length;
    	$y1  = $this->h - 45;
    	$y2  = $y1+5;
    	$this->SetXY( $r1 , -48 );
    	$lignes = $this->sizeOfText( $remark, $length) ;
    	$this->MultiCell(35, 4, $remark);
	}
}

function addcurrency($currency, $currency_ar)
{
	$this->SetFont( "dejavusans", "B", 8);
	$r1  = 49;
	$r2  = $r1 + 90;
	$y1  = $this->h - 28.5;
	$y2  = $y1+10;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
	
	$this->SetFont( "dejavusans", "", 8);
	$length = $this->GetStringWidth( $currency );
	$length_ar = $this->GetStringWidth( $currency_ar );
	
	$this->SetXY( $r1 , $y1 );
	$this->Cell($length,4, $currency);
	$this->SetXY( $r1 , $y1+4 );
	$this->Cell($length_ar,4, $currency_ar, 0, 'L');
}

function addCadreTVAs()
{
	$this->SetFont( "dejavusans", "B", 8);
	$r1  = 10;
	$r2  = $r1 + 120;
	$y1  = $this->h - 40;
	$y2  = $y1+20;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
	
}

function addBarcode($web_add)
{
	$r1  = $this->w - 40;
	$r2  = $r1 + 30;
	$y1  = $this->h - 48;
	$y2  = $y1+20;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), 30, 2.5, 'D');
	$this->write2DBarcode($web_add, 'QRCODE,H', $r1+5, $y1+5, 20, 20, $style, 'N');
	//$this->write2DBarcode($web_add.'/4/'.$mobile, 'QRCODE,H', $r1+5, $y1+5, 30, 30, $style, 'N');
    $this->Text($r1, $y1, 'Scan For Status');
}

// remplit les cadres TVA / Totaux et la remarque
// params  = array( "RemiseGlobale" => [0|1],
//                      "remise_tva"     => [1|2...],  // {la remise s'applique sur ce code TVA}
//                      "remise"         => value,     // {montant de la remise}
//                      "remise_percent" => percent,   // {pourcentage de remise sur ce montant de TVA}
//                  "FraisPort"     => [0|1],
//                      "portTTC"        => value,     // montant des frais de ports TTC
//                                                     // par defaut la TVA = 19.6 %
//                      "portHT"         => value,     // montant des frais de ports HT
//                      "portTVA"        => tva_value, // valeur de la TVA a appliquer sur le montant HT
//                  "AccompteExige" => [0|1],
//                      "accompte"         => value    // montant de l'acompte (TTC)
//                      "accompte_percent" => percent  // pourcentage d'acompte (TTC)
//                  "Remarque" => "texte"              // texte
// tab_tva = array( "1"       => 19.6,
//                  "2"       => 5.5, ... );
// invoice = array( "px_unit" => value,
//                  "qte"     => qte,
//                  "tva"     => code_tva );
function addTVAs( $params, $tab_tva, $invoice )
{
	$this->SetFont('dejavusans','',8);
	
	reset ($invoice);
	$px = array();
	while ( list( $k, $prod) = each( $invoice ) )
	{
		$tva = $prod["tva"];
		@ $px[$tva] += $prod["qte"] * $prod["px_unit"];
	}

	$prix     = array();
	$totalHT  = 0;
	$totalTTC = 0;
	$totalTVA = 0;
	$y = 261;
	reset ($px);
	natsort( $px );
	while ( list($code_tva, $articleHT) = each( $px ) )
	{
		$tva = $tab_tva[$code_tva];
		$this->SetXY(17, $y);
		$this->Cell( 19,4, sprintf("%0.2F", $articleHT),'', '','R' );
		if ( $params["RemiseGlobale"]==1 )
		{
			if ( $params["remise_tva"] == $code_tva )
			{
				$this->SetXY( 37.5, $y );
				if ($params["remise"] > 0 )
				{
					if ( is_int( $params["remise"] ) )
						$l_remise = $param["remise"];
					else
						$l_remise = sprintf ("%0.2F", $params["remise"]);
					$this->Cell( 14.5,4, $l_remise, '', '', 'R' );
					$articleHT -= $params["remise"];
				}
				else if ( $params["remise_percent"] > 0 )
				{
					$rp = $params["remise_percent"];
					if ( $rp > 1 )
						$rp /= 100;
					$rabais = $articleHT * $rp;
					$articleHT -= $rabais;
					if ( is_int($rabais) )
						$l_remise = $rabais;
					else
						$l_remise = sprintf ("%0.2F", $rabais);
					$this->Cell( 14.5,4, $l_remise, '', '', 'R' );
				}
				else
					$this->Cell( 14.5,4, "ErrorRem", '', '', 'R' );
			}
		}
		$totalHT += $articleHT;
		$totalTTC += $articleHT * ( 1 + $tva/100 );
		$tmp_tva = $articleHT * $tva/100;
		$a_tva[ $code_tva ] = $tmp_tva;
		$totalTVA += $tmp_tva;
		$this->SetXY(11, $y);
		$this->Cell( 5,4, $code_tva);
		$this->SetXY(53, $y);
		$this->Cell( 19,4, sprintf("%0.2F",$tmp_tva),'', '' ,'R');
		$this->SetXY(74, $y);
		$this->Cell( 10,4, sprintf("%0.2F",$tva) ,'', '', 'R');
		$y+=4;
	}

	if ( $params["FraisPort"] == 1 )
	{
		if ( $params["portTTC"] > 0 )
		{
			$pTTC = sprintf("%0.2F", $params["portTTC"]);
			$pHT  = sprintf("%0.2F", $pTTC / 1.196);
			$pTVA = sprintf("%0.2F", $pHT * 0.196);
			$this->SetFont('dejavusans','',6);
			$this->SetXY(85, 261 );
			$this->Cell( 6 ,4, "HT : ", '', '', '');
			$this->SetXY(92, 261 );
			$this->Cell( 9 ,4, $pHT, '', '', 'R');
			$this->SetXY(85, 265 );
			$this->Cell( 6 ,4, "TVA : ", '', '', '');
			$this->SetXY(92, 265 );
			$this->Cell( 9 ,4, $pTVA, '', '', 'R');
			$this->SetXY(85, 269 );
			$this->Cell( 6 ,4, "TTC : ", '', '', '');
			$this->SetXY(92, 269 );
			$this->Cell( 9 ,4, $pTTC, '', '', 'R');
			$this->SetFont('dejavusans','',8);
			$totalHT += $pHT;
			$totalTVA += $pTVA;
			$totalTTC += $pTTC;
		}
		else if ( $params["portHT"] > 0 )
		{
			$pHT  = sprintf("%0.2F", $params["portHT"]);
			$pTVA = sprintf("%0.2F", $params["portTVA"] * $pHT / 100 );
			$pTTC = sprintf("%0.2F", $pHT + $pTVA);
			$this->SetFont('dejavusans','',6);
			$this->SetXY(85, 261 );
			$this->Cell( 6 ,4, "HT : ", '', '', '');
			$this->SetXY(92, 261 );
			$this->Cell( 9 ,4, $pHT, '', '', 'R');
			$this->SetXY(85, 265 );
			$this->Cell( 6 ,4, "TVA : ", '', '', '');
			$this->SetXY(92, 265 );
			$this->Cell( 9 ,4, $pTVA, '', '', 'R');
			$this->SetXY(85, 269 );
			$this->Cell( 6 ,4, "TTC : ", '', '', '');
			$this->SetXY(92, 269 );
			$this->Cell( 9 ,4, $pTTC, '', '', 'R');
			$this->SetFont('dejavusans','',8);
			$totalHT += $pHT;
			$totalTVA += $pTVA;
			$totalTTC += $pTTC;
		}
	}

	$this->SetXY(114,266.4);
	$this->Cell(15,4, sprintf("%0.2F", $totalHT), '', '', 'R' );
	$this->SetXY(114,271.4);
	$this->Cell(15,4, sprintf("%0.2F", $totalTVA), '', '', 'R' );

	$params["totalHT"] = $totalHT;
	$params["TVA"] = $totalTVA;
	$accompteTTC=0;
	if ( $params["AccompteExige"] == 1 )
	{
		if ( $params["accompte"] > 0 )
		{
			$accompteTTC=sprintf ("%.2F", $params["accompte"]);
			if ( strlen ($params["Remarque"]) == 0 )
				$this->addRemarque( "Accompte de $accompteTTC Euros exigé à la commande.");
			else
				$this->addRemarque( $params["Remarque"] );
		}
		else if ( $params["accompte_percent"] > 0 )
		{
			$percent = $params["accompte_percent"];
			if ( $percent > 1 )
				$percent /= 100;
			$accompteTTC=sprintf("%.2F", $totalTTC * $percent);
			$percent100 = $percent * 100;
			if ( strlen ($params["Remarque"]) == 0 )
				$this->addRemarque( "Accompte de $percent100 % (soit $accompteTTC Euros) exigé à la commande." );
			else
				$this->addRemarque( $params["Remarque"] );
		}
		else
			$this->addRemarque( "Drôle d'acompte !!! " . $params["Remarque"]);
	}
	else
	{
		if ( strlen ($params["Remarque"]) > 0 )
			$this->addRemarque( $params["Remarque"] );
	}
	$re  = $this->w - 50;
	$rf  = $this->w - 29;
	$y1  = $this->h - 40;
	$this->SetFont( "dejavusans", "", 8);
	$this->SetXY( $re, $y1+5 );
	$this->Cell( 17,4, sprintf("%0.2F", $totalTTC), '', '', 'R');
	$this->SetXY( $re, $y1+10 );
	$this->Cell( 17,4, sprintf("%0.2F", $accompteTTC), '', '', 'R');
	$this->SetXY( $re, $y1+14.8 );
	$this->Cell( 17,4, sprintf("%0.2F", $totalTTC - $accompteTTC), '', '', 'R');
	$this->SetXY( $rf, $y1+5 );
	$this->Cell( 17,4, sprintf("%0.2F", $totalTTC * EURO_VAL), '', '', 'R');
	$this->SetXY( $rf, $y1+10 );
	$this->Cell( 17,4, sprintf("%0.2F", $accompteTTC * EURO_VAL), '', '', 'R');
	$this->SetXY( $rf, $y1+14.8 );
	$this->Cell( 17,4, sprintf("%0.2F", ($totalTTC - $accompteTTC) * EURO_VAL), '', '', 'R');
}

function watermark( $company )
{
	$this->SetFont('dejavusans','B',25);
	$this->SetTextColor(203,203,203);
	$this->Rotate(35,75,165);
	$this->Text(55,120,$company);
	$this->Rotate(0);
	$this->SetTextColor(0,0,0);
}

function addCashBoarder()
{
	$this->SetFont( "dejavusans", "B", 8);
	$r1  = 10;
	$r2  = $r1 + 128;
	$y1  = $this->h - 28;
	$y2  = $y1+20;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
}

}
?>
