<?php

session_start();

if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) || $_SESSION['tipoUtilizador'] >= 3) {
    echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
    header("refresh:1; url=pgHomepage.php");
    exit;
} else {

    require_once "../basedados/basedados.h";

    $idInscricao = $_POST["idInscricao"];
    $idAluno = $_POST["idAluno"];
    $codigoFormacao = $_POST["codigoFormacao"];
    $dataInscricao = $_POST["dataInscricao"];
    $estado = $_POST["estado"];
    
    $sql = "UPDATE `inscricao` SET `idAluno`='$idAluno', `codigoFormacao`='$codigoFormacao', `dataInscricao`='$dataInscricao', `estado`='$estado' WHERE `idInscricao`='$idInscricao'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) == 1) {
        echo '<font color="green">EDIT com sucesso!!!</font>';
    } else {
        echo '<font color="red">EDIT falhou!!!</font>';
    }

    header("refresh:1; url=pgGestaoInscricoes.php");
    exit;

}

?>
