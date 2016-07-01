<?php session_start();
    include('../lib/conexions.php');
    if ($_GET['action']=='add') {
        $data = json_decode(file_get_contents("php://input"));
        $estado = 1;
        if ($data->serobs=="") {
            $observser = "Ninguna";
        }
        else{
            $observser = $data->serobs;
        }
        $sentencia = $conn->prepare("INSERT INTO servicios (idcats, descripcionser, fechaser, costo, observacionser, estadoser) VALUES (:data0, :data1, :data2, :data3, :data4, :data5)");
        $sentencia->bindParam(':data0', $data->sercat);
        $sentencia->bindParam(':data1', $data->serdes);
        $sentencia->bindParam(':data2', $data->serfech);
        $sentencia->bindParam(':data3', $data->sercos);
        $sentencia->bindParam(':data4', $observser);
        $sentencia->bindParam(':data5', $estado);
        $sentencia->execute();
        echo "ok";
    } else{
        if ($_GET['action']=='getc') {
            $idcat = $_GET['idc'];
            $estilo = "";
            $estado = "";
            $num = 0;
            $datos = array();
            $resultado=$conn->query("SELECT * FROM servicios WHERE idcats='$idcat' ORDER BY idser");
            foreach($resultado as $registro){
                switch ($registro['estadoser']) {
                    case 0:
                        $estado = "No activo";
                        $estilo = "label-danger";
                        break;
                    case 1:
                        $estado = "Activo";
                        $estilo = "label-success";
                        break;
                }
                $datos[] = array(
                    'num' => ++$num,
                    'iser' => $registro['idser'],
                    'icat' => $registro['idcats'],
                    'desc' => $registro['descripcionser'],
                    'fech' => $registro['fechaser'],
                    'cost' => $registro['costo'],
                    'obse' => $registro['observacionser'],
                    'esta' => $registro['estadoser'],
                    'estan' => $estado,
                    'estilo' => $estilo
                );
            }
            echo json_encode($datos);
        } else{
            if ($_GET['action']=='upd') {
                $data = json_decode(file_get_contents("php://input"));
                $stmt = $conn->prepare("UPDATE servicios SET idcats = :dat1, descripcionser = :dat2, fechaser = :dat3, costo = :dat4, observacionser = :dat5, estadoser = :dat6 WHERE idser = :dat0");
                $stmt->bindParam(':dat0', $data->iser, PDO::PARAM_INT);
                $stmt->bindParam(':dat1', $data->catser);
                $stmt->bindParam(':dat2', $data->desser);
                $stmt->bindParam(':dat3', $data->fechser);
                $stmt->bindParam(':dat4', $data->cosser);
                $stmt->bindParam(':dat5', $data->obsser);
                $stmt->bindParam(':dat6', $data->estser, PDO::PARAM_INT);
                $stmt->execute();
                echo "ok";
            } else{
                if ($_GET['action']=='del') {
                    $data = json_decode(file_get_contents("php://input"));
                    $sentencia = $conn->prepare("DELETE FROM servicios WHERE idser=:dat0");
                    $sentencia->bindParam(':dat0', $data->iser);
                    $sentencia->execute();
                    echo "ok";
                } else{
                    if ($_GET['action']=='get') {
                        $estado = "";
                        $estilo = "";
                        $num = 0;
                        $datos = array();
                        $resultado=$conn->query("SELECT * FROM servicios ORDER BY idser");
                        foreach($resultado as $registro){
                            switch ($registro['estadoser']) {
                                case 0:
                                    $estado = "No activo";
                                    $estilo = "label-danger";
                                    break;
                                case 1:
                                    $estado = "Activo";
                                    $estilo = "label-success";
                                    break;
                            }
                            $datos[] = array(
                                'num' => ++$num,
                                'iser' => $registro['idser'],
                                'icat' => $registro['idcats'],
                                'desc' => $registro['descripcionser'],
                                'fech' => $registro['fechaser'],
                                'cost' => $registro['costo'],
                                'obse' => $registro['observacionser'],
                                'esta' => $registro['estadoser'],
                                'estan' => $estado,
                                'estilo' => $estilo
                            );
                        }
                        echo json_encode($datos);
                    } else{
                        if ($_GET['action']=='getp') {
                            $datoc = array();
                            $resultado=$conn->query("SELECT idcats, descripcioncats FROM categoriaser WHERE estadocats='1' ORDER BY idcats");
                            foreach($resultado as $registro){
                                $datos = array();
                                $resultser=$conn->query("SELECT idser, descripcionser FROM servicios WHERE idcats='$registro[idcats]' and estadoser='1' ORDER BY idser");
                                foreach($resultser as $regserv){
                                    $datos[] = array(
                                        'iser' => $regserv['idser'],
                                        'desc' => $regserv['descripcionser']
                                    );
                                }
                                $datoc[] = array(
                                    'icat' => $registro['idcats'],
                                    'desc' => $registro['descripcioncats'],
                                    'servs' => $datos
                                );
                            }
                            echo json_encode($datoc);
                        } else{
                            if ($_GET['action']=='pser') {
                                $user = $_SESSION['iop'];
                                $fecha = date("Y-m-d");
                                $fp = fopen("../pdf/serieserv.txt", "r");
                                $nvalor = (int) fgets($fp);
                                fclose($fp);
                                error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
                                $fp = fopen("../pdf/serieserv.txt", "w");
                                fwrite($fp, ($nvalor*1+1).PHP_EOL);
                                fclose($fp);
                                $data = json_decode(file_get_contents("php://input"));
                                $tiempo = $data->tempoe;
                                $descue = $data->descus;
                                if ($tiempo==null) {
                                    $tiempo = "24 hrs";
                                }
                                if ($descue==null) {
                                    $descue = "0";
                                }
                                $sentencia = $conn->prepare("INSERT INTO prestarserv (idu, idcli, servicios, bancoempse, formapuse, detallefpuse, formapdse, detallefpdse, formaptse, detallefptse, formapcse, detallefpcse, tiempopse, lugarse, descuentopse, validezofertase, numeropse, fechapse) VALUES (:data0, :data1, :data2, :data3, :data4, :data5, :data6, :data7, :data8, :data9, :data10, :data11, :data12, :data13, :data14, :data15, :data16, :data17)");
                                $sentencia->bindParam(':data0', $user);
                                $sentencia->bindParam(':data1', $data->cli);
                                $sentencia->bindParam(':data2', $data->sel);
                                $sentencia->bindParam(':data3', $data->cbank);
                                $sentencia->bindParam(':data4', $data->formu);
                                $sentencia->bindParam(':data5', $data->detau);
                                $sentencia->bindParam(':data6', $data->formd);
                                $sentencia->bindParam(':data7', $data->detad);
                                $sentencia->bindParam(':data8', $data->formt);
                                $sentencia->bindParam(':data9', $data->detat);
                                $sentencia->bindParam(':data10', $data->formc);
                                $sentencia->bindParam(':data11', $data->detac);
                                $sentencia->bindParam(':data12', $tiempo);
                                $sentencia->bindParam(':data13', $data->lugar);
                                $sentencia->bindParam(':data14', $descue);
                                $sentencia->bindParam(':data15', $data->valid);
                                $sentencia->bindParam(':data16', $nvalor);
                                $sentencia->bindParam(':data17', $fecha);
                                $sentencia->execute();
                                echo "ok";
                            } else{
                                if ($_GET['action']=='updo') {
                                    $user = $_SESSION['iop'];
                                    $data = json_decode(file_get_contents("php://input"));
                                    $stmt = $conn->prepare("UPDATE prestarserv SET formapuse=:dat2, detallefpuse=:dat3, formapdse=:dat4, detallefpdse=:dat5, formaptse=:dat6, detallefptse=:dat7, formapcse=:dat8, detallefpcse=:dat9 WHERE idpse = :dat0 and idu = :dat1");
                                    $stmt->bindParam(':dat0', $data->iser, PDO::PARAM_INT);
                                    $stmt->bindParam(':dat1', $user);
                                    $stmt->bindParam(':dat2', $data->formu, PDO::PARAM_INT);
                                    $stmt->bindParam(':dat3', $data->detau);
                                    $stmt->bindParam(':dat4', $data->formd, PDO::PARAM_INT);
                                    $stmt->bindParam(':dat5', $data->detad);
                                    $stmt->bindParam(':dat6', $data->formt, PDO::PARAM_INT);
                                    $stmt->bindParam(':dat7', $data->detat);
                                    $stmt->bindParam(':dat8', $data->formc, PDO::PARAM_INT);
                                    $stmt->bindParam(':dat9', $data->detac);
                                    $stmt->execute();
                                } else{
                                    if ($_GET['action']=='getd') {
                                        $user = $_SESSION['iop'];
                                        $data = json_decode(file_get_contents("php://input"));
                                        $fecha = $data->fechas;//$fecha = restardias(1, $data->fechas);
                                        $num = 0;
                                        $datos = array();
                                        $resultado=$conn->query("SELECT ps.idpse, cl.idcli, cl.nombrecli, cl.razonempcli, ps.servicios, ps.formapuse, ps.detallefpuse, ps.formapdse, ps.detallefpdse, ps.formaptse, ps.detallefptse, ps.formapcse, ps.detallefpcse, ps.tiempopse FROM clientes cl, prestarserv ps WHERE ps.idu='$user' AND ps.fechapse='$fecha' AND cl.idcli=ps.idcli ORDER BY ps.idpse");
                                        foreach($resultado as $registro){
                                            if (($registro['formapuse']+$registro['formapdse']+$registro['formaptse']+$registro['formapcse'])==100) {
                                                $estado = true;
                                                $estilo = "label-success";
                                            }elseif(($registro['formapuse']+$registro['formapdse']+$registro['formaptse']+$registro['formapcse'])<100){
                                                $estado = false;
                                                $estilo = "label-warning";
                                            }else{
                                                $estado = false;
                                                $estilo = "label-danger";
                                            }
                                            $datos[] = array(
                                                'num' => ++$num,
                                                'ipse' => $registro['idpse'],
                                                'icli' => $registro['idcli'],
                                                'iserv' => $registro['servicios'],
                                                'nomc' => $registro['nombrecli'],
                                                'razon' => $registro['razonempcli'],
                                                'forms' => $registro['formapuse']+$registro['formapdse']+$registro['formaptse']+$registro['formapcse'],
                                                'formpu' => $registro['formapuse'],
                                                'detalu' => $registro['detallefpuse'],
                                                'formpd' => $registro['formapdse'],
                                                'detald' => $registro['detallefpdse'],
                                                'formpt' => $registro['formaptse'],
                                                'detalt' => $registro['detallefptse'],
                                                'formpc' => $registro['formapcse'],
                                                'detalc' => $registro['detallefpcse'],
                                                'tiempo' => $registro['tiempopse'],
                                                'stilo' => $estilo,
                                                'actbtn' => $estado
                                            );
                                        }
                                        echo json_encode($datos);
                                    } else{
                                        if ($_GET['action']=='getm') {
                                            $user = $_SESSION['iop'];
                                            $data = json_decode(file_get_contents("php://input"));
                                            $fecha = $data->fechas;
                                            $num = 0;
                                            $datos = array();
                                            $resultado=$conn->query("SELECT ps.idpse, cl.idcli, cl.nombrecli, cl.razonempcli, ps.servicios, ps.formapuse, ps.detallefpuse, ps.formapdse, ps.detallefpdse, ps.formaptse, ps.detallefptse, ps.formapcse, ps.detallefpcse, ps.tiempopse FROM clientes cl, prestarserv ps WHERE ps.idu='$user' AND ps.fechapse LIKE '$fecha%' AND cl.idcli=ps.idcli ORDER BY ps.idpse");
                                            foreach($resultado as $registro){
                                                if (($registro['formapuse']+$registro['formapdse']+$registro['formaptse']+$registro['formapcse'])==100) {
                                                    $estado = true;
                                                    $estilo = "label-success";
                                                }elseif(($registro['formapuse']+$registro['formapdse']+$registro['formaptse']+$registro['formapcse'])<100){
                                                    $estado = false;
                                                    $estilo = "label-warning";
                                                }else{
                                                    $estado = false;
                                                    $estilo = "label-danger";
                                                }
                                                $datos[] = array(
                                                    'num' => ++$num,
                                                    'ipse' => $registro['idpse'],
                                                    'icli' => $registro['idcli'],
                                                    'iserv' => $registro['servicios'],
                                                    'nomc' => $registro['nombrecli'],
                                                    'razon' => $registro['razonempcli'],
                                                    'forms' => $registro['formapuse']+$registro['formapdse']+$registro['formaptse']+$registro['formapcse'],
                                                    'formpu' => $registro['formapuse'],
                                                    'detalu' => $registro['detallefpuse'],
                                                    'formpd' => $registro['formapdse'],
                                                    'detald' => $registro['detallefpdse'],
                                                    'formpt' => $registro['formaptse'],
                                                    'detalt' => $registro['detallefptse'],
                                                    'formpc' => $registro['formapcse'],
                                                    'detalc' => $registro['detallefpcse'],
                                                    'tiempo' => $registro['tiempopse'],
                                                    'stilo' => $estilo,
                                                    'actbtn' => $estado
                                                );
                                            }
                                            echo json_encode($datos);
                                        } else{
                                            if ($_GET['action']=='geta') {
                                                $user = $_SESSION['iop'];
                                                $data = json_decode(file_get_contents("php://input"));
                                                $fecha = $data->fechas;
                                                $num = 0;
                                                $datos = array();
                                                $resultado=$conn->query("SELECT ps.idpse, cl.idcli, cl.nombrecli, cl.razonempcli, ps.servicios, ps.formapuse, ps.detallefpuse, ps.formapdse, ps.detallefpdse, ps.formaptse, ps.detallefptse, ps.formapcse, ps.detallefpcse, ps.tiempopse FROM clientes cl, prestarserv ps WHERE ps.idu='$user' AND ps.fechapse LIKE '$fecha%' AND cl.idcli=ps.idcli ORDER BY ps.idpse");
                                                foreach($resultado as $registro){
                                                    if (($registro['formapuse']+$registro['formapdse']+$registro['formaptse']+$registro['formapcse'])==100) {
                                                        $estado = true;
                                                        $estilo = "label-success";
                                                    }elseif(($registro['formapuse']+$registro['formapdse']+$registro['formaptse']+$registro['formapcse'])<100){
                                                        $estado = false;
                                                        $estilo = "label-warning";
                                                    }else{
                                                        $estado = false;
                                                        $estilo = "label-danger";
                                                    }
                                                    $datos[] = array(
                                                        'num' => ++$num,
                                                        'ipse' => $registro['idpse'],
                                                        'icli' => $registro['idcli'],
                                                        'iserv' => $registro['servicios'],
                                                        'nomc' => $registro['nombrecli'],
                                                        'razon' => $registro['razonempcli'],
                                                        'forms' => $registro['formapuse']+$registro['formapdse']+$registro['formaptse']+$registro['formapcse'],
                                                        'formpu' => $registro['formapuse'],
                                                        'detalu' => $registro['detallefpuse'],
                                                        'formpd' => $registro['formapdse'],
                                                        'detald' => $registro['detallefpdse'],
                                                        'formpt' => $registro['formaptse'],
                                                        'detalt' => $registro['detallefptse'],
                                                        'formpc' => $registro['formapcse'],
                                                        'detalc' => $registro['detallefpcse'],
                                                        'tiempo' => $registro['tiempopse'],
                                                        'stilo' => $estilo,
                                                        'actbtn' => $estado
                                                    );
                                                }
                                                echo json_encode($datos);
                                            }else{
                                                if ($_GET['action']=='delo') {
                                                    $data = json_decode(file_get_contents("php://input"));
                                                    $sentencia = $conn->prepare("DELETE FROM prestarserv WHERE idpse=:dat0");
                                                    $sentencia->bindParam(':dat0', $data->iser);
                                                    $sentencia->execute();
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    $conn = null;
function restardias($numdias, $fechasis) {
    if (isset($date)) {
    $date = time();
    }
    list($anno, $mes, $dia, $seg, $min, $hora) = explode( "-", $fechasis);
    $d = $dia - $numdias;
    $fecha = date("Y-m-d", mktime($hora, $min, $seg, $mes, $d, $anno));
    return $fecha;
}
?>