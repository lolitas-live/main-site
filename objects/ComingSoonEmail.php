<?php

global $global, $config;
if (!isset($global['systemRootPath'])) {
    require_once dirname(__FILE__) . '/../videos/configuration.php';
}
echo("<script>console.log('got here pre-isset');</script>");
function saveData() {
  // Check if the form is submitted
  if (isset($_POST['submit'])) {
    echo("<script>console.log('got here isset');</script>");
    // retrieve the form data by using the element's name attributes value as key
    $email = $_REQUEST['email'];
    $sql = "INSERT INTO coming_soon_email (email, created, modified,) "
          . " VALUES ($email, now(), now(), ";
    sqlDAL::writeSql($sql, "s");
    echo("<script>console.log('got here post sqlDAL');</script>");
  }
}

saveData();
