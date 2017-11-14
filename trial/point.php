<?php
include('page_header.php');
require_once('db_inc.php');  //データベース接続

if (isset($_GET['uid'])){
	$userid = $_GET['uid'];
}else{
	if(isset($_SESSION['userid'])){
		$userid=$_SESSION['userid'];
		$uname=$_SESSION['uname'];
	}
}
echo "<h2>ポイント履歴</h2>";
$sql = "SELECT * FROM tb_point natural join tb_user  WHERE userid ='{$userid}' ";
$rs = mysql_query($sql, $conn);
if (!$rs) die ('エラー: ' . mysql_error());
$total =0;
echo '<table  class="table table-striped table-hover">';
echo '<tr><th class="number">更新日時</th><th>詳細</th><th>更新分のポイント</th>';
while ( $row = mysql_fetch_array($rs) ) {
	echo '<tr>';
	echo '<td>' . $row['daytime'] . '</td>';
	echo '<td>' . $row['detail'] . '</td>';
	echo '<td>' . $row['pchange'] . '</td>';
	$total +=  $row['pchange'];
	//echo '<td>' . $row[''] . '</td>';
	//echo '<td>' . $row['eday']   . '</td>';
	//echo '<td>' . $row['perpicient']   . '</td>';
	echo '</tr>';
}
echo '</table>';
echo 'ポイント残高: '.$total;

include('page_footer.php');
?>