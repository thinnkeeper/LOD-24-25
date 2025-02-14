<?php
    session_start();

    include("../basedados/basedados.h");

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true)) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
    } else {

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $schema = $dom->createElementNS("http://www.w3.org/2001/XMLSchema", "xs:schema");
        $dom->appendChild($schema);

        $formacoesLW = $dom->createElement("xs:element");
        $formacoesLW->setAttribute("name", "formacoesLW");
        $schema->appendChild($formacoesLW);

        $formacoesLWComplexType = $dom->createElement("xs:complexType");
        $formacoesLW->appendChild($formacoesLWComplexType);

        $formacoesLWSequence = $dom->createElement("xs:sequence");
        $formacoesLWComplexType->appendChild($formacoesLWSequence);

        // Obter a lista de tabelas da base de dados
        $query = "SHOW TABLES FROM lwbd";
        $result = mysqli_query($conn, $query);

        $tables = [];
        while ($tab = mysqli_fetch_row($result)) {
            $tableName = $tab[0];
            $tables[] = $tableName;
        }

        // Para cada tabela, cria um elemento
        foreach ($tables as $tableName) {
            // Cria o elemento da tabela
            $tableElement = $dom->createElement("xs:element");
            $tableElement->setAttribute("name", $tableName);
            $formacoesLWSequence->appendChild($tableElement);

            // Define o complexType para a tabela
            $tableComplexType = $dom->createElement("xs:complexType");
            $tableElement->appendChild($tableComplexType);

            // Cria a sequência que conterá os elementos (colunas) da tabela
            $tableSequence = $dom->createElement("xs:sequence");
            $tableComplexType->appendChild($tableSequence);

            // Obter as colunas da tabela
            $query2 = "SHOW COLUMNS FROM " . $tableName;
            $result2 = mysqli_query($conn, $query2);
            while ($column = mysqli_fetch_assoc($result2)) {
                $columnName = $column['Field'];
                $mysqlType = $column['Type'];
                // Mapeamento de tipos MySQL para XSD
                $xsdType = "xs:string"; // padrão
                if (strpos($mysqlType, "int") !== false) {
                    $xsdType = "xs:integer";
                } elseif (strpos($mysqlType, "date") !== false) {
                    $xsdType = "xs:date";
                }

                // Cria o elemento correspondente à coluna
                $columnElement = $dom->createElement("xs:element");
                $columnElement->setAttribute("name", $columnName);
                $columnElement->setAttribute("type", $xsdType);
                $tableSequence->appendChild($columnElement);
            }
        }
        // Guarda o XSD
        $xsdContent = $dom->save('exportarXSD.xsd');

        header("refresh:1; url=pgGestao.php");
    }
?>
