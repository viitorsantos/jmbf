<?php
    include "../include/conexao.php";
    include "../include/config.php";
    include "../include/verifica_usuario.php";

	
	if(isset($_GET['endereco'])){
		$id_endereco = $_GET['endereco'];
		$sql_lista = "SELECT *FROM tbl_endereco 
		WHERE id_endereco = '$id_endereco' AND corretora_id = ".CORRETORA."";
		$res_lista = mysqli_query($con, $sql_lista);
		$linha = mysqli_fetch_assoc($res_lista);
		$endereco    = $linha['endereco'];
		$numero      = $linha['numero'];
		$bairro      = $linha['bairro'];
		$cep         = $linha['cep'];
		$cidade      = $linha['cidade'];
		$estado      = $linha['estado'];
		$email       = $linha['email'];
	}

	if(isset($_POST["btnacao"])){
		$id_endereco = $_POST['id_endereco'];
		$endereco    = $_POST['endereco'];
		$numero      = $_POST['numero'];
		$bairro      = $_POST['bairro'];
		$cep         = $_POST['cep'];
		$cidade      = $_POST['cidade'];
		$estado      = $_POST['estado'];
		$email       = $_POST['email'];
		
		if(strlen(trim($endereco)) == 0){
			$erro .= "O Endereço deve ser preenchido.<br>";
		}
		if(strlen(trim($numero)) == 0){
			$erro .= "O Numero deve ser preenchido.<br>";
		}
		if(strlen(trim($bairro)) == 0){
			$erro .= "O Bairro deve ser preenchido.<br>";
		}
		if(strlen(trim($cep)) == 0){
			$erro .= "O CEP deve ser preenchido.<br>";
		}
		if(strlen(trim($cidade)) == 0){
			$erro .= "A Cidade deve ser preenchida.<br>";
		}
		if(strlen(trim($estado)) == 0){
			$erro .= "O Estado deve ser preenchido.<br>";
		}
		if(strlen(trim($email)) == 0){
			$erro .= "O Email deve ser preenchido.<br>";
		}
		
		if(empty($erro)){
			if($id_endereco == 0){
				$sql = "INSERT INTO tbl_endereco(endereco, numero, bairro, cep, cidade, estado, email, corretora_id) 
				VALUES ('$endereco', '$numero', '$bairro', '$cep', '$cidade', '$estado', '$email', ".CORRETORA.")";
			}else{
				$sql = "UPDATE tbl_endereco SET endereco = '$endereco', numero = '$numero', bairro = '$bairro',
				cep = '$cep', cidade = '$cidade', estado = '$estado', email = '$email' WHERE id_endereco = '$id_endereco' AND
				corretora_id = ".CORRETORA."";
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
                            <div class="col-md-10 titulo_tela" >Endereço Corretora</div>
                            <div class="col-md-2 link_tela">
                                 <a href="listar_endereco.php" class="btn btn-info btn-sm">Lista</a>
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
										<div class="col-md-4">
											<label>Endereço*</label>
											<input type="text" class="form-control" name="endereco" value="<?=$endereco?>" maxlength="50" placeholder="Endereço">
										</div>
										<div class="col-md-2">
											<label>Numero*</label>
											<input type="text" class="form-control" name="numero" value="<?=$numero?>" maxlength="6" placeholder="Numero">
										</div>
										<div class="col-md-4">
											<label>Bairro*</label>
											<input type="text" class="form-control" name="bairro" value="<?=$bairro?>" maxlength="30" placeholder="Endereço">
										</div>
										<div class="col-md-2">
											<label>CEP*</label>
											<input type="text" class="form-control" name="cep" value="<?=$cep?>" maxlength="9" placeholder="CEP">
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-offset-2 col-md-3">
											<label>Cidade*</label>
											<input type="text" class="form-control" name="cidade" value="<?=$cidade?>" maxlength="30" placeholder="Cidade">
										</div>
										<div class="col-md-1">
											<label>UF*</label>
											<input type="text" class="form-control" name="estado" value="<?=$estado?>" maxlength="2" placeholder="UF">
										</div>
										<div class="col-md-4">
											<label>Email*</label>
											<input type="email" class="form-control" name="email" value="<?=$email?>" maxlength="40" placeholder="Email">
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-md-12 botao">
											<input class="btn btn-info" type="submit" name="btnacao" value="Gravar">
											<input type="hidden" name="id_endereco" value="<?php echo $id_endereco ?>">
											
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