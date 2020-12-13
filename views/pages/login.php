<form method="post" novalidate class="form__login">
  <h1 class="h3 mb-3 font-weight-normal text-center">ログイン</h1>

  <?php if(isset($err['alert'])): ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $err['alert']; ?>
    </div>
  <?php endif; ?>


  <div class="form-group mb-4">
    <label for="inputEmail" class="sr-only">メールアドレス</label>
    <input name="email" type="email" id="inputEmail" class="form-control" placeholder="メールアドレス" value="<?= $inputValues['email']; ?>" />
    <?php if(isset($err['email'])): ?>
      <p class="text-danger mt-1"><?php echo $err['email']; ?></p>
    <?php endif; ?>
  </div>
  <div class="form-group mb-4">
    <label for="inputPassword" class="sr-only">パスワード</label>
    <input name="password" type="password" id="inputPassword" class="form-control" placeholder="パスワード" />
    <?php if(isset($err['password'])): ?>
      <p class="text-danger mt-1"><?php echo $err['password']; ?></p>
    <?php endif; ?>
  </div>
  <div class="form-group mb-4">
    <button class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
  </div>
  <div class="form-group mb-2">
    <a class="btn btn-lg btn-light btn-block" href="signup">新規登録はこちら</a>
  </div>
</form>
