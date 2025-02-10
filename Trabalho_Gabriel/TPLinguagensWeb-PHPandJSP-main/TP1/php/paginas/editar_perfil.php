
	<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Editar Perfil</title>
</head>
<body>

    <?php
    ob_start();
    include_once("../basedados/basedados.h");
    session_start();

    if (isset($_SESSION['id'])&& ($_SESSION['perfil'] == 'aluno' || $_SESSION['perfil'] == 'docente' || $_SESSION['perfil'] == 'admin')) {
        echo "<a href='logout.php'>Logout</a>";
		$home_page_perfil= null;
		switch ($_SESSION["perfil"]) {
			case 'aluno':
				
				$home_page_perfil = "menu_aluno.php";
				break;
			case 'docente':
				
				$home_page_perfil = "menu_docente.php";
				break;
			case 'admin':
				
				$home_page_perfil = "menu_admin.php";
				break;
			}

        echo "<br><a href='$home_page_perfil'>Home Page</a>";
		echo"<br><h1>Editar dados pessoais</h1>";
		$id = $_SESSION['id'];
        $user_name = $_SESSION['user_name'];

        #$conn = conectar_bd();
        $sql ="SELECT * FROM utilizadores WHERE id_utilizador ='$id'";

        $resultado = mysqli_query($conn, $sql);

        if ($resultado && mysqli_num_rows($resultado)>0) {
            $linha = mysqli_fetch_assoc($resultado);
    ?>
    <form action="atualizar_perfil.php" method="POST">
        <input type="hidden" name="id_utilizador" value="<?php echo $linha['id_utilizador']; ?>">
        Nome: <input type="text" name="nome" value="<?php echo $linha['nome']; ?>"><br>
        Último nome: <input type="text" name="ultimo_nome" value="<?php echo $linha['ultimo_nome']; ?>"><br>
        User name: <input type="text" name="user_name" value="<?php echo $linha['user_name']; ?>"><br>
        Password: <input type="password" name="password"><br>
        <input type="submit" value="Atualizar">
    </form>
    <?php
        } else {
            echo "Erro ao buscar dados do utilizador.";
        }
    mysqli_close($conn);
    } else {
        header("refresh:0; url=index.php");
    }
    ?>
</body>
</html>