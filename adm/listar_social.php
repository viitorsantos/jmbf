<?php
    include "../include/conexao.php";
    include "../include/config.php";
    include "../include/verifica_usuario.php";
	
	if(isset($_GET['excluir'])){
		$id_social = $_GET['excluir'];
		$sql_excluir = "UPDATE tbl_social SET ativo = 0 WHERE id_social = '$id_social' AND corretora_id = ".CORRETORA." AND ativo = 1";
		$res_excluir = mysqli_query($con, $sql_excluir);
			if(strlen(trim(mysqli_error($con))) == 0 and empty($erro)){
				$ok .= "Evento excluído com sucesso.<br>";
			}else{
				$erro .= "Erro, consulte o administrador do sistema.<br>";
			}
	}
	
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
	<script type="text/javascript">
			function confirma(){
			   var press = confirm("Tem certeza que deseja excluir este Evento ?");
				if(press){
					return true;
				}else{
					return false;
				}
			}
	</script>
	
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
                            <div class="col-md-10 titulo_tela" >Responsabilidade Social</div>
                            <div class="col-md-2 link_tela">
                                 <a href="cadastro_social.php" class="btn btn-info btn-sm">Novo</a>
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
                            <div class="table-responsive">
                                <table class="table table-striped">  
									<thead>
										<tr>
											<th>Posição</th>
											<th>Título</th>
											<th colspan="2">Ações</th>
										</tr>
									</thead>
                                    <tbody>
                                         <?php
                                            $sql = "SELECT id_social, titulo, posicao FROM tbl_social WHERE corretora_id = ".CORRETORA."
											AND ativo = 1 ORDER BY posicao";
                                            $res = mysqli_query($con, $sql);
                                            for($i=0; $i<mysqli_num_rows($res); $i++){
                                                $linha = mysqli_fetch_assoc($res);
												$id_social = $linha['id_social'];
												$titulo    = $linha['titulo'];
												$posicao   = $linha['posicao'];
												
                                                echo "<tr>";
													echo "<td class='col-md-2'>$posicao</td>";
                                                    echo "<td class='col-md-11'>$titulo</td>";
													echo "<td class='col-md-1'><a href='./cadastro_imagens.php?social=$id_social' class='btn btn-warning btn-sm'>Adicionar Imagem</a></td>";
                                                    echo "<td class='col-md-1'><a href='./cadastro_social.php?social=$id_social' class='btn btn-primary btn-sm'>Editar</a></td>";
													echo "<td class='col-md-1'><a href='./listar_social.php?excluir=$id_social' onclick='return confirma()' class='btn btn-danger btn-sm'>Excluir</a></td>";
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