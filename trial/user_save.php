<?php
include('page_header.php');
include('db_inc.php');
if (!isset($_POST['uid'])){
  die ('エラー：この機能を利用する権限はありません！');
}

//var_dump($_POST);
if (isset($_POST['act'])){
  $act = $_POST['act'];
  $pass1 = $_POST['pass1'];
  $pass2 = $_POST['pass2'];
  if ($pass1===$pass2){
    $uid = $_POST['uid'];
    $uname = $_POST['uname'];
    $gender = $_POST['gender'];
    $birth = $_POST['year']."-".$_POST['month']."-".$_POST['day'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $urole = $_POST['urole'];
    $dept = $_POST['dept'];
    $selfintro = nl2br($_POST['selfintro']);    //依頼詳細の改行処理

    $sql = array(0=>"UPDATE tb_user SET userid='{$uid}',passwd='{$pass1}',uname='{$uname}',gender=$gender,birth='{$birth}',email='{$email}',dept='{$dept}',tel='{$tel}',selfintro='{$selfintro}',post=$urole WHERE userid='{$uid}'");


  if($act=='insert'){
    $sql =array(
      0=>"INSERT INTO tb_user VALUES ('{$uid}','{$pass1}','{$uname}',$gender,'{$birth}','{$email}','{$dept}','{$tel}','{$selfintro}',500,$urole,1,0,0,now());",
      1=> "INSERT INTO tb_point VALUES(0,now(),'{$uid}','初回ポイント',500);");
  }

    foreach($sql as $s){
      //echo $s;
      $rs = mysql_query($s, $conn);
      if (!$rs) die ('エラー: ' . mysql_error());
    }


    //DB登録後、表示
    echo '<div class="container warn">';

    if($act == 'insert'){
      echo '<p class="mediumfont">データが登録されました。<br><a href="login.php">ログイン</a>を行って下さい。</p>';
    }else{
      echo '<p class="mediumfont">データが更新されました。<br><a href="mypage.php?userid='.$uid.'">マイページ</a>にて確認を行って下さい。</p>';
    }

    echo '</div>';

  }else{
    ?>
    <!-- エラー表示 -->
    <div class="container warn">
    <p class="mediumfont">エラー：パスワードが異なっています。登録できません<br>再度、<a href="login.php">アカウント作成</a>を行って下さい。</h3>
    </div>

    <?php
  }
}
include('page_footer.php');
?>