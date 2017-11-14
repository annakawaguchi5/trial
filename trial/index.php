<?php
include('page_header.php');  //画面出力開始
require_once('db_inc.php');  //データベース接続

$c = array(0=>'', 1=>'フィジカルワーク', 2=>'デジタルワーク');

$page_num = isset($_GET['page']) ? $_GET['page'] : 0;
$page_num = max($page_num, 0);	//ページ番号
$limit = 20; //1ページ内の件数
?>

<div class="container">
	<div class="row">
<?php
	if(isset($_SESSION['auth']) && $_SESSION['auth'] == 0){
		echo '<div class="col-lg-12 warn">';
		echo 'このアカウントは管理者によって利用権限が停止されています。<br>あなたは本システムにおいて、【閲覧】のみ可能です。';
		echo '</div>';
	}
?>
		<!-- 4列をサイドメニューに割り当て -->
		<div class="col-xs-4">
			<div class="panel panel-info">
				<div class="panel-heading">検索・絞り込み</div>
				<div class="panel-body">
					<form action="" class="navbar-form" role="search" method="GET">
						<div class="form-group">
							<input type="text" class="form-control" name="sw" placeholder="検索キーワード">
							<button type="submit" class="btn btn-default">検索</button>
						</div>
					</form>
				</div>

				<div class="panel-heading">仕事ジャンル</div>
				<div class="list-group">
					<a class="list-group-item" href="index.php?category=1"><?php echo $c[1];?></a> <a
					class="list-group-item" href="index.php?category=2"><?php echo $c[2];?></a>
				</div>

			</div>
		</div>

		<!-- 残り8列はコンテンツ表示部分として使う -->
		<!-- SQLを追加/ループで使用-->
		<?php
		$sw = $disp = '';
		if(isset($_GET['sw'])){
			//正規表現により、空白を区切りに分割
			$searchword = $_GET['sw'];
			$regex = "/[\\x0-\x20\x7f\xc2\xa0\xe3\x80\x80]++/u";
			$list = preg_split($regex, $searchword, -1, PREG_SPLIT_NO_EMPTY) + [1 => ''];

			foreach ($list as $key => $value) {
				$sw .= " AND CONCAT(req.requestid, req.rname, req.sdate, req.edate, req.contents, req.requserid, req.rpoint) LIKE '%{$value}%' ";
				$disp .= '『' . $value .'』, ';
			}
			$disp = rtrim($disp, ', ');
		}

		$category = isset($_GET['category'])? " AND req.category = '".isset($_GET['category']) ."'" : "";
	//2. $cidを使ってSQL文のWHERE句を作成
		$where = " WHERE state=2 " . $sw . $category;
	//$sql = "select * from tb_request NATURAL JOIN tb_user ".$where;//検索条件を適用したSQL文を作成


		$sql = "SELECT * FROM tb_request req LEFT OUTER JOIN tb_user user ON user.userid = req.requserid ".$where." ORDER BY req.requestid DESC";
		//echo $sql;
//検索条件を適用したSQL文を作成
		$rs = mysql_query($sql, $conn);
		if (!$rs) die ('エラー: ' . mysql_error());
		$row = mysql_fetch_array($rs) ;
		$num = mysql_num_rows($rs);
		$now = time();

//ページ表示
		if($num > 10){
			$n=ceil($num/10);
		}else{
			$n=1;
		}

		$method=array(1=>'分配', 2=>'全額', 3=>'順位付け配布');
		?>


		<!-- 表示 -->
		<?php
		echo '<div class="col-xs-8">';
		if(isset($_GET['sw'])){
			echo '<h3>検索キーワード：' . $disp . '</h3>';
		}
		echo '<p style="text-align:right">'.$n."ページの中の".($page_num+1)."ページ目を表示</p>" ;
		echo '<p class="right">検索結果　'.$num.'件</p>';

		$sql = "SELECT * FROM tb_request req LEFT OUTER JOIN tb_user user ON user.userid = req.requserid ".$where." ORDER BY req.requestid DESC";
		$sql .= " LIMIT " . $page_num*10 . ", 10" ;
//検索条件を適用したSQL文を作成
//echo $sql;
		$rs = mysql_query($sql, $conn);
		if (!$rs) die ('エラー: ' . mysql_error());
		$row = mysql_fetch_array($rs) ;

		if($row){
	while($row){	//検索結果表示
		$category=$row['category'];
		//$remtime = $row['etime']-$now;
		?>
		<a href=detail.php?requestid=<?php echo $row['requestid'];?>&userid=<?php echo $row['requserid'];?>>
			<div class="panel panel-info">
				<div class="panel-heading">


					<div class="panel-title"><div><?php echo $row['rname'];?></div>
					<div style="text-align:right"><?php echo $row['requserid'];?></div></div>

				</div>
				<div class="panel-body">

					<?php $edate=substr($row['edate'],0,16);?>

					<div class="col-xs-3"><?php echo $c[$category];?></div>
					<div class="col-xs-3"><?php echo $row['point'];?>ポイント（<?php echo $method[$row['amethod']];?>）</div>
					<div class="col-xs-2"><?php echo $row['perficient'];?>人募集中</div>
					<div class="col-xs-4"><?php echo $edate?>締め切り</div>
				</div></div></a>

				<?php
				$row = mysql_fetch_array($rs) ;
			}

			?>

			<nav>
				<ul class="pagination">
					<?php
					if($page_num==0){
						$front='class="disabled"';
						$furl=$page_num;
					}else{
						$front='';
						$furl=$page_num-1;
					}

					if(($page_num+2)>$n){
						$behind='class="disabled"';
						$burl=$page_num;
					}else{
						$behind='';
						$burl=$page_num+1;
					}

//前のページ
					echo '<li '.$front.'><a href="index.php?page='.$furl.'" aria-label="前のページへ"><span aria-hidden="true">≪</span></a></li>';
					if($page_num !=0){
	//echo '<li><a href="'.($page_num-1).'" aria-label="前のページへ"><span aria-hidden="true">≪</span></a></li>';
						echo '<li><a href="index.php?page='.($page_num-1).'">'.$page_num.'</a></li>';
					}
//echo '<li><a href="" aria-label="前のページへ"><span aria-hidden="true">≪</span></a></li>';
//今のページ
					echo '<li class="active"><a href="index.php?page='.$page_num.'">'.($page_num+1).'</a></li>';
//次のページ
					for($i=2; $i<5; $i++){
						if(($page_num+$i)<=ceil($num/10)){
							echo '<li><a href="index.php?page='.($page_num+($i-1)).'">'.($page_num+$i).'</a></li>';
						}
					}
					echo '<li '.$behind.'>';
					echo '<a href="index.php?page='.$burl.'" aria-label="次のページへ">
					<span aria-hidden="true">≫</span>';
					?>
				</a>
			</li>
		</ul>
	</nav>
	<?php } ?>
</div>
</div>
</div>




<?php
include('page_footer.php');
?>