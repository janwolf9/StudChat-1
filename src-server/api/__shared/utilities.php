<?php
function printJSON($out, $error_code = 200){
  http_response_code($error_code);
  echo json_encode($out);
  exit;
}
function printJSONError($out, $error_code = 400) {
  printJSON(array("error" => $out), $error_code);
}
function printJSONData($out, $error_code = 200) {
  printJSON(array("data" => $out), $error_code);
}


function validOrThrow($val, $out, $error_code = 400) {
  if(!isset($val) || empty($val)){
    printJSONError($out);
  }
  return $val;
}
?>
