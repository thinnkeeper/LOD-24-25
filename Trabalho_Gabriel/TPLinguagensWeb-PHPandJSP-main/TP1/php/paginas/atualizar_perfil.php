<?php
	include_once("../basedados/basedados.h");
	session_start();

    if (!isset($_SESSION['perfil'])){
        header("refresh:0; url=index.php");
        
    } else {
    
        $id_utilizador = $_POST['id_utilizador'];
        $nome = $_POST['nome'];
        $ultimo_nome = $_POST['ultimo_nome'];
        $new_user_name = $_POST['user_name'];
        $old_user_name = $_SESSION['user_name'];
        
        $password = $_POST['password'];
        if (empty($nome)||empty($ultimo_nome)||empty($new_user_name)||empty($password)) {
            echo "Não pode haver valores vazios";
            header("refresh:3;url=editar_perfil.php");
        }else{

            $tipo_perfil = $_SESSION["perfil"];


            #$conn = conectar_bd();

            $sql = "UPDATE utilizadores SET nome = '$nome', ultimo_nome='$ultimo_nome', user_name ='$new_user_name', password= MD5('$password') WHERE id_utilizador = $id_utilizador";

            $resultado = mysqli_query($conn, $sql);

            if ($resultado) {
                echo "Utilizador com id=".$id_utilizador." atualizado com sucesso!<br>
                Antigo user_name=".$old_user_name." <br>
                Novo user_name= ".$new_user_name."<br>";
                $_SESSION["user_name"] = $new_user_name;
                $home_page_perfil = null;
                switch ($tipo_perfil) {
                                case 'aluno':
                                    
                                    $home_page_perfil = "menu_aluno.php";
                                    break;
                                case 'docente':
                                    
                                    $home_page_perfil = "menu_docente.php";
                                    break;
                                case 'admin':
                                    
                                    $home_page_perfil ="menu_admin.php";
                                    break;
                            }

                    echo "<br><a href='$home_page_perfil'>Home Page</a>";
            }
        mysqli_close($conn);
        
    }
		
}

?>