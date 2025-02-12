<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <html>
    <body>
    <table border="1">
      <tr style="color: white" bgcolor="#401f1f">
        <th>Código</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Data</th>
        <th>Docente</th>
        <th>Hora Início</th>
        <th>Duração</th>
        <th>Lotação</th>
      </tr>
      <xsl:for-each select="formacoes/formacao">
      <tr>
        <td><xsl:value-of select="codigo"/></td>
        <td><xsl:value-of select="nome"/></td>
        <td><xsl:value-of select="descricao"/></td>
        <td><xsl:value-of select="data"/></td>
        <td><xsl:value-of select="docente/@id"/> - <xsl:value-of select="docente"/></td>
        <td><xsl:value-of select="horaInicio"/></td>
        <td><xsl:value-of select="duracao"/></td>
        <td><xsl:value-of select="lotacao"/></td>
        <td>
          <a style="color: red">
            <xsl:attribute name="href">
              <xsl:value-of select="eliminar/@link" />
            </xsl:attribute>
            <xsl:value-of select="eliminar"/>
          </a>
        </td>
        <td>
          <a style="color: green">
            <xsl:attribute name="href">
              <xsl:value-of select="editar/@link" />
            </xsl:attribute>
            <xsl:value-of select="editar"/>
          </a>
        </td>
      </tr>
      </xsl:for-each>
    </table>
    </body>
    </html>
  </xsl:template>  
</xsl:stylesheet>