<?php

session_start();

if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) || $_SESSION['tipoUtilizador'] >= 3) {
    echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
	header("refresh:1; url=pgHomepage.php");
    exit;
} else {

    require_once "../basedados/basedados.h";

    $id = $_GET['id'];
    $nomeUtilizador = $_POST["nomeUtilizador"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    
    $sql = "UPDATE `utilizador` SET `nomeUtilizador`='$nomeUtilizador', `password`='$password', `email`='$email' WHERE `id`='$id'";
    
    $res = mysqli_query($conn , $sql);

    if (mysqli_affected_rows ($conn) == 1){
        echo ('<font color="green">EDIT com sucesso!!!</font>');
        header("refresh:1; url=pgGestaoUtilizadores.php");
    } else {
        echo ('<font color="red">EDIT falhou!!!</font>');
        header("refresh:1; url=pgGestaoUtilizadores.php");
        exit;
    }
}

?>