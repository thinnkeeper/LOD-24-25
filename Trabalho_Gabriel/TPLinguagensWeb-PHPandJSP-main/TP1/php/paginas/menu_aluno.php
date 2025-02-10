<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Aluno</title>
</head>
<body>

</body>
</html>
<?php
	ob_start();
	include_once("../basedados/basedados.h");
	session_start();
	
	
	if (isset($_SESSION['perfil'])&&$_SESSION['perfil']=='aluno') {
		echo "<a href='logout.php'>Logout</a>";
		echo "<h1>Bem-vindo ".$_SESSION['user_name']."</h1><h4> Você está na página do aluno</h4>";
		$id_aluno = $_SESSION['id'];
		echo "<a href='editar_perfil.php'>Editar Perfil<br></a><br>";
		#$conn = conectar_bd();
		
		
		$sql = "SELECT * FROM cursos WHERE id_curso IN (SELECT id_curso FROM inscricoes WHERE id_utilizador = ".$id_aluno.")";
            
		$resultado = mysqli_query($conn, $sql);
		
		if ($resultado && mysqli_num_rows($resultado) >0) {
			echo "<h2>Cursos em que está incrito:</h2>";
			echo "<table border='1'>";
			echo "  <tr>
						<th>Id_curso</th>
						<th>Nome docente</th>
						<th>Título do curso</th>
						<th>Descrição</th>
						<th>Preço</th>
						<th>Número de vagas Restantes</th>
						<th>Ação</th>
					</tr>";
				while ($linha = mysqli_fetch_assoc($resultado)) {
					echo "<tr>";
						$sql2 = "SELECT nome FROM utilizadores WHERE id_utilizador = ".$linha['id_utilizador'];
						$resultado2 = mysqli_query($conn,$sql2);
						$nome_docente = mysqli_fetch_assoc($resultado2);

						echo "<td>".$linha["id_curso"]."</td>";
						echo "<td>".$nome_docente["nome"]."</td>";
						echo "<td>".$linha["nome_curso"]."</td>";
						echo "<td>".substr($linha["descricao"],0,0)."</td>";
						echo "<td>€".$linha["preco"]."</td>";
						echo "<td>".$linha["vagas_disponiveis"]."</td>";
						echo "<td><a href='cancelar_inscricao.php?id_curso=".$linha["id_curso"]."&id_utilizador=".$id_aluno."'>Cancelar</a></td>";
					echo "</tr>";

				}
				echo "</table>";
		} else
			echo "<h4>Ainda não está inscrito em nenhum curso!</h4>";

		
		$sql = "SELECT * FROM cursos WHERE id_curso NOT IN (SELECT id_curso FROM inscricoes WHERE id_utilizador = ".$_SESSION['id'].")";
            
		$resultado = mysqli_query($conn, $sql);
		
		if ($resultado && mysqli_num_rows($resultado) >0) {
			echo "<h2>Cursos em que pode se inscrever:</h2>";
			echo "<table border='1'>";
			echo "  <tr>
						<th>Id_curso</th>
						<th>Nome docente</th>
						<th>Título do curso</th>
						<th>Descrição</th>
						<th>Preço</th>
						<th>Número de vagas Restantes</th>
						<th>Ação</th>
					</tr>";
				while ($linha = mysqli_fetch_assoc($resultado)) {
					echo "<tr>";
						$sql2 = "SELECT nome FROM utilizadores WHERE id_utilizador = ".$linha['id_utilizador'];
						$resultado2 = mysqli_query($conn,$sql2);
						$nome_docente = mysqli_fetch_assoc($resultado2);

						echo "<td>".$linha["id_curso"]."</td>";
						echo "<td>".$nome_docente["nome"]."</td>";
						echo "<td>".$linha["nome_curso"]."</td>";
						echo "<td>".substr($linha["descricao"],0,50)."</td>";
						echo "<td>€".$linha["preco"]."</td>";
						echo "<td>".$linha["vagas_disponiveis"]."</td>";
						echo "<td><a href='inscrever_curso.php?id_curso=".$linha["id_curso"]."&id_aluno=".$id_aluno."'>Insrever-se</a></td>";
					echo "</tr>";

				}
				echo "</table>";
		}


	} else{
		echo "Problemas com autenticação";
		header("refresh:3;url=index.php");
	}

	mysqli_close($conn);
?>