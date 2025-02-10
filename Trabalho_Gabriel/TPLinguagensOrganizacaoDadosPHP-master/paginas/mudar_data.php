<?php
    include_once("../basedados/basedados.h");
	session_start();

	if (isset($_SESSION["id"]) && ($_SESSION["perfil"] == "docente" || $_SESSION["perfil"] == "admin")){
    
        $id_inscricao = $_GET["id_inscricao"];
        $id_curso = $_GET["id_curso"];

        
        $sql = "UPDATE inscricoes SET data_inscricao = CURRENT_TIMESTAMP WHERE id_inscricao = $id_inscricao";
        $resultado=$conn->query($sql);
        
        if($resultado){
            echo "Mudança realizada com sucesso!<br>";
            header("refresh:3;url=gerenciar_curso.php?id_curso=".$id_curso."");
            

        } else{
            echo "houve problema com a insercao na base de dados".mysqli_error($conn);
            }
        } 
        else {
            header("refresh:0; url=index.php");
        }
        mysqli_close($conn);
	
?>