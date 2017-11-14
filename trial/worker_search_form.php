<?php
include('page_header.php');  //画面出力開始
require_once('db_inc.php');  //データベース接続

$vars = array_merge($_POST, $_GET);
//var_dump($vars);
$reqid = 0;
$userid = $_SESSION['userid'];


?>

<?php
if(!isset($vars)){
	echo 'エラーが発生しました。操作をやり直して下さい。';
}else{
	//$sql = "INSERT INTO tb_request VALUES ($reqid,'".$vars['rname']."','0000-00-00 00:00:00','0000-00-00 00:00:00','".$vars['contents']."',-1,-1,-1,-1,'".$requserid."',-1,NULL,".$vars['category'].")";
	//echo $sql;
	//$rs = mysql_query($sql, $conn);
	//if (!$rs) die ('エラー: ' . mysql_error());

	if($vars['category']==1){
		include('worker_search_p.php');
	}else{
		include('worker_search_d.php');
	}
}
?>

<?php
include('page_footer.php');
?>
