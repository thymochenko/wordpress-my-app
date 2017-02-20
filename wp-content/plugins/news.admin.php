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
$daot = new DaoTemplate();
$template = $daot->findAll();
$daom = new DaoMessage();
$message = $daom->findAll();
$daocampanha = new DaoCampanha();
$_campanha = $daocampanha->findAll();
$daon = new DaoNewslleter();
$newslleter = $daon->findAll();

if($_POST['newslleter-title']){
    $news = new NewslleterController();
    $news->init($_POST);
    $news->persitAction();
}

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
      //exibe modal de persistẽncia de grupo
      $("#add-grupo").click(function(){
      $("#myModal").modal('show');
    });
    //exibe modal de persistẽncia de templates
    $("#add-template").click(function(){
        $("#templateModal").modal('show');
    });
    //exibe modal de persistẽncia de mensagens
    $("#add-message").click(function(){
        $("#messageModal").modal('show');
    });
    //fecha todas as janelas
    $(".close").click(function(){
        $('#templateModal, #messageModal').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });
/*
    $(".campanha-block-info-inicial").hide();
    $("#campanha-responstable").hide();
    $(".campanha-tbody").hide();

    //$(".campanhas-block-content").show();
    $(".template-block-info-inicial").hide();
    $("#template-responstable").hide();
    $(".template-tbody").hide();
//
    //show message
    $(".message-block-info-inicial").hide();
    $("#message-responstable").hide();
    $(".message-tbody").hide();
    */
    //$(".newslleter-block-content").show();

    //bloco das leads
    //$("#inicial-block-content").hide();
                /*
            *@newslleter-form
            *adiciona um template a newslleter
            */
        $('#radio_tpl').click(function(event) {
           event.preventDefault();
           $.ajax(this.href, {
              success: function(data) {
                  //dados do form
                  var data = $('#template-action').serializeArray().reduce(function(obj, item) {
                      //monta view com o post dos dados do form
                      var coll = item.value.split(":");
                      coll[0]; // template Title
                      obj[item.name] = item.value;
                      $('#template-title').append(coll[0] + " | ").hide().fadeIn();
                      $('#template-title').append('<input type="hidden" name="template_id_fk" id="template_id_dinamic_attrib" value="' + coll[1] + '"/>');
                      $('#template-title').append('<input type="hidden" name="template_title_fk" id="template_title_dinamic_attrib" value="' + coll[0] + '"/>');
                      return obj;
                  }, {});
              },
              error: function() {
                  alert('err');
                 //$('#notification-bar').text('An error occurred');
              }
           });
        });

        /*
        *@newslleter-form
        *adiciona uma mensagem a newslleter
        */
    $('#radio-msg').click(function(event) {
       event.preventDefault();
       var data = $('#message-action').serializeArray().reduce(function(obj, item) {
           //monta view com o post dos dados do form
           var coll = item.value.split(":");
           coll[0]; // template Title
           obj[item.name] = item.value;
           $('#message-title').append(coll[0]  + " | ").hide().fadeIn(1000);
           //adiciona um elemento via ajax diretamente na div que exibe as propriedades de envio
           $('.message_id_fk_div').append(coll[1]);
           $('#message-title').append('<input type="hidden" name="message_id_fk" value="' + coll[1] + '"/>');
           $('#message-title').append('<input type="hidden" name="message_title_fk" value="' + coll[0] + '"/>');
           return obj;
       }, {});
    });

    /*method: persist domain:@newslleter
    */
    $('#newslleter-action').on('click', '#newslleter-add',function(event) {
       event.preventDefault();
       var count = 0;
       var data = $('#newslleter-action').serializeArray().reduce(function(obj, item) {
           //monta view com o post dos dados do form
           var valueName = item.value.split(":");
           obj['valueName'] = valueName;
           obj[item.name] = item.value;
           return obj;
       }, {});
       //alert(data['valueName'][1]);
       //gera números randomicos para os Ids
       function getRandomInt(min, max) {
           return Math.floor(Math.random() * (max - min)) + min;
       }
       var id = getRandomInt(100,200);
       //saida para a visualização de envios para a newslleter
       $("#boxDataProperties").append('<h4 class="alert alert-success">Periodo de Envio: | <b><i>'
        + data["dataInicial"] + '</i></b> | ' + " Template: | <b><i>" + data["template_title_fk"] + '</b></i> | Mensagem: | <b><i>' +
    '<span class="message_id_fk_div">' + data["message_title_fk"] + " | </span></h4>").hide().fadeIn(1000);

       //fks

       $("#prop-envio-id").html(function(i,count){
           var count = 0;
           return parseInt(++count);
       });

       $("#boxDataProperties").append('<input type="hidden" name="message_id_fk:'+  id +'" value="' + data["message_id_fk"] + '"/>');
       $("#boxDataProperties").append('<input type="hidden" name="periodo:' + id + '" value="' + data["dataInicial"] + '"/>');
       $("#boxDataProperties").append('<input type="hidden" name="template_id_fk:'+ id + '" id="template_id_dinamic_attrib" value="' + data["template_id_fk"] + '"/>');
    });

    /*@newslleter-form
    *adiciona dados de periodicidade ao form de news
    */
    $('#periodicidade-add').click(function(event) {
       event.preventDefault();

       $.ajax(this.href, {
          success: function(data) {
              //dados do form
              var data = $('#newslleter-action').serializeArray().reduce(function(obj, item) {
                  //monta view com o post dos dados do form
                  var coll = item.value.split(":");
                  coll[0]; // template Title
                  //alert( item.name  + " : " + item.value);
                  obj[item.name] = item.value;
                  $('#data-title').append(obj["dataInicial"]  + " | ").hide().fadeIn();
                  $('#data-title').append('<input type="hidden" name="periodo" value="' + obj["dataInicial"] + '"/>');
                  return obj;
              }, {});
          },
          error: function() {
              alert('err');
          }
       });

    });

    /*@newslleter-form
    *method:load grupos para o formulário de cadastro de newslleter
    */
    $("#grupos-action").on('click', '#grupo_button', function(event) {
       event.preventDefault();
       $.ajax(this.href, {
          success: function(data) {
              var data = $('#grupos-action').serializeArray().reduce(function(obj, item) {
                  var coll = item.value.split(":");
                  var grupo_id = coll[0];
                  var grupo_name = coll[1];
                  obj[item.name] = item.value;
                  $('.selectpicker').append('<option  selected="selected" value="' + grupo_id +
                   '">' + grupo_name +'</option>').selectpicker('refresh');

                  return obj;
              }, {});
          },
          error: function() {
              alert('err');
             //$('#notification-bar').text('An error occurred');
         }
       });
    });
    //links

    /*@Campanha
    *method: carrega dados para o form de update domain:@Campanha
    */
    $(document).on('click',".campanha-link-update", function(event){
        event.preventDefault();
        //mostra form de atualização
        $("#campanhaModal").modal("show");

        $.ajax(this.href, { success: function(data) {
            //dados do form
            var resource = $.parseJSON(data);
            $('.campanha-title-upd').val(resource[0].title);
            $('.campanha-id-upd').val(resource[0].id);
            },
            error: function() {
                      alert('error');
                  }
            });
    });

     /**
     * method:link domain:@campanha
     *
     **/
    $(document).on("click", '.campanhas-link', function(event) {
         event.preventDefault();
         //fecha bloco de template
         alert("ok");
         //$(".template-block-info-inicial").hide();
         //$("#template-responstable").hide();
         //$(".template-tbody").hide();
         //fecha bloco de newslleter
        // $(".newslleter-block-content").hide();
         //bloco index (default)
         //$("#inicial-block-content").hide();
         //abre o bloco de conteúdo com fadeIn
         //hide message
         //$(".message-block-info-inicial").hide();
         //$("#message-responstable").hide();
         //$(".message-tbody").hide();
         $("#newslleter-action").hide();
         $("#inicial-block-content").hide();
         $(".newslleter-block-info-inicial").hide();
         $("#newslleter-responstable").hide();
         $("#template-responstable").hide();
         $("#message-responstable").hide();

         $(".template-block-info-inicial").hide();
         $(".message-block-info-inicial").hide();


    });


    /* method:persist domain:@Campanha
    *
    */
    $(document).on('click', '#cadastro-campanha-send',function(event){
               //ajax post
              $.post("news.core.php", $('#campanha-action-form').serializeArray())
              .done(function( data ) {
                  var resource = $.parseJSON(data);
                  var status = "";
                  if(resource[0].status == "1"){
                       status = "ATIVO";
                  }
                  //view (exibe os dados persistidos em uma tabela)
                   var line = '<tr> <td style="background-color:#B0C4DE" class="campanha-title-td"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"> </span> ' + resource[0].title + '</td>' +
                      '<td style="background-color:#B0C4DE" class="campanha-date-td">' + resource[0].datecreated + '</td>' +
                      '<td style="background-color:#B0C4DE" class="campanha-status-td">' + status + '</td>' +
                      '<td style="background-color:#B0C4DE" class="campanha-actions-td">' +
                      '<a class="campanha-link-update" href="news.core.php?campanha_value_id=' + resource[0].id + '">' +
                      '<button type="button" class="campanha-update-table-button" class="btn btn-default ">' +
                         '<span class="glyphicon glyphicon-new-window" aria-hidden="true"> </span>' +
                      '</button></a>' +
                       '<button type="button" class="btn btn-default campanha-destroy-action">' +
                         '<span class="glyphicon glyphicon-fire" aria-hidden="true"> </span>' +
                      '</button></td>' +
                  '</tr>';

                      $('.campanha-tbody').append(line).hide().fadeIn('slow');

              });
    });

    /* method:update domain:@Campanha
    *
    */
    $('.campanha-update-button').click(function(event) {
         event.preventDefault();
         $.post("news.core.php", $('.campanha-action-update').serializeArray())
         .done(function( data ) {
          var resource = $.parseJSON(data);
            alert("Campanha Atualizada com Sucesso");
            location.reload();
        });
    });

    /* ================================= @Template Context =====================================*/
    /* =========================================================================================*/
    /**
    * method:link domain:@Template
    *
    **/
    $(document).on("click", '.templates-link', function(event) {
        event.preventDefault();
        //fecha bloco de newslleter
    //    $("#test-template").load('template_block_content.php');
    //fecha bloco de newslleter
        //$("#inicial-block-content").hide();
        //$(".newslleter-block-content").show();
        //bloco index (default)
        //alert("vai dar certo");

        //$(".campanha-block-info-inicial").hide();
        //$("#campanha-responstable").hide();
        //$(".campanha-tbody").hide();

        //hide message
        //$(".message-block-info-inicial").hide();
        //$("#message-responstable").hide();
        //$(".message-tbody").hide();
        //$(".campanhas-block-content").show();
        //$(".template-block-info-inicial").show();
        //$("#template-responstable").show();
        //$(".template-tbody").show();
    //

    });
    /* method:persist domain:@Campanha
    *
    */
    $(document).on('click', '#cadastro-template-send',function(event){
               //ajax post
              $.post("news.core.php", $('#template-action-form').serializeArray())
              .done(function( data ) {
                  var resource = $.parseJSON(data);
                  var status = "";
                  if(resource[0].status == "1"){
                       status = "ATIVO";
                  }
                  //view (exibe os dados persistidos em uma tabela)
                   var line = '<tr> <td style="background-color:#B0C4DE" class="template-title-td"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"> </span> ' + resource[0].title + '</td>' +
                      '<td style="background-color:#B0C4DE" class="template-status-td">' + status + '</td>' +
                      '<td style="background-color:#B0C4DE" class="template-actions-td">' +
                      '<a class="template-link-update" href="news.core.php?template_value_id=' + resource[0].id + '">' +
                      '<button type="button" class="template-update-table-button" class="btn btn-default ">' +
                         '<span class="glyphicon glyphicon-new-window" aria-hidden="true"> </span>' +
                      '</button></a>' +
                       '<button type="button" class="btn btn-default campanha-destroy-action">' +
                         '<span class="glyphicon glyphicon-fire" aria-hidden="true"> </span>' +
                      '</button></td>' +
                  '</tr>';

                      $('.template-tbody').append(line).hide().fadeIn('slow');

              });
          });

          /*@Template update Modal
          *method: carrega dados para o form de update domain:@Template
          */
          $(document).on('click',".template-link-update", function(event){
              event.preventDefault();
              //mostra form de atualização
              $("#templateModalUpdate").modal("show");

              $.ajax(this.href, { success: function(data) {
                  //dados do form
                  var resource = $.parseJSON(data);
                  $('.template-title-upd').val(resource[0].title);
                  $('.template-body-upd').val(resource[0].body_template);
                  $('.template-id-upd').val(resource[0].id);
                  },
                  error: function() {
                            alert('error');
                        }
                  });
          });

          /* method:update domain:@Template
          * Método que atualiza as informações do form via post e atualiza a página
          */
          $('.template-update-button').click(function(event) {
               event.preventDefault();
               $.post("news.core.php", $('.template-action-update').serializeArray())
               .done(function( data ) {
                var resource = $.parseJSON(data);
                  alert("Template Atualizada com Sucesso");
                  location.reload();
              });
          });

          /* ================================= @Message Context =====================================*/
          /* =========================================================================================*/
          /**
          * method:link domain:@Message
          *
          **/
          $(document).on("click", '.message-link', function(event) {
              event.preventDefault();
              //fecha bloco de newslleter
          //    $("#test-template").load('template_block_content.php');
          //fecha bloco de newslleter
        //      $("#inicial-block-content").hide();
        //      $(".newslleter-block-content").hide();
              //bloco index (default)
              //alert("vai dar certo");

              //$(".campanha-block-info-inicial").hide();
            //  $("#campanha-responstable").hide();
              //$(".campanha-tbody").hide();

              //$(".campanhas-block-content").show();
        //      $(".template-block-info-inicial").hide();
        //      $("#template-responstable").hide();
        //      $(".template-tbody").hide();
          //
              //show message
        //      $(".message-block-info-inicial").show();
        //      $("#message-responstable").show();
        //      $(".message-tbody").show();
          });

          /* method:persist domain:@Message
          *
          */
          $(document).on('click', '#cadastro-message-send',function(event){
                     //ajax post
                    $.post("news.core.php", $('#message-action-form').serializeArray())
                    .done(function( data ) {
                        var resource = $.parseJSON(data);
                        var status = "";
                        if(resource[0].status == "1"){
                             status = "ATIVO";
                        }
                        //view (exibe os dados persistidos em uma tabela)
                         var line = '<tr> <td style="background-color:#B0C4DE" class="message-title-td"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"> </span> ' + resource[0].title + '</td>' +
                            '<td style="background-color:#B0C4DE" class="message-status-td">' + status + '</td>' +
                            '<td style="background-color:#B0C4DE" class="message-body-td">' + resource[0].body + '</td>' +
                            '<td style="background-color:#B0C4DE" class="message-actions-td">' +
                            '<a class="message-link-update" href="news.core.php?message_value_id=' + resource[0].id + '">' +
                            '<button type="button" class="message-update-table-button" class="btn btn-default ">' +
                               '<span class="glyphicon glyphicon-new-window" aria-hidden="true"> </span>' +
                            '</button></a>' +
                             '<button type="button" class="btn btn-default campanha-destroy-action">' +
                               '<span class="glyphicon glyphicon-fire" aria-hidden="true"> </span>' +
                            '</button></td>' +
                        '</tr>';

                            $('.message-tbody').append(line).hide().fadeIn('slow');

                    });
                });

                /*@Template update Modal
                *method: carrega dados para o form de update domain:@Template
                */
                $(document).on('click',".message-link-update", function(event){
                    event.preventDefault();
                    //mostra form de atualização
                    $("#messageModalUpdate").modal("show");

                    $.ajax(this.href, { success: function(data) {
                        //dados do form
                        var resource = $.parseJSON(data);
                        alert(resource[0].body);
                        $('.message-title-upd').val(resource[0].title);
                        $('.message-body-upd').val(resource[0].body);
                        $('.message-id-upd').val(resource[0].id);
                        },
                        error: function() {
                                  alert('error');
                              }
                        });
                });

                /* method:update domain:@Template
                * Método que atualiza as informações do form via post e atualiza a página
                */
                $('.message-update-button').click(function(event) {
                     event.preventDefault();
                     $.post("news.core.php", $('.message-action-update').serializeArray())
                     .done(function( data ) {
                      var resource = $.parseJSON(data);
                        alert("Mensagem Atualizada com Sucesso");
                        location.reload();
                    });
                });
    });
    </script>

