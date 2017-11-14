	<?php
	include('page_header.php');  //画面出力開始
	require_once('db_inc.php');  //データベース接続

	if (!isset($_SESSION['userid'])){
		echo '<div class="text-danger">このサービスを利用するためにログインする必要があります</div>';
		include('page_footer.php');
		exit;
	}?>

	<?php
	$vars = array_merge($_POST, $_GET);
	//var_dump($vars);
	$requestid=0;
	$requserid=$_SESSION['userid'];

	if(!isset($vars)){
		echo 'エラーが発生しました。操作をやり直して下さい。';
	}else{
		//依頼詳細の改行処理
		$vars['contents'] = nl2br($vars['contents']);

		//報酬計算
		if($vars['amethod']==1 || $vars['amethod']==3){	//分配orユーザ指定
			$rpoint=$vars['point']/$vars['perficient'];
		}else{	//全配
			$rpoint=$vars['point'];
		}

		//フィルタリング
		include('StringConverter.php');
		//echo $judge.','.$msg;
		$state = array('fail'=>'不合格','unknown'=>'承認待ち','pass'=>'合格');
		$str = '判定：'.$state[$judge].'<br>';
		$str .= '疑念ワード数：'.$cnt.' 個<br>';
		$str .= '含有率：'.round($percent).' %<br>';
		$str .= $msg.'<br>';
		$str .= '<a href="reqlist.php">依頼一覧</a>で確認する。';

		if($judge == 'pass'){	//フィルタリング合格
			$state = 2;	//公開
		}else if($judge == 'unknown'){	//承認
			$state = 1;	//非公開（承認依頼）
		}else{
			$state = 0;	//非公開
		}

			//第三者
		if(isset($vars['outsider'])&&$vars['outsider']==1){
			$outsider = "outsider='".$vars['outsider']."'";
		}else{
			$outsider = "NULL";
		}

		//DB登録
		if($vars['category']==1){	//physical
			/* 依頼登録 */


			//依頼登録
			$sql = "INSERT INTO tb_request VALUES (".$requestid.",'".$vars['rname']."','".$vars['sdate'].":00','".$vars['edate'].":00','".$vars['contents']."',".$vars['point'].",".$state.",".$vars['perficient'].",".$vars['amethod'].",'".$requserid."',".$rpoint.",".$outsider.",".$vars['category'].")";
			echo $sql.'<br>';
			$rs = mysql_query($sql, $conn);
			if (!$rs) die ('エラー: ' . mysql_error());
			$requestid = mysql_insert_id();

			/* スケジュール登録 */
			/* 配列化 */
			//改行コードを含む文字列
			$date = $vars['date'];
			//改行コードを置換してLF改行コードに統一
			$date = str_replace(array('\r\n','\r','\n'), '\n', $date);
			//LF改行コードで配列に格納
			$buf = explode("\n", $date);

			//var_dump($buf);

			/* DB用へ文字列変換 */
			foreach($buf as $n => $d){

				$trans = array("/" => "-", "&nbsp;" =>"");
				$d = strtr($d, $trans);
				// 全角で書かれている場合半角に変換し、全角スペースを除去
				$d = trim(mb_convert_kana($d, 'as', 'UTF-8'));
				// 半角英数字以外の文字列は除去
				$d = preg_replace('/[^a-zA-Z0-9\s\/:～_-]/', '', $d);
				//$array[$n] = preg_replace(':', '', $d);
				$array[$n] = explode("～", $d);

				$sql = "INSERT INTO tb_schedule VALUES";
				foreach($array as $n => $time){
					if($time != '' && !empty($time)){
						$sql .="(0,".$requestid.", ".$n.", '".$time[0].":00', '".$time[1].":00'),";
					}
				}
				$sql = rtrim($sql, ",");
				//echo $sql."<br>";

			}
		}else{	//digital
			$sql = "INSERT INTO tb_request VALUES (".$requestid.",'".$vars['rname']."','".$vars['sdate'].":00','".$vars['edate'].":00','".$vars['contents']."',".$vars['point'].",".$state.",".$vars['perficient'].",".$vars['amethod'].",'".$requserid."',".$rpoint.",".$outsider.",".$vars['category'].")";
		}
		//echo $sql."<br>";
		$rs = mysql_query($sql, $conn);
		if (!$rs) die ('エラー: ' . mysql_error());
		//if($rs && $state==1) echo '登録しました。';

		if($rs){
			?>
<div class="container">
	<div class="warn">
	<?php echo $str;?>
	</div>
</div>

			<?php
		}
	}
	?>

	<?php include('page_footer.php');?>