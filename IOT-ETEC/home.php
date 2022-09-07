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
		<style>

		html {
			font-family: Arial;
			display: inline-block;
			margin: 0px auto;
			text-align: center;
		}

		ul.topnav {
			font-family: Courier;
			list-style-type: none;
			margin: auto;
			padding: 0;
			overflow: hidden;
			background-color: #9c2241;
			width: 100%;
			height: 100px;
			color: white;

			/* position: fixed;
			top: 0;
			font-size: 15px;
			text-align: center; */
	
		}

		ul.topnav li { float: left }

		ul.topnav li a {
			font-family: Courier;
			display: block;
			color: white;
			text-align: center;
			padding: 10px 16px;
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

		.menu{
			/* display: flex;
 			justify-content: center; */

			 display: flex;
			 display: flex;
 			 justify-content: center;
  			 text-align: center;
  			 padding-left: 0;
	
		}


		</style>
		
		<title>ETEC</title>

	</head>
	
	<body>
	

	

		
		<ul class="topnav"> 
			<!-- <div class="logo">
				<img src="img\\tec.png">
			</div> -->

			<h2>Sistema Integrado ETEC de Cotia</h2>
			<nav class="menu">
				
				<li><a class="active" href="home.php" >Página Inicial</a></li>
				<li><a href="fichario.php">Fichário</a></li>
				<li><a href="cadastro.php">Cadastro</a></li>
				<li><a href="consulta.php">Consulta</a></li>

				
			
			</nav>
		</ul>

	

	 	

	 </div>
	

	
			
		<br>
				
		<img src="img\\maintenance.png" alt="" style="width:45%;">

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