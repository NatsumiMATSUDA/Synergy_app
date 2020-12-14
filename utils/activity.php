<?php
function getActivityStateById($id) {
  switch ($id) {
    case 1:
      return "予約なし";
      break;
    case 2:
      return "未承認";
      break;
    case 3:
      return "承認済";
      break;
    case 4:
      return "承認却下";
      break;
    case 5:
      return "参加済";
      break;
    case 6:
      return "非参加";
      break;
    default:
      return null;
      break;
  }
}

function getActivityCategoryById($id) {
  switch ($id) {
    case 1:
      return "地域貢献";
      break;
    case 2:
      return "プログラミング";
      break;
    case 3:
      return "ジェンダー";
      break;
    default:
      return null;
      break;
  }
}
 ?>
