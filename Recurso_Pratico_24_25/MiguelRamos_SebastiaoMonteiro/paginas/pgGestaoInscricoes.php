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

                $dom = new DOMDocument('1.0','UTF-8');
                $dom -> formatOutput = true;
                $inscricoes = $dom -> createElement('inscricoes');
                $dom -> appendChild($inscricoes);

                while($row = mysqli_fetch_array($resultado)){

                    $inscricao = $dom -> createElement('inscricao');

                    $idInscricao = $dom -> createElement('idInscricao', $row['idInscricao']);
                    $inscricao -> appendChild($idInscricao);

                    foreach ($alunos as $aluno) {
                        if ($aluno['id'] == $row['idAluno']) {
                            $aluno = $dom -> createElement('aluno', $aluno['nomeUtilizador']);
                            $aluno -> setAttribute('id', $row['idAluno']);
                            $inscricao -> appendChild($aluno);
                        }
                    }
                    foreach ($formacoes as $formac) {
                        if ($formac['codigoFormacao'] == $row['codigoFormacao']) {
                            $formacao = $dom -> createElement('formacao', $formac['nome']);
                            $formacao -> setAttribute('id', $row['codigoFormacao']);
                            $inscricao -> appendChild($formacao);
                        }
                    }
                    $data = $dom -> createElement('data', $row['dataInscricao']);
                    $inscricao -> appendChild($data);

                    if ($row['estado'] == 0) {
                        $estado = $dom -> createElement('estado', 'Pre-inscrito');
                        $inscricao -> appendChild($estado);
                    } elseif ($row['estado'] == 1) {
                        $estado = $dom -> createElement('estado', 'Inscrito');
                        $inscricao -> appendChild($estado);
                    } else {
                        $estado = $dom -> createElement('estado', 'Apagado');
                        $inscricao -> appendChild($estado);
                    }
                    
                    $eliminar = $dom -> createElement('eliminar', 'ELIMINAR');
                    $eliminar -> setAttribute('link', 'eliminaInscricao.php?idInscricao=' . urlencode($row['idInscricao']) . '&estado=' . urlencode($row['estado']));
                    $inscricao -> appendChild($eliminar);

                    if ($_SESSION['tipoUtilizador'] != 3) {
                        $editar = $dom -> createElement('editar', 'EDITAR');
                        $editar -> setAttribute('link', 'pgEditarInscricao.php?idInscricao=' . urlencode($row['idInscricao']));
                        $inscricao -> appendChild($editar);
                    }

                    if($row['estado'] == "0" && ($_SESSION['tipoUtilizador'] <= 2)){
                        $confirmar = $dom -> createElement('confirmar', 'CONFIRMAR');
                        $confirmar -> setAttribute('link', 'confirmaInscricao.php?idInscricao=' . urlencode($row['idInscricao']));
                        $inscricao -> appendChild($confirmar);
                    }
                    $inscricoes -> appendChild($inscricao);
                }
                // GuardaFecha o elemento principal
                $dom -> save('pgGestaoInscricoes.xml');
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