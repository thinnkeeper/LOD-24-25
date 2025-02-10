<?php

    session_start();

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true)) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=paginaPrincipal.php");
        exit;
    }

    else {

        require_once "../basedados/basedados.h";
        
        $id = $_SESSION['id'];
        $nomeUtilizador = $_POST["nomeUtilizador"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        
        $sql = "UPDATE `utilizador` SET `nomeUtilizador`='$nomeUtilizador', `password`='$password', `email`='$email' WHERE `id`='$id'";
        $res = mysqli_query($conn , $sql);

        if (mysqli_affected_rows($conn) == 1){
            echo ('<font color="green">EDIT com sucesso!!!</font>');
            $_SESSION['nomeUtilizador'] = $nomeUtilizador;
        } else {
            echo ('<font color="red">EDIT falhou!!!</font>');
        }

        if($current_page = $_SERVER['PHP_SELF'] == "pgGestaoUtilizadores.php")
            header("refresh:1; url=pgGestaoUtilizadores.php");
        else
            header("refresh:1; url=pgDadosPessoais.php");
        exit;

    }

?>