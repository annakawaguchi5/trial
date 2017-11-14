<?php
include('page_header.php');  //画面出力開始
require_once('db_inc.php');  //データベース接続

$requestid = $_GET['requestid'];
$where = 'WHERE requestid="'.$requestid.'"';
$sql = 'SELECT * FROM tb_request NATURAL JOIN tb_user '.$where;	//検索条件を適用したSQL文を作成
$rs = mysql_query($sql, $conn);
if (!$rs) die ('エラー: ' . mysql_error());
$row = mysql_fetch_array($rs) ;

$sdate=$row['sdate'];
$edate=$row['edate'];
$contents=$row['contents'];
$requserid=$row['requserid'];
$uname=$row['uname'];
$d=$row['dept'];
?>

<div class="container">

	<!-- 8列を割り当て 詳細情報 -->


	<div class="col-xs-8">
		<div class="row">
			<!-- タイトル -->
		<?php
		echo '<h1>'.$row['rname'].'</h1>';
		?>



			<div class="row">
				<div class="col-xs-3">
					<div class="panel panel-info">
						<div class="panel-heading">報酬</div>
						<div class="panel-body">
						<?php
						echo $row['point'].'ポイント';
						?>
						</div>
					</div>
				</div>
				<div class="col-xs-3">
					<div class="panel panel-info">
						<div class="panel-heading">募集人数</div>
						<div class="panel-body">
						<?php
						$perficient = $row['perficient'];
						echo $perficient.'人';
						?>
						</div>
					</div>
				</div>
				<div class="col-xs-3">
					<div class="panel panel-info">
						<div class="panel-heading">応募人数</div>
						<div class="panel-body">
						<?php
						$sql = 'SELECT COUNT(*) FROM tb_receive '.$where;	//検索条件を適用したSQL文を作成
						$rs = mysql_query($sql, $conn);
						if (!$rs) die ('エラー: ' . mysql_error());
						$row = mysql_fetch_array($rs) ;
						//保留, SQL発動
						$apply = $row['COUNT(*)'];
						echo $apply.'人';
						//echo '人';
						?>
						</div>
					</div>
				</div>
				<div class="col-xs-3">
					<div class="panel panel-info">
						<div class="panel-heading">残り人数</div>
						<div class="panel-body">
						<?php
						//保留, SQL発動
						//echo $row['point'].'人';
						$rest=$perficient-$apply;
						echo $rest.'人';
						?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
				<?php
				echo 'ワーク方式：プロジェクト<br>';//+SQL
				echo 'カテゴリ：ポスター作成<br>';//+SQL(genre)
				?>
				</div>
				<div class="col-xs-6">
				<?php
				/*
				 echo '募集開始日：'.$sdate.'<br>';
				 echo '募集締切日：'.$edate.'<br>';
				 echo '希望納品日：<br>';
				 */
				echo '募集開始日：2016-07-20<br>';
				echo '募集締切日：2016-07-27<br>';
				echo '希望納品日：2016-08-07<br>';
				?>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12">
					<div class="panel panel-info">
						<div class="panel-heading">ワーク内容</div>
						<div class="panel-body">
						<?php
						echo $contents;
						?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="panel panel-info">
						<div class="panel-heading">質問掲示板</div>
						<div class="panel-body"></div>
					</div>
				</div>
			</div>
		</div>
		<div container-fluid>
			<button class="col-xs-offset-5 btn btn-danger btn-lg">受注する</button>
		</div>
	</div>

	<?php
	$course = array(
'文系'=>array('es'),
'理系'=>array('jk')
	);

	$dept = array('jk'=>'情報科学');
	?>
	<!-- 3列を割り当て クライアント情報・連絡 -->
	<div class="col-xs-offset-1 col-xs-3">
		<div class="row">
			<div class="panel panel-success">
				<div class="panel-heading">クライアント情報</div>
				<div class="panel-body">
					<div class="col-xs-offset-2">
						<img
							src="http://icon.touch-slide.jp/wp/wp-content/uploads/2012/07/s00023.jpg"
							style="width: 150px; height: 150px;"> <br>
							<?php
							//echo '画像<br>';

							echo $requserid.'<br>'.$uname.'<br>';
							//echo $course.'|';
							echo '理系｜';
							echo $dept[$d].'部<br>';
							?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="panel panel-success">
				<div class="panel-heading">クライアントに質問</div>
				<div class="panel-body">
					<textarea class="form-control"></textarea>
					<br>
					<button class="btn btn-success btn-block">送信</button>
				</div>
			</div>
		</div>
	</div>
</div>




							<?php
							include('page_footer.php');
							?>