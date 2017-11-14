<?php
//ファイル名：check.php
$c = $_POST['category'] ;  //カテゴリーを得る

if ($c){
	session_start();
	$_SESSION['rname']   = $row['rname'];
	$_SESSION['contents'] = $row['contents'];
	$_SESSION['category'] = $row['category'];

	switch($c){
		case 1:
			$url = 'worker_search_f.php';           //転送先のURL
			break;
		case 2:
			$url = 'worker_search_d.php';
			break;
	}
	header('Location:' . $url);   // 画面転送
}else{
	header('Location:worker_search.php');
	echo '入力に不備があります。やり直して下さい。';
}
include('page_footer.php');//ページフッタを出力
?>