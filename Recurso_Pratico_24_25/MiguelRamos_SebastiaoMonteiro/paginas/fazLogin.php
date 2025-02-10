<?php

require_once "../basedados/basedados.h";

session_start();

if (isset($_POST["nomeUtilizador"]) && isset($_POST["password"])) {
    $nomeUtilizador = $_POST["nomeUtilizador"];
    $password = $_POST["password"];
}

$sql = "SELECT * FROM `utilizador` WHERE `nomeUtilizador` = '$nomeUtilizador'";
$resultado = mysqli_query($conn , $sql);

$infos = array();
while ($row = mysqli_fetch_assoc($resultado))
    $infos[] = $row;

foreach ($infos as $row) {
    $row['id'];
    $row['nomeUtilizador'];
    $row['password'];
    $row['tipoUtilizador'];
}

if ($nomeUtilizador == $row['nomeUtilizador'] and $password == $row['password']) {

    if($row['tipoUtilizador'] == 5) {

        echo "<font color ='red'>Utilizador não validado, por favor aguarde até o admnistrador fazer a validação. </font>";

        header("refresh:1; url=pgHomepage.php");
        
        exit;

    }

    
    if($row['tipoUtilizador'] == 6) {

        echo "<font color ='red'>Utilizador não existe. </font>";

        header("refresh:1; url=pgHomepage.php");
        
        exit;

    }

    else {
        $_SESSION['id'] = $row['id'];
        $_SESSION['nomeUtilizador'] = $nomeUtilizador;
        $_SESSION['tipoUtilizador'] = $row['tipoUtilizador'];
        $_SESSION['autenticado'] = true;
    
        echo "<font color ='green'> Login bem sucedido! A carregar a página... </font>";
        header("refresh:1; url=pgGestao.php");
    }
}
else {
    echo "<font color ='red'> Falha na autenticação! </font>";
    echo "<br><a href='pgLogin.php'>Voltar</a>";
}

?>