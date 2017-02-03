<?php
require_once '/var/www/html/wp-content/plugins/news.core.php';

class DaoTemplateTest extends PHPUnit_Framework_TestCase {

  public function testPersist(){
    //cria objeto Message e persiste
    $message = new Message();
    $message->title = "Mensagem a ser atribuida ao template " . rand(10,30);
    $message->body = "este é um corpo de um teste de funcionalidade";
    $message->date_created = date("Y-m-d H:i:s");
    $message->date_updated = date("Y-m-d H:i:s");
    $message->status = Message::active;
    //data providers (Message)
    $dataProvider = new MessageDataProvider($message);
    $dao = new DaoMessage();
    $dao->setDataProvider($dataProvider);
    $dao->persist();
    //cria objeto template foreign key (1 mensagem para 1 template)
    $template = new Template();
    $template->title = "Testando envio";
    $template->body_template = "este é um corpo de um teste de funcionalidade";
    $template->setMessage($message);
    $template->status = Template::active;
    //data providers
    $dataProvider = new TemplateDataProvider($template);
    $daoTpl = new DaoTemplate();
    $daoTpl->setDataProvider($dataProvider);
    $this->assertTrue($daoTpl->persist());
  }

  public function testUpdate(){
    $id_msg = 123; //
    $id_tpl = 132; //
        //cria objeto Message
    $message = new Message();
    $message->title = "Mensagem a ser atribuida ao template:update " . rand(10,30);
    $message->body = "este é um corpo de um teste:update";
    $message->date_updated = date("Y-m-d H:i:s");
    $message->status = Message::active;
    $message->id = (int)$id_msg;
    //data providers (Message)
    $dataProvider = new MessageDataProvider($message);
    $dao = new DaoMessage();
    $dao->setDataProvider($dataProvider);
    $dao->update();
    //foreign key (1 mensagem para 1 template)
    $template = new Template();
    $template->title = "Testando Update";
    $template->body_template = "este é um corpo de um teste:update";
    $template->setMessage($message);
    $template->status = Template::active;
    $template->id = (int)$id_tpl;
    //data providers
    $dataProvider = new TemplateDataProvider($template);
    $daoTpl = new DaoTemplate();
    $daoTpl->setDataProvider($dataProvider);
    $this->assertTrue($daoTpl->update());
  }

  public function testDelete(){
      $id = 132;
      $template = new Template();
      $template->status = Template::inactive;
      $template->id = (int)$id;
      //data providers
      $dataProvider = new TemplateDataProvider($template);
      $dao = new DaoTemplate();
      $dao->setDataProvider($dataProvider);
      $this->assertTrue($dao->delete());
  }
}
