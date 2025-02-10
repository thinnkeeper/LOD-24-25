<html>
    <head>
        <meta charset="utf-8">
        <title>Dados Pessoais</title>
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
            require_once "../basedados/basedados.h";

            if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true)) {
                echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
                header("refresh:1; url=pgHomepage.php");
            }else {
                $id = $_SESSION['id'];
                $sql = "SELECT * FROM `utilizador` WHERE `id` = '$id'";
                $res = mysqli_query($conn , $sql);

                $infos = array();
                while ($row = mysqli_fetch_assoc($res))
                    $infos[] = $row;
            
                foreach ($infos as $row) {
                    $nomeUtilizador = $row['nomeUtilizador'];
                    $password = $row['password'];
                    $email = $row['email'];
                }
            
                $sql = "SELECT * FROM `inscricao` WHERE `idAluno` = '".$_SESSION['id']."'";
                $resultado = mysqli_query($conn , $sql);

                echo 
                '<br>
                <div style="border: 2px solid #000; padding: 10px; width: 250;">
                <b>Nome de utilizador:</b> ' . $row['nomeUtilizador'] . '<br>
                <b>Password:</b> ' . $row['password'] . '<br>
                <b>Email:</b> ' . $row['email'] . ' <br>
                <b>Número de inscrições:</b> ' .mysqli_num_rows($resultado). '
                </div>';            
            ?>
                <br>
                <form action="pgEditaDadosPessoais.php" method="POST">
                    <input type="hidden" name="nomeUtilizador" value="<?php echo $nomeUtilizador ?>">
                    <input type="hidden" name="password" value="<?php echo $password ?>">
                    <input type="hidden" name="email" value="<?php echo $email ?>">
                    <button type="submit" name="submit">Editar</button>
                    <button><a href='pgGestao.php' style="text-decoration: none;">Voltar</a></button>
                </form>
            <?php } ?>

            
        </div>
    </body>
</html>