<?php
include('page_header.php');  //画面出力開始
require_once('db_inc.php');  //データベース接続

$vars = array_merge($_POST, $_GET);
//var_dump($vars);

//$requestid = $_GET['requestid'];
$where = 'WHERE requestid='.$vars['requestid'];
$sql = 'SELECT * FROM tb_request r LEFT JOIN tb_user u ON r.outsider = u.userid '.$where;	//検索条件を適用したSQL文を作成
$rs = mysql_query($sql, $conn);
if (!$rs) die ('エラー: ' . mysql_error());
$detail = mysql_fetch_array($rs) ;
//echo $sql;

//var_dump($detail);
$user = isset($_SESSION['userid']) ? $_SESSION['userid'] : NULL;
$reqid=$vars['requestid'];
$userid = $detail['requserid'];

$c = array(0=>'', 1=>'フィジカルワーク', 2=>'ディジタルワーク');
$method=array(1=>'分配', 2=>'全額', 3=>'順位付け配布');

$sdate=substr($detail['sdate'],0,16);
$edate=substr($detail['edate'],0,16);
date_default_timezone_set('Asia/Tokyo');
$now = date('Y-m-d H:i:s');

$date = 0;
if($now<$detail['sdate']){
	$date = 1;
}else if($detail['sdate']<$now && $now<$detail['edate']){
	$date = 2;
}else if($detail['edate']<$now){
	$date = 3;
}

function state($s, $d){
	$date = array(
		-1 => '非公開（違反依頼）',
		0 => '非公開（フィルタリング不合格）',
		1 => '非公開（承認中）',
		3 => '募集終了',
		);

	if($s != 2){
		$str .= $date[$s];
	}else{
		$str = '公開中';
		if($d == 1){
			$str .= '（募集前）';
		}else if($d ==2){
			$str .= '（募集中）';
		}else{
			$str .= '（募集終了）';
		}
	}
	return $str;
}

?>

