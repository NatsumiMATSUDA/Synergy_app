<?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/utils/activity.php"; ?>
<h3 class="bd-content-title mb-4">
  レポートフォーム
</h3>

<div class="row">
  <div class="col-lg-4 col-xs-12">
    <?php includeWithVariables(dirname(dirname(dirname(dirname(__FILE__))))."/partials/activity_detail.php", array(
      'activity' => $activity,
      'activity_create_user' => $activity_create_user,
    )); ?>
  </div>

  <div class="col-lg-8 col-xs-12">

    <div class="float-right">
      <a class="btn btn-secondary" href="<?= APP_URL ?>/activity/detail/<?= $activity['id']; ?>">戻る</a>
    </div>
    <h3 class="bd-content-title mb-4">
      <?= $activity['activity_title']; ?>
    </h6>

    <?php if(isset($saveSuccess) && $saveSuccess): ?>
      <div class="alert alert-success" role="alert">
        レポートの保存に成功しました。
      </div>
    <?php endif; ?>

    <div class="card mb-4">
      <div class="card-body">
        <form method="post">

          <div class="form-group mb-4">
            <label for="impression">感想</label>
            <textarea name="impression" class="form-control" id="impression" rows="3"><?= $inputValues['impression'] ?></textarea>
            <?php if(isset($err['impression'])): ?>
              <p class="text-danger mt-1"><?php echo $err['impression']; ?></p>
            <?php endif; ?>
          </div>

          <div class="form-group mb-4">
            <label for="contribution">やったこと</label>
            <textarea name="contribution" class="form-control" id="contribution" rows="3"><?= $inputValues['contribution'] ?></textarea>
            <?php if(isset($err['contribution'])): ?>
              <p class="text-danger mt-1"><?php echo $err['contribution']; ?></p>
            <?php endif; ?>
          </div>

          <div class="form-group mb-4">
            <label for="leadership">リーダシップ</label>
            <select class="form-control" name="leadership">
              <option value="0"></option>
              <?php
                foreach($attendees as $attendee) {
                  if($inputValues['leadership'] == $attendee['id']) {
                    echo "<option selected='selected' value='{$attendee['id']}'>{$attendee['user_name']}</option>";
                  } else {
                    echo "<option value='{$attendee['id']}'>{$attendee['user_name']}</option>";
                  }
                }
              ?>
            </select>
          </div>

          <div class="form-group mb-4">
            <label for="ideaman">アイディアマン</label>
            <select class="form-control" name="ideaman">
              <option value="0"></option>
              <?php
                foreach($attendees as $attendee) {
                  if($inputValues['ideaman'] == $attendee['id']) {
                    echo "<option selected='selected' value='{$attendee['id']}'>{$attendee['user_name']}</option>";
                  } else {
                    echo "<option value='{$attendee['id']}'>{$attendee['user_name']}</option>";
                  }
                }
              ?>
            </select>
          </div>

          <div class="form-group mb-4">
            <label for="writer">ライター</label>
            <select class="form-control" name="writer">
              <option value="0"></option>
              <?php
                foreach($attendees as $attendee) {
                  if($inputValues['writer'] == $attendee['id']) {
                    echo "<option selected='selected' value='{$attendee['id']}'>{$attendee['user_name']}</option>";
                  } else {
                    echo "<option value='{$attendee['id']}'>{$attendee['user_name']}</option>";
                  }
                }
              ?>
            </select>
          </div>

          <div class="form-group mb-4">
            <label for="presenter">プレゼンター</label>
            <select class="form-control" name="presenter">
              <option value="0"></option>
              <?php
                foreach($attendees as $attendee) {
                  if($inputValues['presenter'] == $attendee['id']) {
                    echo "<option selected='selected' value='{$attendee['id']}'>{$attendee['user_name']}</option>";
                  } else {
                    echo "<option value='{$attendee['id']}'>{$attendee['user_name']}</option>";
                  }
                }
              ?>
            </select>
          </div>

          <div class="form-group mb-4">
            <label for="mvp">MVP</label>
            <select class="form-control" name="mvp">
              <option value="0"></option>
              <?php
                foreach($attendees as $attendee) {
                  if($inputValues['mvp'] == $attendee['id']) {
                    echo "<option selected='selected' value='{$attendee['id']}'>{$attendee['user_name']}</option>";
                  } else {
                    echo "<option value='{$attendee['id']}'>{$attendee['user_name']}</option>";
                  }
                }
              ?>
            </select>
          </div>

          <div class="form-group mb-4">
            <input class="form-control btn btn-primary btn-lg" type="submit" value="レポートを保存" />
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
