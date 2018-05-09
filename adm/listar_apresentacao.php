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
                            <div class="col-md-10 titulo_tela" >Corretora</div>
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
                            <div class="table-responsive">
                                <table class="table table-striped">  
									<thead>
										<tr>
											<th>Quem Somos</th>
											<th>Missão</th>
											<th>Visão</th>
											<th>Valores</th>
											<th>Foto</th>
											<th colspan="2">Ações</th>
										</tr>
									</thead>
                                    <tbody>
                                         <?php
                                            $sql = "SELECT *FROM tbl_apresentacao WHERE corretora_id = ".CORRETORA."";
                                            $res = mysqli_query($con, $sql);
                                            for($i=0; $i<mysqli_num_rows($res); $i++){
                                                $linha = mysqli_fetch_assoc($res);
												$id_apresentacao = $linha['id_apresentacao'];
												$quem_somos      = $linha['quem_somos'];
												$missao          = $linha['missao'];
												$visao           = $linha['visao'];
												$valores         = $linha['valores'];
												$foto            = $linha['imagem'];
												
												
                                                echo "<tr>";
													echo "<td class='col-md-3'>$quem_somos</td>";
                                                    echo "<td class='col-md-2'>$missao</td>";
													echo "<td class='col-md-2'>$visao</td>";
													echo "<td class='col-md-2'>$valores</td>";
                                                    echo "<td><img width='200' height='200' src= 'upload/".$foto."'></td>"; 
                                                    echo "<td class='col-md-1'><a href='./cadastro_apresentacao.php?apresentacao=$id_apresentacao' class='btn btn-primary btn-sm'>Editar</a></td>";
                                                echo "</tr>";
                                            }
                                         ?>
                                    </tbody>
                                </table>
                            </div>

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