</head>
<style>
#boxDataProperties {
    border-style: dashed;
    border-color: #ccc;
    background-color: #f4f4f4;
}

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

    <!-- menu -->
    <ul class="nav nav-tabs">
      <li class="active"><a href="#">Newslleter</a></li>
      <li><a class="campanhas-link" href="#">Campanhas</a></li>
      <li><a class="templates-link" href="#">Templates</a></li>
      <li><a class="message-link" href="#">Mensagens</a></li>
      <li><a class="relatorios-link" href="#">Relatórios</a></li>
      <li><a class="agendados-link"href="#">Agendados</a></li>
      <li><a class="logs-link" href="#">Logs</a></li>
      <li><a class="leads-link" href="#">Leads</a></li>
    </ul>
<!-- /menu -->
<!-- inicial block content -->

<!-- inicial bloc content -->
<div id="inicial-block-content">
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
</div>
<!-- block inicial -->

<section class="newslleter-block-content">

   <form name="newslleter-action" id="newslleter-action" method="post" action="admin.php?page=news.admin.php">
       <h1>Cadastro de newslleter</h1>
       <h4>Título da Newslleter: </h4>
       <input type="text" name="newslleter-title" value=""><br>
       <h4>Porcentagem total do Envio: </h4>
       <input type="text" name="porcentagem" value=""><br>
       <h4>Adicionar um grupo de Leads: <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" id="add-grupo">Add</button></h4>
       <h4>Selecione os grupos de Leads - <span style="font-size:13px;">Total de leads selecionadas para este envio <span style="color:red">(3)</span></span> </h4>
       <select class="selectpicker" name="grupos_id[]"  multiple>
           <?php foreach($daog->findAll(5) as $gp): ?>
               <option value="<?php echo $gp->id ?>"><?php echo $gp->name ?></option>
           <?php endforeach; ?>
       </select>
       <h4>Propriedades de Envio </h4>
       <h5>Adicionar Template <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-template" id="add-template">Add</button></h5>
       <h5>Adicionar Mensagem <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-message" id="add-message">Add</button></h5>
       <h3>Adicionar Periodicidade </h3>
       Data de Envio : <input types="text" name="dataInicial"/><button type="button" class="btn btn-primary" data-target="#periodicidade-add" id="periodicidade-add">Add</button><br><br>
       <!-- caixas para inserção de envio-->
       <div id="boxDataProperties">
           <h4>Propriedades de Envio: #número:  <span style="color:red" id="prop-envio-id"></span></h4>
           Template e Escolhido : <b><span id="template-title"></span></b><br>
           Mensagem Escolhida : <b><span id="message-title"></span></b><br>
           Data de Envio : <b><span id="data-title"></span></b><br>
       </div>

       <!-- end -->
        <input type="submit" class="btn btn-primary" value="Registrar todos os Envios" name="submit">
        <input type="hidden" name="rand-value" value="<?php echo rand(1,100) ?>">
       <input type="button" class="btn btn-primary" name="newslleter" id="newslleter-add" value="add"/>
   </form>


