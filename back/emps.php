<?php
	include('../lib/conexions.php');
	if ($_GET['action']=='get') {
		$resultado=$conn->query("SELECT * FROM empresa ORDER BY idemp")->fetch();
    	$datos = array(
    		'iemp' => $resultado['idemp'],
			'razon' => $resultado['razonemp'],
			'numer' => $resultado['numeroemp'],
			'zonae' => $resultado['zonaemp'],
			'telf' => $resultado['telefonoemp'],
			'mail' => $resultado['correoemp'],
			'banco' => $resultado['bancoemp'],
			'cuemn' => $resultado['cuentamnemp'],
			'cueme' => $resultado['cuentasusemp'],
			'bancod' => $resultado['bancodemp'],
			'cuemnd' => $resultado['cuentadmnemp'],
			'cuemed' => $resultado['cuentadsusemp']
		);
	    echo json_encode($datos);
	}
	else{
		if ($_GET['action']=='upd') {
			$data = json_decode(file_get_contents("php://input"));
			$stmt = $conn->prepare("UPDATE empresa SET razonemp=:dat1,numeroemp=:dat2,zonaemp=:dat3,telefonoemp=:dat4,correoemp=:dat5,bancoemp=:dat6,cuentamnemp=:dat7,cuentasusemp=:dat8,bancodemp=:dat9,cuentadmnemp=:dat10,cuentadsusemp=:dat11 WHERE idemp = :dat0");
			$stmt->bindParam(':dat0', $data->iem, PDO::PARAM_INT);
			$stmt->bindParam(':dat1', $data->raz);
			$stmt->bindParam(':dat2', $data->num);
			$stmt->bindParam(':dat3', $data->zon);
			$stmt->bindParam(':dat4', $data->tel);
			$stmt->bindParam(':dat5', $data->mai);
			$stmt->bindParam(':dat6', $data->ban);
			$stmt->bindParam(':dat7', $data->cun);
			$stmt->bindParam(':dat8', $data->cue);
			$stmt->bindParam(':dat9', $data->band);
			$stmt->bindParam(':dat10', $data->cund);
			$stmt->bindParam(':dat11', $data->cued);
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
	$conn = null;
?>