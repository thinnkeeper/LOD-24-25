<!DOCTYPE html>
<html>
	<head>
		<title>Confirmação</title>
		<link rel="stylesheet" href="estilo.css?v=1.0">
		<body>
			
		</body>
	</head>
</html>

<?php
	include_once("../basedados/basedados.h");
	session_start();

	// Verifica se o utilizador está logado e se o perfil é de admin
	// Apenas o admin pode aceder a esta página
	if (isset($_SESSION['perfil'])&&($_SESSION['perfil']=="admin")) {
		$id_utilizador = $_GET['id'];
		$email_utilizador = $_GET["e_mail"];
		$user_name = $_GET["user_name"];
		
		echo "<div class='container'>
				<h4>Excluir o utilizador ".$user_name." da base de dados?</h4>
				<div class='button-group'>
					<a href='delete_utilizador.php?id=".$id_utilizador."&e_mail=".$email_utilizador."&user_name=".$user_name."' style='background-color:red;'>SIM!</a><br>
					<a href='menu_admin.php' >NÃO!</a>
					
				</div>
			</div";
	}
	else {
		header("refresh:0; url=index.php");
	}
	


?>