<div class="newslleter-block-info-inicial">

<h1>Newslleter Cadastradas</h1>
</div>
<table id="newslleter-responstable" class="responstable">
<thead>
<tr>
<th>Nome</th>
<th>Status</th>
<th>Ações</th>
</tr>
</thead>
<tbody class="newslleter-tbody">
 <?php
  foreach($newslleter as $news):?>
<tr>
   <td class="newslleter-title-td"><?php  echo $news->title ?></td>
   <td class="newslleter-status-td"> <?php  if ($news->status == Newslleter::ATIVO):?> ATIVO <?php endif; ?>
     <?php  if ($news->status == Message::INATIVO):?> INATIVO <?php endif; ?>
   </td>
   <td class="newslleter-actions-td">
       <a class="newslleter-link-update" href="news.core.php?newslleter_value_id=<?php  echo $news->id ?>">
       <button type="button" class="newslleter-update-table-button" class="btn btn-default ">
           <span class="glyphicon glyphicon-new-window" aria-hidden="true"> </span>
       </button>
       </a>
           <!--<input type="hidden" value="" name="template-action-request" value="template-update-action"/>-->

   <button type="button" class="btn btn-default newslleter-destroy-action">
       <span class="glyphicon glyphicon-fire" aria-hidden="true"> </span>
   </button>
