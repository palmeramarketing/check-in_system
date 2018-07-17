<?php 
class Conexion{
	private $conexion;
	public function conectar_mysqli(){ 
		if(!isset($this->conexion)){
			$this->conexion = new mysqli('localhost', 'root', '', 'check-in_system');
			if (mysqli_connect_errno()){
				return ["data"=>"", "error"=>mysqli_connect_error(), "status"=>500];
			}else{
				return ["data"=>$this->conexion, "error"=>"", "status"=>200];
			}
		}else{
			return $this->conexion;
		}
	}
	public function cerrar_mysqli(){
		if (isset($this->conexion)) {
			mysqli_close($this->conexion);
		}
	}
}
?>