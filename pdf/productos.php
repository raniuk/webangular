<?php session_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$nom=$_POST['rnomb'];
$prv=$_POST['rprov'];
$fec=$_POST['rfech'];
$can=$_POST['rcant'];
$pre=$_POST['rprec'];
$des=$_POST['rdesc'];
$est=$_POST['resta'];

$vnom=explode("|",$nom);
$vprv=explode("|",$prv);
$vfec=explode("|",$fec);
$vcan=explode("|",$can);
$vpre=explode("|",$pre);
$vdes=explode("|",$des);
$vest=explode("|",$est);

require('../lib/fpdf.php');
class PDF extends FPDF {
    //Develop by Author: Olivier    License: FPDF
    var $widths;
    var $aligns;
    function SetWidths($w) {
        $this->widths=$w;
    }
    function SetAligns($a) {
        $this->aligns=$a;
    }
    function Row($data) {
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=5*$nb;
        $this->CheckPageBreak($h);
        for($i=0;$i<count($data);$i++){
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $x=$this->GetX();
            $y=$this->GetY();
            $this->Rect($x,$y,$w,$h);
            $this->MultiCell($w,5,$data[$i],0,$a);
            $this->SetXY($x+$w,$y);
        }
        $this->Ln($h);
    }
    function CheckPageBreak($h) {
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }
    function NbLines($w,$txt) {
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb){
            $c=$s[$i];
            if($c=="\n"){
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax){
                if($sep==-1){
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
    //End external code
    function Header(){
        $mes = date("m");
        if ($mes==1) { $mes = "Enero"; }
        else{ if ($mes==2) { $mes = "Febrero"; }
        else{ if ($mes==3) { $mes = "Marzo"; }
        else{ if ($mes==4) { $mes = "Abril"; }
        else{ if ($mes==5) { $mes = "Mayo"; }
        else{ if ($mes==6) { $mes = "Junio"; }
        else{ if ($mes==7) { $mes = "Julio"; }
        else{ if ($mes==8) { $mes = "Agosto"; }
        else{ if ($mes==9) { $mes = "Septiembre"; }
        else{ if ($mes==10) { $mes = "Octubre"; }
        else{ if ($mes==11) { $mes = "Noviembre"; }
        else{ if ($mes==12) { $mes = "Diciembre"; }
        }   }   }   }   }   }   }   }   }   }   }
        $margensup = 10;
        $this->Image('../public/img/avatar.png',15,10,50,15);
        $this->SetXY(115,$margensup+2);
        $this->SetFont('Arial','',8);
        $this->Cell(0,5, date('d').' de '.$mes.' de '.date('Y'), 0, 1, 'R');
        $this->SetFont('Arial','B',12);
        $this->SetXY(15,$margensup*1.5);
        $this->Cell(0,20, 'REPORTE DE PRODUCTOS', 0, 1, 'C');
        $this->SetFont('Arial','',11);
        $this->SetXY(15,$margensup*2);
        $this->Cell(0,20, "Administrador: ".utf8_decode($_SESSION['uname']), 0, 1, 'C');
        
        $this->SetXY(15,$margensup*3.5);
        $this->SetFont('Arial','B',7);
        $this->SetFillColor(139,217,247);
        $this->Cell(9,6,utf8_decode('N°'),1,0,'C',true);
        $this->Cell(51,6,'NOMBRE PRODUCTO',1,0,'C',true);
        $this->Cell(48,6,'PROVEEDOR',1,0,'C',true);
        $this->Cell(20,6,'CANTIDAD',1,0,'C',true);
        $this->Cell(26,6,'PRECIO (u)',1,0,'C',true);
        $this->Cell(20,6,'FECHA',1,0,'C',true);
        $this->Cell(60,6,'DESCRIPCION',1,0,'C',true);
        $this->Cell(16,6,'ESTADO',1,1,'C',true);
    }
    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',6);
        $this->Cell(0,5,utf8_decode('Página ').$this->PageNo().'-{nb}',0,0,'C');
    }

    function PDF($orientation='L', $unit='mm', $size='letter') {//array(215.9,355.6)
        $this->FPDF($orientation,$unit,$size);
        $this->SetMargins(15, 10, 15);
        $this->SetAutoPageBreak(true,15);
    }
}
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',7.2);
$pdf->SetFillColor(255,255,255);
if (count($vnom)>0) {
    $pdf->SetWidths(array(9,51,48,20,26,20,60,16));
    $pdf->SetAligns(array('L','L','L','C','C','C','L','C'));
    for($i=0;$i<count($vnom);$i++){        
        $pdf->Row(array($i+1,utf8_decode($vnom[$i]),utf8_decode($vprv[$i]),$vcan[$i],$vpre[$i],$vfec[$i],utf8_decode($vdes[$i]),$vest[$i]));
    }
    $pdf->Output();
}
else {
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(0,5,utf8_decode("No existe datos"),1,1,'L', true);
    $pdf->Output();
}
?>