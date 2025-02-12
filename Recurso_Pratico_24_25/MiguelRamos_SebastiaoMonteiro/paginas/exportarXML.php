<?php
    session_start();

    include("../basedados/basedados.h");

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true)) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
    } else {

    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;

    // Criar elemento raiz
    $root = $dom->createElement('formacoesLW');
    $dom->appendChild($root);

    // Obter utilizadores
    $utilizadoresNode = $dom->createElement('utilizadores');
    $root->appendChild($utilizadoresNode);

    $sql = "SELECT * FROM utilizador";
    $utilizadoresResult = mysqli_query($conn, $sql);

    while ($utilizador = mysqli_fetch_assoc($utilizadoresResult)) {
        $utilizadorNode = $dom->createElement('utilizador');
        foreach ($utilizador as $key => $value) {
            $childNode = $dom->createElement($key, $value);
            $utilizadorNode->appendChild($childNode);
        }
        $utilizadoresNode->appendChild($utilizadorNode);
    }

    // Obter formações
    $formacoesNode = $dom->createElement('formacoes');
    $root->appendChild($formacoesNode);

    $sql = "SELECT * FROM formacao";
    $formacoesResult = mysqli_query($conn, $sql);

    while ($formacao = mysqli_fetch_assoc($formacoesResult)) {
        $formacaoNode = $dom->createElement('formacao');
        foreach ($formacao as $key => $value) {
            $childNode = $dom->createElement($key, $value);
            $formacaoNode->appendChild($childNode);
        }
        $formacoesNode->appendChild($formacaoNode);
    }

    // Definir cabeçalhos para XML
    header('Content-Type: text/xml');
    $dom->save('formacoesLW.xml');

    // Disponibilizar o arquivo para download
    header('Content-disposition: attachment; filename="formacoesLW.xml"');
    echo $dom->saveXML();

    }

?>