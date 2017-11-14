<?php
include('page_header.php');
include('db_inc.php');
var_dump($_GET);
$userid = $_GET['userid'];
$tempfile = isset($_FILES['upfile']['tmp_name'])? $_FILES['upfile']['tmp_name'] : false;

if(!$tempfile){
?>
<div class="container">

<h2>写真アップロード</h2>
<h4>アップロードする写真を選択してください。</h4>
<form action="#" method="post" enctype="multipart/form-data"  class="form-horizontal">
<input type="file" name="upfile"  accept="image/*" multiple size="30" />
<br>
<input class="btn btn-danger" type="submit" value="アップロード" />
<input class="btn btn-default" type="reset" value="取消"/>
</form>

<?php
}

/* コメント挿入, タイムスタンプ更新 */
if (is_uploaded_file($tempfile)) {//ファイルがある時
	$filename = $_FILES['upfile']['name'];
	$id = pathinfo($filename, PATHINFO_EXTENSION);	//拡張子取得

	$sql = "SELECT * FROM tb_image WHERE userid = '{$userid}'";	//登録してあるか
	$rs = mysql_query($sql, $conn); //SQL文を実行
	$row = mysql_fetch_array($rs);

	if(!$row){	//新規登録
		//最新のファイルIDを調べる
		$sql = "SELECT MAX(imgid) AS imgid FROM tb_image";
		$rs = mysql_query($sql, $conn); //SQL文を実行
		if (!$rs) die ('エラー: ' . mysql_error());
		$row = mysql_fetch_array($rs);
		//echo $sql;
		$num = $row['imgid']+1;	//ID取得
		$sql = "INSERT INTO tb_image VALUES ({$num},'{$userid}','{$id}',now())";
	}else{	//更新
		$num = $row['imgid'];
		$sql = "UPDATE tb_image SET imgid = $num, mime = '{$id}' WHERE userid = '{$userid}'";
	}
		$filename = './img/' . $userid . '.' . $id;


	//IDをDBへ登録
	$rs = mysql_query($sql, $conn); //SQL文を実行


	if ( move_uploaded_file($tempfile , $filename )) {
		echo "<h3>ファイルをアップロードしました。<br>このウィンドウを閉じて、マイページを更新してください。</h3>";
	} else {
		echo "<h3>ファイルをアップロードできません。<br>操作をやり直してください。</h3>";
	}
}
?>
</div>

<?php include('page_footer.php');?>