    <html>
        <head>
            <meta charset="utf-8">
            <title>Gestão de Inscrições</title>
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
                } else {

                    ///Vai buscar os nomes dos alunos
                    $sql5 = "SELECT `id`, `nomeUtilizador`, `tipoUtilizador` FROM `utilizador`";
                    $res5 = mysqli_query($conn, $sql5);
                    $alunos = array();
                    while ($aluno = mysqli_fetch_assoc($res5)) {
                        $alunos[] = $aluno;
                    }
                    ///Vai buscar TODOS os nomes da formacoes
                    $sql4 = "SELECT `codigoFormacao`, `nome` FROM `formacao`";
                    $res4 = mysqli_query($conn, $sql4);
                    $formacoes = array();
                    while ($formac = mysqli_fetch_assoc($res4)) {
                        $formacoes[] = $formac;
                    }
                    /// Vai buscar os Estados das inscricoes
                    $sql3 = "SELECT * FROM `estadoInscricao`";
                    $res3 = mysqli_query($conn, $sql3);
                    $estados = array();
                    while ($insc = mysqli_fetch_assoc($res3)) {
                        $estados[] = $insc;
                    }

                ?>            
                <br><br>        
                <?php

                    if($_SESSION['tipoUtilizador'] == "3") {
                        $sql = "SELECT * FROM `inscricao` WHERE `idAluno` = '".$_SESSION['id']."' AND `estado` < 2";
                    } else {
                        $sql = "SELECT * FROM `inscricao`";
                    }

                    $resultado = mysqli_query($conn , $sql);
                    if (mysqli_num_rows($resultado) == 0) {
                        echo "<b>Não existem inscrições feitas.<b>";
                    ?>
                        <br>
                        <button><a href='pgCriaNovaInscricao.php' style="text-decoration: none;">Nova inscrição</a></button>
                        <button><a href='pgGestao.php' style="text-decoration: none;">Voltar</a></button>
                    <?php
                        exit;
                    }
                        echo "<table border='1' style='text-align:center;'><tr><th>ID da Inscrição</th><th>ID Aluno</th><th>Formação</th><th>Data de Inscrição</th><th>Estado</th></tr>";

                        while($row = mysqli_fetch_array($resultado)){
                            echo "<tr>";
                            echo "<td>".$row['idInscricao']."</td>";
                            foreach ($alunos as $aluno) {
                                if ($aluno['id'] == $row['idAluno']) {
                                    $idAl = $row['idAluno'];
                                    $nomeAl = $aluno['nomeUtilizador'];
                                    echo "<td>[".$idAl."] - ".$nomeAl."</td>";
                                }
                            }
                            foreach ($formacoes as $formac) {
                                if ($formac['codigoFormacao'] == $row['codigoFormacao']) {
                                    $cofForm = $row['codigoFormacao'];
                                    $nomeForm = $formac['nome'];
                                    echo "<td>[".$cofForm."] - ".$nomeForm."</td>";
                                }
                            }
                            echo "<td>".$row['dataInscricao']."</td>";
                            if ($row['estado'] == 0) {
                                echo "<td> Pre-inscrito </td>";
                            } elseif ($row['estado'] == 1) {
                                echo "<td> Inscrito </td>";
                            } else {
                                echo "<td> Apagado </td>";
                            }

                            echo "<td><a href='eliminaInscricao.php?idInscricao=" . $row['idInscricao'] . "&estado=" . $row['estado'] . "'> <font color='red'> ELIMINAR </font> </a></td>";
                            if ($_SESSION['tipoUtilizador'] != 3) {
                                echo "<td><a href = 'pgEditarInscricao.php?idInscricao=" .$row['idInscricao']. "'> <font color='green'> EDITAR </font> </a></td>";
                            }

                            if($row['estado'] == "0" && ($_SESSION['tipoUtilizador'] <= 2)){
                                echo "<td><a href = 'confirmaInscricao.php?idInscricao=" .$row['idInscricao']. "'> <font color='purple'> CONFIRMAR </font> </a></td>";
                            }

                            echo "</tr>";
                        }
                        echo "</table><br/>";
                }

                if($_SESSION['tipoUtilizador'] == "3") {
                ?>
                <button><a href='pgInscricao.php' style="text-decoration: none;">Marcar inscrição</a></button>
                <?php
                }

                else {
                    ?>
                    <button><a href='pgCriaNovaInscricao.php' style="text-decoration: none;">Nova inscrição</a></button>
                    <?php
                    }

                ?>
                <button><a href='pgGestao.php' style="text-decoration: none;">Voltar</a></button>
            </div>        
        </body>

            

    </html>