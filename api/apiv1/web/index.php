<?php
class Banner {
  const DISPOSITIVE = [
    "browser"=>"E",
    "robot"=>"A",
    "mobile"=>"B",
    "tablet"=>"C",
    "facebook"=>"D"
  ];

  CONST CAMPAIN = ["plugrush"=>[1,0.25], "juiceAds"=>[1,1.25]];

  CONST POSITION_BANNER = ["index_direita"=>1,
   "index_popup"=>2,
   "index_footer" => 3,
   "abaixo_video_player"=> 4,
   "sidebar1"=>5,
   "sidebar2"=>6,
   "pop_up_search"=>7
 ];
}

//ini_set('display_errors', 0);

require_once __DIR__.'/../vendor/autoload.php';
require_once '/var/www/html/api/apiv1/vendor/Browser.php-master/lib/Browser.php';
$app = require __DIR__.'/../src/app.php';
$app['debug'] = true;
$app["banner.service"] = function(){
  return new Banner();
};
    // init Silex app
$app->get('/banners/{campain}/{posbanner}', function ($campain,$posbanner) use ($app) {
  $browser = new browser();
    //browser
  $dispositive = Banner::DISPOSITIVE['browser'];
  if($browser->isRobot()){
    $dispositive = Banner::DISPOSITIVE['robot'];
  }
  else if($browser->isMobile()){
    $dispositive = Banner::DISPOSITIVE['mobile'];
  }
  elseif ($browser->isTablet()) {
    $dispositive = Banner::DISPOSITIVE['tablet'];
  }
  elseif ($browser->isFacebook()) {
    $dispositive = Banner::DISPOSITIVE['facebook'];
  }

  $sql = 'INSERT INTO wp_banners
    (campain, price_click_media, position_locate_banner,
    user_agent, browser_name, _os, dispositive,date_created)
    VALUES(?, ?, ?, ?, ?, ?, ?,NOW())';

  $stmt = $app['db']->prepare($sql);

  foreach (Banner::CAMPAIN as $k => $camp) {
    if($campain == $k){
      $stmt->bindValue(1,$camp[0]);
      $stmt->bindValue(2,$camp[1]);
    }
  }

  foreach (Banner::POSITION_BANNER as $y => $pos) {
    if($posbanner == $y){
      $stmt->bindValue(3,$pos);
    }
  }
  $stmt->bindValue(4,$browser->getUserAgent());
  $stmt->bindValue(5,$browser->getBrowser());
  $stmt->bindValue(6,$browser->getPlatform());
  $stmt->bindValue(7,$dispositive);
  //var_dump($app['db']->errorInfo());
  if($stmt->execute()){
    //redirect iframelink
    return true;
  }
  else {
    echo "error";
  }
});

$app->run();