</td>
</tr>
<?php endforeach; ?>
</form>
<!-- Modal message (action:update) -->
<div class="modal fade" id="newslleterModalUpdate" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="exampleModalLabel">template : Atualizando Registro</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body">
         <!-- form update template -->
       <div id="newslleter-form-view">
           <form name="newslleter-action-update" action="news.core.php" class="newslleter-action-update" method="post">
                   Título : <br><br><input type="text" name="newslleter-title-upd" class="newslleter-title-upd" value="">
                   <br><br>
                   <select name="message-status-upd">
                       <option class="option-newslleter-ativo" value="1">ATIVO</option>
                       <option class="option-newslleter-inativo" value="0">INATIVO</option>
                   </select>
                   <br><br>
                    <input type="submit" class="btn btn-primary" value="ATUALIZAR" name="submit">
                   <input type="hidden" name="newslleter-id-upd" class="newslleter-id-upd" value="">
                   <br>
                <input type="button" class="btn btn-primary newslleter-update-button" name="newslleter-update-button" value="atualizar"/>
           </form>
       </div>
       <!--  update message form -->
     </div>
     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
     </div>
   </div>
 </div>
</div>

<!-- grupos -->
<!--  -->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <input type="checkbox" name="grupos" id="check-grupo" value="<?php echo $g->id; ?>:<?php echo $g->name; ?>">
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
<!--  grupos -->

