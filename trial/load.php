 
<?php
session_start();
require_once('db_inc.php');  //データベース接続
if(!isset($_SESSION['userid'])){
  include('page_header.php');
  die('エラー：この機能を利用する権限がありません');
  include('page_footer.php');
}else{
  
}

 $name='14JK000';
 /*
if (isset($_GET['name'])) {
  $name = $_GET['name'];
}
 */
function getPDO() {
  // PHP Data Object を返す
  $dataSourceName = 'mysql:host=localhost;dbname=trial;charset=utf8';
  $user = 'root';
  $dbPassword = '';
 
  return new PDO($dataSourceName, $user, $dbPassword);
}
 
// 拡張子によってMIMEタイプを切り替えるための配列
/*$MIMETypes = array(
   'png'  => 'image/png',
   'jpg'  => 'image/jpeg',
   'jpeg' => 'image/jpeg',
   'gif'  => 'image/gif',
   'bmp'  => 'image/bmp',
);*/
// Content-typeテーブル
 $contents_type = array(
     'jpg'  => 'image/jpeg',
     'jpeg' => 'image/jpeg',
     'png'  => 'image/png',
     'gif'  => 'image/gif',
     'bmp'  => 'image/bmp',
     'tmp'  => 'image/tmp'
 );
try {
 
  $pdo = getPDO();
 
 if(mysqli_connect_errno()){
  printf("Connect failed:%s\n", mysqli_connect_errno());
  exit();
   }

  $tableName = "tb_imagedata";
 /*
  // データベースから条件に一致する行を取り出す
  //$data = $pdo->query('SELECT * FROM ' . $tableName . ' WHERE name = "' . $name . '"')->fetch(PDO::FETCH_ASSOC);
  $data = $pdo->prepare("SELECT name, image, extension FROM $tableName WHERE name='{$name}'");
  //$data = $pdo->query("SELECT * FROM $tableName WHERE name='{$name}'");
   $data->bindParam(':name', $name);
 $data->execute();
  var_dump($data);
  $image = $data->fetch(PDO::FETCH_ASSOC);
   $img = $data->fetchObject();

  // $img = mysqli::real_escape_string($img);
 //header('Content-type: ' . $contents_type[$img->extension]);
 echo'Content-type: ' . $contents_type[$img->extension];
 echo $img->contents;
 print_r($img);
 */
// データベースから対象のデータを取得
 /*
     $stmt = $pdo->prepare('SELECT name, image, extension FROM tb_imagedata WHERE name=:name');
     $stmt->bindParam(':name', $name);
     $stmt->execute(); */
     $sql = 'SELECT * FROM ' . $tableName . ' WHERE name = "' . $name . '"';
     $rs = mysql_query($sql, $conn);
        if (!$rs) die ('エラー: ' . mysql_error());
        $row = mysql_fetch_array($rs) ;

// 出力
     $decoded_file = base64_decode($row[0]);
      header('Content-type: ' . $contents_type[$row['extension']]);
      echo $row[0];
     /*
     $img = $stmt->fetchObject();
     header('Content-type: ' . $contents_type[$img->extension]);
     echo $img->image; 
*/
// $sql = 'SELECT name, extension FROM ' . $tableName . ' WHERE name = "' . $name . '"';
  //$sql = 'SELECT * FROM ' . $tableName . ' WHERE name = "' . $name . '"';
        //echo $sql;
        /*$rs = mysql_query($sql, $conn);
        if (!$rs) die ('エラー: ' . mysql_error());
        $row = mysql_fetch_array($rs) ;
        var_dump($row);
        */
         //$image = $->fetch(PDO::FETCH_ASSOC);
        //echo 'Content-type:'.$contents_type[$row['extension']];
        //header('Content-type: ' . $contents_type[$row['extension']]);
        //echo $row['image'];

 /*
  // 画像として扱うための設定
  header('Content-type:' . $MIMETypes[$data['extension']]);
 
  echo $data['image'];
 */
} catch (Exception $e) {
  echo "load failed: " . $e;
}
?>