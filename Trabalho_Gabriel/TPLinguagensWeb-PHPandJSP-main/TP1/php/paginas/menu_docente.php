<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Docente</title>
</head>
<body>
<?php
	ob_start();
	include_once("../basedados/basedados.h");
	session_start();
	
	if (isset($_SESSION['perfil'])&&$_SESSION['perfil']=='docente') {
		echo "<a href='logout.php'>Logout</a>";
		echo "<h1>Bem-vindo ".$_SESSION['user_name']."</h1><h4> Você está na página do docente</h4><br><br>";

		echo "<a href='editar_perfil.php'>Editar Perfil</a>";

		
		//query para achar os cursos do docente 
		
		$sql = "SELECT * FROM cursos WHERE id_utilizador = ".$_SESSION['id']."";

		$resultado = mysqli_query($conn, $sql);

		if ($resultado && mysqli_num_rows($resultado) >0) {
			echo "<h2> Teus cursos: </h2>";
			echo "<table border='1'>";
			echo "  <tr>
						<th>Id_curso</th>
						<th>Título do curso</th>
						<th>Descrição</th>
						<th>Preço</th>
						<th>Vagas Restantes</th>
						<th>Inscritos</th>
						<th>Vagas Totais</th>
						<th>Acao</th>
					</tr>";
			

				while ($linha = mysqli_fetch_assoc($resultado)) {
					//$_SESSION['id_curso']=$linha['id_curso'];
					
					echo "<tr>";
						echo "<td>".$linha["id_curso"]."</td>";
						echo "<td>".$linha["nome_curso"]."</td>";
						echo "<td>".substr($linha["descricao"],0,50)."</td>";
						echo "<td>€".$linha["preco"]."</td>";
						echo "<td>".$linha["vagas_disponiveis"]."</td>";
						echo "<td>".$linha["vagas_totais"] - $linha["vagas_disponiveis"]."</td>";
						echo "<td>".$linha["vagas_totais"]."</td>";
						echo "<td><a href='gerenciar_curso.php?id_curso=".$linha["id_curso"]."'>Gerenciar</a></td>";
					echo "</tr>";

				}
				echo "</table>";

			} else {
				echo "<h4>Você ainda não tem cursos.<br></h4>";
				
			}
		
			echo "<h2>Criar curso:</h2>";	
		?>
	
		<form action="criar_curso.php" method="POST">
			<input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
			Nome Curso: <input type="text" name="nome_curso"><br>
			Descrição: <textarea name="descricao" rows="1" cols="50"></textarea><br>
			Preço: <input type="number" name="preco"><br>
			Vagas: <input type="number" name="vagas_totais"><br>
			<input type="submit" value="Criar Curso">
		</form>
    <?php
		
	} else{
		echo "Problemas com autenticação";
		header("refresh:3;url=index.php");
	}
	
	mysqli_close($conn);
?>
</body>
</html>
