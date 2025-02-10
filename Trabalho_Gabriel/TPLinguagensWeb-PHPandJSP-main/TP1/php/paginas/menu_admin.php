<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin</title>
</head>
<body>

</body>
</html>
<?php
	ob_start();
	include_once("../basedados/basedados.h");
	session_start();
	
	if (isset($_SESSION['perfil'])&&$_SESSION['perfil']=='admin') {
		echo "<a href='logout.php'>Logout</a>";
		echo "<h1>Bem-vindo ".$_SESSION['user_name']."</h1><h4> Voce esta na pagina do admin</h4><br><br>";

		echo "<a href='editar_perfil.php'>Editar Perfil<br></a>";
		echo "<a href='cursos_admin.php'>Cursos<br></a>";

		?>
		<div class="form-container">
        <h2>Registar Utilizador</h2>
        <form action="registo.php" method="post">
			<input type="hidden" name="isDocente" value="true"> <!-- forma para saber se é docente -->
            Nome: <input type="text" name="nome" style="margin-bottom: 10px;"><br>      
            Último nome: <input type="text" name="ultimo_nome"style="margin-bottom: 10px;"><br>      
            E-mail: <input type="text" name="e_mail"style="margin-bottom: 10px;"><br>
            User_name: <input type="text" name="user_name"style="margin-bottom: 10px;"><br>
            Password: <input type="password" name="password"style="margin-bottom: 10px;"><br>
            Perfil:
            <select name="perfil" style="margin-bottom: 10px;">
                <option value="aluno">Aluno</option>
                <option value="docente">Docente</option>
                <option value="admin">Administrador</option>
            </select><br>
            <input type="submit" value="Registar">
        </form>
    </div>
		<?php

		//query para achar os utilizadores que ainda nao foram autenticados
		$sql = "SELECT * FROM utilizadores WHERE autenticado = false";

		$resultado = mysqli_query($conn, $sql);

		if ($resultado && mysqli_num_rows($resultado) >0) {
			echo "<h2> Pedidos Pendentes </h2>";
			echo "<table border='1'>";
			echo "  <tr>
						<th>ID</th>
						<th>Nome</th>
						<th>Último Nome</th>
						<th>E-mail</th>
						<th>User Name</th>
						<th>Perfil</th>
						<th>Ação</th>
						<th>Ação</th>
					</tr>";
			

				while ($linha = mysqli_fetch_assoc($resultado)) {
					echo "<tr>";

						echo "<td>".$linha["id_utilizador"]."</td>";
						echo "<td>".$linha["nome"]."</td>";
						echo "<td>".$linha["ultimo_nome"]."</td>";
						echo "<td>".$linha["e_mail"]."</td>";
						echo "<td>".$linha["user_name"]."</td>";
						echo "<td>".$linha["perfil"]."</td>";
						echo "<td><a href='autenticar_utilizador.php?id=".$linha["id_utilizador"]."&e_mail=".$linha["e_mail"]."&user_name=".$linha["user_name"]."'>Autenticar</a></td>";
						echo "<td><a href='confirmacao.php?id=".$linha["id_utilizador"]."&e_mail=".$linha["e_mail"]."&user_name=".$linha["user_name"]."'>Excluir utilizador</a></td>";
					echo "</tr>";

				}
				echo "</table>";

			} else {
				echo "<h4>Não há pedidos pendentes<br></h4>";
				
			}
		
		//query para pegar todos os utilizadores autenticados
		$autenticados= "SELECT * FROM utilizadores WHERE autenticado = true";

		$resultado_autenticados = mysqli_query($conn, $autenticados);

		if ($resultado && mysqli_num_rows($resultado_autenticados) >0) {
			echo "<h2> Utilizadores autenticados </h2>";
			echo "<table border='1'>";
			echo "  <tr>
						<th>ID</th>
						<th>Nome</th>
						<th>Último Nome</th>
						<th>E-mail</th>
						<th>User Name</th>
						<th>Perfil</th>
						<th>Ação</th>
						<th>Ação</th>
					</tr>";
			

				while ($linha = mysqli_fetch_assoc($resultado_autenticados)) {
					echo "<tr>";

						echo "<td>".$linha["id_utilizador"]."</td>";
						echo "<td>".$linha["nome"]."</td>";
						echo "<td>".$linha["ultimo_nome"]."</td>";
						echo "<td>".$linha["e_mail"]."</td>";
						echo "<td>".$linha["user_name"]."</td>";
						echo "<td>".$linha["perfil"]."</td>";
						echo "<td><a href='bloquear_utilizador.php?id=".$linha["id_utilizador"]."&e_mail=".$linha["e_mail"]."&user_name=".$linha["user_name"]."'>Bloquear acesso</a></td>";
						echo "<td><a href='confirmacao.php?id=".$linha["id_utilizador"]."&e_mail=".$linha["e_mail"]."&user_name=".$linha["user_name"]."'>Excluir utilizador</a></td>";
					echo "</tr>";

				}
				echo "</table>";

			} else {
				echo "<h4>Não há pedidos pendentes<br></h4>";
				
			}
			
	} else{
		echo "Problemas com autenticação";
		header("refresh:3;url=index.php");
		}	
	mysqli_close($conn);
	

		
?>