<!--  grupos -->
<!--  Template-->
<div class="modal fade" data-backdrop="static" id="templateModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Template</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="template-action" action="news.admin.php" id="template-action" method="post">
            <?php foreach($template as $tpl): ?>
                <input type="radio" name="template" id="radio-template" value="<?php echo $tpl->title; ?>:<?php echo $tpl->id; ?>">
                <?php echo $tpl->title; ?>
                <br>
            <?php endforeach; ?>
             <input type="button" class="btn btn-primary" name="template" id="radio_tpl" value="add"/>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- templates -->

<!--  Message Modal -->
<div class="modal fade" id="messageModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="message-action" action="news.admin.php" id="message-action" method="post">
            <?php foreach($message as $msg): ?>
                <input type="radio" name="template" id="radio-template" value="<?php echo $msg->title; ?>:<?php echo $msg->id; ?>">
                <?php echo $msg->title; ?>
                <br>
            <?php endforeach; ?>
             <input type="button" class="btn btn-primary" name="message" id="radio-msg" value="add"/>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>
</section>
<!-- Home message-->

<!-- modal message-->

<!-- end newslleter-block-content  -->
<!-- inicial bloc content -->

<!-- close inicial block content -->



<!-- campanhas-block-content  -->
<?php //include_once "campanha_block_content.php"; ?>
<!-- end campanhas-block-content  -->

