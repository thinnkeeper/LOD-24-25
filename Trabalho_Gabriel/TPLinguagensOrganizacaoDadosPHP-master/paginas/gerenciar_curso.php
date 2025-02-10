<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gerir Curso</title>
	<link rel="stylesheet" href="estilo.css?v=1.0">
	
</head>
<body>
<?php
	ob_start();
	include_once("../basedados/basedados.h");
	session_start();
	

	echo "<header>Página de gestão de curso</header>";
	//pagina toda
	echo '<div class="container">';
	echo '<div class="button-group">';

	if (isset($_SESSION['perfil'])&&($_SESSION['perfil']=='docente'||$_SESSION['perfil']=='admin')) {
		echo "<a href='logout.php'>Logout</a>";
		$perfil = $_SESSION["perfil"];

		if ($perfil == 'docente') {
        echo "<a href='menu_docente.php' style= margin:2px>Home Page</a>";
		}
		else{
			echo "<a href='menu_admin.php' style= margin:2px>Home Page</a>";
		}


		$id_curso = $_GET['id_curso'];
		echo "<a href='cancelar_curso.php?id_curso=".$id_curso."'>Cancelar curso?</a>";

		echo "</div>";

		
		$sql_curso = "SELECT * FROM cursos WHERE id_curso = ".$id_curso."";
		$resultado_curso = mysqli_query($conn,$sql_curso);
		if ($resultado_curso&&mysqli_num_rows($resultado_curso)>0) {
			$row = mysqli_fetch_assoc($resultado_curso);

		?>
		<div class="form-registo">
			<form action="atualizar_curso.php" method="POST">
				<input type="hidden" name="id_curso" value="<?php echo $id_curso; ?>">
				<input type="hidden" name="vagas_disponiveis" value="<?php echo $row["vagas_disponiveis"]; ?>">
				<input type="hidden" name="vagas_totais_antigas" value="<?php echo $row["vagas_totais"]; ?>">
				Titulo: <input type="text" name="nome_curso" value="<?php echo $row['nome_curso']; ?>">
				Descrição: <input type="text" name="descricao" value="<?php echo $row['descricao']; ?>">
				Preço: <input type="number" name="preco" value="<?php echo $row['preco']; ?>">
				Vagas Totais<input type="number" name="vagas_totais" value= "<?php echo $row['vagas_totais'];?>">
				Vagas Disponíveis: <?php echo $row['vagas_disponiveis'];?>
				<input type="submit" value="Atualizar curso">
			</form>
		</div>
		<?php

		}
		// para inscrever um aluno a um curso
		echo '<div class ="card">';
		echo "<h2>Aluno(s) não inscritos</h2>";

		$xml = new DOMDocument('1.0', 'UTF-8');
		$root = $xml->createElement("alunos");
		$xml->appendChild($root);

		$sql_col = "SHOW COLUMNS FROM utilizadores";
		$res_col = mysqli_query($conn,$sql_col);
		$n_col=0;

		while ($row_col = mysqli_fetch_array($res_col)) {
			$nome_col[$n_col++]=$row_col[0];
		}


		$select_aluno = "SELECT * FROM utilizadores WHERE perfil = 'aluno' AND id_utilizador NOT IN (SELECT id_utilizador FROM inscricoes WHERE id_curso = ".$id_curso.")";
		$resultado_select_alunos = mysqli_query($conn,$select_aluno);

		if ($resultado_select_alunos&&mysqli_num_rows($resultado_select_alunos)>0) {

			$tAluno = $xml->createElement("tabela_aluno");
			$root->appendChild($tAluno);

			while ($row=mysqli_fetch_array($resultado_select_alunos)) {
				$aluno = $xml->createElement("aluno");
				$tAluno->appendChild($aluno);

				for ($n=0; $n <$n_col ; $n++) { 
					$col = $xml->createElement($nome_col[$n], htmlspecialchars($row[$n]));
					$aluno->appendChild($col);
				}
				$link_gerir_inscrito = $xml->createElement("gerir_nao_inscrito",htmlspecialchars("inscrever_curso.php?id_curso=".$id_curso."&id_aluno=".$row[0]));
				$aluno->appendChild($link_gerir_inscrito);
			}

		$xslt = new DOMDocument();
		$xslt->loadXML('<?xml version="1.0" encoding="UTF-8"?>
		<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
		<xsl:template match="/">
			<html>
				<body>
					<table>
						<tr>
							<!-- Gera titulos das colunas, menos para a coluna gerenciar_curso -->
							<xsl:for-each select="alunos/tabela_aluno/aluno[1]/*">
								<xsl:if test="name() !=\'password\' and name() !=\'perfil\' and name() !=\'autenticado\' and name() !=\'gerir_nao_inscrito\' ">
									<th><xsl:value-of select="name()"/></th>
								</xsl:if>
							</xsl:for-each>
							<th>Ação</th>
						</tr>
						<xsl:for-each select="alunos/tabela_aluno/aluno">
							<tr>
								<!-- Gera dados das colunas, menos para a coluna gerenciar_curso -->
								<xsl:for-each select="*">
									<xsl:if test="name() !=\'password\' and name() !=\'perfil\' and name() !=\'autenticado\'and name() !=\'gerir_nao_inscrito\' ">
										<td><xsl:value-of select="."/></td>
									</xsl:if>
								</xsl:for-each>
								<!-- Botão de ação -->
								<td>
									<!-- link para direcionar ao aluno da respetiva linha-->

									<a href="{gerir_nao_inscrito}">Inscrever</a>
								</td>
							</tr>
						</xsl:for-each>
					</table>
				</body>
			</html>
		</xsl:template>
		</xsl:stylesheet>');

		$xslt_processor = new XSLTProcessor();
		$xslt_processor->importStylesheet($xslt);
		echo $xslt_processor->transformToXml($xml);

		echo "</div>";
			/*
			echo "<table>";
			echo "  <thead>
						<tr>
							<th>Id</th>
							<th>Nome</th>
							<th>Ultimo Nome</th>
							<th>Email</th>
							<th>Username</th>
							<th>Ação</th>
						</tr>
					</thead>";
			while ($linha = mysqli_fetch_assoc($resultado_select_alunos)) {
				echo "
					<tbody>
						<tr>";
					echo "<td>".$linha["id_utilizador"]."</td>";
					echo "<td>".$linha["nome"]."</td>";
					echo "<td>".$linha["ultimo_nome"]."</td>";
					echo "<td>".$linha["e_mail"]."</td>";
					echo "<td>".$linha["user_name"]."</td>";
					echo "<td><a href='inscrever_curso.php?id_curso=".$id_curso."&id_aluno=".$linha["id_utilizador"]."'>Inscrever</a></td>";
				echo "
					</tbody>
						</tr>";

						
			}*/


			// echo "</table>";
		} else {
			echo "<h4>Não há alunos para inscrever</h4>";
		}

		
		$sql = "SELECT * FROM inscricoes WHERE id_curso = ".$id_curso."";
		$resultado = mysqli_query($conn, $sql);

		if ($resultado && mysqli_num_rows($resultado) >0) {
			$sql = "SELECT nome_curso FROM cursos WHERE id_curso =".$id_curso."";
			$resultado_nome = mysqli_fetch_assoc(mysqli_query($conn,$sql));
			$nome_curso = $resultado_nome["nome_curso"];
			// echo "<h2> Nome do curso :".$nome_curso."</h2>";

			echo '<div class="card">';
			echo "<h2> Inscritos: </h2>";
			
			$xmlInscritos = new DOMDocument('1.0', 'UTF-8');
			$rootInscritos = $xmlInscritos->createElement("alunos");
			$xmlInscritos->appendChild($rootInscritos);

			


			$sql_col2 = "SHOW COLUMNS FROM utilizadores";
			$res_col2 = mysqli_query($conn,$sql_col2);
			$n_col=0;

			while ($row_col = mysqli_fetch_array($res_col2)) {
				$nome_col[$n_col++]=$row_col[0];
			}

			$select_aluno2 = "SELECT * FROM utilizadores WHERE perfil = 'aluno' AND id_utilizador IN (SELECT id_utilizador FROM inscricoes WHERE id_curso = ".$id_curso.")";
			$resultado_select_alunos2 = mysqli_query($conn,$select_aluno2);

			if ($resultado_select_alunos2&&mysqli_num_rows($resultado_select_alunos2)>0) {

				$tAluno = $xmlInscritos->createElement("tabela_aluno");
				$rootInscritos->appendChild($tAluno);
				
			
				while ($row=mysqli_fetch_array($resultado_select_alunos2)) {
					$aluno = $xmlInscritos->createElement("aluno");
					$tAluno->appendChild($aluno);
	
					for ($n=0; $n <$n_col ; $n++) { 
						$col = $xmlInscritos->createElement($nome_col[$n], htmlspecialchars($row[$n]));
						$aluno->appendChild($col);
					}
					$link_gerir_inscrito = $xmlInscritos->createElement("gerir_inscrito",htmlspecialchars("cancelar_inscricao.php?id_curso=".$id_curso."&id_utilizador=".$row[0]));
					$aluno->appendChild($link_gerir_inscrito);
				}

				// echo $xmlInscritos->saveXML();


		$xsltInscritos = new DOMDocument();
		$xsltInscritos->loadXML('<?xml version="1.0" encoding="UTF-8"?>
		<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
		<xsl:template match="/">
			<html>
				<body>
					<table>
						<tr>
							<!-- Gera titulos das colunas, menos para a coluna gerenciar_curso -->
							<xsl:for-each select="alunos/tabela_aluno/aluno[1]/*">
								<xsl:if test="name() !=\'password\' and name() !=\'perfil\' and name() !=\'autenticado\' and name () != \'gerir_inscrito\'">
									<th><xsl:value-of select="name()"/></th>
								</xsl:if>
							</xsl:for-each>
							<th>Ação</th>
						</tr>
						<xsl:for-each select="alunos/tabela_aluno/aluno">
							<tr>
								<!-- Gera dados das colunas, menos para a coluna gerenciar_curso -->
								<xsl:for-each select="*">
									<xsl:if test="name() !=\'password\' and name() !=\'perfil\' and name() !=\'autenticado\' and name () != \'gerir_inscrito\'">
										<td><xsl:value-of select="."/></td>
									</xsl:if>
								</xsl:for-each>
								<!-- Botão de ação -->
								<td>
									<a href="{gerir_inscrito}">Cancelar</a>
								</td>
							</tr>
						</xsl:for-each>
					</table>
				</body>
			</html>
		</xsl:template>
		</xsl:stylesheet>');

		$xslt_processor2 = new XSLTProcessor();
		$xslt_processor2->importStylesheet($xsltInscritos);
		echo $xslt_processor2->transformToXml($xmlInscritos);

		echo "</div>";
			
		}	
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