	<div class="col-xs-4">
	<?php
	if($user==$vars['userid'])$unrec=0;	//依頼人がスケジュール見れるように

	//ワーク完了者がいるかどうか
	$sql = "SELECT * FROM tb_receive WHERE requestid=".$vars['requestid']." AND EXISTS (SELECT * FROM tb_receive WHERE requestid =".$vars['requestid']." AND dgresult =1)";
	//echo $sql;
	$rs = mysql_query($sql, $conn);
	if (!$rs) die ('エラー: ' . mysql_error());
	$row = mysql_fetch_array($rs) ;

	if($row){	//ワーク完了しているとき
		$kakutei=2;
	}else{	//ワーク完了してないとき
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
		$title='ワーク完了';
		$msg='このワークは終了しています。';
	}else if($kakutei==1){
		$act='reqcomp.php';	//ワーク確定+ポイント配布へ
		$title='ワーク完了';
		$msg='作業が完了したら、達成者を選びワーク完了を押してください。<br>';
	}else{
		$act='schedule_fix.php';	//スケジュール確定へ
		$title='スケジュール決定';
		$msg='希望する受注者を選び、チェックボックスにチェックを入れボタンを押してください。';
	}
	if($detail['category']==1 && $user!=NULL && $unrec!=1){
		?>

		<div class="panel panel-success">
			<div class="panel-heading">
			<?php echo $title;?>
			</div>
			<div class="panel-body">

			<?php if($user==$vars['userid']){	//ログインユーザ=依頼者
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
					<b>ワーク完了</b><br>報酬を支払う
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
						echo '日程が確定されていせん。<br>依頼者が確定するまで少々お持ちください。<br><span style="color: red;"><br>依頼者がユーザ選択権を持つため、必ずしも確定されるわけではありません。</span><br>';
					}
				}?>
			</div>
		</div>

		<?php }?>
	</div>