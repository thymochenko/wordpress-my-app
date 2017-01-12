<?php
//declare(strict_types=1);
class NewslleterDataProvider {

  protected $nl,$dataType, $transformedData;

  public function __construct(Newslleter $newslleter){
      $this->nl = $newslleter;
  }

  public function setReturnType($type){
    if($type == 'array'){
      $this->dataType = 'array';
      if($this->nl->getData()){
          $this->transformedData = $this->nl->getData();
      }
    }else if ($type == 'json'){
      $this->transformedData = json_decode($this->nl->getData());
    }
  }

  public function getData(){
    return $this->transformedData;
  }
}

final class Connection {

  protected static $conn;

  const DATABASE_CONF = [
    "dbname"=>"wordpress",
    "host"=>"localhost",
    "username"=>"postgres",
    "password"=> "silvia25"
  ];

  final public function __construct(){}

  public static function get(){
    if(isset(self::$conn)){
      return self::$conn;
    }
    else{
      self::open();
    }
  }

  public static function open(){
    self::$conn = new PDO("pgsql:dbname=" .  self::DATABASE_CONF["dbname"] .
     " host=" . self::DATABASE_CONF["host"], self::DATABASE_CONF["username"],
     self::DATABASE_CONF["password"], [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING] );
     self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     return self::$conn;
  }
}


class DaoNewslleter {

  protected $wpdb, $nlDataProvider, $conn;

  public function __construct($wpdb){
      if($wpdb instanceOf wpdb || $wpdb instanceOf wpdb2){
        $this->wpdb = $wpdb;
    }
  }

  public function setDataProvider(NewslleterDataProvider $nlDataProvider){
    $this->nlDataProvider = $nlDataProvider;
  }

  public function setTable($table){
    $this->table = $this->wpdb->prefix .  $table;
  }

  public function store(){
    if(!isset($this->wpdb)){
      throw new Exception("wpdb is not set", 1);
    }

    $data = $this->nlDataProvider->getData();
    //@Book persist
    if(isset($data["button_book"])){
      /*
       "date_created"=> current_time( 'mysql' ), "date_updated"=> current_time( 'mysql' )]);
       $bool = $this->wpdb->insert("wp_book", ["title"=>$data['book_name'],

      $book = $this->wpdb->get_results('SELECT id FROM wp_book ORDER BY id DESC limit 1');
      $data['book_id'] = $book[0]->id;

      unset($data['book_name']);
      unset($data['button_book']);

       return ($this->wpdb->insert($this->table, $data)) ? true : false;
       */
       //@newslleter persist
       try {
         $sth = Connection::open()->prepare(
            "INSERT INTO wp_book (title,datecreated,dateupdated)
             VALUES (
               :title, :datecreated,:dateupdated)
            ");

         $sth->bindValue(':title', $data['book_name'] . ":". $data['button_book'] , PDO::PARAM_STR);
         $sth->bindValue(':datecreated', date("Y-m-d H:i:s") , PDO::PARAM_STR);
         $sth->bindValue(':dateupdated', date("Y-m-d H:i:s") , PDO::PARAM_STR);

         $sth->execute();
         $sth2 = Connection::open()->prepare("SELECT id FROM wp_book ORDER BY id DESC limit 1");
         $sth2->execute();

         $result = $sth2->fetch(PDO::FETCH_OBJ);

         $sth3 = Connection::open()->prepare("INSERT INTO wp_newslleter_contact
           (name,email,ip, msg, book_id, status,datecreated, dateupdated)
             VALUES (
               :name,
               :email,:ip,:msg,
               :book_id, :status,
               :datecreated,:dateupdated)
            ");

         $sth3->bindValue(':name', $data["name"], PDO::PARAM_STR);
         $sth3->bindValue(':email', $data["email"], PDO::PARAM_STR);
         $sth3->bindValue(':ip', "192.168.0.1", PDO::PARAM_STR);
         $sth3->bindValue(':msg', "newslleter:ebook", PDO::PARAM_STR);
         $sth3->bindValue(':book_id', $result->id, PDO::PARAM_INT);
         $sth3->bindValue(':status',Newslleter::STATUS['ebook_request'] , PDO::PARAM_INT);
         $sth3->bindValue(':datecreated', date("Y-m-d H:i:s") , PDO::PARAM_STR);
         $sth3->bindValue(':dateupdated', date("Y-m-d H:i:s") , PDO::PARAM_STR);
         var_dump($data);
         var_dump($result->id);
         var_dump($sth->execute());exit;
         return ($sth->execute()) ? true : false;

         } catch (PDOException $e) {
           echo 'Connection failed: ' . $e->getMessage();
         }
    }
    //@newslleter persist
    try {
      $sth = Connection::open()->prepare("INSERT INTO wp_newslleter_contact
        (name,email,ip, msg, book_id, status,datecreated, dateupdated)
          VALUES (
            :name,
            :email,:ip,:msg,
            :book_id, :status,
            :datecreated,:dateupdated)
         ");

      $sth->bindValue(':name', "newslleter:index", PDO::PARAM_STR);
      $sth->bindValue(':email', $data["email"], PDO::PARAM_STR);
      $sth->bindValue(':ip', "192.168.0.1", PDO::PARAM_STR);
      $sth->bindValue(':msg', "newslleter:index", PDO::PARAM_STR);
      $sth->bindValue(':book_id', 0, PDO::PARAM_INT);
      $sth->bindValue(':status',Newslleter::STATUS['active_newslleter'] , PDO::PARAM_INT);
      $sth->bindValue(':datecreated', date("Y-m-d H:i:s") , PDO::PARAM_STR);
      $sth->bindValue(':dateupdated', date("Y-m-d H:i:s") , PDO::PARAM_STR);

      return ($sth->execute()) ? true : false;

      } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
      }
    //return ($this->wpdb->insert($this->table, $data)) ? true : false;
  }

  public function getAll(){
    $result1 = $this->wpdb->get_results(
    'SELECT * FROM ' . $this->table . ' as n');

    @$result2 = $this->wpdb->get_results(
    'SELECT DISTINCT * FROM ' . $this->table . ' as n
    INNER JOIN wp_book AS b ON n.book_id = b.id

    ', object);
    $data = [];
    if(isset($result1)){
        $objects = ['news'=>$result1, 'books'=>@$result2];
        for($i =0; $i < count($objects['news']); $i++){
          if(isset($objects['books'][$i]->title)){
            $objects['news'][] = $objects['books'][$i];
            unset($objects['books']);
          }
        }
    }

    return $objects;
  }

  public function update(){

  }

  public function destroy(){

  }
}

class Newslleter {

  protected $data;

  const STATUS = ['active_newslleter'=>1, 'inactive'=>2, 'canceled'=>3,
   'ebook_request' => 4, 'msg' => 5];

  public function __construct(){

  }

  public function getData(){
    if(isset($this->data)){
        return $this->data;
    }else{
      return [];
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

  public function get_bookName(){
    return $this->data['book_name'];
  }

}

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
