<?php

global $global, $config;
if (!isset($global['systemRootPath'])) {
    require_once dirname(__FILE__) . '/../videos/configuration.php';
}

require_once $global['systemRootPath'] . 'objects/Vouchers.php';

function sendEmail() {
  if (saveData()) {
    $email = $_REQUEST['email'];
    $sql = "SELECT * FROM `vouchers` WHERE user_email = '{$email}' ";
    $res = sqlDAL::readSql($sql);
    $data = sqlDAL::fetchAssoc($res);
    sqlDAL::close($res);
    $code = $data['code'];
    echo "<script>console.log('this is the code: " . $code . "' );</script>";
    //send email with code
    emailVoucher($email, $code);
  } else {
    echo "<script>console.log('saved data not true');</script>";
  }
}

function saveData() {
  global $global;

  // Check if the form is submitted
  if (isset($_POST['submit'])) {

    function handleEmail() {
      $email = $_REQUEST['email'];
      $sql = "SELECT * FROM `coming_soon_email` WHERE email = '{$email}' ";
      $res = sqlDAL::readSql($sql);
      $data = sqlDAL::fetchAssoc($res);
      sqlDAL::close($res);
      if ($data != false) {
        echo "<h1>EMAIL: " . $email . " already exists!</h1><p>We'll let you know when the
        site is up to redeem your code. Contact us: hello@lolitas.live</p>";
      } else {
        $sql = "INSERT INTO `coming_soon_email` (`email`, `created`, `modified`) VALUES "
        . "(?, now(), now())";
        sqlDAL::writeSql($sql, "s", array(xss_esc($email)));

        //create code and store against email
        saveCode($email);

        echo "<h1>Thanks for registering, " . $email . "!</h1><p>You will receive
        an email with a free credit code soon. We'll also let you know when the
        site is up to redeem your code. Contact us: hello@lolitas.live";
      }
    }
  }
  handleEmail();
  return true;
}
saveData();
sendEmail();
