<?php
    session_start();

    include("../basedados/basedados.h");

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true || $_SESSION['tipoUtilizador'] != "1")) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
    } else {
        
        $query = "SHOW TABLES";
        $result = mysqli_query($conn, $query);
        
        $dtdContent = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $dtdContent .= "<!DOCTYPE formacoesLW [\n";
        
        $tables = [];
        while ($row = mysqli_fetch_array($result)) {
            $tables[] = $row[0];
        }
        
        $dtdContent .= "\t<!ELEMENT formacoesLW (" . implode(", tabela_", $tables) . ")>\n\n";
        
        foreach ($tables as $table) {
            $dtdContent .= "\t<!ELEMENT tabela_$table ($table*)>\n";
            $dtdContent .= "\t<!ELEMENT $table (";
            
            $query = "DESCRIBE $table";
            $columns_result = mysqli_query($conn, $query);
            $columns = [];
            while ($col = mysqli_fetch_assoc($columns_result)) {
                $columns[] = $col['Field'];
            }
            
            $dtdContent .= implode(", ", $columns) . ")>\n";
            
            foreach ($columns as $column) {
                $dtdContent .= "\t<!ELEMENT $column (#PCDATA)>\n";
            }
            
            $dtdContent .= "\n";
        }
        
        $dtdContent .= "]>";
        
        // Guardar o DTD num ficheiro
        $filename = "exportarDTD.dtd";
        file_put_contents($filename, $dtdContent);

        header("refresh:1; url=pgGestao.php");

        mysqli_close($conn);
    }
?>
