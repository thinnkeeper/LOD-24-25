<html>
    <head>
        <meta charset="utf-8">
        <title>Página Gestão</title>
        <link rel="stylesheet" href="styles.css">

    </head>
    <body>
        <div id="cabecalho">
            <a href='pgHomepage.php'>
                <div id="logo">
                    <h2>FormacõesLW</h2>
                </div>
            </a>
            <div class= "input-div">
                <div id="botoes"> 
                    <?php
                        ob_start();
                        session_start();
                        
                        if($_SESSION["autenticado"]){
                            
                            echo "
                                <div id='botao'>
                                    <form action='./logout.php'>
                                        <input type='submit' value='Logout'>
                                    </form>
                                </div>
                                <div id='botao'>
                                    <form action='./pgGestao.php'>
                                        <input type='submit' value='Area Pessoal'>
                                    </form>
                                </div>
                            ";	
                        }else {
                            
                            echo "
                                <div id='botao'>
                                    <form action='./PgLogin.php'>
                                        <input type='submit' value='Login'>
                                    </form>
                                </div>
                                <div id='botao'> 
                                    <form action='./PgRegisto.php'>
                                        <input type='submit' value='Registe-se'>
                                    </form>
                                </div>
                            ";
                            
                        }
                    ?>
                </div>
            </div>
        </div>
        <div id="corpo">
            <?php
                if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true)) {
                    echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
                    header("refresh:1; url=pgHomepage.php");
                } else {
                    echo "Bem vindo/a " .$_SESSION['nomeUtilizador']. "!";
            ?>
                <table border="2" cellpadding="2" cellspacing="2" width="20%" height="20%">
                    <tr>
                        <td align="center"><button><a href='pgDadosPessoais.php' style="text-decoration: none;">Dados Pessoais</a></button>                        

                        <?php
                        if($_SESSION['tipoUtilizador'] == 1) {
                        ?>
                            <button><a href='pgGestaoUtilizadores.php' allign="center" style="text-decoration: none;">Gestão Utilizadores</a></button>
                        <?php
                        }
                        ?>
                        <?php
                        if($_SESSION['tipoUtilizador'] >= 1 && $_SESSION['tipoUtilizador'] <= 2) {
                        ?>
                            <button><a href='pgGestaoFormacoes.php' allign="center" style="text-decoration: none;">Gestão Formações</a></button>
                        <?php
                        }
                        ?>
                        <button><a href='pgGestaoInscricoes.php' style="text-decoration: none;">Gerir Inscrições</a></button>
                        <?php
                        if($_SESSION['tipoUtilizador'] == 3) {
                        ?>
                            <button><a href='pgInscricao.php' style="text-decoration: none;">Marcar Nova Inscrição</a></button>
                        <?php
                        }
                        ?>
                    </tr>

                </table>
                
                        <?php
                        if($_SESSION['tipoUtilizador'] == 1) {
                        ?>
                            <table border="2" cellpadding="2" cellspacing="2" width="20%" height="20%">
                                <tr>
                                    <td align="center">
                                    <button><a href='exportarXML.php' allign="center" style="text-decoration: none;">Exportar XML</a></button>
                                    <button><a href='exportarDTD.php' allign="center" style="text-decoration: none;">Exportar DTD</a></button>
                                    <button><a href='exportarXSD.php' allign="center" style="text-decoration: none;">Exportar XSD</a></button>
                                </tr>
                            </table>
                        <?php
                        }
                        ?>
                    
                <br>
                <?php
                }
                ?>
        </div>
    </body>
</html>
