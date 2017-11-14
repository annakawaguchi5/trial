<?php
include('page_header.php');  //画面出力開始
require_once('db_inc.php');  //データベース接続

$vars = array_merge($_POST, $_GET);
//var_dump($vars);
$requestid=$vars['requestid'];

$where = 'WHERE requestid="'.$requestid.'" AND requserid=userid';
echo $sql = 'SELECT * FROM tb_request, tb_user '.$where;	//検索条件を適用したSQL文を作成
$rs = mysql_query($sql, $conn);
if (!$rs) die ('エラー: ' . mysql_error());
$row = mysql_fetch_array($rs) ;
$edate=substr($row['edate'],0,16);
?>
<h2>日程調整機能</h2>
<div class="container-fluid bg-info">
	<form action="recconfirm_save.php" class="form-horizontal"
		method="post">
		<input type="hidden" name="requestid" value="<?php echo $requestid;?>">
		<input type="hidden" name="userid" value="<?php echo $_SESSION['userid'];?>">
		<input type="hidden" name="category" value="<?php echo $row['category'];?>">
		<div class="form-group">
			<label for="rname" class="control-label col-sm-2">依頼名:</label> <b
				class="col-sm-8"> <?php echo $row['rname'];?> </b>
				<input type="hidden" name="rname" value="<?php echo $row['rname'];?>">
		</div>
		<div class="form-group">
			<label for="edate" class="control-label col-sm-2">募集締切日:</label>
			<p class="col-sm-8">
			<?php echo $edate;?>
			</p>
			<input type="hidden" name="sdate" value="<?php echo $row['sdate'];?>">
			<input type="hidden" name="edate" value="<?php echo $row['edate'];?>">
		</div>
		<div class="form-group">
			<label for="schedule" class="control-label col-sm-2">日程:</label>
			<p class="col-sm-8">
			<?php
			$sql = 'SELECT * FROM tb_schedule wHERE requestid='.$vars['requestid'].' ORDER BY stime ASC' ;	//検索条件を適用したSQL文を作成
			$rs = mysql_query($sql, $conn);
			if (!$rs) die ('エラー: ' . mysql_error());
			$row = mysql_fetch_array($rs) ;


			while($row){
				$stime=substr($row['stime'],0,16);
							$etime=substr($row['etime'],0,16);
				echo $stime.' ～ '.$etime;?>

				<input type="radio" name="poss[<?php echo $row['optid'];?>]"
					style="color: red;" value="1"> ◯ <input type="radio"
					name="poss[<?php echo $row['optid'];?>]" value="0" checked> × <br>
					<?php
					$row = mysql_fetch_array($rs) ;
			}?>
			</p>
		</div>
		<div class="col-sm-offset-2 col-sm-4">
			<button type="submit" class="btn btn-danger btn-lg btn-block">登 録</button>
		</div>
	</form>
</div>

			<?php
			include('page_footer.php');
				?>