<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <html>
    <body>
    <table border="1">
      <tr style="color: white" bgcolor="#401f1f">
        <th>ID</th>
        <th>Nome</th>
        <th>Tipo</th>
        <th>Email</th>
      </tr>
      <xsl:for-each select="utilizadores/utilizador">
      <tr>
        <td><xsl:value-of select="id"/></td>
        <td><xsl:value-of select="nomeUtilizador"/></td>
        <td><xsl:value-of select="tipoUtilizador"/></td>
        <td><xsl:value-of select="email"/></td>
        <td>
          <a style="color: purple">
            <xsl:attribute name="href">
              <xsl:value-of select="validar/@link" />
            </xsl:attribute>
            <xsl:value-of select="validar"/>
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