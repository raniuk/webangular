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
        $this->Cell(0,20, 'PRESTACION DE SERVICIOS', 0, 1, 'C');
        $this->SetFont('Arial','',11);
        $this->SetXY(15,$margensup*4.1);
        $this->Cell(88,5.2*4.7,'',1,0,'C',false);
        include('../lib/conexions.php');
        $cliente = $_POST['rcli'];
        $user = $_SESSION['iop'];
        $fecha = date("Y-m-d");
        $queryemp=$conn->query("SELECT razonemp, direccionemp, numeroemp, zonaemp, telefonoemp, correoemp FROM empresa ORDER BY idemp DESC LIMIT 1")->fetch();
        $selectuven=$conn->query("SELECT numeropse FROM prestarserv WHERE idu='$user' AND idcli='$cliente' ORDER BY idpse DESC LIMIT 1")->fetch();
        $correlativo = "";
        $tam = (int) strlen($selectuven['numeropse']);
        for ($i = 0; $i<8-$tam; $i++) {
            $correlativo = $correlativo.'0';
        }
        $correlativo = $correlativo.$selectuven['numeropse'];
        $this->SetXY(15,$margensup*3.5);
        $this->SetFont('Arial','B',10);
        $this->SetFillColor(139,217,247);
        $this->Cell(88,6,'SERVICIO',1,0,'C',true);
        $this->Cell(56,6,'GMZ.SER/'.$correlativo.'-'.substr(date('Y'),2,3),1,0,'C',true);
        $this->Cell(42,6,'FECHA '.$fecha,1,1,'C',true);
        $this->SetFont('Arial','',10);
        $this->SetFillColor(255,255,255);
        $this->Cell(81,5.5,utf8_decode($queryemp['razonemp']),0,1,'L',false);
        $this->Cell(81,4.5,utf8_decode('Dirección: ').$queryemp['direccionemp'].utf8_decode(' N° ').$queryemp['numeroemp'],0,1,'L',false);
        $this->Cell(88,4.5,'Zona: '.$queryemp['zonaemp'],0,1,'L',false);
        $this->Cell(88,4.5,utf8_decode('Teléfono: '.$queryemp['telefonoemp']),0,1,'L',false);
        $this->Cell(88,4.5,$queryemp['correoemp'],0,1,'L',false);
        $this->SetXY(103,$margensup*4.1);
        $querycli=$conn->query("SELECT tipocli, cinitcli, nombrecli, razonempcli, telefonocli, correocli FROM clientes WHERE idcli='$cliente'")->fetch();
        if ($querycli['tipocli']==1) {
            $tipocliente = "EMPRESA NIT: ".$querycli['cinitcli'];
        }else{
            $tipocliente = "PERSONA CI: ".$querycli['cinitcli'];
        }
        $this->Cell(18,10.5,'CLIENTE',1,0,'L',false);
        $this->Cell(80,10.5,$tipocliente,1,1,'L',false);
        $this->SetXY(103,$margensup*5.15);
        $this->Cell(18,7,'Nombre',1,0,'L',false);
        $this->Cell(80,7,$querycli['nombrecli'],1,1,'L',false);
        $this->SetXY(103,$margensup*5.86);
        $this->Cell(18,7,'Empresa',1,0,'L',false);
        $this->Cell(80,7,$querycli['razonempcli'],1,1,'L',false);
        $this->Cell(18,5.5,'Vendedor',1,0,'L',false);
        $queryuse=$conn->query("SELECT nombreus FROM usuarios WHERE idu='$user' LIMIT 1")->fetch();
        $this->Cell(70,5.5,$queryuse['nombreus'],1,0,'L',false);
        $this->Cell(18,5.5,utf8_decode('Teléfono'),1,0,'L',false);
        $this->Cell(80,5.5,$querycli['telefonocli'],1,1,'L',false);

        $this->Cell(18,5.5,'Servicio',1,0,'L',false);
        $this->Cell(70,5.5,'---',1,0,'L',false);
        $this->Cell(18,5.5,'Correo',1,0,'L',false);
        $this->Cell(80,5.5,$querycli['correocli'],1,1,'L',false);
        $this->ln(5);
    }
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
$pdf->ln(5);
$pdf->Cell(0,5,utf8_decode('Atendiendo a su amable solicitud de servicio, a continuación se detallan los servicios a prestar:'),0,0,'L',false);
$pdf->ln(10);
$pdf->SetFont('Arial','B',9.5);
$pdf->SetFillColor(139,217,247);
$pdf->Cell(156,10,'CATEGORIAS Y SERVICIOS',1,0,'C',true);
$pdf->Cell(30,10,'PRECIO',1,1,'C',true);
$subtotal = 0;
$servi = $_POST['rservs'];
$cambio = $_SESSION['tcamb'];
$serviprest = explode('|', $servi);
$selectcat=$conn->query("SELECT idcats, descripcioncats FROM categoriaser WHERE estadocats='1' ORDER BY idcats");
foreach ($selectcat as $datacat) {
    $pdf->SetFont('Arial','B',9.5);
    $pdf->SetWidths(array(186));
    $pdf->SetAligns(array('L'));
    $j = 2; $sw=false;
    while ($j <= count($serviprest)) {
        if ($datacat['idcats']==$serviprest[$j]) {
            $sw = true;
            break;
        }
        $j = $j + 2;
    }
    if ($sw) {
        $pdf->Row(array(utf8_decode($datacat['descripcioncats'])));
    }
    $pdf->SetFont('Arial','',9.5);
    $i = 2;
    $pdf->SetWidths(array(156,30));
    $pdf->SetAligns(array('L','C'));
    while ($i <= count($serviprest)) {
        if ($datacat['idcats']==$serviprest[$i]) {
            $iserv = $serviprest[$i-1];
            $selectserv=$conn->query("SELECT descripcionser, costo FROM servicios WHERE idcats='$datacat[idcats]' AND idser='$iserv' LIMIT 1")->fetch();
            $subtotal = $subtotal+$selectserv['costo'];
            $pdf->Row(array(utf8_decode($selectserv['descripcionser']),redondear($selectserv['costo'])));
        }
        $i = $i + 2;
    }
}
//$idpse = $_POST['rips'];
$cliente = $_POST['rcli'];
$user = $_SESSION['iop'];
$selectuven=$conn->query("SELECT bancoempse, formapuse, detallefpuse, formapdse, detallefpdse, formaptse, detallefptse, formapcse, detallefpcse, tiempopse, lugarse, descuentopse, validezofertase FROM prestarserv WHERE idu='$user' AND idcli='$cliente' ORDER BY idpse DESC LIMIT 1")->fetch();
$descuento = $selectuven['descuentopse'];
/*for($j=0; $j<12-($i/2);$j++){
    $pdf->Row(array("",""));
}*/
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
$pdf->ln(8);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,5,utf8_decode('Formalidades de la cotización de los servicios:'),0,1,'L',true);
$pdf->ln(3);
$pdf->SetWidths(array(40,146));
$pdf->SetAligns(array('L','L'));
$pdf->SetFont('Arial','',10);
if ($selectuven['bancoempse']==1) {
    $queryemp=$conn->query("SELECT bancoemp, cuentamnemp, cuentamnemp FROM empresa ORDER BY idemp DESC LIMIT 1")->fetch();
    $cuentasel = utf8_decode('Con deposito en las cuentas de '.$queryemp['bancoemp'].' Cta. '.$queryemp['cuentamnemp'].' Moneda Nacional y Cta. '.$queryemp['cuentamnemp'].' Dólares Americanos.');
}elseif($selectuven['bancoempse']==2){
    $queryemp=$conn->query("SELECT bancodemp, cuentadmnemp, cuentadsusemp FROM empresa ORDER BY idemp DESC LIMIT 1")->fetch();
    $cuentasel = utf8_decode('Con deposito en las cuentas de '.$queryemp['bancodemp'].' Cta. '.$queryemp['cuentadmnemp'].' Moneda Nacional.');
}
$pdf->Row(array(utf8_decode('Tiempo de Ejecución'),utf8_decode($selectuven['tiempopse'])));
$pdf->Row(array('Lugar de Trabajo',utf8_decode($selectuven['lugarse'])));
$pdf->Row(array('Forma de Pago',$selectuven['formapuse'].'% '.utf8_decode($selectuven['detallefpuse'])."\n".$selectuven['formapdse'].'% '.utf8_decode($selectuven['detallefpdse'])."\n".$selectuven['formaptse'].'% '.utf8_decode($selectuven['detallefptse'])."\n".$selectuven['formapcse'].'% '.utf8_decode($selectuven['detallefpcse'])));
$pdf->Row(array('Cuenta Bancaria',$cuentasel));
$pdf->Row(array('Condiciones del Pago',utf8_decode('Por toda compra mayor a Bs. 50,000.00 se debe cancelar con cheque o deposito en la cuenta bancaria y el depositante debe ser el mismo de la factura emitida.')));
$pdf->Row(array('Precio con Factura',utf8_decode('Expresada en bolivianos (Bs), al tipo de cambio oficial del día.')));
$pdf->Row(array('Validez de la Oferta',$selectuven['validezofertase'].utf8_decode(' días y/o a confirmación de stock.')));
$pdf->Output();
$conn = null;
function redondear($value){
    return round($value*100)/100;
}
?>