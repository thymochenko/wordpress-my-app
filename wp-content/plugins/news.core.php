<?php

//declare(strict_types=1);
class DataProvider {

    protected $nl, $dataType, $transformedData;

    public function __construct($object) {
        $this->nl = $object;
        if (isset($this->nl)) {
            $this->transformedData = $this->nl->getData();
        }
    }

    public function getData() {
        return $this->transformedData;
    }

}

abstract class Model {

    protected $data;

    public function __construct() {
        
    }

    public function getData() {
        if (isset($this->data)) {
            return $this->data;
        } else {
            return array();
        }
    }

    public function __set($prop, $value) {
        if (method_exists($this, 'set_' . $prop)) {
            call_user_func(array(
                $this,
                'set_' . $prop
                    ), $value);
        } else {
            //atribui o valor a propriedade
            $this->data[$prop] = $value;
        }
    }

    public function __get($prop) {
        if (method_exists($this, 'get_' . $prop)) {
            return call_user_func(array(
                $this,
                'get_' . $prop
            ));
        } else {
            //atribui o valor a propriedade
            return $this->data[$prop];
        }
    }

}

final class Connection {

    protected static $conn;
    /*
      const DATABASE_CONF = [
      "dbname"=>"",
      "host"=>"",
      "username"=>"",
      "password"=> ""
      ];
     */
    static $DATABASE_CONF = array(
        "dbname" => "wordpress",
        "host" => "localhost",
        "username" => "postgres",
        "password" => "silvia25"
    );
    static $DATABASE_CONF_REMOTE = array(
        "dbname" => "wordpress",
        "host" => "",
        "username" => "",
        "password" => ""
    );

    final public function __construct() {
        
    }

    public static function get() {
        if (isset(self::$conn)) {
            return self::$conn;
        } else {
            self::open();
        }
    }

    public static function close() {
        if (isset(self::$conn)) {
            self::$conn = null;
        }
    }

