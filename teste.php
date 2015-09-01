<?php 
$password = 'teste';

// These only work for CRYPT_SHA512, but it should give you an idea of how crypt() works.
$Salt = uniqid(); // Could use the second parameter to give it more entropy.
$Algo = '6'; // This is CRYPT_SHA512 as shown on http://php.net/crypt
$Rounds = '5000'; // The more, the more secure it is!

// This is the "salt" string we give to crypt().
$crypt = '$' . $Algo . '$rounds=' . $Rounds . '$' . $Salt;

$HashedPassword = crypt($password, $crypt);
echo "Generated a hashed password: " . $HashedPassword . "\n";
?>

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
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">SIGOI</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <!-- ----- Barra de Navegação: Esquerda ------ -->
                <ul class="nav navbar-nav">
                    <li class="nav nav-btn"><a href="novo.php">Novo Chamado</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Opções <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="disabled"><a href="#">Editar Chamado</a></li>
                            <li class="disabled"><a href="#">Excluir Chamado</a></li>
                            <li role="separator" class="divider"></li>
                            <li class="disabled"><a href="#">Cadastro de Usuários</a></li>
                            <li><a href="cadastro_setor.php">Cadastro de Setores</a></li>
                            <li><a href="cadastro_local.php">Cadastro de Locais</a></li>
                            <li><a href="cadastro_funcao.php">Cadastro de Funções</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="parametros.php">Parâmetros SIGOI</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Visualizações <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="disabled"><a href="#">Seus Chamados</a></li>
                            <li class="disabled"><a href="#">Seus Chamados Abertos</a></li>
                            <li class="disabled"><a href="#">Seus Chamados Pendentes</a></li>
                            <li class="disabled"><a href="#">Seus Chamados Fechados</a></li>
                            <li role="separator" class="divider"></li>
                            <li class="disabled"><a href="#">Todos os Chamados</a></li>
                            <li class="disabled"><a href="#">Todos os Chamados Abertos</a></li>                 
                            <li class="disabled"><a href="#">Todos os Chamados Pendentes</a></li>
                            <li class="disabled"><a href="#">Todos os Chamados Fechados</a></li>
                            <li role="separator" class="divider"></li>
                            <li class="disabled"><a href="#">Chamados Não Atribuídos</a></li>                           
                        </ul>
                    </li>
                    <!-- <li class="active"><a href="#">Link</a></li> -->
                </ul>
                <!-- ----- Barra de Navegação: Direita ------ -->
                <ul class="nav navbar-nav navbar-right">
                    <form class="navbar-form navbar-left" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Pesquisar">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Vai!</button>
                            </span>
                        </div>
                    </form>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo -->
    <div class="container-fluid">

        <div id="loginbox" class="mainbox col-md-6 col-sm-offset-3"> 
            <!-- <div class="row">
                <div class="iconmelon">
                    <svg viewBox="0 0 32 32">
                        <g filter="">
                            <use xlink:href="#git"></use>
                        </g>
                    </svg>
                </div>
            </div> -->
            <div class="panel panel-default" >
                <div class="panel-heading">
                    <div class="panel-title text-center">Login</div>
                </div>     
                <div class="panel-body" >
                    <form name="form" id="form" class="form-horizontal" enctype="multipart/form-data" method="POST">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="user" type="text" class="form-control" name="user" value="" placeholder="User">                                        
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                        </div>                                                                  
                        <div class="form-group">
                            <!-- Button -->
                            <div class="col-sm-12 controls">
                                <button type="submit" href="#" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-log-in"></i> Log in</button>                          
                            </div>
                        </div>
                    </form>     
                </div>                     
            </div>  
        </div>

    </div>
</body>
</html>