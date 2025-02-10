<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pagina Inicial</title>
	<style>
        ul {
            margin-bottom: 20px; /* Aumenta o espaço entre os itens da lista */
        }
        .form-container {
            margin-bottom: 30px; /* Aumenta o espaço entre os formulários */
        }
        form {
            display: inline-block;
            margin-bottom: 20px; /* Aumenta o espaço entre os formulários */
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>

</head>
<body>
    <h1>Bem-vindo à Empresa de Formação ESTCursosDigit </h1>
    <div class="container">
        <span class="texto" style="font-size: px;">Formação em Competências Digitais</span>
    </div>
    <h2>Informações sobre a Empresa</h2>
    <ul>
        <li>Localização: Avenida do Empresário</li> 
        <li>6000-767 Castelo Branco</li>
        <li>Horários de Funcionamento: 8:00 às 22:00 de Segunda a Sexta-feira <br>Sábados das 9:00 às 13:00</li>
        <li>Cursos: </li>

        <?php
            ob_start();
            include_once("../basedados/basedados.h");
            
            //query para pegar os dados de todos os cursos criados
            $sql = "SELECT * FROM cursos";
            
		    $resultado = mysqli_query($conn, $sql);
            
            if ($resultado && mysqli_num_rows($resultado) >0) {
                echo "<table border='1'>";
                echo "  <tr>
                            <th>Id_curso</th>
                            <th>Nome docente</th>
                            <th>Título do curso</th>
                            <th>Descrição</th>
                            <th>Preço</th>
                            <th>Número de vagas Restantes</th>
                        </tr>";
                    while ($linha = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>";
                            $sql2 = "SELECT nome FROM utilizadores WHERE id_utilizador = ".$linha['id_utilizador'];
                            $resultado2 = mysqli_query($conn,$sql2);
                            $nome_docente = mysqli_fetch_assoc($resultado2);

                            echo "<td>".$linha["id_curso"]."</td>";
                            echo "<td>".$nome_docente["nome"]."</td>";
                            echo "<td>".$linha["nome_curso"]."</td>";
                            echo "<td>".substr($linha["descricao"],0,50)."</td>";
                            echo "<td>".$linha["preco"]." €</td>";
                            echo "<td>".$linha["vagas_disponiveis"]."</td>";
                        echo "</tr>";

                    }
                    echo "</table>";
                }
        ?>
    </ul>
        <div class="form-container">
        <h2>Login</h2>
        <form action="login.php" method="POST"> 
            User_name: <input type="text" name="user_name" style="margin-bottom: 10px;"><br>
            Password: <input type="password" name="password" style="margin-bottom: 10px;"><br>
            <input type="submit" name="Login">
        </form>
    </div>

    <div class="form-container">
        <h2>Registo</h2>
        <form action="registo.php" method="post">
            Nome: <input type="text" name="nome" style="margin-bottom: 10px;"><br>      
            Último nome: <input type="text" name="ultimo_nome"style="margin-bottom: 10px;"><br>      
            E-mail: <input type="text" name="e_mail"style="margin-bottom: 10px;"><br>
            User_name: <input type="text" name="user_name"style="margin-bottom: 10px;"><br>
            Password: <input type="password" name="password"style="margin-bottom: 10px;"><br>
            Perfil:
            <select name="perfil" style="margin-bottom: 10px;">
                <option value="aluno">Aluno</option>
                <option value="docente">Docente</option>
                <option value="admin">Administrador</option>
            </select><br>
            <input type="submit" value="Registar-se">
        </form>
    </div>
</body>
</html>