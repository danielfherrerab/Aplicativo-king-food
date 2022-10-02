<?php
	class Database{
		private $servidorlocal;
		private $basededatos;
		private $nombre;
		private $password;
		private $charset;

		public function __construct(){
				$this->servidorlocal = 'localhost';
				$this->basededatos 	 = 'kingfood';
				$this->nombre       = 'root';
				$this->clave         = '';
				$this->caracteres    = 'utf8';
		}
		function connect(){
			try{
				$conexion = "mysql:host=".$this->servidorlocal.";dbname=".$this->basededatos.";charset=".$this->caracteres;
				$opciones = [
				PDO::ATTR_ERRMODE 		    => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_EMULATE_PREPARES  => false, ];
				$pdo = new PDO($conexion, $this->nombre, $this->clave,$opciones);
				return $pdo;
			}
			catch(PDOException $e){
				print_r('Error en la conexion:  '.$e->getMessage());
			}
		}
	}
?>