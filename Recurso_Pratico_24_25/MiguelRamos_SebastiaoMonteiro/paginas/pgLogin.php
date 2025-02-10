<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    
    <h3>Login</h3>

    <form method="POST" action="fazLogin.php">
        <label>Utilizador:</label> <input type="text" name="nomeUtilizador">
        <label>Password:</label> <input type="password" name="password">
        <br>
        <input type="submit" value="Login">
    </form>

    <a href='pgRegisto.php' style="color: black;">Ainda não tens conta? Faz já o teu registo!</a>

</body>
</html>
