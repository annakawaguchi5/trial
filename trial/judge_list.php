<?php
if(!isset($vars['reqid']))include('page_header.php');  //画面出力開始
require_once('db_inc.php');  //データベース接続


//要承認のリスト検索
$where = 'WHERE state=0';
$sql = 'SELECT * FROM tb_request r '.$where;	//検索条件を適用したSQL文を作成
$rs = mysql_query($sql, $conn);
if (!$rs) die ('エラー: ' . mysql_error());
$row = mysql_fetch_array($rs) ;
//var_dump($row);
?>
<h2>承認依頼　一覧</h2>
<form action="judge_list.php" method="post">
<table class="table table-striped">
<thead>
<tr class="info"><th></th><th>依頼番号</th><th>依頼名</th><th>依頼詳細</th><th>依頼者</th><th>第三者</th><th>カテゴリ</th></tr>
</thead>
<tbody>
<?php
$c = array (
	0 => '未分類',
	1 => 'フィジカルワーク',
	2 => 'ディジタルワーク'
	);
while($row){
	if(isset($row['outsiderid']) && $row['outsiderid'] == NULL){
	$outsiderid = $row['outsiderid'];
}else{
	$outsiderid = 'なし';
}

echo '<tr><td><input type="checkbox" name="reqid[]" value="'.$row['requestid'].'"></td><td>'.$row['requestid'].'</td><td>'.$row['rname'].'</td><td>'.$row['contents'].'</td><td>'.$row['requserid'].'</td><td>'.$outsiderid.'</td><td>'.$c[$row['category']].'</td></tr>';
$row = mysql_fetch_array($rs) ;
}?>
</tbody>
</table>
<button type="submit" name="state" class="btn btn-success btn-block" value="1">採用</button>
<button type="submit" name="state" class="btn btn-danger btn-block" value="-1">拒否</button>
</form>

<?php
$vars = array_merge($_POST, $_GET);
//var_dump($vars);

if(isset($vars['reqid'])){
	foreach($vars['reqid'] as $r => $s){
	//要承認のリスト検索
	$where = ' WHERE requestid='.$s;
	$sql = 'UPDATE tb_request SET state ='.$vars['state'].$where;	//検索条件を適用したSQL文を作成
	$rs = mysql_query($sql, $conn);
	if (!$rs) die ('エラー: ' . mysql_error());
	}
	if($rs){
		header('Location:judge_list.php');
	}
}
?>
<?php
if(!isset($vars) || empty($vars))include('page_footer.php');
?>