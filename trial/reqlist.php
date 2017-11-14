<?php
include('page_header.php');
require_once('db_inc.php');  //データベース接続

$userid = $_SESSION['userid'];
echo '<h2>依頼一覧</h2>';

date_default_timezone_set('Asia/Tokyo');
$now = date('Y-m-d H:i:s');



$where = " where req.requserid='{$userid}'";
echo $sql = "SELECT req.*, rep.kind, rep.reason, COUNT(rec.requestid) as count FROM tb_request req LEFT JOIN tb_receive rec ON req.requserid=rec.userid LEFT JOIN tb_report rep ON req.requestid=rep.requestid ". $where ." GROUP BY req.requestid";//検索条件を適用するSQL文を作成
$rs = mysql_query($sql, $conn);
$row = mysql_fetch_array($rs);
if (!$rs) die ('エラー: ' . mysql_error());
if(!$row){
	echo '<div class="warn">受注履歴がありません。</div>';
}else{
?>
	<table class="table table-striped table-hover">
		<tr><th>依頼番号</th><th>依頼名</th><th>募集開始</th><th>募集締切</th><th>ポイント</th>
			<th>応募人数</th><th>状態</th><th>採択</th><th></th></tr>
			<?php
			while ( $row ) {
				//var_dump($row);
				echo '<tr>';
				$rid = $row['requestid'];
				echo '<td>' . $row['requestid'] . '</td>';
				echo '<td><a href="detail.php?requestid='.$row['requestid'].'">' . $row['rname'] . '</a></td>';
				echo '<td>' . date('Y/n/j H:i', strtotime($row['sdate'])) . '</td>';
				echo '<td>' . date('Y/n/j H:i', strtotime($row['edate'])) . '</td>';
				echo '<td>' . $row['point']   . '</td>';
				echo '<td>' ;
				echo isset($row['count']) ? $row['count'] : 0;
				echo  '</td>';

				if($row['state'] == -1){	//違反報告により削除
					//違反種別
					$k = array(
						0 => '不適切な単語を有する依頼',
						1 => '悪質なリンク',
						2 => '個人情報の掲載',
						3 => '直接取引が危惧される依頼',
						4 => '公序良俗、法令に反する依頼',
						5 => '依頼になっていない依頼',
						6 => 'その他（下記の違反理由で詳細に）'
						);



					if($row['kind']!=NULL){
						$exp = '違反理由：';
						$exp .= $k[$row['kind']]."\n";
						if(!$row['reason']==''){
							$exp .= '詳細：';
							$exp .= $row['reason'];
						}
					}else{
						$exp = '';
					}

					//echo $exp;
					$color = 'class="red"';
					$state = '<a href="#" class="exp" title="'.$exp.'" >管理者により削除されました。</a>';
					$saitaku = '<td><del>採択</del></td>';
				}else if($row['state'] == 0){	//フィルタリング不合格
					$color = 'class="red"';
					$state = '非公開（フィルタリング不合格）';
					$saitaku = '<td></td>';
				}else if($row['state'] == 1){	//承認中
					$color = '';
					$state = '承認中';
					$saitaku = '<td></td>';
				}else if($row['state'] == 2){	//公開中
					$color = '';
					if($now<$row['sdate']){
						$state = '募集開始前';
					}else if($row['sdate']<$now && $now<$row['edate']){
						$state = '募集中';
					}else{
						$state = '募集終了';
					}
					$saitaku = '<td><a href="delist.php?rid=' . $row['requestid'] . '">採択</a></td>';
				}else{	//採択済み
					$color = 'class="green"';
					$state = '募集終了';
					$saitaku = '<td>採択済み</td>';
				}

				echo '<td '.$color.'>' . $state .'</td>';
				echo $saitaku;
				echo '</tr>';

				$row = mysql_fetch_array($rs);
			}
}
?>
</table>

<?php include('page_footer.php'); ?>