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


//GLOBAL $wpdb;
if(@$_POST['method'] == 'newslleter'){
  $l = new Leads();
//$news->name = $_POST['nome'];
  $l->name = "newslleter:index";
  $l->email = $_POST['email'];
  $l->ip = $_SERVER['SERVER_ADDR'];
  $l->msg = "formulário da página inicial";
  $l->date_created = date("Y-m-d H:i:s");
  $l->book_id = 0;
  $l->status = Leads::active_newslleter;
  $l->date_updated = date("Y-m-d H:i:s");
  $l->method = 'newslleter';
  $dataProvider = new LeadsDataProvider($l);
  $dataProvider->setReturnType('array');
  $dao = new DaoLeads();
  $dao->setDataProvider($dataProvider);
  $dao->store();

}elseif(@$_POST['method'] == 'ebook'){
    //domain object
    $l = new Leads();
    $l->name = $_POST['nome'];
    $l->email = $_POST['email'];
    $l->msg = "persistindo um livro";
    $l->ip = $_SERVER['SERVER_ADDR'];
    $l->status = Leads::ebook_request;
    $l->method = "ebook";
    $l->date_created =  date("Y-m-d H:i:s");
    $l->date_updated =  date("Y-m-d H:i:s");
    $l->ebookHidden = $_POST['ebook_hidden'];
    //data provider
    $dataProvider = new LeadsDataProvider($l);
    $dataProvider->setReturnType('array');
    $dao = new DaoLeads();
    $dao->setDataProvider($dataProvider);
    $dao->store();

}elseif(@$_POST['method'] == 'contact'){
  $l = new Leads();
  $l->email = $_POST['email'];
  $l->name = $_POST['name'];
  $l->ip = $_SERVER['SERVER_ADDR'];
  $l->status = Leads::msg;
  $l->date_created = date("Y-m-d H:i:s");
  $l->date_updated = date("Y-m-d H:i:s");
  $l->msg =  $_POST['msg'];
  $l->method = "contact";
  //data provider
  $dataProvider = new LeadsDataProvider($l);
  $dataProvider->setReturnType('array');
  //DAO
  $dao = new DaoLeads();
  $dao->setDataProvider($dataProvider);
  $dao->store();
/*

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
*/
}elseif(@$_POST['method'] == 'modal'){
    //domain object
    $l = new Leads();
    $l->name = $_POST['nome'];
    $l->email = $_POST['email'];
    $l->ip = $_SERVER['SERVER_ADDR'];
    $l->status = Leads::modal;
    $l->date_created =  date("Y-m-d H:i:s");
    $l->date_updated =  date("Y-m-d H:i:s");
    $l->ebookHidden = 'null';
    $l->msg = "cadastrando lead via modal";
    $l->method = "modal";
    //data provider
    $dataProvider = new LeadsDataProvider($l);
    $dataProvider->setReturnType('array');
    //DAO
    $dao = new DaoLeads();
    $dao->setDataProvider($dataProvider);
    $dao->store();

}

//lista em formato cvs
if(isset($_GET['export'])){
  $l = new Leads();
  $l = new LeadsDataProvider($l);
  $dao = new DaoLeads($wpdb);
  $dao->setTable('wp_news_leads');
  $dao->exportList();
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
