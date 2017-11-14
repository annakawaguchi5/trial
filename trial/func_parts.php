<?php
function DeptResp($d,$conn){
	$sql = "SELECT * FROM tb_department WHERE did = '{$d}'";
	$rs = mysql_query($sql, $conn);
	if (!$rs) die ('エラー: ' . mysql_error());
	$row = mysql_fetch_array($rs);

	return $row['dname'];
}
?>
