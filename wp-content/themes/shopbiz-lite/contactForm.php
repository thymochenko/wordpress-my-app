  <?php

  if( $_SERVER['REQUEST_METHOD'] == 'POST'){
      var_dump($_POST);
      $nome =  (isset($_POST['nome'])) ? filter_var(trim($_POST["nome"]), FILTER_SANITIZE_STRING) : null;
      $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
      $msg = (isset($_POST['msg'])) ? strip_tags(trim($_POST['msg'])) : null;
      $button_book = (isset($_POST['ebook_hidden'])) ? filter_var(trim($_POST['ebook_hidden']), FILTER_SANITIZE_STRING) : null;
      var_dump($button_book);exit;
      $book_name = substr($button_book, 8);

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
       elseif ($_POST['email'] && isset($_POST['nome']) && isset($_POST['ebook_hidden'])) {
         # code...
         $mail->Body .= " Ola  {$nome}! Segue o Ebook Solicitado :  <br />";
         $mail->Body .= " Atenciosamente: Timo Cabral do timocabral.com:) <br />";
         $mail->addStringAttachment(file_get_contents(
           $url="http://localhost/wp-content/uploads/{$button_book}"),
            "{$book_name}"
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
         $mail2->Body .= " nome: {$nome} <br />";
         $mail2->AddAddress("timocabralcarvalho@gmail.com", 'Timo Cabral');
         return ($mail2->send()) ? "error" : "ok";
      }
  }
