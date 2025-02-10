<?php
	include_once("../basedados/basedados.h");
	session_start();

	// Verifica se o utilizador está logado e se o perfil é de admin ou docente
	if (!isset($_SESSION['perfil'])||($_SESSION['perfil']!="admin")){
		echo "Não tem permissão para aceder a esta página.";

		if($_SESSION['perfil']=="aluno"){
			header("refresh:0; url=menu_aluno.php");
		} elseif ($_SESSION['perfil']=="docente") {
			header("refresh:0; url=menu_docente.php");
		} else {
			header("refresh:0; url=index.php");
		}

	} else {
		


		$id_utilizador = $_GET['id'];
		$email_utilizador = $_GET["e_mail"];
		$user_name = $_GET["user_name"];


    // Limpeza dos dados para evitar SQL Injection
    $id_utilizador = mysqli_real_escape_string($conn, $id_utilizador);

    // Verifica se existe pelo menos outro administrador autenticado
    $sql = "SELECT COUNT(*) AS total_admins 
            FROM utilizadores 
            WHERE perfil = 'admin' AND autenticado = 1 AND id_utilizador != $id_utilizador";
    $resultado = mysqli_query($conn, $sql);

    if ($resultado) {
        $row = mysqli_fetch_assoc($resultado);

        if ($row['total_admins'] > 0) {
            // Atualiza o estado do utilizador para não autenticado
            $sql_update = "UPDATE utilizadores SET autenticado = 0 WHERE id_utilizador = $id_utilizador";
            $resultado_update = mysqli_query($conn, $sql_update);

            if ($resultado_update) {
                header("refresh:0;url=menu_admin.php");
            } else {
                echo "<h4>Ocorreu um erro ao tentar bloquear o utilizador.</h4>";
            }
        } else {
            // Não há outro admin autenticado
            echo "<div class='container'>
                    <h4>Não é possível bloquear este utilizador porque não existe outro administrador autenticado.</h4>
                    <a href='menu_admin.php'>Voltar</a>
                  </div>";
        }
    } else {
        echo "<h4>Erro ao verificar administradores.</h4>";
    }

    // Fecha a ligação à base de dados
    mysqli_close($conn);
}
?>
