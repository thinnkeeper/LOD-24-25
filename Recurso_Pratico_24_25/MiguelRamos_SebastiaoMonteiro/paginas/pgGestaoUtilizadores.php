<html>
    <head>
        <meta charset="utf-8">
        <title>Gestão de Utilizadores</title>
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
                if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true || $_SESSION['tipoUtilizador'] != "1")) {
                    echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
                    header("refresh:1; url=pgHomepage.php");
                } else {
            ?>
            <br>
            <?php

                $sql = "SELECT u.id, u.nomeUtilizador, t.descricao AS tipoUtilizador, u.email
                FROM `utilizador` u
                INNER JOIN `tipoUtilizador` t ON u.tipoUtilizador = t.id";
                $resultado = mysqli_query($conn, $sql);

                $dom = new DOMDocument('1.0','UTF-8');
                $dom -> formatOutput = true;

                $utilizadores = $dom -> createElement('utilizadores');
                $dom -> appendChild($utilizadores);

                // Percorre os resultados e gera os elementos XML para cada utilizador
                while ($row = mysqli_fetch_array($resultado)) {
                    $utilizador = $dom -> createElement('utilizador');

                    $id = $dom -> createElement('id', $row['id']);
                    $utilizador -> appendChild($id);

                    $nomeUtilizador = $dom -> createElement('nomeUtilizador', $row['nomeUtilizador']);
                    $utilizador -> appendChild($nomeUtilizador);

                    $tipoUtilizador = $dom -> createElement('tipoUtilizador', $row['tipoUtilizador']);
                    $utilizador -> appendChild($tipoUtilizador);

                    $email = $dom -> createElement('email', $row['email']);
                    $utilizador -> appendChild($email);
                    
                    // Se o tipo de utilizador for "visitante nao validado", adiciona a ação de validação
                    if ($row['tipoUtilizador'] == "visitante nao validado") {
                        echo '<acao tipo="validar">' . htmlspecialchars("validaVisitante.php?nomeUtilizador=" . urlencode($row['nomeUtilizador'])) . '</acao>';
                    }
                    
                    // Adiciona a ação para eliminar o utilizador
                    echo '<acao tipo="eliminar">' . htmlspecialchars("eliminaUtilizador.php?nomeUtilizador=" . urlencode($row['nomeUtilizador']) . "&amp;tipoUtilizador=" . urlencode($row['tipoUtilizador'])) . '</acao>';
                    
                    // Adiciona a ação para editar o utilizador
                    echo '<acao tipo="editar">' . htmlspecialchars("pgEditaUtilizador.php?id=" . urlencode($row['id'])) . '</acao>';
                    
                    echo '</utilizador>';
                    $utilizadores -> appendChild($utilizador);
                }

                // Fecha o elemento principal
                $dom -> appendChild($utilizadores);
                echo '</utilizadores>';
                
                }
            ?>
            <div>
            <button><a href='pgNovoUtilizador.php' style="text-decoration: none;">Novo Utilizador</a></button>
            <button><a href='pgGestao.php' style="text-decoration: none;">Voltar</a></button>
            </div>

            
        </div>
    </body>
</html>