	<div class="chart">
		<canvas id="myChart"></canvas>

		<?php
		echo '<p>'.percent($mydata['goodnum'], $mydata['evalnum']).'</p>';

		function percent($g, $e){
			if($e == 0){
				$str = '評価データなし';
			}else{
				$p = round($g/$e*100);
				$str = $p .'%';
			}
			return $str;
		}

		$array = array((INT)$mydata['goodnum'], $mydata['evalnum']-$mydata['goodnum']);

		if($array[0] != 0 || $array[1] != 0){		//評価データがある時
			$color = array("#ff3366","#3498db");
		}else{
			//$array =array(1,1);
			$color = array("#CDB1AF","#b5c3c9");
		}




		//配列をJavaScriptに渡すために一度jsonに変換
		$num=json_encode($array);
		$color=json_encode($color);
		?>

		<script type="text/javascript">
		//JSON.parseを使って配列を受け取る
		var d = JSON.parse('<?php echo $num;?>');
		var c = JSON.parse('<?php echo $color;?>');
		var nodata = 0;

		if(d[0] == 0 || d[1] ==0){
			d=[1,1];
			var nodata = 1;
		}

		console.log(d);
		console.log(c);

		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'doughnut',
			data: {
				labels: ["Good", "Bad"],
				datasets: [{
					backgroundColor: c,
					//backgroundColor: ["#ff3366","#3498db"],
					//data: [55, 11, 22]
					data:d	//ここの処理
				}]
			},
			options: {
				title: {                           //タイトル設定
                display: true,                 //表示設定
                fontSize: 22,                  //フォントサイズ
                text: '他ユーザからの評価'                //ラベル
            },
            tooltips: {
            	callbacks: {
            		label: function (tooltipItem, data) {
            			if(nodata == 0){
            				return data.labels[tooltipItem.index]
            				+ ": "
            				+ data.datasets[0].data[tooltipItem.index]
	              				+ " 件"; //ここで単位を付けます
	              			}else{
	              				return data.labels[tooltipItem.index]
	              				+ ": "
	              				+ '0件';
	              			}
	              		}
	              	}
	              }
	          }
	      });
	  </script>
	</div>

