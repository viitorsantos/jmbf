<?php
	require_once 'cabecalho.php';
	include "include/conexao.php";
	include "include/config.php";
	
	$sql = "SELECT tbl_seguros.id_link, tbl_link.link, titulo, texto, imagem FROM tbl_seguros
	INNER JOIN tbl_link ON tbl_link.id_link = tbl_seguros.id_link
	WHERE link = 'viagem.php' AND tbl_seguros.corretora_id = ".CORRETORA." AND ativo = 1";
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
		<br>
		<div class="row">
			<div class="col-md-offset-3 col-md-2">
				<a href="https://portal.sulamericaseguros.com.br/seguroviagem.htm?ref=eyJkYWRvc1Byb2R1Y2FvIjp7IkFBIjoiMTYzMjQiLCJBViI6IjAiLCJFQSI6IjUzMzU0IiwiRVYiOiIyNjI0NDUxIiwidW9wRW1pc3NhbyI6IjMzNyIsInVvcE5lZ29jaW8iOiI0NjExIn0sImNvcnJldG9yTm9tZSI6IkpNQkYgQ09SUiBERSBTRUdTIExUREEiLCJpZENvcnJldG9yIjoiMTAwODkxIiwicGVyY2VudHVhbENvcnJldGFnZW0iOlt7InBlcmNlbnR1YWxDb3JyZXRhZ2VtIjoiMjAuMDAifSx7InBlcmNlbnR1YWxBZ2VuY2lhbWVudG8iOiIwLjAwIn0seyJwZXJjZW50dWFsUHJlc3RhY2FvU2VydmljbyI6IjAuMDAifSx7ImluZGV4T3BjYW8iOiI1In1dLCJub21lUHJvbW90b3IiOiIifQ==
					" target="_blank">Clique aqui para contratar</a>
			</div>
		</div>
		<br>
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