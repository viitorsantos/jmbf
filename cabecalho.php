<?php

	include "include/conexao.php";
	include "include/config.php";
    
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JMBF - Corretora de Seguros</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/es.css" rel="stylesheet"> 
	<link href="imagens/favicon.ico" rel="icon" type="imagens/png"/>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body data-spy="scroll" data-target=".menu-navegacao" data-offset="80">
    <!-- MENU DA APLICAÇÂO-->
      <nav class="navbar navbar-inverse navbar-fixed-top">
        <div Class="container">
          <div class="navbar-header">
            <button type="button"class="navbar-toggle" data-toggle="collapse" data-target="#menu">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">JMBF - Corretora de Seguros<img src="" class=""></a>
          </div>

          <div class="collapse navbar-collapse menu-navegacao" id="menu">
            <ul class="nav navbar-nav navbar-right">
              <li><a href="#page-top"></a></li>
              <li><a class="" href="index.php">Home</a></li>
              <li><a class="" href="corretora.php">A Corretora</a></li>
              <li class="dropdown">
                    <a href="#" class="dropdown-toggle texto" data-toggle="dropdown">Seguros <span class="caret"></span></a>

                            <ul class="dropdown-menu" role="menu">
								<?php 
									$sql_seguros = "SELECT tbl_seguros.id_link, tbl_link.link, titulo FROM tbl_seguros
									INNER JOIN tbl_link ON tbl_link.id_link = tbl_seguros.id_link
									WHERE tbl_seguros.corretora_id = ".CORRETORA." AND ativo = 1 ORDER BY titulo";
									$res_seguros = mysqli_query($con, $sql_seguros);
									for($j=0; $j<mysqli_num_rows($res_seguros); $j++){
										$linha = mysqli_fetch_assoc($res_seguros);
										$link = $linha['link'];
										$titulo = $linha['titulo'];
										echo '<li><a href="'.$link.'" >'.$titulo.'</a></li>';
									}
								?>
                            </ul>
                </li>
              <li><a class="" href="parceiros.php">Parceiros</a></li>
			  <li><a class="" href="acao_social.php">Ação Social</a></li>
              <li><a class="" href="contato.php">Fale Conosco</a></li>
            </ul>
          </div>
        </div>
      </nav>
    <!-- FIM DO MENU DA APLICAÇÂO-->