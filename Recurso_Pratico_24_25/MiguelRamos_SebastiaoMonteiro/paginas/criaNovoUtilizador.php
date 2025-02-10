<?php

    require_once "../basedados/basedados.h";
    session_start();

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) || $_SESSION['tipoUtilizador'] >= 3) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
    } else {

        $nomeUtilizador = $_POST["nomeUtilizador"];
        $password = $_POST["password"];
        $tipoUtilizador = $_POST["tipoUtilizador"];
        $email = $_POST["email"];

        if ($nomeUtilizador && $password != null && $email != null) {
            $sql = "INSERT INTO utilizador (nomeUtilizador, password, tipoUtilizador, email) VALUES ('$nomeUtilizador', '$password', '$tipoUtilizador', '$email')";

            $res = mysqli_query($conn , $sql);
            if (mysqli_affected_rows ($conn) == 1) {
                echo ('<font color="green">Criação com sucesso, aguarde validação!</font>');
                header("refresh:1; url=pgGestaoUtilizadores.php");
            }
        }
        else {
            echo ('<font color="red">CRIAÇÃO FALHOU!</font>');
            header("refresh:1; url=pgGestaoUtilizadores.php");
        }
    }
?>