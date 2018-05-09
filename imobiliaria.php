<?php
	require_once 'cabecalho.php';
	include "include/conexao.php";
	include "include/config.php";
	
	$sql = "SELECT tbl_seguros.id_link, tbl_link.link, titulo, texto, imagem FROM tbl_seguros
	INNER JOIN tbl_link ON tbl_link.id_link = tbl_seguros.id_link
	WHERE link = 'imobiliaria.php' AND tbl_seguros.corretora_id = ".CORRETORA." AND ativo = 1";
	$res = mysqli_query($con, $sql);
	$linha = mysqli_fetch_assoc($res);
	$titulo = $linha['titulo'];
	$texto  = $linha['texto'];
	$foto   = $linha['imagem'];
?>

<script type="text/javascript">
	$(document).ready(function(){
		$('div .contato').hide();
		$('div .contato').show(5000);
	});
 </script>

<div class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h1><?=$titulo?></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<br>
				<p>
					<?=$texto?>
				</p>
			</div>
			<div class="col-sm-4 col-md-4">
				<?php echo'<img src="adm/upload/'.$foto.'" class="img-responsive">'?>
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-md-offset-3 contato">
				<a href="contato.php">Entre em Contato - Clique aqui</a>
			</div>
		</div>
	</div>
</div>
<?php
	require_once 'rodape.php';
?>