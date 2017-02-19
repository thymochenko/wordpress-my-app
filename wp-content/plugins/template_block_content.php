<!-- template-block-template -->
<div class="template-block-content">
<!-- Home template-->
<h1 id="test-template">{Cadastro de Templates}</h1>
<h4>Titulo do Template</h4>
    <form name="template-action-form" id="template-action-form" method="post" action="admin.php?page=news.admin.php">
        <input type="text" name="template-title" value="">
        <input type="submit" class="btn btn-primary" value="submit" name="submit">
        <input type="button" id="cadastro-template-send" class="btn btn-primary" name="template" value="add"/>
        <input type="hidden" name="template-request-persist"  value="1">
    </form>

    <h1>templates Cadastradas</h1>
    <table id="template-table-list-index" class="responstable">
    <thead>
    <tr>
    <th>Nome</th>
    <th>data criação</th>
    <th>Status</th>
    <th>Ações</th>
    </tr>
    </thead>
    <tbody class="template-tbody">
      <?php
       foreach($template as $tpl):?>
    <tr>
        <td class="template-title-td"><?php  echo $tpl->title ?></td>
        <td class="template-date-td"><?php  echo $tpl->datecreated ?></td>
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
                        <?php //include_once "text_editor.php"; ?>
                        Status:
                        <select name="template-status-upd">
                            <option class="option-template-ativo" value="1">ATIVO</option>
                            <option class="option-template-inativo" value="2">INATIVO</option>
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
</div>
