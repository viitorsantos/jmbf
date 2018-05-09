<?php
    include "../include/conexao.php";
    include "../include/config.php";
    include "../include/verifica_usuario.php";

	
	if(isset($_GET['social'])){
		$id_social = $_GET['social'];
		$sql_lista = "SELECT titulo, texto, posicao FROM tbl_social WHERE
		id_social = '$id_social' AND corretora_id = ".CORRETORA." AND ativo = 1";
		$res_lista = mysqli_query($con, $sql_lista);
		$linha = mysqli_fetch_assoc($res_lista);
		$titulo    = $linha['titulo'];
		$texto     = $linha['texto'];
		$posicao_banco  = $linha['posicao'];
	}
	
	if(isset($_POST["btnacao"])){
		$id_social = $_POST['id_social'];
		$titulo    = $_POST['titulo'];
		$texto     = $_POST['texto'];
		$posicao   = $_POST['posicao'];
	
		
		if(strlen(trim($posicao)) == 0){
			$erro .= "A posição deve ser preenchida.<br>";
		}
		
		if($posicao != $posicao_banco){
			$sql_verifica = "SELECT posicao FROM tbl_social WHERE posicao = '$posicao' 
				AND corretora_id = ".CORRETORA." AND ativo = 1";
				$res_verifica = mysqli_query($con, $sql_verifica);
				if(mysqli_num_rows($res_verifica) > 0){
					$erro .= "Essa posição já está cadastrada";
					$posicao = "";
				}
		 }
		
		if(strlen(trim($titulo)) == 0){
			$erro .= "O título deve ser preenchido.<br>";
		}
		if(strlen(trim($texto)) == 0){
			$erro .= "O texto deve ser preenchido.<br>";
		}
		
		if(empty($erro)){
			if($id_social == 0){
				$sql = "INSERT INTO tbl_social(titulo, texto, posicao, corretora_id) 
				VALUES ('$titulo', '$texto', '$posicao', ".CORRETORA.")";
			}else{
				$sql = "UPDATE tbl_social SET titulo = '$titulo', texto = '$texto', posicao = '$posicao'
				WHERE id_social = '$id_social' AND corretora_id = ".CORRETORA." AND ativo = 1";
			}
			//echo $sql;
			$res = mysqli_query($con, $sql);
			if(strlen(trim(mysqli_error($con))) == 0 and empty($erro)){
				$ok .= "Cadastro realizado com sucesso.";
			}else{
				$erro .= "Erro, consulte o administrador do sistema.<br>";
			}
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
		<link rel="stylesheet" type="text/css" href="../editor/bootstrap3-wysihtml5.min.css"></link>
		<script src="../js/jquery-1.11.3.min.js"></script>
		
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
                            <div class="col-md-10 titulo_tela" >Responsabilidade Social</div>
                            <div class="col-md-2 link_tela">
                                 <a href="listar_social.php" class="btn btn-info btn-sm">Lista</a>
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
                                <form method="POST" action="" >
									<div class="row">
										<div class="col-md-offset-2 col-md-3">
											<label>Posição o texto no site*</label>
											<select name="posicao" class="form-control" id="posicao">
												<option> </option>
												<option value="1" <?php if($posicao_banco == 1){echo "selected";}?>>1</option>
												<option value="2" <?php if($posicao_banco == 2){echo "selected";}?>>2</option>
												<option value="3" <?php if($posicao_banco == 3){echo "selected";}?>>3</option>
												<option value="4" <?php if($posicao_banco == 4){echo "selected";}?>>4</option>
												<option value="5" <?php if($posicao_banco == 5){echo "selected";}?>>5</option>
												<option value="6" <?php if($posicao_banco == 6){echo "selected";}?>>6</option>
												<option value="7" <?php if($posicao_banco == 7){echo "selected";}?>>7</option>
												<option value="8" <?php if($posicao_banco == 8){echo "selected";}?>>8</option>
												<option value="9" <?php if($posicao_banco == 9){echo "selected";}?>>9</option>
												<option value="10" <?php if($posicao_banco == 10){echo "selected";}?>>10</option>
												</select>
										</div>
										<div class="col-md-4">
											<label>Titulo*</label>
											<input type="text" class="form-control" name="titulo" value="<?=$titulo?>" maxlength="50" placeholder="Título">
										</div>
									</div>
									<br>
									<br>
									<div class="row">
									  <label>Texto*</label>
										<div class="form-group">
											  <textarea name='texto' class="textarea" placeholder="Enter text ..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px;">
														
														<?php
															echo $texto;
														?>
													
											  </textarea>
										 </div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-12 botao">
											<input class="btn btn-info" type="submit" name="btnacao" value="Gravar">
											<input type="hidden" name="id_social" value="<?php echo $id_social ?>">
											
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
			<script src="../editor/wysihtml5x-toolbar.min.js"></script>
			<script src="../editor/runtime.min.js"></script>
			<script src="../editor/bootstrap3-wysihtml5.min.js"></script>

			<script>
			  $('.textarea').wysihtml5();
			</script>
        </div>
    </body>
</html>