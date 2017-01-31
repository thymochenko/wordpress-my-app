<?php
require_once '/var/www/html/wp-content/plugins/news.core.php';

class DaoLeadsTest extends PHPUnit_Framework_TestCase{

  public function testPersistNewslleter(){
    $l = new Leads();
    $l->email = "calabocajamorreu@gmail.com";
    $l->name = "newslleter:index";
    $l->ip = "192.168.1.1";
    $l->msg = "formulário da página inicial";
    $l->book_id = 0;
    $l->status = Leads::active_newslleter;
    $l->date_created = date("Y-m-d H:i:s");
    $l->date_updated = date("Y-m-d H:i:s");
    $l->method = 'newslleter';
  //$news->ebook_hidden = "kkkk";

    $dataProvider = new LeadsDataProvider($l);
    $dataProvider->setReturnType('array');
    $dao = new DaoLeads();
    $dao->setDataProvider($dataProvider);
    $this->assertTrue($dao->store());
  }

  public function testPersistBook(){
    //domain object
    $l = new Leads();
    $l->email = "bookpersisttest@gmail.com";
    $l->name = "newslleter:book";
    $l->ip = "192.168.1.1";
    $l->msg = "persistindo um livro";
    $l->status = Leads::ebook_request;
    $l->date_created = date("Y-m-d H:i:s");
    $l->date_updated = date("Y-m-d H:i:s");
    $l->method = 'ebook';
    $l->ebookHidden = "Docker e WordPress:https://drive.google.com/file/d/0ByRILKhxz02OREZjM2xQZnQ1YXc/view?usp=sharing";

    $dataProvider = new LeadsDataProvider($l);
    $dataProvider->setReturnType('array');
    $dao = new DaoLeads();
    $dao->setDataProvider($dataProvider);
    $this->assertTrue($dao->store());
  }

  public function testPersistContact(){
    $l = new Leads();
    $l->email = "contact@gmail.com";
    $l->name = "contact test";
    $l->ip = "192.168.1.1";
    $l->status = Leads::msg;
    $l->date_created = date("Y-m-d H:i:s");
    $l->date_updated = date("Y-m-d H:i:s");
    $l->msg =  "entrando em contato com o owner";
    $l->method = 'contact';
    //data provider
    $dataProvider = new LeadsDataProvider($l);
    $dataProvider->setReturnType('array');

    $dao = new DaoLeads();
    $dao->setDataProvider($dataProvider);
    $this->assertTrue($dao->store());
  }

  public function testPersistModal(){
    $l = new Leads();
    $l->email = "modal@gmail.com";
    $l->name = "modal test";
    $l->ip = "192.168.1.1";
    $l->status = Leads::modal;
    $l->date_created = date("Y-m-d H:i:s");
    $l->date_updated = date("Y-m-d H:i:s");
    $l->msg =  "cadastrando lead via modal ";
    $l->method = 'modal';
    //data provider
    $dataProvider = new LeadsDataProvider($l);
    $dataProvider->setReturnType('array');

    $dao = new DaoLeads();
    $dao->setDataProvider($dataProvider);
    $this->assertTrue($dao->store());
  }
}
