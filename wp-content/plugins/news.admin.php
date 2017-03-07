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

//$leads = new DaoLeads;
//$_leads = $leads->findAll();
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
        <script type="text/javascript" src="http://localhost/wp-content/plugins/newslleter-plugin/js/interaction.js"></script>

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
                <span style="color:red">[<?php echo count($collMsgForLast5Days); ?>]</span></h2>
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
                if ($dao->emailsForToday()):
                    foreach ($dao->emailsForToday() as $lead):
                        ?>
                        <tr>
                            <td style=""><?php echo $lead->name ?></td>
                            <td><?php echo $lead->email ?></td>
                            <td><?php if (isset($lead->datecreated)): ?><b style="color:red;"><?php echo $lead->datecreated ?></b><?php endif; ?></td>
                            <td> <?php if ($lead->status == Leads::active_newslleter): ?> Newslleter Ativo <?php endif; ?>
                                <?php if ($lead->status == Leads::inactive): ?> Inativo <?php endif; ?>
                                <?php if ($lead->status == Leads::canceled): ?> cancelado <?php endif; ?>
                                <?php if ($lead->status == Leads::ebook_request): ?> Ebook  <?php echo @$lead->title ?> <?php endif; ?>
                                <?php if ($lead->status == Leads::msg): ?> Mensagem <?php endif; ?>
                                <?php if ($lead->status == Leads::modal): ?> Modal <?php endif; ?>
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
                <?php foreach ($dao->getAll() as $lead): ?>
                    <tr>
                        <td style=""><?php echo $lead->name ?></td>
                        <td><?php echo $lead->email ?></td>
                        <td><?php if (isset($lead->datecreated)): ?><b style="color:red;"><?php echo $lead->datecreated ?></b><?php endif; ?></td>
                        <td> <?php if ($lead->status == Leads::active_newslleter): ?> Newslleter Ativo <?php endif; ?>
                            <?php if ($lead->status == Leads::inactive): ?> Inativo <?php endif; ?>
                            <?php if ($lead->status == Leads::canceled): ?> cancelado <?php endif; ?>
                            <?php if ($lead->status == Leads::ebook_request): ?> Ebook  <?php echo @$lead->title ?> <?php endif; ?>
                            <?php if ($lead->status == Leads::msg): ?> Mensagem <?php endif; ?>
                            <?php if ($lead->status == Leads::modal): ?> Modal <?php endif; ?>
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
            <input type="text" name="newslleter-title" value=""><br><br>
            <h4>Campanha:</h4>
            <select name="campanha_id">
                <?php foreach ($_campanha as $camp): ?>
                    <option value="<?php echo $camp->id ?>"><?php echo $camp->title ?></option>
                <?php endforeach; ?>
            </select>
            <br><br>
            <h4>Porcentagem total do Envio: </h4>
            <input type="text" name="porcentagem" value=""><br>
            <h4>Adicionar um grupo de Leads: <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" id="add-grupo">Add</button></h4>
            <h4>Selecione os grupos de Leads - <span style="font-size:13px;">Total de leads selecionadas para este envio <span style="color:red">(3)</span></span> </h4>
            <select class="selectpicker" name="grupos_id[]"  multiple>
                <?php foreach ($daog->findAll(5) as $gp): ?>
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
            <input type="submit" id="newslleter-register-all" class="btn btn-primary" value="Registrar todos os Envios" name="submit">
            <input type="hidden" name="rand-value" value="<?php echo rand(1, 100) ?>">
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
                    <th>Envios </th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody class="newslleter-tbody">
                <?php
                /*
                 *  protected 'wpdb' => null
                  protected 'nlDataProvider' => null
                  protected 'table' => null
                  public 'id' => int 624
                  public 'newslleter_id' => int 624
                  public 'envio_id' => int 887
                  public 'template_id' => int 529
                  public 'message_id' => int 600
                  public 'status' => int 1
                  public 'datecreated' => string '2017-03-03 15:29:07' (length=19)
                  public 'newslleter_title' => string 'Sentauro' (length=8)
                  public 'message_title' => string 'LAd' (length=3)
                  public 'template_title' => string 'Campanha Ebook Docker' (length=21)
                  public 'btemplate' => string 'Template' (length=8)
                 */
                //var_dump($newslleter);
                
                for ($x = 0; $x < count($newslleter); $x++):
                    ?>
                    <tr>
                        <?php if($newslleter[$x][0]->status != ""): ?>
                        <td class="newslleter-title-td"><?php echo $newslleter[$x][0]->newslleter_title ?></td>
                        <td class="newslleter-status-td"> <?php if ($newslleter[$x][0]->news_status == Newslleter::ATIVO): ?> ATIVO <?php endif; ?>
                            <?php if ($newslleter[$x][0]->news_status == Newslleter::INATIVO): ?> INATIVO <?php endif; ?>
                            <?php if ($newslleter[$x][0]->news_status == Newslleter::EM_ANDAMENTO): ?> EM ANDAMENTO <?php endif; ?>
                            <?php if ($newslleter[$x][0]->news_status == Newslleter::ENVIADA): ?> ENVIADA <?php endif; ?>
    <?php if ($newslleter[$x][0]->news_status == Newslleter::PROBLEMA_ENVIO): ?> PROBLEMA DE ENVIO <?php endif; ?>
                
                        </td>
                         <td>
                             Mensagens : <br>total de mensagens (<?php echo count($newslleter[$x]); ?>) 
                                 <br>
                                 <?php 
                         for ($c = 0; $c < count($newslleter[$x]); $c++):?>
                            <b> [<?php echo $newslleter[$x][$c]->message_title ?>]  </b>             
                             <?php endfor; ?>
                            
                              <br><br>Templates : <br>total de templates (<?php echo count($newslleter[$x]); ?>) <br> 
                        <?php for ($c = 0; $c < count($newslleter[$x]); $c++):?>
                            <b> [<?php echo $newslleter[$x][$c]->template_title ?>]  </b>     
                            
                             <?php endfor; ?>
                            
                                                          <br><br> Periodo : <br>total de periodos (<?php echo count($newslleter[$x]); ?>) <br> 
                        <?php for ($c = 0; $c < count($newslleter[$x]); $c++):?>
                            <b> [<?php echo $newslleter[$x][$c]->data_de_envio_fixo ?>]<br>  </b>     
                            
                             <?php endfor; ?>
                            
                         </td>
                        <td class="newslleter-actions-td">
                            <a class="newslleter-link-update" href="news.core.php?newslleter_value_id=<?php echo $newslleter[$x][0]->id ?>">
                                <button type="button" class="newslleter-update-table-button" class="btn btn-default ">
                                    <span class="glyphicon glyphicon-new-window" aria-hidden="true"> </span>
                                </button>
                            </a>
                                <!--<input type="hidden" value="" name="template-action-request" value="template-update-action"/>-->

                            <button type="button" class="btn btn-default newslleter-destroy-action">
                                <span class="glyphicon glyphicon-fire" aria-hidden="true"> </span>
                            </button>
                        </td>
                        <?php endif; ?>
                    </tr>
               
