<?php
	$Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
	file_put_contents('UIDContainer.php',$Write);
?>

<!DOCTYPE html>
<html lang="pt-br">
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.min.js"></script>
		<script>
			$(document).ready(function(){
				 $("#getUID").load("UIDContainer.php");
				setInterval(function() {
					$("#getUID").load("UIDContainer.php");
				}, 500);
			});
		</script>
		
		<style>
		html {
			font-family: Arial;
			display: inline-block;
			margin: 0px auto;
		}
		
		textarea {
			resize: none;
		}

		ul.topnav {
			list-style-type: none;
			margin: auto;
			padding: 0;
			overflow: hidden;
			background-color: #9c2241;
			width: 70%;
		}

		ul.topnav li {float: left;}

		ul.topnav li a {
			display: block;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
		}

		ul.topnav li a:hover:not(.active) {background-color: #1b1c1b;}

		ul.topnav li a.active {background-color: #333;}

		ul.topnav li.right {float: right;}

		@media screen and (max-width: 600px) {
			ul.topnav li.right, 
			ul.topnav li {float: none;}
		}

		img {
			display: block;
			margin-left: auto;
			margin-right: auto;
		}

		footer {
    		position: absolute;
   			bottom: 0;
    		background-color: #9c2241;
    		color: white;
    		width: 100%;
    		height: 100px;
    		text-align: center;
    		line-height: 100px;
		}

		div.rodape{
			font-family: Courier;
			display: inline-block;
			margin: 41px 12px;
			text-align: right;
			color: white;
			float: right;
		
		}
		
		div.logo{
			float: left;
			width: 4%;
		}

		div.ico{
			float: left;
			color: white;
			font-family: Courier;
			width: 7%;
			display: block flow;
		}
		
		</style>
		
		<title>ETEC</title>
	</head>
	
	<body>

		<h2 align="center">Cadastro de Alunos</h2>
		
		<ul class="topnav">
			<li><a href="home.php">Página Inicial</a></li>
			<li><a href="fichario.php">Fichário</a></li>
			<li><a class="active" href="cadastro.php">Cadastro</a></li>
			<li><a href="consulta.php">Consulta	</a></li>
		</ul>

		<div class="container">
			<br>
			<div class="center" style="margin: 0 auto; width:495px; border-style: solid; border-color: #f2f2f2;">
				<div class="row">
					<h3 align="center">Registro de Alunos</h3>
				</div>
				<br>
				<form class="form-horizontal" action="insertDB.php" method="post" >
					<div class="control-group">
						<label class="control-label">ID</label>
						<div class="controls">
							<textarea name="id" id="getUID" placeholder="Passe o cartão no Leitor para realizar o cadastro" rows="1" cols="1" required></textarea>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">Nome</label>
						<div class="controls">
							<input id="div_refresh" name="name" type="text"  placeholder="" required>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">Gênero</label>
						<div class="controls">
							<select name="gender">
								<option value="Male">Masculino</option>
								<option value="Female">Feminino</option>
							</select>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">E-mail</label>
						<div class="controls">
							<input name="email" type="text" placeholder="" required>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">Celular</label>
						<div class="controls">
							<input name="mobile" type="text"  placeholder="" required>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Curso</label>
						<div class="controls">
							<input name="curso" type="text"  placeholder="" required>
						</div>
					</div>
					
					<div class="form-actions">
						<button type="submit" class="btn btn-success">Salvar</button>
                    </div>
				</form>
				
			</div>               
		</div> <!-- /container -->	
		
		<footer>

			<div class="rodape">

				<h5>Developed by<br>Raphael Mariano & Luiz Gustavo & Giovanna</h5>

			</div>

			<div class="ico">

				<img src="img\\tec.png" style="width: 40%">

				<h5>@TECDREAMS</h5>

			</div>

		</footer>

	</body>
</html>