<?php
    include_once("../basedados/basedados.h");
	session_start();

	if (isset($_POST['nome'], $_POST['ultimo_nome'],$_POST['e_mail'],$_POST['user_name'], $_POST['password']) && !empty($_POST['nome'])&& !empty($_POST['ultimo_nome'])&& !empty($_POST['e_mail'])&& !empty($_POST['user_name'])&& !empty($_POST['password'])){
        
        $nome = $_POST['nome'];
        $ultimo_nome = $_POST['ultimo_nome'];
        $e_mail = $_POST['e_mail'];
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];
        $perfil = $_POST['perfil'];
    
        #$conn = conectar_bd();

		$verificar_utilizador = "SELECT * FROM utilizadores WHERE user_name LIKE '".$user_name."' OR e_mail LIKE '".$e_mail."'";

		$resultado_verificacao = mysqli_query($conn,$verificar_utilizador);

		if(mysqli_num_rows($resultado_verificacao)>0){
			echo "<h3>Nome de usuário ou e-mail já utilizados!</h3>";
			header("refresh:3; url=index.php");
		}else{
			$sql = "INSERT INTO utilizadores (nome,ultimo_nome,e_mail,user_name,password,perfil) VALUES('$nome','$ultimo_nome','$e_mail','$user_name',MD5('$password'), '$perfil')";

			$resultado=$conn->query($sql);

			if($resultado){	
				if ($_POST['isDocente'] && $_POST['isDocente'] == 'true'){
					echo "Registo feito com sucesso!";
					header("refresh:3;url=menu_admin.php");
				} else{
				echo "Seu registo foi feito com sucesso!<br>Aguarde ser autenticado.";
				header("refresh:5;url=index.php");
				}
			} else{
				echo "houve problema com a insercao na base de dados".mysqli_error($conn);
			}
		}
	}else {
		echo "Erro ao criar utilizador!";
		header("refresh:3; url=index.php");
	}

	mysqli_close($conn);
?>