<div class="container">
	<?php
	echo '<h4><span class="red">'.state($detail['state'], $date).'</span></h4>';
	echo '<h1>'.$detail['rname'].'<small><a href="javascript:;" onclick="OpenWindow(\''.$reqid.'\',\''.$user.'\')">違反報告する</a><small></h1>';
	?>
	<!-- 9列を割り当て 詳細情報 -->


	<div class="col-xs-8">
		<!-- タイトル -->


		<div class="row">
			<div class="col-xs-3">
				<div class="panel panel-info">
					<div class="panel-heading">仕事ジャンル</div>
					<div class="panel-body">
						<?php
						echo $c[$detail['category']];
						?>
					</div>
				</div>
			</div>
			<div class="col-xs-3">
				<div class="panel panel-info">
					<div class="panel-heading">報酬</div>
					<div class="panel-body">
						<?php
						echo $detail['point'].'ポイント（'.$method[$detail['amethod']].'）';
						?>
					</div>
				</div>
			</div>

			<div class="col-xs-3">
				<div class="panel panel-info">
					<div class="panel-heading">募集人数</div>
					<div class="panel-body">
						<?php
						$perficient = $detail['perficient'];
						echo $perficient.'人';
						?>
					</div>
				</div>
			</div>
			<div class="col-xs-3">
				<?php if($detail['category']==1){?>
				<div class="panel panel-info">
					<div class="panel-heading">第3者</div>
					<div class="panel-body">
						<?php
						if($detail['outsider']){
						//echo $detail['uname'];
							echo $detail['outsider'];
						}else{
							echo 'なし';
						}
						?>
					</div>
				</div>
				<?php }?>
			</div>
		</div>


		<div class="panel panel-info">
			<div class="panel-heading">募集開始日</div>
			<div class="panel-body">
				<?php
				echo $sdate;

				?>
			</div>
		</div>



		<div class="panel panel-info">
			<div class="panel-heading">募集締切日</div>
			<div class="panel-body">
				<?php
				echo $edate;
				?>
			</div>
		</div>





		<div class="panel panel-info">
			<div class="panel-heading">仕事内容・概要</div>
			<div class="panel-body">
				<?php
				echo $detail['contents'];

				?>
			</div>
		</div>


		<?php if($user != $detail['requserid']){	//ログイン中のユーザが依頼者でない時
			//ユーザが利用権限を持っているか
			$sql = "SELECT auth FROM tb_user WHERE userid='".$user."'";
			$rs = mysql_query($sql, $conn);
			if (!$rs) die ('エラー: ' . mysql_error());
			$row = mysql_fetch_array($rs) ;
			$auth = $row['auth'];
			if($detail['category']==1){	//フィジカル
				//受注状況検索
				$sql = "SELECT * FROM tb_adjustskd ad WHERE requestid=".$vars['requestid']." AND receiverid='".$user."'";
				$rs = mysql_query($sql, $conn);
				if (!$rs) die ('エラー: ' . mysql_error());
				$row = mysql_fetch_array($rs) ;
			}else{	//ディジタル
				//受注状況検索
				$sql = "SELECT * FROM tb_receive WHERE requestid=".$vars['requestid']." AND userid='".$user."'";
				$rs = mysql_query($sql, $conn);
				if (!$rs) die ('エラー: ' . mysql_error());
				$row = mysql_fetch_array($rs) ;
			}
			//echo $sql;

			//受注ボタン作成
			if(!$user){	//未ログイン
				button($vars['requestid'],'yetlogin','');
			}else if($auth==0){	//利用権限停止中
				button($vars['requestid'],'unauth','');
			}else if($row){	//受注済み
				button($vars['requestid'],'already','');
				$unrec=0;
			}else{	//未受注
				$unrec=1;
				if($date == 1){	//募集前
					button($vars['requestid'], 'notstart','');
				}else if($date == 2){	//募集中
					if($detail['category']==1){
						button($vars['requestid'],'abled','p');	//フィジカル
					}else{
						button($vars['requestid'],'abled','d');	//ディジタル
					}
				}else if($date == 3){	//募集終了
					button($vars['requestid'],'ended','');
				}
			}?>



			<?php }?>
		</div>

		<!-- 3列を割り当て スケジュールリスト-->
		<div class="col-xs-4">
			<?php
	$unrec = $user==$detail['requserid'] ? 0 : 1 ;	//依頼人がスケジュール見れるように

	//依頼完了者がいるかどうか
	$sql = "SELECT * FROM tb_receive WHERE requestid=".$vars['requestid']." AND EXISTS (SELECT * FROM tb_receive WHERE requestid =".$vars['requestid']." AND dgresult =1)";
	//echo $sql;
	$rs = mysql_query($sql, $conn);
	if (!$rs) die ('エラー: ' . mysql_error());
	$row = mysql_fetch_array($rs) ;

	if($row){	//依頼完了しているとき
		$kakutei=2;
	}else{	//依頼完了してないとき
		//スケジュールが確定されているか
		$sql = "SELECT * FROM tb_receive WHERE requestid=".$vars['requestid']." AND NOT EXISTS (SELECT * FROM tb_receive WHERE requestid =".$vars['requestid']." AND dgresult =1)";
		//echo $sql;
		$rs = mysql_query($sql, $conn);
		if (!$rs) die ('エラー: ' . mysql_error());
		$row = mysql_fetch_array($rs) ;
		//var_dump($row);
		$kakutei = $row ? 1 : 0 ;	//確定してれば1、してなければ0
	}
	if($kakutei==2){
		$act='';
		$title='依頼完了';
		$msg='この依頼は終了しています。';
	}else if($kakutei==1){
		$act='reqcomp.php';	//依頼確定+ポイント配布へ
		$title='依頼完了';
		$msg='作業が完了したら、達成者を選び依頼完了を押してください。<br>';
	}else{
		$act='schedule_fix.php';	//スケジュール確定へ
		$title='スケジュール決定';
		$msg='希望する受注者を選び、チェックボックスにチェックを入れボタンを押してください。';
	}
	if($detail['category']==1 && $user!=NULL && $unrec!=1){
		?>

		<div class="panel panel-danger">
			<div class="panel-heading">
				<?php echo $title;?>
			</div>
			<div class="panel-body">

			<?php if($user==$row['userid']){	//ログインユーザ=依頼者
				echo $msg;?>
				<form action="<?php echo $act;?>" method="post">
					<input type="hidden" name="requestid"
					value="<?php echo $vars['requestid'];?>"> <input type="hidden"
					name="requserid" value="<?php echo $detail['requserid'];?>"> <input
					type="hidden" name="category"
					value="<?php echo $detail['category'];?>"> <input type="hidden"
					name="kakutei" value="<?php echo $kakutei;?>">
					<?php
					if($kakutei!=2){
						$sql = 'SELECT *
						FROM tb_schedule
						WHERE requestid='.$vars['requestid'].'
ORDER BY tb_schedule.stime';	//検索条件を適用したSQL文を作成
$rs = mysql_query($sql, $conn);
if (!$rs) die ('エラー: ' . mysql_error());
$row = mysql_fetch_array($rs) ;

while($row){
	$stime=substr($row['stime'],0,16);
	$etime=substr($row['etime'],0,16);
	echo'<div>';
	echo '<label>'.$stime.' ～ '.$etime.'</label><br>';
	?>
	<?php
								//echo $row['requestid'].'<br>';
								//echo $row['optid'].'<br>';
	if($kakutei==2){
		$s='';
	}else if($kakutei==1){
		$s = 'SELECT * FROM tb_receive NATURAL JOIN tb_user WHERE requestid='.$vars['requestid'].' AND optid='.$row['optid'];
	}else{
		$s = 'SELECT * FROM tb_schedule s
		NATURAL JOIN tb_adjustskd a
		NATURAL JOIN tb_user u
		WHERE s.requestid = '.$row['requestid'].'
		AND s.optid = '.$row['optid'].'
		AND a.receiverid = u.userid
		AND a.possibility =1
		ORDER BY s.stime, u.userid';
	}
								$sql2 = $s;	//検索条件を適用したSQL文を作成
								$rs2 = mysql_query($sql2, $conn);
								if (!$rs2) die ('エラー: ' . mysql_error());
								$row2 = mysql_fetch_array($rs2) ;

								while($row2){?>

								<label class="checkbox-inline"> <?php if($kakutei==1){
									$user=$row2['userid'];
								}else{
									$user=$row2['receiverid'];
								}?> <input type="checkbox"
								name="skd[<?php echo $row['optid'];?>][<?php echo $user;?>]"
								value="<?php echo $row['optid'];?>"> <?php echo $row2['uname'];?>
							</label>

							<?php
							$row2 = mysql_fetch_array($rs2) ;
						}
						echo '</div>';
						$row = mysql_fetch_array($rs) ;
					}
				}
				?>
				<br>
				<?php
				if($kakutei==2){
				}else if($kakutei==1){
					echo '<button type="submit" class="btn btn-danger btn-lg btn-block">
					<b>依頼完了</b><br>報酬を支払う
				</button>';
			}else{
				echo '<button type="submit" class="btn btn-danger btn-lg btn-block">
				スケジュール確定
			</button>';
		}
		?>


	</form>
				<?php }else{	//ログインユーザ≠依頼者
					$sql = "SELECT * FROM tb_receive WHERE requestid=".$vars['requestid']." AND userid='".$user."'";	//決定状況の検索
					$rs = mysql_query($sql, $conn);
					if (!$rs) die ('エラー: ' . mysql_error());
					$row = mysql_fetch_array($rs) ;
					if($row){

						echo '<span style="background-color:yellow;">日程が確定されました。<br>時間厳守で作業を行ってください。</span><br>';
						while($row){
							$rday=substr($row['rday'],0,16);
							$eday=substr($row['eday'],0,16);
							echo '<label>'.$rday.' ～ '.$eday.'</label><br>';
							$row = mysql_fetch_array($rs) ;
						}
					}else{
						echo '日程が確定されていせん。<br>依頼者がユーザおよび日程を確定するまで少々お持ちください。<br><span style="color: red;"><br>依頼者がユーザ選択権を持つため、必ずしも依頼申請されるわけではありません。</span><br>';
					}
				}?>
			</div>
		</div>

		<?php }
		$sql = "SELECT * FROM tb_user WHERE '".$user."'";
		$rs = mysql_query($sql, $conn);
		if (!$rs) die ('エラー: ' . mysql_error());
		$row = mysql_fetch_array($rs) ;?>


		<?php include('user_data.php'); ?>


		<!--
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
	-->




	<?php include('page_footer.php');?>
	<?php
	function button($reqid,$d,$c){
		if($d=='yetlogin'){
			$disabled='disabled';
			$str='受注するためにはログインが必要です';
			$act='';
		}else if($d=='unauth'){
			$disabled = 'disabled';
			$str = '利用権限がありません。';
			$act = '';
		}else if($d=='already'){
			$disabled='disabled';
			$str='受注済み';
			$act='';
		}else if($d == 'notstart'){
			$disabled = 'disabled';
			$str = '募集開始前です';
			$act = '';
		}else if($d == 'ended'){
			$disabled = 'disabled';
			$str = '募集を締め切りました';
			$act = '';
		}else{
			$disabled='abled';
			$str='受注';
			if($c=='p'){
				$c=1;
				$act='recconfirm.php';
			}else{
				$c=2;
				$act='recconfirm_save.php';
			}
		}
		echo'<div class="col-sm-offset-2 col-sm-8">
		<a href="'.$act.'?requestid='.$reqid.'&category='.$c.'">
			<button type="submit" class="btn btn-danger btn-lg btn-block" '.$disabled.'>'.$str.'</button>
		</a>
	</div>';
}?>