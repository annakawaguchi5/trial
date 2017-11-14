<?php //他ユーザデータ閲覧用
require_once('db_inc.php');  //データベース接続

?>
<div class="container-fluid">
<div class="panel panel-success">
	<div class="panel-heading">クライアント情報</div>
	<div class="panel-body">
	<div class="row">
			<img src="./img/intro.png" width="200" height="200">
</div>
	<?php
	$sql = "SELECT *, if(gender=1,'男性','女性') as gender FROM tb_user WHERE userid='".$userid."'";
	$rs = mysql_query($sql, $conn);
	if (!$rs) die ('エラー: ' . mysql_error());
	$row = mysql_fetch_array($rs) ;
	?>
	<div class="row">
	<h4>
	<div class="col-sm-5">ユーザID</div>
	<div class="col-sm-7"><?php echo $row['userid'];?></div>
	<div class="col-sm-5">氏名</div>
	<div class="col-sm-7"><?php echo $row['uname'];?></div>
	<div class="col-sm-5">生年月日</div>
	<div class="col-sm-7">
	<?php
		echo date('Y年n月j日', strtotime($row['birth']));
	?>
	</div>
	<div class="col-sm-5">性別</div>
	<div class="col-sm-7"><?php echo $row['gender'];?></div>
	<div class="col-sm-5">利用開始日</div>
	<div class="col-sm-7"><?php echo date('Y年n月j日', strtotime($row['created_at']));?></div>
	<div class="col-sm-5">信頼度</div>
	<div class="col-sm-7">
	<?php
		if($row['evalnum']!=0){
			$total = $row['evalnum'];
			$good = $row['goodnum'];
			$bad = $row['evalnum']-$row['goodnum'];
			$p =  round(100*$row['goodnum']/$row['evalnum']);
			echo $p.'%';
			echo '<br><span style="font-size: small">(良い：'.$good.'件/悪い：'.$bad.'件)</span>';
		}else{
			echo 'データなし';
		}
	?>
	</div>

	<div class="col-lg-12" align="right"><a href="mypage.php?userid=<?php echo $userid; ?>">詳細はこちら</a></div>
	</h4>
	</div>
	</div>
</div>
</div>

