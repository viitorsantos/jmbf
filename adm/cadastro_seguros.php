<?php
    include "../include/conexao.php";
    include "../include/config.php";
    include "../include/verifica_usuario.php";

	
	if(isset($_GET['seguro'])){
		$id_seguro = $_GET['seguro'];
		$sql_lista = "SELECT resposta, titulo, subtitulo, texto, posicao, imagem, id_link FROM tbl_seguros WHERE
		id_seguro = '$id_seguro' AND corretora_id = ".CORRETORA." AND ativo = 1";
		$res_lista = mysqli_query($con, $sql_lista);
		$linha = mysqli_fetch_assoc($res_lista);
		$resposta  = $linha['resposta'];
		$titulo    = $linha['titulo'];
		$subtitulo = $linha['subtitulo'];
		$texto     = $linha['texto'];
		$foto      = $linha['imagem'];
		$posicao_banco  = $linha['posicao'];
		$id_link   = $linha['id_link'];
	}

	if(isset($_POST["btnacao"])){
		$id_seguro = $_POST['id_seguro'];
		$resposta  = $_POST['resposta'];
		$titulo    = $_POST['titulo'];
		$subtitulo = $_POST['subtitulo'];
		$texto     = $_POST['texto'];
		$posicao   = $_POST['posicao'];
		$id_link   = $_POST['link'];
	
	   //Upload da Imagem
		$dir = "upload/"; //variavel que armazena onde será feito o upload

		$extensoes = array('jpg', 'png');
		$arquivo = $_FILES['arquivo']; //$_FILES faz referencia a qualquer arquivo enviado ao php
		$file = $dir.$arquivo['name']; //dentro da variavel file está o local onde o upload vai ser salvo
		$ext = strtolower(end(explode(".", $arquivo['name']))); //strtolower tranforma para minusculo e explode pela o ponto e gera um array
		
		if($id_seguro == 0){
			if(strlen(trim($arquivo['name'])) == 0){
				$erro .= "A imagem deve ser carregada.<br>";
			}
			if(array_search($ext, $extensoes) === false){
				$erro .= "O tipo do arquivo esta incorreto. Permitidos apenas imagens(JPG, PNG).<br>";
			}
		}			
		
		if(strlen(trim($resposta)) == 0){
			$erro .= "A resposta deve ser preenchida.<br>";
		}
		if(strlen(trim($titulo)) == 0){
			$erro .= "O título deve ser preenchido.<br>";
		}
		if($id_seguro == 0 && $resposta == 's'){
			if(strlen(trim($posicao)) == 0){
				$erro .= "A posição deve ser preenchida.<br>";
			}
		}
		
		if($resposta == 's'){
			if($posicao != $posicao_banco){
				$sql_verifica = "SELECT posicao FROM tbl_seguros WHERE posicao = '$posicao' 
				AND corretora_id = ".CORRETORA." AND ativo = 1";
				$res_verifica = mysqli_query($con, $sql_verifica);
				if(mysqli_num_rows($res_verifica) > 0){
					$erro .= "Essa posição já está cadastrada.<br>";
					$posicao = "";
				}
		   }	
		}
		
		if($resposta == 'n'){
			$posicao = "";
		}
			
		if(strlen(trim($texto)) == 0){
			$erro .= "O texto deve ser preenchido.<br>";
		}
		
		if(empty($erro)){
			if(move_uploaded_file($arquivo['tmp_name'], $file)){
				$foto = $arquivo['name'];
			}
			if($id_seguro == 0){
				$sql = "INSERT INTO tbl_seguros(resposta, titulo, subtitulo, texto, imagem, posicao, id_link, corretora_id) 
				VALUES ('$resposta', '$titulo', '$subtitulo', '$texto', '$foto', '$posicao', '$id_link', ".CORRETORA.")";
			}else{
				$sql = "UPDATE tbl_seguros SET resposta = '$resposta', titulo = '$titulo', subtitulo = '$subtitulo', texto = '$texto',
				imagem = '$foto', posicao = '$posicao', id_link = $id_link WHERE id_seguro = '$id_seguro' AND
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
		<link rel="stylesheet" type="text/css" href="../editor/bootstrap3-wysihtml5.min.css"></link>
		<script src="../js/jquery-1.11.3.min.js"></script>
		
    </head>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('div #link').hide();
			$('div #posicao').hide();
			$('#resposta').change(function(){
				var resp = $('#resposta').val();
				if(resp == 's'){
					$('div #posicao').show(1000);
				}else{
					$('div #posicao').hide(1000);
				}
			});
			
			var resp = $('#resposta').val();
			if(resp == 's'){
				$('div #posicao').show();
			}
			
		});
		
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
                            <div class="col-md-10 titulo_tela" >Seguros</div>
                            <div class="col-md-2 link_tela">
                                 <a href="listar_seguros.php" class="btn btn-info btn-sm">Lista</a>
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
										<div class="col-md-offset-3 col-md-3">
											<label>Este seguro vai aparecer na página inicial ?*</label>
											<select name="resposta" id="resposta" class="form-control">
												<option></option>
												<option value="s"<?php if($resposta == 's'){echo "selected";}?>>Sim</option>
												<option value="n"<?php if($resposta == 'n'){echo "selected";}?>>Não</option>
											</select>
										</div>
										<div id="posicao">
											<div class="col-md-2">
												<label>Posição da imagem no site</label>
												<select name="posicao" class="form-control">
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
													<option value="11" <?php if($posicao_banco == 11){echo "selected";}?>>11</option>
													<option value="12" <?php if($posicao_banco == 12){echo "selected";}?>>12</option>
												</select>
											</div>
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-4">
											<label>Titulo*</label>
											<input type="text" class="form-control" name="titulo" value="<?=$titulo?>" maxlength="50" placeholder="Título">
										</div>
										<div class="col-md-8">
											<label>SubTitulo</label>
											<input type="text" class="form-control" name="subtitulo" value="<?=$subtitulo?>" maxlength="70" placeholder="SubTítulo">
										</div>
									</div>
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
									
                                    <div class="row">
										<div class="col-md-offset-4 col-md-4">
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
									<div class="row" id="link">
										<div class="col-md-offset-4 col-md-4">
											<label>Link</label>
											<select name="link" class="form-control">
												<option></option>
												<?php
													$sql_link = "SELECT id_link, link FROM tbl_link WHERE corretora_id = ".CORRETORA." ORDER BY link";
													$res_link = mysqli_query($con, $sql_link);
													for($i=0; $i<mysqli_num_rows($res_link); $i++){
														$linha = mysqli_fetch_assoc($res_link);
														$link_banco = $linha['id_link'];
														$link = $linha['link'];
										
														if($id_link == $link_banco){
															$selected = "selected";
														}else{
															$selected = "";
														}
														echo "<option value='$link_banco' $selected> $link </option>";
													}
													
												?>
											</select>
										</div>
									</div>
									
									<br>
									<div class="row">
										<div class="col-md-12 botao">
											<input class="btn btn-info" type="submit" name="btnacao" value="Gravar">
											<input type="hidden" name="id_seguro" value="<?php echo $id_seguro ?>">
											
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