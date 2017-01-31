<?php
require_once 'news.core.php';
$dataProvider = new LeadsDataProvider(new Leads());
$dataProvider->setReturnType('array');
GLOBAL $wpdb;
$dao = new DaoLeads($wpdb);
$dao->setDataProvider($dataProvider);
$dao->setTable('wp_news_leads');
$collMsgForLast5Days = $dao->emailsForToday();
?>
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
   foreach($collMsgForLast5Days as $lead):?>
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
</body>
