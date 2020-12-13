<h1 class="bd-content-title mb-4">新規ユーザー登録フォーム</h1>


<?php if(isset($err['alert'])): ?>
  <div class="alert alert-danger" role="alert">
    <?php echo $err['alert']; ?>
  </div>
<?php endif; ?>


<form method="post" novalidate>
  <div class="form-group mb-4">
    <label for="username">ユーザー名</label>
    <input name="username" type="text" class="form-control" id="username" placeholder="ユーザー名" value="<?= $inputValues['username'] ?>" />
    <?php if(isset($err['username'])): ?>
      <p class="text-danger mt-1"><?php echo $err['username']; ?></p>
    <?php endif; ?>
  </div>

  <div class="form-group mb-4">
    <label for="email">メールアドレス</label>
    <input name="email" type="email" class="form-control" id="email" placeholder="メールアドレス" value="<?= $inputValues['email'] ?>" />
    <?php if(isset($err['email'])): ?>
      <p class="text-danger mt-1"><?php echo $err['email']; ?></p>
    <?php endif; ?>
  </div>

  <div class="form-group mb-4">
    <label for="password">パスワード</label>
    <input name="password" type="password" class="form-control" id="password" placeholder="xxx@synergy.com">
    <?php if(isset($err['password'])): ?>
      <p class="text-danger mt-1"><?php echo $err['password']; ?></p>
    <?php endif; ?>
  </div>

  <div class="form-group mb-4">
    <label for="password_conf">パスワード(確認用)</label>
    <input name="password_conf" type="password" class="form-control" id="password_conf" placeholder="xxx@synergy.com">
    <?php if(isset($err['password_conf'])): ?>
      <p class="text-danger mt-1"><?php echo $err['password_conf']; ?></p>
    <?php endif; ?>
  </div>

  <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>" />

  <div class="form-group mb-4">
    <button class="btn btn-lg btn-primary btn-block" type="submit">新規登録</button>
  </div>

  <div class="form-group mb-2">
    <a class="btn btn-lg btn-light btn-block" href="login">アカウントを既にお持ちの方はこちら</a>
  </div>
</form>
