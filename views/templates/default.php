<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

  <title></title>
  <link rel="stylesheet" type="text/css" href="<?= APP_URL ?>/assets/bootstrap/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="<?= APP_URL ?>/assets/style/app.css" />
</head>

<body>
  <div class="app">
    <?php include(dirname(dirname(__FILE__)).'/partials/header.php'); ?>
    <main class="container">
      <? include($filePath) ?>
    </main>
  </div>

</body>
</html>
