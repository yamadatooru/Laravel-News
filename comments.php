

<?php

// メッセージを保存するファイルのパス設定
define( 'FILENAME', './message.csv');

// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');


$id = $_GET['id'];
echo $id ;


    v
    
  

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laravel News</title>
  <link rel="stylesheet" href="stylesheet.css">
  
</head>
<body>
  <nav class="main-header">
    <div class="nav-bar">
        <a href="index.php" class="nav-link">Laravel News</a>
    </div>
  </nav>
  <h2 class="content-header">さぁ、最新のニュースをシェアしましょう</h2>
  
  
  <hr>
  
</body>
</html>