<!-- template-block-content  -->
<?php //include_once "template_block_content.php"; ?>
<section class="campanhas-block-content">
<!-- Home campanha-->
<div class="campanha-block-info-inicial">
<h1>Cadastro de campanhas</h1>
<h4>Titulo da campanha</h4>
    <form name="campanha-action-form" id="campanha-action-form" method="post" action="admin.php?page=news.admin.php">
        <input type="text" name="campanha-title" value="">
        <input type="submit" class="btn btn-primary" value="submit" name="submit">
        <input type="button" id="cadastro-campanha-send" class="btn btn-primary" name="campanha" value="add"/>
        <input type="hidden" name="campanha-request-persist"  value="1">
    </form>

    <h1>Campanhas Cadastradas</h1>
    <table id="campanha-responstable" class="responstable">
    <thead>
    <tr>
    <th>Nome</th>
    <th>data criação</th>
    <th>Status</th>
    <th>Ações</th>
    </tr>
    </thead>
    <tbody class="campanha-tbody">
      <?php
       foreach($_campanha as $camp):?>
    <tr>
        <td class="campanha-title-td"><?php  echo $camp->title ?></td>
        <td class="campanha-date-td"><?php  echo $camp->datecreated ?></td>
        <td class="campanha-status-td"> <?php  if ($camp->status == Campanha::ATIVO):?> ATIVO <?php endif; ?>
          <?php  if ($camp->status == Campanha::INATIVO):?> INATIVO <?php endif; ?>
          <?php  if ($camp->status == Campanha::EM_ANDAMENTO):?> EM ANDAMENTO <?php endif; ?>
          <?php  if ($camp->status == Campanha::ENVIADA):?> ENVIADA <?php endif; ?>
          <?php  if ($camp->status == Campanha::PROBLEMA_ENVIO):?> PROBLEMA ENVIO <?php endif; ?>
        </td>
        <td class="campanha-actions-td">
            <a class="campanha-link-update" href="news.core.php?campanha_value_id=<?php  echo $camp->id ?>">
            <button type="button" class="campanha-update-table-button" class="btn btn-default ">
                <span class="glyphicon glyphicon-new-window" aria-hidden="true"> </span>
            </button>
            </a>
                <!--<input type="hidden" value="" name="campanha-action-request" value="campanha-update-action"/>-->

        <button type="button" class="btn btn-default campanha-destroy-action">
            <span class="glyphicon glyphicon-fire" aria-hidden="true"> </span>
        </button>
     </td>
    </tr>
    <?php endforeach; ?>
    </form>
    <!-- Home campanha-->

    <!-- Modal campanha (action:update) -->
    <div class="modal fade" id="campanhaModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">campanha : Atualizando Registro</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <!-- form update campanha -->
            <div id="chamada-form-view">
                <form name="campanha-action-update" action="news.core.php" class="campanha-action-update" method="post">
                        Título : <br><br><input type="text" name="campanha-title-upd" class="campanha-title-upd" value="">
                        <br><br>
                        Status:
                        <select name="campanha-status-upd">
                            <option class="option-chamada-ativo" value="1">ATIVO</option>
                            <option class="option-chamada-inativo" value="2">INATIVO</option>
                            <option class="option-chamada-e_andamento" value="3">EM ANDAMENTO</option>
                            <option class="option-chamada-enviada" value="4">ENVIADA</option>
                            <option class="option-chamada-pro_de_envio" value="5">PROBLEMA DE ENVIO</option>
                        </select>
                        <br><br>
                         <input type="submit" class="btn btn-primary" value="ATUALIZAR" name="submit">
                        <input type="hidden" name="campanha-id-upd" class="campanha-id-upd" value="">
                        <br>
                     <input type="button" class="btn btn-primary campanha-update-button" name="campanha-update-button" value="atualizar"/>
                </form>
            </div>
            <!-- /update campanha form -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- /modal campanha-->
