<?php
session_start();
require_once('db_inc.php');  //データベース接続
$vars = array_merge($_POST, $_GET);

if(!isset($_POST['kind'])){
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
    	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<title>違反報告</title>
    	<!-- Bootstrap -->
    	<link href="css/bootstrap.min.css" rel="stylesheet">
    	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    	<!--[if lt IE 9]>
    		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    	<![endif]-->
	</head>
<body>
<div class="container">
	<div class="panel panel-success">
		<div class="panel-heading">不適切な依頼を報告</div>
			<div class="panel-body">
				<form action="" method="post">
					<div class="form-group">
						<label for="selection">報告理由:</label>
						<select name="kind" class="form-control">
						<?php
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
							foreach($kind as $k => $d){
    							echo '<option name="kind" value="'.$k.'">'.$d.'</option>';
							}
      					?>
    					</select>
					</div>
					<div class="form-group">
						<label for="reason">詳細:</label>
						<textarea name="reason" class="form-control"></textarea>
					</div>
					<button class="btn btn-danger btn-block">送信</button>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
//送信されたとき
}else{
	$vars = array_merge($_POST, $_GET);

	echo $sql = "INSERT INTO tb_report VALUES (0,".$vars['requestid'].", ".$vars['kind'].", '".$vars['reason']."', '".$vars['userid']."', 0,0,0,0,0,0)";
	$rs = mysql_query($sql, $conn);
	if (!$rs) die('エラー: ' . mysql_error());
	if ($rs){
		echo '<h2>送信しました。ご協力ありがとうございました。</h2>';
	}
}


?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>

