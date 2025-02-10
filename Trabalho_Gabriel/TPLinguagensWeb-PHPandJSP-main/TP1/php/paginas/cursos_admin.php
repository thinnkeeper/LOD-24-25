<?php 
    ob_start();
	include_once("../basedados/basedados.h");
	session_start();
    
    if (isset($_SESSION['perfil'])&&$_SESSION['perfil']=='admin'){
        echo "<a href='logout.php'>Logout<br></a>";
        echo "<a href='menu_admin.php'>Home Page<br></a>";
        

        $sql = "SELECT * FROM utilizadores WHERE perfil = 'docente'";

		$resultado = mysqli_query($conn, $sql);

		if ($resultado && mysqli_num_rows($resultado) >0) {
			echo "<h2>Lista de docentes:</h2>";
			echo "<table border='1'>";
			echo "  <tr>
						<th>ID</th>
						<th>Nome</th>
						<th>Último Nome</th>
						<th>E-mail</th>
						<th>User Name</th>

					</tr>";
			

				while ($linha = mysqli_fetch_assoc($resultado)) {
					echo "<tr>";

						echo "<td>".$linha["id_utilizador"]."</td>";
						echo "<td>".$linha["nome"]."</td>";
						echo "<td>".$linha["ultimo_nome"]."</td>";
						echo "<td>".$linha["e_mail"]."</td>";
						echo "<td>".$linha["user_name"]."</td>";
					echo "</tr>";

				}
				echo "</table>";

			} else {
				echo "<h4>Ainda não há docentes<br></h4>";
				
			}

        echo "<h2>Criar curso:</h2>";	
    
        ?>
	
		<form action="criar_curso.php" method="POST">
			Id do docente<input type="number" name="id"><br>
			Nome Curso: <input type="text" name="nome_curso"><br>
			Descrição: <textarea name="descricao" rows="1" cols="50"></textarea><br>
			Preço: <input type="number" name="preco"><br>
			Vagas: <input type="number" name="vagas_totais"><br>
			<input type="submit" value="Criar Curso">
		</form>
    <?php
    $sql = "SELECT * FROM cursos ";

    $resultado = mysqli_query($conn, $sql);

    if ($resultado && mysqli_num_rows($resultado) >0) {
        echo "<h2> Todos os cursos: </h2>";
        echo "<table border='1'>";
        echo "  <tr>
                    <th>Id_curso</th>
                    <th>ID docente</th>
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
                    echo "<td>".$linha["id_utilizador"]."</td>";
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
            echo "<h4>Ainda não há cursos.<br></h4>";
            
        }
    }
    else
        header("refresh:0;url=index.php");


?>

