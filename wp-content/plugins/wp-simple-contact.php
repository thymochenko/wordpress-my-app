<?php
/**
 * @package Hello_Dolly
 * @version 1.6
 */
/*
Plugin Name: wp-simple-contact
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: Ai que demais.
Author: Timo Cabral
Version: 1.0
Author URI: http://timocabral.com/
*/

require_once 'news.core.php';
require_once("utils/PHPMailerAutoload.php");


GLOBAL $wpdb;
if(@$_POST['method'] == 'newslleter'){
  $news = new Newslleter();
//$news->name = $_POST['nome'];
  $news->email = $_POST['email'];
//$news->email = 'henkosato5@gmail.com';
  $news->ip = $_SERVER['SERVER_ADDR'];
  $news->status = Newslleter::STATUS['active_newslleter'];
  $news->date_created = current_time( 'mysql' );
  $news->date_updated = current_time( 'mysql' );
//$news->ebook_hidden = "kkkk";

  $dataProvider = new NewslleterDataProvider($news);
  $dataProvider->setReturnType('array');
  $dao = new DaoNewslleter($wpdb);
  $dao->setDataProvider($dataProvider);
  $dao->setTable('newslleter_contact');
  $dao->store();

  $mail = new MailSender($dataProvider);
  $mail->send(function() use ($mail){
  $mailWrapper = $mail->phpMailerWrapper(new PHPMailer());
  $mailWrapper->IsSMTP();
  $mailWrapper->SMTPAuth = true;
  $mailWrapper->SMTPDebug = 0;
  $mailWrapper->Host = 'smtp.gmail.com';
  $mailWrapper->Password = 'a12op34unh';
  $mailWrapper->Username = 'timocabralcarvalho@gmail.com';
  $mailWrapper->SMTPSecure = "ssl";
  $mailWrapper->Port = 465;
  $mailWrapper->FromName = 'Timo Cabral';
  $mailWrapper->From = 'timocabralcarvalho@gmail.com';

  $mailWrapper->Body .= " ASSINANTE NEWSLLETER <br />";
  $mailWrapper->Body .= " email: {$mail->getData()['email']} <br />";
  $mailWrapper->AddAddress("timocabralcarvalho@gmail.com", "Timo Cabral");
  //var_dump($mail->getData()['name']);
  $mailWrapper->send();
  });
}elseif(@$_POST['method'] == 'ebook'){
    //domain object
    $news = new Newslleter();
    $news->name = $_POST['nome'];
    $news->email = $_POST['email'];
    $news->ip = $_SERVER['SERVER_ADDR'];
    $news->status = Newslleter::STATUS['ebook_request'];
    $news->date_created =  date("Y-m-d H:i:s");
    $news->date_updated =  date("Y-m-d H:i:s");
    $news->ebookHidden = $_POST['ebook_hidden'];
    //data provider
    $dataProvider = new NewslleterDataProvider($news);
    $dataProvider->setReturnType('array');
    //DAO
    $dao = new DaoNewslleter($wpdb);
    $dao->setDataProvider($dataProvider);
    $dao->setTable('newslleter_contact');
    $dao->store();

    $mail = new MailSender($dataProvider);
    $mail->send(function() use ($mail){
    $mailWrapper = $mail->phpMailerWrapper(new PHPMailer());
    $mailWrapper->IsSMTP();
    $mailWrapper->SMTPAuth = true;
    $mailWrapper->SMTPDebug = 0;
    $mailWrapper->Host = 'smtp.gmail.com';
    $mailWrapper->Password = 'a12op34unh';
    $mailWrapper->Username = 'timocabralcarvalho@gmail.com';
    $mailWrapper->SMTPSecure = "ssl";
    $mailWrapper->Port = 465;
    $mailWrapper->FromName = 'Timo Cabral';
    $mailWrapper->From = $email;
    //formatando mensagem
    $mailWrapper->Body .= " ASSINANTE NEWSLLETER <br />";
    $mailWrapper->Body .= " email: {$mail->getData()['email']} <br />";
    $mailWrapper->AddAddress("timocabralcarvalho@gmail.com", "Timo Cabral");
    //var_dump($mail->getData()['name']);
    $mailWrapper->send();
    //mandando o ebook
    //var_dump($mail->getData());exit;
    $whapper2 = $mail->phpMailerWrapper(new PHPMailer());
    $whapper2->IsSMTP();
    $whapper2->SMTPAuth = true;
    $whapper2->SMTPDebug = 0;
    $whapper2->Host = 'smtp.gmail.com';
    $whapper2->Password = 'a12op34unh';
    $whapper2->Username = 'timocabralcarvalho@gmail.com';
    $whapper2->SMTPSecure = "ssl";
    $whapper2->Port = 465;
    $whapper2->IsHTML(true);
    $whapper2->CharSet  = 'utf-8';
    $whapper2->FromName = 'Timo Cabral';
    $whapper2->From = "timocabralcarvalho@gmail.com";
    $whapper2->AddAddress($mail->getData()['email'], 'Timo Cabral');
    $whapper2->send();

    $whapper2->Body .= " Ola  {$mail->getData()['name']}! Segue o Ebook Solicitado :  <br />";
    $whapper2->Body .= " Atenciosamente: Timo Cabral do timocabral.com :) <br />";
    $whapper2->addStringAttachment(file_get_contents(
      $url="http://localhost/wp-content/uploads/{$mail->getData()['button_book']}"),
       "{$mail->getData()['book_name']}"
    );

    $whapper2->send();

    });
}elseif(@$_POST['method'] == 'contact'){
  $news = new Newslleter();
  $news->email = $_POST['email'];
  $news->name = $_POST['name'];
  $news->ip = $_SERVER['SERVER_ADDR'];
  $news->status = Newslleter::STATUS['msg'];
  $news->date_created = current_time( 'mysql' );
  $news->date_updated = current_time( 'mysql' );
  $news->msg =  $_POST['msg'];
  //data provider
  $dataProvider = new NewslleterDataProvider($news);
  $dataProvider->setReturnType('array');
  //DAO
  $dao = new DaoNewslleter($wpdb);
  $dao->setDataProvider($dataProvider);
  $dao->setTable('newslleter_contact');
  $dao->store();

  $mail = new MailSender($dataProvider);
  $mail->send(function() use ($mail){
    $mailWrapper = $mail->phpMailerWrapper(new PHPMailer());
    $mailWrapper->IsSMTP();
    $mailWrapper->SMTPAuth = true;
    $mailWrapper->SMTPDebug = 0;
    $mailWrapper->Host = 'smtp.gmail.com';
    $mailWrapper->Password = 'a12op34unh';
    $mailWrapper->Username = 'timocabralcarvalho@gmail.com';
    $mailWrapper->SMTPSecure = "ssl";
    $mailWrapper->Port = 465;
    $mailWrapper->FromName = 'Timo Cabral';
    $mailWrapper->From = "timocabralcarvalho@gmail.com";
    //formatando mensagem
    $mailWrapper->Body = " nome {$mail->getData()['name']} / email: {$mail->getData()['email']}
     Mensagem: ". nl2br($mail->getData()['msg'])."<br />";
    $mailWrapper->AddAddress("timocabralcarvalho@gmail.com", "Timo Cabral");
    //var_dump($mail->getData()['name']);
    $mailWrapper->send();
    return ;
  });
}

add_action('admin_menu', 'my_plugin_menu');

    /**
    *add_menu_page doc : https://developer.wordpress.org/reference/functions/add_menu_page/
    *
    */
    function my_plugin_menu() {
 	      add_menu_page('Simple Newslleter',
          'Simple Newslleter',
          'administrator',
          'news.admin.php',
          '',
          'dashicons-admin-generic');
    }


    add_action( 'admin_init', 'my_plugin_settings' );

    function my_plugin_settings() {
	      register_setting('my-plugin-settings-group', 'accountant_name');
	      register_setting('my-plugin-settings-group', 'accountant_email');
    }
