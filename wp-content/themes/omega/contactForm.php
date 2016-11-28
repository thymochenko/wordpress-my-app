  <?php
  
  if( $_SERVER['REQUEST_METHOD'] == 'POST'){
      $nome =  (isset($_POST['name'])) ? filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING) : null;
      $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
      $msg = (isset($_POST['msg'])) ? strip_tags(trim($_POST['msg'])) : null;

      require_once("utils/PHPMailerAutoload.php");
      $mail = new PHPMailer();

      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      //$mail->SMTPDebug = 3;
      $mail->Host = 'smtp.gmail.com';
      $mail->Username = 'timocabralcarvalho@gmail.com';
      $mail->Password = 'a12op34unh';
      $mail->SMTPSecure = "ssl";
      $mail->Port = 465;
      $mail->From = 'timocabralcarvalho@gmail.com';
      $mail->FromName = 'Timo Cabral';
      if(isset($_POST["contact"])){
        $mail->AddAddress("timocabralcarvalho@gmail.com", 'Timo Cabral');
      } else {
        $mail->AddAddress("{$email}", 'Timo Cabral - Desenvolvimento ');
      }

      $mail->IsHTML(true);
      $mail->CharSet  = 'utf-8';

      if(isset($_POST['msg'])){

        $mail->Body .= " nome {$nome} / email: {$email} Mensagem: ". nl2br($_POST['msg'])."<br />";
        $mail->AltBody = 'Para mensagens somente texto';
        echo ($mail->send()) ? "<script>alert('Mensagme enviada com sucesso')</script>" : "error" ;
        header("location: http://localhost/index.php/sucesso/");
       }
       elseif ($_POST['email'] && isset($_POST['msg']) == null) {
         # code...
         $mail->Body .= " Segue o Ebook Solicitado : Desenvolvimento com Docker e Wordpress <br />";
         $mail->Body .= " Atenciosamente: Timo Cabral :) <br />";
         $mail->addStringAttachment(file_get_contents(
           $url="http://localhost/wp-content/uploads/ebooks/ebook-docker.pdf"),
            'ebook-docker-wordpress.pdf'
         );

         $bool =  ($mail->send()) ? "error" : "ok";

         $mail2 = new PHPMailer();

         $mail2->IsSMTP();
         $mail2->SMTPAuth = true;
         $mail2->SMTPDebug = 3;
         $mail2->Host = 'smtp.gmail.com';
         $mail2->Password = 'a12op34unh';
         $mail2->Username = 'timocabralcarvalho@gmail.com';
         $mail2->SMTPSecure = "ssl";
         $mail2->Port = 465;
         $mail2->FromName = 'Timo Cabral';
         $mail2->From = 'timocabralcarvalho@gmail.com';

         $mail2->Body .= " Pedido de Ebook: #{Docker/Wordpress} <br />";
         $mail2->Body .= " email: {$email} <br />";
         $mail2->AddAddress("timocabralcarvalho@gmail.com", 'Timo Cabral');
         return ($mail2->send()) ? "error" : "ok";
      }
  }
