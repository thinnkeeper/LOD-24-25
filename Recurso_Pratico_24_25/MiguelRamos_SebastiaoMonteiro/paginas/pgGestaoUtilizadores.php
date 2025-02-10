<?php
// Inicia a sessão e inclui a ligação à base de dados
session_start();
require_once "../basedados/basedados.h";

// Verifica se o utilizador está autenticado e se tem privilégios (tipoUtilizador == "1")
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true || $_SESSION['tipoUtilizador'] != "1") {
    // Define o cabeçalho como XML
    header("Content-Type: text/xml; charset=UTF-8");
    // Inicia o documento XML
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<resposta>';
    echo '<erro>Não estás autenticado! (Sem privilégios para aceder a esta página.)</erro>';
    echo '</resposta>';
    exit();
}

// Define o cabeçalho para XML
header("Content-Type: text/xml; charset=UTF-8");

// Inicia o documento XML
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<utilizadores>';

// Consulta à base de dados
$sql = "SELECT u.id, u.nomeUtilizador, t.descricao AS tipoUtilizador, u.email
        FROM `utilizador` u
        INNER JOIN `tipoUtilizador` t ON u.tipoUtilizador = t.id";
$resultado = mysqli_query($conn, $sql);

// Verifica se a consulta foi efetuada com sucesso
if (!$resultado) {
    echo '<erro>Erro na consulta: ' . htmlspecialchars(mysqli_error($conn)) . '</erro>';
    echo '</utilizadores>';
    exit();
}

// Percorre os resultados e gera os elementos XML para cada utilizador
while ($row = mysqli_fetch_array($resultado)) {
    echo '<utilizador>';
        echo '<id>' . htmlspecialchars($row['id']) . '</id>';
        echo '<nomeUtilizador>' . htmlspecialchars($row['nomeUtilizador']) . '</nomeUtilizador>';
        echo '<tipoUtilizador>' . htmlspecialchars($row['tipoUtilizador']) . '</tipoUtilizador>';
        echo '<email>' . htmlspecialchars($row['email']) . '</email>';
        
        // Se o tipo de utilizador for "visitante nao validado", adiciona a ação de validação
        if ($row['tipoUtilizador'] == "visitante nao validado") {
            echo '<acao tipo="validar">' . htmlspecialchars("validaVisitante.php?nomeUtilizador=" . urlencode($row['nomeUtilizador'])) . '</acao>';
        }
        
        // Adiciona a ação para eliminar o utilizador
        echo '<acao tipo="eliminar">' . htmlspecialchars("eliminaUtilizador.php?nomeUtilizador=" . urlencode($row['nomeUtilizador']) . "&amp;tipoUtilizador=" . urlencode($row['tipoUtilizador'])) . '</acao>';
        
        // Adiciona a ação para editar o utilizador
        echo '<acao tipo="editar">' . htmlspecialchars("pgEditaUtilizador.php?id=" . urlencode($row['id'])) . '</acao>';
    echo '</utilizador>';
}

// Fecha o elemento principal
echo '</utilizadores>';
?>
<!--old-->
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

                echo "<table border='1' style='text-align:center;'><tr><th>Utilizador</th><th>Permissões</th><th>Email</th></tr>";

                while($row = mysqli_fetch_array($resultado)){
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['nomeUtilizador']."</td>";
                    echo "<td>".$row['tipoUtilizador']."</td>";
                    echo "<td>".$row['email']."</td>";
                    if($row['tipoUtilizador'] == "visitante nao validado")
                        echo "<td><a href = 'validaVisitante.php?nomeUtilizador=" .$row['nomeUtilizador']. "'> <font color='purple'> VALIDAR </font> </a></td>";
                    else
                        echo "<td></td>";
                        echo "<td><a href='eliminaUtilizador.php?nomeUtilizador=" . $row['nomeUtilizador'] . "&tipoUtilizador=" . $row['tipoUtilizador'] . "'> <font color='red'> ELIMINAR </font> </a></td>";
                        echo "<td></td>";
                    echo "<td><a href = 'pgEditaUtilizador.php?id=" .$row['id']. "'> <font color='green'> EDITAR </font> </a></td>";
                    echo "</tr>";
                }
                echo "</table><br>";
                }

            ?>
            <div>
            <button><a href='pgNovoUtilizador.php' style="text-decoration: none;">Novo Utilizador</a></button>
            <button><a href='pgGestao.php' style="text-decoration: none;">Voltar</a></button>
            </div>

            
        </div>
    </body>
</html>