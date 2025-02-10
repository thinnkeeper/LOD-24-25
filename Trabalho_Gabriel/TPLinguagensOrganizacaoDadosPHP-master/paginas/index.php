<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ESTCursosDigitais - Página Inicial</title>
    <link rel="stylesheet" href="estilo.css?v=1.0">
    
    
</head>
<body>
    
    <header>Bem-vindo à Empresa de Formação ESTCursosDigitais</header>
    <div class="container">
        <!-- <span class="texto">Formação em Competências Digitais</span> -->
    
        <div class="button-group">
            <a href="informacao_empresa.php">Informações sobre a Empresa</a>
            <a href="informacao_cursos.php">Informações sobre cursos</a>
        </div>
    </div>
    <div class="container" style="display:flex;">
        <div class="form-registo">
        
                <h2>Login</h2>
                <form action="login.php" method="POST">
                    <input type="text" name="user_name" placeholder="Nome de usuário">
                    <input type="password" name="password" placeholder="Senha">
                    <input type="submit" value="Entrar">
                </form>
            </div>
        
            <div class="form-registo">
                <h2>Registo</h2>
                <form action="registo.php" method="post">
                    <input type="text" name="nome" placeholder="Nome">
                    <input type="text" name="ultimo_nome" placeholder="Último nome">
                    <input type="text" name="e_mail" placeholder="E-mail">
                    <input type="text" name="user_name" placeholder="Nome de utilizador">
                    <input type="password" name="password" placeholder="Senha">
                    <select name="perfil">
                         <option value="" disabled selected>Selecione o perfil</option>
                        <option value="aluno">Aluno</option>
                        <option value="docente">Docente</option>
                        <option value="admin">Administrador</option>
                    </select>
                    <input type="submit" value="Registar-se">
                </form>
            </div>
    </div>
</body>
</html>