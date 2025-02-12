<?php
    session_start();

    include("../basedados/basedados.h");

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true || $_SESSION['tipoUtilizador'] != "1")) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
    } else {

    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;

    $root = $dom->createElement('baseDados');
    $dom->appendChild($root);

    // Obter utilizadores
    $utilizadores = $dom->createElement('utilizadores');
    $root->appendChild($utilizadores);

    $sql = "SELECT * FROM utilizador";
    $utilizadoresRes = mysqli_query($conn, $sql);

    while ($utilizador = mysqli_fetch_assoc($utilizadoresRes)) {
        $util = $dom->createElement('utilizador');
        foreach ($utilizador as $key => $value) {
            $temp = $dom->createElement($key, $value);
            $util->appendChild($temp);
        }
        $utilizadores->appendChild($util);
    }

    // Obter tipos de utilizador
    $tiposutilizadores = $dom->createElement('tiposUtilizadores');
    $root->appendChild($tiposutilizadores);

    $sql = "SELECT * FROM tipoutilizador";
    $tiposRes = mysqli_query($conn, $sql);

    while ($tipoutilizador = mysqli_fetch_assoc($tiposRes)) {
        $t = $dom->createElement('tipoUtilizador');
        foreach ($tipoutilizador as $key => $value) {
            $temp = $dom->createElement($key, $value);
            $t->appendChild($temp);
        }
        $tiposutilizadores->appendChild($t);
    }

    // Obter formações
    $formacoes = $dom->createElement('formacoes');
    $root->appendChild($formacoes);

    $sql = "SELECT * FROM formacao";
    $formacoesRes = mysqli_query($conn, $sql);

    while ($formacao = mysqli_fetch_assoc($formacoesRes)) {
        $formac = $dom->createElement('formacao');
        foreach ($formacao as $key => $value) {
            $temp = $dom->createElement($key, $value);
            $formac->appendChild($temp);
        }
        $formacoes->appendChild($formac);
    }

    // Obter inscrições
    $inscricoes = $dom->createElement('inscricoes');
    $root->appendChild($inscricoes);

    $sql = "SELECT * FROM inscricao";
    $inscricoesRes = mysqli_query($conn, $sql);

    while ($inscricao = mysqli_fetch_assoc($inscricoesRes)) {
        $insc = $dom->createElement('inscricao');
        foreach ($inscricao as $key => $value) {
            $temp = $dom->createElement($key, $value);
            $insc->appendChild($temp);
        }
        $inscricoes->appendChild($insc);
    }

    // Obter estados das inscrições
    $estados = $dom->createElement('estadosInscricoes');
    $root->appendChild($estados);

    $sql = "SELECT * FROM estadoinscricao";
    $estadosRes = mysqli_query($conn, $sql);

    while ($estado = mysqli_fetch_assoc($estadosRes)) {
        $est = $dom->createElement('estado');
        foreach ($estado as $key => $value) {
            $temp = $dom->createElement($key, $value);
            $est->appendChild($temp);
        }
        $estados->appendChild($est);
    }

    $dom->save('exportarXML.xml');

    //header('Content-Type: text/xml');
    //echo $dom -> saveXML();
    
    header("refresh:1; url=pgGestao.php");
    }

?>