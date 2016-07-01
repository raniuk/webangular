<?php session_start();
	include('../lib/conexions.php');
	if ($_GET['action']=='add') {
		$user = $_SESSION['iop'];
		$fecha = date("Y-m-d");
		$data = json_decode(file_get_contents("php://input"));
		$product = $data->ipro;
		$cantidad = $data->cants;
		$diferencia = $data->cantp - $cantidad;
		$resultve=$conn->query("SELECT cantidadven FROM tventas WHERE idpro='$product' and idu='$user'");
	    if ($resultve->rowCount()>0) {//$resultve->fetchColumn() > 0
	    	$sumados = $resultve->fetchColumn(0)+$cantidad;
	    	$stmt = $conn->prepare("UPDATE tventas SET cantidadven = :dat2 WHERE idpro=:dat0 and idu=:dat1");
			$stmt->bindParam(':dat0', $product, PDO::PARAM_INT);
			$stmt->bindParam(':dat1', $user, PDO::PARAM_INT);
			$stmt->bindParam(':dat2', $sumados, PDO::PARAM_INT);
			$stmt->execute();
	    } else {
			$sentencia = $conn->prepare("INSERT INTO tventas (idu, idpro, cantidadven, fechaven) VALUES (:data0, :data1, :data2, :data3)");
			$sentencia->bindParam(':data0', $user);
			$sentencia->bindParam(':data1', $product);
			$sentencia->bindParam(':data2', $cantidad);
			$sentencia->bindParam(':data3', $fecha);
			$sentencia->execute();
		}
		$stmt = $conn->prepare("UPDATE productos SET cantidadpro = :dat1 WHERE idpro = :dat0");
		$stmt->bindParam(':dat0', $product, PDO::PARAM_INT);
		$stmt->bindParam(':dat1', $diferencia, PDO::PARAM_INT);
		$stmt->execute();
		echo "ok";
	}
	else{
		if ($_GET['action']=='get') {
			$user = $_SESSION['iop'];
			$resultado=$conn->query("SELECT tv.idpro, tv.cantidadven, pr.nombrepro, pr.precioupro FROM tventas tv, productos pr WHERE tv.idu='$user' and tv.idpro=pr.idpro");
		    $datos = array();
		    $num = 0;
		    foreach($resultado as $registro){
		    	$datos[] = array(
		    		'num' => ++$num,
		    		'ipro' => $registro['idpro'],
		    		'prod' => $registro['nombrepro'],
		    		'prec' => $registro['precioupro'],
					'cantv' => $registro['cantidadven'],
					'subto' => $registro['precioupro']*$registro['cantidadven']
				);
		    }
		    echo json_encode($datos);
		}
		else{
			if ($_GET['action']=='upd') {
				$user = $_SESSION['iop'];
				$data = json_decode(file_get_contents("php://input"));
				$producto = $data->ipro;
	    		$cantnueva = $data->cants-1;
	    		if ($cantnueva==0) {
	    			$sentencia = $conn->prepare("DELETE FROM tventas WHERE idpro = :dat0 and idu = :dat1");
					$sentencia->bindParam(':dat0', $producto);
					$sentencia->bindParam(':dat1', $user);
					$sentencia->execute();
	    		} else{
	    			$stmt = $conn->prepare("UPDATE tventas SET cantidadven = :dat2 WHERE idpro = :dat0 and idu = :dat1");
					$stmt->bindParam(':dat0', $producto, PDO::PARAM_INT);
					$stmt->bindParam(':dat1', $user, PDO::PARAM_INT);
					$stmt->bindParam(':dat2', $cantnueva, PDO::PARAM_INT);
					$stmt->execute();
	    		}
	    		$resultpro=$conn->query("SELECT cantidadpro FROM productos WHERE idpro='$producto'");
	    		if ($resultpro->rowCount()>0) {
	    			$nuevacant = $resultpro->fetchColumn(0)+1;
	    			$stmt = $conn->prepare("UPDATE productos SET cantidadpro = :dat1 WHERE idpro = :dat0");
					$stmt->bindParam(':dat0', $producto, PDO::PARAM_INT);
					$stmt->bindParam(':dat1', $nuevacant, PDO::PARAM_INT);
					$stmt->execute();
	    		}
				echo "ok";
			}
			else{
				if ($_GET['action']=='del') {
					$user = $_SESSION['iop'];
					$data = json_decode(file_get_contents("php://input"));
					$producto = $data->ipro;
	    			$sentencia = $conn->prepare("DELETE FROM tventas WHERE idpro = :dat0 and idu = :dat1");
					$sentencia->bindParam(':dat0', $producto);
					$sentencia->bindParam(':dat1', $user);
					$sentencia->execute();

	    			$resultpro=$conn->query("SELECT cantidadpro FROM productos WHERE idpro='$producto'");
		    		if ($resultpro->rowCount()>0) {
		    			$nuevacant = $resultpro->fetchColumn(0)+$data->cants;
		    			$stmt = $conn->prepare("UPDATE productos SET cantidadpro = :dat1 WHERE idpro = :dat0");
						$stmt->bindParam(':dat0', $producto, PDO::PARAM_INT);
						$stmt->bindParam(':dat1', $nuevacant, PDO::PARAM_INT);
						$stmt->execute();
						echo "ok";
		    		}
				}
			}
		}
	}
	$conn = null;
?>