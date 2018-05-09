<?php
	require_once 'cabecalho.php';
	include "include/conexao.php";
	include "include/config.php";
	
	$sql = "SELECT *FROM tbl_apresentacao WHERE corretora_id = ".CORRETORA."";
	$res = mysqli_query($con, $sql);
	$linha = mysqli_fetch_assoc($res);
	$quem_somos = $linha['quem_somos'];
	$missao     = $linha['missao'];
	$visao      = $linha['visao'];
	$valores    = $linha['valores'];
	$foto       = $linha['imagem'];
	$descricao_foto = $linha['descricao_imagem'];
?>

<div class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h1>Quem Somos </h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<p>
					<?=$quem_somos?>
				</p>
			</div>
			<div class="col-sm-4 col-md-4">
				<?php echo '<img src="adm/upload/'.$foto.'" class="img-responsive" id="joao">'?>
				<p>
					<?=$descricao_foto?>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<h1>Missão</h1>
				<p>
					<?=$missao?>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<h1>Visão</h1>
				<p>
					<?=$visao?>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<h1>Valores</h1>
				<p>
					<?=$valores?>
				</p>
			</div>
		</div>
	</div>
</div>
<?php
	require_once 'rodape.php';
?>