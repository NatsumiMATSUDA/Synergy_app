<?php include_once dirname(dirname(dirname(__FILE__)))."/utils/activity.php"; ?>

<div>
  <?php  if(isset($category_name) && $category_name): ?>
    <h6><?= $category_name; ?></h6>
  <?php endif; ?>

  <?php if(count($activities)): ?>
    <div class="mb-4">
      <ul class="list-group">
        <?php foreach($activities as $colum): ?>
          <a href="<?= APP_URL; ?>/activity/detail/<?= $colum['id'] ?>" class="list-group-item list-group-item-action">
            <div class="row">
              <div class="col-sm">
                <?= $colum['start_date']; ?> 〜 <?= $colum['end_date']; ?>
              </div>
              <div class="col-sm">
                <?= $colum['activity_title']; ?>
              </div>
              <?php if(isset($colum['state'])): ?>
                <div class="col-sm">
                  <?= getActivityStateById($colum['state']); ?>
                </div>
              <?php endif; ?>
            </div>
          </a>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>


</div>
