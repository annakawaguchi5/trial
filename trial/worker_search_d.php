<!-- SQL発動 worker_search.phpの入力データを表示 -->
<!-- form groupは追々まとめる -->
<div class="container">
	<h2>デジタルワーク登録画面</h2>
	<form action="worker_search_decide.php" class="form-horizontal"
	method="post">
	<?php foreach($vars as $n => $v){
		echo '<input type="hidden" name="'.$n.'" value="'.$v.'">';
	}?>
	<div class="form-group">
	<label for="contents" class="control-label col-sm-2">募集開始日：</label>
		<div class="col-sm-10">
			<!-- <input type="text" name="" class="form-control" id="datepicker"> -->
			<div class="input-group">
				<input type="text" class="form-control date" name="sdate" id="sdate" /> <span
				class="input-group-addon"><span
				class="glyphicon glyphicon-calendar"></span> </span>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="contents" class="control-label col-sm-2">募集締切日：</label>
		<div class="col-sm-10">
			<!-- <input type="text" name="" class="form-control" id="datepicker"> -->
			<div class="input-group">
				<input type="text" class="form-control date" name="edate" id="edate" /> <span
				class="input-group-addon"><span
				class="glyphicon glyphicon-calendar"></span> </span>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="contents" class="control-label col-sm-2">報酬：</label>
		<div class="col-sm-10">
			<input type="text" name="point" class="form-control" id="point">
		</div>
	</div>
	<div class="form-group">
		<label for="contents" class="control-label col-sm-2">達成予定人数：</label>
		<div class="col-sm-10">
			<input type="text" name="perficient" class="form-control" id="perficient">
		</div>
	</div>
	<div class="form-group">
		<label for="point" class="control-label col-sm-2">ポイント分配方法:</label>
		<div class="col-sm-10">
			<select name="amethod" class="form-control" id="amethod">
				<option value="1">分配</option>

				<option value="2">全額</option>

				<option value="3">順位付け配布</option>

			</select>
		</div>
	</div>



	<button class="col-xs-offset-2 btn btn-danger" type="submit" onclick="return CheckFormD();">登録</button>
	<button class="btn btn-default" type="reset">取消</button>

</form>
</div>