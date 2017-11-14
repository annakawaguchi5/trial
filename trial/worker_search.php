<?php
include('page_header.php');  //画面出力開始
require_once('db_inc.php');  //データベース接続
echo "<h2>依頼登録画面</h2>";

$items = array('rname'=>'依頼名', 'contents'=>'依頼内容', 'category'=>'仕事カテゴリ');
$category = array(1=>'フィジカルワーク', 2=>'デジタルワーク');
?>



<!-- form groupは追々まとめる -->

<div class="container-fluid bg-info">
	<form action="worker_search_form.php" class="form-horizontal" method="post" name="form1">
		<div class="form-group">
			<label for="requestid" class="control-label col-sm-2">依頼名:</label>
			<div class="col-sm-8">
				<input type="text" name="rname" id="rname" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label for="contents" class="control-label col-sm-2">依頼内容：</label>
			<div class="col-sm-8">
				<textarea name="contents" id="contents" class="form-control"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="category" class="control-label col-sm-2">仕事カテゴリ:</label>
			<div class="col-sm-10">
				<div class="radio-inline">
					<input type="radio" name="category" id="category1" value="1">フィジカルワーク
				</div>
				<div class="radio-inline">
					<input type="radio" name="category" id="category2" value="2">デジタルワーク
				</div>
			</div>
		</div>


		<button class="col-xs-offset-2 btn btn-danger" type="submit" onclick="return CheckForm1();">次へ</button>
		<button class="btn btn-default" type="reset">取消</button>

	</form>
</div>

<?php
include('page_footer.php');
?>


