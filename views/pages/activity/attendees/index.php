<?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/utils/activity.php";
 ?>

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
      出席者確定フォーム
    </h3>
    <ul class="list-group">
      <?php foreach($attendees as $attendee): ?>
        <div class="list-group-item list-group-item-action">
          <div class="row">
            <div class="col-sm">
              <?= $attendee['user_name']; ?>
            </div>

            <div class="col-sm text-center">
              <?= getActivityStateById($attendee['state']); ?>
            </div>

            <div class="col-sm">
              <div class="d-flex justify-content-end">
                <form class="mr-2" method="post" action="<?= APP_URL ?>/activity/update/state" onsubmit="return confirm('このユーザーを出席とします。よろしいですか？')">
                  <button class="btn btn-small btn-success" type="submit">出席</button>
                  <input type="hidden" name="activity_id" value="<?= $activity['id'] ?>" />
                  <input type="hidden" name="state_id" value="5" />
                  <input type="hidden" name="user_id" value="<?= $attendee['id'] ?>" />
                  <input type="hidden" name="context" value="attendee" />
                </form>

                <form method="post" action="<?= APP_URL ?>/activity/update/state" onsubmit="return confirm('このユーザーを欠席とします。よろしいですか？')">
                  <button class="btn btn-small btn-danger" type="submit">欠席</button>
                  <input type="hidden" name="activity_id" value="<?= $activity['id'] ?>" />
                  <input type="hidden" name="state_id" value="6" />
                  <input type="hidden" name="user_id" value="<?= $attendee['id'] ?>" />
                  <input type="hidden" name="context" value="attendee" />
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
