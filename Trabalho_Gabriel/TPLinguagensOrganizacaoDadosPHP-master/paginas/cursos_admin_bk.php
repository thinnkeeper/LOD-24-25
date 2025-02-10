<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Docentes e cursos</title>
    <link rel="stylesheet" href="estilo.css">
        <body>
            
            
    
<?php 
    ob_start();
	include_once("../basedados/basedados.h");
	session_start();
    
    if (isset($_SESSION['perfil'])&&$_SESSION['perfil']=='admin'){
        echo "  <header>Docentes e cursos</header>

                <div class = 'container'>
                    <div class = 'button-group'>
                        <a href='logout.php'>Logout</a>
                        <a href='menu_admin.php'>Home Page</a>
                    </div
                ";
                

        /**
         * Este bloco de codigo faz:
         *  1. Cria um ficheiro xml e cria seu primeiro elemento "docentes"
         *  2. essa variavel, em php, é a raiz
         *  2. faz uma query na base de dados referente ao nome das colunas 
         * e armazena na variavel nome coluna, que por sua vez é um array
         */
        $xml = new DOMDocument('1.0', 'UTF-8');
        $root = $xml->createElement("docentes");
        $xml->appendChild($root);

        $sql_col = "SHOW COLUMNS FROM utilizadores";
        $res_col = mysqli_query($conn, $sql_col);
        $n_col=0;

        while ($row_col = mysqli_fetch_array($res_col)) {
            $nome_coluna[$n_col++]=$row_col[0];
        }



        /**
         * Este bloco de codigo faz:
         *  1. faz select dos docentes para saber suas infos
         *  2. cria um elemento "tabela_docente" que é filha da root "docente"
         *  3. no while vai criar para cada resultado do select uma variavel docente
         *  que sera filha da tabela docente
         *  4. o fluxo for vai criar os conteudos de cada coluna de cada docente e 
         *  criar este novo elemento como filho do elemento docente
         */
        $select_docentes = "SELECT * FROM utilizadores WHERE perfil = 'docente'";
		$resultado_select_docentes = mysqli_query($conn, $select_docentes);

        // mudar esta visualização
		if ($resultado_select_docentes && mysqli_num_rows($resultado_select_docentes) >0) {

            $tabela_docente = $xml->createElement("tabela_docente");
            $root->appendChild($tabela_docente);

            while ($row=mysqli_fetch_array($resultado_select_docentes)) {
                $docente = $xml->createElement("docente");
                $tabela_docente->appendChild($docente);

                for ($n=0; $n < $n_col; $n++) { 
                    $coluna = $xml ->createElement($nome_coluna[$n],
                    htmlspecialchars($row[$n]));
                    $docente->appendChild($coluna);
                }
            }

            $xslt_docentes = new DOMDocument();
            $xslt_docentes->loadXML('<?xml version="1.0" encoding="UTF-8"?>
		<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
		<xsl:template match="/">
			<html>
				<body>
					<table>
						<tr>
							
							<xsl:for-each select="docentes/tabela_docente/docente[1]/*">
								<xsl:if test="name() !=\'password\' and name() !=\'perfil\' and name() !=\'autenticado\'and name() !=\'gerir_nao_inscrito\' ">
									<th><xsl:value-of select="name()"/></th>
                                </xsl:if>
							</xsl:for-each>
							
						</tr>
						<xsl:for-each select="docentes/tabela_docente/docente">
							<tr>
								
							    <xsl:for-each select="*">
									<xsl:if test="name() !=\'password\' and name() !=\'perfil\' and name() !=\'autenticado\'and name() !=\'gerir_nao_inscrito\' ">
									    <td><xsl:value-of select="."/></td>
                                    </xsl:if>
								</xsl:for-each>
							</tr>
						</xsl:for-each>
					</table>
				</body>
			</html>
		</xsl:template>
		</xsl:stylesheet>');

        $xslt_processor_docente = new XSLTProcessor();
		$xslt_processor_docente->importStylesheet($xslt_docentes);
        echo "
                <div class='container'>
                    <h2>Docentes</h2>";
		echo $xslt_processor_docente->transformToXml($xml);

        echo "
                </div>
            </div>";        
                /*
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

*/

			} else {
				echo "<h4>Ainda não há docentes<br></h4>";
				
			}

        
    
        ?>
    <div class="container">    
    <div class="card">
        <h2>Criar Curso</h2>
		<form action="criar_curso.php" method="POST" style="width:50%;">
			Id do docente<input type="number" name="id"><br>
			Nome Curso: <input type="text" name="nome_curso"><br>
			Descrição: <textarea name="descricao" rows="3" cols="100"></textarea><br>
			Preço: <input type="number" name="preco"><br>
			Vagas: <input type="number" name="vagas_totais"><br>
			<input type="submit" value="Criar Curso">
		</form>
    </div>
    </div>
    <?php

        /**
         * Este bloco de codigo faz:
         *  1. Cria um ficheiro xml e cria seu primeiro elemento "cursos"
         *  2. essa variavel, em php, é a raiz
         *  2. faz uma query na base de dados referente ao nome das colunas 
         * e armazena na variavel nome coluna, que por sua vez é um array
         */
        $xml_cursos = new DOMDocument('1.0', 'UTF-8');
        $root_cursos = $xml_cursos->createElement("cursos");
        $xml_cursos->appendChild($root_cursos);

        $sql_col_cursos = "SHOW COLUMNS FROM cursos";
        $res_col_cursos = mysqli_query($conn, $sql_col_cursos);
        $n_col=0;

        while ($row_col = mysqli_fetch_array($res_col_cursos)) {
            $nome_coluna[$n_col++]=$row_col[0];
        }



        /**
         * Este bloco de codigo faz:
         *  1. faz select dos cursos para saber suas infos
         *  2. cria um elemento "tabela_cursos" que é filha da root "cursos"
         *  3. no while vai criar para cada resultado do select uma variavel curso
         *  que sera filha da tabela curso
         *  4. o fluxo for vai criar os conteudos de cada coluna de cada curso e 
         *  criar este novo elemento como filho do elemento curso
         */
        $select_cursos = "SELECT * FROM cursos ";
        $resultado_select_cursos = mysqli_query($conn, $select_cursos);

        if ($resultado_select_cursos && mysqli_num_rows(result: $resultado_select_cursos) >0) {
            // print_r($resultado_select_cursos);
            $tabela_curso = $xml_cursos->createElement("tabela_curso");
            $root_cursos->appendChild($tabela_curso);

            while ($row=mysqli_fetch_array($resultado_select_cursos)) {
                $curso = $xml_cursos-> createElement("curso");
                $tabela_curso->appendChild($curso);

                for ($n=0; $n < $n_col; $n++) { 
                    $coluna = $xml_cursos->createElement($nome_coluna[$n],htmlspecialchars($row[$n]));
                    $curso->appendChild($coluna);
                }
                //cria uma coluna aqui para passar dinamicamente o link de cada curso para ser editado
                $link_curso= $xml_cursos->createElement("gerenciar_curso", htmlspecialchars("gerenciar_curso.php?id_curso=".$row[0]));
				$curso->appendChild($link_curso);
            }
        

            // TODO adicionar coluna de acao para gerenciar curso FEITO
            // TODO tem como arredondar as extremidades das tabelas? FEITO
            $xslt_cursos = new DOMDocument();
            $xslt_cursos->loadXML('<?xml version="1.0" encoding="UTF-8"?>
		<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
		<xsl:template match="/">
			<html>
				<body>
					<table>
						<tr>
							
							<xsl:for-each select="cursos/tabela_curso/curso[1]/*">
								<xsl:if test="name() != \'gerenciar_curso\'">
									<th><xsl:value-of select="name()"/></th>
                                </xsl:if>
							</xsl:for-each>
							<th>Ação</th>
						</tr>
						<xsl:for-each select="cursos/tabela_curso/curso">
							<tr>
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



            
        $xslt_processor_curso = new XSLTProcessor();
		$xslt_processor_curso->importStylesheet($xslt_cursos);

        echo "<div class='container'>
                <h2>Cursos</h2><br>";

                echo $xslt_processor_curso->transformToXml($xml_cursos);

        echo " </div";

            /*
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
                */

            } else {
                echo "<h4>Ainda não há cursos.<br></h4>";
                
            }
        }
        else
            header("refresh:0;url=index.php");


    ?>

        </body>
    </head>
</html>
