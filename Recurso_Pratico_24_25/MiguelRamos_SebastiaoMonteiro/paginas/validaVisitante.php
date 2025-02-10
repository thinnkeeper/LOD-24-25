<?php

    session_start();

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true)) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
    } else {

        require_once "../basedados/basedados.h";

        $nomeUtilizador = $_GET["nomeUtilizador"];

        $sql = "UPDATE `utilizador` SET `tipoUtilizador` = '3' WHERE `utilizador`.`nomeUtilizador` = '$nomeUtilizador'";
        $res = mysqli_query ($conn, $sql);

        echo "ALUNO VALIDADO!";
        header("refresh:1; url=pgGestaoUtilizadores.php");
    }
?>