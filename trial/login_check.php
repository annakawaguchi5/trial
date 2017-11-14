<?php
include 'db_inc.php';
$userid = $_POST['userid'];
$passwd = $_POST['passwd'];
$sql = "SELECT * FROM tb_user WHERE userid='{$userid}' AND passwd='{$passwd}'";
$rs = mysql_query($sql, $conn);
if (!$rs) die('エラー: ' . mysql_error());
$row = mysql_fetch_array($rs);  //問合せ結果を配列として一行受け取る
if ($row){
	session_start();
  $_SESSION['userid'] = $userid;
  $_SESSION['uname']  = $row['uname'];
  $_SESSION['post']   =$row['post'];
  $_SESSION['auth'] = $row['auth'];
  $url = "index.php";
  if($userid=='admin'){
    $url = 'user_list.php';
  }else if($userid=='JudgeA' || $userid=='JudgeB' || $userid=='JudgeC'){
    $url = 'judge_list.php';
  }
  header("Location:". $url);
}else{
  include 'page_header.php';
  echo "<h2>認証失敗！</h2>";
  echo "<p>ユーザID："  . $userid;
  echo "<p>パスワード："  . $passwd;
  echo '<p>を確認して再度ログインして下さい';
  include 'page_footer.php';
}
?>