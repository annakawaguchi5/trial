<?php
include('page_header.php');  //画面出力開始
require_once('db_inc.php');  //データベース接続

$vars = array_merge($_POST, $_GET);
//var_dump($vars);

if(!isset($_POST['m'])){
?>

	<div class="panel panel-success">
		<div class="panel-heading">ユーザを評価する</div>
			<div class="panel-body">
				<form action="" method="post">
					<input type="hidden" name="requserid" value="<?php echo $vars['requserid'];?>">
					<div class="form-group">
						<label for="evaluation" class="col-xs-12 bigfont"><?php echo $vars['requserid'];?>さんの評価：</label>
						<div class="col-xs-6">
						<input type="submit" name="m" class="btn btn-danger btn-lg form-control" value="Good">
						</div>
						<div class="col-xs-6">
						<input type="submit" name="m" class="btn btn-primary btn-lg form-control" value="Bad">
						</div>
					</div>
				</form>
			</div>
	</div>
<?php
}else{
	$good = $vars['m']=='Good' ? 'goodnum + 1' : 'goodnum';
	$sql = "UPDATE tb_user SET evalnum = evalnum + 1, goodnum = $good WHERE userid='{$vars['requserid']}'";
	$rs = mysql_query($sql, $conn);
	if (!$rs) die('エラー: ' . mysql_error());
	if ($rs){
		echo '<h2>送信しました。ご協力ありがとうございました。</h2>';
	}
}

include('page_footer.php');?>