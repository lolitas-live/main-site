<?php

global $global, $config;
if (!isset($global['systemRootPath'])) {
    require_once dirname(__FILE__) . '/../videos/configuration.php';
}

function saveData() {
  global $global;

  // Check if the form is submitted
  if (isset($_POST['submit'])) {

    function checkEmail() {
      $email = $_REQUEST['email'];
      $sql = "SELECT * FROM `coming_soon_email` WHERE email = '{$email}' ";
      $res = sqlDAL::readSql($sql);
      $data = sqlDAL::fetchAssoc($res);
      sqlDAL::close($res);
      if ($data != false) {
        echo "<h1>EMAIL: " . $email . " already exists!</h1>";
      } else {
        $sql = "INSERT INTO `coming_soon_email` (`email`, `created`, `modified`) VALUES "
        . "(?, now(), now())";
        sqlDAL::writeSql($sql, "s", array(xss_esc($email)));
        echo "<h1>Thanks for registering, " . $email . "!</h1><p>You will receive
        an email with a free credit code soon. We'll also let you know when the
        site is up to redeem your code. Contat us: hello@lolitas.live";
      }
    }
  }
  checkEmail();
}

saveData();
