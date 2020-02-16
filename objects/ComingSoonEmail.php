<?php

global $global, $config;
if (!isset($global['systemRootPath'])) {
    require_once dirname(__FILE__) . '/../videos/configuration.php';
}

function saveData() {
  global $global;

  // Check if the form is submitted
  if (isset($_POST['submit'])) {

    // retrieve the form data by using the element's name attributes value as key
    $email = $_REQUEST['email'];

    function checkEmail() {
      $sql = "SELECT * FROM `coming_soon_email` WHERE email = '{$email}' ";
      $res = sqlDAL::readSql($sql));
      $data = sqlDAL::fetchAssoc($res);
      sqlDAL::close($res);
      if ($data != false) {
        echo "<script>console.log('data is not false: " . $data . "' );</script>";
      } else {
        $sql = "INSERT INTO `coming_soon_email` (`email`, `created`, `modified`) VALUES "
        . "(?, now(), now())";
        sqlDAL::writeSql($sql, "s", array(xss_esc($email)));
      }
    }
  }
  checkEmail();
}

saveData();
