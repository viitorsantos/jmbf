<?php
    include "../include/conexao.php";
    include "../include/config.php";
    include "../include/verifica_usuario.php";

	
    
	
?>
<!DOCTYPE html>
<html lang="PT-BR">
    <head> 
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/dashboard.css" rel="stylesheet">
        <link href="../css/style_admin.css" rel="stylesheet">
		
		
    </head>
	
    <body>
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                   <?php include "../include/cabecalho.php" ?>
                    <div class="col-md-2">
                        <?php include "../include/menu_admin.php" ?>
                    </div>
                    <div class="col-md-10 corpo" >
                        <div class="page-header">
                            <div class="col-md-10 titulo_tela" >Bem vindo <?php session_start(); echo $_SESSION['nome'];?></div>
                            <div class="col-md-2 link_tela">
                                
                            </div>
                        </div>
                        <?php if (strlen(trim($erro)) > 0): ?>
                            <div class="alert alert-danger">
                                <i class="icon-remove-sign"></i>
                                <?php echo $erro ?>
                            </div>
                        <?php endif; ?>
                        <?php if (strlen(trim($ok)) > 0): ?>
                            <div class="alert alert-success">
                                <i class="icon-ok"></i>
                                <?php echo $ok ?>
                            </div>
                        <?php endif; ?>
                        <div class="conteudo">
                                <form method="POST" action="">
                                    <div class="row">
										<div class="col-md-offset-4 col-md-3">
											<a href="listar_slider.php"><button type="button" class="btn btn-primary btn-group-justified">Slider</button></a>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-offset-4 col-md-3">
											 <a href="listar_seguros.php"><button type="button" class="btn btn-primary btn-group-justified">Seguros</button></a>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-offset-4 col-md-3">
											 <a href="listar_apresentacao.php"><button type="button" class="btn btn-primary btn-group-justified">Corretora</button></a>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-offset-4 col-md-3">
											 <a href="listar_social.php"><button type="button" class="btn btn-primary btn-group-justified">Ação Social</button></a>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-offset-4 col-md-3">
											 <a href="listar_parceiros.php"><button type="button" class="btn btn-primary btn-group-justified">Parceiros</button></a>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-offset-4 col-md-3">
											 <a href="listar_endereco.php"><button type="button" class="btn btn-primary btn-group-justified">Contato</button></a>
										</div>
									</div>
                               </form>

                        </div>
                    </div>
                </div>
            </div>
                <div class="row">
                    <?php include RAIZ."include/footer.php" ?>
                </div>
          
            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
        </div>
    </body>
</html>