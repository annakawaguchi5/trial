<h1 id="siteTitle">
  <a href="index.php">学内クラウドソーシング</a>
</h1>

<nav class="navbar navbar-default">

  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed"
      data-toggle="collapse" data-target="#navbarEexample3">
      <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
      <span class="icon-bar"></span> <span class="icon-bar"></span>
    </button>
  </div>
  <div class="collapse navbar-collapse" id="navbarEexample3">

  <?php
  $menu1 = array(  //ワーカーメニュー
  '依頼一覧'  => 'index.php',
 '依頼登録'  => 'worker_search.php',
 '受注履歴' => 'reclist.php',
 '依頼履歴'  => 'reqlist.php' ,
 'ポイント履歴' => 'point.php'
);
  $menu2 = array(  //審査員メニュー
 '承認依頼一覧'  => 'judge_list.php' ,
 '違反判定依頼一覧' => 'ngreq.php'
);
$menu3 = array(  //管理者メニュー
 //'アカウント登録'  => 'user_add.php' ,
 'アカウント一覧'  => 'user_list.php' ,
 'アカウント削除'  => 'user_delete.php' ,
 'パスワード変更'  => 'user_passwd.php'
);

$menu8 = array(  //共通メニュー: ログイン中  ,
  'ログアウト'  => 'logout.php'
);
$menu9 = array(  //共通メニュー: ログイン前
  'ユーザ登録'  => 'user_add.php',
  'ログイン'  => 'login.php',
);


echo '<ul class="nav navbar-nav">';
if(isset($_SESSION['post']) ){
  $i = $_SESSION['post'];
  $s = array(1=>'学生',2=>'教員',5=>'審査員',8=>'審査員',9=>'管理者');
  echo '<li class="dropdown">';
  echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $s[$i] . 'メニュー<span class="caret"></span></a>';
  echo '<ul class="dropdown-menu">';
  $menu = array();
  if( $_SESSION['post']==1 || $_SESSION['post']==2 || $_SESSION['post']==5) $menu = $menu1;   //ワーカーメニュー
  if( $_SESSION['post']==8) $menu = $menu2;   //審査員メニュー
  if( $_SESSION['post']==9) $menu = $menu3;   //管理者メニュー
  foreach($menu as $label=>$url)
    echo "<li><a href=\"{$url}\">{$label}</a></li>";
  echo '</ul>';
  echo '</li>';
}
echo '</ul>';
echo '<ul class="nav navbar-nav navbar-right">';
if(isset($_SESSION['post']) ){//共通メニュー: ログイン中
  $url='mypage.php?userid='.$_SESSION['userid'];
  echo '<li><a href="' .$url. '">' . $_SESSION['uname'] . 'さんのマイページ</a></li>';
  foreach($menu8 as $label=>$url)
    echo '<li><a href="' .$url. '">' . $label . '</a></li>';
}else{ //共通メニュー: ログイン前
  foreach($menu9 as $label=>$url)
    echo '<li><a href="' .$url. '">' . $label . '</a></li>';
}
echo '</ul>';

 ?>
  </div>
</nav>
