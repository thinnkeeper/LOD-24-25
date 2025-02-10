<!DOCTYPE html>
<html>
    <head>
        <title>Confirmação</title>
        <link rel="stylesheet" href="estilo.css?v=1.0">
    </head>
    <body>
    </body>
</html>

<?php
include_once("../basedados/basedados.h");
session_start();

// Verifica se o utilizador está logado e se o perfil é de admin
if (isset($_SESSION['perfil']) && ($_SESSION['perfil'] == "admin")) {
    $id_utilizador = $_GET['id'];
    $email_utilizador = $_GET["e_mail"];
    $user_name = $_GET["user_name"];

    // Sanitização para evitar SQL Injection
    $id_utilizador = mysqli_real_escape_string($conn, $id_utilizador);

    // Verifica o número de admins autenticados, excluindo o que está a ser eliminado
    $sql = "SELECT COUNT(*) AS total_admins 
            FROM utilizadores 
            WHERE perfil = 'admin' AND autenticado = 1 AND id_utilizador != $id_utilizador";
    $resultado = mysqli_query($conn, $sql);

    if ($resultado) {
        $row = mysqli_fetch_assoc($resultado);

        if ($row['total_admins'] > 0) {
            // Existe pelo menos outro admin autenticado, pode continuar
            echo "<div class='container'>
                    <h4>Excluir o utilizador " . htmlspecialchars($user_name) . " da base de dados?</h4>
                    <div class='button-group'>
                        <a href='delete_utilizador.php?id=" . urlencode($id_utilizador) . "&e_mail=" . urlencode($email_utilizador) . "&user_name=" . urlencode($user_name) . "' style='background-color:red;'>SIM!</a><br>
                        <a href='menu_admin.php'>NÃO!</a>
                    </div>
                  </div>";
        } else {
            // Não há outro admin autenticado
            echo "<div class='container'>
                    <h4>Não é possível excluir este utilizador porque não existe outro administrador autenticado.</h4>
                    <a href='menu_admin.php'>Voltar</a>
                  </div>";
        }
    } else {
        echo "<div class='container'>
                <h4>Ocorreu um erro ao verificar administradores.</h4>
                <a href='menu_admin.php'>Voltar</a>
              </div>";
    }
} else {
    // Redireciona para o índice se não for admin
    header("refresh:0; url=index.php");
}
?>
