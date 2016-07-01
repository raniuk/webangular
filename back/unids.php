<?php
    include('../lib/conexions.php');
    if ($_GET['action']=='add') {
        $data = json_decode(file_get_contents("php://input"));
        $estado = 1;
        $sentencia = $conn->prepare("INSERT INTO unidades (unidad, estadoun) VALUES (:data0, :data1)");
        $sentencia->bindParam(':data0', $data->unid);
        $sentencia->bindParam(':data1', $estado);
        $sentencia->execute();
        echo "ok";
    }else{
        if ($_GET['action']=='get') {
            $resultado=$conn->query("SELECT unidad FROM unidades WHERE estadoun='1' ORDER BY idun");
            foreach($resultado as $registro){
                $datos[] = array(
                    'value' => $registro['unidad'],
                    'name' => $registro['unidad']
                );
            }
            echo json_encode($datos);
        }else{
            if ($_GET['action']=='getl') {
                $resultado=$conn->query("SELECT * FROM unidades ORDER BY idun");
                $num = 0;
                foreach($resultado as $registro){
                    switch ($registro['estadoun']) {
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
                        'iun' => $registro['idun'],
                        'uni' => $registro['unidad'],
                        'est' => $registro['estadoun'],
                        'estn' => $estado,
                        'esti' => $estilo
                    );
                }
                echo json_encode($datos);
            }else{
                if ($_GET['action']=='upd') {
                    $data = json_decode(file_get_contents("php://input"));
                    $stmt = $conn->prepare("UPDATE unidades SET unidad = :dat1,estadoun = :dat2 WHERE idun = :dat0");
                    $stmt->bindParam(':dat0', $data->iun, PDO::PARAM_INT);
                    $stmt->bindParam(':dat1', $data->desun);               
                    $stmt->bindParam(':dat2', $data->estun, PDO::PARAM_INT);
                    $stmt->execute();
                    echo "ok";
                }else{
                    if ($_GET['action']=='del') {
                        $data = json_decode(file_get_contents("php://input"));
                        $sentencia = $conn->prepare("DELETE FROM unidades WHERE idun=:dat0");
                        $sentencia->bindParam(':dat0', $data->iun);
                        $sentencia->execute();
                    }
                }
            }
        }
    }
    $conn = null;
?>