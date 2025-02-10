<?php
    require_once "../basedados/basedados.h";
    session_start();

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) || $_SESSION['tipoUtilizador'] >= 3) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
    } else {    

        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];
        $docenteID = $_POST["docenteID"];
        $data = $_POST["data"];
        $horaInicio = $_POST["horaInicio"];
        $duracao = $_POST["duracao"];
        $lotacao = $_POST["lotacao"];

        if ($nome && $descricao && $docenteID && $data && $horaInicio && $duracao && $lotacao) {
            $sql = "INSERT INTO formacao ( lotacao, nome, descricao, data, horaInicio, duracao, docenteID) 
                    VALUES ('$lotacao', '$nome', '$descricao', '$data', '$horaInicio', '$duracao', '$docenteID')";
            $res = mysqli_query($conn, $sql);

            if ($res && mysqli_affected_rows($conn) == 1) {
                echo '<font color="green">Criação com sucesso!</font>';
                header("refresh:1; url=pgGestaoFormacoes.php");
                exit;
            } else {
                echo '<font color="red">Criação falhou!</font>';
            }
        }
        header("refresh:3; url=pgGestaoInscricoes.php");   
    }
?>