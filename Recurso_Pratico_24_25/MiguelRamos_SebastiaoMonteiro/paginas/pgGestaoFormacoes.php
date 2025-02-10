<html>
    <head>
        <meta charset="utf-8">
        <title>Gestão de Formacões</title>
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
            require_once "../basedados/basedados.h";

            if ((!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) || $_SESSION['tipoUtilizador'] >= 3) {
                echo "Não estás autenticado! (Sem privilégios para aceder a esta página.)";
                header("refresh:1; url=pgHomepage.php");
            } else {

                if($_SESSION['tipoUtilizador'] == "2") {
                    $dID = $_SESSION['id'];
                    $sql = "SELECT * FROM `formacao` WHERE `docenteID` = $dID";
                } else {
                    $sql = "SELECT * FROM `formacao`";
                }

                ///Vai buscar os nomes dos docentes
                $sql5 = "SELECT `id`, `nomeUtilizador`, `tipoUtilizador` FROM `utilizador`";
                $res5 = mysqli_query($conn, $sql5);
                $docentes = array();
                while ($docente = mysqli_fetch_assoc($res5)) {
                    $docentes[] = $docente;
                }

                $res = mysqli_query($conn , $sql);
                if (mysqli_num_rows($res) == 0) {
                    echo "<b>Não existem formações.</b>";
                }
                echo "<br>";
                echo "<table border='1' style='text-align:center;'><tr><th>Código</th><th>Nome</th><th>Descrição</th><th>Data</th><th>Docente</th><th>Hora Inicio</th><th>Duração</th><th>Lotação</th></tr>";

                    while($row = mysqli_fetch_array($res)){
                        echo "<tr>";
                        echo "<td>".$row['codigoFormacao']."</td>";
                        echo "<td>".$row['nome']."</td>";
                        echo "<td>".$row['descricao']."</td>";
                        echo "<td>".$row['data']."</td>";
                        foreach ($docentes as $docente) {
                            if ($docente['id'] == $row['docenteID']) {
                                $docID = $row['docenteID'];
                                $nomeDoc = $docente['nomeUtilizador'];
                                echo "<td>[".$docID."] - ".$nomeDoc."</td>";
                            }
                        }
                        echo "<td>".$row['horaInicio']."</td>";
                        echo "<td>".$row['duracao']."h</td>";
                        echo "<td>".$row['lotacao']."</td>";
                        echo "<td><a href = 'eliminaFormacao.php?codigoFormacao=" .$row['codigoFormacao']. "'> <font color='red'> ELIMINAR </font> </a></td>";
                        echo "<td><a href = 'pgEditarFormacao.php?codigoFormacao=" .$row['codigoFormacao']. "'> <font color='green'> EDITAR </font> </a></td>";
                        echo "</tr>";
                    }
                    echo "</table><br/>";
            }
            ?>
            <button><a href='pgCriaNovaFormacao.php' style="text-decoration: none;">Criar Formação</a></button>
            <button><a href='pgGestao.php' style="text-decoration: none;">Voltar</a></button>
        </div>        
    </body>
</html>