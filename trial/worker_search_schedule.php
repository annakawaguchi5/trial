<?php
include('page_header.php');  //画面出力開始
require_once('db_inc.php');  //データベース接続


$vars = array_merge($_POST, $_GET);

?>
<?php $url='"worker_search_decide.php"';?>
<h2>日程候補登録</h2>
<div class="container-fluid bg-info">
	<form action=<?php echo $url;?> class="form-horizontal"	method="post" >
		<div class="form-group">
		<?php
			foreach($vars as $n => $d){
				echo '<input type="hidden" name="'.$n.'" value="'.$d.'">';
			}?>
		</div>
		<div class="form-group">
			<div class="col-xs-offset-1">
				<label class="text-left">希望する日時を選択してください。※候補の区切りは改行で判断されます。<br>～手順～<br>１．カレンダーの日付をクリック<br>２．時間の調整
				</label>
			</div>
			<!-- <input type="text" name="" class="form-control" id="datepicker"> -->

				<div class="col-xs-offset-1 col-sm-2">
					<div id="datepicker"></div>
				</div>
				<div class="col-sm-7 col-xs-offset-1">
					<textarea rows="10" id="date" class="date_val form-control"
						placeholder="例）2017/1/1(月) 9:00～12:00" name="date" id="date"></textarea>
				</div>

		</div>
		<div class="col-sm-offset-2 col-sm-8">
			<button type="submit" class="btn btn-danger btn-lg btn-block" onclick="return CheckFormS();">登 録</button>
		</div>
	</form>
</div>

		<?php include('page_footer.php');?>