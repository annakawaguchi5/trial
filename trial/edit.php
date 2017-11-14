<!-- mypage.phpより遷移 -->
<?php
include('page_header.php');
require_once('db_inc.php');  //データベース接続
$userid = $_SESSION['userid'];

//INSERT or UPDATE 
$act = 'insert';
if (isset($userid)){//既存アカウントの編集かを調べる
  $sql = "SELECT * FROM tb_image WHERE userid='{$userid}'";
  $rs = mysql_query($sql, $conn);
  if (!$rs) die('エラー: ' . mysql_error());
  $row= mysql_fetch_array($rs);
  if ($row){ // 既存画像を編集するために、変数に代入
    $act = 'update';
}
?>
<form enctype="multipart/form-data" action="./edit.php" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
    <input name="image" type="file" />
    <p><input type="submit" name="save" value="Submit" /><p>
</form>
<?php
$url = "localhost";
$user = "root";
$pass = "";
$db = "trial";
 
if (!empty($_POST))
{
    // バイナリデータ
    $fp = fopen($_FILES["image"]["tmp_name"], "rb");
    $imgdat = fread($fp, filesize($_FILES["image"]["tmp_name"]));
    fclose($fp);
    $imgdat = addslashes($imgdat);
     
    // 拡張子
    $dat = pathinfo($_FILES["image"]["name"]);
    $extension = $dat['extension'];
     
    // MIMEタイプ
    if ( $extension == "jpg" || $extension == "jpeg" ) $mime = "image/jpeg";
    else if( $extension == "gif" ) $mime = "image/gif";
    else if ( $extension == "png" ) $mime = "image/png";
     
    // MySQL登録
    $link = mysql_connect( $url, $user, $pass ) or die("MySQLへの接続に失敗しました。");
    $sdb = mysql_select_db( $db, $link ) or die("データベースの選択に失敗しました。");
    $sql = "INSERT INTO `trial`.`tb_image` (userid, `imgdat`, `mime`) VALUES ('".$userid."', '".$imgdat."', '".$mime."')";
    if($act == 'update'){
        $sql = "UPDATE tb_image SET imgdat = '" . $imgdat . "', mime = '" . $mime ."' WHERE userid = '" . $userid . "'";
    }
     
    $result = mysql_query( $sql, $link ) or die("クエリの送信に失敗しました。");
    if($result){echo '写真を変更しました';} 
    mysql_close($link) or die("MySQL切断に失敗しました。");
    }
}

include('page_footer.php');
?>