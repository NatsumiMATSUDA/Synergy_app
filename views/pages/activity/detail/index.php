<?php include_once dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/utils/activity.php"; ?>
<h3 class="bd-content-title mb-4">
  アクティビティ詳細
</h3>

<div class="row">
    <div class="col-lg-4 col-xs-12">
    <?php includeWithVariables(dirname(dirname(dirname(dirname(__FILE__))))."/partials/activity_detail.php", array(
      'activity' => $activity,
      'activity_create_user' => $activity_create_user,
    )); ?>

    <div class="card mb-4">
      <div class="card-body">
        <?php if($isEnd): ?>
          <span class="d-block text-center">アクティビティ終了</span>

          <?php if(isset($entryState['state']) && $entryState['state'] == 5): ?>
            <a href="<?=APP_URL ?>/activity/report/<?= $activity['id']?>/write" class="btn btn-outline-primary btn-block mt-3">レポートを書く</a>
          <?php endif; ?>

        <?php elseif(!$isEnd && $isRecruiting): ?>

          <?php if(!$entryState || $entryState['state'] == 1): ?><!-- entry_stateがない(acitivityに参加していない)場合-->
            <form method="post" action="<?= APP_URL ?>/activity/join" onsubmit="return confirm('参加しますか？ よろしいでしょうか？')">
              <button class="btn btn-block btn-primary" type="submit">参加する</button>
              <input type="hidden" name="activity_id" value="<?= $activity['id'] ?>" />
            </form>
          <?php elseif($entryState): ?>
            <?php if($entryState['state'] > 1): ?>
              <?= getActivityStateById($entryState['state']) ?>
            <?php endif; ?>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>

    <?php if($is_owner): ?>
      <div>
        <h6 class="bd-content-title mb-2 font-weight-bold">
          オプション
        </h6>
        <div class="card">
          <div class="card-body">
            <a class="btn btn-outline-primary btn-block" href="<?= APP_URL ?>/activity/attendees/<?= $activity['id']; ?>">出席者管理</a>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <div class="col-lg-8 col-xs-12">

    <h6 class="bd-content-title mb-4">
      <?= $activity['activity_title']; ?>
    </h6>


    <div class="card mb-4">
      <div class="card-body">
        <?= $activity['content']; ?>
      </div>
    </div>

    <?php if($isRecruiting && count($attendees)): ?>
      <div class="mb-4">
        <h6 class="bd-content-title mb-2">
          参加者
        </h6>
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
                <?php if($is_owner && $attendee['state'] == 2): ?>
                  <div class="col-sm">
                    <div class="d-flex justify-content-end">
                      <form class="mr-2" method="post" action="<?= APP_URL ?>/activity/update/state" onsubmit="return confirm('あのユーザーを承認します。よろしいですか？')">
                        <button class="btn btn-small btn-success" type="submit">承認</button>
                        <input type="hidden" name="activity_id" value="<?= $activity['id'] ?>" />
                        <input type="hidden" name="state_id" value="3" />
                        <input type="hidden" name="user_id" value="<?= $attendee['id'] ?>" />
                        <input type="hidden" name="context" value="detail" />
                      </form>

                      <form method="post" action="<?= APP_URL ?>/activity/update/state" onsubmit="return confirm('あのユーザーを否定します。よろしいですか？')">
                        <button class="btn btn-small btn-danger" type="submit">否定</button>
                        <input type="hidden" name="activity_id" value="<?= $activity['id'] ?>" />
                        <input type="hidden" name="state_id" value="4" />
                        <input type="hidden" name="user_id" value="<?= $attendee['id'] ?>" />
                        <input type="hidden" name="context" value="detail" />
                      </form>
                    </div>
                  </div>
                <?php else: ?>
                  <div class="col-sm"></div>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </ul>
      </div>

      <?php if($isEnd && isset($reports) && count($reports)): ?>
        <?php
          $impressions = array_filter($reports, function($report, $key) {
            return !empty($report['impression']);
          }, ARRAY_FILTER_USE_BOTH);

          $contributions = array_filter($reports, function($report, $key) {
            return !empty($report['contribution']);
          }, ARRAY_FILTER_USE_BOTH);

          $counters = array(
            'leadership' => array(),
            'ideaman' => array(),
            'writer' => array(),
            'presenter' => array(),
            'mvp' => array(),
          );

          $user_map = array();
          foreach ($reports as $report) {
            $user_map[$report['user_id']] = $report['user_name'];

            if(!isset($counters['leadership'][$report['user_id']])) {
              $counters['leadership'][$report['user_id']] = 0;
            }
            $counters['leadership'][$report['user_id']]++;

            if(!isset($counters['ideaman'][$report['user_id']])) {
              $counters['ideaman'][$report['user_id']] = 0;
            }
            $counters['ideaman'][$report['user_id']]++;

            if(!isset($counters['writer'][$report['user_id']])) {
              $counters['writer'][$report['user_id']] = 0;
            }
            $counters['writer'][$report['user_id']]++;

            if(!isset($counters['presenter'][$report['user_id']])) {
              $counters['presenter'][$report['user_id']] = 0;
            }
            $counters['presenter'][$report['user_id']]++;

            if(!isset($counters['mvp'][$report['user_id']])) {
              $counters['mvp'][$report['user_id']] = 0;
            }
            $counters['mvp'][$report['user_id']]++;
          }
        ?>

        <?php if(count($impressions)): ?>
          <div class="mb-4">
            <h6 class="bd-content-title mb-2">
              感想
            </h6>

            <?php foreach($impressions as $impression): ?>
              <div class="card mb-4">
                <div class="card-body">
                  <p class="mb-2">記入者：<span class="font-weight-bold"><?= $impression['impression']; ?></span>さん</p>
                  <p class="font-italic mb-0"><?= $impression['impression']; ?></p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php if(count($contributions)): ?>
          <div class="mb-4">
            <h6 class="bd-content-title mb-2">
              貢献
            </h6>

            <?php foreach($contributions as $contribution): ?>
              <div class="card mb-4">
                <div class="card-body">
                  <p class="mb-2">記入者：<span class="font-weight-bold"><?= $contribution['user_name']; ?></span>さん</p>
                  <p class="font-italic mb-0"><?= $contribution['contribution']; ?></p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div class="mb-4">
          <h6 class="bd-content-title mb-2">
            役割結果
          </h6>

          <div class="card mb-4">
            <div class="card-body">

              <?php if(count($counters['leadership'])): ?>

                <?php $winner = array_search(max($counters['leadership']), $counters['leadership']); ?>

                <p class="float-right"><?= count($reports) ?>人に対して、<?= $counters['leadership'][$winner] ?>人に選ばれました</p>
                <p class="mb-2">リーダーシップ : <span class="font-weight-bold"><?= $user_map[$winner] ?></span>さん</p>
                <hr />
              <?php endif; ?>

              <?php if(count($counters['ideaman'])): ?>

                <?php $winner = array_search(max($counters['ideaman']), $counters['ideaman']); ?>

                <p class="float-right"><?= count($reports) ?>人に対して、<?= $counters['ideaman'][$winner] ?>人に選ばれました</p>
                <p class="mb-2">アイディアマン : <span class="font-weight-bold"><?= $user_map[$winner] ?></span>さん</p>
                <hr />
              <?php endif; ?>

              <?php if(count($counters['writer'])): ?>

                <?php $winner = array_search(max($counters['writer']), $counters['writer']); ?>

                <p class="float-right"><?= count($reports) ?>人に対して、<?= $counters['writer'][$winner] ?>人に選ばれました</p>
                <p class="mb-2">ライター : <span class="font-weight-bold"><?= $user_map[$winner] ?></span>さん</p>
                <hr />
              <?php endif; ?>

              <?php if(count($counters['presenter'])): ?>

                <?php $winner = array_search(max($counters['presenter']), $counters['presenter']); ?>

                <p class="float-right"><?= count($reports) ?>人に対して、<?= $counters['presenter'][$winner] ?>人に選ばれました</p>
                <p class="mb-2">プレエンター : <span class="font-weight-bold"><?= $user_map[$winner] ?></span>さん</p>
                <hr />
              <?php endif; ?>

              <?php if(count($counters['mvp'])): ?>

                <?php $winner = array_search(max($counters['mvp']), $counters['mvp']); ?>

                <p class="float-right"><?= count($reports) ?>人に対して、<?= $counters['mvp'][$winner] ?>人に選ばれました</p>
                <p class="mb-2">MVP : <span class="font-weight-bold"><?= $user_map[$winner] ?></span>さん</p>
              <?php endif; ?>
            </div>
          </div>

        </div>

      <?php endif; ?>
    <?php endif; ?>

  </div>
</div>
