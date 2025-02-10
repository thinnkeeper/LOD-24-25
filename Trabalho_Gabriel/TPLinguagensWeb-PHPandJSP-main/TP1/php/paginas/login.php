<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
</head>
<body>

</body>
</html>

<?php
    
    include_once("../basedados/basedados.h");
    session_start();

    #verifica se essas variaveis foram preenchidas. se sim as inicializa
    if (isset($_POST['user_name'], $_POST['password'])){
        $user_name = $_POST['user_name'];
        $password = md5($_POST['password']);
    
        //query para pegar as informacoes do utilzador que esta a fazer o login
        $sql = "SELECT * FROM utilizadores WHERE user_name = '$user_name' AND password = '$password'";


        $resultado = $conn->query($sql);
        if ($resultado) {
            if(mysqli_num_rows($resultado)>0) {   
                $registo = mysqli_fetch_assoc($resultado);
                if ($registo["autenticado"]==1) {
                    
                    $_SESSION["user_name"] = $user_name;
                    $_SESSION["perfil"] = $registo["perfil"];
                    $_SESSION["id"] = $registo["id_utilizador"];
                    echo "Login bem-sucedido. Redirecionando...";

                    switch ($registo["perfil"]) {
                        case 'aluno':
                            
                            header("refresh:3;url=menu_aluno.php");
                            break;
                        case 'docente':
                            
                            header("refresh:3;url=menu_docente.php");
                            break;
                        case 'admin':
                            
                            header("refresh:3;url=menu_admin.php");
                            break;
                    }
                } else{
                    echo "Ainda não foi validado";
                    header("refresh:3; url=index.php");
                }
                
            } else {
                echo "Credenciais inválidas";
                header("refresh:3; url=index.php");}

        } else {
            echo "Por favor, preencha todos os campos";
            header("refresh:3; url=index.php");
        }
         mysqli_close($conn);
    }

    ?>