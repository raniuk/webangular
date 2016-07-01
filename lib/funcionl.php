<?php
	class login extends conexionl{
		private $user;
		private $pass;
		private $coti;

		public function setUser($usuario){
			$this->user=$usuario;
		}

		public function setPass($contra){
			$this->pass=$contra;
		}

		public function setCoti($cotiz){
			$this->coti=$cotiz;
		}

		public function getUser(){
			return $this->user;
		}

		public function getPass(){
			return $this->pass;
		}

		public function getCoti(){
			return $this->coti;
		}

		public function entrar(){
			$pdo = parent::getDB();
			$entrar = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ? AND contrasenha =?");
			$entrar->bindValue(1, $this->getUser());
			$entrar->bindValue(2, $this->getPass());
			$entrar->execute();
			if ($entrar->rowCount()==1):
				$datos=$entrar->fetch(PDO::FETCH_OBJ);
				$_SESSION['iop']=$datos->idu;
				$_SESSION['uname']=$datos->nombreus;
				$_SESSION['utype']=$datos->funcionus;
				$_SESSION['uesta']=$datos->estadous;
				$_SESSION['tcamb']=$this->getCoti();//6.95;
				$_SESSION['dentro']=false;
				return true;
			else:
				return false;
			endif;
		}

		public static function salir(){
			if (isset($_SESSION['dentro'])) :
				unset($_SESSION['dentro']);
				session_destroy();
				echo"<script language='javascript'>window.location='../index.php'</script>";
				//header("Location: ../index.php");//Aqui fijar al salir de sistema va ir
			endif;
		}
	}
?>