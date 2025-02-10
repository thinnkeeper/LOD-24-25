<?php
    session_start();

    if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true)) {
        echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
        header("refresh:1; url=pgHomepage.php");
    } else {
        session_unset();
        session_destroy();
        header('Location: pghomepage.php');
        exit;
    }

?>