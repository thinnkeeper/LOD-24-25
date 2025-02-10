<html>
    <head>
        <meta charset="utf-8">
        <title>Gestão de Formações</title>
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

                if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) || $_SESSION['tipoUtilizador'] >= 3) {
                    echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
                    header("refresh:1; url=pgHomepage.php");
                } else {

                    ///Vai buscar os nomes dos docentes
                    $sql5 = "SELECT `id`, `nomeUtilizador`, `tipoUtilizador` FROM `utilizador`";
                    $res5 = mysqli_query($conn, $sql5);
                    $docentes = array();
                    while ($docente = mysqli_fetch_assoc($res5)) {
                        $docentes[] = $docente;
                    }

                    ?>
                        <br><h1>Criar Nova Formação:</h1>
                        <form method="POST" action="criaNovaFormacao.php" id="nff">
                            <br><b><label>Nome:</label><b>
                            <input type="text" name="nome">
                            <b><label>Descrição:</label><b>
                            <textarea name="descricao" form="nff" cols="40" rows="5"></textarea><br><br>
                            <b><label>Docente:<b>
                            <select name="docenteID">
                                <?php
                                    foreach ($docentes as $docente) {
                                        if ($docente['tipoUtilizador'] == 2) {
                                            $id = $docente['id'];
                                            $nome = $docente['nomeUtilizador'];
                                            echo '<option value="'.$id.'">'.$id.' - '.$nome.'</option>';
                                        }
                                    }
                                ?>
                            </select><br><br>
                            <b><label>Data:<b>
                            <input type="date" name="data"><br>
                            <br><b><label>Hora de Inicio:</label><b>
                            <input type="text" name="horaInicio">
                            <b><label>Duração:</label><b>
                            <input type="text" name="duracao">
                            <b><label>Lotação:</label><b>
                            <input type="text" name="lotacao"><br>
                            <input type="submit" value="Criar Formação">
                            <button><a href='criaNovaFormacao.php'>Voltar</a></button>
                        </form>
                    <?php
                }
            ?>
        </div>
    </body>
</html>