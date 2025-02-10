<html>
    <head>
        <meta charset="utf-8" />
        <title>Editar Formação</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <?php
        session_start();

        if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) || $_SESSION['tipoUtilizador'] >= 3) {
            echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
            header("refresh:1; url=pgHomepage.php");
        } else {
            require_once "../basedados/basedados.h";
            $codigoFormacao = $_GET["codigoFormacao"];
            $sql = "SELECT * FROM `formacao` WHERE `codigoFormacao` = '$codigoFormacao'";
            $res = mysqli_query($conn, $sql);

            $infos = array();
            while ($row = mysqli_fetch_assoc($res)) {
                $infos[] = $row;
            }

            foreach ($infos as $row) {
                $row['codigoFormacao'];
                $row['lotacao'];
                $row['nome'];
                $row['descricao'];
                $row['data'];
                $row['horaInicio'];
                $row['duracao'];
                $row['docenteID'];
            }

            ///Vai buscar os nomes dos docentes            
            $sql5 = "SELECT `id`, `nomeUtilizador`, `tipoUtilizador` FROM `utilizador`";
            $res5 = mysqli_query($conn, $sql5);
            $docentes = array();
            while ($docente = mysqli_fetch_assoc($res5)) {
                $docentes[] = $docente;
            }

        ?>
    
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
                <form method="POST" action="editaFormacao.php?codigoFormacao=<?php echo $row['codigoFormacao']; ?>" id="ef">
                    <!-- Mostra o Id da formacao, mas nao deixa editar, porque e chave primaria -->
                    <b><label>ID Formação: <?php echo $row['codigoFormacao']?> <?php echo "<input type='hidden' name='codigoFormacao' size='20' value='" . $row['codigoFormacao'] . "'>" ?><br><br>
                    <b><label>Nome: <?php echo "<input type='text' name='nome' size='20' value='" . $row['nome'] . "'>" ?> <br>
                    <b><label>Descrição: 
                    <textarea name="descricao" form="ef" cols="40" rows="5"><?php echo $row['descricao']; ?></textarea><br><br>
                    <b><label>Docente: <?php echo $row['docenteID'] ?>
                    <select name="docenteID" value=<?php echo $row['docenteID'] ?>>
                        <?php
                            foreach ($docentes as $docente) {
                                if ($docente['tipoUtilizador'] == 2) {
                                    $dID = $docente['id'];
                                    $nome = $docente['nomeUtilizador'];
                                    echo '<option value="'.$dID.'">'.$dID.' - '.$nome.'</option>';
                                }
                                
                            }
                        ?>
                    </select><br><br>
                    <b><label>Data: <?php echo "<input type='date' name='data' size='20' value='" . $row['data'] . "'>" ?><br><br>
                    <b><label>Hora de Inicio: <?php echo "<input type='text' name='horaInicio' size='20' value='" . $row['horaInicio'] . "'>" ?> <br>
                    <b><label>Duração (em horas): <?php echo "<input type='text' name='duracao' size='20' value='" . $row['duracao'] . "'>" ?> <br>
                    <b><label>Lotação: <?php echo "<input type='text' name='lotacao' size='20' value='" . $row['lotacao'] . "'>" ?> <br>
                    <input type="submit" name="submit" value="Editar">
                    <button><a href='pgGestaoFormacoes.php' style="text-decoration: none;">Voltar</a></button>
                </form>
                <br>
            </div>
        <?php
        }
        ?>
    </body>
</html>
