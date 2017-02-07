<?php
//declare(strict_types=1);
class DataProvider {
    protected $nl,$dataType, $transformedData;

    public function __construct($object, $type = null){
        $this->nl = $object;
        if(isset($this->nl)){
            $this->transformedData = $this->nl->getData();
        }
    }

    public function getData(){
      return $this->transformedData;
    }
}

class LeadsDataProvider extends DataProvider {

  public function __construct($object){
    parent::__construct($object);
  }
}

class MessageDataProvider extends DataProvider {

  public function __construct($object){
    parent::__construct($object);
  }
}
class TemplateDataProvider extends DataProvider {

  public function __construct($object){
    parent::__construct($object);
  }
}
class GruposDataProvider extends DataProvider {
    public function __construct($object){
      parent::__construct($object);
    }
}

final class Connection {

  protected static $conn;
  /*
  const DATABASE_CONF = [
    "dbname"=>"d3e7040odgf0s7",
    "host"=>"ec2-204-236-218-242.compute-1.amazonaws.com",
    "username"=>"rjikommzhlyatb",
    "password"=> "7c3ae88652c3ea9b27612a5009163c2c1b86fab876efd9231bfa84f958955cb4"
  ];
  */
  static $DATABASE_CONF = array(
    "dbname"=>"wordpress",
    "host"=>"localhost",
    "username"=>"postgres",
    "password"=> "silvia25"
  );

  static $DATABASE_CONF_REMOTE = array(
    "dbname"=>"wordpress",
    "host"=>"wordpress.clo6jnwupfzu.us-west-2.rds.amazonaws.com",
    "username"=>"postgres",
    "password"=> "silvia25"
  );

  final public function __construct(){}

  public static function get(){
    if(isset(self::$conn)){
      return self::$conn;
    }
    else{
      self::open();
    }
  }

  public static function close(){
    if(isset(self::$conn)){
      self::$conn = null;
    }
  }

  public static function open($connType=null){
    if(isset($connType) || isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost'){
        self::$conn = new PDO("pgsql:dbname=" .  self::$DATABASE_CONF["dbname"] .
        " host=" . self::$DATABASE_CONF["host"], self::$DATABASE_CONF["username"],
        self::$DATABASE_CONF["password"], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING) );
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$conn;
    }
    else{
        self::$conn = new PDO("pgsql:dbname=" .  self::$DATABASE_CONF_REMOTE["dbname"] .
        " host=" . self::$DATABASE_CONF_REMOTE["host"], self::$DATABASE_CONF_REMOTE["username"],
        self::$DATABASE_CONF_REMOTE["password"], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING) );
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$conn;
    }
  }
}
class Dao {

    protected $wpdb, $nlDataProvider, $table;

    public function __construct($wpdb=null){
        if($wpdb instanceOf wpdb || $wpdb instanceOf wpdb2){
          $this->wpdb = $wpdb;
      }
    }

    public function setDataProvider(DataProvider $nlDataProvider){
      $this->nlDataProvider = $nlDataProvider;
    }

    public function setTable($table){
      $this->table = $this->wpdb->prefix .  $table;
    }
}

class DaoLeads extends Dao {

  protected $wpdb, $nlDataProvider, $conn;

  public function store(){
    $data = $this->nlDataProvider->getData();
    if(!isset($data)){
      throw new Exception("Nenhum dado a ser persistido", 1);
    }

    if($this->persistBook($data) ||
    $this->persistModal($data) ||
    $this->persistNewslleter($data) ||
    $this->persistContact($data)){
      return true;
    }
    else{
      return false;
    }
  }

