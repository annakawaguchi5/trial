<?php include('page_header.php'); ?>
<div class="container">
  <h2>学内向けクラウドソーシングへログイン</h2>
  <form class="form-horizontal" action="login_check.php" method="post">
    <div class="form-group has-warning">
    <label for="userid" class="control-label col-sm-2">ログインID：</label>
      <div class="col-sm-10"><input type="text" id="vs1" name="userid" class="form-control" placeholder="ログインID（英数の文字列）">
      </div>
    </div>
    <div class="form-group has-success">
    <label for="pass" class="control-label col-sm-2">パスワード：</label>
      <div class="col-sm-10"><input type="password" id="vs2" name="passwd" class="form-control" placeholder="パスワード">
      </div>
    </div>
    <div class="form-group has-error">
     <div class="col-sm-offset-3 col-sm-6"><input class="btn btn-primary btn-block" type="submit" value="ログイン">
     </div>
   </div>
 </form>
</div>
<?php include('page_footer.php'); ?>