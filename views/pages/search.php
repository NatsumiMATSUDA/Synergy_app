
<h2 class="bd-content-title mb-4">参加可能なアクティビティ検索</h2>

<form method="get">
  <div class="form-group mb-4">
    <label for="category">分野検索</label>
    <select class="form-control" name="category">
      <option value="0" <?= $category == '0' ? 'selected="selected"' : '' ?>>選択してください</option>
      <option value="1" <?= $category == '1' ? 'selected="selected"' : '' ?>>地域貢献</option>
      <option value="2" <?= $category == '2' ? 'selected="selected"' : '' ?>>プログラミング</option>
      <option value="3" <?= $category == '3' ? 'selected="selected"' : '' ?>>ジェンダー</option>
    </select>
  </div>

  <div class="form-group mb-4">
    <label for="category">キーワード</label>
    <input class="form-control" type="text" value="<?= $keywords ?>" name="keywords" />
  </div>

  <div class="form-group mb-4">
    <input class="form-control btn btn-primary btn-lg" type="submit" value="検索" />
  </div>
</form>

<?php if(count($activities)): ?>
  <?php includeWithVariables(dirname(dirname(__FILE__))."/partials/activitylist.php", array(
    'activities' => $activities
  )); ?>
<?php endif; ?>
