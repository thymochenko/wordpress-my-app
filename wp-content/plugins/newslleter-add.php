<?php
require_once 'news.core.php';
?>
<html>
<head>
    <script
    			  src="https://code.jquery.com/jquery-3.1.1.min.js"
    			  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    			  crossorigin="anonymous"></script>


              <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

          <!-- Optional theme -->
          <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

          <!-- Latest compiled and minified JavaScript -->
          <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
          <script>
          $(function() {
              $("#mymodal").modal('show');
          });
          </script>
</head>
<body>
    <h1>Cadastro de newslleter</h1>
    <form name="newslleter_send" id="news_send" method="post" action="news.core.php">
        <select id="myselect">
            <option value="1">Mr</option>
            <option value="2">Mrs</option>
            <option value="3">Ms</option>
            <option value="4">Dr</option>
        <option value="5">Prof</option>
</select>
    </form>
</body>
</html>
