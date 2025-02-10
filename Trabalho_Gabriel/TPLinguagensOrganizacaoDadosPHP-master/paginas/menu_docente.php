<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Docente</title>
	<link rel="stylesheet" href="estilo.css?v=1.0">

</head>
<body>

<?php
	ob_start();
	include_once("../basedados/basedados.h");
	session_start();
	
	if (isset($_SESSION['perfil'])&&$_SESSION['perfil']=='docente') {
		echo "<header>Página do Docente</header>";
		
		echo "	<div class='container'>
					<div class='button-group'>
						<a href='logout.php'>Logout</a>
						<a href='editar_perfil.php'>Editar Perfil</a>
					</div>
					
				<h1 style='text-align:center;'>Bem-vindo ".$_SESSION['user_name']."</h1>
				</div>";


					

		

		//criacao do documento xml
		$xml = new DOMDocument('1.0','UTF-8');
		//cria um novo elemtento XML
		$root = $xml->createElement("dados");
		//anexa 'dados' como nó da raiz do documento XML
		$xml->appendChild($root);

		$sql_col = "SHOW COLUMNS FROM cursos";
		$res_col = mysqli_query($conn,$sql_col);
		$n_col = 0;

		while ($row_col = mysqli_fetch_array($res_col)) {
    
			$nome_col[$n_col++]=$row_col[0];
		}

		$sql_select = "SELECT * FROM cursos WHERE id_utilizador = ".$_SESSION['id']."";
		$res_select = mysqli_query($conn, $sql_select);
		$num_select = mysqli_num_rows($res_select);

		if($num_select>0){
			//echo "$num_select cursos encontrados<br>";
			$tcurso = $xml->createElement("tabela_curso");
			$root->appendChild($tcurso);
		
			while($row=mysqli_fetch_array($res_select)){
				$curso = $xml->createElement("curso");
				$tcurso->appendChild($curso);
				
				for ($n=0; $n<$n_col; $n++){
					$col = $xml->createElement($nome_col[$n], htmlspecialchars($row[$n]));
					$curso->appendChild($col);
				}
				//cria uma coluna aqui para passar dinamicamente o link de cada curso para ser editado
				$link_curso= $xml->createElement("gerenciar_curso", htmlspecialchars("gerenciar_curso.php?id_curso=".$row[0]));
				$curso->appendChild($link_curso);
			}
		}
		


		$xslt = new DOMDocument();
		$xslt->loadXML('<?xml version="1.0" encoding="UTF-8"?>
		<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
		<xsl:template match="/">
			<html>
				<body>
					<h1>Seus Cursos</h1>
					<table>
						<tr>
							<!-- Gera titulos das colunas, menos para a coluna gerenciar_curso -->
							<xsl:for-each select="dados/tabela_curso/curso[1]/*">
								<xsl:if test="name() != \'gerenciar_curso\'">
									<th><xsl:value-of select="name()"/></th>
								</xsl:if>
							</xsl:for-each>
							<th>Ação</th>
						</tr>
						<xsl:for-each select="dados/tabela_curso/curso">
							<tr>
								<!-- Gera dados das colunas, menos para a coluna gerenciar_curso -->
								<xsl:for-each select="*">
									<xsl:if test="name() != \'gerenciar_curso\'">
										<td><xsl:value-of select="."/></td>
									</xsl:if>
								</xsl:for-each>
								<!-- Botão de ação -->
								<td>
									<a href="{gerenciar_curso}">Gerir</a>
								</td>
							</tr>
						</xsl:for-each>
					</table>
				</body>
			</html>
		</xsl:template>
		</xsl:stylesheet>');

?>
		<div class="form-registo">
			<h2>Criar Curso</h2>
			<form action="criar_curso.php" method="POST" >
				<input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
				Nome Curso: <input type="text" name="nome_curso" rows="1"><br>
				Descrição: <textarea name="descricao" rows="1" cols="50"></textarea><br>
				Preço: <input type="number" name="preco"><br>
				Vagas: <input type="number" name="vagas_totais"><br>
				<input type="submit" value="Criar Curso">
			</form>
		</div>

	<div class="container">
		<div class="card">

		
<?php

$xslt_processor = new XSLTProcessor();
$xslt_processor->importStylesheet($xslt);
echo $xslt_processor->transformToXml($xml);

		
		//query para achar os cursos do docente 
		/*
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
		
			echo "<h2 style='max-width: 400px; margin: 0 auto; padding: 20px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>Criar curso:</h2>";	
			*/
		?>
		
		</div>
	</div>


	


    <?php
	
	
	} else{
		echo "Problemas com autenticação";
		header("refresh:3;url=index.php");
	}
	
	mysqli_close($conn);
?>
</body>
</html>
