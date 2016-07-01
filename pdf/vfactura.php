<?php session_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
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
        $h=5.5*$nb;
        $this->CheckPageBreak($h);
        for($i=0;$i<count($data);$i++){
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $x=$this->GetX();
            $y=$this->GetY();
            $this->Rect($x,$y,$w,$h);
            $this->MultiCell($w,5.5,$data[$i],0,$a);
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
        $margensup = 10;
        $this->Image('../public/img/avatar.png',15,10,60,20);
        $this->SetFont('Arial','B',12);
        $this->SetXY(15,$margensup*1.7);
        $this->Cell(0,20, 'VENTA DE PRODUCTOS', 0, 1, 'C');
        $this->SetFont('Arial','',11);
        $this->SetXY(15,$margensup*4.1);
        $this->Cell(88,5.2*4.7,'',1,0,'C',false);
        include('../lib/conexions.php');
        $cliente = $_POST['rcli'];
        $venta = $_POST['rven'];
        $user = $_SESSION['iop'];
        $fecha = date("Y-m-d");
        $queryemp=$conn->query("SELECT razonemp, direccionemp, numeroemp, zonaemp, telefonoemp, correoemp FROM empresa ORDER BY idemp DESC LIMIT 1")->fetch();
        $queryuse=$conn->query("SELECT nombreus FROM usuarios WHERE idu='$user' LIMIT 1")->fetch();
        $querycli=$conn->query("SELECT tipocli, cinitcli, nombrecli, razonempcli, telefonocli, correocli FROM clientes WHERE idcli='$cliente'")->fetch();
        $selectuven=$conn->query("SELECT numeroven FROM ventas WHERE idu='$user' AND idcli='$cliente' AND idven='$venta' LIMIT 1")->fetch();
        if ($querycli['tipocli']==1) {
            $tipocliente = "EMPRESA NIT: ".$querycli['cinitcli'];
        } else {
            $tipocliente = "PERSONA CI: ".$querycli['cinitcli'];
        }
        $correlativo = "";
        $tam = (int) strlen($selectuven['numeroven']);
        for ($i = 0; $i<8-$tam; $i++) {
            $correlativo = $correlativo.'0';
        }
        $correlativo = $correlativo.$selectuven['numeroven'];
        $this->SetXY(15,$margensup*3.5);
        $this->SetFont('Arial','B',10);
        $this->SetFillColor(139,217,247);
        $this->Cell(88,6,'VENTA',1,0,'C',true);
        $this->Cell(56,6,'GMZ.VEN/'.$correlativo.'-'.substr(date('Y'),2,3),1,0,'C',true);
        $this->Cell(42,6,'FECHA '.$fecha,1,1,'C',true);
        $this->SetFont('Arial','',10);
        $this->SetFillColor(255,255,255);
        $this->Cell(81,5.5,utf8_decode($queryemp['razonemp']),0,1,'L',false);
        $this->Cell(81,4.5,utf8_decode('Dirección: ').$queryemp['direccionemp'].utf8_decode(' N° ').$queryemp['numeroemp'],0,1,'L',false);
        $this->Cell(88,4.5,'Zona: '.$queryemp['zonaemp'],0,1,'L',false);
        $this->Cell(88,4.5,utf8_decode('Teléfono: '.$queryemp['telefonoemp']),0,1,'L',false);
        $this->Cell(88,4.5,$queryemp['correoemp'],0,1,'L',false);
        $this->SetXY(103,$margensup*4.1);
        $this->Cell(18,10.5,'CLIENTE',1,0,'L',false);
        $this->Cell(80,10.5,$tipocliente,1,1,'L',false);
        $this->SetXY(103,$margensup*5.15);
        $this->Cell(18,7,'Nombre',1,0,'L',false);
        $this->Cell(80,7,$querycli['nombrecli'],1,1,'L',false);
        $this->SetXY(103,$margensup*5.86);
        $this->Cell(18,7,'Empresa',1,0,'L',false);
        $this->Cell(80,7,$querycli['razonempcli'],1,1,'L',false);
        $this->Cell(18,5.5,'Vendedor',1,0,'L',false);
        $this->Cell(70,5.5,$queryuse['nombreus'],1,0,'L',false);
        $this->Cell(18,5.5,utf8_decode('Teléfono'),1,0,'L',false);
        $this->Cell(80,5.5,$querycli['telefonocli'],1,1,'L',false);
        $this->Cell(18,5.5,'Venta',1,0,'L',false);
        $this->Cell(70,5.5,'---',1,0,'L',false);
        $this->Cell(18,5.5,'Correo',1,0,'L',false);
        $this->Cell(80,5.5,$querycli['correocli'],1,1,'L',false);
        $this->ln(4);
        $conn = null;
    }
    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',6);
        $this->Cell(0,5,utf8_decode('Página ').$this->PageNo().'-{nb}',0,0,'C');
    }
    function PDF($orientation='P', $unit='mm', $size='letter') {//array(215.9,355.6)
        $this->FPDF($orientation,$unit,$size);
        $this->SetMargins(15, 10, 15);
        $this->SetAutoPageBreak(true,20);
    }
}
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
include('../lib/conexions.php');
$pdf->Cell(0,5,'Estimado:',0,1,'L',false);
$pdf->ln(4);
$pdf->Cell(0,5,utf8_decode('Atendiendo a su amable solicitud de venta, a continuación se detallan los productos:'),0,0,'L',false);
$pdf->ln(8);
$pdf->SetFont('Arial','B',9.5);
$pdf->SetFillColor(139,217,247);
$pdf->Cell(10,10,'Item',1,0,'C',true);
$pdf->Cell(18,10,'Cantidad',1,0,'C',true);
$pdf->Cell(18,10,'Unidad',1,0,'C',true);
$pdf->Cell(80,10,utf8_decode('Descripción'),1,0,'C',true);
$pdf->Cell(30,10,'Precio Unit. USD',1,0,'C',true);
$pdf->Cell(30,10,'Precio Total USD',1,1,'C',true);
$cliente = $_POST['rcli'];
$venta = $_POST['rven'];
$user = $_SESSION['iop'];
$selectuven=$conn->query("SELECT idven, bancoempven, formapuven, detallefpuven, formapdven, detallefpdven, formaptven, detallefptven, formapcven, detallefpcven, tiempoven, descuentoven, validezofertaven FROM ventas WHERE idu='$user' AND idcli='$cliente' AND idven='$venta' LIMIT 1")->fetch();
$ivent = $selectuven['idven'];
$descuento = $selectuven['descuentoven'];
$querypro=$conn->query("SELECT tv.cantidadven, pr.nombrepro, pr.unidadpro, pr.precioupro FROM ventaprods tv, productos pr WHERE tv.idpro=pr.idpro and tv.idven='$ivent' ORDER BY tv.idven");
$pdf->SetWidths(array(10,18,18,80,30,30));
$pdf->SetAligns(array('L','C','C','L','C','C'));
$pdf->SetFont('Arial','',9.5);
$cambio = $_SESSION['tcamb'];
$i = 1;
$subtotal = 0;
foreach($querypro as $datospro){
    $subtotal += $datospro['cantidadven']*$datospro['precioupro'];
    $pdf->Row(array($i++,$datospro['cantidadven'],$datospro['unidadpro'],utf8_decode($datospro['nombrepro']),$datospro['precioupro'],redondear($datospro['cantidadven']*$datospro['precioupro'])));
}
for($j=0; $j<9-$i;$j++){
    $pdf->Row(array("","","","","",""));
}
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',9.5);
$pdf->Cell(156,5,'Sub Total',1,0,'R',true);
$pdf->Cell(30,5,redondear($subtotal),1,1,'C',true);
$pdf->Cell(156,5,'(-) Descuento',1,0,'R',true);
$pdf->Cell(30,5,'% '.$descuento,1,1,'C',true);
if ($descuento!=0) {
    $descuento = $subtotal*($descuento/100);
}
$pdf->Cell(156,5,'Total a Pagar Final',1,0,'R',true);
$pdf->Cell(30,5,'$us '.redondear(($subtotal-$descuento)),1,1,'C',true);
$pdf->Cell(146,5,'Total a Pagar Final',1,0,'R',true);
$pdf->Cell(40,5,'Bs '.redondear(($subtotal-$descuento)*$cambio),1,1,'C',true);
$querycli=$conn->query("SELECT direccioncli FROM clientes WHERE idcli='$cliente'")->fetch();
$pdf->ln(6);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,5,utf8_decode('Formalidades de la Cotización:'),0,1,'L',true);
$pdf->ln(3);
$pdf->SetWidths(array(40,146));
$pdf->SetAligns(array('L','L'));
$pdf->SetFont('Arial','',10);
if ($selectuven['bancoempven']==1) {
    $queryemp=$conn->query("SELECT bancoemp, cuentamnemp, cuentamnemp FROM empresa ORDER BY idemp DESC LIMIT 1")->fetch();
    $cuentasel = utf8_decode('Con deposito en las cuentas de '.$queryemp['bancoemp'].' Cta. '.$queryemp['cuentamnemp'].' Moneda Nacional y Cta. '.$queryemp['cuentamnemp'].' Dólares Americanos.');
}elseif($selectuven['bancoempven']==2){
    $queryemp=$conn->query("SELECT bancodemp, cuentadmnemp, cuentadsusemp FROM empresa ORDER BY idemp DESC LIMIT 1")->fetch();
    $cuentasel = utf8_decode('Con deposito en las cuentas de '.$queryemp['bancodemp'].' Cta. '.$queryemp['cuentadmnemp'].' Moneda Nacional.');
}
$pdf->Row(array('Tiempo de Entrega',utf8_decode($selectuven['tiempoven'])));
$pdf->Row(array('Lugar de Entrega',utf8_decode($querycli['direccioncli'])));
$pdf->Row(array('Forma de Pago',$selectuven['formapuven'].'% '.utf8_decode($selectuven['detallefpuven'])."\n".$selectuven['formapdven'].'% '.utf8_decode($selectuven['detallefpdven'])."\n".$selectuven['formaptven'].'% '.utf8_decode($selectuven['detallefptven'])."\n".$selectuven['formapcven'].'% '.utf8_decode($selectuven['detallefpcven'])));
$pdf->Row(array('Cuenta Bancaria',$cuentasel));
$pdf->Row(array('Condiciones del Pago',utf8_decode('Por toda compra mayor a Bs. 50,000.00 se debe cancelar con cheque o deposito en la cuenta bancaria y el depositante debe ser el mismo de la factura emitida.')));
$pdf->Row(array('Precio con Factura',utf8_decode('Expresada en bolivianos (Bs), al tipo de cambio oficial del día.')));
$pdf->Row(array('Validez de la Oferta',$selectuven['validezofertaven'].utf8_decode(' días y/o a confirmación de stock.')));
$pdf->Output();
$conn = null;
function redondear($value){
    return round($value*100)/100;
}
?>