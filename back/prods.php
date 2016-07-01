<?php
    include('../lib/conexions.php');
    if ($_GET['action']=='add') {
        $data = json_decode(file_get_contents("php://input"));
        $estado = 1;
        if ($data->prodesc=="") {
            $prodescrip = "Ninguna";
        }
        else{
            $prodescrip = $data->prodesc;
        }
        $sentencia = $conn->prepare("INSERT INTO productos (idprv, nombrepro, descripcionpro, cantidadpro, unidadpro, precioupro, fechapro, fotopro, estadopro) VALUES (:data0, :data1, :data2, :data3, :data4, :data5, :data6, :data7, :data8)");
        $sentencia->bindParam(':data0', $data->proprov);
        $sentencia->bindParam(':data1', $data->pronom);
        $sentencia->bindParam(':data2', $prodescrip);
        $sentencia->bindParam(':data3', $data->procant);
        $sentencia->bindParam(':data4', $data->prounid);
        $sentencia->bindParam(':data5', $data->proprec);
        $sentencia->bindParam(':data6', $data->profech);
        $sentencia->bindParam(':data7', $data->profoto);
        $sentencia->bindParam(':data8', $estado);
        $sentencia->execute();
        echo "ok";
    }
    else{
        if ($_GET['action']=='get') {
            $estilo = "";
            $numero = 0;
            $datos = array();
            $resultado=$conn->query("SELECT * FROM productos ORDER BY idpro");
            foreach($resultado as $registro){
                switch ($registro['estadopro']) {
                    case 0:
                        $estado = "No activo";
                        $estilo = "label-danger";
                        break;
                    case 1:
                        $estado = "Activo";
                        $estilo = "label-success";
                        break;
                }
                /*if ($registro['fotopro']!="") {
                    $fotoprod = $registro['fotopro'];
                }else{
                    $fotoprod = "base.png";
                }*/
                $resultprv=$conn->query("SELECT nombreprv FROM proveedores ORDER BY idprv")->fetch();
                $datos[] = array(
                    'num' => ++$numero,
                    'ipro' => $registro['idpro'],
                    'nprv' => $resultprv['nombreprv'],
                    'iprv' => $registro['idprv'],
                    'nomb' => $registro['nombrepro'],
                    'desc' => $registro['descripcionpro'],
                    'cant' => $registro['cantidadpro'],
                    'proc' => $registro['precioupro'],
                    'fech' => $registro['fechapro'],
                    'foto' => $registro['fotopro'],//$fotoprod,
                    'esta' => $registro['estadopro'],
                    'estan' => $estado,
                    'estilo' => $estilo
                );
            }
            echo json_encode($datos);
        }
        else{
            if ($_GET['action']=='upd') {
                $data = json_decode(file_get_contents("php://input"));
                if ($data->pfotoa!=$data->pfoton && file_exists("../public/img/prods/".$data->pfotoa)) {
                    unlink("../public/img/prods/".$data->pfotoa);
                }
                $stmt = $conn->prepare("UPDATE productos SET idprv = :dat1, nombrepro = :dat2, descripcionpro = :dat3, cantidadpro = :dat4, precioupro = :dat5,fechapro = :dat6,fotopro = :dat7, estadopro = :dat8 WHERE idpro = :dat0");
                $stmt->bindParam(':dat0', $data->ipro, PDO::PARAM_INT);
                $stmt->bindParam(':dat1', $data->iprv);
                $stmt->bindParam(':dat2', $data->pnomb);
                $stmt->bindParam(':dat3', $data->pdesc);
                $stmt->bindParam(':dat4', $data->pcant);
                $stmt->bindParam(':dat5', $data->pprec);
                $stmt->bindParam(':dat6', $data->pfech);
                $stmt->bindParam(':dat7', $data->pfoton);
                $stmt->bindParam(':dat8', $data->pesta, PDO::PARAM_INT);
                $stmt->execute();
                echo "ok";
            }
            else{
                if ($_GET['action']=='del') {
                    $data = json_decode(file_get_contents("php://input"));
                    $sentencia = $conn->prepare("DELETE FROM productos WHERE idpro=:dat0");
                    $sentencia->bindParam(':dat0', $data->ipro);
                    $sentencia->execute();
                    if (file_exists("../public/img/prods/".$data->fot)) {
                        unlink("../public/img/prods/".$data->fot);
                    }
                    echo "ok";
                }
                else{
                    if ($_GET['action']=='list') {
                        $datos = array();
                        $resultado=$conn->query("SELECT pro.idpro, pro.nombrepro, prv.nombreprv, pro.descripcionpro, pro.cantidadpro, pro.precioupro, pro.fotopro FROM productos pro, proveedores prv WHERE pro.idprv=prv.idprv ORDER BY pro.idpro");
                        foreach($resultado as $registro){
                            if ($registro['cantidadpro']!=0) {
                                $btnact = false;
                                $cantini = 1;
                            }else{
                                $btnact = true;
                                $cantini = 0;
                            }
                            if ($registro['fotopro']!="") {
                                $fotoprod = $registro['fotopro'];
                            }else{
                                $fotoprod = "base.png";
                            }
                            $datos[] = array(
                                'ipro' => $registro['idpro'],
                                'nompro' => $registro['nombrepro'],
                                'nomprv' => $registro['nombreprv'],
                                'despro' => $registro['descripcionpro'],
                                'cantin' => $cantini,
                                'canpro' => $registro['cantidadpro'],
                                'prepro' => $registro['precioupro'],
                                'fotpro' => $fotoprod,
                                'activo' => $btnact
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