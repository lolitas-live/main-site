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
    echo "<script>console.log('Email: " . $email . "' );</script>";
    $sql = "INSERT INTO `coming_soon_email` (`email`, `created`, `modified`) VALUES ($email, now(), now())";
    echo "<script>console.log('SQL statement: " . $sql . "' );</script>";
    $resp = sqlDAL::writeSql($sql, "s");
    echo("<script>console.log('got here post sqlDAL');</script>");
  }
  echo "<script>console.log('Response: " . $resp . "' );</script>";
  return $resp;
}

saveData();
