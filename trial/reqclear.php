<?php
  include('page_header.php');
  include 'db_inc.php';

  $vars = array_merge($_POST, $_GET);
var_dump($vars);

  $rid = $_GET["rid"];
  $sql = "SELECT * FROM  tb_request NATURAL JOIN tb_receive WHERE requestid=" . $rid;
  $rs = mysql_query($sql, $conn);
  if (!$rs) die ('エラー: ' . mysql_error());
  $row = mysql_fetch_array($rs);
  $point = $row['point'];

?>

<h2>依頼名:</h2>
<a href="detail.php?requestid=<?php echo $rid;?>" class="div"><?php echo $row['rname']?></a><br><br>
<form action="reqclear_save.php" method="post">
<input type="hidden" name="rid" value="<?php echo $rid; ?>">
<input type="hidden" name="point" value="<?php echo $point; ?>">
<h3>達成者選択</h3>
<table class="table table-hover">
  <tr><td>受注者</td><?php if($row['category']==2){echo'<td>納品ファイル</td><td>コメント</td><td>更新時間</td>';}?><td>達成者</td><td>評価</td></tr>
<?php
   while ( $row ) {
  	echo '<tr>';
  	$rid = $row['requestid'];
  	echo '<td>' . $row['userid'] . '</td>';
  	if($row['category']==2){echo '<td>  </td>';
  	echo '<td>' . $row['comment'] . '</td>';
    echo '<td>' . $row['updatetime'] . '</td>';}
  	echo '<td><input type="checkbox" name="q[]" value="'. $row['userid']. '"> </td>';
    echo '<td><button type="button"  name="measure[\''.$row['userid'].'\']"　id="sampleButtonStateful1" class="btn btn-success" data-loading-text="○" autocomplete="off">
    <img src="./img/gd.png">
  </button><button type="button"  name="measure[\''.$row['userid'].'\']"　id="sampleButtonStateful2" class="btn btn-danger" data-loading-text="×" autocomplete="off">
    <img src="./img/bad.png">
  </button></td>';

  	$row = mysql_fetch_array($rs);
  }
?>
</table>
<p><input type="submit" class="btn btn-success btn-lg center-block" value="決定"></p>
</form>

<?php include('page_footer.php'); ?>