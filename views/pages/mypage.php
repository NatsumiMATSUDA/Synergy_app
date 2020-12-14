<?php include_once dirname(dirname(dirname(__FILE__)))."/utils/activity.php"; ?>
<h3 class="bd-content-title mb-4">
  マイページ
</h3>

<div class="row">
  <div class="col-4">
    <div class="card mb-4">
      <div class="card-body">
        <table class="table-borderless table m-0">
          <tbody>
            <tr>
              <td width="150px"><span class="font-weight-bold">ユーザー名</span></td>
              <td>
                <?php echo $login_user['user_name']; ?>
              </td>
            </tr>

            <tr>
              <td width="150px"><span class="font-weight-bold">大学名</span></td>
              <td>
                津田塾大学
              </td>
            </tr>
            <tr>
              <td width="150px"><span class="font-weight-bold">学部学科名</span></td>
              <td>
                総合政策学部<br />総合政策学科
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-8">

    <h6 class="bd-content-title mb-4">
      アクティビティ履歴
    </h6>

    <div class="app__activities">

      <?php if(count($activities1)): ?>
        <?php includeWithVariables(dirname(dirname(__FILE__))."/partials/activitylist.php", array(
          'activities' => $activities1,
          'category_name' => getActivityCategoryById(1)
        )); ?>
      <?php endif; ?>


      <?php if(count($activities2)): ?>
        <?php includeWithVariables(dirname(dirname(__FILE__))."/partials/activitylist.php", array(
          'activities' => $activities2,
          'category_name' => getActivityCategoryById(2)
        )); ?>
      <?php endif; ?>

      <?php if(count($activities3)): ?>
        <?php includeWithVariables(dirname(dirname(__FILE__))."/partials/activitylist.php", array(
          'activities' => $activities3,
          'category_name' => getActivityCategoryById(3)
        )); ?>
      <?php endif; ?>

    </div>

  </div>
</div>
