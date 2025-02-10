<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
   xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <!-- Define a saída como HTML com codificação UTF-8 -->
  <xsl:output method="html" encoding="UTF-8" indent="yes"/>

  <!-- Template principal: aplica-se ao documento inteiro -->
  <xsl:template match="/">
    <html>
      <head>
        <meta charset="UTF-8"/>
        <title>Gestão de Utilizadores</title>
        <style type="text/css">
          <![CDATA[
            body {
                background-color: #fff5f5;
            }
            
            h3, h1 {
                text-align: center;
            }
            
            #cabecalho {
                margin: -8px;
                height: 100px;
                border: 2px solid #401f1f;
            }
            
            th {
                padding: 15px;
            }
            
            .input-div {
                margin: 5px;
                float: right;
                height: 100px;
            }
            
            input[type=submit] {
                background-color: #401f1f;
                padding: 10px 20px;
                height: 50px;
                font: bold 15px sans-serif;
                color: white;
                box-shadow: 2px 2px 5px #000000;
                cursor: pointer;
                border: 0px;
            }
            
            input[type=submit]:hover {
                box-shadow: 1px 1px 5px #000000;
            }
            
            #botoes {
                margin: 10px;
            }
            
            #botao {
                float: right;
                margin: 10px;
            }
            
            #logo {
                float: left;
                margin-left: 80px;
                margin-top: 25px;
                width: 180px;
                height: 60px;
                color: #401f1f;
            }
            
            a:link, a:visited {
                color: white;
                font: bold 15px sans-serif;
                text-decoration: none;
            }
            h2 {
                color: #401f1f;
            }
            button {
                background-color: #401f1f;
                padding: 10px 20px;
                height: 50px;
                font: bold 15px sans-serif;
                color: white;
                box-shadow: 2px 2px 5px #000000;
                cursor: pointer;
                border: 0px;
            }
            
            #corpo {
                border: 2px solid #401f1f;
                margin: -8px;
                margin-top: 10px;
            }
            
            #corpo > * {
                margin: auto;
            }
            
            #imagem {
                border: 2px solid #401f1f;
                margin: 1%;
            }
            
            #dados {
                border: 2px solid #401f1f;
                margin-top: 15px;
                margin-left: 1%;
                margin-right: 1%;
                margin-bottom: 15px;
                height: 500px;
            }
            
            #localizacao {
                border: 2px solid #401f1f;
                float: left;
                margin: 20px;
            }
            
            #horario {
                border: 2px solid #401f1f;
                float: left;
                margin: 20px;
                text-align: center;
                padding: 70px;
            }
            
            form {
                width: 300px;
                margin: 0 auto;
                text-align: center;
            }
            
            label {
                font-size: 18px;
                display: block;
                text-align: left;
                margin-bottom: 5px;
            }
            
            input[type="text"],
            input[type="password"],
            input[type="submit"] {
                background-color: #401f1f;
                border: none;
                color: white;
                padding: 10px 20px;
                font-weight: bold;
                font-size: 15px;
                margin-bottom: 10px;
                box-shadow: 2px 2px 5px #000000;
                cursor: pointer;
                display: block;
                width: 100%;
            }
            
            input[type="submit"]:hover {
                box-shadow: 1px 1px 5px #000000;
            }
            
            a {
                color: black;
                font-weight: bold;
                text-decoration: none;
                display: block;
                text-align: center;
            }
          ]]>
        </style>
      </head>
      <body>
        <!-- Cabeçalho com o logo -->
        <div id="cabecalho">
          <div id="logo">
            <h2>FormacõesLW</h2>
          </div>
          <!-- Poderá incluir aqui os botões de login/logout se necessário -->
          <div class="input-div">
            <div id="botoes">
              <!-- Espaço reservado para botões -->
            </div>
          </div>
        </div>
        
        <!-- Corpo principal da página -->
        <div id="corpo">
          <h1>Gestão de Utilizadores</h1>
          <table border="1" style="text-align:center;">
            <tr>
              <th>ID</th>
              <th>Nome Utilizador</th>
              <th>Tipo Utilizador</th>
              <th>Email</th>
              <th>Validar</th>
              <th>Eliminar</th>
              <th>Editar</th>
            </tr>
            <!-- Itera por cada utilizador -->
            <xsl:for-each select="utilizadores/utilizador">
              <tr>
                <td><xsl:value-of select="id"/></td>
                <td><xsl:value-of select="nomeUtilizador"/></td>
                <td><xsl:value-of select="tipoUtilizador"/></td>
                <td><xsl:value-of select="email"/></td>
                <td>
                  <xsl:choose>
                    <xsl:when test="acao[@tipo='validar']">
                      <a href="{acao[@tipo='validar']}">
                        <font color="purple">VALIDAR</font>
                      </a>
                    </xsl:when>
                    <xsl:otherwise>
                      <!-- Espaço em branco se não existir ação de validar -->
                    </xsl:otherwise>
                  </xsl:choose>
                </td>
                <td>
                  <a href="{acao[@tipo='eliminar']}">
                    <font color="red">ELIMINAR</font>
                  </a>
                </td>
                <td>
                  <a href="{acao[@tipo='editar']}">
                    <font color="green">EDITAR</font>
                  </a>
                </td>
              </tr>
            </xsl:for-each>
          </table>
          <br/>
          <div>
            <button>
              <a href="pgNovoUtilizador.php" style="text-decoration: none;">Novo Utilizador</a>
            </button>
            <button>
              <a href="pgGestao.php" style="text-decoration: none;">Voltar</a>
            </button>
          </div>
        </div>
      </body>
    </html>
  </xsl:template>
  
</xsl:stylesheet>