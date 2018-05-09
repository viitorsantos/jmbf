<?php
    include "../include/conexao.php";
    include "../include/config.php";
    include "../include/verifica_usuario.php";

	
	if(isset($_GET['social'])){
		$id_social = $_GET['social'];
		$id_imagem = $_GET['imagem'];
		$sql_lista = "SELECT posicao, imagem FROM tbl_social_imagens WHERE
		id_imagem = '$id_imagem' AND corretora_id = ".CORRETORA." AND ativo = 1";
		$res_lista = mysqli_query($con, $sql_lista);
		$linha = mysqli_fetch_assoc($res_lista);
		$foto      = $linha['imagem'];
		$posicao_banco  = $linha['posicao'];
	}

	if(isset($_POST["btnacao"])){
		$id_imagem = $_POST['id_imagem'];
		$posicao   = $_POST['posicao'];
		
	   //Upload da Imagem
		$dir = "upload/"; //variavel que armazena onde será feito o upload

		$extensoes = array('jpg', 'png');
		$arquivo = $_FILES['arquivo']; //$_FILES faz referencia a qualquer arquivo enviado ao php
		$file = $dir.$arquivo['name']; //dentro da variavel file está o local onde o upload vai ser salvo
		$ext = strtolower(end(explode(".", $arquivo['name']))); //strtolower tranforma para minusculo e explode pela o ponto e gera um array
		
		if($id_imagem == 0){
			if(strlen(trim($arquivo['name'])) == 0){
				$erro .= "A imagem deve ser carregada.<br>";
			}
			if(array_search($ext, $extensoes) === false){
				$erro .= "O tipo do arquivo esta incorreto. Permitidos apenas imagens(JPG, PNG).<br>";
			}
		}			
		
		if(strlen(trim($posicao)) == 0){
			$erro .= "A posição deve ser preenchida.<br>";
		}
		
		if($posicao != $posicao_banco){
			$sql_verifica = "SELECT posicao, id_social FROM tbl_social_imagens WHERE posicao = '$posicao' 
			AND id_social = $id_social AND corretora_id = ".CORRETORA." AND ativo = 1";
			$res_verifica = mysqli_query($con, $sql_verifica);
			if(mysqli_num_rows($res_verifica) > 0){
				$erro .= "Essa posição já está cadastrada.<br>";
				$posicao = "";
			}
		 }	
		
		if(empty($erro)){
			if(move_uploaded_file($arquivo['tmp_name'], $file)){
				$foto = $arquivo['name'];
			}
			
			if($id_imagem == 0){
				$sql = "INSERT INTO tbl_social_imagens(id_social, imagem, posicao, corretora_id) 
				VALUES ('$id_social', '$foto', '$posicao', ".CORRETORA.")";
			}else{
				$sql = "UPDATE tbl_social_imagens SET id_social = '$id_social', 
				imagem = '$foto', posicao = '$posicao' WHERE id_imagem = '$id_imagem' AND
				corretora_id = ".CORRETORA." AND ativo = 1";
			}
			//echo $sql;
			$res = mysqli_query($con, $sql);
			if(strlen(trim(mysqli_error($con))) == 0 and empty($erro)){
				$ok .= "Cadastro realizado com sucesso.";
			}else{
				$erro .= "Erro, consulte o administrador do sistema.<br>";
			}
				//print_r($_FILES);
		}else{
				//echo "O envio do arquivo falhou!";
				//print_r($_FILES);
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
                            <div class="col-md-8 titulo_tela" >Responsabilidade Social (Imagens)</div>
                            <div class="col-md-1 link_tela">
                                 <a href="listar_social.php" class="btn btn-warning btn-sm">Voltar</a>
                            </div>
							<div class="col-md-1 link_tela">
                                 <a href="cadastro_imagens.php?social=<?=$id_social?>" class="btn btn-success btn-sm">Nova Imagem</a>
                            </div>
							<div class="col-md-1 link_tela">
                                 <a href="listar_imagens.php?social=<?=$id_social?>" class="btn btn-info btn-sm">Lista</a>
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
                                <form method="POST" action="" enctype="multipart/form-data">
									<div class="row">
											<div class="col-md-offset-2 col-md-3">
												<label>Posição da imagem no Evento*</label>
												<select name="posicao" class="form-control">
													<option> </option>
													<option value="1" <?php if($posicao_banco == 1){echo "selected";}?>>1</option>
													<option value="2" <?php if($posicao_banco == 2){echo "selected";}?>>2</option>
													<option value="3" <?php if($posicao_banco == 3){echo "selected";}?>>3</option>
													<option value="4" <?php if($posicao_banco == 4){echo "selected";}?>>4</option>
													<option value="5" <?php if($posicao_banco == 5){echo "selected";}?>>5</option>
													<option value="6" <?php if($posicao_banco == 6){echo "selected";}?>>6</option>
												</select>
											</div>
											<div class="col-md-4">
											<label>Imagem<h6>Inserir imagem de Largura=280pixels Altura=187pixels</h6></label>
											<div method="POST"> 
														Selecione a Imagem 
														<input type="file" name="arquivo">
														<input type="hidden" name="MAX_FILE_SIZE" value="1000" /> <!--Poderá enviar para o servidor no maximo 30MB-->
														<?php echo "Imagem: ".$foto;?>
											</div>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-12 botao">
											<input class="btn btn-info" type="submit" name="btnacao" value="Gravar">
											<input type="hidden" name="id_imagem" value="<?php echo $id_imagem ?>">
											
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