<?php endfor; ?>
                </form>
                <!-- Modal message (action:update) -->
            <div class="modal fade" id="newslleterModalUpdate" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Atualizando Registro</h5>
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
                                    <h4>Campanha:</h4>
                                    <select name="campanha_id">
                                        <?php foreach ($_campanha as $camp): ?>
                                            <option value="<?php echo $camp->id ?>"><?php echo $camp->title ?></option>
<?php endforeach; ?>
                                    </select>
                                    Porcentagem : <br><br><input type="text" name="newslleter-porcentagem-upd" class="newslleter-porcentagem-upd" value="">
                                    <br><br>
                                    <select name="newslleter-status-upd" class="newslleter-status-upd">
                                        <option class="option-newslleter-ativo" value="1">ATIVO</option>
                                        <option class="option-newslleter-inativo" value="0">INATIVO</option>
                                        <option class="option-newslleter-em_andamento" value="3">EM ANDAMENTO</option>
                                        <option class="option-newslleter-enviada" value="4">ENVIADA</option>
                                        <option class="option-newslleter-problema_envio" value="5">PROBLEMA DE ENVIO</option>
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
                                <?php foreach ($grupos as $g): ?>
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
                                <?php foreach ($template as $tpl): ?>
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
                                <?php foreach ($message as $msg): ?>
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
<?php //include_once "campanha_block_content.php";  ?>
    <!-- end campanhas-block-content  -->

    <!-- template-block-content  -->
