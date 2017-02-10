<?php
require_once '/var/www/html/wp-content/plugins/news.core.php';

class DaoNewslleterTest extends PHPUnit_Framework_TestCase {

  public function testPersistNewslleter(){
      $news = new Newslleter();
      $news->title = "SOAP OPERA SEQUENCE ";
      $news->campaign_id = 1;
      $news->status = 1;
      $news->porcentagem = 10;
      //envio:1
      $envio1 = new Envio();
      $envio1->message_id = 1;
      $envio1->template_id = 2;
      $envio1->status = 1;
      //periodo:1
      $periodo1 = new Periodo;
      $periodo1->data_de_envio_fixo = '10/02/2017';
      //add Periodo
      $envio1->addPeriodo($periodo1);
      //envio:2
      $envio2 = new Envio();
      $envio2->message_id = 1;
      $envio2->template_id = 2;
      $envio2->status = 1;
      //periodo:1
      $periodo2 = new Periodo;
      $periodo2->data_de_envio_fixo = '10/02/2017';
      //add Periodo
      $envio2->addPeriodo($periodo2);
      //envio:3
      $envio3 = new Envio();
      $envio3->message_id = 1;
      $envio3->template_id = 2;
      $envio3->status = 1;
      //periodo:1
      $periodo3 = new Periodo;
      $periodo3->data_de_envio_fixo = '10/02/2017';
      //add Periodo
      $envio3->addPeriodo($periodo3);

      //add envio a newslleter
      $news->addEnvio($envio1);
      $news->addEnvio($envio2);
      $news->addEnvio($envio3);
      $news->addGrupos(array('grupos_id'=> array(1,2,3)));

      $dataProvider = new NewslleterDataProvider($news);
      $dao = new DaoNewslleter();
      $dao->setDataProvider($dataProvider);
      $this->assertTrue($dao->persist());
  }
}
