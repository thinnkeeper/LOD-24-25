<?php
    include_once("../basedados/basedados.h");
	session_start();



	if (isset($_SESSION["id"])&&($_SESSION["perfil"]=="admin" || $_SESSION["perfil"]=="docente")){
        $id_curso = $_GET["id_curso"];
        $perfil = $_SESSION["perfil"];

        
        $sql = "DELETE FROM inscricoes WHERE id_curso = $id_curso";
        $resultado=$conn->query($sql);
        
        $sql2 = "DELETE FROM cursos WHERE id_curso = $id_curso";
        $resultado2=$conn->query($sql2);
        if($resultado && $resultado2){
            echo "Cancelamento realizado com sucesso!<br>";

            if($perfil == "docente"){
                
                header("refresh:3;url=menu_docente.php");
            } else{
                
                header("refresh:3;url=menu_admin.php");
            }
            


        } else{
            echo "houve problema com a insercao na base de dados".mysqli_error($conn);
            }
        } else {
            header("refresh:0; url=index.php");
        } 

		mysqli_close($conn);
?>