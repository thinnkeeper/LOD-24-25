<html>
    <head>
        <meta charset="utf-8">
        <title>Página Incrições</title>
        <link rel="stylesheet" href="styles.css">

    </head>
    <body>
        <div id="cabecalho">
            <a href='pgHomepage.php'>
                <div id="logo">
                    <h2>FormacõesLW</h2>
                </div>
            </a>
            <div class= "input-div">
                <div id="botoes"> 
                    <?php
                        session_start();
                        require_once "../basedados/basedados.h";
                        
                        if($_SESSION["autenticado"]){
                            
                            echo "
                                <div id='botao'>
                                    <form action='./logout.php'>
                                        <input type='submit' value='Logout'>
                                    </form>
                                </div>
                                <div id='botao'>
                                    <form action='./pgGestao.php'>
                                        <input type='submit' value='Area Pessoal'>
                                    </form>
                                </div>
                            ";	
                        }else {
                            
                            echo "
                                <div id='botao'>
                                    <form action='./PgLogin.php'>
                                        <input type='submit' value='Login'>
                                    </form>
                                </div>
                                <div id='botao'> 
                                    <form action='./PgRegisto.php'>
                                        <input type='submit' value='Registe-se'>
                                    </form>
                                </div>
                            ";
                            
                        }
                    ?>
                </div>
            </div>
        </div>
        <div id="corpo">
            <?php
                if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true)) {
                    echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
                    header("refresh:1; url=pgHomepage.php");
                } else {
                    $sql = "SELECT * FROM `formacao`";
                    $res = mysqli_query($conn , $sql);
                    if (mysqli_num_rows($res) == 0) {
                        echo "<b>Não existem formacoes!<b>";
                    }

                    $infos = array(); ///lista temporaria para guardar os valores das formacoes
                    
                    echo "<table border='1' style='text-align:center;'>
                            <tr>
                                <th>Código Formação</th>
                                <th>Lotação</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Data</th>
                                <th>Hora de Início</th>
                                <th>Duração</th>
                            </tr>";
                    while($row = mysqli_fetch_array($res)){
                        $temp = array();
                        echo "<tr>";
                            echo "<td>".$row['codigoFormacao']."</td>";
                            $temp[] = $row['codigoFormacao'];
                            echo "<td>".$row['lotacao']."</td>";
                            echo "<td>".$row['nome']."</td>";
                            $temp[] = $row['nome'];
                            echo "<td>".$row['descricao']."</td>";
                            echo "<td>".$row['data']."</td>";
                            echo "<td>".$row['horaInicio']."</td>";
                            echo "<td>".$row['duracao']."</td>";
                        echo "</tr>";
                        $infos[] = $temp;
                    }
                    echo "</table><br/>";                    
            ?>
            <br>
            <form action="fazInscricao.php" method="POST">
                <fieldset style="width: 295px">
                    <b>Qual a formação?</b>
                    <select name="formacao">
                        <option></option>
                        <?php
                        foreach ($infos as $value) {
                            echo $value['0'];
                            $codigoFormacao = $value[0];
                            $nome = $value[1];
                            echo '<option value="'.$codigoFormacao.'">'.$nome.'</option>';
                        }
                        ?>
                    </select>
                    <input type="submit" value="Confirmar">
                    <button><a href='pgGestao.php' style="text-decoration: none;">Voltar</a></button>
                </fieldset>
            </form>
            <?php
                }
            ?>
        </div>
    </body>
</html>