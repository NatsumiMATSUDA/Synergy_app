<div class="card mb-4">
  <div class="card-body">
    <table class="table-borderless table m-0">
      <tbody>
        <tr>
          <td width="150px"><span class="font-weight-bold">アクティビティ名</span></td>
          <td>
            <?= $activity['activity_title'] ?>
          </td>
        </tr>
        <tr>
          <td width="150px"><span class="font-weight-bold">分野</span></td>
          <td>
            <?= getActivityCategoryById($activity['category']); ?>
          </td>
        </tr>
        <tr>
          <td width="150px"><span class="font-weight-bold">開催日</span></td>
          <td>
            <?= $activity['start_date']; ?>
          </td>
        </tr>
        <tr>
          <td width="150px"><span class="font-weight-bold">終了日</span></td>
          <td>
            <?= $activity['end_date']; ?>
          </td>
        </tr>
        <?php if(isset($activity_create_user) && $activity_create_user): ?>
          <tr>
            <td width="150px"><span class="font-weight-bold">作成者</span></td>
            <td>
              <?= $activity_create_user['user_name']; ?>さん
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