  public function persistModal($data){
    $dateTime = new DateTime();
    $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));
    //@modal
    if($data['method'] == 'modal'){

       try {
         $sth3 = Connection::open($localconnection=true)->prepare("INSERT INTO wp_news_leads
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
         $sth3->bindValue(':status', Leads::modal , PDO::PARAM_INT);
         $sth3->bindValue(':grupos_id', $data['grupos_id'] , PDO::PARAM_INT);
         $sth3->bindValue(':datecreated', $dateTime->format('Y-m-d H:i:s') , PDO::PARAM_STR);
         $sth3->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s') , PDO::PARAM_STR);
         return ($sth3->execute()) ? true : false;

         } catch (PDOException $e) {
           echo 'Connection failed: ' . $e->getMessage();
         }
    }
  }

  public function persistNewslleter($data){
    $dateTime = new DateTime();
    $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));
    //@newslleter persist
    if($data['method'] == "newslleter"){
      try {
        $sth = Connection::open($localconnection=true)->prepare("INSERT INTO wp_news_leads
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
        $sth->bindValue(':status', $data['status'] , PDO::PARAM_INT);
        $sth->bindValue(':grupos_id', $data['grupos_id'] , PDO::PARAM_INT);
        //date
        $sth->bindValue(':datecreated', $dateTime->format('Y-m-d H:i:s') , PDO::PARAM_STR);
        $sth->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s') , PDO::PARAM_STR);

        $sth->execute();
        return $this->persitFkLeadsGroup($data, $dateTime);
        //$objects[0];


        } catch (PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
        }
      }
  }

  public function persitFkLeadsGroup($data,$dateTime){
      //seleciona a lead inserida
      $sth1 = Connection::get($localconnection=true)->prepare(
      "SELECT email, datecreated, grupos_id, id FROM wp_news_leads
       WHERE email = :email
       AND datecreated::date = to_date('{$dateTime->format('Y-m-d')}' ,'YYYY-MM-DD')
       AND grupos_id = :grupos_id
       ORDER BY id DESC");

      $sth1->bindValue(':email', $data['email'] , PDO::PARAM_STR);
      $sth1->bindValue(':grupos_id', $data['status'] , PDO::PARAM_INT);
      $sth1->execute();
      //percorre os elementos e armazena
      while($obj = $sth1->fetchObject(__CLASS__)) {
          $object[] = $obj;
      }
      //insere a id da lead e do grupo na tabela manyToMany
      $sth2 = Connection::get($localconnection=true)->prepare(
      "INSERT INTO wp_grupos_leads
      (grupos_id, leads_id) VALUES (:grupos_id, :leads_id)");

      $sth2->bindValue(':grupos_id', (int)$object[0]->grupos_id , PDO::PARAM_INT);
      $sth2->bindValue(':leads_id', (int)$object[0]->id , PDO::PARAM_INT);
      return ($sth2->execute()) ? true : false;
  }

  public function persistContact($data){
    $dateTime = new DateTime();
    $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));

    if($data['method'] == 'contact'){
        try {

          $sth4 = Connection::open($localconnection=true)->prepare("INSERT INTO wp_news_leads
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
              $sth4->bindValue(':status', $data['status'] , PDO::PARAM_INT);
              $sth4->bindValue(':grupos_id', $data['grupos_id'] , PDO::PARAM_INT);
              $sth4->bindValue(':datecreated', $dateTime->format('Y-m-d H:i:s') , PDO::PARAM_STR);
              $sth4->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s') , PDO::PARAM_STR);
              $sth4->execute();
              return $this->persitFkLeadsGroup($data, $dateTime);
       } catch (PDOException $e) {
         echo 'Connection failed: ' . $e->getMessage();
       }
    }
  }

  public function persistBook(array $data){
    //@Book persist
    $dateTime = new DateTime();
    $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));

    if(isset($data["button_book"]) && $data["button_book"] != ''){

       try {
         $sth = Connection::open($localconnection=true)->prepare(
            "INSERT INTO wp_book (title,datecreated,dateupdated)
             VALUES (
               :title, :datecreated,:dateupdated)
            ");

         $sth->bindValue(':title', $data['book_name'] . ":". $data['button_book'] , PDO::PARAM_STR);
         $sth->bindValue(':datecreated', $dateTime->format('Y-m-d H:i:s') , PDO::PARAM_STR);
         $sth->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s') , PDO::PARAM_STR);

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
         $sth3->bindValue(':status', $data['status'] , PDO::PARAM_INT);
         $sth3->bindValue(':grupos_id', $data['grupos_id'] , PDO::PARAM_INT);
         $sth3->bindValue(':datecreated', $dateTime->format('Y-m-d H:i:s') , PDO::PARAM_STR);
         $sth3->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s') , PDO::PARAM_STR);
         $sth3->execute();

         return $this->persitFkLeadsGroup($data, $dateTime);

         } catch (PDOException $e) {
           echo 'Connection failed: ' . $e->getMessage();
         }
    }
  }

  public function exportList(){
    $sth = Connection::open($localconnection=true)->prepare("SELECT DISTINCT name, email FROM wp_news_leads");
    $sth->execute();
    while($obj = $sth->fetchObject(__CLASS__)) {
        $objects[] = $obj;
    }

    echo "name ; email <br>";
    foreach ($objects as $k => $news) {
      echo $news->name . " ; " . $news->email . "<br>";
    }
  }

  public function getAll(){
    $sth = Connection::open($localconnection=true)->prepare("SELECT * FROM wp_news_leads ORDER by id DESC");
    $sth->execute();
    while($obj = $sth->fetchObject(__CLASS__)) {
        $objects[] = $obj;
    }
    return $objects;
  }

  /*
  *emails recebidos do dia.
  */
  public function emailsForToday(){
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
    $sth = Connection::open($localconnection=true)->prepare(
    "SELECT * FROM wp_news_leads
     WHERE datecreated::date >= to_date('{$formatedDate}' ,'YYYY-MM-DD') ORDER BY id DESC");

    $sth->execute();
    while($obj = $sth->fetchObject(__CLASS__)) {
        $objects[] = $obj;
    }
    return $objects ? $objects : false;
  }


  public function update(){

  }

  public function destroy(){

  }
}

