<?php
	include_once("../basedados/basedados.h");
	session_start();

	// Verifica se o utilizador está logado e se o perfil é de admin
	if (!isset($_SESSION['perfil'])||($_SESSION['perfil']!="admin")){
		echo "Não tem permissão para aceder a esta página.";
		if($_SESSION['perfil']=="aluno"){
			header("refresh:0; url=menu_aluno.php");
		} elseif ($_SESSION['perfil']=="docente") {
			header("refresh:0; url=menu_docente.php");
		} else {
			header("refresh:0; url=index.php");
		}

	} else {
		

		$id_utilizador = $_GET['id'];
		$email_utilizador = $_GET["e_mail"];
		$user_name = $_GET["user_name"];


		#$conn = conectar_bd();

		$sql = "UPDATE utilizadores SET autenticado = 1 WHERE id_utilizador = $id_utilizador";

		$resultado = mysqli_query($conn, $sql);

		if ($resultado) {
			echo "Utilizador com id=".$id_utilizador.", user_name=".$user_name." e e-mail=".$email_utilizador." foi autenticado!<br>";
			echo "<a href='menu_admin.php'>Voltar para página admin</a>";
		}
		mysqli_close($conn);	

	}


?>