<?php
include('page_header.php');
include('db_inc.php');
$userid = $_SESSION['userid'];
var_dump($_POST);

/* コメント挿入, タイムスタンプ更新 */
if (isset($_POST['rid'])){
	$rid    = $_POST['rid'];
	$contents    = $_POST['contents'];
	$sql = "UPDATE tb_receive SET comment = '{$contents}' ,eday = CURRENT_TIMESTAMP WHERE requestid = $rid and userid = '{$userid}'";
	$rs = mysql_query($sql, $conn); //SQL文を実行
	//echo $sql;


	/* ファイルアップロード */
		$tempfile = $_FILES['upfile']['tmp_name'];

		if (is_uploaded_file($tempfile)) {
			$filename = $_FILES['upfile']['name'];

			//最新のファイルIDを調べる
			$sql = "SELECT MAX(fileid) AS fileid FROM tb_receive";	//納品用
			$rs = mysql_query($sql, $conn); //SQL文を実行
			if (!$rs) die ('エラー: ' . mysql_error());
			$row = mysql_fetch_array($rs);
			//echo $sql;

			$num = $row['fileid']+1;	//ID取得
			$id = pathinfo($filename, PATHINFO_EXTENSION);	//拡張子取得

			$filename = './upfile/' . $num . '.' . $id;	//ファイルアドレス
			$sql = "UPDATE tb_receive SET fileid = $num, mime = '{$id}' WHERE requestid = $rid and userid = '{$userid}'";

			//IDをDBへ登録
			$rs = mysql_query($sql, $conn); //SQL文を実行

			if ( move_uploaded_file($tempfile , $filename )) {
				echo "ファイルをアップロードしました。";
			} else {
				echo "ファイルをアップロードできません。";
			}
		}
}

include('page_footer.php');?>