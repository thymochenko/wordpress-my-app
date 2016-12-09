/*
global $wpdb;
$table = $wpdb->prefix . 'newslleter_contact';

 $wpdb->insert($table,
  ['name'=>'timo 2',
  'email'=>'timocabral@gmail.com',
  'ip'=>'1',
   'status'=>1,
   'date_created'=> current_time( 'mysql' ),
   'date_updated'=> current_time( 'mysql' )
  ]);

$results = $wpdb->get_results( "SELECT * FROM {$table}" );
var_dump($results);
*/
?>
