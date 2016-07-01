<?php
	include('../lib/conexions.php');
	if ($_GET['action']=='add') {
		$data = json_decode(file_get_contents("php://input"));
		$sentencia = $conn->prepare("INSERT INTO categoriaser (descripcioncats, estadocats) VALUES (:data0, :data1)");
		$sentencia->bindParam(':data0', $data->catdesc);
		$sentencia->bindParam(':data1', $data->catest);
		$sentencia->execute();
		echo "ok";
	}
	else{
		if ($_GET['action']=='get') {
			$resultado=$conn->query("SELECT * FROM categoriaser ORDER BY idcats");
		    $datos = array();
		    $num = 0;
		    $estilo = "";
		    foreach($resultado as $registro){
				switch ($registro['estadocats']) {
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
		    		'icat' => $registro['idcats'],
					'descat' => $registro['descripcioncats'],
					'estadocat' => $registro['estadocats'],
					'estadoncat' => $estado,
					'estilocat' => $estilo
				);
		    }
		    echo json_encode($datos);
		}
		else{
			if ($_GET['action']=='upd') {
				$data = json_decode(file_get_contents("php://input"));
				$stmt = $conn->prepare("UPDATE categoriaser SET descripcioncats = :dat1,estadocats = :dat2 WHERE idcats = :dat0");
				$stmt->bindParam(':dat0', $data->icat, PDO::PARAM_INT);
				$stmt->bindParam(':dat1', $data->descat);				
				$stmt->bindParam(':dat2', $data->estcat, PDO::PARAM_INT);
				$stmt->execute();
				echo "ok";
			}
			else{
				if ($_GET['action']=='del') {
					$data = json_decode(file_get_contents("php://input"));
					$sentencia = $conn->prepare("DELETE FROM categoriaser WHERE idcats=:dat0");
					$sentencia->bindParam(':dat0', $data->icat);
					$sentencia->execute();
				}
				else{
                    if ($_GET['action']=='getl') {
                        $datos = array();
                        $resultado=$conn->query("SELECT idcats, descripcioncats FROM categoriaser ORDER BY idcats");
                        foreach($resultado as $registro){
                            $datos[] = array(
                                'value' => $registro['idcats'],
                                'name' => $registro['descripcioncats']
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