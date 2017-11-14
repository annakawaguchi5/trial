<?php
include('page_header.php');
include 'db_inc.php';
$userid = $_SESSION['userid'];
if (isset($_GET['rid'])){
	$rid = $_GET['rid'];
	$_GET['del'];
$sql = "SELECT * FROM  tb_request  WHERE requestid = {$rid}";//未納品の時
if(isset($_GET['del']) && $_GET['del']==1){	//納品済みの時
	$sql = "SELECT * FROM tb_request NATURAL JOIN tb_receive WHERE requestid = {$rid} AND userid = '{$userid}'";
}
$rs = mysql_query($sql, $conn);
if (!$rs) die ('エラー: ' . mysql_error());
//echo $sql;
$people = array();
$row = mysql_fetch_array($rs);
$rname  = $row['rname'];
$edate = $row['edate'];
$contents =$row['contents'];
$c = isset($row['comment'])? $row['comment'] : NULL;
$f = isset($row['fileid'])? $row['fileid'] : NULL;
if($f!=NULL)$filead = './upfile/'.$row['fileid'].'.'.$row['mime'];
?>

<h2>納品</h2>
<form action="upload.php" method="post" enctype="multipart/form-data">
	<table class="table table-striped table-hover">
		<tr><td>依頼名:</td><td><?php echo $rname;?></td></tr>
		<tr><td>締切日:</td><td><?php echo $edate;?></td></tr>
		<tr><td>依頼内容:</td><td><?php echo $contents;?></td></tr>
		<tr><td>納品内容:</td><td><textarea class="form-control" name="contents" cols=50 rows=4><?php echo $c; ?></textarea></td></tr>
		<tr><td>ファイル：</td><td>
			<?php
			if($f==NULL){
				echo '<input type="file" name="upfile" accept="image/*" multiple size="30" />';
			}else{
				echo '<a href="'.$filead.'">'.$filead.'</a>';
			}
			?>
		</td></tr>
	</table>
	<input type="hidden" name="rid" value="<?php echo $rid;?>">
	<input type="submit" value="納品" /><input type="reset" value="取消"/>
</form>

<?php
}else{
	echo '<div class="warn">依頼を表示できません。</div>';
}
include('page_footer.php');
?>