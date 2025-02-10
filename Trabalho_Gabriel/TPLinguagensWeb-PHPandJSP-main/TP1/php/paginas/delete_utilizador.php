<?php
	include_once("../basedados/basedados.h");
	session_start();

	// Verifica se o utilizador está logado e se o perfil é de admin
	// Apenas o admin pode aceder a esta página
	if (isset($_SESSION['perfil'])&&($_SESSION['perfil']=="admin")) {
		$id_utilizador = $_GET['id'];
		$email_utilizador = $_GET["e_mail"];
		$user_name = $_GET["user_name"];


		#$conn = conectar_bd();
		$sql = "DELETE FROM utilizadores WHERE id_utilizador = $id_utilizador";

		$resultado = mysqli_query($conn, $sql);

		if ($resultado) {
			echo "<h4>Utilizador com id=".$id_utilizador."<br>user_name=".$user_name." <br>e-mail=".$email_utilizador."</h4>foi excluido da base de dados!<br>";
			echo "<a href='menu_admin.php'>Voltar para página admin</a>";
			
		}
	}
	else {
		header("refresh:0; url=index.php");
	}

	mysqli_close($conn);	


?>