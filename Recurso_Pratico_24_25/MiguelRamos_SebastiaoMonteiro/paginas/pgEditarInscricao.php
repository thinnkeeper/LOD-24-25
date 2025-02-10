<html>
    <head>
        <meta charset="utf-8" />
        <title>Editar Inscrição</title>
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
            $idInscricao = $_GET["idInscricao"];
            $sql = "SELECT * FROM `inscricao` WHERE `idInscricao` = '$idInscricao'";
            $res = mysqli_query($conn, $sql);

            $infos = array();
            while ($row = mysqli_fetch_assoc($res)) {
                $infos[] = $row;
            }

            foreach ($infos as $row) {
                $row['idInscricao'];
                $row['idAluno'];
                $row['codigoFormacao'];
                $row['dataInscricao'];
                $row['estado'];
            }

            /// Vai buscar o nome do aluno.
            $idAluno = $row['idAluno'];
            $sql1 = "SELECT `nomeUtilizador` FROM `utilizador` WHERE `id` = '$idAluno'";
            $res1 = mysqli_query($conn, $sql1);
            $nome = mysqli_fetch_assoc($res1);
            
            /// Vai buscar o nome da formacao.
            $codigoFormacao = $row['codigoFormacao'];
            $sql2 = "SELECT `nome` FROM `formacao` WHERE `codigoFormacao` = '$codigoFormacao'";
            $res2 = mysqli_query($conn, $sql2);
            $nomeFormacao = mysqli_fetch_assoc($res2);

            /// Vai buscar os Estados das inscricoes
            $sql3 = "SELECT * FROM `estadoInscricao`";
            $res3 = mysqli_query($conn, $sql3);
            $estados = array();
            while ($insc = mysqli_fetch_assoc($res3)) {
                $estados[] = $insc;
            }

            ///Vai buscar TODOS os nomes da formacoes
            $sql4 = "SELECT `codigoFormacao`, `nome` FROM `formacao`";
            $res4 = mysqli_query($conn, $sql4);
            $formacoes = array();
            while ($formac = mysqli_fetch_assoc($res4)) {
                $formacoes[] = $formac;
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
                <form method="POST" action="editaInscricao.php?idInscricao=<?php echo $row['idInscricao']; ?>">
                    <!-- Mostra o Id da inscricao, mas nao deixa editar, porque e chave primaria -->
                    <b><label>ID da Inscrição: <?php echo $row['idInscricao']?> <?php echo "<input type='hidden' name='idInscricao' size='20' value='" . $row['idInscricao'] . "'>" ?><br><br>
                    <!-- Mostra o idAluno e o Nome do utilizador, nao deixa editar, e envia idAluno -->
                    <b><label>Nome do Utilizador: <?php echo "[".$row['idAluno']."] ". $nome['nomeUtilizador'] ?><?php echo "<input type='hidden' name='idAluno' size='20' value='" . $row['idAluno'] . "'>" ?> <br><br>
                    <b><label>Data de Inscrição: <?php echo $row['dataInscricao']?><?php echo "<input type='hidden' size='20' name='dataInscricao' value='" . $row['dataInscricao'] . "'>" ?> <br><br>
                    <!--<b><label>Código da Formação: <?php echo "[".$row['codigoFormacao']."] ". $nomeFormacao['nome'] ?><br><?php echo "<input type='text' size='20' name='codigoFormacao' value='" . $row['codigoFormacao'] . "'>" ?><br> -->
                    <b><label>Formação: <?php echo $row['codigoFormacao'] ?>
                    <select name="codigoFormacao" value=<?php echo $row['codigoFormacao'] ?>>
                        <?php
                            foreach ($formacoes as $formac) {
                                $codigo = $formac['codigoFormacao'];
                                $nome = $formac['nome'];
                                echo '<option value="'.$codigo.'">'.$codigo.' - '.$nome.'</option>';
                            }
                        ?>
                    </select><br><br>
                    <b><label>Estado: <?php echo $row['estado'] ?>
                    <select name="estado" value=<?php echo $row['estado'] ?>>
                        <option></option>
                        <?php
                            foreach ($estados as $insc) {
                                $estado = $insc['estado'];
                                $descricao = $insc['descricao'];
                                echo '<option value="'.$estado.'">'.$estado.' - '.$descricao.'</option>';
                            }
                        ?>
                    </select><br><br>
                    <input type="submit" name="submit" value="Editar">
                    <button><a href='pgGestaoInscricoes.php' style="text-decoration: none;">Voltar</a></button>
                </form>
                <br>
            </div>
        <?php
        }
        ?>
    </body>
</html>
