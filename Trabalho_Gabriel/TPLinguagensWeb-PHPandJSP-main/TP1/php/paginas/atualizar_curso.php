<?php
	include_once("../basedados/basedados.h");
	session_start();

    // Verifica se o utilizador está logado e se o perfil é de admin ou docente
    if (!isset($_SESSION['perfil'])||($_SESSION['perfil']!="admin"||$_SESSION['perfil']!="docente")){
        echo "Não tem permissão para aceder a esta página.";
        if($_SESSION['perfil']=="aluno"){
            header("refresh:0; url=menu_aluno.php");
        }else{
        header("refresh:0; url=index.php");
        }

    } else {
        $id_curso = $_POST['id_curso'];
        $nome_curso = $_POST['nome_curso'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $vagas_totais = $_POST['vagas_totais'];

        $vagas_antigas = $_POST['vagas_totais_antigas'];
        $vagas_disponiveis = $_POST['vagas_disponiveis'];

        $novas_vagas = $vagas_disponiveis + ($vagas_totais - $vagas_antigas);
        
        
        if (empty($nome_curso)||empty($descricao)||empty($preco)||empty($vagas_totais)||$vagas_totais<($vagas_antigas-$vagas_disponiveis)) {
            echo "Não pode haver valores vazios ou menos vagas totais que o número de alunos inscritos neste curso.";
            header("refresh:3;url=gerenciar_curso.php");
        }else{

            $tipo_perfil = $_SESSION["perfil"];

            #$conn = conectar_bd();


            $sql = "UPDATE cursos SET nome_curso = '$nome_curso', descricao='$descricao', preco ='$preco', vagas_totais= '$vagas_totais',vagas_disponiveis = '$novas_vagas' WHERE id_curso = $id_curso";

            $resultado = mysqli_query($conn, $sql);

            if ($resultado) {
                echo "Curso ".$nome_curso." atualizado com sucesso!<br>";
                #$_SESSION["user_name"] = $new_user_name;
                $home_page_perfil = null;
                switch ($tipo_perfil) {
                        
                                case 'docente':
                                    $home_page_perfil = "menu_docente.php";
                                    break;

                                case 'admin':
                                    $home_page_perfil ="menu_admin.php";
                                    break;
                            }

                    header("refresh:2;url='$home_page_perfil'");
            }
            mysqli_close($conn);
    }
		
}

?>