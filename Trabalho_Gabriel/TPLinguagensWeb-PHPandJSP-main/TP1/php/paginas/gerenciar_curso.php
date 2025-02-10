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
	
	if (isset($_SESSION['perfil'])&&($_SESSION['perfil']=='docente'||$_SESSION['perfil']=='admin')) {
		echo "<a href='logout.php'>Logout</a><br>";
		$perfil = $_SESSION["perfil"];

		if ($perfil == 'docente') {
        echo "<a href='menu_docente.php'>Home Page</a><br>";
		}
		else{
			echo "<a href='menu_admin.php'>Home Page</a><br>";
		}


		$id_curso = $_GET['id_curso'];
		echo "<a href='cancelar_curso.php?id_curso=".$id_curso."'>Cancelar curso?</a>";

		echo "<h2>Editar curso</h2>";
		$sql_curso = "SELECT * FROM cursos WHERE id_curso = ".$id_curso."";
		$resultado_curso = mysqli_query($conn,$sql_curso);
		if ($resultado_curso&&mysqli_num_rows($resultado_curso)>0) {
			$row = mysqli_fetch_assoc($resultado_curso);

		?>
			<form action="atualizar_curso.php" method="POST">
				<input type="hidden" name="id_curso" value="<?php echo $id_curso; ?>">
				<input type="hidden" name="vagas_disponiveis" value="<?php echo $row["vagas_disponiveis"]; ?>">
				<input type="hidden" name="vagas_totais_antigas" value="<?php echo $row["vagas_totais"]; ?>">
				Titulo: <input type="text" name="nome_curso" value="<?php echo $row['nome_curso']; ?>"><br>
				Descriçao: <input type="text" name="descricao" value="<?php echo $row['descricao']; ?>"><br>
				Preco: <input type="number" name="preco" value="<?php echo $row['preco']; ?>"><br>
				Vagas Totais<input type="number" name="vagas_totais" value= "<?php echo $row['vagas_totais'];?>"><br>
				Vagas Disponiveis: <?php echo $row['vagas_disponiveis'];?><br>
				<input type="submit" value="Atualizar curso">

			</form>
		<?php

		}
		//form para inscrever um aluno a um curso
		echo "<h2>Inscrever aluno</h2>";
		$sql_alunos = "SELECT * FROM utilizadores WHERE perfil = 'aluno' AND id_utilizador NOT IN (SELECT id_utilizador FROM inscricoes WHERE id_curso = ".$id_curso.")";
		$resultado_alunos = mysqli_query($conn,$sql_alunos);
		if ($resultado_alunos&&mysqli_num_rows($resultado_alunos)>0) {
			echo "<table border='1'>";
			echo "  <tr>
						<th>Id</th>
						<th>Nome</th>
						<th>Ultimo Nome</th>
						<th>Email</th>
						<th>Username</th>
						<th>Ação</th>
					</tr>";
			while ($linha = mysqli_fetch_assoc($resultado_alunos)) {
				echo "<tr>";
					echo "<td>".$linha["id_utilizador"]."</td>";
					echo "<td>".$linha["nome"]."</td>";
					echo "<td>".$linha["ultimo_nome"]."</td>";
					echo "<td>".$linha["e_mail"]."</td>";
					echo "<td>".$linha["user_name"]."</td>";
					echo "<td><a href='inscrever_curso.php?id_curso=".$id_curso."&id_aluno=".$linha["id_utilizador"]."'>Inscrever</a></td>";
				echo "</tr>";
			}
			echo "</table>";
		} else {
			echo "<h4>Não há alunos para inscrever</h4>";
		}

		$sql = "SELECT * FROM inscricoes WHERE id_curso = ".$id_curso."";
		$resultado = mysqli_query($conn, $sql);

		if ($resultado && mysqli_num_rows($resultado) >0) {
			$sql = "SELECT nome_curso FROM cursos WHERE id_curso =".$id_curso."";
			$resultado_nome = mysqli_fetch_assoc(mysqli_query($conn,$sql));
			$nome_curso = $resultado_nome["nome_curso"];
			echo "<h2> Nome do curso :".$nome_curso."</h2>";
			
			echo "<h2> Inscrições: </h2>";
			echo "<table border='1'>";
			echo "  <tr>
				<th>Id inscricao</th>
				<th>Id aluno</th>
				<th>Nome aluno</th>
				<th>Data</th>
				<th>Acao</th>
				<th>Acao</th>
			</tr>";
				while ($linha = mysqli_fetch_assoc($resultado)) {
					$id_aluno = $linha["id_utilizador"];

					
			
					echo "<tr>";

						echo "<td>".$linha["id_inscricao"]."</td>";
						echo "<td>".$linha["id_utilizador"]."</td>";

						$sql = "SELECT nome FROM utilizadores WHERE id_utilizador =".$id_aluno."";

						$resultado_nome_aluno = mysqli_fetch_assoc(mysqli_query($conn,$sql));
						$nome_aluno = $resultado_nome_aluno["nome"];
						echo "<td>".$nome_aluno."</td>";
						echo "<td>".$linha["data_inscricao"]."</td>";
						echo "<td><a href='cancelar_inscricao.php?id_curso=".$id_curso."&id_utilizador=".$id_aluno."'>Cancelar</a></td>";
						echo "<td><a href='mudar_data.php?id_inscricao=".$linha['id_inscricao']."&id_curso=".$id_curso."'>Mudar data </a></td>";
					echo "</tr>";

				}
				echo "</table>";

			} else {
				echo "<h4>Este curso ainda não tem incrições!<br></h4>";
				
			}
			mysqli_close($conn);
		
		
		
	} else{
		echo "Problemas com autenticação";
		header("refresh:3;url=index.php");
	}
	
		
?>
</body>
</html>
