<?php
declare(strict_types=1);
class NewslleterDataProvider {

  protected $nl,$dataType, $transformedData;

  public function __construct(Newslleter $newslleter){
      $this->nl = $newslleter;
  }

  public function setReturnType(string $type){
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

class DaoNewslleter {

  protected $wpdb, $nlDataProvider;

  public function __construct(wpdb $wpdb){
      $this->wpdb = $wpdb;
  }

  public function setDataProvider(NewslleterDataProvider $nlDataProvider){
    $this->nlDataProvider = $nlDataProvider;
  }

  public function setTable(string $table){
    $this->table = $this->wpdb->prefix .  $table;
  }

  public function store() : bool {
    if(!isset($this->wpdb)){
      throw new Exception("wpdb is not set", 1);
    }
    $data = $this->nlDataProvider->getData();

    if(isset($data["button_book"])){

      $this->wpdb->insert("wp_book", ["title"=>$data['book_name'],
       "date_created"=> current_time( 'mysql' ), "date_updated"=> current_time( 'mysql' )]);

      $book = $this->wpdb->get_results('SELECT id FROM wp_book ORDER BY id DESC limit 1');
      $data['book_id'] = $book[0]->id;

      unset($data['book_name']);
      unset($data['button_book']);

       return ($this->wpdb->insert($this->table, $data)) ? true : false;
    }

    return ($this->wpdb->insert($this->table, $data)) ? true : false;
  }

  public function getAll() : array {
    $result1 = $this->wpdb->get_results(
    'SELECT * FROM ' . $this->table . ' as n');

    $result2 = $this->wpdb->get_results(
    'SELECT DISTINCT * FROM ' . $this->table . ' as n
    INNER JOIN wp_book AS b ON n.book_id = b.id

    ', object);
    $data = [];
    $objects = ['news'=>$result1, 'books'=>$result2];
    for($i =0; $i < count($objects['news']); $i++){
      if($objects['books'][$i]->title){
        $objects['news'][] = $objects['books'][$i];
        unset($objects['books']);
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

  public function getData(): array {
    if(isset($this->data)){
        return $this->data;
    }else{
      return [];
    }
  }

  public function __set(string $prop, $value) {
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

  public function set_name(string $name){
    $this->data['name'] = (isset($name)) ? filter_var(trim($name), FILTER_SANITIZE_STRING) : null;
  }

  public function get_name() : string {
    return $this->data['name'];
  }

  public function set_email(string $email){
      $this->data['email'] = filter_var(trim($email), FILTER_VALIDATE_EMAIL);
  }

  public function get_email(): string {
    return $this->data['email'];
  }

  public function set_msg(string $msg){
    $this->data['msg'] = (isset($msg)) ? strip_tags(trim($msg)) : null;
  }

  public function get_msg() : string {
    return $this->data['msg'];
  }

  public function set_ebookHidden($ebookHidden){
    $this->data['button_book'] = (isset($ebookHidden)) ? filter_var(trim($ebookHidden), FILTER_SANITIZE_STRING) : null;
    $this->data['book_name'] = substr($this->data['button_book'], 8);
  }

  public function get_ebookHidden() : string {
    return $this->data['button_book'];
  }

  public function set_bookName($bookName){
    $this->data['book_name'] = $bookName;
  }

  public function get_bookName() : string {
    return $this->data['book_name'];
  }

}

class MailSender {

    protected $data;

    public function __construct(NewslleterDataProvider $dataProvider){
      $dataProvider->setReturnType('array');
      $this->data = $dataProvider->getData();
    }

    public function phpMailerWrapper(PHPMailer $mailer) : PHPMailer {
        $this->phpMailer = $mailer;
        return $this->phpMailer;
    }

    public function send($behavior){
      $closure = function() use ($behavior){
        $behavior();
      };

      $closure();
    }

    public function getData(): array {
      return $this->data;
    }
}
//$sender = new MailSender($news);
//$sender->
