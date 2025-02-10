<?php

    session_start();

    require_once "../basedados/basedados.h";

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true)) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
    }

    else {

        if(isset($_POST["formacao"]))
            $formacao = $_POST["formacao"];

        $dataInscricao = date('Y-m-d');
        $estado = 0;
        $insert = "INSERT INTO inscricao(idAluno, codigoFormacao, dataInscricao, estado) VALUES ('".$_SESSION['id']."', '$formacao', '$dataInscricao', '$estado')";
        $resInscricao = mysqli_query($conn , $insert);



        if (mysqli_affected_rows ($conn) == 1)
            echo ('<font color="green">Inscrição com sucesso!!!</font>');
        
        header("refresh:1; url=pgGestaoInscricoes.php");
    }

?>