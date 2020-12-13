<!--
処理する情報が同じものは大きく一つのファイルにまとめる
-->

<h1 class="bd-content-title mb-4">アクティビティ新規作成</h1>

<?php if(isset($err['alert'])): ?>
  <div class="alert alert-danger" role="alert">
    <?php echo $err['alert']; ?>
  </div>
<?php endif; ?>

<form method="post">
  <div class="form-group mb-4">
    <label for="activity_title">アクティビティタイトル</label>
    <input name="activity_title" type="text" class="form-control" id="activity_title" placeholder="タイトル" value="<?= $inputValues['activity_title'] ?>" />
    <?php if(isset($err['activity_title'])): ?>
      <p class="text-danger mt-1"><?php echo $err['activity_title']; ?></p>
    <?php endif; ?>
  </div>

  <div class="form-group mb-4">
    <div class="row">
      <div class="col-sm">
        <label for="content">開始日</label>
        <div class="row">
          <div class="col-sm">
            <select class="form-control" name="start_year">
              <option value="0">年</option>
              <?php
                for ($i=2017; $i<=2020; $i++) {
                  if($inputValues['start_year'] == $i) {
                    echo "<option selected='selected' value='{$i}'>{$i}年</option>";
                  } else {
                    echo "<option value='{$i}'>{$i}年</option>";
                  }
                }
              ?>
            </select>
          </div>
          <div class="col-sm">
            <select class="form-control" name="start_month">
              <option value="0">月</option>
              <?php
                for ($i=1; $i<=12; $i++) {
                  if($inputValues['start_month'] == $i) {
                    echo "<option selected='selected' value='{$i}'>{$i}月</option>";
                  } else {
                    echo "<option value='{$i}'>{$i}月</option>";
                  }
                }
              ?>
            </select>
          </div>
          <div class="col-sm">
            <select class="form-control" name="start_day">
              <option value="0">日</option>
              <?php
                for ($i=1; $i<=31; $i++) {
                  if($inputValues['start_day'] == $i) {
                    echo "<option selected='selected' value='{$i}'>{$i}日</option>";
                  } else {
                    echo "<option value='{$i}'>{$i}日</option>";
                  }
                }
              ?>
            </select>
          </div>
        </div>
        <?php if(isset($err['start_date'])): ?>
          <p class="text-danger mt-1"><?php echo $err['start_date']; ?></p>
        <?php endif; ?>
      </div>
      <div class="col-sm">
        <label for="content">終了日</label>
        <div class="row">
          <div class="col-sm">
            <select class="form-control" name="end_year">
              <option value="0">年</option>
              <?php
                for ($i=2017; $i<=2020; $i++) {
                  if($inputValues['end_year'] == $i) {
                    echo "<option selected='selected' value='{$i}'>{$i}年</option>";
                  } else {
                    echo "<option value='{$i}'>{$i}年</option>";
                  }
                }
              ?>
            </select>
          </div>
          <div class="col-sm">
            <select class="form-control" name="end_month">
              <option value="0">月</option>
              <?php
                for ($i=1; $i<=12; $i++) {
                  if($inputValues['end_month'] == $i) {
                    echo "<option selected='selected' value='{$i}'>{$i}月</option>";
                  } else {
                    echo "<option value='{$i}'>{$i}月</option>";
                  }
                }
              ?>
            </select>
          </div>
          <div class="col-sm">
            <select class="form-control" name="end_day">
              <option value="0">日</option>
              <?php
                for ($i=1; $i<=31; $i++) {
                  if($inputValues['end_day'] == $i) {
                    echo "<option selected='selected' value='{$i}'>{$i}日</option>";
                  } else {
                    echo "<option value='{$i}'>{$i}日</option>";
                  }
                }
              ?>
            </select>
          </div>
        </div>
        <?php if(isset($err['end_date'])): ?>
          <p class="text-danger mt-1"><?php echo $err['end_date']; ?></p>
        <?php endif; ?>
      </div>
    </div>

  </div>

  <div class="form-group mb-4">
    <label for="content">分野カテゴリ</label>
    <select class="form-control" name="category">
      <option value="0">選択してください</option>
      <option value="1" <?= $inputValues['category'] == '1' ? 'selected="selected"' : '' ?>>地域貢献</option>
      <option value="2" <?= $inputValues['category'] == '2' ? 'selected="selected"' : '' ?>>プログラミング</option>
      <option value="3" <?= $inputValues['category'] == '3' ? 'selected="selected"' : '' ?>>ジェンダー</option>
    </select>
    <?php if(isset($err['category'])): ?>
      <p class="text-danger mt-1"><?php echo $err['category']; ?></p>
    <?php endif; ?>
  </div>


  <div class="form-group mb-4">
    <label for="content">アクティビティ内容</label>
    <textarea name="content" class="form-control" id="content" rows="3"><?= $inputValues['content'] ?></textarea>
    <?php if(isset($err['content'])): ?>
      <p class="text-danger mt-1"><?php echo $err['content']; ?></p>
    <?php endif; ?>
  </div>


  <div class="form-group mb-4">
    <label for="content">参加者募集</label>
    <select class="form-control" name="recruitment_state">
      <option value="0">選択してください</option>
      <option value="1" <?= $inputValues['recruitment_state'] == '1' ? 'selected="selected"':'' ?>>募集する</option>
      <option value="2" <?= $inputValues['recruitment_state'] == '2' ? 'selected="selected"':'' ?>>募集しない</option>
    </select>
    <?php if(isset($err['recruitment_state'])): ?>
      <p class="text-danger mt-1"><?php echo $err['recruitment_state']; ?></p>
    <?php endif; ?>
  </div>


  <div class="form-group mb-4">
    <input class="form-control btn btn-primary btn-lg" type="submit" value="送信" />
  </div>

</form>
