<?php
$vars = array_merge($_POST, $_GET);
//var_dump($vars);

if(!isset($vars['rid'])){	//依頼番号がないとき→リスト
	header("Location: reqlist.php");
}else{	//依頼番号があるとき
	echo "<h2>納品物一覧</h2>";
	include('page_header.php');
	include 'db_inc.php';
	echo $sql = "SELECT * FROM  tb_receive 	natural join tb_request req WHERE req.requserid='{$_SESSION['userid']}' AND req.requestid='{$vars['rid']}' ORDER BY req.requestid";
	$rs = mysql_query($sql, $conn);
	$row = mysql_fetch_array($rs); 
	if (!$rs) die ('エラー: ' . mysql_error());
	echo '依頼番号：'.$vars['rid'].'<br>依頼名：'.$row['rname'].'<br><a href = "reqclear.php?rid='. $row['requestid'].'">達成者選択</a><br>';
	echo '<table  class="table table-striped table-hover">';
	
	echo '<tr><th class="number" title="クリックで並び替え">納品者</th><th>コメント</th><th class="number" title="クリックで並び替え">ファイル</th><th class="number" title="クリックで並び替え">納品日</th><th class="number" title="クリックで並び替え">採択状況</th></tr>';
	while ($row) {
		echo '<tr>';
		echo '<td><a href = "view.php?userid='. $row['userid'].'">' . $row['userid'] . '</a></td>';
		echo '<td>' . $row['comment'] . '</td>';
		if($row['fileid'] != NULL){
			$filename = './upfile/' . $row['fileid'] . '.' . $row['mime'];
			$url = '<a href="'.$filename.'">'.$filename.'</a>';
		}else{
			$filename = "未登録";
		}
		echo '<td>' . $url . '</td>';
		echo '<td>' . $row['eday']   . '</td>';
		echo '<td>' . $row['dgresult'] . '</td>';
		echo '</tr>';
		$row = mysql_fetch_array($rs); 
	}
	echo '</table>';
}
include('page_footer.php');
?>