<?php
    require_once "../basedados/basedados.h";
    session_start();

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true)) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
    } else {
        $idInscricao = $_GET["idInscricao"];
        $estado = $_GET["estado"];

        if ($estado != 2) {
            $sql = "UPDATE inscricao SET estado = '2' WHERE idInscricao = '$idInscricao'";
            $res = mysqli_query($conn, $sql);
        } else {
            $sql = "DELETE FROM inscricao WHERE idInscricao = '$idInscricao'";
            $res = mysqli_query($conn, $sql);
        }

        if (mysqli_affected_rows($conn) == 1) {
            echo '<font color="green">Estado atualizado com sucesso!!!</font>';
        } else {
            echo '<font color="red">Atualização do estado falhou!!!</font>';
        }

        header("refresh:1; url=pgGestaoInscricoes.php");
    }
?>
