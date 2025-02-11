<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <html>
    <body>
    <table border="1">
      <tr style="color: white" bgcolor="#401f1f">
        <th>ID Inscrição</th>
        <th>ID Aluno</th>
        <th>ID Formação</th>
        <th>Data</th>
        <th>Estado</th>
      </tr>
      <xsl:for-each select="inscricoes/inscricao">
      <tr>
        <td><xsl:value-of select="idInscricao"/></td>
        <td><xsl:value-of select="aluno/@id"/> - <xsl:value-of select="aluno"/></td>
        <td><xsl:value-of select="formacao/@id"/> - <xsl:value-of select="formacao"/></td>
        <td><xsl:value-of select="data"/></td>
        <td><xsl:value-of select="estado"/></td>
        <td>
          <a style="color: purple">
            <xsl:attribute name="href">
              <xsl:value-of select="confirmar/@link" />
            </xsl:attribute>
            <xsl:value-of select="confirmar"/>
          </a>
        </td>
        <td><a style="color: red">
            <xsl:attribute name="href">
              <xsl:value-of select="eliminar/@link" />
            </xsl:attribute>
            <xsl:value-of select="eliminar"/>
          </a>
        </td>
        <td><a style="color: green">
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