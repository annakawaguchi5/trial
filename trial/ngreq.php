<?php
if(!isset($vars['reqid']) || empty($vars)){
include('page_header.php');  //画面出力開始
}else{
	session_start();
}
require_once('db_inc.php');  //データベース接続
//要承認のリスト検索
$where = " WHERE result=0 AND ".$_SESSION['userid']."=0";
$sql = 'SELECT * FROM tb_report r NATURAL JOIN tb_request '.$where;	//検索条件を適用したSQL文を作成
$rs = mysql_query($sql, $conn);
if (!$rs) die ('エラー: ' . mysql_error());
$row = mysql_fetch_array($rs) ;

//var_dump($row);
//違反種別
$kind = array(
	0 => '不適切な単語を有する依頼',
	1 => '悪質なリンク',
	2 => '個人情報の掲載',
	3 => '直接取引が危惧される依頼',
	4 => '公序良俗、法令に反する依頼',
	5 => '依頼になっていない依頼',
	6 => 'その他（下記の違反理由で詳細に）'
);
?>
<h2>違反判定</h2>
<form action="ngreq.php" method="post">
<table class="table table-striped">
<thead>
<tr class="info"><th></th><th>依頼番号</th><th>依頼名</th><th>依頼詳細</th><th>依頼者</th><th>報告理由</th><th>詳細</th></tr>
</thead>
<tbody>
<?php
$c = array (
	0 => '未分類'
	);
while($row){
	echo '<tr><td><input type="checkbox" name="reqid['.$row['repid'].']" value="'.$_SESSION['userid'].'"></td><td>'.$row['requestid'].'</td><td>'.$row['rname'].'</td><td>'.$row['contents'].'</td><td>'.$row['requserid'].'</td><td>'.$kind[$row['kind']].'</td><td>'.$row['reason'].'</td></tr>';
$row = mysql_fetch_array($rs) ;
}?>
</tbody>
</table>
<button type="submit" name="act" class="btn btn-success btn-block col-xs-6 form-control" value="1">継続</button>
<button type="submit" name="act" class="btn btn-danger btn-block col-xs-6 form-control" value="-1">取消</button>
</form>

<?php
$vars = array_merge($_POST, $_GET);
//var_dump($vars);

if(isset($vars['reqid'])){
	foreach($vars['reqid'] as $r => $s){	//$r=repid報告番号, $s=userid審査員ID
		//要承認のリスト検索
		$where = " WHERE result=0 AND ".$s."=0 AND repid=".$r;
		echo $sql = 'SELECT * FROM tb_report r NATURAL JOIN tb_request '.$where;	//検索条件を適用したSQL文を作成
		$rs = mysql_query($sql, $conn);
		if (!$rs) die ('エラー: ' . mysql_error());
		$row = mysql_fetch_array($rs) ;

		if($row){
			$result = "";
			$cancelnum = ($vars['act']==1) ? "" : " , cancelnum = cancelnum + 1 ";
			if($row['insp']!=0){	//2,3回目
				if($row['cancelnum']==1 && $vars['act']==(-1)){	//(×,×,?)or(×,×,×)
					$result = " , result=2 ";	//依頼取り消し
					$state = "-1";
				}
				if($row['insp']==1){	//2回目
					if($row['cancelnum']==0 && $vars['act']==1){	//(○,○,?)
						$result = " , result=1 ";	//依頼継続
					}
				}else if($row['insp']==2){	//3回目
					if($row['cancelnum']==1 && $vars['act']==1){	//(○,×,○)or(×,○,○)
						$result = " , result=1 ";
					}
				}
			}
			//DB更新
			//違反判定の結果を反映
			$where = ' WHERE repid='.$r;
			echo $sql = 'UPDATE tb_report SET insp =insp+1'.$cancelnum. ','. $_SESSION['userid'].' = '.$vars['act'].$result.$where;	//審査済=>insp++
			$rs = mysql_query($sql, $conn);
			if (!$rs) die ('エラー: ' . mysql_error());

			if(isset($state)){
			//不適切依頼の非公開化
			$where = ' WHERE requestid='.$row['requestid'];
			echo $sql = 'UPDATE tb_request SET state = -1 '.$where;	//審査済=>insp++
			$rs = mysql_query($sql, $conn);
			if (!$rs) die ('エラー: ' . mysql_error());
			}
		}
	}
}

/*
if(isset($vars['reqid'])){
	foreach($vars['reqid'] as $r => $s){	//$r=依頼番号, $s=審査員ID

	if($vars['act']==(-1)){
		$cancelnum = $ 
	}else{
		
	}
		//要承認のリスト検索
	$where = ' WHERE requestid='.$r;
	echo $sql = 'UPDATE tb_report SET insp ='.($s+1).', '.$_SESSION['userid'].'= '.$vars['act'].''.$where;	//審査済=>insp++
	//$rs = mysql_query($sql, $conn);
	if (!$rs) die ('エラー: ' . mysql_error());
*/
?>
<?php
if(!isset($vars) || empty($vars))include('page_footer.php');
?>