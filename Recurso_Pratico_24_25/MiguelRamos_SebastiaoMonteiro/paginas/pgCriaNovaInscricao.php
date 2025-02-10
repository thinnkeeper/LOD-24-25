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

                if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) || $_SESSION['tipoUtilizador'] >= 3) {
                    echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
                    header("refresh:1; url=pgHomepage.php");
                } else {

                    ///Vai buscar os nomes dos alunos
                    $sql = "SELECT `id`, `nomeUtilizador`, `tipoUtilizador` FROM `utilizador`";
                    $res = mysqli_query($conn, $sql);
                    $alunos = array();
                    while ($aluno = mysqli_fetch_assoc($res)) {
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
                        <form method="POST" action="criaNovaInscricao.php">
                            <b><label>Aluno:
                            <select name="idAluno">
                                <?php
                                    foreach ($alunos as $aluno) {
                                        if ($aluno['tipoUtilizador'] == 3) {
                                            $id = $aluno['id'];
                                            $nome = $aluno['nomeUtilizador'];
                                            echo '<option value="'.$id.'">'.$id.' - '.$nome.'</option>';
                                        }
                                    }
                                ?>
                            </select><br><br>
                            <b><label>Formação:
                            <select name="codigoFormacao">
                                <?php
                                    foreach ($formacoes as $formac) {
                                        $codigo = $formac['codigoFormacao'];
                                        $nome = $formac['nome'];
                                        echo '<option value="'.$codigo.'">'.$codigo.' - '.$nome.'</option>';
                                    }
                                ?>
                            </select><br><br>
                            <b><label>Estado:
                            <select name="estado">
                                <?php
                                    foreach ($estados as $insc) {
                                        $estado = $insc['estado'];
                                        $descricao = $insc['descricao'];
                                        echo '<option value="'.$estado.'">'.$estado.' - '.$descricao.'</option>';
                                    }
                                ?>
                            </select><br><br>
                            <input type="submit" value="Introduzir">
                            <button><a href='pgGestaoInscricoes.php'>Voltar</a></button>
                        </form>

                    <?php
                }
            ?>
        </div>
    </body>
</html>