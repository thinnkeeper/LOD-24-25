<!DOCTYPE html>
<html>
    <head>
        <title>Informações da Empresa</title>
        <link rel="stylesheet" href="estilo.css?v=1.0">
        <body>
            
        <header>Informações da Empresa</header>

        <div class="container">
            <div class="button-group">
                <a href="index.php">Voltar para a Página Inicial</a>
            </div>
        </div>

        <div class="container">
            <div class="card">
                
<?php


$xml_dados_empresa = '<?xml version="1.0" encoding="UTF-8"?>
<informacao_empresa>
	<designacao> Empresa de Formação ESTCursosDigitais </designacao>
    <morada> Avenida do Empresário </morada>
    <freguesia> Castelo Branco </freguesia>
    <codigo_postal> 6000-767 </codigo_postal>
    <horario_funcionamento>Segunda-Sexta: 8:00 às 22:00 Sábado: 9:00 às 13:00</horario_funcionamento>
    
</informacao_empresa>';

$xslt_dados_empresa = '<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
    <html>
        <head>
        </head>
        <body>
            <table>
                <tr>
				    <th>Designação</th>
                    <th>Morada</th>
                    <th>Freguesia</th>
                    <th>Código Postal</th>
                    <th>Horário de Funcionamento</th>
                </tr>
                <xsl:for-each select="informacao_empresa">
                <tr>
					<td><xsl:value-of select="designacao"/></td>
                    <td><xsl:value-of select="morada"/></td>
                    <td><xsl:value-of select="freguesia"/></td>
                    <td><xsl:value-of select="codigo_postal"/></td>
                    <td><xsl:value-of select="horario_funcionamento"/></td>
                </tr>
                </xsl:for-each>
            </table>
            
        </body>
</html>
</xsl:template>
</xsl:stylesheet>';

$xslt = new XSLTProcessor();
$xslt->importStylesheet(new SimpleXMLElement($xslt_dados_empresa));

echo $xslt->transformToXml(new SimpleXMLElement($xml_dados_empresa));
//echo ($xml_dados_empresa);
?>
    
            </div>
        </div>

        </body>
    </head>
</html>