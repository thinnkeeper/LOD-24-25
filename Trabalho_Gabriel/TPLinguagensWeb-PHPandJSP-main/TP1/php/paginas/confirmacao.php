<?php
	include_once("../basedados/basedados.h");
	session_start();

	// Verifica se o utilizador está logado e se o perfil é de admin
	// Apenas o admin pode aceder a esta página
	if (isset($_SESSION['perfil'])&&($_SESSION['perfil']=="admin")) {
		$id_utilizador = $_GET['id'];
		$email_utilizador = $_GET["e_mail"];
		$user_name = $_GET["user_name"];
		
		echo "<h4>Excluir o utilizador ".$user_name." da base de dados?</h4>";
		echo "<a href='delete_utilizador.php?id=".$id_utilizador."&e_mail=".$email_utilizador."&user_name=".$user_name."'>SIM!</a><br>";
		echo "<a href='menu_admin.php'>NÃO!</a>";
	}
	else {
		header("refresh:0; url=index.php");
	}
	


?>