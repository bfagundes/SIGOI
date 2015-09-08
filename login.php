<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head -->
	<title>Lista de Chamados</title>

	<!-- CSS Styles -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
	<!-- jQuery -->
	<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
	<script type="text/javascript" src="js/jquery1-11-3.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>

	<!-- Barra de Navegação -->
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
				</button>
				<a class="navbar-brand" href="login.php">SIGOI</a>
			</div>
		</div>
	</nav>

	<!-- Conteúdo -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-heading"> <strong class="brand">SIGOI: Login</strong></div>
					<div class="panel-body">
						<form class="form-horizontal" role="form">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Email</label>
								<div class="col-sm-9">
									<input type="email" class="form-control" id="inputEmail3" placeholder="Email" required="">
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-3 control-label">Password</label>
								<div class="col-sm-9">
									<input type="password" class="form-control" id="inputPassword3" placeholder="Password" required="">
								</div>
							</div>
							<!-- <div class="form-group">
								<div class="col-sm-offset-3 col-sm-9">
									<div class="checkbox">
										<label class="">
											<input type="checkbox" class="">Remember me</label>
										</div>
									</div>
								</div> -->
								<div class="form-group last">
									<div class="col-sm-offset-3 col-sm-9">
										<button type="submit" class="btn btn-success btn-sm">Sign in</button>
										<button type="reset" class="btn btn-default btn-sm">Reset</button>
									</div>
								</div>
						</form> 
					</div> <!-- /panel -->
					<!-- <div class="panel-footer">Not Registered? <a href="#" class="">Register here</a></div> -->
				</div> <!-- /panel-default -->
			</div> <!-- /col-md-4 -->
		</div> <!-- /Row -->
	</div> <!-- /Container-Fluid -->

</body>
</html>