  <?php
  if( $_SERVER['REQUEST_METHOD']=='POST' ){
      $nome = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
      $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
      $msg = strip_tags(trim($_POST['msg']));
      if($msg == ''){
          echo 'Por favor, preencher o campo mensagem.';
      }else{

    require_once("utils/PHPMailerAutoload.php");
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = 2;
    $mail->Host = 'smtp.gmail.com';
    $mail->Username = 'henkosato5@gmail.com';
    $mail->Password = 'stevevai';
    $mail->SMTPSecure = "ssl";
    $mail->Port = 465;
    $mail->From = 'henkosato5@gmail.com';
    $mail->FromName = 'thymochenko';
    $mail->AddAddress('henkosato5@gmail.com', 'thymochenko');
    $mail->IsHTML(true);
    $mail->CharSet  = 'utf-8';

    $mail->Body .= "
    nome {$nome} / email: {$email}
    Mensagem: ". nl2br($_POST['msg'])."<br />";

    $mail->AltBody = 'Para mensagens somente texto';
    if(!$mail->Send()) {
     echo 'Error';
     //echo "Mailer Error: " . $mail->ErrorInfo;
  }else{
     echo 'Send ok';
     unset($msg);
  	 }
    }
  }
