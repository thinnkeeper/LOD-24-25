<html>
    <head>
        <meta charset="utf-8">
        <title>Gestão de Formacões</title>
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

                if($_SESSION['tipoUtilizador'] == "2") {
                    $dID = $_SESSION['id'];
                    $sql = "SELECT * FROM `formacao` WHERE `docenteID` = $dID";
                } else {
                    $sql = "SELECT * FROM `formacao`";
                }

                ///Vai buscar os nomes dos docentes
                $sql5 = "SELECT `id`, `nomeUtilizador`, `tipoUtilizador` FROM `utilizador`";
                $res5 = mysqli_query($conn, $sql5);
                $docentes = array();
                while ($docente = mysqli_fetch_assoc($res5)) {
                    $docentes[] = $docente;
                }

                $res = mysqli_query($conn , $sql);
                
                $dom = new DOMDocument('1.0','UTF-8');
                $dom -> formatOutput = true;
                
                $formacoes = $dom -> createElement('formacoes');
                $dom -> appendChild($formacoes);

                while($row = mysqli_fetch_array($res)) {
                    $formacao = $dom -> createElement('formacao');

                    $codigo = $dom -> createElement('codigo', $row['codigoFormacao']);
                    $formacao -> appendChild($codigo);

                    $nome = $dom -> createElement('nome', $row['nome']);
                    $formacao -> appendChild($nome);

                    $descricao = $dom -> createElement('descricao', $row['descricao']);
                    $formacao -> appendChild($descricao);

                    $data = $dom -> createElement('data', $row['data']);
                    $formacao -> appendChild($data);

                    foreach ($docentes as $docente) {
                        if ($docente['id'] == $row['docenteID']) {
                            $docenteElemento = $dom -> createElement('docente', $docente['nomeUtilizador']);
                            $docenteElemento -> setAttribute('id', $row['docenteID']);
                            $formacao -> appendChild($docenteElemento);
                        }
                    }

                    $horaInicio = $dom -> createElement('horaInicio', $row['horaInicio']);
                    $formacao -> appendChild($horaInicio);

                    $duracao = $dom -> createElement('duracao', $row['duracao'] . 'h');
                    $formacao -> appendChild($duracao);

                    $lotacao = $dom -> createElement('lotacao', $row['lotacao']);
                    $formacao -> appendChild($lotacao);
                    
                    // Adicionar ações de eliminar e editar
                    $eliminar = $dom -> createElement('eliminar', 'ELIMINAR');
                    $eliminar -> setAttribute('link', 'eliminaFormacao.php?codigoFormacao=' . urlencode($row['codigoFormacao']));
                    $formacao -> appendChild($eliminar);

                    $editar = $dom -> createElement('editar', 'EDITAR');
                    $editar -> setAttribute('link', 'pgEditarFormacao.php?codigoFormacao=' . urlencode($row['codigoFormacao']));
                    $formacao -> appendChild($editar);

                    $formacoes -> appendChild($formacao);
                }
                
                $dom -> save('pgGestaoFormacoes.xml');
                
                // Carregar os ficheiros e associar o xsl com o xml
                $xml = new DOMDocument;
                $xml->load('pgGestaoFormacoes.xml');
                $xsl = new DOMDocument;
                $xsl->load('pgGestaoFormacoes.xsl');
                
                $proc = new XSLTProcessor;
                $proc->importStyleSheet($xsl);
                
                echo $proc->transformToXML($xml);
            }
            ?>
            <button><a href='pgCriaNovaFormacao.php' style="text-decoration: none;">Criar Formação</a></button>
            <button><a href='pgGestao.php' style="text-decoration: none;">Voltar</a></button>
        </div>        
    </body>
</html>