<?php
require_once '/var/www/html/wp-content/plugins/news.core.php';

class DaoMessageTest extends PHPUnit_Framework_TestCase {

  public function testPersist(){
    $message = new Message();
    $message->title = "Testando envio";
    $message->body = "este é um corpo de um teste de funcionalidade";
    $message->date_created = date("Y-m-d H:i:s");
    $message->date_updated = date("Y-m-d H:i:s");
    $message->status = Message::active;
    //data providers
    $dataProvider = new MessageDataProvider($message);
    $dao = new DaoMessage();
    $dao->setDataProvider($dataProvider);
    $this->assertTrue($dao->persist());
  }

  public function testDelete(){
    $_GET['id'] = 103;
    if($_GET['id']){
      $message = new Message();
      $message->status = Message::inactive;
      $message->id = (int) $_GET['id'];
      $dataProvider = new MessageDataProvider($message);
      $dao = new DaoMessage();
      $dao->setDataProvider($dataProvider);
      $this->assertTrue($dao->delete());
    }
  }


    public function testUpdate(){
      $_GET['id'] = 103;
      if($_GET['id']){
        $message = new Message();
        $message->title = "Testando envio:update";
        $message->body = "este é um corpo de um teste de funcionalidade:update";
        $message->date_updated = date("Y-m-d H:i:s");
        $message->status = Message::active;
        $message->id = (int) $_GET['id'];
        $dataProvider = new MessageDataProvider($message);
        $dao = new DaoMessage();
        $dao->setDataProvider($dataProvider);
        $this->assertTrue($dao->update());
      }
    }
}
