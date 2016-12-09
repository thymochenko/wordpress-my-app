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
if($_POST['email']){
include 'news.core.php';
require_once("utils/PHPMailerAutoload.php");
/*
$news = new Newslleter();
$news->name = "Timo Cabral";
$news->email = "timocabral@gmail.com";
$news->ip = "192.168.1.5";
$news->status = Newslleter::STATUS['active'];
$news->date_created = current_time( 'mysql' );
$news->date_updated = current_time( 'mysql' );
*/
$news = new Newslleter();
//$news->name = $_POST['nome'];
$news->email = $_POST['email'];
//$news->email = 'henkosato5@gmail.com';
//$news->ip = $_SERVER['SERVER_ADDR'];
//$news->status = Newslleter::STATUS['active'];
//$news->date_created = '10/10/1986 9:9:33';
//$news->date_updated = '10/10/1986 9:9:33';
//$news->ebook_hidden = "kkkk";

$dataProvider = new NewslleterDataProvider($news);
$dataProvider->setReturnType('array');

$dao = new DaoNewslleter($wpdb);
$dao->setDataProvider($dataProvider);
$dao->setTable('newslleter_contac');
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

  $mailWrapper->Body .= " ASSINANTE NEWSLLETER <br />";
  $mailWrapper->Body .= " email: {$mail->getData()['email']} <br />";
  $mailWrapper->AddAddress("timocabralcarvalho@gmail.com", "Timo Cabral");
  //var_dump($mail->getData()['name']);
  return ($mailWrapper->send()) ? "error" : "ok";
  });
}

add_action('admin_menu', 'my_plugin_menu');

    /**
    *registra configurações básicas do menu do plugin e conteudo inicial.
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
