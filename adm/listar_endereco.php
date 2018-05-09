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
                            <div class="col-md-10 titulo_tela" >Endereço Corretora</div>
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
											<th>Endereco</th>
											<th>Numero</th>
											<th>Cidade</th>
											<th>Estado</th>
											<th colspan="2">Ações</th>
										</tr>
									</thead>
                                    <tbody>
                                         <?php
                                            $sql = "SELECT *FROM tbl_endereco WHERE corretora_id = ".CORRETORA."";
                                            $res = mysqli_query($con, $sql);
                                            for($i=0; $i<mysqli_num_rows($res); $i++){
                                                $linha = mysqli_fetch_assoc($res);
												$id_endereco = $linha['id_endereco'];
												$endereco    = $linha['endereco'];
												$numero      = $linha['numero'];
												$cidade      = $linha['cidade'];
												$estado      = $linha['estado'];
												
                                                echo "<tr>";
													echo "<td class='col-md-3'>$endereco</td>";
                                                    echo "<td class='col-md-2'>$numero</td>";
													echo "<td class='col-md-2'>$cidade</td>";
													echo "<td class='col-md-2'>$estado</td>";
                                                    echo "<td class='col-md-1'><a href='./cadastro_endereco.php?endereco=$id_endereco' class='btn btn-primary btn-sm'>Editar</a></td>";
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