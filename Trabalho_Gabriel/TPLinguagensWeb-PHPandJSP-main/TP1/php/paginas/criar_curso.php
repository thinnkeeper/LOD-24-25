<?php
	include_once("../basedados/basedados.h");
	session_start();

    // Verifica se o utilizador está logado e se o perfil é de admin ou docente

    if (isset($_SESSION['perfil'])&&($_SESSION['perfil']=="admin" || $_SESSION['perfil']=="docente")) {
        $id_utilizador =$_POST['id'];
        $nome_curso = $_POST['nome_curso'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $vagas_totais = $_POST['vagas_totais'];
        
        $tipo_perfil = $_SESSION["perfil"];
        
        #$password = $_POST['password'];
        if (empty($nome_curso)||empty($descricao)||empty($preco)||empty($vagas_totais)) {
            echo "Não pode haver valores vazios";

            if ($tipo_perfil == "docente") {
                header("refresh:3;url=menu_docente.php");
            }
            else
                header("refresh:3;url=menu_admin.php");
            
        }else{

            
            #$conn = conectar_bd();

            $sql = "INSERT INTO cursos (id_utilizador, nome_curso, descricao, preco,vagas_disponiveis, vagas_totais) VALUES ('$id_utilizador', '$nome_curso', '$descricao',' $preco', '$vagas_totais', '$vagas_totais')";

            $resultado = mysqli_query($conn, $sql);

            if ($resultado) {
                echo "Curso ".$nome_curso." criado com sucesso!<br>";
                if ($tipo_perfil == "docente") {
                    echo "<br><a href=menu_docente.php>Home Page</a>";
                    header("refresh:3;url=menu_docente.php");
                }
                else
                echo "<br><a href=menu_admin.php>Home Page</a>";
                header("refresh:3;url=menu_admin.php");
                
            }
            mysqli_close($conn);
        }
    }
    else {
        header("refresh:0; url=index.php");
    }

	
?>