<?php //include_once "template_block_content.php";  ?>
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

            <br><br><h4>Campanhas Cadastradas</h4>
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
                    <?php foreach ($_campanha as $camp): ?>
                        <tr>
                            <td class="campanha-title-td"><?php echo $camp->title ?></td>
                            <td class="campanha-date-td"><?php echo $camp->datecreated ?></td>
                            <td class="campanha-status-td"> <?php if ($camp->status == Campanha::ATIVO): ?> ATIVO <?php endif; ?>
                                <?php if ($camp->status == Campanha::INATIVO): ?> INATIVO <?php endif; ?>
                                <?php if ($camp->status == Campanha::EM_ANDAMENTO): ?> EM ANDAMENTO <?php endif; ?>
                                <?php if ($camp->status == Campanha::ENVIADA): ?> ENVIADA <?php endif; ?>
                                <?php if ($camp->status == Campanha::PROBLEMA_ENVIO): ?> PROBLEMA ENVIO <?php endif; ?>
                            </td>
                            <td class="campanha-actions-td">
                                <a class="campanha-link-update" href="news.core.php?campanha_value_id=<?php echo $camp->id ?>">
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
                        <h1 id="test-template"> Cadastro de Templates</h1>
                        <h4>Titulo do Template</h4>
                        <form name="template-action-form" id="template-action-form" method="post" action="admin.php?page=news.admin.php">
                            <input type="text" name="template-title" value="">
                            <br><br>Corpo do Template <br><br><textarea name="template-body"></textarea><br><br>
                            <input type="submit" class="btn btn-primary" value="submit" name="submit">
                            <input type="button" id="cadastro-template-send" class="btn btn-primary" name="template" value="add"/>
                            <input type="hidden" name="template-request-persist"  value="1">
                        </form>
                        <br><br>
                        <h4>Templates Cadastradas</h4>
                        <br>
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
                            <?php foreach ($template as $tpl): ?>
                                <tr>
                                    <td class="template-title-td"><?php echo $tpl->title ?></td>
                                    <td class="template-status-td"> <?php if ($tpl->status == Template::ATIVO): ?> ATIVO <?php endif; ?>
                                        <?php if ($tpl->status == Template::INATIVO): ?> INATIVO <?php endif; ?>

                                    </td>
                                    <td class="template-actions-td">
                                        <a class="template-link-update" href="news.core.php?template_value_id=<?php echo $tpl->id ?>">
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
                <!-- lead-block-template -->
                <section class="lead-block-content">
                    <!-- Home template-->
                    <div class="lead-block-info-inicial">
                        <h1 id="test-lead"> Cadastro de Leads </h1>
                        <form name="lead-action-form" id="lead-action-form" method="post" action="">
                            nome <input type="text" name="lead-nome" class="lead-nome"/><br><br>
                            email <input type="text" name="lead-mail" class="lead-mail"/><br><br>
                            Grupo <select class="" name="lead-grupos_id[]"  multiple>
                                <?php foreach ($daog->findAll(8) as $gp): ?>
                                    <option value="<?php echo $gp->id ?>"><?php echo $gp->name ?></option>
                                <?php endforeach; ?>
                            </select><br><br>
                            empresa <input type="text" name="lead-empresa" class="lead-mail"/><br><br>
                            cargo:<br><br>
                            <select name="lead-cargo"><br>
                                <option class="option-cargo" value="1">DBA</option>
                                <option class="option-cargo" value="2">Analista de Testes</option>
                                <option class="option-cargo" value="3">Analista de Sistema</option>
                                <option class="option-cargo" value="4">Programador</option>
                                <option class="option-cargo" value="5">Web Designer</option>
                                <option class="option-cargo" value="6">Engenheiro de Software</option>
                                <option class="option-cargo" value="7">Analista de Infraestrutura e Redes</option>
                                <option class="option-cargo" value="8">Técnico de Informática</option>
                                <option class="option-cargo" value="9">Professor</option>
                                <option class="option-cargo" value="10">Curioso</option>
                                <option class="option-cargo" value="11">Estudante</option>
                            </select><br><br>
                            site da empresa <input type="text" name="lead-site" class="lead-mail"/><br><br>
                            Sua Area de Atuação<br>
                            <select name="lead-area-atuacao">
                                <option value="1">Agência de Marketing e Publicidade</option>
                                <option value="2">Consultorias e Treinamentos</option>
                                <option value="3">Ecommerce</option>
                                <option value="4">Educação e Ensino</option>
                                <option value="5">Engenharia e Indústria Geral</option>
                                <option value="6">Eventos</option>
                                <option value="7">Financeiro, Jurídico e Serviços Relacionados</option>
                                <option value="8">Hardware e Eletrônicos</option>
                                <option value="9">Imobiliárias</option>
                                <option value="10">Mídia e Comunicação</option>
                                <option value="11">ONGs</option>
                                <option value="12">Saúde e Estética</option>
                                <option value="13">Serviços em Geral</option>
                                <option value="14">Serviços em RH e Coaching</option>
                                <option value="15">Software e Cloud</option>
                                <option value="16">Telecomunicações</option>
                                <option value="17">Turismo e Lazer</option>
                                <option value="18">Varejo</option>
                            </select><br><br>
                            Status: <br><br>
                            <select name="lead-cargo">
                                <option class="option-cargo" value="1">ATIVO</option>
                                <option class="option-cargo" value="2">INATIVO</option>
                                <option class="option-cargo" value="3">DESCADASTRADO</option>
                            </select><br><br>
                            <input type="submit" class="btn btn-primary" value="submit" name="submit">
                            <input type="button" id="cadastro-lead-send" class="btn btn-primary" name="lead" value="add"/>
                            <input type="hidden" name="lead-request-persist"  value="1">
                        </form>
                        <br><br>
                        <h4>Leads Cadastradas</h4><br>
                        <table id="lead-responstable" class="responstable">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody class="lead-tbody">
                                <?php foreach ($dao->getAll() as $lead): ?>
                                    <tr>
                                        <td class="message-title-td"><?php echo $lead->name ?></td>
                                        <td class="message-status-td"> <?php if ($lead->status == Leads::active_newslleter): ?> ATIVO <?php endif; ?>
    <?php if ($lead->status == Leads::inactive): ?> INATIVO <?php endif; ?>
                                            <?php if ($lead->status == Leads::canceled): ?> CANCELADA <?php endif; ?>
                                            <?php if ($lead->status == Leads::ebook_request): ?> EBOOK <?php endif; ?>
                                            <?php if ($lead->status == Leads::msg): ?> MENSAGEM FORM CONTATO<?php endif; ?>
                                            <?php if ($lead->status == Leads::modal): ?> MODAL <?php endif; ?>
                                        </td>
                                        <td class="lead-actions-td">
                                            <a class="lead-link-update" href="news.core.php?lead_value_id=<?php echo $lead->id ?>">
                                                <button type="button" class="lead-update-table-button" class="btn btn-default ">
                                                    <span class="glyphicon glyphicon-new-window" aria-hidden="true"> </span>
                                                </button>
                                            </a>
                                                <!--<input type="hidden" value="" name="template-action-request" value="template-update-action"/>-->

                                            <button type="button" class="btn btn-default lead-destroy-action">
                                                <span class="glyphicon glyphicon-fire" aria-hidden="true"> </span>
                                            </button>
                                        </td>
                                    </tr>