</section>
<!-- end campanha-block-template -->

<!-- template-block-template -->
<section class="template-block-content">
<!-- Home template-->
<div class="template-block-info-inicial">
<h1 id="test-template">{Cadastro de Templates}</h1>
<h4>Titulo do Template</h4>
    <form name="template-action-form" id="template-action-form" method="post" action="admin.php?page=news.admin.php">
        <input type="text" name="template-title" value="">
        Corpo do Template <br><textarea name="template-body"></textarea>
        <input type="submit" class="btn btn-primary" value="submit" name="submit">
        <input type="button" id="cadastro-template-send" class="btn btn-primary" name="template" value="add"/>
        <input type="hidden" name="template-request-persist"  value="1">
    </form>

    <h1>templates Cadastradas</h1>
</div>
    <table id="template-responstable" class="responstable">
    <thead>
    <tr>
    <th>Nome</th>
    <th>Status</th>
    <th>Ações</th>
    </tr>
    </thead>
    <tbody class="template-tbody">
      <?php
       foreach($template as $tpl):?>
    <tr>
        <td class="template-title-td"><?php  echo $tpl->title ?></td>
        <td class="template-status-td"> <?php  if ($tpl->status == Template::ATIVO):?> ATIVO <?php endif; ?>
          <?php  if ($tpl->status == Template::INATIVO):?> INATIVO <?php endif; ?>

        </td>
        <td class="template-actions-td">
            <a class="template-link-update" href="news.core.php?template_value_id=<?php  echo $tpl->id ?>">
            <button type="button" class="template-update-table-button" class="btn btn-default ">
                <span class="glyphicon glyphicon-new-window" aria-hidden="true"> </span>
            </button>
            </a>
                <!--<input type="hidden" value="" name="template-action-request" value="template-update-action"/>-->

        <button type="button" class="btn btn-default template-destroy-action">
            <span class="glyphicon glyphicon-fire" aria-hidden="true"> </span>
        </button>
     </td>
    </tr>
    <?php endforeach; ?>
    </form>
    <!-- Home template-->

    <!-- Modal template (action:update) -->
    <div class="modal fade" id="templateModalUpdate" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">template : Atualizando Registro</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <!-- form update template -->
            <div id="template-form-view">
                <form name="template-action-update" action="news.core.php" class="template-action-update" method="post">
                        Título : <br><br><input type="text" name="template-title-upd" class="template-title-upd" value="">
                        <br><br>
                        Template:
                        <textarea class="template-body-upd" name="template-body-upd"></textarea><br>
                        Status:
                        <select name="template-status-upd">
                            <option class="option-template-ativo" value="1">ATIVO</option>
                            <option class="option-template-inativo" value="0">INATIVO</option>
                        </select>
                        <br><br>
                         <input type="submit" class="btn btn-primary" value="ATUALIZAR" name="submit">
                        <input type="hidden" name="template-id-upd" class="template-id-upd" value="">
                        <br>
                     <input type="button" class="btn btn-primary template-update-button" name="template-update-button" value="atualizar"/>
                </form>
            </div>
            <!--  update template form -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- modal template-->
