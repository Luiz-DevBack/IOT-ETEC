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
			list-style-type: none;
			margin: auto;
			padding: 0;
			overflow: hidden;
			background-color: #9c2241;
			width: 100%;
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
		
		.table {
			margin: auto;
			width: 90%; 
		}
		
		thead {
			color: #FFFFFF;
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
		
		<h2>Fichário - Listagem de Alunos</h2>
		<ul class="topnav">
			<li><a href="home.php">Página Inicial</a></li>
			<li><a class="active" href="fichario.php">Fichário</a></li>
			<li><a href="cadastro.php">Cadastro</a></li>
			<li><a href="consulta.php">Consulta</a></li>
		</ul>
		<br>
		<div class="container">
            <div class="row">
                <h3>Tabela de Fichário</h3>
            </div>
            <div class="row">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr bgcolor="#9c2241" color="#FFFFFF">
                      <th>Nome</th>
                      <th>RM</th>
					  <th>Gênero</th>
					  <th>E-mail</th>
                      <th>Celular</th>
					  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM table_the_iot_projects ORDER BY name ASC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['name'] . '</td>';
                            echo '<td>'. $row['id'] . '</td>';
                            echo '<td>'. $row['gender'] . '</td>';
							echo '<td>'. $row['email'] . '</td>';
							echo '<td>'. $row['mobile'] . '</td>';
							echo '<td><a class="btn btn-success" href="user data edit page.php?id='.$row['id'].'">Edit</a>';
							echo ' ';
							echo '<a class="btn btn-danger" href="user data delete page.php?id='.$row['id'].'">Delete</a>';
							echo '</td>';
                            echo '</tr>';
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
				</table>
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