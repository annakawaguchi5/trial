<?php
//session_start();
include('page_header.php');
include 'menu1.php';
$requestid = -1 ;
if (isset($_POST['rid'])){
	$rid    = $_POST['rid'];
	$q  = $_POST['q'];
	$point    = $_POST['point'];
//	echo $rid;
//	print_r($q);
	include 'db_inc.php';
	$i = 1;
	foreach($q as $userid){
		$sql = "update tb_receive set dgresult=".$i . " where requestid=".$rid . " and userid='{$userid}'";
		$rs = mysql_query($sql, $conn); //SQL文を実行

		$pay_userid = $_SESSION['userid'];
		$sql ="insert into tb_point (pchange ,detail,userid) values(-$point, '支払い', '{$pay_userid}')";
		$rs = mysql_query($sql, $conn);

		$sql ="insert into tb_point (pchange ,detail,userid) values($point, '収入', '{$userid}')";
		$rs = mysql_query($sql, $conn);
		$i++;
	}
	$url = "delist.php";


	header('Location:' . $url);

}
?>