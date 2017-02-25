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
$(document).on('click', '#newslleter-add',function(event) {
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

/*@Newslleter
*persist block information

$(document).on('click', '#newslleter-register-all', function(event) {
     event.preventDefault();
     $.post("news.core.php", $('.newslleter-action').serializeArray())
     .done(function( data ) {
         alert(data);
        alert("Newslleter Inserida com Sucesso");
        location.reload();
    });
});*/
/*@Template update Modal
*method: carrega dados para o form de update domain:@Template
*/
$(document).on('click',".newslleter-link-update", function(event){
    event.preventDefault();
    //mostra form de atualização
    $("#newslleterModalUpdate").modal("show");

    $.ajax(this.href, { success: function(data) {
        //dados do form
        var resource = $.parseJSON(data);
        var status;

        if(resource[0].status === 1){
            status = "ATIVO";
        }
        if(resource[0].status === 0){
            status = "INATIVO"
        }
        if(resource[0].status === 3){
            status = "EM ANDAMENTO";
        }
        if(resource[0].status === 4){
            status = "ENVIADA";
        }
        if(resource[0].status === 5){
            status = "PROBLEMA ENVIO";
        }

        $('.newslleter-title-upd').val(resource[0].title);
        $('.newslleter-porcentagem-upd').val(resource[0].porcentagem);
        $('.newslleter-id-upd').val(resource[0].id);
        //alert('"<option value="' +  resource[0].status + '" selected="selected">' + status + '</option>');
        $(".newslleter-status-upd").append('"<option value="' +  resource[0].status + '" selected="selected">' + status + '</option>');

        },
        error: function() {
                  alert('error');
              }
        });
});
/* method:update domain:@Template
* Método que atualiza as informações do form via post e atualiza a página
*/
$('.newslleter-update-button').click(function(event) {
     event.preventDefault();
     $.post("http://localhost/wp-content/plugins/news.core.php", $('.newslleter-action-update').serializeArray())
     .done(function( data ) {
      var resource = $.parseJSON(data);
        alert("Newslleter (" +  resource[0].title + ") Atualizada com Sucesso" );
        location.reload();
    });
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
$(document).on('click', '#grupo_button', function(event) {
   //alert('no evento');
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

     $(".campanha-block-info-inicial").show();
     $("#campanha-responstable").show();
     $(".campanha-tbody").show();
});


$("#inicial-block-content").hide();
//$("#newslleter-action").hide();
//$(".newslleter-block-info-inicial").hide();
//$("#newslleter-responstable").hide();
$("#template-responstable").hide();
$("#message-responstable").hide();

$(".template-block-info-inicial").hide();
$(".message-block-info-inicial").hide();

$(".campanha-block-info-inicial").hide();
$("#campanha-responstable").hide();
$(".campanha-tbody").hide();
//leads
$(".lead-block-info-inicial").hide();
$("#lead-responstable").hide();
$(".lead-tbody").hide();
/* method:persist domain:@Campanha
*
*/
$(document).on('click', '#cadastro-campanha-send',function(event){
           //ajax post
          $.post("http://localhost/wp-content/plugins/news.core.php", $('#campanha-action-form').serializeArray())
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
     $.post("http://localhost/wp-content/plugins/news.core.php", $('.campanha-action-update').serializeArray())
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
$("#inicial-block-content").hide();
$("#newslleter-action").hide();
$("#newslleter-responstable").hide();
$(".newslleter-block-info-inicial").hide();

$("#template-responstable").show();
$(".template-block-info-inicial").show();
$(".template-tbody").show();

$("#message-responstable").hide();
$(".message-block-info-inicial").hide();
$(".message-tbody").hide();

$(".campanha-block-info-inicial").hide();
$("#campanha-responstable").hide();
$(".campanha-tbody").hide();

});
/* method:persist domain:@Campanha
*
*/
$(document).on('click', '#cadastro-template-send',function(event){
           //ajax post
          $.post("http://localhost/wp-content/plugins/news.core.php", $('#template-action-form').serializeArray())
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
           $.post("http://localhost/wp-content/plugins/news.core.php", $('.template-action-update').serializeArray())
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
          $("#inicial-block-content").hide();
          $("#newslleter-action").hide();
          $("#newslleter-responstable").hide();
          $(".newslleter-block-info-inicial").hide();

          $("#template-responstable").hide();
          $(".template-block-info-inicial").hide();
          $(".template-tbody").hide();

          $("#message-responstable").show();
          $(".message-block-info-inicial").show();
          $(".message-tbody").show();

          $(".campanha-block-info-inicial").hide();
          $("#campanha-responstable").hide();
          $(".campanha-tbody").hide();
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
                $.post("http://localhost/wp-content/plugins/news.core.php", $('#message-action-form').serializeArray())
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
                 $.post("http://localhost/wp-content/plugins/news.core.php", $('.message-action-update').serializeArray())
                 .done(function( data ) {
                  var resource = $.parseJSON(data);
                    alert("Mensagem Atualizada com Sucesso");
                    location.reload();
                });
            });
            //----------------------------------------- leads -----------------------\\
            /*@leads
            *
            */
            $(document).on("click", '.leads-link', function(event) {
                event.preventDefault();
                $("#inicial-block-content").hide();
                $("#newslleter-action").hide();
                $("#newslleter-responstable").hide();
                $(".newslleter-block-info-inicial").hide();

                $("#template-responstable").hide();
                $(".template-block-info-inicial").hide();
                $(".template-tbody").hide();

                $("#message-responstable").hide();
                $(".message-block-info-inicial").hide();
                $(".message-tbody").hide();

                $(".campanha-block-info-inicial").hide();
                $("#campanha-responstable").hide();
                $(".campanha-tbody").hide();

                $(".lead-block-info-inicial").show();
                $("#lead-responstable").show();
                $(".lead-tbody").show();
            });


                  /* method:persist domain:@Lead
                  *
                  */
                  $(document).on('click', '#cadastro-lead-send',function(event){
                             //ajax post
                            $.post("http://localhost/wp-content/plugins/news.core.php", $('#lead-action-form').serializeArray())
                            .done(function( data ) {
                                alert(data);
                                var resource = $.parseJSON(data);
                                var status = "";

                                if(resource[0].status === 1){
                                     status = "ATIVO";
                                }
                                if(resource[0].status === 2){
                                    status = "INATIVO";
                                }
                                if(resource[0].status === 3){
                                    status = "CANCELADO";
                                }
                                if(resource[0].status === 4){
                                    status = "EBOOK";
                                }
                                if(resource[0].status === 5){
                                    status = "MENSAGEM";
                                }
                                if(resource[0].status === 6){
                                    status = "MODAL";
                                }
                                if(resource[0].status === 7){
                                    status = "DESCADASTRADO";
                                }
                                //view (exibe os dados persistidos em uma tabela)
                                 var line = '<tr> <td style="background-color:#B0C4DE" class="lead-title-td"><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"> </span> ' + resource[0].name + '</td>' +
                                    '<td style="background-color:#B0C4DE" class="lead-status-td">' + status + '</td>' +
                                    '<td style="background-color:#B0C4DE" class="lead-actions-td">' +
                                    '<a class="message-link-update" href="news.core.php?lead_value_id=' + resource[0].id + '">' +
                                    '<button type="button" class="lead-update-table-button" class="btn btn-default">' +
                                       '<span class="glyphicon glyphicon-new-window" aria-hidden="true"> </span>' +
                                    '</button></a>' +
                                    '<button type="button" class="btn btn-default lead-destroy-action">' +
                                       '<span class="glyphicon glyphicon-fire" aria-hidden="true"> </span>' +
                                    '</button></td>' +
                                '</tr>';

                                    $('.lead-tbody').append(line).hide().fadeIn('slow');

                            });
                        });

                        /*@Template update Modal
                        *method: carrega dados para o form de update domain:@Template
                        */
                        $(document).on('click',".lead-link-update", function(event){
                            event.preventDefault();
                            //mostra form de atualização
                            $("#leadModalUpdate").modal("show");

                            $.ajax(this.href, { success: function(data) {
                                //dados do form
                                var resource = $.parseJSON(data);
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
                             $.post("http://localhost/wp-content/plugins/news.core.php", $('.message-action-update').serializeArray())
                             .done(function( data ) {
                              var resource = $.parseJSON(data);
                                alert("Mensagem Atualizada com Sucesso");
                                location.reload();
                            });
                        });
});
