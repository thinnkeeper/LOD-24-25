<html>
    <meta charset="utf-8" />
    <title>Editar Utilizador</title>
    <link rel="stylesheet" href="styles.css">

<?php

    require_once "../basedados/basedados.h";
    session_start();
    

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) || $_SESSION['tipoUtilizador'] >= 3) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
    }

    else {

        $id = $_GET["id"];

        $sql = "SELECT * FROM `utilizador` WHERE `id` = '$id'";
        $res = mysqli_query($conn , $sql);

        
        $infos = array();
        while ($row = mysqli_fetch_assoc($res)) 
            $infos[] = $row;

        foreach ($infos as $row) {
            $row['id'];
            $row['nomeUtilizador'];
            $row['password'];
            $row['email'];
        }

?>

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
            <br>
            <form method="POST" action="editarUtilizador.php?id=<?php echo $row['id']; ?>">
                <b><label>Utilizador: </label></b>
                <?php echo "<input type='text' name='nomeUtilizador' size='20' value='" . $row['nomeUtilizador'] . "'>" ?><br>
                <b><label>Password: </label></b>
                <?php echo "<input type='password' name='password' size='20' value='" . $row['password'] . "'>" ?> <br>
                <b><label>Email: </label></b>
                <?php echo "<input type='text' size='20' name='email' value='" . $row['email'] . "'>" ?> <br>  
                <input type="submit" name="submit" value="Editar">
                <button><a href='pgGestaoUtilizadores.php' style="text-decoration: none;">Voltar</a></button>                
            </form>
            <br>
        </div>


<?php

    }

?>

    </body>
</html>
