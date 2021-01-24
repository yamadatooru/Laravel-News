

<?php
$user = 'root';
$password = 'root';// XAMPの場合は空？！
$db = 'laravel_news';
$host = 'localhost';
$port = 3306;


$link = mysqli_init();

$success = mysqli_real_connect(
  $link,
  $host,
  $user,
  $password,
  $db,
  $port
);


// メッセージを保存するファイルのパス設定
define( 'FILENAME', './message.csv');

// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

// 変数の初期化
$now_date = null;
$data = null;
$file_handle = null;
$split_data = null;
$message = array();
$message_array = array();
$error_message = array();
$clean = array();

if( !empty($_POST['btn_submit']) ) {

  // タイトルの入力チェック
  if( empty($_POST['title']) ) {
    $error_message[] = 'タイトルは必須です。';
  } else {
    $clean['title'] = htmlspecialchars( $_POST['title'], ENT_QUOTES);
    $clean['title'] = preg_replace( '/\\r\\n|\\n|\\r/', '', $clean['title']);
  }
  
  // 文字数チェック
  if (strlen($_POST['title'])  >= 30)  {
     $error_message[] = 'タイトルは30文字以下です。';
 }

  // 記事の入力チェック
	if( empty($_POST['message']) ) {
		$error_message[] = '記事は必須です。';
	} else {
    $clean['message'] = htmlspecialchars( $_POST['message'], ENT_QUOTES);
    $clean['message'] = preg_replace( '/\\r\\n|\\n|\\r/', '<br>', $clean['message']);
	}

  // 書き込み
  if( empty($error_message) ) {

    if( $file_handle = fopen( FILENAME, "a") ) {
      // 書き込み日時を取得
      $now_date = date("Y-m-d H:i:s");
    
      // 書き込むデータを作成
      $data = "'".$clean['title']."','".$clean['message']."','".$now_date."'\n";
    
      // 書き込み
      fwrite( $file_handle, $data);
      // ファイルを閉じる
      fclose( $file_handle);
    }	
    header('Location: ./');
  }
  // 
}


// 読み込み
if( $file_handle = fopen( FILENAME,'r') ) {
    while( $data = fgets($file_handle) ){

      $split_data = preg_split( '/\'/', $data);

      $message = array(
          'title' => $split_data[1],
          'message' => $split_data[3],
          'post_date' => $split_data[5]
      );
      array_unshift( $message_array, $message);
  }
  // ファイルを閉じる
  fclose( $file_handle);
  
}
// 

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laravel News</title>
  <link rel="stylesheet" href="stylesheet.css">
  <script type="text/javascript">
    // <!--

    function disp(){

      // 「OK」時の処理開始 ＋ 確認ダイアログの表示
      if(window.confirm('投稿してよろしいですか？')){
      }
      // 「OK」時の処理終了

      // 「キャンセル」時の処理開始
      else{

        window.alert('キャンセルしました。'); // 警告ダイアログを表示
        return false;
      }
      // 「キャンセル」時の処理終了

    }

    // -->
  </script>
</head>
<body>
  <nav class="main-header">
    <div class="nav-bar">
        <a href="index.php" class="nav-link">Laravel News</a>
    </div>
  </nav>
  <h2 class="content-header">さぁ、最新のニュースをシェアしましょう</h2>
  <!-- エラーメッセージ表示 PHP -->
  <?php if( !empty($error_message) ): ?>
    <ul class="error_message">
      <?php foreach( $error_message as $value ): ?>
        <li><?php echo $value; ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <!--  -->
  <section class="form-post">
    <form method="post" onsubmit="return disp();">
      <div class="input-title">
        <label for="title">タイトル：</label>
        <input id="title" type="text" name="title" value="">
      </div>
      <div class="input-message">
        <label for="message">記事：</label>
        <textarea name="message" id="message"></textarea>
      </div>
      <div class="input-submit">
        <input type="submit" name="btn_submit" value="投稿">
      </div>      
    </form>
  </section>
  <hr>
  <!-- 投稿表示 PHP -->
  <section>
    <?php if( !empty($message_array) ): ?>
    <?php foreach( $message_array as $value ): ?>
    <article>
      <div class="info">
        <h3><?php echo $value['title'];?></h3>
        <time><?php echo date('Y年m月d日 H:i', strtotime($value['post_date'])); ?></time>
        <p class = "message"><?php echo $value['message']; ?></p>
        <a href="comments.php?id=<?php echo $value['post_date']?>">記事全文・コメントを見る</a>
      </div>
    </article>
    <hr>
    <?php endforeach; ?>
    <?php endif; ?>
  </section>
  <!--  -->
</body>
</html>