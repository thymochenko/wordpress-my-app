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
</div>
<!-- end campanha-block-template -->
