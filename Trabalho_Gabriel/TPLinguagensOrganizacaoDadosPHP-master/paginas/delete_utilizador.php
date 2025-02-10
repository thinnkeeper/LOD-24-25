<!DOCTYPE html>
<html>
	<head>
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


		#$conn = conectar_bd();
		$sql = "DELETE FROM utilizadores WHERE id_utilizador = $id_utilizador";

		$resultado = mysqli_query($conn, $sql);

		if ($resultado) {
			echo "<div class='container' style='text-align:center;'>
			<h4>Utilizador com id Nº ".$id_utilizador." Nome: ".$user_name." e-mail: ".$email_utilizador."</h4>foi excluído da base de dados!<br>

					<div class='button-group' style='text-align:center;'>
					<a href='menu_admin.php'>Voltar para página admin</a>
					</div>
				</div>";
			
		}
	}
	else {
		header("refresh:0; url=index.php");
	}

	mysqli_close($conn);	


?>