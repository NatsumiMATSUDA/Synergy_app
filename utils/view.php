<?php
//テンプレートの呼び出し

//ページ遷移時に値を渡す
function includeWithVariables($filePath, $variables = array(), $print = true) {
  $output = NULL;
  if(file_exists($filePath)){
    extract($variables);
    ob_start();
    include $filePath;
    $output = ob_get_clean();
  }
  if ($print) {
      print $output;
  }
  return $output;
}

//テンプレートを呼び出す
function includeTemplateWithVariables($template = 'default', $filePath, $variables = array()) {
  $output = NULL;

  $templateFile = dirname(dirname(__FILE__))."/views/templates/".$template.".php";
  if(!file_exists($templateFile)){
    return $output;
    die();
  }

  if(file_exists($filePath)){
    extract($variables);
    ob_start();
    include $templateFile;
    $output = ob_get_clean();
  }

  print $output;
}
?>
