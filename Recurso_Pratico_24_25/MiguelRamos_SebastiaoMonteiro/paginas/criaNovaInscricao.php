<?php
    require_once "../basedados/basedados.h";
    session_start();

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) || $_SESSION['tipoUtilizador'] >= 3) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
    } else {    

        $idAluno = $_POST["idAluno"];
        $codigoFormacao = $_POST["codigoFormacao"];
        $estado = $_POST["estado"];
        $dataInscricao = date('Y-m-d');

        if ($idAluno && $codigoFormacao && $estado) {
            $sql = "INSERT INTO inscricao ( idAluno, codigoFormacao, dataInscricao, estado) 
                    VALUES ('$idAluno', '$codigoFormacao', '$dataInscricao', '$estado')";
            $res = mysqli_query($conn, $sql);

            if ($res && mysqli_affected_rows($conn) == 1) {
                echo '<font color="green">Criação com sucesso!</font>';
                header("refresh:1; url=pgGestaoInscricoes.php");
                exit;
            } else {
                echo '<font color="red">Criação falhou!</font>';
            }
        }
        
        header("refresh:3; url=pgGestaoInscricoes.php");   
    }
?>
