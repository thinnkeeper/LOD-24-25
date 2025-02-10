<?php

    require_once "../basedados/basedados.h";
    session_start();

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) || $_SESSION['tipoUtilizador'] >= 3) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
    } else {

        $codigoFormacao = $_GET["codigoFormacao"];

        ///vai apagar todas as inscricoes relativas a esta formacao
        $sql2 = "DELETE FROM inscricao WHERE codigoFormacao = '$codigoFormacao'";
        $res2 = mysqli_query($conn, $sql2);

        $sql = "DELETE FROM formacao WHERE codigoFormacao = '$codigoFormacao'";
        $res = mysqli_query($conn, $sql);

        if (mysqli_affected_rows($conn) == 1) {
            echo '<font color="green">Formação eliminada com sucesso!!!</font>';
        } else {
            echo '<font color="red">Eliminação falhou!!!</font>';
        }

        header("refresh:1; url=pgGestaoFormacoes.php");
    }
?>