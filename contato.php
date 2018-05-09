<?php
  require_once 'cabecalho.php';
  include "include/conexao.php";
  include "include/config.php";
	
	$sql = "SELECT *FROM tbl_endereco WHERE corretora_id = ".CORRETORA."";
	$res = mysqli_query($con, $sql);
	$linha = mysqli_fetch_assoc($res);
	$endereco    = $linha['endereco'];
	$numero      = $linha['numero'];
	$bairro      = $linha['bairro'];
	$cep         = $linha['cep'];
	$cidade      = $linha['cidade'];
	$estado      = $linha['estado'];
	$email_contato  = $linha['email'];
?>

<script type="text/javascript">
  $(document).ready(function(){
    $('div .corretor').hide();
    $('div .corretor').show(5000);
  });
 </script>


<?php
 session_start();

  if(isset($_POST["btnacao"])){
    $nome = $_POST['nome'];
    $email = $_POST["email"];
    $telefone = $_POST['telefone'];
    $msg = $_POST["mensagem"];

   session_start();  
 
  if ( $_POST["codigo"] == $_SESSION["codigo"] )
  {
    
  }
  else
  {
     $erro .= "Código Errado"; //Validando Captcha
  } 
  
    if(strlen(trim($nome))==0){
      $erro .= "Por favor preencher o Nome. <br>";
    }

    if(strlen(trim($email))==0){
      $erro .= "Por favor preencher a E-mail";
    }
    
    if(strlen(trim($telefone))==0){
      $erro .= "Por favor preencher o Telefone";
    }

    if(strlen(trim($msg))==0){
      $erro .= "Por favor preencher a Mensagem.";
    }

    if(strlen(trim($erro))==0){

      $mensagem = "Nome: $nome <br> 
              E-mail: $email <br>
              Telefone: $telefone <br>
              Mensagem:  $msg <br>";

      //REMETENTE --> ESTE EMAIL TEM QUE SER VALIDO DO DOMINIO
      //==================================================== 
      $email_remetente = "contato@jmbfseguros.com.br"; // deve ser uma conta de email do seu dominio 
      //====================================================
      
      //Configurações do email, ajustar conforme necessidade
      //==================================================== 
      $email_destinatario = "contato@jmbfseguros.com.br, joao@jmbfseguros.com.br"; // pode ser qualquer email que receberá as mensagens
      $email_reply = "$email"; 
      $email_assunto = "Contato Site JMBF"; // Este será o assunto da mensagem
      //====================================================
      
      //Seta os Headers (Alterar somente caso necessario) 
      //==================================================== 
      $email_headers = implode ( "\n",array ( "From: $email_remetente", "Reply-To: $email", "Subject: $email_assunto","Return-Path: $email_remetente","MIME-Version: 1.0","X-Priority: 3","Content-Type: text/html; charset=UTF-8" ) );
      //====================================================
      
      //Enviando o email 
      mail ($email_destinatario, $email_assunto, $mensagem, $email_headers);

      $ok = "Mensagem enviada com sucesso. <br>";
    }
  }

?>


    <!-- FALE CONOSCO -->
    <div class="page-header">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <div class="col-md-3">
                <h1>Fale Conosco</h1>
           <small>* campos de preenchimento obrigatório.</small>
               </div>
               <div class="col-md-offset-8 corretor">
                  Fale direto com o Corretor <br>
                  <!--<img src="imagens/tel.png" class="sociais"> 14 - 3417 8313 / -->
                  <img src="imagens/whats.png" class="sociais"> 14 - 99800 3195
               </div>
            </div>
          </div>
        <hr>

        <?php 
          if(strlen(trim($erro))>0){
            echo "<div class='alert alert-danger' role='alert'>
                  <a href='#' class='alert-link'>$erro</a>
                  </div>";
          }

          if(strlen(trim($ok))>0){
            echo "<div class='alert alert-success' role='alert'>
                  <a href='#' class='alert-link'>$ok</a>
                  </div>";
          }
        ?> 

        <div class="row">
          <div class="col-xs-12">
            <form action="" method="POST" name="frmContato" id="formContato">
              <div class="row">
                <div class="col-sm-6 col-md-6">
                  <div class="form-group">
                    <input type="text" class="form-control input-lg" placeholder="Nome*" name='nome' value="<?php echo $nome ?>" required>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control input-lg" placeholder="E-mail*" name='email'  value="<?php echo $email ?>" required>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control input-lg" name='telefone'  maxlength="13" value="<?php echo $telefone ?>" placeholder="Telefone*" required>
                  </div>
                  <div class="form-group">
                    <textarea class="form-control input-lg" name='mensagem' placeholder="Sua mensagem! *" required><?php echo $msg ?></textarea>
                  </div>  
                  <div class="form-group">
          <button type="submit" class="btn btn-default btn-lg" name="btnacao">Enviar</button>
                  </div>
                </div>

                <div class="col-sm-6 col-md-6">
                  <div class="end_1"><?php echo $endereco.",".$numero." ".$bairro." ".$cep." ".$cidade."/".$estado;?> </div>
                  <div class="end_1">E-mail: <?php echo $email_contato;?></div>
                </div>

              </div>
            </form>
          </div>
        </div>
       </div> 

        <div class="row">
          <div class="col-xs-12">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3693.158927835002!2d-49.93848658548507!3d-22.234048019799893!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94bfd0ab3a7bb313%3A0x30c8a25cd05a9199!2sR.+Jorge+Bernardoni%2C+723+-+Jardim+Itaipu%2C+Mar%C3%ADlia+-+SP!5e0!3m2!1spt-BR!2sbr!4v1454080363373" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
          </div>
        </div>
     </div>
 
    <!-- FIM FALE CONOSCO -->
    <?php
      require_once ("rodape.php");
    ?>