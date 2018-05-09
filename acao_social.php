<?php
	require_once "cabecalho.php";
	include "include/conexao.php";
	include "include/config.php";
	
	$sql = "SELECT *FROM tbl_social
	WHERE corretora_id = ".CORRETORA." AND ativo = 1 ORDER BY posicao";
	$res = mysqli_query($con, $sql);
	
    
?>


 <section>
		<div class="page-header">
			<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<h1> <small>Ações Sociais</small></h1>
						</div>
					</div>
					<?php
						for($i=0; $i<mysqli_num_rows($res); $i++){
							$linha = mysqli_fetch_assoc($res);
							$titulo = $linha['titulo'];
							$texto = $linha['texto'];
							$id_social = $linha['id_social'];
							
							if($i == 0 || $i == 3 || $i == 6 || $i == 9){
								echo '<div class="row">';
							}
									echo '<div class="col-sm-4 col-md-4">';
										$sql_imagem = "SELECT posicao, imagem FROM tbl_social_imagens
										WHERE id_social = $id_social AND corretora_id = ".CORRETORA." AND ativo = 1 ORDER BY posicao";
										$res_imagem = mysqli_query($con, $sql_imagem);
										$l2 = mysqli_fetch_assoc($res_imagem);
												$posicao_img = $l2['posicao'];
												$foto = $l2['imagem'];
												echo "<br>";
												echo "<img width='400' height='100' src='adm/upload/".$foto."' class='img-responsive'>";
											
											echo "<br>";
											echo "<button type='button' class='btn btn-primary btn-lg btn-block' data-toggle='modal' data-target='#myModal".$id_social."'>";
											echo "Veja Fotos";
											echo "</button>";
											
						?>
								<div class="modal fade" id="myModal<?=$id_social?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												  <div class="modal-dialog" role="document">
													<div class="modal-content">
													  <div class="modal-body">
															<?php
																$sql_imagens = "SELECT posicao, imagem FROM tbl_social_imagens
																WHERE id_social = $id_social AND corretora_id = ".CORRETORA." AND ativo = 1 ORDER BY posicao";
																$res_imagens = mysqli_query($con, $sql_imagens);
															?>
															            <div id="sliderprincipal<?=$i?>" class="carousel slide" data-ride="carousel">
																			  <ol class="carousel-indicators">
																				  <?php
																					for($j=0; $j<mysqli_num_rows($res_imagens); $j++){
																						$imagens = mysqli_fetch_assoc($res_imagens);
																						$posicao = $imagens['posicao'];
																						$foto = $linha['imagem'];
																						
																						echo "<li data-target='#sliderprincipal".$i."' data-slide-to='$posicao'></li>";
																					}
																				 ?>
																			  </ol>

																			<div class="carousel-inner" role="listbox">
																				  <?php
																					$sql_foto = "SELECT posicao, imagem FROM tbl_social_imagens
																					WHERE id_social = $id_social AND corretora_id = ".CORRETORA." AND ativo = 1 ORDER BY posicao";
																					$res_foto = mysqli_query($con, $sql_foto);
																					for($k=0; $k<mysqli_num_rows($res_foto); $k++){
																							$l = mysqli_fetch_assoc($res_foto);
																							$foto = $l['imagem'];
																							
																							if($k == 0){
																								echo '<div class="item active">';
																							}else{
																								echo '<div class="item">';
																							}
																							
																							echo "<img src='adm/upload/".$foto."' alt='Imagem slider $k'>";
																							echo '</div>';
																							
																						} 
																				  ?>
																	  

																			  <a class="left carousel-control" href="#sliderprincipal<?=$i?>" role="button" data-slide="prev">
																				<span class="glyphicon glyphicon-chevron-left"></span>
																				<span class="sr-only">Anterior</span>
																			  </a>

																			  <a class="right carousel-control" href="#sliderprincipal<?=$i?>" role="button" data-slide="next">
																				<span class="glyphicon glyphicon-chevron-right"></span>
																				<span class="sr-only">Próximo</span>
																			  </a>
																			</div>
																		</div>
													  </div>
													  <div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
													  </div>
													</div>
												  </div>
											</div>
									
											<?php
						
										echo '<h4 class="text-center">'.$titulo.'</h4>';
										echo '<p class="text-center">'.$texto.'</p>';
									echo '</div>';
							if($i == 2 || $i == 5 || $i == 8 || $i == 11){
								echo '</div>';
							}
						}
						
					?>
			</div>
		</div>
</section>
<?php
	require_once 'rodape.php';
?>



