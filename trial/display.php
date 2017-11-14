<?php
include('page_header.php');
if(!isset($_SESSION['userid'])){
  die('エラー：この機能を利用する権限がありません');
}
?>
<img src="load.php" alt="" />
<?php
include('page_footer.php');
?>