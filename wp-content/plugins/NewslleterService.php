<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NewslleterService
 *
 * @author thymo
 */
// Replace path_to_sdk_inclusion with the path to the SDK as described in
// http://docs.aws.amazon.com/aws-sdk-php/v3/guide/getting-started/basic-usage.html
require "vendor/autoload.php";
require "news.core.php";
//define('REQUIRED_FILE','path_to_sdk_inclusion');
// Replace sender@example.com with your "From" address.
// This address must be verified with Amazon SES.
define('SENDER', 'henkosato5@gmail.com');


// Replace us-west-2 with the AWS region you're using for Amazon SES.
define('REGION', 'us-west-2');

use Aws\Ses\SesClient;

class NewslleterService {

    const SENDER = "henkosato5@gmail.com";

    //put your code here

    public function __construct() {
        $client = SesClient::factory(array(
                    'version' => 'latest',
                    'http' => array(
                        'verify' => false
                    ),
                    'region' => REGION,
                    'credentials' => array(
                        'key' => '',
                        'secret' => '',
                    )
        ));

        $sth = Connection::open($localconnection = true)->prepare(
                "SELECT  * "
                . " FROM wp_envio_news AS e"
                . " INNER JOIN wp_news_envio AS env ON (e.envio_id = env.id)"
                . "INNER JOIN wp_news_newslleter AS n ON (e.newslleter_id = n.id)"
                . " ORDER BY n.id DESC LIMIT 3"
        );

        $sth->execute();
        $count = 0;

        while ($obj = $sth->fetchObject('stdClass')) {
            $objects[] = $obj;
        }

        //var_dump($objects);
        //bloco 1: dados da news
        $sth1 = Connection::get($localconnection = true)->prepare(
                "SELECT m.id AS message_id, m.body AS message_body, n.status as news_status, n.id, e.newslleter_id, e.envio_id, env.template_id, env.message_id,  env.status, env.datecreated, n.title AS newslleter_title, "
                . " m.title AS message_title, t.title AS template_title, t.body_template AS btemplate, np.data_de_envio_fixo "
                . " FROM wp_envio_news AS e"
                . " INNER JOIN wp_news_envio AS env ON (e.envio_id = env.id)"
                . "INNER JOIN wp_news_newslleter AS n ON (e.newslleter_id = n.id)"
                . "INNER JOIN wp_news_messages AS  m ON (env.message_id = m.id)"
                . "INNER JOIN wp_news_template AS  t ON (env.template_id = t.id)"
                . "INNER JOIN wp_envio_periodo AS p ON (env.id = p.envio_id)"
                . "INNER JOIN wp_news_periodo AS np ON (p.periodo_id = np.id)"
                . " ORDER BY n.id DESC LIMIT 3");

        //bloco 2: dados da lead
        $sth2 = Connection::get($localconnection = true)->prepare(
                "SELECT gl.leads_id, l.name AS lead_name, l.email "
                . " FROM wp_envio_news AS e "
                . "INNER JOIN wp_news_newslleter AS n ON (e.newslleter_id = n.id)"
                . "INNER JOIN wp_grupos_news AS  gn ON (n.id = gn.newslleter_id)"
                . "INNER JOIN wp_grupos AS g ON (gn.grupos_id = g.id)"
                . "INNER JOIN wp_grupos_leads AS  gl ON (gl.grupos_id = g.id)"
                . "INNER JOIN wp_news_leads AS l ON (l.id = gl.leads_id) "
                . " WHERE e.newslleter_id = :newslleter_id");

        //bloco 3: dados dos grupos
        $sth3 = Connection::get($localconnection = true)->prepare(
                "SELECT g.name, g.tags"
                . " FROM  wp_news_newslleter AS n "
                . "INNER JOIN wp_grupos_news AS  gn ON (n.id = gn.newslleter_id)"
                . "INNER JOIN wp_grupos AS g ON (gn.grupos_id = g.id)"
                . " WHERE n.id = :newslleter_id");

        //@envio
        $sth1->execute();
        while ($obj = $sth1->fetchObject("stdClass")) {
            $collection[] = $obj;
        }

        // var_dump($collection);  

        for ($j = 0; $j < count($objects); $j++) {

            $sth2->bindValue(':newslleter_id', $collection[$j]->id, PDO::PARAM_STR);
            $sth2->execute();

            $sth3->bindValue(':newslleter_id', $collection[$j]->id, PDO::PARAM_STR);
            $sth3->execute();


            //var_dump($collection);
            //@leads
            while ($obj = $sth2->fetchObject("stdClass")) {
                $collection[$j]->leads[] = $obj;
                $collection[$j]->total_leads = count($collection[$j]->leads);
            }

            //@grupos
            while ($obj = $sth3->fetchObject("stdClass")) {
                $collection[$j]->grupos[] = $obj;
            }
            // var_dump($collection[$j]);
        }
        //var_dump($collection);
        //var_dump($collection);
        //seleciona se existe algum envio para o dia
        $dateNow = new DateTime("now");
        for ($x = 0; $x < count($collection); $x++) {
            $date = new DateTime($collection[$x]->data_de_envio_fixo);

            if ($dateNow->format("Y-m-d") == $date->format('Y-m-d')) {
                $request = array();
                $request['Source'] = self::SENDER;
                $collection[$x]->message_body .= '<img src="http://localhost/wp-content/plugins/news.core.php?message_mail_value_id=' . $collection[$x]->message_id . '"/>';
                $request['Message']['Subject']['Data'] = $collection[$x]->message_title;
                for ($a = 0; $a < count($collection[$x]->leads); $a++) {
                    $request['Destination']['ToAddresses'] = array($collection[$x]->leads[$a]->email);
                    $request['Message']['Body']['Html']['Data'] = $collection[$x]->message_body;
                    try {
                        $result = $client->sendEmail($request);
                        $messageId = $result->get('MessageId');
                        echo("Email sent! Message ID: $messageId" . "\n");
                    } catch (Exception $e) {
                        echo("The email was not sent. Error message: ");
                        echo($e->getMessage() . "\n");
                    }
                }
            } else {
                //var_dump($collection[$x]);
            }
        }

        //seleciona as leads pertencentes ao envio desta newslleter
        //envia
        $recipientTo = "";
        $subject = "";
        $body = "";


        $request = array();
        $request['Source'] = SENDER;
        $request['Destination']['ToAddresses'] = array($recipientTo);
        $request['Message']['Subject']['Data'] = $subject;
        $request['Message']['Body']['Text']['Data'] = $body;
    }

}

$service = new NewslleterService();
