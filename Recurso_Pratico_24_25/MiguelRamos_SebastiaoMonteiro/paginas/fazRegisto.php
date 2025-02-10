<?php

    require_once "../basedados/basedados.h";
    session_start();

    

    $nomeUtilizador = $_POST["nomeUtilizador"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    if ($nomeUtilizador && $password != null && $email != null) {
        $sql = "INSERT INTO utilizador (nomeUtilizador, password, tipoUtilizador, email) VALUES ('$nomeUtilizador', '$password', '5', '$email')";

        $res = mysqli_query($conn , $sql);
        if (mysqli_affected_rows ($conn) == 1) {
            echo ('<font color="green">Registo com sucesso, aguarde validação!</font>');
            header("refresh:1; url=pgLogin.php");
        }
    }
    else {
        echo ('<font color="red">REGISTO FALHOU!</font>');
        header("refresh:1; url=pgHomepage.php");
    }
    
?>