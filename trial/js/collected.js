//違反報告
function OpenWindow(reqid,uid) {
	var reqid = reqid;
	var uid = uid;
	//document.write(uid);
	//alert(uid);
	var url = "report.php?requestid="+reqid+"&userid="+uid;
	console.log(url);
	window.open(url,"window1","width=600,height=800,scrollbars=1,location=yes");
}

//ユーザ評価
function OpenWindow2(requserid) {
	var requserid = requserid;
	//document.write(uid);
	//alert(requserid);
	var url = "measure.php?requserid="+requserid;
	console.log(url);
	window.open(url,"window1","width=600,height=800,scrollbars=1,location=yes");
}

//利用権限修正
function OpenWindow3(userid, auth) {
	var userid = userid;
	var auth = auth;
	//document.write(uid);
	//alert(requserid);
	var url = "authupdate.php?userid="+userid+"&auth="+auth;
	console.log(url);
	window.open(url,"window1","width=600,height=800,scrollbars=1,location=yes");
}

//プロフィール写真アップロード
function OpenWindow4(userid) {
	var userid = userid;
	//document.write(uid);
	//alert(requserid);
	var url = "upimg.php?userid="+userid;
	console.log(url);
	window.open(url,"window1","width=600,height=400,scrollbars=1,location=yes");
}

//ユーザ追加・修正空欄チェック
function CheckFormU(){
	var str = new String(); //アラート用
	var p1 = document.getElementById('pass1').value;
	var p2 = document.getElementById('pass2').value;

	if(!(document.getElementById('uid').value)){
		str += 'ユーザIDを入力してください。\n';
	}
	if(!(document.getElementById('pass1').value) || !(document.getElementById('pass2').value)){
		str += 'パスワードを入力してください。\n';
	}
	if(!(document.getElementById('uname').value)){
		str += '氏名を入力してください。\n';
	}
	if(!(document.users.gender[0].checked) && !(document.users.gender[1].checked) && !(document.users.gender[2].checked)){
		str += '性別を選択してください。\n';
	}
	if(!(document.getElementById('year').value) || !(document.getElementById('month').value) || !(document.getElementById('day').value)){
		str += '生年月日を入力してください。\n';
	}
	if(!(document.getElementById('tel').value)){
		str += '電話番号を入力してください。\n';
	}
	if(!(document.getElementById('email').value)){
		str += 'メールアドレスを入力してください。\n';
	}
	if(!(document.users.urole[0].checked) && !(document.users.urole[1].checked) && !(document.users.urole[2].checked)){
		str += '種別を選択してください。\n';
	}

	if(str == ''){
		if(p1 ===p2){
			return true;
		}else{
			alert('パスワードが一致しませんでした。\n入力しなおしてください。');
			return false;
		}
	}else{
		alert(str);
		return false;
	}
}


//依頼登録空欄チェック
function CheckForm1(){
	var str = new String(); //アラート用
	if(!(document.getElementById('rname').value)){
		str += '依頼名を入力してください。\n';
	}
	if(!(document.getElementById('contents').value)){
		str += '依頼内容を入力してください。\n';
	}
	if(!(document.form1.category[0].checked) && !(document.form1.category[1].checked)){
		str += 'カテゴリを選択してください。\n';
	}
	if(str == ''){
		return true;
	}else{
		alert(str);
		return false;
	}
}

//詳細フォーム空欄チェック
function CheckFormD(){
	var str = new String(); //アラート用
	if(!(document.getElementById('sdate').value)){
		str += '募集開始時刻を入力してください。\n';
	}
	if(!(document.getElementById('edate').value)){
		str += '募集終了時刻を入力してください。\n';
	}
	if(!(document.getElementById('point').value)){
		str += '報酬を入力してください。\n';
	}
	if(!(document.getElementById('perficient').value)){
		str += '達成予定人数を入力してください。\n';
	}
	if(str == ''){
		return true;
	}else{
		alert(str);
		return false;
	}
}

function CheckFormS(){
	var str = new String();
	if(!(document.getElementById('date').value)){
		str += '日程候補日時を入力してください。';
	}
	if(str == ''){
		return true;
	}else{
		alert(str);
		return false;
	}
}


//募集締め切りなど
$(function () {
	$('.date').datetimepicker({
		locale: 'ja',
		format : 'YYYY-MM-DD HH:mm'
	});

	$('.birth').datetimepicker({
		locale: 'ja',
		format : 'YYYY年MM月DD日'
	});
});





//日程調整用
$(function () {
	$("#datepicker").datepicker({
		dateFormat: 'yy/m/d(DD)',
		yearSuffix: '年',
		showMonthAfterYear: true,
		monthNames: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
		dayNames: ['日', '月', '火', '水', '木', '金', '土'],
		dayNamesMin: ['日', '月', '火', '水', '木', '金', '土'],
	minDate: new Date(),//new Date()
	maxDate: '+12m',
	hideIfNoPrevNext: true,
	// 日付が選択された時、日付をテキストフィールドへセット
	onSelect: function (dateText, inst) {
		var nowText = $(".date_val").val();

		if (nowText === "") {
			$(".date_val").val(dateText + " 00:00～" + dateText +" 23:00");
		}
		else {
			$(".date_val").val(nowText + "\n" + dateText + " 00:00～" + dateText +" 23:00");
		}
	}
});
});

//吹き出し
$(function() {
	$(".exp").balloon();
});


