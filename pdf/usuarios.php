<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
/*$nr=$_POST['nrep'];
$ci=$_POST['cirep'];
$nomr=$_POST['nombrerep'];
$telfr=$_POST['telfrep'];
$fecr=$_POST['fechrep'];
$zonr=$_POST['zonarep'];
$dir=$_POST['direcrep'];

$vnr=explode("|",$nr);
$vci=explode("|",$ci);
$vnomr=explode("|",$nomr);
$vtelf=explode("|",$telfr);
$vfech=explode("|",$fecr);
$vzon=explode("|",$zonr);
$vdir=explode("|",$dir);*/
require('../lib/fpdf.php');
class PDF extends FPDF {
    function Header() {
        $this->Image('../img/logo.jpg',15,5,45,15);   // left, top, width, height        
        $fecharep = date("m");
        $mes = "";
        if($fecharep=='01'){ $mes = "ENERO"; }
        else{ if($fecharep=='02'){ $mes = "FEBRERO"; }
        else{ if($fecharep=='03'){ $mes = "MARZO"; }
        else{ if($fecharep=='04'){ $mes = "ABRIL"; }
        else{ if($fecharep=='05'){ $mes = "MAYO"; }
        else{ if($fecharep=='06'){ $mes = "JUNIO"; }
        else{ if($fecharep=='07'){ $mes = "JULIO"; }
        else{ if($fecharep=='08'){ $mes = "AGOSTO"; }
        else{ if($fecharep=='09'){ $mes = "SEPTIEMBRE"; }
        else{ if($fecharep=='10'){ $mes = "OCTUBRE"; }
        else{ if($fecharep=='11'){ $mes = "NOVIEMBRE"; }
        else{ if($fecharep=='12'){ $mes = "DICIEMBRE"; }
        }   }   }   }   }   }   }   }   }   }   }
    
        $this->SetFont('Times','B',10);
        $this->SetXY(22,4);
        $this->Cell(0,40,'LISTADO DE USUARIOS REGISTRADOS',0,1,'C');
        $this->Ln(12);
        $this->SetFont('Times','B',8);
        $this->SetXY(22,8);
        $this->Cell(0,40,'FECHA: '.date("d")." DE ".$mes." DE ".date("Y"), 0, 1, 'C');
        $this->Ln(12);
        $this->SetXY(18,35);
        $this->SetFont('Times','B',8);
        $this->SetFillColor(139,217,247);
        $this->Cell(35,7,'CUENTA',1,0,'C',true);
        $this->Cell(65,7,'NOMBRE COMPLETO',1,0,'C',true);
        $this->Cell(25,7,'C.I.',1,0,'C',true);
        $this->Cell(25,7,'FECHA INGRESO',1,0,'C',true);
        $this->Cell(30,7,'FUNCIÓN',1,1,'C',true);
    }
    var $B;  var $I;  var $U;  var $HREF;
    function PDF($orientation='P', $unit='mm', $size='Letter') {
        $this->FPDF($orientation,$unit,$size);
        $this->B = 0;
        $this->I = 0;
        $this->U = 0;
        $this->HREF = '';
        $this->SetMargins(18, 20 , 10);
    }
    //Pie de página
    function Footer() {
        $doc="Página ";
        $pagina=$this->PageNo().' - {nb}';
        //$Posición: a 1,5 cm del final
        $this->SetY(-18);
        $this->SetX(182);
        //Arial italic 8
        $this->SetFont('Arial','I',8);
        //Número de página
        $this->Line(20,286, 180, 286);
        $this->Cell(127,3,$doc."  ".$pagina,0,0,'L');   
    }
}

$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
$pdf->SetFillColor(255,255,255);
require("../lib/conexions.php");
$resultado=$conn->query("SELECT * FROM usuarios ORDER BY idu");
    foreach($resultado as $registro) {
        switch ($registro['expedidous']) {
            case 1:
                $ciudad = "CHQ";
                break;
            case 2:
                $ciudad = "LPZ";
                break;
            case 3:
                $ciudad = "CBA";
                break;
            case 4:
                $ciudad = "SCZ";
                break;
            case 5:
                $ciudad = "OR";
                break;
            case 6:
                $ciudad = "PT";
                break;
            case 7:
                $ciudad = "TJA";
                break;
            case 8:
                $ciudad = "BNI";
                break;
            case 9:
                $ciudad = "PND";
                break;
        }
        switch ($registro['funcionus']) {
            case 'a':
                $funcion = "Administrador";
                break;
            case 'o':
                $funcion = "Operador";
                break;
        }
        $pdf->Cell(35,6,$registro['usuario'],1,0,'L',true);
        $pdf->Cell(65,6,utf8_decode($registro['nombreus'].' '. $registro['apellidous']),1,0,'L',true);
        $pdf->Cell(25,6,$registro['cedulaus'].' '.$ciudad,1,0,'C',true);
        $pdf->Cell(25,6,$registro['fechaus'],1,0,'C',true);
        $pdf->Cell(30,6,$funcion,1,1,'L',true);
    }
    $pdf->SetFont('Arial','B',6);
    $pdf->SetAutoPageBreak(true,10);
$pdf->Output();
?>