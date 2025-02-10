<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="estilo.css">
        <body>
            
        

<?php
    include_once("../basedados/basedados.h");
	session_start();

	if (isset($_SESSION["id"])&& ($_SESSION["perfil"] == "aluno"|| $_SESSION["perfil"] == "docente" || $_SESSION["perfil"] == "admin")){
        $id_aluno= $_GET["id_aluno"];
        $id_curso = $_GET["id_curso"];
        
        //query para pegar o numero de vagas disponiveis naquele curso
        $vagas = "SELECT vagas_disponiveis FROM  cursos WHERE id_curso = $id_curso ";
        $resultado_vagas = mysqli_query($conn, $vagas);
        if ($resultado_vagas && mysqli_num_rows($resultado_vagas)>0) {
            $numero_vagas = mysqli_fetch_assoc($resultado_vagas);
            $vagas_restantes = $numero_vagas["vagas_disponiveis"];
            
            if ($vagas_restantes > 0 ) {
                //se ha vagas insere na tabela inscricoes os dados do aluno e do curso
                $sql = "INSERT INTO inscricoes (id_utilizador,id_curso) VALUES('$id_aluno','$id_curso')";
		        $resultado=$conn->query($sql);
                
		        if($resultado){
                    echo "<h2 style='text-align:center;'>Inscrição realizada com sucesso!</h2>";
                    $perfil_utilizador = $_SESSION['perfil'];
                    switch ($perfil_utilizador) {
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
			        


                    $vagas_restantes-=1;
                    $sql = "UPDATE cursos SET vagas_disponiveis = ".$vagas_restantes."  WHERE id_curso =".$id_curso."";
                    mysqli_query($conn,$sql);   

                } else{
                    echo "houve problema com a insercao na base de dados".mysqli_error($conn);
		            }
            } else {
                echo "Nao é possível a inscrição neste curso, contacte-nos! ";
                header("refresh:5 ; url=menu_aluno.php");
                }
        
        }
            
        mysqli_close($conn);

	} else {
        header("refresh:0; url=index.php");
    }
?>

        </body>
    </head>
</html>