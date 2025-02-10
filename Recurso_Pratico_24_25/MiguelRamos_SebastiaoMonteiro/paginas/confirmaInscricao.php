<?php

    require_once "../basedados/basedados.h";
    session_start();

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true)) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
    } else {

        $idInscricao = $_GET["idInscricao"];

        $sql = "UPDATE `inscricao` SET `estado` = '1' WHERE `inscricao`.`idInscricao` = '$idInscricao'";
        $res = mysqli_query ($conn, $sql);

        echo "Inscricao TERMINADA!";
        header("refresh:1; url=pgGestaoInscricoes.php");
    }
?>