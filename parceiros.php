<?php
	require_once 'cabecalho.php';
	include "include/conexao.php";
	include "include/config.php";
	
	$sql = "SELECT nome, link, imagem FROM tbl_parceiros
	WHERE corretora_id = ".CORRETORA." AND ativo = 1 ORDER BY nome";
	$res = mysqli_query($con, $sql);
	

?>
<div class="page-header ">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h1>Seguradoras</h1>
				</div>
			</div>
			<?php
				for($i=0; $i<mysqli_num_rows($res); $i++){
					$linha = mysqli_fetch_assoc($res);
					$nome  = $linha['nome'];
					$link  = $linha['link'];
					$foto  = $linha['imagem'];
					
					echo '<div class="col-sm-2">';
						echo '<div>';
							echo '<a href="'.$link.'" target="_blank">';
							echo '<div><img src="adm/upload/'.$foto.'" class="img-responsive parceiros"></div>';
							echo '</a>';
							echo '<h4 class="text-center">'.$nome.'</h4>';
						echo '</div>';
					echo'</div>';	
				}
			
			?>
		</div>
</div>
<?php
	require_once 'rodape.php';
?>