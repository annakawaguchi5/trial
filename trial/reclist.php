<?php
include('page_header.php');  //画面出力開始
require_once('db_inc.php');  //データベース接続

$userid = $_SESSION['userid'];
echo '<h2>受注履歴</h2>';
/*
echo $sql = "SELECT requestid, count(*) as people FROM  tb_recieve group by requestid ";
$rs = mysql_query($sql, $conn);
if (!$rs) die ('エラー: ' . mysql_error());
$people = array();
while ( $row = mysql_fetch_array($rs) ) {
	$rid  = $row['requestid'];
	$people[$rid ] = $row['people'];
}*/
$where = " where userid='{$userid}'";
$sql = "SELECT req.*, rec.*, rep.kind, rep.reason FROM tb_request req NATURAL JOIN tb_receive rec LEFT JOIN tb_report rep ON req.requestid=rep.requestid " . $where;//検索条件を適用するSQL文を作成
//echo $sql;
$rs = mysql_query($sql, $conn);
if (!$rs) die ('エラー: ' . mysql_error());
$row = mysql_fetch_array($rs);
if(!$row){
	echo '受注履歴がありません。';
}else{
?>
<table class="table table-striped table-hover">
<tr><th>依頼番号</th><th>依頼名</th><th>締切</th><th>ポイント</th>
<th>更新時間</th><th>納品</th><?php if($row['dgresult']==1) echo '<th>ユーザ評価</th>';?></tr>
<?php
while ( $row ) {
	echo '<tr>';
	echo '<td>' . $row['requestid'] . '</td>';
	echo '<td>' . $row['rname'] . '</td>';
	echo '<td>' . $row['edate'] . '</td>';
	echo '<td>' . $row['point']   . '</td>';
	$eday = $row['eday'];
	echo '<td>' . $eday .'</td>';
	if($row['state']==2){//依頼募集中
		if(isset($row['comment']) || isset($row['fileid'])){
			$del = 1;	//納品済み
			$disp = "納品物確認";
		}else{
			$del = 0;	//未納品
			$disp = "納品する";
		}
		echo '<td><a href="dgoods.php?rid=' . $row['requestid'] . '&del='.$del.'">'.$disp.'</a></td>';
	}else if($row['state']==-1){//違反依頼
		//違反種別
		$k = array(
		0 => '不適切な単語を有する依頼',
		1 => '悪質なリンク',
		2 => '個人情報の掲載',
		3 => '直接取引が危惧される依頼',
		4 => '公序良俗、法令に反する依頼',
		5 => '依頼になっていない依頼',
		6 => 'その他（下記の違反理由で詳細に）'
		);

		if($row['kind']!=NULL){
			$exp = '違反理由：';
			$exp .= $k[$row['kind']]."\n";
			if(!$row['reason']==''){
				$exp .= '詳細：';
				$exp .= $row['reason'];
			}
		}else{
			$exp = '';
		}

		echo '<td><a href="#" class="exp" title="'.$exp.'" >管理者により削除されました。</a></td>';
	}else{
		echo '<td></td>';
	}


	if($row['dgresult']==1){echo '<td><a href="javascript:;" onclick="OpenWindow2(\''.$row['requserid'].'\')">'.$row['requserid'].'さんを評価する</a></td>';}
	echo '</tr>';
	$row = mysql_fetch_array($rs);
}
}
?>
</table>

<?php include('page_footer.php');?>