<?php
include('page_header.php');  //画面出力開始
require_once('db_inc.php');  //データベース接続

if(!$_SESSION['post'] == 9){	//管理者でない時
	die('エラー：この機能を利用する権限がありません。');
}

echo '<h2>ユーザ一覧</h2>';
$sql = "SELECT * FROM vw_user";//検索条件を適用するSQL文を作成
//echo $sql;
$rs = mysql_query($sql, $conn);
if (!$rs) die ('エラー: ' . mysql_error());
$row = mysql_fetch_array($rs);
if(!$row){
	echo 'アカウントが存在しません。';
}else{
	?>
	<table class="table table-striped table-hover">
		<tr><th>ユーザID</th><th>氏名</th><th>性別</th><th>生年月日</th>
			<th>電話</th><th>メール</th><th>所属</th><th>自己紹介</th><th>種別</th>
			<th>ポイント</th><th>利用開始日</th><th>評価(Good数/評価数)</th><th>権限状態</th><th>利用権限修正</th></tr>
			<?php
			while ( $row ) {
				echo '<tr>';
				echo '<td>' . $row['userid'] . '</td>';
				echo '<td>' . $row['uname'] . '</td>';
				$g = array(0=> '－', 1=>'男', 2=>'女', 3=>'その他');
				echo '<td>' . $g[$row['gender']] . '</td>';
				echo '<td>' . date('Y/m/d', strtotime($row['birth'])) . '</td>';
				echo '<td>' . $row['tel'] . '</td>';
				echo '<td>' . $row['email'] . '</td>';
				echo '<td>' . $row['dname'] . '</td>';
				echo '<td>' . $row['selfintro'] . '</td>';
				$uroles = array(1=>'学生',2=>'教員', 5=>'組織', 8=>'審査員', 9=>'管理者');
				echo '<td>' . $uroles[$row['post']] . '</td>';
				echo '<td>' . $row['rpoint'] . '</td>';
				echo '<td>' . date('Y/m/d', strtotime($row['created_at'])) . '</td>';
				echo '<td>' . percent($row['goodnum'], $row['evalnum']) . '</td>';
				$a = array(0=>'停止中', 1=>'利用可能');
				echo '<td>' . $a[$row['auth']] . '</td>';
				if($row['post'] != 8 && $row['post'] != 9){
					echo '<td><a href="javascript:;" onclick="OpenWindow3(\''.$row['userid'].'\','.$row['auth'].')">利用権限修正</a></td>';
				}else{
					echo '<td></td>';
				}
				echo '</tr>';
				$row = mysql_fetch_array($rs);
			}
}
	?>
</table>


<?php
function percent($g, $e){
	if($e == 0){
		$str = '評価なし';
	}else{
		$str = $g . '件/' . $e . '件';
		$p = round($g/$e*100);
		$str .= '(' . $p .'%)';
	}
	return $str;
}
include('page_footer.php');?>