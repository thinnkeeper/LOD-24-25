<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Menu Administrador</title>
	<link rel="stylesheet" href="estilo.css?v=1.0">
	
</head>
<body>


<?php
	ob_start();
	include_once("../basedados/basedados.h");
	session_start();
	
	if (isset($_SESSION['perfil'])&&$_SESSION['perfil']=='admin') {
		echo "<header>Página do administrador</header>";
		//pagina toda
		echo '<div class="container">';
		echo '<div class="button-group">';
		
		
		echo "	<a href='logout.php'>Logout</a>
				<a href='editar_perfil.php'>Editar Perfil<br></a>
				<a href='cursos_admin.php'>Cursos<br></a>
				</div>";
		echo "<h1 style='text-align:center;'>Bem-vindo ".$_SESSION['user_name']."</h1>";
		
		echo "	
			</div>";

		
		
		?>
		
				<div class="form-registo">
					<h2>Registar Utilizador</h2>
					<form action="registo.php" method="post"  >
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
		

		<div class="container">
			<div class="card">
			

		
		<?php
		//query para listar os utilizadores que ainda nao foram autenticados
		$sql_false = "SELECT * FROM utilizadores WHERE autenticado = false";
		$resultado_false = mysqli_query($conn, $sql_false);


		if ($resultado_false && mysqli_num_rows($resultado_false) >0) {
			echo "<h2> Pedidos Pendentes </h2>";

			$xml_n_autenticados = new DOMDocument('1.0', 'UTF-8');
			$root_n_autenticados = $xml_n_autenticados->createElement("nao_autenticados");
			$xml_n_autenticados->appendChild($root_n_autenticados);

			// print_r($resultado_false);
			$show_col = "SHOW COLUMNS FROM utilizadores";
			$res_show_col = mysqli_query($conn,$show_col);
			$n_col=0;

			while ($row_col = mysqli_fetch_array($res_show_col)) {
				$nome_col[$n_col++]=$row_col[0];
				
			}
			// print_r($nome_col);
			// print_r($resultado_false);

			$t_n_autenticados = $xml_n_autenticados->createElement("tabela_nao_autenticados");
			$root_n_autenticados->appendChild($t_n_autenticados);
			
			// $iteracao=0;
			while ($row=mysqli_fetch_array($resultado_false)) {
				// print_r($row);
				$utilizador_n_autenticado = $xml_n_autenticados->createElement("utilizador_nao_autenticado");
				$t_n_autenticados->appendChild($utilizador_n_autenticado);
				// print_r("numero de iteracoes".$iteracao);
				// $iteracao++;

				for ($i=0; $i < $n_col; $i++) { 
					// print_r($nome_col[$i].": ".$row[$nome_col[$i]]." ");
					$col = $xml_n_autenticados->createElement($nome_col[$i], htmlspecialchars($row[$nome_col[$i]]));
        			$utilizador_n_autenticado->appendChild($col);
					
					
				}
				
				// print_r("<br>");
				// print_r($nome_col);
				// print_r($utilizador_n_autenticado);
				$link_autenticar =$xml_n_autenticados->createElement("autenticar",htmlspecialchars("autenticar_utilizador.php?id=".$row["id_utilizador"]."&e_mail=".$row["e_mail"]."&user_name=".$row["user_name"].""));
				$utilizador_n_autenticado->appendChild($link_autenticar);

				$link_confirmacao =$xml_n_autenticados->createElement("confirmar",htmlspecialchars("confirmacao.php?id=".$row["id_utilizador"]."&e_mail=".$row["e_mail"]."&user_name=".$row["user_name"].""));
				$utilizador_n_autenticado->appendChild($link_confirmacao);
				// print_r($utilizador_n_autenticado);
				// var_dump($utilizador_n_autenticado);  
			}

			// print_r($utilizador_n_autenticado);
			// print_r($res_show_col);
			// echo $xml_n_autenticados->saveXML();
			// echo "<pre>" . htmlspecialchars($xml_n_autenticados->saveXML()) . "</pre>";
			
			$xslt_n_autenticados = new DOMDocument();
			$xslt_n_autenticados-> loadXML('<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <html>
            <body>
                <table>
                    <tr>
                        <xsl:for-each select="nao_autenticados/tabela_nao_autenticados/utilizador_nao_autenticado[1]/*">
                            <xsl:if test="name() != \'password\' and name() != \'autenticado\' and name() != \'autenticar\' and name() != \'confirmar\'">
                                <th><xsl:value-of select="name()"/></th>
                            </xsl:if>
                        </xsl:for-each>
						<th>Ação</th>
                        <th>Ação</th>
                    </tr>
                    <xsl:for-each select="nao_autenticados/tabela_nao_autenticados/utilizador_nao_autenticado">
                        <tr>
                            <xsl:for-each select="*">
                                <xsl:if test="name() != \'password\' and name() != \'autenticado\' and name() != \'autenticar\' and name() != \'confirmar\'">
                                    <td><xsl:value-of select="."/></td>
                                </xsl:if>
                            </xsl:for-each>
                            <td>
                                <a href="{autenticar}">Autenticar</a>
                                
                            </td>
							<td>
								<a href="{confirmar}">Cancelar</a>
							</td>
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>');

		$xslt_processor_n_autenticados = new XSLTProcessor();
		$xslt_processor_n_autenticados->importStylesheet($xslt_n_autenticados);
		echo $xslt_processor_n_autenticados->transformToXml($xml_n_autenticados);


			/*
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
				*/
		 	} else {
				echo "<h4>Não há pedidos pendentes<br></h4>";
				
				
			}
		

		?>
			</div>
		</div>


		<div class="container">
			<div class="card">
		<?php

		
		//query para pegar todos os utilizadores autenticados
		$autenticados= "SELECT * FROM utilizadores WHERE autenticado = true";
		$resultado_autenticados = mysqli_query($conn, $autenticados);

		if ($resultado_autenticados && mysqli_num_rows($resultado_autenticados) >0) {
			echo "<h2> Utilizadores autenticados </h2>";

			$xml_autenticados = new DOMDocument('1.0', 'UTF-8');
			$root_autenticados = $xml_autenticados->createElement('autenticados');
			$xml_autenticados->appendChild($root_autenticados);

			$show_col = "SHOW COLUMNS FROM utilizadores";
			$res_show_col = mysqli_query($conn,$show_col);
			$n_col=0;

			while ($row_col = mysqli_fetch_array($res_show_col)) {
				$nome_col[$n_col++]=$row_col[0];
				
			}

			$t_autenticados = $xml_autenticados->createElement("tabela_autenticados");
			$root_autenticados->appendChild($t_autenticados);


			while ($row=mysqli_fetch_array($resultado_autenticados)) {
				$utilizador_autenticado = $xml_autenticados->createElement("utilizador_autenticado");
				$t_autenticados->appendChild($utilizador_autenticado);
				// echo "<pre>" . htmlspecialchars($xml_autenticados->saveXML()) . "</pre>";
				

				for ($i=0; $i < $n_col; $i++) { 
					$col =$xml_autenticados->createElement($nome_col[$i],htmlspecialchars($row[$nome_col[$i]]));
					$utilizador_autenticado->appendChild($col);
				}

				$link_bloquear =$xml_autenticados->createElement("bloquear",htmlspecialchars("bloquear_utilizador.php?id=".$row["id_utilizador"]."&e_mail=".$row["e_mail"]."&user_name=".$row["user_name"].""));
				$utilizador_autenticado->appendChild($link_bloquear);

				$link_confirmacao =$xml_autenticados->createElement("confirmar",htmlspecialchars("confirmacao.php?id=".$row["id_utilizador"]."&e_mail=".$row["e_mail"]."&user_name=".$row["user_name"].""));
				$utilizador_autenticado->appendChild($link_confirmacao);

			}
			

			$xslt_autenticados = new DOMDocument();
			$xslt_autenticados->loadXML('<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <html>
            <body>
                <table>
                    <tr>
                        <xsl:for-each select="autenticados/tabela_autenticados/utilizador_autenticado[1]/*">
                            <xsl:if test="name() != \'password\' and name() != \'autenticado\' and name() != \'bloquear\' and name() != \'confirmar\'">
                                <th><xsl:value-of select="name()"/></th>
                            </xsl:if>
                        </xsl:for-each>
						<th>Ação</th>
                        <th>Ação</th>
                    </tr>
                    <xsl:for-each select="autenticados/tabela_autenticados/utilizador_autenticado">
                        <tr>
                            <xsl:for-each select="*">
                                <xsl:if test="name() != \'password\' and name() != \'autenticado\' and name() != \'bloquear\' and name() != \'confirmar\'">
                                    <td><xsl:value-of select="."/></td>
                                </xsl:if>
                            </xsl:for-each>
                            <td>
                                <a href="{bloquear}">Bloquear</a>
                                
                            </td>
							<td>
								<a href="{confirmar}">Cancelar</a>
							</td>
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>');

			$xslt_processor_autenticados = new XSLTProcessor();
			$xslt_processor_autenticados->importStylesheet($xslt_autenticados);
			echo $xslt_processor_autenticados->transformToXml($xml_autenticados);

			/*
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
				*/

			} else {
				echo "<h4>Não há pedidos pendentes<br></h4>";
				
			}
			
	} else{
		echo "Problemas com autenticação";
		header("refresh:3;url=index.php");
		}	
	mysqli_close($conn);



?>
		</div>
	</div>
</body>
</html>