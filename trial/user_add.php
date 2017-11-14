<?php
include('page_header.php');
include('db_inc.php');

$uid = $uname = $gender = $tel = $email = $did = $selfintro ='';
$birth ="---";
$urole = 1;
$act = 'insert';
$sex = 0;// 新規登録のつもりで、変数を初期化
if (isset($_GET['uid'])){//既存アカウントの編集かを調べる
  $u = $_GET['uid'] ;
  echo $sql = "SELECT * FROM tb_user WHERE userid='{$u}'";
  $rs = mysql_query($sql, $conn);
  if (!$rs) die('エラー: ' . mysql_error());
  $row= mysql_fetch_array($rs);
  if ($row){ // 既存アカウントを編集するために、変数に代入
    $act = 'update';
    $uid   = $row['userid'];
    $uname = $row['uname'];
    $gender = $row['gender'];
    $birth = $row['birth'];
    $tel = $row['tel'];
    $email = $row['email'];
    $urole = $row['post'];
    $did = $row['dept'];
    $selfintro = $row['selfintro'];
  }
}
?>
<div class="container">
<div class="main">
<h2>アカウント登録・編集</h2>
<form action="user_save.php" method="post" class="form-horizontal" name="users">
<input type="hidden" name="act" value="<?php echo $act; ?>">


<table class="table table-hover">
<tr><td>ユーザID：</td><td><input type="text" name="uid" value="<?php echo $uid;?>" placeholder="" class="form-control" id="uid"></td></tr>
<tr><td>パスワード：</td><td><input type="password" name="pass1" value="" placeholder="" class="form-control" id="pass1"></td></tr>
<tr><td>パスワード(確認)：</td><td><input type="password" name="pass2" value="" placeholder="" class="form-control" id="pass2"></td></tr>
<tr><td>氏　名：</td><td><input type="text" name="uname"  value="<?php echo $uname;?>" class="form-control" id="uname"></td></tr>
<tr><td>性別：</td><td>
<?php
  $s = array(1=>'男', 2=>'女', 3=>'その他');
  foreach ($s as $u => $r){
    if ($u==$gender){
      echo '<p style="display:inline-block; width:70px;">
      <input type="radio" name="gender" value="' . $u .'" id="gender['.$u.']" checked>' . $r . '</p>';
    }else{
      echo '<p style="display:inline-block; width:70px;">
      <input type="radio" name="gender" value="' . $u .'" id="gender['.$u.']">' . $r .'</p>';
    }
  }
?>
</td></tr>
<?php $t = explode("-", $birth);?>
<tr><td>生年月日：</td><td><div class="form-inline">（西暦）
    <input type="text" name="year" class="form-control" placeholder="年" value="<?php echo $t[0];?>" id="year" style="width: 70px"><span style="margin: 0 5px;">年</span>
    <input type="text" name="month" class="form-control" placeholder="月" value="<?php echo $t[1];?>" id="month" style="width: 50px"><span style="margin: 0 5px;">月</span>
    <input type="text" name="day" class="form-control" placeholder="日" value="<?php echo $t[2];?>" id="day" style="width: 50px"><span style="margin: 0 5px;">日</span>
  </div>
</td></tr>
<tr><td>連絡先：</td><td><input type="text" name="tel" class="form-control" value="<?php echo $tel;?>" id="tel"></td></tr>
<tr><td>メールアドレス：</td><td><input type="text" name="email" class="form-control" value="<?php echo $email;?>" id="email"></td></tr>

<tr>
<td>ユーザ種別</td>
<td>
<?php
  $role =  $urole;
  $roles = array(1=>'学生',2=>'教員', 5=>'組織');

  foreach ($roles as $u => $r){
    $u == 1 ? $pdl = 'onclick="checkradio(\'\');"' : $pdl = 'onclick="checkradio(\'none\');"';
    if ($u==$role){
      echo '<p style="display:inline-block; width:70px;"><input type="radio" name="urole" id="urole['.$u.']" value="' . $u .'" '. $pdl . ' checked>' . $r .'</p>';
    }else{
      echo '<p style="display:inline-block; width:70px;"><input type="radio" name="urole" id="urole['.$u.']" value="' . $u .'" '. $pdl . '>' . $r . '</p>';
    }
  }
?>
</td></tr>

<tr>
<td>学部・学科</td><td>
<select name="dept" class="form-control">
<?php
//学科を調べまわす
  echo $sql = "SELECT * FROM tb_department";
  $rs = mysql_query($sql, $conn);
  if (!$rs) die('エラー: ' . mysql_error());
  $d= mysql_fetch_array($rs);
 // var_dump($dept);


  while($d){
    $s = isset($did) && $did==$d['did']? 'selected': '';
    echo '<option value="'.$d['did'].'" '.$s.'>'.$d['dname'].'('.$d['did'].')'.'</option>';
    $d= mysql_fetch_array($rs);
  }
        ?>
</select></td>
</tr>

<tr><td>自己紹介</td><td><textarea name="selfintro" placeholder="例）趣味は英会話です。語学力には自信があります！" class="form-control"><?php echo $selfintro;?></textarea></td></tr>
</table>
<div class="col-sm-offset-1 col-sm-5">
  <input type="submit" class="btn btn-danger btn-lg btn-block" value="登録"  onclick="return CheckFormU();"/>
</div>
<div class="col-sm-offset-1 col-sm-4">
  <input type="reset" class="btn btn-default btn-lg btn-block" value="取消" />
</div>


</form>

</div>
</div>

<?php
include('page_footer.php');
?>