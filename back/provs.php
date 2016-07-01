<?php
    include('../lib/conexions.php');
    if ($_GET['action']=='add') {
        $data = json_decode(file_get_contents("php://input"));
        if ($data->prvcont!=null) {
            $contacto = $data->prvcont;
        }else{
            $contacto = "";
        }
        if ($data->prvpais!=null) {
            $pais = $data->prvpais;
        }else{
            $pais = "";
        }
        if ($data->prvtelf!=null) {
            $telefono = $data->prvtelf;
        }else{
            $telefono = 0;
        }
        if ($data->prvcel!=null) {
            $celular = $data->prvcel;
        }else{
            $celular = 0;
        }
        if ($data->prvdir!=null) {
            $direccion = $data->prvdir;
        }else{
            $direccion = "";
        }
        $fechaprv = date("Y-m-d");
        $estado = 1;
        $sentencia = $conn->prepare("INSERT INTO proveedores (nombreprv, nitprv, contactoprv, paisprv, telefonoprv, movilprv, direccionprv, fechaiprv, estadoprv) VALUES (:data0, :data1, :data2, :data3, :data4, :data5, :data6, :data7, :data8)");
        $sentencia->bindParam(':data0', $data->prvnom);
        $sentencia->bindParam(':data1', $data->prvnit);
        $sentencia->bindParam(':data2', $contacto);
        $sentencia->bindParam(':data3', $pais);
        $sentencia->bindParam(':data4', $telefono);
        $sentencia->bindParam(':data5', $celular);
        $sentencia->bindParam(':data6', $direccion);
        $sentencia->bindParam(':data7', $fechaprv);
        $sentencia->bindParam(':data8', $estado);
        $sentencia->execute();
        echo "ok";
    }
    else{
        if ($_GET['action']=='get') {
            $estilo = "";
            $numero = 0;
            $datos = array();
            $resultado=$conn->query("SELECT * FROM proveedores ORDER BY idprv");
            foreach($resultado as $registro){
                switch ($registro['estadoprv']) {
                    case 0:
                        $estado = "No activo";
                        $estilo = "label-danger";
                        break;
                    case 1:
                        $estado = "Activo";
                        $estilo = "label-success";
                        break;
                }
                if ($registro['telefonoprv']!=0) {
                    $telefono = $registro['telefonoprv'];
                }else{
                    $telefono = "";
                }
                if ($registro['movilprv']!=0) {
                    $celular = $registro['movilprv'];
                }else{
                    $celular = "";
                }
                $datos[] = array(
                    'num' => ++$numero,
                    'idprv' => $registro['idprv'],
                    'name' => $registro['nombreprv'],
                    'nit' => $registro['nitprv'],
                    'cont' => $registro['contactoprv'],
                    'pais' => $registro['paisprv'],
                    'telf' => $telefono,
                    'celu' => $celular,
                    'dire' => $registro['direccionprv'],
                    'fechai' => $registro['fechaiprv'],
                    'estado' => $registro['estadoprv'],
                    'estadon' => $estado,
                    'estilo' => $estilo
                );
            }
            echo json_encode($datos);
        }
        else{
            if ($_GET['action']=='upd') {
                $data = json_decode(file_get_contents("php://input"));
                $stmt = $conn->prepare("UPDATE proveedores SET nombreprv = :dat1, nitprv = :dat2,contactoprv = :dat3,paisprv = :dat4,telefonoprv = :dat5,movilprv = :dat6,direccionprv = :dat7,fechaiprv = :dat8,estadoprv = :dat9 WHERE idprv = :dat0");
                $stmt->bindParam(':dat0', $data->iprv, PDO::PARAM_INT);
                $stmt->bindParam(':dat1', $data->paname);
                $stmt->bindParam(':dat2', $data->panit);
                $stmt->bindParam(':dat3', $data->pacont);
                $stmt->bindParam(':dat4', $data->papais);
                $stmt->bindParam(':dat5', $data->patelf);
                $stmt->bindParam(':dat6', $data->pacelu);
                $stmt->bindParam(':dat7', $data->padir);
                $stmt->bindParam(':dat8', $data->pafechi);
                $stmt->bindParam(':dat9', $data->paest, PDO::PARAM_INT);
                $stmt->execute();
                echo "ok";
            }
            else{
                if ($_GET['action']=='del') {
                    $data = json_decode(file_get_contents("php://input"));
                    $sentencia = $conn->prepare("DELETE FROM proveedores WHERE idprv=:idpers");
                    $sentencia->bindParam(':idpers', $data->idpers);
                    $sentencia->execute();
                    echo "ok";
                }
                else{
                    if ($_GET['action']=='getl') {
                        $datos = array();
                        $resultado=$conn->query("SELECT idprv, nombreprv FROM proveedores ORDER BY idprv");
                        foreach($resultado as $registro){
                            $datos[] = array(
                                'value' => $registro['idprv'],
                                'name' => $registro['nombreprv']
                            );
                        }
                        echo json_encode($datos);
                    }
                }
            }
        }
    }
    $conn = null;
?>