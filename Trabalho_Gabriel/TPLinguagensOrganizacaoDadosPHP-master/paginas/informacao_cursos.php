<!DOCTYPE html>
<html>
    <head>
        <title>Informações cursos</title>
        <link rel="stylesheet" href="estilo.css?v=1.0">
        <body>
            <header>Informações sobre cursos</header>

			<div class="container">
            <div class="button-group">
                <a href="index.php">Voltar para a Página Inicial</a>
            </div>
        </div>

        <div class="container">
            <div class="card">
        

<?php
	ob_start();
	include_once("../basedados/basedados.h");

	//criacao do documento xml

	$xml = new DOMDocument('1.0','UTF-8');
	//cria um novo elemtento XML
	$root = $xml->createElement("cursos");
	//anexa 'dados' como nó da raiz do documento XML
	$xml->appendChild($root);


	$sql_col = "SHOW COLUMNS FROM cursos";
	$res_col = mysqli_query($conn,$sql_col);
	$n_col = 0;

	while ($row_col = mysqli_fetch_array($res_col)) {
		$nome_col[$n_col++]=$row_col[0];
	}


	$sql_select = "SELECT * FROM cursos";
	$res_select = mysqli_query($conn, $sql_select);
	$num_select = mysqli_num_rows($res_select);

	if($num_select>0){
		//echo "$num_select cursos encontrados<br>";
		$tcurso = $xml->createElement("tabela_curso");
		$root->appendChild($tcurso);

		while($row=mysqli_fetch_array($res_select, MYSQLI_NUM)){
			$curso = $xml->createElement("curso");
			$tcurso->appendChild($curso);
			
			for ($n=0; $n<$n_col; $n++){
				$col = $xml->createElement($nome_col[$n], htmlspecialchars($row[$n]));
				$curso->appendChild($col);
			}
		}
}




$xslt_curso = new DOMDocument();

$xslt_curso->loadXML('<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
    <html>
    <head>
        
    </head>
    <body>
        
        <table>
            <tr>
                <xsl:for-each select="cursos/tabela_curso/curso[1]/*">
                    <th><xsl:value-of select="name()"/></th>
                </xsl:for-each>
            </tr>
            <xsl:for-each select="cursos/tabela_curso/curso">
                <tr>
                    <xsl:for-each select="*">
                        <td><xsl:value-of select="."/></td>
                    </xsl:for-each>
                </tr>
            </xsl:for-each>
        </table>
        
    </body>
    </html>
</xsl:template>
</xsl:stylesheet>');

//aplicar tranformacao do xslt ao xml
	$xslt_processor = new XSLTProcessor();
	$xslt_processor->importStylesheet($xslt_curso);
	echo $xslt_processor->transformToXml($xml);
            


?>

			</div>
		</div>

        </body>
    </head>
</html>