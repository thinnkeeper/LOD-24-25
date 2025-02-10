<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Novo Utilizador</title>
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
                    session_start();
                    require_once "../basedados/basedados.h";
                    
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

                $tipoUtilizador = "SELECT `tipoUtilizador` FROM `utilizador`";
                $res = mysqli_query($conn, $tipoUtilizador);
                
                $tiposUtilizador = array();
                while ($row = mysqli_fetch_assoc($res)) {
                    $tiposUtilizador[] = $row['tipoUtilizador'];
                }

                ?>
                <br>
                <form method="POST" action="criaNovoUtilizador.php">
                    <label>Utilizador:</label>
                    <input type="text" name="nomeUtilizador">
                    <label>Password:</label>
                    <input type="password" name="password">
                    <select name="tipoUtilizador">
                        <?php
                        foreach ($tiposUtilizador as $tipo) {
                            echo '<option value="' . $tipo . '">' . $tipo . '</option>';
                        }                        
                        ?>
                    </select><br><br>
                    <label>Email:</label>
                    <input type="text" name="email"><br>
                    <input type="submit" value="Introduzir">
                    <button><a href='pgGestaoutilizadores.php'>Voltar</a></button>
                </form>
                <br>
            <?php
            }
            ?>
    </div>

</body>
</html>