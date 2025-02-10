<?php

    session_start();

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) || $_SESSION['tipoUtilizador'] >= 3) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
        exit;
    } else {

        require_once "../basedados/basedados.h";

        $codigoFormacao = $_POST["codigoFormacao"];
        $lotacao = $_POST["lotacao"];
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];
        $data = $_POST["data"];
        $horaInicio = $_POST["horaInicio"];
        $duracao = $_POST["duracao"];
        $docenteID = $_POST["docenteID"];
        
        $sql = "UPDATE `formacao` SET `lotacao`='$lotacao', `nome`='$nome', `descricao`='$descricao', `data`='$data', `horaInicio`='$horaInicio', `duracao`='$duracao', `docenteID`='$docenteID' WHERE `codigoFormacao`='$codigoFormacao'";
        $res = mysqli_query($conn, $sql);

        if (mysqli_affected_rows($conn) == 1) {
            echo '<font color="green">EDIT com sucesso!!!</font>';
        } else {
            echo '<font color="red">EDIT falhou!!!</font>';
        }

        header("refresh:1; url=pgGestaoFormacoes.php");
        exit;

    }

?>