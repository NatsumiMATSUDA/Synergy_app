<?php
function h($str){
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');//(エスケープしたいもの、エスケープの内容、文字コード)
}
?>
