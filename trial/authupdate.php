<?php
include('page_header.php');  //画面出力開始
require_once('db_inc.php');  //データベース接続

$vars = array_merge($_POST, $_GET);
//var_dump($vars);
$userid = $vars['userid'];

if(!isset($_POST['m'])){
	$a = array(0=>'停止中', 1=>'利用可能');
?>

	<div class="panel panel-success">
		<div class="panel-heading">利用権限修正</div>
			<div class="panel-body">
			<p  class="bigfont">現在状況：<?php echo $a[$vars['auth']];?></p>
				<form action="" method="post">
					<input type="hidden" name="userid" value="<?php echo $vars['userid'];?>">
					<div class="form-group">
						<label for="evaluation" class="col-xs-12 bigfont"><?php echo $vars['userid'];?>さんの利用権限：</label>
						<div class="col-xs-6">
						<button type="submit" name="m" class="btn btn-danger btn-lg form-control" value="0" >利用停止</button>
						</div>
						<div class="col-xs-6">
						<button type="submit" name="m" class="btn btn-primary btn-lg form-control" value="1">利用開始</button>
						</div>
					</div>
				</form>
			</div>
	</div>
<?php
}else{
	$sql = "UPDATE tb_user SET auth = {$vars['m']} WHERE userid='{$vars['userid']}'";
	$rs = mysql_query($sql, $conn);
	if (!$rs) die('エラー: ' . mysql_error());
	if ($rs){
		echo '<h2>利用権限を変更しました。</h2>';
	}
}

include('page_footer.php');?>