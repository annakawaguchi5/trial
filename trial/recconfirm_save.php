<?php
include('page_header.php');  //画面出力開始
require_once('db_inc.php');  //データベース接続

$vars = array_merge($_POST, $_GET);
//var_dump($vars);

if(!$vars){
	echo '受注登録に失敗しました。再度登録作業を行ってください。';
}else{
	if($vars['category']==1){
		foreach($vars['poss'] as $optid => $possibility){
			$sql = "INSERT INTO tb_adjustskd VALUES ('".$vars['userid']."',".$vars['requestid'].",".$optid.",".$possibility.")";
			//echo $sql;
			$rs = mysql_query($sql, $conn);
			if (!$rs) die ('エラー: ' . mysql_error());
		}
	}else{
		$where = 'WHERE requestid='.$vars['requestid'];
		$sql = 'SELECT * FROM tb_request '.$where;	//検索条件を適用したSQL文を作成
		$rs = mysql_query($sql, $conn);
		if (!$rs) die ('エラー: ' . mysql_error());
		$row = mysql_fetch_array($rs) ;

		$sql = "INSERT INTO tb_receive VALUES (".$vars['requestid'].",'".$_SESSION['userid']."',NULL,NULL,1,NULL,NULL,'".$row['sdate']."','".$row['edate']."', now())";	//検索条件を適用したSQL文を作成
		//echo $sql;
		$rs = mysql_query($sql, $conn);
		if (!$rs) die ('エラー: ' . mysql_error());

	}
	if($rs){
		if($vars['category']==1){
			$msg="登録しました。<br>依頼者が日程を決定するまで少々お待ちください。<br>決定日程はワーク詳細ページで確認できます。";
		}else{
			$msg="登録しました。<br>締切日に留意して、納品を完了させてください。<br>納品は受注一覧より可能です。";
		}
		?>
<div class="container">
	<h2 class="text-center">
		<?php echo $msg;?>
	</h2>
</div>
		<?php

	}
}
?>

<?php
include('page_footer.php');
?>