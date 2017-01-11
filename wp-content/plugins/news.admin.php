<?php
require_once 'news.core.php';
$dataProvider = new NewslleterDataProvider(new Newslleter());
$dataProvider->setReturnType('array');
GLOBAL $wpdb;
$dao = new DaoNewslleter($wpdb);
$dao->setDataProvider($dataProvider);
$dao->setTable('newslleter_contact');
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
   if(isset($dao->getAll()['news'])){ $d = $dao->getAll()['news']; @sort($d, SORT_NUMERIC); } ;
   foreach($d as $newslleter):?>
<tr>
    <td style=""><?php  echo $newslleter->name ?></td>
    <td><?php  echo $newslleter->email ?></td>
    <td><?php  if(isset($newslleter->datecreated)):?><?php  echo $newslleter->datecreated ?><?php endif; ?></td>
    <td> <?php  if ($newslleter->status == Newslleter::STATUS['active_newslleter']):?> Newslleter Ativo <?php endif; ?>
      <?php  if ($newslleter->status == Newslleter::STATUS['inactive']):?> Inativo <?php endif; ?>
      <?php  if ($newslleter->status == Newslleter::STATUS['canceled']):?> cancelado <?php endif; ?>
      <?php  if ($newslleter->status == Newslleter::STATUS['ebook_request']):?> Ebook : <?php echo $newslleter->title ?> <?php endif; ?>
      <?php  if ($newslleter->status == Newslleter::STATUS['msg']):?> Mensagem <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
</body>
<?php
?>
