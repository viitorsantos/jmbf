<?php

	include "include/conexao.php";
	include "include/config.php";
	
	$sql = "SELECT titulo, subtitulo, texto, imagem, tbl_seguros.id_link, tbl_link.link, posicao FROM tbl_seguros
	INNER JOIN tbl_link ON tbl_link.id_link = tbl_seguros.id_link
	WHERE tbl_seguros.corretora_id = ".CORRETORA." AND resposta = 's' AND ativo = 1 ORDER BY posicao";
	$res = mysqli_query($con, $sql);
	
    
?>
	
<script type="text/javascript">
	$(document).ready(function(){
		$('.a').hide();
		$('.i').mouseenter(function(){
			$('.a').show(1000);
		});
	});
</script>

 <section>
		<div class="page-header">
			<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<h1> <small>Conheça nossos seguros</small></h1>
						</div>
					</div>
					
					<?php
						for($i=0; $i<mysqli_num_rows($res); $i++){
							$linha = mysqli_fetch_assoc($res);
							$link = $linha['link'];
							$foto = $linha['imagem'];
							$titulo = $linha['titulo'];
							$subtitulo = $linha['subtitulo'];
							
							if($i == 0 || $i == 3 || $i == 6 || $i == 9){
								echo '<div class="row">';
							}
								echo '<div class="col-sm-4 col-md-4">';
									echo '<a href="'.$link.'"><img src="adm/upload/'.$foto.'" class="img-responsive atividade i"></a>';
									echo '<h4 class="text-center">'.$titulo.'</h4>';
									echo '<p class="text-center">'.$subtitulo.'</p>';
									echo '<div class="col-sm-offset-4 col-md-offset-4">';
										echo '<a href="'.$link.'" class="atividades a">SAIBA MAIS</a>';
									echo'</div>';
								echo '</div>';
							if($i == 2 || $i == 5 || $i == 8 || $i == 11){
								echo '</div>';
							}	
						}
						
					?>
					<br>
					
					<div class='row'>
						<div class='col-md-5'>
							<script type="text/javascript">
								broker="Q3w1MDAwNTU4NDV8MDF8MDUxfDQzMXw="
								img="https://www.hdi.com.br/images/hdi_auto/logo_hdi_calculo.png"
							</script>
							<script src="https://www.hdi.com.br/col/banner_hdi.js"></script>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-offset-5">
							<div class="dropdown center">
								<button type="button" class="btn btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Outros Seguros
								<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<?php 
										$sql_seguros = "SELECT tbl_seguros.id_link, tbl_link.link, titulo FROM tbl_seguros
										INNER JOIN tbl_link ON tbl_link.id_link = tbl_seguros.id_link
										WHERE tbl_seguros.corretora_id = ".CORRETORA." AND ativo = 1 ORDER BY titulo";
										$res_seguros = mysqli_query($con, $sql_seguros);
										for($j=0; $j<mysqli_num_rows($res_seguros); $j++){
											$linha = mysqli_fetch_assoc($res_seguros);
											$link = $linha['link'];
											$titulo = $linha['titulo'];
											echo '<li><a href="'.$link.'" ><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'.$titulo.'</a></li>';
										}
									?>
								</ul>
							</div>
						</div>
					</div>
			</div>
		</div>
</section>