//jQueryを利用してカスタムデータ属性にアクセス
var $script = $('#script');
var test = JSON.parse($script.attr('data-json-test'));

for (var i = 0; i < test.length; i++) {

alert(test[i]);

}

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ["M", "T", "W", "T", "F", "S", "S"],
    datasets: [{
      backgroundColor: [
        "#2ecc71",
        "#3498db",
        "#95a5a6",
        "#9b59b6",
        "#f1c40f",
        "#e74c3c",
        "#34495e"
      ],
      data: test
    }]
  }
});