<?php
    session_start();

    include("../basedados/basedados.h");

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true)) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
    } else {

        // Criar o conteúdo do DTD
        $dtdContent = "<!ELEMENT formacoesLW (utilizadores, formacoes)>
        <!ELEMENT utilizadores (utilizador*)>
        <!ELEMENT utilizador (id, nomeUtilizador, email, tipoUtilizador)>
        <!ELEMENT id (#PCDATA)>
        <!ELEMENT nomeUtilizador (#PCDATA)>
        <!ELEMENT email (#PCDATA)>
        <!ELEMENT tipoUtilizador (#PCDATA)>
        <!ELEMENT formacoes (formacao*)>
        <!ELEMENT formacao (codigoFormacao, nome, descricao, data, docenteID, horaInicio, duracao, lotacao)>
        <!ELEMENT codigoFormacao (#PCDATA)>
        <!ELEMENT nome (#PCDATA)>
        <!ELEMENT descricao (#PCDATA)>
        <!ELEMENT data (#PCDATA)>
        <!ELEMENT docenteID (#PCDATA)>
        <!ELEMENT horaInicio (#PCDATA)>
        <!ELEMENT duracao (#PCDATA)>
        <!ELEMENT lotacao (#PCDATA)>";

        // Guardar o DTD num arquivo
        $filename = "formacoesLW.dtd";
        file_put_contents($filename, $dtdContent);

        // Download do DTD
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($filename));
        readfile($filename);

        // Remover o arquivo após o download
        // unlink($filename);
    }
?>