<?php endforeach; ?>
                                </form>
                        </table>

                    </div>
                    <!-- Home lead-->

                    <!-- Modal Lead (action:update) -->
                    <div class="modal fade" id="leadModalUpdate" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Lead : Atualizando Registro</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- form update template -->
                                    <div id="lead-form-view">
                                        <form name="lead-action-update" class="lead-action-update" method="post" action="">
                                            nome <input type="text" name="lead-name-upd" class="lead-name-upd"/><br><br>
                                            email <input type="text" name="lead-mail-upd" class="lead-mail-upd"/><br><br>
                                            Grupo <select class="" name="lead-grupos_id-upd[]"  multiple>
<?php foreach ($daog->findAll(5) as $gp): ?>
                                                    <option value="<?php echo $gp->id ?>"><?php echo $gp->name ?></option>
                                                <?php endforeach; ?>
                                            </select><br><br>
                                            empresa <input type="text" name="lead-empresa-upd" class="lead-empresa-upd"/><br><br>
                                            cargo:<br><br>
                                            <select name="lead-cargo-upd"><br>
                                                <option class="option-cargo" value="1">DBA</option>
                                                <option class="option-cargo" value="2">Analista de Testes</option>
                                                <option class="option-cargo" value="3">Analista de Sistema</option>
                                                <option class="option-cargo" value="4">Programador</option>
                                                <option class="option-cargo" value="5">Web Designer</option>
                                                <option class="option-cargo" value="6">Engenheiro de Software</option>
                                                <option class="option-cargo" value="7">Analista de Infraestrutura e Redes</option>
                                                <option class="option-cargo" value="8">Técnico de Informática</option>
                                                <option class="option-cargo" value="9">Professor</option>
                                                <option class="option-cargo" value="10">Curioso</option>
                                                <option class="option-cargo" value="11">Estudante</option>
                                            </select><br><br>
                                            site da empresa <input type="text" name="lead-site-upd" class="lead-site-upd"/><br><br>
                                            Sua Area de Atuação<br>
                                            <select name="lead-area-atuacao-upd">
                                                <option value="1">Agência de Marketing e Publicidade</option>
                                                <option value="2">Consultorias e Treinamentos</option>
                                                <option value="3">Ecommerce</option>
                                                <option value="4">Educação e Ensino</option>
                                                <option value="5">Engenharia e Indústria Geral</option>
                                                <option value="6">Eventos</option>
                                                <option value="7">Financeiro, Jurídico e Serviços Relacionados</option>
                                                <option value="8">Hardware e Eletrônicos</option>
                                                <option value="9">Imobiliárias</option>
                                                <option value="10">Mídia e Comunicação</option>
                                                <option value="11">ONGs</option>
                                                <option value="12">Saúde e Estética</option>
                                                <option value="13">Serviços em Geral</option>
                                                <option value="14">Serviços em RH e Coaching</option>
                                                <option value="15">Software e Cloud</option>
                                                <option value="16">Telecomunicações</option>
                                                <option value="17">Turismo e Lazer</option>
                                                <option value="18">Varejo</option>
                                            </select><br><br>
                                            Status: <br><br>
                                            <select name="lead-status-upd" class="lead-status-upd">
                                                <option class="" value="1">ATIVO</option>
                                                <option class="" value="2">INATIVO</option>
                                                <option class="" value="3">DESCADASTRADO</option>
                                            </select><br><br>
                                            <input type="submit" class="btn btn-primary" value="submit" name="submit">
                                            <input type="button" id="lead-update-button" class="btn btn-primary" name="lead" value="add"/>
                                            <input type="hidden" name="lead-request-update"  value="1">
                                            <input type="hidden" name="lead-id-upd" class="lead-id-upd" value="">
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
                    <!-- modal lead-->
                </section>

                <!-- end lead-block-content  -->


                <!-- message-block-template -->
                <section class="message-block-content">
                    <!-- Home template-->
                    <div class="message-block-info-inicial">
                        <h1 id="test-template"> Cadastro de Mensagens </h1>
                        <h4>Titulo da Messagem</h4>
                        <form name="message-action-form" id="message-action-form" method="post" action="admin.php?page=news.admin.php">
                            <input type="text" name="message-title" value=""><br>
                            <br>Corpo da Mensagem <br><textarea name="message-body"></textarea><br><br>
                            <input type="submit" class="btn btn-primary" value="submit" name="submit">
                            <input type="button" id="cadastro-message-send" class="btn btn-primary" name="message" value="add"/>
                            <input type="hidden" name="message-request-persist"  value="1">
                        </form>
                        <br><br>
                        <h4>Mensagens Cadastradas</h4><br>
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
<?php foreach ($message as $msg): ?>
                                <tr>
                                    <td class="message-title-td"><?php echo $msg->title ?></td>
                                    <td class="message-status-td"> <?php if ($msg->status == Message::ATIVO): ?> ATIVO <?php endif; ?>
    <?php if ($msg->status == Message::INATIVO): ?> INATIVO <?php endif; ?>

                                    </td>
                                    <td class="message-body-td"><?php echo $msg->body ?></td>
                                    <td class="message-actions-td">
                                        <a class="message-link-update" href="news.core.php?message_value_id=<?php echo $msg->id ?>">
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

                </body>
                </html>
