<?php session_start();
	include('../lib/conexions.php');
	if ($_GET['action']=='add') {
		$activedel = false;
		$user = $_SESSION['iop'];
		$fecha = date("Y-m-d");

		$fp = fopen("../pdf/seriegmz.txt", "r");
		$nvalor = (int) fgets($fp);
		fclose($fp);
		error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		$fp = fopen("../pdf/seriegmz.txt", "w");
		fwrite($fp, ($nvalor*1+1).PHP_EOL);
		fclose($fp);

		$data = json_decode(file_get_contents("php://input"));
		$cliente = $data->icli;
		$tiempo = $data->tiempo;
		$descue = $data->descu;
		if ($tiempo==null) {
			$tiempo = "24 hrs";
		}
		if ($descue==null) {
			$descue = 0;
		}
		$queryaddv = $conn->prepare("INSERT INTO ventas (idu, idcli, bancoempven, formapuven, detallefpuven, formapdven, detallefpdven, formaptven, detallefptven, formapcven, detallefpcven, tiempoven, descuentoven, validezofertaven, numeroven, fechaven) VALUES (:data0, :data1, :data2, :data3, :data4, :data5, :data6, :data7, :data8, :data9, :data10, :data11, :data12, :data13, :data14, :data15)");
		$queryaddv->bindParam(':data0', $user);
		$queryaddv->bindParam(':data1', $cliente);
		$queryaddv->bindParam(':data2', $data->cbank);
		$queryaddv->bindParam(':data3', $data->foru);
		$queryaddv->bindParam(':data4', $data->detau);
		$queryaddv->bindParam(':data5', $data->ford);
		$queryaddv->bindParam(':data6', $data->detad);
		$queryaddv->bindParam(':data7', $data->fort);
		$queryaddv->bindParam(':data8', $data->detat);
		$queryaddv->bindParam(':data9', $data->forc);
		$queryaddv->bindParam(':data10', $data->detac);
		$queryaddv->bindParam(':data11', $tiempo);
		$queryaddv->bindParam(':data12', $descue);
		$queryaddv->bindParam(':data13', $data->vali);
		$queryaddv->bindParam(':data14', $nvalor);
		$queryaddv->bindParam(':data15', $fecha);
		$queryaddv->execute();

		$selectuven=$conn->query("SELECT idven FROM ventas WHERE idu='$user' AND idcli='$cliente' AND fechaven='$fecha' ORDER BY idven DESC LIMIT 1");
		$ivent = $selectuven->fetchColumn(0);

		$resultado=$conn->query("SELECT idpro, cantidadven FROM tventas WHERE idu='$user' AND fechaven='$fecha'");
	    foreach($resultado as $registro){
			$queryaddv = $conn->prepare("INSERT INTO ventaprods (idven, idpro, cantidadven) VALUES (:data0, :data1, :data2)");
			$queryaddv->bindParam(':data0', $ivent);
			$queryaddv->bindParam(':data1', $registro['idpro']);
			$queryaddv->bindParam(':data2', $registro['cantidadven']);
			$queryaddv->execute();
			$activedel = true;
	    }
	    if ($activedel) {
	    	$querydeltv = $conn->prepare("DELETE FROM tventas WHERE idu=:dat0 and fechaven=:dat1");
			$querydeltv->bindParam(':dat0', $user);
			$querydeltv->bindParam(':dat1', $fecha);
			$querydeltv->execute();
			echo "ok";
	    }
	}
	else{
		if ($_GET['action']=='getd') {
			$user = $_SESSION['iop'];
			$data = json_decode(file_get_contents("php://input"));
			$fecha = $data->fechas;//$fecha = restardias(1, $data->fechas);
			$resultado=$conn->query("SELECT ve.idven, ve.idcli, ve.formapuven, ve.detallefpuven, ve.formapdven, ve.detallefpdven, ve.formaptven, ve.detallefptven, ve.formapcven, ve.detallefpcven, ve.tiempoven, ve.numeroven, cl.nombrecli, cl.razonempcli FROM ventas ve, clientes cl WHERE ve.idu='$user' and ve.fechaven='$fecha' and ve.idcli=cl.idcli ORDER BY ve.idven DESC");
		    $datos = array();
		    $num = 0;
		    $estilo = "";
		    foreach($resultado as $registro){
				if (($registro['formapuven']+$registro['formapdven']+$registro['formaptven']+$registro['formapcven'])==100) {
                    $estado = true;
                    $estilo = "label-success";
                }elseif(($registro['formapuven']+$registro['formapdven']+$registro['formaptven']+$registro['formapcven'])<100){
                    $estado = false;
                    $estilo = "label-warning";
                }else{
                    $estado = false;
                    $estilo = "label-danger";
                }
		    	$datos[] = array(
		    		'num' => ++$num,
		    		'iven' => $registro['idven'],
		    		'icli' => $registro['idcli'],
		    		'client' => $registro['nombrecli'],
		    		'razon' => $registro['razonempcli'],
					'forma' => $registro['formapuven']+$registro['formapdven']+$registro['formaptven']+$registro['formapcven'],
					'formu' => $registro['formapuven'],
					'detau' => $registro['detallefpuven'],
					'formd' => $registro['formapdven'],
					'detad' => $registro['detallefpdven'],
					'formt' => $registro['formaptven'],
					'detat' => $registro['detallefptven'],
					'formc' => $registro['formapcven'],
					'detac' => $registro['detallefpcven'],
					'formav' => $estilo,
					'tiempo' => $registro['tiempoven'],
					'actbtn' => $estado
				);
		    }
		    echo json_encode($datos);
		}
		else{
			if ($_GET['action']=='upd') {
				$user = $_SESSION['iop'];
				$data = json_decode(file_get_contents("php://input"));
				$stmt = $conn->prepare("UPDATE ventas SET formapuven=:dat2, detallefpuven=:dat3, formapdven=:dat4, detallefpdven=:dat5, formaptven=:dat6, detallefptven=:dat7, formapcven=:dat8, detallefpcven=:dat9 WHERE idven = :dat0 and idu = :dat1");
				$stmt->bindParam(':dat0', $data->iven, PDO::PARAM_INT);
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
			}else{
				if ($_GET['action']=='del') {
					$data = json_decode(file_get_contents("php://input"));
					$sentencia = $conn->prepare("DELETE FROM ventaprods WHERE idven=:dat0");
					$sentencia->bindParam(':dat0', $data->iven);
					$sentencia->execute();

					$sentencia = $conn->prepare("DELETE FROM ventas WHERE idven=:dat0");
					$sentencia->bindParam(':dat0', $data->iven);
					$sentencia->execute();
				}
				else{
                    if ($_GET['action']=='getm') {
						$user = $_SESSION['iop'];
						$data = json_decode(file_get_contents("php://input"));
						$fecha = $data->fechas;
						$resultado=$conn->query("SELECT ve.idven, ve.idcli, ve.formapuven, ve.detallefpuven, ve.formapdven, ve.detallefpdven, ve.formaptven, ve.detallefptven, ve.formapcven, ve.detallefpcven, ve.tiempoven, ve.numeroven, cl.nombrecli, cl.razonempcli FROM ventas ve, clientes cl WHERE ve.idu='$user' and ve.fechaven LIKE '$fecha%' and ve.idcli=cl.idcli ORDER BY ve.idven DESC");
					    $datos = array();
					    $num = 0;
					    $estilo = "";
					    foreach($resultado as $registro){
					    	if (($registro['formapuven']+$registro['formapdven']+$registro['formaptven']+$registro['formapcven'])==100) {
			                    $estado = true;
			                    $estilo = "label-success";
			                }elseif(($registro['formapuven']+$registro['formapdven']+$registro['formaptven']+$registro['formapcven'])<100){
			                    $estado = false;
			                    $estilo = "label-warning";
			                }else{
			                    $estado = false;
			                    $estilo = "label-danger";
			                }
					    	$datos[] = array(
					    		'num' => ++$num,
					    		'iven' => $registro['idven'],
					    		'icli' => $registro['idcli'],
					    		'client' => $registro['nombrecli'],
					    		'razon' => $registro['razonempcli'],
								'forma' => $registro['formapuven']+$registro['formapdven']+$registro['formaptven']+$registro['formapcven'],
								'formu' => $registro['formapuven'],
								'detau' => $registro['detallefpuven'],
								'formd' => $registro['formapdven'],
								'detad' => $registro['detallefpdven'],
								'formt' => $registro['formaptven'],
								'detat' => $registro['detallefptven'],
								'formc' => $registro['formapcven'],
								'detac' => $registro['detallefpcven'],
								'formav' => $estilo,
								'tiempo' => $registro['tiempoven'],
								'actbtn' => $estado
							);
					    }
					    echo json_encode($datos);
					}else{
						if ($_GET['action']=='getg') {
							$user = $_SESSION['iop'];
							$data = json_decode(file_get_contents("php://input"));
							$fecha = $data->fechas;
							$resultado=$conn->query("SELECT ve.idven, ve.idcli, ve.formapuven, ve.detallefpuven, ve.formapdven, ve.detallefpdven, ve.formaptven, ve.detallefptven, ve.formapcven, ve.detallefpcven, ve.tiempoven, ve.numeroven, cl.nombrecli, cl.razonempcli FROM ventas ve, clientes cl WHERE ve.idu='$user' and ve.fechaven LIKE '$fecha%' and ve.idcli=cl.idcli ORDER BY ve.idven DESC");
						    $datos = array();
						    $num = 0;
						    $estilo = "";
						    foreach($resultado as $registro){
						    	if (($registro['formapuven']+$registro['formapdven']+$registro['formaptven']+$registro['formapcven'])==100) {
				                    $estado = true;
				                    $estilo = "label-success";
				                }elseif(($registro['formapuven']+$registro['formapdven']+$registro['formaptven']+$registro['formapcven'])<100){
				                    $estado = false;
				                    $estilo = "label-warning";
				                }else{
				                    $estado = false;
				                    $estilo = "label-danger";
				                }
						    	$datos[] = array(
						    		'num' => ++$num,
						    		'iven' => $registro['idven'],
						    		'icli' => $registro['idcli'],
						    		'client' => $registro['nombrecli'],
						    		'razon' => $registro['razonempcli'],
									'forma' => $registro['formapuven']+$registro['formapdven']+$registro['formaptven']+$registro['formapcven'],
									'formu' => $registro['formapuven'],
									'detau' => $registro['detallefpuven'],
									'formd' => $registro['formapdven'],
									'detad' => $registro['detallefpdven'],
									'formt' => $registro['formaptven'],
									'detat' => $registro['detallefptven'],
									'formc' => $registro['formapcven'],
									'detac' => $registro['detallefpcven'],
									'formav' => $estilo,
									'tiempo' => $registro['tiempoven'],
									'actbtn' => $estado
								);
						    }
						    echo json_encode($datos);
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