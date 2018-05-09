<?php
    include "../include/conexao.php";
    include "../include/config.php";
    include "../include/verifica_usuario.php";

	
	if(isset($_GET['parceiro'])){
		$id_parceiro = $_GET['parceiro'];
		$sql_lista = "SELECT nome, link, imagem FROM tbl_parceiros WHERE
		id_parceiro = '$id_parceiro' AND corretora_id = ".CORRETORA." AND ativo = 1";
		$res_lista = mysqli_query($con, $sql_lista);
		$linha = mysqli_fetch_assoc($res_lista);
		$nome  = $linha['nome'];
		$link  = $linha['link'];
		$foto  = $linha['imagem'];
	}

	if(isset($_POST["btnacao"])){
		$id_parceiro = $_POST['id_parceiro'];
		$nome        = $_POST['nome'];
		$link        = $_POST['link'];
	
	   //Upload da Imagem
		$dir = "upload/"; //variavel que armazena onde será feito o upload

		$extensoes = array('jpg', 'png');
		$arquivo = $_FILES['arquivo']; //$_FILES faz referencia a qualquer arquivo enviado ao php
		$file = $dir.$arquivo['name']; //dentro da variavel file está o local onde o upload vai ser salvo
		$ext = strtolower(end(explode(".", $arquivo['name']))); //strtolower tranforma para minusculo e explode pela o ponto e gera um array
		
		if($id_parceiro == 0){
			if(strlen(trim($arquivo['name'])) == 0){
				$erro .= "A imagem deve ser carregada.<br>";
			}
			if(array_search($ext, $extensoes) === false){
				$erro .= "O tipo do arquivo esta incorreto. Permitidos apenas imagens(JPG, PNG).<br>";
			}
		}
				
		if(strlen(trim($nome)) == 0){
			$erro .= "O nome do parceiro deve ser preenchida.<br>";
		}
			
		if(empty($erro)){
			if(move_uploaded_file($arquivo['tmp_name'], $file)){
				$foto = $arquivo['name'];
			}
			if($id_parceiro == 0){
				$sql = "INSERT INTO tbl_parceiros(nome, link, imagem, corretora_id) 
				VALUES ('$nome', '$link', '$foto', ".CORRETORA.")";
			}else{
				$sql = "UPDATE tbl_parceiros SET nome = '$nome', link = '$link', imagem = '$foto'
				WHERE id_parceiro = '$id_parceiro' AND corretora_id = ".CORRETORA." AND ativo = 1";
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
                            <div class="col-md-10 titulo_tela" >Parceiros</div>
                            <div class="col-md-2 link_tela">
                                 <a href="listar_parceiros.php" class="btn btn-info btn-sm">Lista</a>
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
										<div class="col-md-offset-2 col-md-4">
											<label>Nome Parceiro*</label>
											<input type="text" class="form-control" name="nome" value="<?=$nome?>" maxlength="50" placeholder="Nome">
										</div>
										<div class="col-md-4">
											<label>Link Site</label>
											<input type="text" class="form-control" name="link" value="<?=$link?>" maxlength="50" placeholder="Link">
										</div>
									</div>
									<br>
									
                                    <div class="row">
										<div class="col-md-offset-4 col-md-4">
											<label>Imagem*<h6>Inserir imagem de Largura=660pixels Altura=660pixels</h6></label>
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
											<input type="hidden" name="id_parceiro" value="<?php echo $id_parceiro ?>">
											
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