class DaoGrupos extends Dao {

    public function findAll($limit = null){
        if(isset($limit)){
            $sth = Connection::open($localconnection=true)
            ->prepare("SELECT * FROM wp_grupos ORDER by id DESC LIMIT :limit");
            $sth->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        else{
            $sth = Connection::open($localconnection=true)
            ->prepare("SELECT * FROM wp_grupos ORDER by id DESC");
        }

        $sth->execute();
        while($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }

        return $objects;
    }
}

abstract class Model {

    protected $data;

    public function __construct(){
    }

    public function getData(){
      if(isset($this->data)){
          return $this->data;
      }else{
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

    public function __get(string $prop) {
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

class Leads extends Model {

  const active_newslleter = 1;
  const inactive = 2;
  const canceled = 3;
  const ebook_request = 4;
  const msg = 5;
  const modal = 6;

  public function set_name($name){
    $this->data['name'] = (isset($name)) ? filter_var(trim($name), FILTER_SANITIZE_STRING) : null;
  }

  public function get_name() {
    return $this->data['name'];
  }

  public function set_email($email){
      $this->data['email'] = filter_var(trim($email), FILTER_VALIDATE_EMAIL);
  }

  public function get_email(){
    return $this->data['email'];
  }

  public function set_msg($msg){
    $this->data['msg'] = (isset($msg)) ? strip_tags(trim($msg)) : null;
  }

  public function get_msg(){
    return $this->data['msg'];
  }

  public function set_ebookHidden($ebookHidden){
    $this->data['button_book'] = (isset($ebookHidden)) ? filter_var(trim($ebookHidden), FILTER_SANITIZE_STRING) : null;
    $booksMeta = explode(":", substr($this->data['button_book'], 0));
    $this->data["book_name"] = $booksMeta[0];
    $this->data['button_book'] = $booksMeta[1] . $booksMeta[2];
  }

  public function get_ebookHidden() {
    return $this->data['button_book'];
  }

  public function set_bookName($bookName){
    $this->data['book_name'] = $bookName;
  }

  /*@method set_status int $status
  *
  *     a variável status será passada para a chave estrangeira grupos_id
  *     se a variável status tiver o mesmo valor de uma constante da classe Leads
  */
  public function set_status($status){

      if($status == 1 || $status > 3  || $status < 7){
         $this->data['grupos_id'] = $status;
         $this->data['status'] = $status;
      }
      else{
          $this->data['status'] = $status;
      }
  }

  public function get_bookName(){
    return $this->data['book_name'];
  }
}

class Message extends Model {

  const active = 1;
  const inactive = 0;

  public function set_title($title){
      $this->data['title'] = (isset($title)) ? strip_tags(trim($title)) : null;
  }

  public function get_title(){
      return $this->data['title'];
  }

  public function set_body($body){
      $this->data['body'] = (isset($body)) ? strip_tags($body) : null;
  }

  public function get_body(){
      return $this->data['body'];
  }
}

class DaoMessage extends Dao {
  public function persist(){
    try {
      //recebe os dados de um dataProvider
      $dateTime = new DateTime();
      $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));

      $data = $this->nlDataProvider->getData();
      $sth = Connection::open($localconnection=true)->prepare(
         "INSERT INTO wp_news_messages (title,body,status,datecreated,dateupdated)
          VALUES (
            :title, :body, :status, :datecreated,:dateupdated)
         ");

      $sth->bindValue(':title', $data['title'], PDO::PARAM_STR);
      $sth->bindValue(':body', $data['body'], PDO::PARAM_STR);
      $sth->bindValue(':status', $data['status'], PDO::PARAM_INT);
      $sth->bindValue(':datecreated', $dateTime->format('Y-m-d H:i:s') , PDO::PARAM_STR);
      $sth->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s') , PDO::PARAM_STR);

      return ($sth->execute()) ? true : false;

      } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
      }
  }


  public function delete(){
    try {
      $data = $this->nlDataProvider->getData();
      //recebe os dados de um dataProvider
      if(is_integer($data['id'])){

        $dateTime = new DateTime();
        $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));

        $sth = Connection::open($localconnection=true)->prepare("UPDATE
           wp_news_messages SET status = :status, dateupdated = :dateupdated WHERE id = :id
        ");

        $sth->bindValue(':status', $data['status'] , PDO::PARAM_INT);
        $sth->bindValue(':id', (int) $data['id'] , PDO::PARAM_INT);
        $sth->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s') , PDO::PARAM_STR);

        return ($sth->execute()) ? true : false;

      }

     } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
  }


    public function update(){
      try {
        $data = $this->nlDataProvider->getData();
        //recebe os dados de um dataProvider
        if(is_integer($data['id'])){

          $dateTime = new DateTime();
          $dateTime->setTimeZone(new DateTimeZone('America/Fortaleza'));

          $sth = Connection::open($localconnection=true)->prepare(
            "UPDATE wp_news_messages
            SET title = :title, body = :body, status = :status, dateupdated = :dateupdated
            WHERE id = :id
          ");
          $sth->bindValue(':title', $data['title'], PDO::PARAM_STR);
          $sth->bindValue(':body', $data['body'], PDO::PARAM_STR);
          $sth->bindValue(':status', $data['status'] , PDO::PARAM_INT);
          $sth->bindValue(':id', (int) $data['id'] , PDO::PARAM_INT);
          $sth->bindValue(':dateupdated', $dateTime->format('Y-m-d H:i:s') , PDO::PARAM_STR);

          return ($sth->execute()) ? true : false;

        }

       } catch (PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
      }
    }

    public function findAll(){
        $sth = Connection::open($localconnection=true)->prepare(
        "SELECT * FROM wp_news_messages ORDER BY id DESC LIMIT 10");

        $sth->execute();
        while($obj = $sth->fetchObject(__CLASS__)) {
            $objects[] = $obj;
        }
        return $objects ? $objects : false;
      }
}

class Grupos extends Model {
    protected $manyToMany = 'grupos_leads(grupo_id, lead_id)';
    protected $name;
    protected $datecreated, $dateupdated;
    protected $tags = 'json';
    protected $status;
}

class Newslleter extends Model {
    protected $many_to_many = 'grupos_news(grupo_id, newslleter_id)';
    protected $Envio;
    protected $status;
    protected $title;
    /*TEST A-B */
    protected $Newslleter;
    protected $datecreated, $dateupdated;
    protected $porcentagem = "json";
}

class Envio extends Model {
        protected $manyToMany = 'evio_periodo(envio_id, periodo_id)';
        protected $Log = ['one to one'];
        protected $Template = ['one to one'];
        protected $Message = ['one to onoe'];
        protected $datecreated, $dateupdated;
}

class Periodicidade extends Model {
    protected $diaInicial, $diaFinal;
    protected $status;
}

class Template extends Model {
  const active = 1;
  const inactive = 0;

  public function set_title($title){
      $this->data['title'] = (isset($title)) ? strip_tags($title) : null;
  }

  public function get_title(){
      return $this->data['title'];
  }

  public function setMessage(Message $msg){
    $sth = Connection::open($localconnection=true)->prepare(
       "SELECT * FROM wp_news_messages WHERE title = :title");

    $sth->bindValue(':title', $msg->title, PDO::PARAM_STR);
    $sth->execute();

    while($obj = $sth->fetchObject(__CLASS__)) {
        $objects[] = $obj;
    }
    $this->data['message_id'] = $objects[0]->id;
  }

  public function getMessage(){
    return $this->data['message_id'];
  }

  public function set_body_template($body){
      $this->data['body_template'] = (isset($body)) ? strip_tags($body) : null;
  }

  public function get_body(){
      return $this->data['body_template'];
  }
}

class DaoTemplate extends Dao {
  public function persist(){
    try {
      $data = $this->nlDataProvider->getData();
      $sth = Connection::open($localconnection=true)->prepare(
         "INSERT INTO wp_news_template (title, body_template, message_id, status)
          VALUES (
            :title, :body_template, :message_id, :status)
         ");

      $sth->bindValue(':title', $data['title'], PDO::PARAM_STR);
      $sth->bindValue(':body_template', $data['body_template'], PDO::PARAM_STR);
      $sth->bindValue(':message_id', $data['message_id'], PDO::PARAM_INT);
      $sth->bindValue(':status', Template::active, PDO::PARAM_INT);

      return ($sth->execute()) ? true : false;

      } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
      }
  }


  public function update(){
    try {
      $data = $this->nlDataProvider->getData();
      $sth = Connection::open($localconnection=true)->prepare(
         "UPDATE wp_news_template SET title = :title, body_template = :body_template,
          message_id = :message_id, status = :status
          WHERE id = :id
        ");

      $sth->bindValue(':title', $data['title'], PDO::PARAM_STR);
      $sth->bindValue(':body_template', $data['body_template'], PDO::PARAM_STR);
      $sth->bindValue(':message_id', (int)$data['message_id'], PDO::PARAM_INT);
      $sth->bindValue(':status', Template::active, PDO::PARAM_INT);
      $sth->bindValue(':id', (int)$data['id'], PDO::PARAM_INT);

      return ($sth->execute()) ? true : false;

      } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
      }
  }

  public function delete(){
      try {
        $data = $this->nlDataProvider->getData();
        $sth = Connection::open($localconnection=true)->prepare(
           "UPDATE wp_news_template SET status = :status
            WHERE id = :id
          ");

        $sth->bindValue(':status', $data['status'], PDO::PARAM_INT);
        $sth->bindValue(':id', (int)$data['id'], PDO::PARAM_INT);

        return ($sth->execute()) ? true : false;

        } catch (PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
        }
  }

  public function findAll(){
      $sth = Connection::open($localconnection=true)->prepare(
      "SELECT * FROM wp_news_template ORDER BY id DESC LIMIT 10");

      $sth->execute();
      while($obj = $sth->fetchObject(__CLASS__)) {
          $objects[] = $obj;
      }
      return $objects ? $objects : false;
  }
}

class Logs extends Model {

}
/*
class MailSender {

    protected $data;

    public function __construct(NewslleterDataProvider $dataProvider){
      $dataProvider->setReturnType('array');
      $this->data = $dataProvider->getData();
    }

    public function phpMailerWrapper(PHPMailer $mailer){
        $this->phpMailer = $mailer;
        return $this->phpMailer;
    }

    public function send($behavior){
      $closure = function() use ($behavior){
        $behavior();
      };

      $closure();
    }

    public function getData(){
      return $this->data;
    }
}
//$sender = new MailSender($news);
//$sender->
**/
