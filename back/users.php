<?php
    include('../lib/conexions.php');
    if ($_GET['action']=='add') {
        $data = json_decode(file_get_contents("php://input"));
        $contra = md5(sha1($data->usecon));
        $fecha = date("Y-m-d");
        $estado = 1;
        $funcion = "o";
        $sentencia = $conn->prepare("INSERT INTO usuarios (usuario, contrasenha, nombreus, cedulaus, expedidous, cargous, telefonous, correous, direccionus, fechaus, funcionus, estadous) VALUES (:data0, :data1, :data2, :data3, :data4, :data5, :data6, :data7, :data8, :data9, :data10, :data11)");
        $sentencia->bindParam(':data0', $data->useuse);
        $sentencia->bindParam(':data1', $contra);
        $sentencia->bindParam(':data2', $data->usenom);
        $sentencia->bindParam(':data3', $data->usedni);
        $sentencia->bindParam(':data4', $data->usepro);
        $sentencia->bindParam(':data5', $data->usecar);
        $sentencia->bindParam(':data6', $data->usetel);
        $sentencia->bindParam(':data7', $data->climail);
        $sentencia->bindParam(':data8', $data->clidir);
        $sentencia->bindParam(':data9', $fecha);
        $sentencia->bindParam(':data10', $funcion);
        $sentencia->bindParam(':data11', $estado);
        $sentencia->execute();
        echo "ok";
    }
    else{
        if ($_GET['action']=='get') {
            $estilo = "";
            $numero = 0;
            $datos = array();
            $resultado=$conn->query("SELECT * FROM usuarios WHERE funcionus!='a' ORDER BY idu");
            foreach($resultado as $registro){
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
                        $ciudad = "ORU";
                        break;
                    case 6:
                        $ciudad = "PSI";
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
                    default:
                        $ciudad = "";
                        break;
                }
                switch ($registro['estadous']) {
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
                    'num' => ++$numero,
                    'ius' => $registro['idu'],
                    'use' => $registro['usuario'],
                    'nomb' => $registro['nombreus'],
                    'dni' => $registro['cedulaus'],
                    'proc' => $registro['expedidous'],
                    'procn' => $ciudad,
                    'carg' => $registro['cargous'],
                    'telf' => $registro['telefonous'],
                    'corr' => $registro['correous'],
                    'dire' => $registro['direccionus'],
                    'fech' => $registro['fechaus'],
                    'est' => $registro['estadous'],
                    'estn' => $estado,
                    'esti' => $estilo
                );
            }
            echo json_encode($datos);
        }
        else{
            if ($_GET['action']=='upd') {
                $data = json_decode(file_get_contents("php://input"));
                $clave = $data->ucla;
                if ($clave=="") {
                    $stmt = $conn->prepare("UPDATE usuarios SET usuario=:dat1, nombreus=:dat2, cedulaus=:dat3, expedidous=:dat4, cargous=:dat5, telefonous=:dat6, correous=:dat7, direccionus = :dat8,estadous = :dat9 WHERE idu = :dat0");
                    $stmt->bindParam(':dat0', $data->ius, PDO::PARAM_INT);
                    $stmt->bindParam(':dat1', $data->uusu);
                    $stmt->bindParam(':dat2', $data->unom);
                    $stmt->bindParam(':dat3', $data->udni);
                    $stmt->bindParam(':dat4', $data->upro);
                    $stmt->bindParam(':dat5', $data->ucar);
                    $stmt->bindParam(':dat6', $data->utel);
                    $stmt->bindParam(':dat7', $data->ucor);
                    $stmt->bindParam(':dat8', $data->udir);
                    $stmt->bindParam(':dat9', $data->uest, PDO::PARAM_INT);
                    $stmt->execute();
                    echo "ok";
                }else{
                    $contra = md5(sha1($clave));
                    $stmt = $conn->prepare("UPDATE usuarios SET usuario=:dat1, contrasenha=:dat2, nombreus=:dat3, cedulaus=:dat4, expedidous=:dat5, cargous=:dat6, telefonous=:dat7, correous=:dat8, direccionus=:dat9, estadous = :dat10 WHERE idu = :dat0");
                    $stmt->bindParam(':dat0', $data->ius, PDO::PARAM_INT);
                    $stmt->bindParam(':dat1', $data->uusu);
                    $stmt->bindParam(':dat2', $contra);
                    $stmt->bindParam(':dat3', $data->unom);
                    $stmt->bindParam(':dat4', $data->udni);
                    $stmt->bindParam(':dat5', $data->upro);
                    $stmt->bindParam(':dat6', $data->ucar);
                    $stmt->bindParam(':dat7', $data->utel);
                    $stmt->bindParam(':dat8', $data->ucor);
                    $stmt->bindParam(':dat9', $data->udir);
                    $stmt->bindParam(':dat10', $data->uest, PDO::PARAM_INT);
                    $stmt->execute();
                    echo "ok";
                }
            }
            else{
                if ($_GET['action']=='del') {
                    $data = json_decode(file_get_contents("php://input"));
                    $sentencia = $conn->prepare("DELETE FROM usuarios WHERE idu=:dat0");
                    $sentencia->bindParam(':dat0', $data->ius);
                    $sentencia->execute();
                    echo "ok";
                }
                else{
                    if ($_GET['action']=='getl') {
                        $datos = array();
                        $resultado=$conn->query("SELECT idprv, usuario, apellidosprv FROM usuarios ORDER BY idprv");
                        foreach($resultado as $registro){
                            $datos[] = array(
                                'value' => $registro['idprv'],
                                'name' => $registro['usuario'].' '.$registro['apellidosprv']
                            );
                        }
                        echo json_encode($datos);
                        $conn = null;
                    }
                }
            }
        }
    }
    $conn = null;
?>