    public static function open($connType = null) {
        if (isset($connType) || isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
            self::$conn = new PDO("pgsql:dbname=" . self::$DATABASE_CONF["dbname"] .
                    " host=" . self::$DATABASE_CONF["host"], self::$DATABASE_CONF["username"], self::$DATABASE_CONF["password"], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$conn;
        } else {
            self::$conn = new PDO("pgsql:dbname=" . self::$DATABASE_CONF_REMOTE["dbname"] .
                    " host=" . self::$DATABASE_CONF_REMOTE["host"], self::$DATABASE_CONF_REMOTE["username"], self::$DATABASE_CONF_REMOTE["password"], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$conn;
        }
    }

}

class Dao {

    protected $wpdb, $nlDataProvider, $table;

    public function __construct($wpdb = null) {
        if ($wpdb instanceOf wpdb || $wpdb instanceOf wpdb2) {
            $this->wpdb = $wpdb;
        }
    }

    public function setDataProvider(DataProvider $nlDataProvider) {
        $this->nlDataProvider = $nlDataProvider;
    }

    public function setTable($table) {
        $this->table = $this->wpdb->prefix . $table;
    }

}

class LeadsDataProvider extends DataProvider {

    public function __construct($object) {
        parent::__construct($object);
    }

}

class MessageDataProvider extends DataProvider {

    public function __construct($object) {
        parent::__construct($object);
    }

}

class TemplateDataProvider extends DataProvider {

    public function __construct($object) {
        parent::__construct($object);
    }

}

class GruposDataProvider extends DataProvider {

    public function __construct($object) {
        parent::__construct($object);
    }

}

class NewslleterDataProvider extends DataProvider {

    public function __construct($object) {
        parent::__construct($object);
    }

}

class EnvioDataProvider extends DataProvider {

    public function __construct($object) {
        parent::__construct($object);
    }

}

class PeriodoDataProvider extends DataProvider {

    public function __construct($object) {
        parent::__construct($object);
    }

}

class CampanhaDataProvider extends DataProvider {

    public function __construct($object) {
        parent::__construct($object);
    }

}

class LogsDataProvider extends DataProvider {

    public function __construct($object) {
        parent::__construct($object);
    }

}

class DaoLeads extends Dao {

    protected $wpdb, $nlDataProvider, $conn;

    public function store() {
        $data = $this->nlDataProvider->getData();
        if (!isset($data)) {
            throw new Exception("Nenhum dado a ser persistido", 1);
        }

        if ($this->persistBook($data) ||
                $this->persistModal($data) ||
                $this->persistNewslleter($data) ||
                $this->persistContact($data) || $this->persistAdmin($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function persistModal($data) {
        $dateTime = new DateTime();
        $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));
        //@modal
        if ($data['method'] == 'modal') {

            try {
                $sth3 = Connection::open($localconnection = true)->prepare("INSERT INTO wp_news_leads
         (name,email,ip, msg, book_id, status, grupos_id, datecreated, dateupdated)
           VALUES (
             :name,
             :email,:ip,:msg,
             :book_id, :status, :grupos_id, :datecreated, :dateupdated)
          ");

                $sth3->bindValue(':name', $data["name"], PDO::PARAM_STR);
                $sth3->bindValue(':email', $data["email"], PDO::PARAM_STR);
                $sth3->bindValue(':ip', $data["ip"], PDO::PARAM_STR);
                $sth3->bindValue(':msg', $data['msg'], PDO::PARAM_STR);
                $sth3->bindValue(':book_id', 0, PDO::PARAM_INT);
                $sth3->bindValue(':status', Leads::modal, PDO::PARAM_INT);
                $sth3->bindValue(':grupos_id', $data['grupos_id'], PDO::PARAM_INT);
                $sth3->bindValue(':datecreated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                $sth3->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                return ($sth3->execute()) ? true : false;
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }
    }

    public function persistAdmin($data) {
        $dateTime = new DateTime();
        $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));
        //@modal
        if ($data['method'] == 'admin') {
            try {
                $sth3 = Connection::open($localconnection = true)->prepare("INSERT INTO wp_news_leads
           (name,email,ip, msg, book_id, status, grupos_id, datecreated, dateupdated, empresa, cargo, site, area_atuacao)
             VALUES (
               :name,
               :email,:ip,:msg,
               :book_id, :status, :grupos_id, :datecreated, :dateupdated, :empresa, :cargo, :site, :area_atuacao)
               RETURNING id");

                $sth3->bindValue(':name', $data["name"], PDO::PARAM_STR);
                $sth3->bindValue(':email', $data["email"], PDO::PARAM_STR);
                $sth3->bindValue(':ip', $data["ip"], PDO::PARAM_STR);
                $sth3->bindValue(':msg', $data['msg'], PDO::PARAM_STR);
                $sth3->bindValue(':book_id', 0, PDO::PARAM_INT);
                $sth3->bindValue(':status', $data['status'], PDO::PARAM_INT);
                $sth3->bindValue(':grupos_id', $data['grupos_id'], PDO::PARAM_INT);
                $sth3->bindValue(':datecreated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                $sth3->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                $sth3->bindValue(':empresa', $data['empresa'], PDO::PARAM_STR);
                $sth3->bindValue(':cargo', $data['cargo'], PDO::PARAM_INT);
                $sth3->bindValue(':site', $data['site'], PDO::PARAM_STR);
                $sth3->bindValue(':area_atuacao', $data['area_atuacao'], PDO::PARAM_INT);

                $sth3->execute();

                $lead_id = $sth3->fetch(PDO::FETCH_ASSOC);
                $data['persist_id'] = $lead_id;
                //var_dump($_POST);exit;
                //insere a id da lead e do grupo na tabela manyToMany
                $sth2 = Connection::open($localconnection = true)->prepare(
                        "INSERT INTO wp_grupos_leads
           (grupos_id, leads_id) VALUES (:grupos_id, :leads_id)");
                //var_dump(count($data['lead_grupo_id']));
                for ($o = 0; $o < count($data['lead_grupo_id']); $o++) {
                    $sth2->bindValue(':grupos_id', (int) $data['lead_grupo_id'][$o], PDO::PARAM_INT);
                    $sth2->bindValue(':leads_id', (int) $data['persist_id']['id'], PDO::PARAM_INT);
                    $sth2->execute();
                }
                //log
                $log = new Logs;
                $log->log = array('data' => $data);
                $dataProvider = new LogsDataProvider($log);
                $dao = new DaoLogs();
                $dao->setDataProvider($dataProvider);
                $dao->persist();

                return true;
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }
    }

    /*
     * @Remember : persistir a chave muitos para muitos grupos_id, leads_id
     */

    public function persistNewslleter($data) {
        $dateTime = new DateTime();
        $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));
        //@newslleter persist
        if ($data['method'] == "newslleter") {
            try {
                $sth = Connection::open($localconnection = true)->prepare("INSERT INTO wp_news_leads
        (name,email,ip, msg, book_id, status, grupos_id, datecreated, dateupdated)
          VALUES (
            :name,
            :email,:ip,:msg,
            :book_id, :status, :grupos_id, :datecreated, :dateupdated)
         ");

                $sth->bindValue(':name', $data['name'], PDO::PARAM_STR);
                $sth->bindValue(':email', $data["email"], PDO::PARAM_STR);
                $sth->bindValue(':ip', $data['ip'], PDO::PARAM_STR);
                $sth->bindValue(':msg', $data['msg'], PDO::PARAM_STR);
                $sth->bindValue(':book_id', $data['book_id'], PDO::PARAM_INT);
                $sth->bindValue(':status', $data['status'], PDO::PARAM_INT);
                $sth->bindValue(':grupos_id', $data['grupos_id'], PDO::PARAM_INT);
                //date
                $sth->bindValue(':datecreated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                $sth->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);

                $sth->execute();
                return $this->persitFkLeadsGroup($data, $dateTime);
                //$objects[0];
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }
    }

    public function persitFkLeadsGroup($data, $dateTime) {
        //seleciona a lead inserida
        $sth1 = Connection::get($localconnection = true)->prepare(
                "SELECT email, datecreated, grupos_id, id FROM wp_news_leads
       WHERE email = :email
       AND datecreated::date = to_date('{$dateTime->format('Y-m-d')}' ,'YYYY-MM-DD')
       AND grupos_id = :grupos_id
       ORDER BY id DESC");

        $sth1->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $sth1->bindValue(':grupos_id', $data['status'], PDO::PARAM_INT);
        $sth1->execute();
        //percorre os elementos e armazena
        while ($obj = $sth1->fetchObject(__CLASS__)) {
            $object[] = $obj;
        }
        //insere a id da lead e do grupo na tabela manyToMany
        $sth2 = Connection::get($localconnection = true)->prepare(
                "INSERT INTO wp_grupos_leads
      (grupos_id, leads_id) VALUES (:grupos_id, :leads_id)");

        $sth2->bindValue(':grupos_id', (int) $object[0]->grupos_id, PDO::PARAM_INT);
        $sth2->bindValue(':leads_id', (int) $object[0]->id, PDO::PARAM_INT);
        return ($sth2->execute()) ? true : false;
    }

    //lead_id 562
    //grupo: 161 - 160

    public function persistContact($data) {
        $dateTime = new DateTime();
        $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));

        if ($data['method'] == 'contact') {
            try {

                $sth4 = Connection::open($localconnection = true)->prepare("INSERT INTO wp_news_leads
          (name,email,ip, msg, book_id, status, grupos_id, datecreated, dateupdated)
            VALUES (
              :name,
              :email,:ip,:msg,
              :book_id, :status, :grupos_id, :datecreated, :dateupdated)
           ");

                $sth4->bindValue(':name', $data["name"], PDO::PARAM_STR);
                $sth4->bindValue(':email', $data["email"], PDO::PARAM_STR);
                $sth4->bindValue(':ip', $data["ip"], PDO::PARAM_STR);
                $sth4->bindValue(':msg', $data["msg"], PDO::PARAM_STR);
                $sth4->bindValue(':book_id', 0, PDO::PARAM_INT);
                $sth4->bindValue(':status', $data['status'], PDO::PARAM_INT);
                $sth4->bindValue(':grupos_id', $data['grupos_id'], PDO::PARAM_INT);
                $sth4->bindValue(':datecreated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                $sth4->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                $sth4->execute();
                return $this->persitFkLeadsGroup($data, $dateTime);
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }
    }

    public function persistBook(array $data) {
        //@Book persist
        $dateTime = new DateTime();
        $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));

        if (isset($data["button_book"]) && $data["button_book"] != '') {

            try {
                $sth = Connection::open($localconnection = true)->prepare(
                        "INSERT INTO wp_book (title,datecreated,dateupdated)
             VALUES (
               :title, :datecreated,:dateupdated)
            ");

                $sth->bindValue(':title', $data['book_name'] . ":" . $data['button_book'], PDO::PARAM_STR);
                $sth->bindValue(':datecreated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                $sth->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);

                $sth->execute();

                $sth2 = Connection::get()->prepare("SELECT id FROM wp_book ORDER BY id DESC limit 1");
                $sth2->execute();

                $result = $sth2->fetch(PDO::FETCH_OBJ);
                //Connection::close();

                $sth3 = Connection::get()->prepare("INSERT INTO wp_news_leads
         (name,email,ip, msg, book_id, status, grupos_id, datecreated, dateupdated)
           VALUES (
             :name,
             :email,:ip,:msg,
             :book_id, :status, :grupos_id, :datecreated, :dateupdated)
          ");

                $sth3->bindValue(':name', $data["name"], PDO::PARAM_STR);
                $sth3->bindValue(':email', $data["email"], PDO::PARAM_STR);
                $sth3->bindValue(':ip', "192.168.0.1", PDO::PARAM_STR);
                $sth3->bindValue(':msg', "newslleter:ebook", PDO::PARAM_STR);
                $sth3->bindValue(':book_id', $result->id, PDO::PARAM_INT);
                $sth3->bindValue(':status', $data['status'], PDO::PARAM_INT);
                $sth3->bindValue(':grupos_id', $data['grupos_id'], PDO::PARAM_INT);
                $sth3->bindValue(':datecreated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                $sth3->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                $sth3->execute();

                return $this->persitFkLeadsGroup($data, $dateTime);
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }
    }

    public function exportList() {
        $sth = Connection::open($localconnection = true)->prepare("SELECT DISTINCT name, email FROM wp_news_leads");
        $sth->execute();
        while ($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }

        echo "name ; email <br>";
        foreach ($objects as $k => $news) {
            echo $news->name . " ; " . $news->email . "<br>";
        }
    }

    public function getAll() {
        $sth = Connection::open($localconnection = true)->prepare("SELECT * FROM wp_news_leads ORDER by id DESC LIMIT 3");
        $sth->execute();
        while ($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }
        return $objects;
    }

    /*
     * emails recebidos do dia.
     */

    public function emailsForToday() {
        $date = new DateTime('now');
        $data = $date->format('d/m/Y');
        preg_match('/^(\d+)\/(\d+)\/(\d+)$/', $data, $matches);
        list($data, $dia, $mes, $ano) = $matches;

        //Últimos 5 dias de recebimento
        $time = mktime(0, 0, 0, $mes, $dia - 5, $ano);

        // Formatar a data obtida
        $formatedDate = strftime('%Y-%m-%d', $time); // 10/02/2010
        //busca todos os registros
        //var_dump($formatedDate);
        $sth = Connection::open($localconnection = true)->prepare(
                "SELECT * FROM wp_news_leads
     WHERE datecreated::date >= to_date('{$formatedDate}' ,'YYYY-MM-DD') ORDER BY id DESC");

        $sth->execute();
        while ($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }
        return $objects ? $objects : false;
    }

    public function update() {
        $dateTime = new DateTime();
        $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));

        $data = $this->nlDataProvider->getData();

        if ($data['method'] == 'admin') {
            try {
                $sth3 = Connection::open($localconnection = true)->prepare("UPDATE wp_news_leads
           SET name = :name, email = :email, ip = :ip, msg = :msg, book_id = :book_id, status = :status, grupos_id = :grupos_id, 
           dateupdated = :dateupdated, empresa = :empresa, cargo = :cargo, site = :site, area_atuacao = :area_atuacao
           WHERE id = :id RETURNING id
           ");

                $sth3->bindValue(':id', $data["id"], PDO::PARAM_INT);
                $sth3->bindValue(':name', $data["name"], PDO::PARAM_STR);
                $sth3->bindValue(':email', $data["email"], PDO::PARAM_STR);
                $sth3->bindValue(':ip', $data["ip"], PDO::PARAM_STR);
                $sth3->bindValue(':msg', $data['msg'], PDO::PARAM_STR);
                $sth3->bindValue(':book_id', 0, PDO::PARAM_INT);
                $sth3->bindValue(':status', (int) $data['status'], PDO::PARAM_INT);
                $sth3->bindValue(':grupos_id', 1, PDO::PARAM_INT);
                $sth3->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                $sth3->bindValue(':empresa', $data['empresa'], PDO::PARAM_STR);
                $sth3->bindValue(':cargo', $data['cargo'], PDO::PARAM_INT);
                $sth3->bindValue(':site', $data['site'], PDO::PARAM_STR);
                $sth3->bindValue(':area_atuacao', $data['area_atuacao'], PDO::PARAM_INT);

                $sth3->execute();

                $lead_id = $sth3->fetch(PDO::FETCH_ASSOC);
                $data['persist_id'] = $lead_id;
                //var_dump($_POST);exit;
                //insere a id da lead e do grupo na tabela manyToMany
                $sth2 = Connection::open($localconnection = true)->prepare(
                        "UPDATE wp_grupos_leads
          SET  grupos_id = :grupos_id, leads_id = :leads_id WHERE grupos_id = :grupos_id AND leads_id = :leads_id");
                //var_dump(count($data['lead_grupo_id']));
                for ($o = 0; $o < count($data['lead_grupo_id']); $o++) {
                    $sth2->bindValue(':grupos_id', (int) $data['lead_grupo_id'][$o], PDO::PARAM_INT);
                    $sth2->bindValue(':leads_id', (int) $data['persist_id']['id'], PDO::PARAM_INT);
                    $sth2->execute();
                }
                return true;
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }
    }

    public function destroy() {
        
    }

    public function findFirst() {
        $sth = Connection::open($localconnection = true)->prepare(
                "SELECT * FROM wp_news_leads ORDER BY id DESC LIMIT 1");

        $sth->execute();
        while ($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }

        return $objects ? $objects : false;
    }

    public function findById($id) {
        if (is_integer($id)) {
            $sth = Connection::open($localconnection = true)->prepare(
                    "SELECT id, name, email, site, status, dateupdated, empresa, cargo, area_atuacao
           FROM wp_news_leads WHERE id = :id ORDER BY id DESC LIMIT 1");
            $sth->bindValue(":id", $id, PDO::PARAM_INT);
            $sth->execute();

            while ($obj = $sth->fetchObject(__CLASS__)) {
                $objects[] = $obj;
            }

            return $objects ? $objects : false;
        }
    }

}

class DaoGrupos extends Dao {

    public function persist() {
        try {
            //recebe os dados de um dataProvider
            $dateTime = new DateTime();
            $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));

            $data = $this->nlDataProvider->getData();

            $sth = Connection::open($localconnection = true)->prepare(
                    "INSERT INTO wp_grupos (name,status,datecreated,dateupdated, tags)
          VALUES (
            :name,:status,:datecreated,:dateupdated, :tags)
         ");

            $sth->bindValue(':name', $data['name'], PDO::PARAM_STR);
            $sth->bindValue(':status', $data['status'], PDO::PARAM_STR);
            $sth->bindValue(':datecreated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $sth->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $sth->bindValue(':tags', json_encode($data['tags']), PDO::PARAM_STR);

            return ($sth->execute()) ? true : false;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function findAll($limit = null) {
        if (isset($limit)) {
            $sth = Connection::open($localconnection = true)
                    ->prepare("SELECT * FROM wp_grupos ORDER by id DESC LIMIT :limit");
            $sth->bindValue(':limit', $limit, PDO::PARAM_INT);
        } else {
            $sth = Connection::open($localconnection = true)
                    ->prepare("SELECT * FROM wp_grupos ORDER by id DESC");
        }

        $sth->execute();
        while ($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }

        return $objects;
    }

    public function findFirst() {
        $sth = Connection::open($localconnection = true)->prepare(
                "SELECT * FROM wp_grupos ORDER BY id DESC LIMIT 1");

        $sth->execute();
        while ($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }

        return $objects ? $objects : false;
    }

}

class DaoNewslleter extends Dao {

    public function persist() {
        try {
            $dateTime = new DateTime();
            $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));
            //persist @Newslleter
            $sth = Connection::open($localconnection = true)->prepare("INSERT INTO wp_news_newslleter
                (title,campaign_id,newslleter_id, status, porcentagem, datecreated, dateupdated)
                VALUES (
                    :title,
                    :campaign_id,:newslleter_id,:status,
                    :porcentagem, :datecreated, :dateupdated) RETURNING id
                    ");

            $data = $this->nlDataProvider->getData();

            $sth->bindValue(':title', $data["title"], PDO::PARAM_STR);
            $sth->bindValue(':campaign_id', $data["campaign_id"], PDO::PARAM_INT);
            $sth->bindValue(':newslleter_id', 1, PDO::PARAM_INT);
            $sth->bindValue(':status', $data['status'], PDO::PARAM_INT);
            $sth->bindValue(':porcentagem', $data['porcentagem'], PDO::PARAM_INT);
            $sth->bindValue(':datecreated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $sth->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $sth->execute();
            //RETURNING id
            $newslleter_id = $sth->fetch(PDO::FETCH_ASSOC);

            //var_dump($newslleter_id['id']);exit;
            //persist @Envio
            $sth1 = Connection::get($localconnection = true)->prepare('INSERT INTO wp_news_envio
                     (template_id, message_id, status, datecreated, dateupdated, log_id)
                     VALUES (:template_id, :message_id, :status, :datecreated, :dateupdated, :log_id) RETURNING id');

            //persist block
            //var_dump($data['envio'][0]->message_id); exit;

            for ($i = 0; $i < count($data['envio']); $i++) {
                if ($data['envio'][$i]->template_id != "" && $data['envio'][$i]->message_id != "" && $data['envio'][$i]->status != "") {
                    $sth1->bindValue(':template_id', (int) $data['envio'][$i]->template_id, PDO::PARAM_INT);
                    $sth1->bindValue(':message_id', (int) $data['envio'][$i]->message_id, PDO::PARAM_INT);
                    $sth1->bindValue(':status', (int) $data['envio'][$i]->status, PDO::PARAM_INT);
                    $sth1->bindValue(':datecreated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                    $sth1->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                    $sth1->bindValue(':log_id', 1, PDO::PARAM_INT);
                    $sth1->execute();
                    $envio_id[] = $sth1->fetch(PDO::FETCH_ASSOC);
                }
            }

            //var_dump($envio_id);exit;
            //recupera todos os ids persistido
            //persist @Periodo
            $sth2 = Connection::get($localconnection = true)->prepare(
                    'INSERT INTO wp_news_periodo (data_de_envio_fixo)
                  VALUES (:data_de_envio_fixo) RETURNING id');
            //           var_dump($data['envio'][0]->periodo[0]->data_de_envio_fixo);exit;
            for ($x = 0; $x < count($data['envio']); $x++) {
                $sth2->bindValue(':data_de_envio_fixo', $data['envio'][$x]->periodo[0]->data_de_envio_fixo, PDO::PARAM_STR);
                $sth2->execute();
                $periodo_id[] = $sth2->fetch(PDO::FETCH_ASSOC);
            }
            // var_dump($_POST);exit;
            //var_dump($periodo_id);exit;
            //@grupos_news
            $sth3 = Connection::get($localconnection = true)->prepare(
                    'INSERT INTO wp_grupos_news (grupos_id,newslleter_id)
                  VALUES (:grupos_id, :newslleter_id)');
            //var_dump($data['grupos'][0]);exit;

            for ($z = 0; $z < count($data['grupos']); $z++) {
                $sth3->bindValue(':grupos_id', (int) $data["grupos"][$z], PDO::PARAM_INT);
                $sth3->bindValue(':newslleter_id', (int) $newslleter_id['id'], PDO::PARAM_INT);
                $sth3->execute();
            }

            foreach ($data['grupos'] as $grupo) {
                $grupos[] = array('grupo' => $grupo);
            }

            foreach ($data['envio'] as $envio) {
                //var_dump($envio);
                if ($envio->message_id != null) {
                    $messages[] = array('envio:message_id' => $envio->message_id);
                }
            }

            self::storeEnvioFkTables($data, $envio_id, $periodo_id, $newslleter_id);

            //logs
            $log = new Logs;
            $log->log = array('data' => $data, 'grupos' => $grupos, 'messages' => $messages);
            $dataProvider = new LogsDataProvider($log);
            $dao = new DaoLogs();
            $dao->setDataProvider($dataProvider);
            $dao->persist();
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public static function storeEnvioFkTables($data, $envio_id, $periodo_id, $newslleter_id) {
        // var_dump($envio_id[0]['id']);exit;

        $sth4 = Connection::open($localconnection = true)->prepare(
                'INSERT INTO wp_envio_news (envio_id, newslleter_id)
                  VALUES (:envio_id, :newslleter_id)');

        $count = 0;
        foreach ($data['envio'] as $k => $date) {
            if ($envio_id[$count]['id'] != "" && $envio_id[$count]['id'] != null && $newslleter_id['id'] != "") {

                $sth4->bindValue(':envio_id', (int) $envio_id[$count]['id'], PDO::PARAM_INT);
                $sth4->bindValue(':newslleter_id', (int) $newslleter_id['id'], PDO::PARAM_INT);
                //sleep(1);
                //if(count($data['envio']) <)
                $sth4->execute();
                $count++;
            }
        }

        $sth5 = Connection::open($localconnection = true)->prepare(
                'INSERT INTO wp_envio_periodo (envio_id,periodo_id)
                   VALUES (:envio_id, :periodo_id)');


        for ($y = 0; $y < count($data['envio']); $y++) {
            $sth5->bindValue(':envio_id', (int) $envio_id[$y]['id'], PDO::PARAM_INT);
            $sth5->bindValue(':periodo_id', (int) $periodo_id[$y]['id'], PDO::PARAM_INT);
            //break;
            $sth5->execute();
        }

        return true;
    }

    public function update() {
        $dateTime = new DateTime();
        $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));
        //persist @Newslleter
        $sth = Connection::open($localconnection = true)->prepare("UPDATE wp_news_newslleter
            SET title = :title, campaign_id = :campaign_id, newslleter_id = :newslleter_id, status = :status,
            porcentagem = :porcentagem, dateupdated = :dateupdated
            WHERE id = :id");

        $data = $this->nlDataProvider->getData();
        $sth->bindValue(':title', $data["title"], PDO::PARAM_STR);
        $sth->bindValue(':campaign_id', 1, PDO::PARAM_INT);
        $sth->bindValue(':newslleter_id', 1, PDO::PARAM_INT);
        $sth->bindValue(':status', (int) $data['status'], PDO::PARAM_INT);
        $sth->bindValue(':porcentagem', (int) $data['porcentagem'], PDO::PARAM_INT);
        $sth->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        $sth->bindValue(':id', (int) $data['id'], PDO::PARAM_INT);
        $sth->execute();
        return true;
    }

    public function delete() {
        
    }

    public function findAll() {
        $sth = Connection::open($localconnection = true)->prepare(
                "SELECT * FROM wp_news_newslleter ORDER BY id DESC LIMIT 5");

        $sth->execute();
        while ($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }

        //var_dump($objects);

        $sth1 = Connection::get($localconnection = true)->prepare(
                "SELECT n.status as news_status, n.id, e.newslleter_id, e.envio_id, env.template_id, env.message_id,  env.status, env.datecreated, n.title AS newslleter_title, "
                . " m.title AS message_title, t.title AS template_title, t.body_template AS btemplate, np.data_de_envio_fixo "
                . " FROM wp_envio_news AS e"
                . " INNER JOIN wp_news_envio AS env ON (e.envio_id = env.id)"
                . "INNER JOIN wp_news_newslleter AS n ON (e.newslleter_id = n.id)"
                . "INNER JOIN wp_news_messages AS  m ON (env.message_id = m.id)"
                . "INNER JOIN wp_news_template AS  t ON (env.template_id = t.id)"
                . "INNER JOIN wp_envio_periodo AS p ON (env.id = p.envio_id)"
                . "INNER JOIN wp_news_periodo AS np ON (p.periodo_id = np.id)"
                . " WHERE e.newslleter_id = :newslleter_id");
        //var_dump($objects);
        //var_dump($objects);

        for ($j = 0; $j < count($objects); $j++) {

            $sth1->bindValue(':newslleter_id', $objects[$j]->id, PDO::PARAM_STR);
            $sth1->execute();
            //            $obj = $sth1->fetchObject("stdClass");
            while ($obj = $sth1->fetchObject(__CLASS__)) {
                $objects_fkey_envio[] = $obj;
            }

            //  var_dump($objects_fkey_envio);

            if ($objects_fkey_envio[$j]->news_id == $objects_fkey_envio[$j]->newslleter_id_fk) {
                $collection[] = $objects_fkey_envio;
                unset($objects_fkey_envio);
            }
        }

        //var_dump($objects_fkey_envio);
        // var_dump($collection);

        return $collection ? $collection : false;
    }

    public function findFirst() {
        $sth = Connection::open($localconnection = true)->prepare(
                "SELECT * FROM wp_news_newslleter ORDER BY id DESC LIMIT 1");

        $sth->execute();
        while ($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }

        return $objects ? $objects : false;
    }

    public function findById($id) {
        if (is_integer($id)) {
            $sth = Connection::open($localconnection = true)->prepare(
                    "SELECT * FROM wp_news_newslleter WHERE id = :id ORDER BY id DESC LIMIT 1");
            $sth->bindValue(":id", $id, PDO::PARAM_INT);
            $sth->execute();

            while ($obj = $sth->fetchObject(__CLASS__)) {
                $objects[] = $obj;
            }

            return $objects ? $objects : false;
        }
    }

}

class DaoMessage extends Dao {

    public function persist() {
        try {
            //recebe os dados de um dataProvider
            $dateTime = new DateTime();
            $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));

            $data = $this->nlDataProvider->getData();
            $sth = Connection::open($localconnection = true)->prepare(
                    "INSERT INTO wp_news_messages (title,body,status,datecreated,dateupdated)
          VALUES (
            :title, :body, :status, :datecreated,:dateupdated)
         ");

            $sth->bindValue(':title', $data['title'], PDO::PARAM_STR);
            $sth->bindValue(':body', $data['body'], PDO::PARAM_STR);
            $sth->bindValue(':status', $data['status'], PDO::PARAM_INT);
            $sth->bindValue(':datecreated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $sth->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);

            return ($sth->execute()) ? true : false;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function delete() {
        try {
            $data = $this->nlDataProvider->getData();
            //recebe os dados de um dataProvider
            if (is_integer($data['id'])) {

                $dateTime = new DateTime();
                $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));

                $sth = Connection::open($localconnection = true)->prepare("UPDATE
           wp_news_messages SET status = :status, dateupdated = :dateupdated WHERE id = :id
        ");

                $sth->bindValue(':status', $data['status'], PDO::PARAM_INT);
                $sth->bindValue(':id', (int) $data['id'], PDO::PARAM_INT);
                $sth->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);

                return ($sth->execute()) ? true : false;
            }
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function update() {
        try {
            $data = $this->nlDataProvider->getData();
            //recebe os dados de um dataProvider
            if (is_integer($data['id'])) {

                $dateTime = new DateTime();
                $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));

                $sth = Connection::open($localconnection = true)->prepare(
                        "UPDATE wp_news_messages
            SET title = :title, body = :body, status = :status, dateupdated = :dateupdated
            WHERE id = :id
          ");
                $sth->bindValue(':title', $data['title'], PDO::PARAM_STR);
                $sth->bindValue(':body', $data['body'], PDO::PARAM_STR);
                $sth->bindValue(':status', $data['status'], PDO::PARAM_INT);
                $sth->bindValue(':id', (int) $data['id'], PDO::PARAM_INT);
                $sth->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);

                return ($sth->execute()) ? true : false;
            }
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function findAll() {
        $sth = Connection::open($localconnection = true)->prepare(
                "SELECT * FROM wp_news_messages ORDER BY id DESC LIMIT 5");

        $sth->execute();
        while ($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }
        return $objects ? $objects : false;
    }

    public function findFirst() {
        $sth = Connection::open($localconnection = true)->prepare(
                "SELECT * FROM wp_news_messages ORDER BY id DESC LIMIT 1");

        $sth->execute();
        while ($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }

        return $objects ? $objects : false;
    }

    public function findById($id) {
        if (is_integer($id)) {
            $sth = Connection::open($localconnection = true)->prepare(
                    "SELECT * FROM wp_news_messages WHERE id = :id ORDER BY id DESC LIMIT 1");
            $sth->bindValue(":id", $id, PDO::PARAM_INT);
            $sth->execute();

            while ($obj = $sth->fetchObject(__CLASS__)) {
                $objects[] = $obj;
            }

            return $objects ? $objects : false;
        }
    }

    public function registraAbertura($id) {
        try {
            //recebe os dados de um dataProvider
            if (is_integer($id)) {
                $collection = $this->findById($id);
                if ($collection[0]->id) {
                    $dateTime = new DateTime();
                    $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));

                    $sth = Connection::open($localconnection = true)->prepare(
                            "UPDATE wp_news_messages
                              SET  status = :status, dateupdated = :dateupdated
                             WHERE id = :id
                     ");
                    $sth->bindValue(':status', Message::VISUALIZADA, PDO::PARAM_INT);
                    $sth->bindValue(':id', (int) $collection[0]->id, PDO::PARAM_INT);
                    $sth->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);

                    return ($sth->execute()) ? $collection : false;
                }
            }
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

}

class DaoTemplate extends Dao {

    public function persist() {
        try {
            $data = $this->nlDataProvider->getData();
            $sth = Connection::open($localconnection = true)->prepare(
                    "INSERT INTO wp_news_template (title, body_template, message_id, status)
          VALUES (
            :title, :body_template, :message_id, :status)
         ");

            $sth->bindValue(':title', $data['title'], PDO::PARAM_STR);
            $sth->bindValue(':body_template', $data['body_template'], PDO::PARAM_STR);
            $sth->bindValue(':message_id', $data['message_id'], PDO::PARAM_INT);
            $sth->bindValue(':status', (int) $data['status'], PDO::PARAM_INT);

            return ($sth->execute()) ? true : false;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function update() {
        try {
            $data = $this->nlDataProvider->getData();
            $sth = Connection::open($localconnection = true)->prepare(
                    "UPDATE wp_news_template SET title = :title, body_template = :body_template,
          message_id = :message_id, status = :status
          WHERE id = :id
        ");

            $sth->bindValue(':title', $data['title'], PDO::PARAM_STR);
            $sth->bindValue(':body_template', $data['body_template'], PDO::PARAM_STR);
            $sth->bindValue(':message_id', (int) $data['message_id'], PDO::PARAM_INT);
            $sth->bindValue(':status', (int) $data['status'], PDO::PARAM_INT);
            $sth->bindValue(':id', (int) $data['id'], PDO::PARAM_INT);

            return ($sth->execute()) ? true : false;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function delete() {
        try {
            $data = $this->nlDataProvider->getData();
            $sth = Connection::open($localconnection = true)->prepare(
                    "UPDATE wp_news_template SET status = :status
            WHERE id = :id
          ");

            $sth->bindValue(':status', $data['status'], PDO::PARAM_INT);
            $sth->bindValue(':id', (int) $data['id'], PDO::PARAM_INT);

            return ($sth->execute()) ? true : false;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function findAll() {
        $sth = Connection::open($localconnection = true)->prepare(
                "SELECT * FROM wp_news_template ORDER BY id DESC LIMIT 3");

        $sth->execute();
        while ($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }
        return $objects ? $objects : false;
    }

    public function findFirst() {
        $sth = Connection::open($localconnection = true)->prepare(
                "SELECT * FROM wp_news_template ORDER BY id DESC LIMIT 1");

        $sth->execute();
        while ($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }

        return $objects ? $objects : false;
    }

    public function findById($id) {
        if (is_integer($id)) {
            $sth = Connection::open($localconnection = true)->prepare(
                    "SELECT * FROM wp_news_template WHERE id = :id ORDER BY id DESC LIMIT 1");
            $sth->bindValue(":id", $id, PDO::PARAM_INT);
            $sth->execute();

            while ($obj = $sth->fetchObject(__CLASS__)) {
                $objects[] = $obj;
            }

            return $objects ? $objects : false;
        }
    }

}

class DaoCampanha extends Dao {

    public function persist() {
        try {
            $dateTime = new DateTime();
            $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));

            $data = $this->nlDataProvider->getData();
            $sth = Connection::open($localconnection = true)->prepare(
                    "INSERT INTO wp_news_campanha (title, status,datecreated, dateupdated)
            VALUES (
              :title, :status, :datecreated, :dateupdated)
           ");

            $sth->bindValue(':title', $data['title'], PDO::PARAM_STR);
            $sth->bindValue(':status', $data['status'], PDO::PARAM_INT);
            $sth->bindValue(':datecreated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $sth->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);

            return ($sth->execute()) ? true : false;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function update() {
        try {
            $dateTime = new DateTime();
            $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));

            $data = $this->nlDataProvider->getData();
            $sth = Connection::open($localconnection = true)->prepare(
                    "UPDATE wp_news_campanha SET title = :title, status = :status,
            dateupdated = :dateupdated
            WHERE id = :id
          ");

            $sth->bindValue(':title', $data['title'], PDO::PARAM_STR);
            $sth->bindValue(':status', (int) $data['status'], PDO::PARAM_INT);
            $sth->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $sth->bindValue(':id', (int) $data['id'], PDO::PARAM_INT);

            return ($sth->execute()) ? true : false;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function delete() {
        try {
            $dateTime = new DateTime();
            $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));

            $data = $this->nlDataProvider->getData();
            $sth = Connection::open($localconnection = true)->prepare(
                    "UPDATE wp_news_campanha SET status = :status
              WHERE id = :id
            ");

            $sth->bindValue(':status', $data['status'], PDO::PARAM_INT);
            $sth->bindValue(':id', (int) $data['id'], PDO::PARAM_INT);

            return ($sth->execute()) ? true : false;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function findAll() {
        $sth = Connection::open($localconnection = true)->prepare(
                "SELECT * FROM wp_news_campanha ORDER BY id DESC LIMIT 3");

        $sth->execute();
        while ($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }

        return $objects ? $objects : false;
    }

    public function findFirst() {
        $sth = Connection::open($localconnection = true)->prepare(
                "SELECT * FROM wp_news_campanha ORDER BY id DESC LIMIT 1");

        $sth->execute();
        while ($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }

        return $objects ? $objects : false;
    }

    public function findById($id) {
        if (is_integer($id)) {
            $sth = Connection::open($localconnection = true)->prepare(
                    "SELECT * FROM wp_news_campanha WHERE id = :id ORDER BY id DESC LIMIT 1");
            $sth->bindValue(":id", $id, PDO::PARAM_INT);
            $sth->execute();

            while ($obj = $sth->fetchObject(__CLASS__)) {
                $objects[] = $obj;
            }

            return $objects ? $objects : false;
        }
    }

}

class DaoLogs extends Dao {

    public function persist() {
        try {
            $dateTime = new DateTime();
            $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));

            $data = $this->nlDataProvider->getData();
            $sth = Connection::open($localconnection = true)->prepare(
                    "INSERT INTO wp_news_logs (log,title,description)
            VALUES (
              :log,:title,:description)
           ");
            //$dateTime->format('Y-m-d H:i:s')
            $sth->bindValue(':log', $data['log'], PDO::PARAM_STR);
            $sth->bindValue(':title', "class:  " . __CLASS__ . " method: " . __FUNCTION__, PDO::PARAM_STR);
            $sth->bindValue(':description', " ", PDO::PARAM_STR);
            return ($sth->execute()) ? true : false;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function findFirst() {
        $sth = Connection::open($localconnection = true)->prepare(
                "SELECT * FROM wp_news_logs ORDER BY id DESC LIMIT 1");

        $sth->execute();
        while ($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }

        return $objects ? $objects : false;
    }

}

class Logs extends Model {

    public function get_log() {
        return $this->data['log'];
    }

    public function set_log($log) {
        $this->data['log'] = json_encode($log);
    }

}

class Leads extends Model {

    const active_newslleter = 1;
    const inactive = 2;
    const canceled = 3;
    const ebook_request = 4;
    const msg = 5;
    const modal = 6;
    const descadastrado = 7;

    public function set_name($name) {
        $this->data['name'] = (isset($name)) ? filter_var(trim($name), FILTER_SANITIZE_STRING) : null;
    }

    public function get_name() {
        return $this->data['name'];
    }

    public function set_email($email) {
        $this->data['email'] = filter_var(trim($email), FILTER_VALIDATE_EMAIL);
    }

    public function get_email() {
        return $this->data['email'];
    }

    public function set_msg($msg) {
        $this->data['msg'] = (isset($msg)) ? strip_tags(trim($msg)) : null;
    }

    public function get_msg() {
        return $this->data['msg'];
    }

    public function set_ebookHidden($ebookHidden) {
        $this->data['button_book'] = (isset($ebookHidden)) ? filter_var(trim($ebookHidden), FILTER_SANITIZE_STRING) : null;
        $booksMeta = explode(":", substr($this->data['button_book'], 0));
        $this->data["book_name"] = $booksMeta[0];
        $this->data['button_book'] = $booksMeta[1] . $booksMeta[2];
    }

    public function get_ebookHidden() {
        return $this->data['button_book'];
    }

    public function set_bookName($bookName) {
        $this->data['book_name'] = $bookName;
    }

    /* @method set_status int $status
     *
     *     a variável status será passada para a chave estrangeira grupos_id
     *     se a variável status tiver o mesmo valor de uma constante da classe Leads
     */

    public function set_status($status) {

        if ($status == 1 || $status > 3 || $status < 7) {
            $this->data['grupos_id'] = $status;
            $this->data['status'] = $status;
        } else {
            $this->data['status'] = $status;
        }
    }

    public function get_bookName() {
        return $this->data['book_name'];
    }

}

class Message extends Model {

    const ATIVO = 1;
    const INATIVO = 0;
    const VISUALIZADA = 2;

    public function set_title($title) {
        $this->data['title'] = (isset($title)) ? strip_tags(trim($title)) : null;
    }

    public function get_title() {
        return $this->data['title'];
    }

    public function set_body($body) {
        $this->data['body'] = (isset($body)) ? $body : null;
    }

    public function get_body() {
        return $this->data['body'];
    }

}

class Campanha extends Model {

    const ATIVO = 1;
    const INATIVO = 2;
    const EM_ANDAMENTO = 3;
    const ENVIADA = 4;
    const PROBLEMA_ENVIO = 5;

}

class Grupos extends Model {

    protected $manyToMany = 'grupos_leads(grupo_id, lead_id)';
    protected $name;
    protected $datecreated, $dateupdated;
    protected $tags = 'json';
    protected $status;
    
    public function set_tags($tags){
        $this->data['tags'] = explode(",", $tags);
    }
    
    public function get_tags(){
        return $this->data['tags'];
    }
}

class Newslleter extends Model {

    const ATIVO = 1;
    const INATIVO = 0;
    const EM_ANDAMENTO = 3;
    const ENVIADA = 4;
    const PROBLEMA_ENVIO = 5;

    /* protected $many_to_many = 'grupos_news(grupo_id, newslleter_id)';
      protected $envio;
      protected $status;
      protected $title;
      /*TEST A-B
      protected $Newslleter;
      protected $datecreated, $dateupdated;
      protected $porcentagem = "json";
      protected $grupos;
     */

    public function addEnvio(Envio $envio) {
        $this->data['envio'][] = $envio;
    }

    public function getEnvio() {
        return $this->data['envio'];
    }

    public function addGrupos(array $grupos) {
        $this->data['grupos'] = $grupos;
    }

    public function getGrupos() {
        return $this->data['grupos'];
    }

}

class Envio extends Model {
    /*
      protected $manyToMany = 'evio_periodo(envio_id, periodo_id)';
      protected $Log = ['one to one'];
      protected $Template = ['one to one'];
      protected $Message = ['one to onoe'];
      protected $datecreated, $dateupdated;
      protected $periodo;
     */

    public function addPeriodo(Periodo $periodo) {
        $this->data['periodo'][] = $periodo;
    }

    public function getPeriodo() {
        return $this->data['periodo'];
    }

}

class Periodo extends Model {

    protected $diaInicial, $diaFinal;
    protected $status;

    public function get_data_de_envio_fixo() {
        return $this->data['data_de_envio_fixo'];
    }

}

class Template extends Model {

    const ATIVO = 1;
    const INATIVO = 0;

    public function set_title($title) {
        $this->data['title'] = (isset($title)) ? strip_tags($title) : null;
    }

    public function get_title() {
        return $this->data['title'];
    }

    public function setMessage(Message $msg) {
        $sth = Connection::open($localconnection = true)->prepare(
                "SELECT * FROM wp_news_messages WHERE title = :title");

        $sth->bindValue(':title', $msg->title, PDO::PARAM_STR);
        $sth->execute();

        while ($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }
        $this->data['message_id'] = $objects[0]->id;
    }

    public function getMessage() {
        return $this->data['message_id'];
    }

    public function set_body_template($body) {
        $this->data['body_template'] = (isset($body)) ? strip_tags($body) : null;
    }

    public function get_body() {
        return $this->data['body_template'];
    }

}

class LeadsController {

    public static function actionPersist() {
        if (isset($_POST['lead-request-persist']) && $_POST['lead-request-persist'] != "") {
            $lead = new Leads();
            $lead->email = $_POST['lead-mail'];
            $lead->name = $_POST['lead-nome'];
            $lead->ip = $_SERVER['REMOTE_ADDR'];
            $lead->msg = "cadastro.admin";
            $lead->book_id = 0;
            $lead->status = Leads::active_newslleter;
            $lead->date_created = date("Y-m-d H:i:s");
            $lead->date_updated = date("Y-m-d H:i:s");
            $lead->empresa = $_POST['lead-empresa'];
            $lead->cargo = $_POST['lead-cargo'];
            $lead->site = $_POST['lead-site'];
            $lead->area_atuacao = $_POST['lead-area-atuacao'];
            $lead->method = "admin";
            $lead->lead_grupo_id = $_POST['lead-grupos_id'];
            $dataProvider = new LeadsDataProvider($lead);
            //$dataProvider->setReturnType('array');
            $dao = new DaoLeads();
            $dao->setDataProvider($dataProvider);
            $dao->store();
            $result = $dao->findFirst();
            echo(json_encode($result));
            exit;
        }
    }

    public static function actionPostUpdate() {
        if (isset($_POST['lead-request-update']) && $_POST['lead-request-update'] != "") {
            $lead = new Leads();
            $lead->id = $_POST['lead-id-upd'];
            $lead->email = $_POST['lead-mail-upd'];
            $lead->name = $_POST['lead-name-upd'];
            $lead->ip = $_SERVER['REMOTE_ADDR'];
            $lead->msg = "cadastro.admin";
            $lead->book_id = 0;
            $lead->status = $_POST['lead-status-upd'];
            $lead->date_created = date("Y-m-d H:i:s");
            $lead->date_updated = date("Y-m-d H:i:s");
            $lead->empresa = $_POST['lead-empresa-upd'];
            $lead->cargo = $_POST['lead-cargo-upd'];
            $lead->site = $_POST['lead-site-upd'];
            $lead->area_atuacao = $_POST['lead-area-atuacao-upd'];
            $lead->method = "admin";
            $lead->lead_grupo_id = $_POST['lead-grupos_id-upd'];
            $dataProvider = new LeadsDataProvider($lead);
            //$dataProvider->setReturnType('array');
            $dao = new DaoLeads();
            $dao->setDataProvider($dataProvider);
            $dao->update();
            $result = $dao->findFirst();
            echo(json_encode($result));
            exit;
        }
    }

    public function actionUpdate() {
        //var_dump($_GET[]);exit;
        if (isset($_GET['lead_value_id'])) {
            $dao = new DaoLeads;
            $result = $dao->findById((int) $_GET['lead_value_id']);
            echo(json_encode($result));
            exit;
        }
    }

}

class NewslleterController {

    protected static $request;

    public static function init($array) {
        //var_dump(array_chunk($_POST,3));
        if (isset($array)) {
            foreach ($array as $k => $post) {
                if ("template_id_fk:" == substr($k, 0, 15)) {
                    $number['template_id_fk'][] = $post;
                }

                if ("message_id_fk:" == substr($k, 0, 14)) {
                    $number['message_id_fk'][] = $post;
                }

                if ("periodo:" == substr($k, 0, 8)) {
                    $number['periodo'][] = $post;
                }
                if (isset($array['grupos_id'])) {
                    $number['grupos_id'] = $_POST['grupos_id'];
                }
            }
            $number['newslleter-title'] = $_POST['newslleter-title'];
            $number['porcentagem'] = $_POST['porcentagem'];
            self::setRequest($number);
            //var_dump($_POST);exit;
            //var_dump(substr("periodo:115",0,8));exit;
        }
    }

    public function setRequest($request) {
        self::$request = $request;
    }

    public function getRequest() {
        return self::$request;
    }

    public static function persitAction() {
        $post = self::getRequest();
        $news = new Newslleter();
        $news->title = $post['newslleter-title'];
        $news->campaign_id = $post['campanha_id'];
        $news->status = Newslleter::EM_ANDAMENTO;
        $news->porcentagem = $post['porcentagem'];

        for ($z = 0; $z < count($post) - 1; $z++) {
            $envio1 = new Envio();
            $envio1->message_id = $post['message_id_fk'][$z];
            $envio1->template_id = $post['template_id_fk'][$z];
            $envio1->status = 1;
            //periodo:1
            $periodo1 = new Periodo;
            $periodo1->data_de_envio_fixo = $post['periodo'][$z];
            //add Periodo
            $envio1->addPeriodo($periodo1);

            //add envio a newslleter
            $news->addEnvio($envio1);
        }
        //var_dump($post['grupos_id']);exit;
        $news->addGrupos($post['grupos_id']);
        //var_dump($news->envio[0]->periodo);exit;
        $dataProvider = new NewslleterDataProvider($news);
        $dao = new DaoNewslleter();
        $dao->setDataProvider($dataProvider);
        $dao->persist();
        $redirect = "http://localhost/wp-admin/admin.php?page=news.admin.php";
        header("location:$redirect");
    }

    public function actionUpdate() {
        //var_dump($_GET[]);exit;
        if (isset($_GET['newslleter_value_id'])) {
            $dao = new DaoNewslleter;
            $result = $dao->findById((int) $_GET['newslleter_value_id']);
            echo(json_encode($result));
            exit;
        }
    }

    public function actionPostUpdate() {
        if (isset($_POST['newslleter-id-upd'])) {
            $news = new Newslleter();
            $news->id = $_POST['newslleter-id-upd'];
            $news->campaign_id = $_POST['campanha_id'];
            $news->title = $_POST['newslleter-title-upd'];
            $news->status = $_POST['newslleter-status-upd'];
            $news->porcentagem = $_POST['newslleter-porcentagem-upd'];
            $dataProvider = new NewslleterDataProvider($news);
            $dao = new DaoNewslleter();
            $dao->setDataProvider($dataProvider);
            $dao->update();
            $result = $dao->findFirst();
            echo(json_encode($result));
            exit;
        }
    }

}

class CampanhaController {

    public static function actionPersist() {
        if (isset($_POST["campanha-request-persist"])) {
            $campanha = new Campanha;
            $campanha->title = $_POST['campanha-title'];
            $campanha->status = Campanha::ATIVO;
            $campanha->date_created = date("Y-m-d H:i:s");
            $campanha->date_updated = date("Y-m-d H:i:s");
            $dataProvider = new CampanhaDataProvider($campanha);
            $daoc = new DaoCampanha();
            $daoc->setDataProvider($dataProvider);
            $daoc->persist();
            $result = $daoc->findFirst();
            echo(json_encode($result));
            exit;
        }
    }

    public function actionUpdate() {
        //var_dump($_GET[]);exit;
        if (isset($_GET['campanha_value_id'])) {
            $daocampanha = new DaoCampanha;
            $campanhaResult = $daocampanha->findById((int) $_GET['campanha_value_id']);
            echo(json_encode($campanhaResult));
            exit;
        }
    }

    public function actionPostUpdate() {
        if (isset($_POST['campanha-id-upd'])) {
            //var_dump($_POST);exit;
            $campanha = new Campanha;
            $campanha->id = (int) $_POST['campanha-id-upd'];
            $campanha->title = $_POST['campanha-title-upd'];
            $campanha->status = $_POST['campanha-status-upd'];
            $campanha->date_created = date("Y-m-d H:i:s");
            $campanha->date_updated = date("Y-m-d H:i:s");
            $dataProvider = new CampanhaDataProvider($campanha);
            $daoc = new DaoCampanha();
            $daoc->setDataProvider($dataProvider);
            $daoc->update();
            $result = $daoc->findFirst();
            echo(json_encode($result));
            exit;
        }
    }

}

class TemplateController {

    public static function actionPersist() {
        if (isset($_POST["template-request-persist"])) {
            $tpl = new Template;
            $tpl->title = $_POST['template-title'];
            $tpl->body_template = $_POST['template-body'];
            $tpl->status = Template::ATIVO;
            $tpl->date_created = date("Y-m-d H:i:s");
            $tpl->date_updated = date("Y-m-d H:i:s");
            $dataProvider = new TemplateDataProvider($tpl);
            $daot = new DaoTemplate();
            $daot->setDataProvider($dataProvider);
            $daot->persist();
            $result = $daot->findFirst();
            echo(json_encode($result));
            exit;
        }
    }

    public function actionLoadDataForm() {
        //var_dump($_GET[]);exit;
        if (isset($_GET['template_value_id'])) {
            $dao = new DaoTemplate;
            $result = $dao->findById((int) $_GET['template_value_id']);
            echo(json_encode($result));
            exit;
        }
    }

    public function actionUpdate() {
        if (isset($_POST['template-id-upd'])) {
            //var_dump($_POST);exit;
            $tpl = new Template;
            $tpl->id = (int) $_POST['template-id-upd'];
            $tpl->title = $_POST['template-title-upd'];
            $tpl->status = $_POST['template-status-upd'];
            $tpl->message_id = 87;
            $tpl->body_template = $_POST['template-body-upd'];
            $dataProvider = new TemplateDataProvider($tpl);
            $dao = new DaoTemplate();
            $dao->setDataProvider($dataProvider);
            $dao->update();
            $result = $dao->findFirst();
            echo(json_encode($result));
            exit;
        }
    }

}

class MessageController {

    public static function actionPersist() {
        if (isset($_POST["message-request-persist"])) {
            $msg = new Message;
            $msg->title = $_POST['message-title'];
            $msg->body = $_POST['message-body'];
            $msg->status = Message::ATIVO;
            $msg->date_created = date("Y-m-d H:i:s");
            $msg->date_updated = date("Y-m-d H:i:s");
            $dataProvider = new MessageDataProvider($msg);
            $dao = new DaoMessage();
            $dao->setDataProvider($dataProvider);
            $dao->persist();
            $result = $dao->findFirst();
            echo(json_encode($result));
            exit;
        }
    }

    public function actionLoadDataForm() {
        //var_dump($_GET[]);exit;
        if (isset($_GET['message_value_id'])) {
            $dao = new DaoMessage;
            $result = $dao->findById((int) $_GET['message_value_id']);
            echo(json_encode($result));
            exit;
        }
    }

    public function actionObservaAbertura() {
        //var_dump($_GET[]);exit;
        if (isset($_GET['message_mail_value_id'])) {
            $dao = new DaoMessage;
            $result = $dao->registraAbertura((int) $_GET['message_mail_value_id']);
            echo(json_encode($result));
            exit;
        }
    }

    public function actionUpdate() {
        if (isset($_POST['message-id-upd'])) {
            //var_dump($_POST);exit;
            $msg = new Message;
            $msg->id = (int) $_POST['message-id-upd'];
            $msg->title = $_POST['message-title-upd'];
            $msg->status = $_POST['message-status-upd'];
            $msg->body = $_POST['message-body-upd'];
            $dataProvider = new MessageDataProvider($msg);
            $dao = new DaoMessage();
            $dao->setDataProvider($dataProvider);
            $dao->update();
            $result = $dao->findFirst();
            echo(json_encode($result));
            exit;
        }
    }

}

class GruposController {

    public static function actionPersist() {
        if (isset($_POST["grupos-request-persist"])) {
            $grupo = new Grupos;
            $grupo->name = $_POST['grupos-name'];
            $grupo->tags = $_POST['grupos-tags'];
            $grupo->status = 1;
            $dataProvider = new GruposDataProvider($grupo);
            $dao = new DaoGrupos();
            $dao->setDataProvider($dataProvider);
            $dao->persist();
            $result = $dao->findFirst();
            echo(json_encode($result));
            exit;
        }
    }
}

if ($_POST || $_GET) {
    //@Campanha Controller Methods
    CampanhaController::actionPersist();
    CampanhaController::actionUpdate();
    CampanhaController::actionPostUpdate();
//@Template Controller Methods
    TemplateController::actionPersist();
    TemplateController::actionLoadDataForm();
    TemplateController::actionUpdate();
//@Message Controller Methods
    MessageController::actionPersist();
    MessageController::actionLoadDataForm();
    MessageController::actionUpdate();
    MessageController::actionObservaAbertura();

    if (isset($_POST['newslleter-title'])) {
        NewslleterController::init($_POST);
        NewslleterController::persitAction();
    }

    NewslleterController::actionUpdate();
    NewslleterController::actionPostUpdate();
//@Leads
    LeadsController::actionPersist();
    LeadsController::actionUpdate();
    LeadsController::actionPostUpdate();
    
    GruposController::actionPersist();
}