<?php

	include "include/conexao.php";
	include "include/config.php";
	
	$sql = "SELECT imagem, posicao FROM tbl_slider WHERE corretora_id = ".CORRETORA." AND ativo = 1 ORDER BY posicao";
	$res = mysqli_query($con, $sql);
	
    
?>
<!--SLIDER DA APLICAÇÃO -->
    <div class="divSlider">
      <div class="container">
        <div class="col-xs-12">
            <div id="sliderprincipal" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
				  <?php
					for($i=0; $i<mysqli_num_rows($res); $i++){
						$linha = mysqli_fetch_assoc($res);
						$posicao = $linha['posicao'];
						$foto = $linha['imagem'];
						
						echo "<li data-target='#sliderprincipal' data-slide-to='$posicao'></li>";
					}
				 ?>
              </ol>

              <div class="carousel-inner" role="listbox">
				  <?php
					$sql_foto = "SELECT imagem, posicao FROM tbl_slider WHERE corretora_id = ".CORRETORA." AND ativo = 1 ORDER BY posicao";
					$res_foto = mysqli_query($con, $sql_foto);
					for($i=0; $i<mysqli_num_rows($res_foto); $i++){
							$linha = mysqli_fetch_assoc($res_foto);
							$foto = $linha['imagem'];
							
							if($i == 0){
								echo '<div class="item active">';
							}else{
								echo '<div class="item">';
							}
							
							echo "<img src='adm/upload/".$foto."' alt='Imagem slider $i'>";
							echo '</div>';
							
						} 
				  ?>
      
              </div>

              <a class="left carousel-control" href="#sliderprincipal" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Anterior</span>
              </a>

              <a class="right carousel-control" href="#sliderprincipal" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Próximo</span>
              </a>
            </div>
          </div>
        </div>
    </div>
    <!-- FIM SLIDER DA APLICAÇÃO -->