<?php session_start();
    include('../lib/conexions.php');
    require_once '../lib/Classes/PHPExcel.php';
    require_once '../lib/Classes/PHPExcel/IOFactory.php';
    $fecha = $_POST['rfecha'];
    $user = $_SESSION['iop'];
    $mes = substr($fecha,5,7);
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
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->
    getProperties()
        ->setCreator("GMZBol")
        ->setLastModifiedBy("GMZBol")
        ->setTitle("Reporte diaria de ventas")
        ->setSubject("Reporte diaria")
        ->setDescription("Reporte diaria de ventas")
        ->setKeywords("GMZBol")
        ->setCategory("Reportes");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
    //$objSheet = $objPHPExcel->setActiveSheetIndex(0);
    $objSheet = $objPHPExcel->setActiveSheetIndex();
    $objSheet->setCellValue('A1', 'REPORTE DIARIA DE VENTAS'." - ".substr($fecha,8,10)." de ".$mes." de ".substr($fecha,0,4));
    $objSheet->setCellValue('A2', 'Nro');
    $objSheet->setCellValue('B2', '    CLIENTE    ');
    $objSheet->setCellValue('C2', '    EMPRESA     ');
    $objSheet->setCellValue('D2', 'FORMA DE PAGO');
    $objSheet->setCellValue('E2', 'CUENTA');
    $objSheet->setCellValue('F2', 'TIEMPO DE ENTREGA');
    $objSheet->setCellValue('G2', '  SERIE  ');
    $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
    
    $resultado=$conn->query("SELECT ve.bancoempven, ve.formapuven, ve.formapdven, ve.formaptven, ve.formapcven, ve.tiempoven, ve.numeroven, cl.nombrecli, cl.razonempcli FROM ventas ve, clientes cl WHERE ve.idu='$user' and ve.fechaven LIKE '$fecha%' and ve.idcli=cl.idcli ORDER BY ve.idven DESC");
    $i = 3;
    foreach($resultado as $registro){
        $serie = "GMZ.VEN/";
        $tam = (int) strlen($registro['numeroven']);
        for ($j = 0; $j<8-$tam; $j++) {
            $serie = $serie.'0';
        }
        $serie = $serie.$registro['numeroven'];
        if ($registro['bancoempven']==1) {
            $queryemp=$conn->query("SELECT bancoemp FROM empresa ORDER BY idemp DESC LIMIT 1")->fetch();
            $banco = $queryemp['bancoemp'];
        }elseif ($registro['bancoempven']==2) {
            $queryemp=$conn->query("SELECT bancodemp FROM empresa ORDER BY idemp DESC LIMIT 1")->fetch();
            $banco = $queryemp['bancodemp'];
        }
        $objSheet->setCellValue('A'.$i, $i-2);
        $objSheet->setCellValue('B'.$i, $registro['nombrecli']);
        $objSheet->setCellValue('C'.$i, $registro['razonempcli']);
        $objSheet->setCellValue('D'.$i, ($registro['formapuven']+$registro['formapdven']+$registro['formaptven']+$registro['formapcven'])."%");
        $objSheet->setCellValue('E'.$i, $banco);
        $objSheet->setCellValue('F'.$i, $registro['tiempoven']);
        $objSheet->setCellValue('G'.$i, $serie);
        $i++;
    }
    $estiloTitulo = array(
        'font' => array(
            'name'      => 'Verdana',
            'bold'      => true,
            'italic'    => false,
            'strike'    => false,
            'size' =>12,
                'color'     => array(
                    'rgb' => '202020'
                )
        ),
        'fill' => array(
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('argb' => 'FFFFFFFF')
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_NONE
            )
        ), 
        'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation'   => 0,
                'wrap'          => FALSE
        )
    );
    $estiloTituloReporte = array(
        'font' => array(
            'name'      => 'Verdana',
            'bold'      => true,
            'italic'    => false,
            'strike'    => false,
            'size' =>10,
                'color'     => array(
                    'rgb' => '212121'
                )
        ),
        'fill' => array(
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('argb' => 'FFd8e7fa')
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_NONE
            )
        ), 
        'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation'   => 0,
                'wrap'          => FALSE
        )
    );
    $estiloTituloColumnas = array(
        'font' => array(
            'name'      => 'Arial',
            'bold'      => FALSE,
            'size' =>10,
            'color'     => array(
                'rgb' => '212121'
            )
        ),
        'fill'  => array(
            'endcolor'   => array(
                'argb' => 'FF431a5d'
            )
        ),
        'borders' => array(
            'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                'color' => array(
                    'rgb' => '56a6f7'
                )
            ),
            'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                'color' => array(
                    'rgb' => '56a6f7'
                )
            )
        ),
        'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'          => FALSE
    ));
    $estiloInformacion = new PHPExcel_Style();
    $estiloInformacion->applyFromArray(
        array(
            'font' => array(
            'name'      => 'Arial',
            'color'     => array(
                'rgb' => '000000'
            )
        ),
        'fill'  => array(
            'type'      => PHPExcel_Style_Fill::FILL_SOLID,
            'color'     => array('argb' => 'FFd9b7f4')
        ),
        'borders' => array(
            'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN ,
                'color' => array(
                    'rgb' => '3a2a47'
                )
            )
        )
    ));
    for ($fila=0; $fila < $i; $fila++) { 
        $objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':'.'G'.$fila)->applyFromArray($estiloTituloColumnas);
    }
    $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($estiloTitulo);
    $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($estiloTituloReporte);
    //$objPHPExcel->getActiveSheet()->freezePane('G3');
    $objPHPExcel->getActiveSheet()->freezePaneByColumnAndRow(0,2);
    //$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A2:D4");
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="rdiaria.xls"');
    header('Cache-Control: max-age=0');

    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    $objWriter->save('php://output');
    exit;
    $conn = null;
?>
