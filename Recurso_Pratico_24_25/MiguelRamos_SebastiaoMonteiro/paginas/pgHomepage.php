<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FormacoesLW</title>
	<link rel="stylesheet" href="styles.css">
</head>

<body>
    	<!-- GRAFISMO CABECALHO -->
<div id="cabecalho">
	<a href='pgHomepage.php'>
		<div id="logo">
            <h2>FormacõesLW</h2>
		</div>
	</a>
    <div class= "input-div">
		<div id="botoes"> 
			<?php
				ob_start();
				session_start();
				
				if(isset($_SESSION["nomeUtilizador"])){
					
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
    <div id="imagem">
		<img src="banner.JPG" alt="banner">
    </div>
    <div id="dados">
        <div id="localizacao">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3064.447506980121!2d-7.513859882316797!3d39.81938324447061!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd3d5ea6bb2280e1%3A0x1c460157bc4b46c8!2sEscola%20Superior%20de%20Tecnologia%20-%20Instituto%20Polit%C3%A9cnico%20de%20Castelo%20Branco!5e0!3m2!1spt-PT!2spt!4v1715871330111!5m2!1spt-PT!2spt" 
					width="900" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div id="horario">
            <h3>Horario</h3>
			<b>Segunda-feira --- 09:00h - 18:00h</b><br>
			<b>Terça-feira ----- 09:00h - 18:00h</b><br>
			<b>Quarta-feira ---- 09:00h - 18:00h</b><br>
			<b>Quinta-feira ---- 09:00h - 18:00h</b><br>
			<b>Sexta-feira ----- 09:00h - 18:00h</b><br>
			<b>Sábado ---------- Fechado</b><br>
			<b>Domingo --------- Fechado</b><br>
			<br><br><br>
			
        </div>
		<div id="horario">
            <h3>Preços</h3>			
			<b>Preçário:</b><br>
			<b>Aulas 30 min - - -> 35€</b><br>
			<b>Aulas 60 min - - -> 65€</b><br>
			<b>Aulas 90 min - - -> 95€</b><br>
			<br><br><br>
        </div>
    </div>
</div>
</body>
</html>