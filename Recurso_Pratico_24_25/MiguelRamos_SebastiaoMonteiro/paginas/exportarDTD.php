<?php
    session_start();

    include("../basedados/basedados.h");

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true || $_SESSION['tipoUtilizador'] != "1")) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
    } else {

        // Conectar à base de dados
        $query = "SHOW TABLES FROM lwbd";
        $result = mysqli_query($conn, $query);
            
        $dtdContent = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $dtdContent .= "<!ELEMENT formacoesLW (";
        
        $tableElements = [];
        $elementDefinitions = "";
            
        while ($tab = mysqli_fetch_row($result)) {
            $tableName = $tab[0];
            $tableElements[] = $tableName;
                
            $query2 = "SHOW COLUMNS FROM " . $tableName;
            $result2 = mysqli_query($conn, $query2);
            
            $columnElements = [];
            while ($tab2 = mysqli_fetch_row($result2)) {
                $columnElements[] = $tab2[0];
                $elementDefinitions .= "<!ELEMENT " . $tab2[0] . " (#PCDATA)>\n";
            }
                
            $dtdContent .= "<!ELEMENT " . $tableName . " (" . implode(", ", $columnElements) . ")>\n";
        }
            
        $dtdContent .= implode(", ", $tableElements) . ")>\n";
        $dtdContent .= $elementDefinitions;
            
        // Guardar o DTD num ficheiro
        $filename = "exportarDTD.dtd";
        file_put_contents($filename, $dtdContent);

        // Remover o ficheiro após o download
        // unlink($filename);

        header("refresh:1; url=pgGestao.php");
    }
?>
