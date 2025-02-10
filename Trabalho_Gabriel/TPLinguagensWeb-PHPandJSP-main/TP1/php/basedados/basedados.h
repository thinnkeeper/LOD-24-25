<?php

	$conn = mysqli_connect("localhost","root","","gestao_cursos") or die("não foi possivel conectar a base de dados");
	/*function conectar_bd(){
		$conn = mysqli_connect("localhost","root","","gestao_cursos") or die("não foi possivel conectar a base de dados");


		return $conn;
	}
	*/

	function desconectar_bd($conn){
		mysqli_close($conn);
	}
?>