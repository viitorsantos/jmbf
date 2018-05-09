<?php
    include "../include/conexao.php";
    include "../include/config.php";
    include "../include/verifica_usuario.php";

	
	if(isset($_GET['apresentacao'])){
		$id_apresentacao = $_GET['apresentacao'];
		$sql_lista = "SELECT *FROM tbl_apresentacao 
		WHERE id_apresentacao = '$id_apresentacao' AND corretora_id = ".CORRETORA."";
		$res_lista = mysqli_query($con, $sql_lista);
		$linha = mysqli_fetch_assoc($res_lista);
		$quem_somos  = $linha['quem_somos'];
		$foto        = $linha['imagem'];
		$descricao_foto = $linha['descricao_imagem'];
		$missao    = $linha['missao'];
		$visao     = $linha['visao'];
		$valores   = $linha['valores'];
	}

	if(isset($_POST["btnacao"])){
		$id_apresentacao = $_POST['id_apresentacao'];
		$quem_somos      = $_POST['quem_somos'];
		$missao          = $_POST['missao'];
		$visao           = $_POST['visao'];
		$valores         = $_POST['valores'];
		$descricao_foto  = $_POST['descricao_foto'];
	
	   //Upload da Imagem
		$dir = "upload/"; //variavel que armazena onde será feito o upload

		$extensoes = array('jpg', 'png', '');
		$arquivo = $_FILES['arquivo']; //$_FILES faz referencia a qualquer arquivo enviado ao php
		$file = $dir.$arquivo['name']; //dentro da variavel file está o local onde o upload vai ser salvo
		$ext = strtolower(end(explode(".", $arquivo['name']))); //strtolower tranforma para minusculo e explode pela o ponto e gera um array
		
		if(array_search($ext, $extensoes) === false){
			$erro .= "O tipo do arquivo esta incorreto. Permitidos apenas imagens(JPG, PNG).<br>";
		}			
		
		if(strlen(trim($quem_somos)) == 0){
			$erro .= "O texto Quem Somos deve ser preenchido.<br>";
		}
		if(strlen(trim($missao)) == 0){
			$erro .= "O texto Missão deve ser preenchido.<br>";
		}
		if(strlen(trim($visao)) == 0){
			$erro .= "O texto Visão deve ser preenchido.<br>";
		}
		if(strlen(trim($valores)) == 0){
			$erro .= "O texto Valores deve ser preenchido.<br>";
		}
		
		if(empty($erro)){
			if(move_uploaded_file($arquivo['tmp_name'], $file)){
				$foto = $arquivo['name'];
			}
			if($id_apresentacao == 0){
				$sql = "INSERT INTO tbl_apresentacao(quem_somos, imagem, descricao_imagem, missao, visao, valores, corretora_id) 
				VALUES ('$quem_somos', '$foto', '$descricao_foto', '$missao', '$visao', '$valores', ".CORRETORA.")";
			}else{
				$sql = "UPDATE tbl_apresentacao SET quem_somos = '$quem_somos', imagem = '$foto', descricao_imagem = '$descricao_foto',
				missao = '$missao', visao = '$visao', valores = '$valores' WHERE id_apresentacao = '$id_apresentacao' AND
				corretora_id = ".CORRETORA."";
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
                            <div class="col-md-2 link_tela">
                                 <a href="listar_apresentacao.php" class="btn btn-info btn-sm">Lista</a>
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
									  <label>Quem Somos*</label>
										<div class="form-group">
											  <textarea name='quem_somos' class="textarea" placeholder="Enter text ..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px;">
														
														<?php
															echo $quem_somos;
														?>
													
											  </textarea>
										 </div>
									</div>
									<br>
									<div class="row">
									  <label>Missão*</label>
										<div class="form-group">
											  <textarea name='missao' class="textarea" placeholder="Enter text ..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px;">
														
														<?php
															echo $missao;
														?>
													
											  </textarea>
										 </div>
									</div>
									<br>
									<div class="row">
									  <label>Visão*</label>
										<div class="form-group">
											  <textarea name='visao' class="textarea" placeholder="Enter text ..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px;">
														
														<?php
															echo $visao;
														?>
													
											  </textarea>
										 </div>
									</div>
									<br>
									<div class="row">
									  <label>Valores*</label>
										<div class="form-group">
											  <textarea name='valores' class="textarea" placeholder="Enter text ..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px;">
														
														<?php
															echo $valores;
														?>
													
											  </textarea>
										 </div>
									</div>
									<br>
									
                                    <div class="row">
										<div class="col-md-offset-4 col-md-4">
											<label>Imagem*<h6>Inserir imagem de Largura=312pixels Altura=533pixels</h6></label>
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
									  <label>Descrição foto</label>
										<div class="form-group">
											  <textarea name='descricao_foto' class="textarea" placeholder="Enter text ..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px;">
														
														<?php
															echo $descricao_foto;
														?>
													
											  </textarea>
										 </div>
									</div>
									
									<br>
									<div class="row">
										<div class="col-md-12 botao">
											<input class="btn btn-info" type="submit" name="btnacao" value="Gravar">
											<input type="hidden" name="id_apresentacao" value="<?php echo $id_apresentacao ?>">
											
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