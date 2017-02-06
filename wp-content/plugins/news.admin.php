<?php
require_once 'news.core.php';
$dataProvider = new LeadsDataProvider(new Leads());
$dp_grupos = new GruposDataProvider(new Grupos());
$daog = new DaoGrupos();
$grupos = $daog->findAll();
GLOBAL $wpdb;
$dao = new DaoLeads($wpdb);
$dao->setDataProvider($dataProvider);
$dao->setTable('wp_news_leads');

?>
<html>
<head>
    <script type="text/javascript"
    			  src="https://code.jquery.com/jquery-3.1.1.min.js"
    			  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    			  crossorigin="anonymous"></script>


              <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

          <!-- Optional theme -->
          <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

          <!-- Latest compiled and minified JavaScript -->
          <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
          <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
  $(function() {
      $("#add-grupo").click(function(){
      $("#myModal").modal('show');
    });

    $('#grupo_button').click(function(event) {
       event.preventDefault();

       $.ajax(this.href, {
          success: function(data) {
              var data = $('#grupos-action').serializeArray().reduce(function(obj, item) {

                  obj[item.name] = item.value;
                  $('.selectpicker').append('<option  selected="selected" value="' + item.name +
                   '">' + item.value +'</option>')
                  .selectpicker('refresh');

                  return obj;
              }, {});


              // alert($("#grupos-action").val("160").attr("selected","selected"));

               $('#test').append('<option val="100">One</option>');
             //$('#main').html($(data).find('#main *'));
             //$('#notification-bar').text('The page has been successfully loaded');
          },
          error: function() {
              alert('err');
             //$('#notification-bar').text('An error occurred');
          }
       });
    });

  });
</script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.32/jquery.form.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/jquery.validate.min.js"></script>

</head>
<style>
.responstable {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #167f92;
    border-radius: 10px;
    color: #024457;
    margin: 1em 0;
    overflow: hidden;
    width: 100%;
}
.responstable tr {
    border: 1px solid #d9e4e6;
}
.responstable tr:nth-child(2n+1) {
    background-color: #eaf3f3;
}
.responstable th {
    background-color: #167f92;
    border: 1px solid #fff;
    color: #fff;
    display: none;
    padding: 1em;
}
.responstable th:first-child {
    display: table-cell;
    text-align: center;
}
.responstable th:nth-child(2) {
    display: table-cell;
}
.responstable th:nth-child(2) span {
    display: none;
}
.responstable th:nth-child(2)::after {
    content: attr(data-th);
}
@media (min-width: 480px) {
.responstable th:nth-child(2) span {
    display: block;
}
.responstable th:nth-child(2)::after {
    display: none;
}
}
.responstable td {
    display: block;
    max-width: 7em;
    overflow-wrap: break-word;
}
.responstable td:first-child {
    border-right: 1px solid #d9e4e6;
    display: table-cell;
    text-align: center;
}
@media (min-width: 480px) {
.responstable td {
    border: 1px solid #d9e4e6;
}
}
.responstable th, .responstable td {
    margin: 0.5em 1em;
    text-align: left;
}
@media (min-width: 480px) {
.responstable th, .responstable td {
    display: table-cell;
    padding: 1em;
}
}
</style>
</head>
<body>
<div id="last-msg">
  <h2>Últimas Leads recebidas nos últmos 5 dias :
     <span style="color:red">[<?php echo count($collMsgForLast5Days);?>]</span></h2>
  <h3></h3>
</div>
<div class="menu-admin-wp-news">
  <h3><a href="?export=true">Export Contacts</a></h3>
</div>
<table class="responstable">
<thead>
<tr>
<th style="padding: .7em .3em; text-align: center; font-weight: bold; border: 0; ">nome</th>
<th>email</th>
<th>data</th>
<th>tipo</th>
</tr>
</thead>
<tbody>
  <?php
   if($dao->emailsForToday()):
   foreach($dao->emailsForToday() as $lead):?>
<tr>
    <td style=""><?php  echo $lead->name ?></td>
    <td><?php  echo $lead->email ?></td>
    <td><?php  if(isset($lead->datecreated)):?><b style="color:red;"><?php  echo $lead->datecreated ?></b><?php endif; ?></td>
    <td> <?php  if ($lead->status == Leads::active_newslleter):?> Newslleter Ativo <?php endif; ?>
      <?php  if ($lead->status == Leads::inactive):?> Inativo <?php endif; ?>
      <?php  if ($lead->status == Leads::canceled):?> cancelado <?php endif; ?>
      <?php  if ($lead->status == Leads::ebook_request):?> Ebook  <?php echo @$lead->title ?> <?php endif; ?>
      <?php  if ($lead->status == Leads::msg):?> Mensagem <?php endif; ?>
      <?php  if ($lead->status == Leads::modal):?> Modal <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
<?php endif; ?>

</tbody>
</table>
<h1>Todas as leads Cadastradas</h1>
<table class="responstable">
<thead>
<tr>
<th style="padding: .7em .3em; text-align: center; font-weight: bold; border: 0; ">nome</th>
<th>email</th>
<th>data</th>
<th>tipo</th>
</tr>
</thead>
<tbody>
  <?php
   foreach($dao->getAll() as $lead):?>
<tr>
    <td style=""><?php  echo $lead->name ?></td>
    <td><?php  echo $lead->email ?></td>
    <td><?php  if(isset($lead->datecreated)):?><b style="color:red;"><?php  echo $lead->datecreated ?></b><?php endif; ?></td>
    <td> <?php  if ($lead->status == Leads::active_newslleter):?> Newslleter Ativo <?php endif; ?>
      <?php  if ($lead->status == Leads::inactive):?> Inativo <?php endif; ?>
      <?php  if ($lead->status == Leads::canceled):?> cancelado <?php endif; ?>
      <?php  if ($lead->status == Leads::ebook_request):?> Ebook  <?php echo @$lead->title ?> <?php endif; ?>
      <?php  if ($lead->status == Leads::msg):?> Mensagem <?php endif; ?>
      <?php  if ($lead->status == Leads::modal):?> Modal <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

<!-- modal grupos -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Grupos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="grupos-action" action="news.admin.php" id="grupos-action" method="post">
            <?php foreach($grupos as $g): ?>
                <input type="checkbox" name="grupo" id="check-grupo" value="<?php echo $g->name; ?>">
                <?php echo $g->name; ?><br>
            <?php endforeach; ?>
             <input type="button" class="btn btn-primary" name="grupo" id="grupo_button" value="add"/>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- /modal grupos -->
    <h1>Cadastro de newslleter</h1>
    <form name="newslleter_send" id="news_send" method="post" action="news.core.php">
        <h2>Adicionar um grupo de Leads: <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" id="add-grupo">Add</button></h2>
        <h3>Selecione os grupos de Leads - <span style="font-size:13px;">Total de leads selecionadas para este envio <span style="color:red">(3)</span></span> </h3>
        <select class="selectpicker" name="grupos"  multiple>
            <?php foreach($daog->findAll(5) as $gp): ?>
                <option value="<?php echo $gp->id ?>"><?php echo $gp->name ?></option>
            <?php endforeach; ?>

        </select>

    </form>
</body>
</html>
