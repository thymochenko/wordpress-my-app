<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 3: Layouts</title>

    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->


    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<style>
body {
  background-color: #08020d;
}

.box:hover {
 -moz-box-shadow: 0 0 3px #885ead;
 -webkit-box-shadow: 0 0 3px #885ead;
 box-shadow: 0 0 8px #885ead;
 opacity: 0.7;
 }

.starter-template {
  padding: 45px 5px;
  text-align: center;
  background-color:#ccc;
}

.box {
  display: inline-block;
  width: 210px;
  height: 165px;
  margin: 1em;
  background-color:#ccc;
  color: #999;
}

.box img {
  width: 210px;
  height: 165px;
}

.img-responsive1 {
  display: inline-block;
  width: 500px;
  height: 320px;
  background-color:#ccc;
  margin-right:510px;
  margin-top:-45px;
}

.box-sub-nav1{
 background-color:#f4f4f4;
}

.submit {
    color: #000;
}
.container-controll {
	margin-left: 6%;
}

footer {
 color:#fff;
 padding-top: 15px;
 padding-bottom: 15px;
 background-color: #551A8B;
 border: 1px solid #ddd;
 border: 1px solid rgba(86,61,124,.2);
 text-align: center;

}

.clearfix { overflow:auto; float:right; bbackground-color:#eee; margin-right:16%; margin-top:8px;}

#principalTitle {
	width:260px;
	height:35px;
	padding-top:6px;
	color:#fff;
	margin-left:15px;
	background-color:#2a0d45;
	border-radius: 7px 20px;
	font-size:1.3em;
}

.label-default {
	background-color:#551A8B;
}

a {
    color: #fff;
    text-decoration: none;
}

a:focus , a:hover {
	color: #bba3d0;
}

.blogsession {
	color:#eee;
	background-color:#111;
}

.blogsidebar{
	color:#eee;
	background-color:#551A8B;;
}

.widgettitle{
	font-size:1.5em;
}

#searchsubmit {
	color:#000;
}

.navbar-inverse {
    background-color:#2a0d45;
    color:#ffffff;
    border-radius:0;
}

.navbar-inverse .navbar-nav > li > a {
    color:#fff;
}
.navbar-inverse .navbar-nav > .active > a, .navbar-nav > .active > a:hover, .navbar-nav > .active > a:focus {
    color: #ffffff;
    background-color:transparent;
}
.navbar-inverse .navbar-brand {
    color:#eeeeee;
}

.widget_categories .widget_archive .widget_tags li{
    list-style-type: none;
}

.widget_categories h2 {
  margin-left: 25px;
  list-style-type: none;
  border: 1px solid #999;
}

.widget_archive h2 {
  margin-left: 25px;
  list-style-type: none;
  border: 1px solid #999;
}

.widget_tag_cloud h2 {
  margin-left: 25px;
  list-style-type: none;
}

.widget h2 {
  background-color: #330f53;
  border: 1px solid #000;
    list-style-type: none;
}
.widget {
  list-style-type: none;
}

#breadcrumbs{
    list-style:none;
    margin:10px 0;
    overflow:hidden;
}

#breadcrumbs li{
    display:inline-block;
    vertical-align:middle;
    margin-right:15px;
}

#breadcrumbs .separator{
    font-size:18px;
    font-weight:100;
    color:#ccc;
}

</style>
</head>
<body>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Contact</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="contact" method="post">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="inputEmail3" name="name" placeholder="Text">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail4" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
              <input name="email" type="email" class="form-control" id="inputEmail4" placeholder="Email">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
        	<textarea name="msg" class="form-control" rows="3"></textarea>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Send Message</button>
            </div>
          </div>
          <div id="sucess" class="alert alert-success" role="alert">
<strong>Send!</strong> Message sent successfully</div>
        <div id="error" class="alert alert-warning" role="alert">
          <strong>Error!</strong> Error send message
          </div>
          <div id="preload"><img width="100" height="100" src="http://localhost/wp-content/themes/latinabigass/img/load.gif"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- closeModal -->

<!-- ModalBanner -->
<div class="modal fade bs-example-modal-sm" id="bannerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Advertising</h4>
      </div>
      <div class="modal-body">
        <img style="margin-left:125px;"src="http://media.trafficjunky.net/uploaded_content/creative/101/034/449/1/1010344491.gif"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- closeModalBanner -->

  <?php $category = Repository::findCategoryForIndexMenu(); ?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#the-menu">
        <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
      </button>
<a class="navbar-brand brand" href="/index.html"><span class="label label-default">MegaLatinaAss</span></a>
</div>
<div class="collapse navbar-collapse" id="the-menu">
<ul class="nav navbar-nav">
<li class="active">
<a href="/"><span class="glyphicon glyphicon-home"></span> Home</a></li>
<li><a data-toggle="modal" data-target="#myModal" href="#"><span class="glyphicon glyphicon-earphone"></span> Contact Us</a></li>
<!-- <li><a href="/contact.html"><span class="glyphicon glyphicon-heart-empty"></span> Most viewers</a></li>-->
<li><a href="/index.php/category/blog/"><span class="glyphicon glyphicon-book"></span> Blog</a></li>
</ul>
<form id="searchform" action="http://localhost/" method="get" role="search" class="navbar-form navbar-right visible-md-inline visible-lg-inline">
<div class="form-group" style="margin-top: 4px">
<label class="sr-only" for="keyword">Keyword</label>
<input type="text" name="s" class="form-control input-sm" id="keyword" placeholder="Enter Search keyword" value=""/>
</div>
</form>
<ul class="nav navbar-nav navbar-left">
							<li class="dropdown">
								<a data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-tags"></span>&nbsp;&nbsp;Best Category&nbsp;<span class="caret"></span></a>
								<ul class="dropdown-menu">
                  <?php foreach($category as $k=>$cat):?>
									<li><a href="index.php/category/<?php echo $cat->slug ?>"><span class="glyphicon glyphicon-tag"></span>&nbsp;<?php echo $cat->name ?>&nbsp;<span class="badge"><?php echo $cat->category_count ?></span></a></li>
                <?php endforeach; ?>
								</ul>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
								<a data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-star-empty"></span>&nbsp;&nbsp;Partnes&nbsp;<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="#"><span class="glyphicon glyphicon-log-in"></span>&nbsp;HentaiHunters&nbsp;</a></li>
									<li class="divider"></li>
									<li><a href="#"><span class="glyphicon glyphicon-log-in"></span>&nbsp;AsianTeenForMe</a></li>
									<li><a href="#"><span class="glyphicon glyphicon-log-in"></span>&nbsp;EbonyQueens</a></li>
									<li><a href="#"><span class="glyphicon glyphicon-log-in"></span>&nbsp;DildosHot</a></li>
								</ul>
							</li>
						</ul>
</div>
</div>
</nav>
