<?php
    require_once "../basedados/basedados.h";
    session_start();

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) || $_SESSION['tipoUtilizador'] >= 3) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
        exit;
    }

    if (isset($_GET["nomeUtilizador"]) && isset($_GET["tipoUtilizador"])) {
        $nomeUtilizador = $_GET["nomeUtilizador"];
        $tipoUtilizador = $_GET["tipoUtilizador"];

        if ($tipoUtilizador != 6) {
            $sql = "UPDATE utilizador SET tipoUtilizador = '6' WHERE nomeUtilizador = '$nomeUtilizador'";
            $res = mysqli_query($conn, $sql);
        } else {
            $sql = "DELETE FROM utilizador WHERE nomeUtilizador = '$nomeUtilizador'";
            $res = mysqli_query($conn, $sql);
        }

        if ($res) {
            if (mysqli_affected_rows($conn) == 1) {
                echo '<font color="green">Tipo de utilizador atualizado com sucesso!!!</font>';
            } else {
                echo '<font color="red">Nenhuma alteração foi feita.</font>';
            }
        } else {
            echo '<font color="red">Atualização do tipo de utilizador falhou!!!</font>';
        }
    } else {
        echo '<font color="red">Parâmetros inválidos fornecidos.</font>';
    }

    header("refresh:1; url=pgGestaoUtilizadores.php");
?>
