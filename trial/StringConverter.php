<?php
//worker_search_decide.php内に組込み
$NGRAM = 2;

$EXCLUDES = array("、", "。");

$sentence = $vars['rname'].$vars['contents'];



$result = array();

for($i = 0;$i <= (mb_strlen($sentence) - $NGRAM);$i++) {

    $parts = mb_substr($sentence, $i, $NGRAM);	//$sentenceの$i番目から$NGRAM文字分を代入

    $parts = strtolower($parts);



    $exists_exclude = false;

    foreach($EXCLUDES as $exclude) {

        $pos = mb_strpos($parts, $exclude);

        if($pos === 0) {

            $exists_exclude = true;

        } else if($pos !== false) {

            $parts = str_replace($exclude, " ", $parts);	//$EXCLUDESが含まれている場合、空文字変換

        }

    }

    if(!$exists_exclude) {

        $result[$i] = $parts;	//分割結果格納

    }

}


$counted_list = array();


foreach($result as $num => $word) {	//重複削除

    if(array_key_exists($word, $counted_list)) {
        $counted_list[$word][] = $num;	//既存

    } else {
        $counted_list[$word] = array($num);	//新規

    }

}

$length = count($counted_list);
$last_i  = key(array_slice($counted_list, -1, 1, true));	//連想配列における最後尾

$sql = "SELECT ngword FROM tb_ngword WHERE";//検索条件を適用したSQL文を作成
 foreach($counted_list as $word => $place){
 	if ($word === $last_i) { // 最後
 		$sql.=" ngword LIKE '%".$word."%'";
    }else{
 	  $sql.=" ngword LIKE '%".$word."%' OR";
    }
 	//echo $word;
}
//echo $sql;


$rs = mysql_query($sql, $conn);
if (!$rs) die ('エラー: ' . mysql_error());
$row = mysql_fetch_array($rs);
if(!$row){
    $cnt = 0;
    $percent = 0;
    $judge='pass';
    $msg='あなたの依頼は審査を通過しました。只今より、他のユーザへ公開されます。';
}else{
    while($row){
        $array[] = $row['ngword'];
        $row = mysql_fetch_array($rs);
    }

    //var_dump($array);

    $cnt = isset($array)? count($array) : 0;
    echo $percent = count($array)/$length;

    if( $percent>=0.08){
        $judge = 'fail';
        $msg = 'あなたの依頼文は不正依頼だと判定されたため、非公開化されました。/n再度依頼を行う場合は、「依頼履歴」より依頼文を編集してください。';
    }else if($cnt>3 ||$percent>=0.04){
        $judge = 'unknown';
        $msg = 'あなたの依頼文は不正が懸念されるため、管理者の確認が必要です。登録までしばしお待ちください。';
    }else{
        $judge = 'pass';
        $msg = 'あなたの依頼は審査を通過しました。只今より、他のユーザへ公開されます。';
    }
}
?>
