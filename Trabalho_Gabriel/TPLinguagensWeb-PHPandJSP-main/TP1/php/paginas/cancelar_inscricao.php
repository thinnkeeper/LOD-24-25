<?php
    include_once("../basedados/basedados.h");
	session_start();

    //verificar se o utilizador está logado
	if (isset($_SESSION["id"])){
        $id_aluno= $_GET["id_utilizador"];
        $id_curso = $_GET["id_curso"];
        #$conn = conectar_bd();

        
        $sql = "DELETE FROM inscricoes WHERE id_curso = $id_curso and id_utilizador = $id_aluno ";
        $resultado=$conn->query($sql);
        
        if($resultado){
            echo "Cancelamento realizado com sucesso!<br>";

            $perfil = $_SESSION["perfil"];
            switch ($perfil) {
                case 'aluno':
                    
                    header("refresh:2;url=menu_aluno.php");
                    break;
                
                case 'docente':
                    
                    header("refresh:2;url=gerenciar_curso.php?id_curso=".$id_curso."");
                    break;

                case 'admin':
                    
                    header("refresh:2;url=gerenciar_curso.php?id_curso=".$id_curso."");
                    break;
            }
            

            $vagas = "SELECT vagas_disponiveis FROM  cursos WHERE id_curso = $id_curso ";
            $resultado_vagas = mysqli_query($conn, $vagas);
            $numero_vagas = mysqli_fetch_assoc($resultado_vagas);
            $vagas_restantes = $numero_vagas["vagas_disponiveis"];
            $vagas_restantes+=1;
            
            $sql = "UPDATE cursos SET vagas_disponiveis = ".$vagas_restantes."  WHERE id_curso =".$id_curso."";
            mysqli_query($conn,$sql);   

        } else{
            echo "houve problema com a insercao na base de dados".mysqli_error($conn);
            }
        } else {
            header("refresh:0; url=index.php");
        } 
        mysqli_close($conn);
	
?>