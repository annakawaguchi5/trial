<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>CanvasJSサンプル</title>
	</head>
	<body>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
		<canvas id="myChart"></canvas>
		<?php
			$array = array(33, 11, 22);

			//配列をJavaScriptに渡すために一度jsonに変換
			$jsonTest=json_encode($array);
		?>

		<script type="text/javascript">
		//JSON.parseを使って配列を受け取る
		var test=JSON.parse('<?php echo $jsonTest; ?>');

		console.log(test);

		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'pie',
			data: {
				labels: ["M", "T", "W"],
				datasets: [{
					backgroundColor: [
					"#2ecc71",
					"#3498db",
					"#95a5a6"
					],
					//data: [55, 11, 22]
					data:test	//ここの処理
				}]
			}
		});
		</script>
	</body>
</html>