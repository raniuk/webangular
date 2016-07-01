<?php
    include('../lib/conexions.php');
    if ($_GET['action']=='add') {
        $data = json_decode(file_get_contents("php://input"));
        $fechar = date("Y-m-d");
        $estado = 1;
        if ($data->clicelu=="") {
            $celular = 0;
        }
        else{
            $celular = $data->clicelu;
        }
        if ($data->climail=="") {
            $correoc = "";
        }
        else{
            $correoc = $data->climail;
        }
        if ($data->clidir=="") {
            $direccion = "Sin dirección";
        }
        else{
            $direccion = $data->clidir;
        }
        $sentencia = $conn->prepare("INSERT INTO clientes (nombrecli, cinitcli, telefonocli, celularcli, correocli, tipocli, razonempcli, fecharegcli, ciudadcli, direccioncli, estadocli) VALUES (:data0, :data1, :data2, :data3, :data4, :data5, :data6, :data7, :data8, :data9, :data10)");
        $sentencia->bindParam(':data0', $data->clinom);
        $sentencia->bindParam(':data1', $data->clinit);
        $sentencia->bindParam(':data2', $data->clitelf);
        $sentencia->bindParam(':data3', $celular);
        $sentencia->bindParam(':data4', $correoc);
        $sentencia->bindParam(':data5', $data->clitipo);
        $sentencia->bindParam(':data6', $data->clirazs);
        $sentencia->bindParam(':data7', $fechar);
        $sentencia->bindParam(':data8', $data->cliciu);
        $sentencia->bindParam(':data9', $direccion);
        $sentencia->bindParam(':data10', $estado);
        $sentencia->execute();
        echo "ok";
    }
    else{
        if ($_GET['action']=='get') {
            $estilo = "";
            $numero = 0;
            $datos = array();
            $resultado=$conn->query("SELECT * FROM clientes ORDER BY idcli");
            foreach($resultado as $registro){
                switch ($registro['estadocli']) {
                    case 0:
                        $estado = "No activo";
                        $estilo = "label-danger";
                        break;
                    case 1:
                        $estado = "Activo";
                        $estilo = "label-success";
                        break;
                }
                switch ($registro['tipocli']) {
                    case 0:
                        $tipocliente = "Persona";
                        break;
                    case 1:
                        $tipocliente = "Empresa";
                        break;
                }
                switch ($registro['ciudadcli']) {
                    case 1:
                        $ciudad = "Chuquisaca";
                        break;
                    case 2:
                        $ciudad = "La Paz";
                        break;
                    case 3:
                        $ciudad = "Cochabamba";
                        break;
                    case 4:
                        $ciudad = "Santa Cruz";
                        break;
                    case 5:
                        $ciudad = "Oruro";
                        break;
                    case 6:
                        $ciudad = "Potosi";
                        break;
                    case 7:
                        $ciudad = "Tarija";
                        break;
                    case 8:
                        $ciudad = "Beni";
                        break;
                    case 9:
                        $ciudad = "Pando";
                        break;
                }
                $datos[] = array(
                    'num' => ++$numero,
                    'icli' => $registro['idcli'],
                    'clie' => $registro['nombrecli'],
                    'nit' => $registro['cinitcli'],
                    'telf' => $registro['telefonocli'],
                    'celu' => $registro['celularcli'],
                    'mail' => $registro['correocli'],
                    'tipo' => $registro['tipocli'],
                    'tipon' => $tipocliente,
                    'fech' => $registro['fecharegcli'],
                    'ciud' => $registro['ciudadcli'],
                    'ciudn' => $ciudad,
                    'dire' => $registro['direccioncli'],
                    'esta' => $registro['estadocli'],
                    'estan' => $estado,
                    'estilo' => $estilo
                );
            }
            echo json_encode($datos);
        }
        else{
            if ($_GET['action']=='upd') {
                $data = json_decode(file_get_contents("php://input"));
                $stmt = $conn->prepare("UPDATE clientes SET nombrecli = :dat1, cinitcli = :dat2, telefonocli = :dat3, celularcli = :dat4, correocli = :dat5, tipocli = :dat6, fecharegcli = :dat7, ciudadcli = :dat8, direccioncli = :dat9, estadocli = :dat10 WHERE idcli = :dat0");
                $stmt->bindParam(':dat0', $data->icli, PDO::PARAM_INT);
                $stmt->bindParam(':dat1', $data->nomcli);
                $stmt->bindParam(':dat2', $data->nitcli);
                $stmt->bindParam(':dat3', $data->telcli);
                $stmt->bindParam(':dat4', $data->celcli);
                $stmt->bindParam(':dat5', $data->corcli);
                $stmt->bindParam(':dat6', $data->tipcli);
                $stmt->bindParam(':dat7', $data->fechcli);
                $stmt->bindParam(':dat8', $data->ciucli);
                $stmt->bindParam(':dat9', $data->dircli);
                $stmt->bindParam(':dat10', $data->estcli, PDO::PARAM_INT);
                $stmt->execute();
                echo "ok";
            }
            else{
                if ($_GET['action']=='del') {
                    $data = json_decode(file_get_contents("php://input"));
                    $sentencia = $conn->prepare("DELETE FROM clientes WHERE idcli=:dat0");
                    $sentencia->bindParam(':dat0', $data->iser);
                    $sentencia->execute();
                    echo "ok";
                }
                else{
                    if ($_GET['action']=='sear') {
                        $datos = array();
                        $resultado=$conn->query("SELECT idcli, nombrecli FROM clientes ORDER BY nombrecli");
                        foreach($resultado as $registro){
                            $datos[] = array(
                                'codec' => $registro['idcli'],
                                'namec' => $registro['nombrecli']
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