</section>

<!-- end template-block-content  -->

<!-- end template-block-template -->
<!-- message-block-template -->
<section class="message-block-content">
<!-- Home template-->
<div class="message-block-info-inicial">
<h1 id="test-template">{Cadastro de Mensagens}</h1>
<h4>Titulo da Messagem</h4>
    <form name="message-action-form" id="message-action-form" method="post" action="admin.php?page=news.admin.php">
        <input type="text" name="message-title" value=""><br>
        Corpo da Mensagem <br><textarea name="message-body"></textarea><br>
        <input type="submit" class="btn btn-primary" value="submit" name="submit">
        <input type="button" id="cadastro-message-send" class="btn btn-primary" name="message" value="add"/>
        <input type="hidden" name="message-request-persist"  value="1">
    </form>

    <h1>Mensagens Cadastradas</h1>
</div>
    <table id="message-responstable" class="responstable">
    <thead>
    <tr>
    <th>Nome</th>
    <th>Status</th>
    <th>Mensagem</th>
    <th>Ações</th>
    </tr>
    </thead>
    <tbody class="message-tbody">
      <?php
       foreach($message as $msg):?>
    <tr>
        <td class="message-title-td"><?php  echo $msg->title ?></td>
        <td class="message-status-td"> <?php  if ($msg->status == Message::ATIVO):?> ATIVO <?php endif; ?>
          <?php  if ($msg->status == Message::INATIVO):?> INATIVO <?php endif; ?>

        </td>
        <td class="message-body-td"><?php  echo $msg->body ?></td>
        <td class="message-actions-td">
            <a class="message-link-update" href="news.core.php?message_value_id=<?php  echo $msg->id ?>">
            <button type="button" class="message-update-table-button" class="btn btn-default ">
                <span class="glyphicon glyphicon-new-window" aria-hidden="true"> </span>
            </button>
            </a>
                <!--<input type="hidden" value="" name="template-action-request" value="template-update-action"/>-->

        <button type="button" class="btn btn-default message-destroy-action">
            <span class="glyphicon glyphicon-fire" aria-hidden="true"> </span>
        </button>
     </td>
    </tr>
    <?php endforeach; ?>
    </form>
    <!-- Home message-->

    <!-- Modal message (action:update) -->
    <div class="modal fade" id="messageModalUpdate" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">template : Atualizando Registro</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <!-- form update template -->
            <div id="message-form-view">
                <form name="message-action-update" action="news.core.php" class="message-action-update" method="post">
                        Título : <br><br><input type="text" name="message-title-upd" class="message-title-upd" value="">
                        <br><br>
                        Corpo:
                        <textarea class="message-body-upd" name="message-body-upd"></textarea><br>
                        Status:
                        <select name="message-status-upd">
                            <option class="option-message-ativo" value="1">ATIVO</option>
                            <option class="option-message-inativo" value="0">INATIVO</option>
                        </select>
                        <br><br>
                         <input type="submit" class="btn btn-primary" value="ATUALIZAR" name="submit">
                        <input type="hidden" name="message-id-upd" class="message-id-upd" value="">
                        <br>
                     <input type="button" class="btn btn-primary message-update-button" name="message-update-button" value="atualizar"/>
                </form>
            </div>
            <!--  update message form -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- modal message-->
</section>

<!-- end message-block-content  -->
<!-- newslleter-block-template -->

<!-- cadastro Newslleter -->


</body>
</html>
