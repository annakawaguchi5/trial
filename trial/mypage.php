<?php
include('page_header.php');  //画面出力開始
require_once('db_inc.php');  //データベース接続
$vars = array_merge($_POST, $_GET);
$userid=$_GET['userid'];  //表示するuseridを取得

  //ユーザ情報検索
$sql = "SELECT * FROM tb_user u LEFT JOIN tb_department dep ON u.dept = dep.did LEFT JOIN tb_image img ON u.userid = img.userid WHERE u.userid='".$vars['userid']."'";
  $rs = mysql_query($sql, $conn); //SQL文を実行
  if (!$rs) die ('エラー: ' . mysql_error());
  $mydata = mysql_fetch_array($rs);

  $g = array(
	0 => 'なし',
	1 => '男性',
	2 => '女性',
	3 => 'その他',
	);

  $p = array(
	1 => '学生',
	2 => '教員',
	8 => '組織',
	9 => '管理者'
	);

  $mydata['gender'] = $g[$mydata['gender']];
  $mydata['post'] = $p[$mydata['post']];

  echo '<div class="container">';

  if(isset($_SESSION['userid']) && $_SESSION['userid']==$userid){
	echo '<h2>マイページ</h2>';
  }else{
	echo '<h2>'.$userid.'さんのプロフィール</h2>';
  }
  ?>


  <div class="row mydata">
	<div class="mediumfont">
	  <div class="col-sm-4">
		<!-- 写真 -->

		  <?php
		  if($mydata['imgid'] != NULL){ //写真がある時
			echo '<div class="center"><img src="./img/'.$userid.'.'.$mydata['mime'].'"></div>';
		  }else{
			echo '<div class="center"><img src="./img/person.jpg"></div>';
		  }
		  if(isset($_SESSION['userid']) && $_SESSION['userid'] == $userid){

			echo '<div class="center"><a href="javascript:;" onclick="OpenWindow4(\''.$userid.'\')" class="btn btn-success" id="upbtn">アップロード</a></div>';
		  }
		  ?>
<br>

		<!-- 信頼度 -->
		<?php include('chart.php');?>

	  </div>

	  <!-- プロフィール -->
	  <div class="col-sm-8">
		<div class="right">

		  <?php if(isset($_SESSION['userid']) && $_SESSION['userid']==$userid){    //本人?>

		  <a href="user_add.php?uid=<?php echo $userid;?>"><button type="button" class="btn btn-warning btn-lg">変更</button></a>
		</div>
		<table>
		  <tr><td>ひとこと：</td><td><?php echo $c = ($mydata['selfintro']!=NULL)?$mydata['selfintro']:'未登録';?>
		  </td></tr>
		  <tr><td>ユーザID：</td><td><?php echo $userid; ?></td></tr>
		  <tr><td>名前：</td><td><?php echo $mydata['uname']; ?></td></tr>
		  <tr><td>性別：</td><td><?php echo $mydata['gender'];?></td></tr>
		  <tr><td>生年月日：</td><td><?php echo date('Y 年 n 月 j 日',strtotime($mydata['birth'])); ?></td></tr>
		  <tr><td>職種：</td><td><?php echo $mydata['post'];?></td></tr>
		  <tr><td>学部・学科：</td><td><?php echo $mydata['dname']; ?></td></tr>
		  <tr><td>連絡先：</td><td><?php echo $mydata['tel']; ?>(電話)<br><?php echo $mydata['email']; ?>(メール)</td></tr>
		  <tr><td>利用開始日：</td><td><?php echo date('Y 年 n 月 j 日',strtotime($mydata['created_at'])); ?></td></tr>

		</table>

		<?php }else{ //本人以外?>

	  </div>
	  <table>
		<tr><td>ひとこと：</td><td><?php echo $c = ($mydata['selfintro']!=NULL)?$mydata['selfintro']:'未登録';?>
		</td></tr>
		<tr><td>ユーザID：</td><td><?php echo $userid; ?></td></tr>
		<tr><td>名前：</td><td><?php echo $mydata['uname']; ?></td></tr>
		<tr><td>性別：</td><td><?php echo $mydata['gender'];?></td></tr>
		<tr><td>生年月日：</td><td><?php echo date('Y 年 n 月 j 日',strtotime($mydata['birth'])); ?></td></tr>
		<tr><td>職種：</td><td><?php echo $mydata['post'];?></td></tr>
		<tr><td>学部・学科：</td><td><?php echo $mydata['dname']; ?></td></tr>
		<tr><td>利用開始日：</td><td><?php echo date('Y 年 n 月 j 日',strtotime($mydata['created_at'])); ?></td></tr>
	  </table>

	  <?php } ?>
	</div>
  </div>
</div>

<?php
echo $sql = "SELECT req.*, rec.*, rep.kind, rep.reason FROM tb_request req NATURAL JOIN tb_receive rec LEFT JOIN tb_report rep ON req.requestid=rep.requestid WHERE userid='".$vars['userid']."' ORDER BY updatetime LIMIT 10";
  $rs = mysql_query($sql, $conn); //SQL文を実行
  if (!$rs) die ('エラー: ' . mysql_error());
  $row = mysql_fetch_array($rs);
?>
	<div class="row">
	<div class="">
	<h2>最近の成果物</h2>
	<?php
	if(!$row){
		echo '<div><h3>成果物はありません。</h3></div>';
	}else{
			echo '<div>';
			echo '<table class="table table-striped table-hover">';
			echo '<tr><th>依頼名</th><th>コメント</th><th>ファイル</th><th>更新時刻</th></tr>';
			while($row){
				echo '<tr><td>' . $row['rname'] . '</td>';
				echo '<td>' . $row['comment'] . '</td>';
				if(isset($row['fileid'])){
					$address = './upfile/' . $row['fileid'] .'.'.$row['mime'] ;
					echo '<td><a href="'.$address.'">'.$address.'</a></td>';
				}else{
					echo '<td></td>';
				}
				echo '<td>' . date('Y年 n月 j日 H:i',strtotime($row['updatetime'])) . '</td></tr>';
				$row = mysql_fetch_array($rs);
			}
			echo '</table>';
			echo '<div>';
		}

		?>
	</div>
</div>



<!---->
<?php
include('page_footer.php');
?>