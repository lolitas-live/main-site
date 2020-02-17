<?php

global $global, $config;
if (!isset($global['systemRootPath'])) {
    require_once dirname(__FILE__) . '/../videos/configuration.php';
}

require_once $global['systemRootPath'] . 'objects/Vouchers.php';
require_once $global['systemRootPath'] . 'objects/PHPMailer/src/PHPMailer.php';
require_once $global['systemRootPath'] . 'objects/PHPMailer/src/SMTP.php';
require_once $global['systemRootPath'] . 'objects/PHPMailer/src/Exception.php';


function sendEmail($email, $code) {
  $mail = new PHPMailer\PHPMailer\PHPMailer;
  //Set PHPMailer to use SMTP.
  $mail->isSMTP();
  setSiteSendMessage($mail);
  $mail->From = "hello@lolitas.live";
  $mail->FromName = "Lolitas Live";
  $mail->addAddress($email);
  $mail->isHTML(true);
  $mail->Subject = "Your free credit is here!";
  $mail->Body = "<h1>Save the code below</h1><p>When the site is live we will
                email you again with a link to sign up and redeem your code</p>
                <p>{$code}</p>";
  $mail->AltBody = "Save the code below so you can redeem at signup when the
                site is live. We'll let you know.";

  if(!$mail->send())
  {
      echo "<script>console.log('Mailer Error: " . $mail->ErrorInfo . "' );</script>";
  }
  else
  {
      echo "<script>console.log('Message has been sent successfully');</script>";
  }
}

function getAssignedCode($email) {
  $sql = "SELECT * FROM `vouchers` WHERE user_email = '{$email}' ";
  $res = sqlDAL::readSql($sql);
  $data = sqlDAL::fetchAssoc($res);
  sqlDAL::close($res);
  if ($data != false) {
    $code = $data['code'];
    //send email with code
    sendEmail($email, $code);
  } else {
    echo "<script>console.log('email address has no assigned codes');</script>";
  }
}

function handleSubmit() {
  global $global;

  // Check if the form is submitted
  if (isset($_POST['submit'])) {
    $email = $_REQUEST['email'];
    $sql = "SELECT * FROM `coming_soon_email` WHERE email = '{$email}' ";
    $res = sqlDAL::readSql($sql);
    $data = sqlDAL::fetchAssoc($res);
    sqlDAL::close($res);

    // Check email exists
    if ($data != false) {
      echo
      "
      <html>
      <head>
        <link rel=\"stylesheet\" type=\"text/css\" href=\"../view/css/comingsoon.css\">
      </head>
      <body>
      <div class=\"bgimg\">
        <div class=\"topleft\">
          <p>Lolitas LIVE</p>
        </div>
        <div class=\"middle\">
          <h1>Email: " . $email . " already exists!</h1>
          <p>We'll let you know when the
          site is up to redeem your code.
          </p>
        </div>
        <div class=\"bottomleft\">
          <p>Contact us: hello@lolitas.live</p>
        </div>
      </div>
      </body>
      </html>
      ";
    } else {
      $sql = "INSERT INTO `coming_soon_email` (`email`, `created`, `modified`) VALUES "
      . "(?, now(), now())";
      sqlDAL::writeSql($sql, "s", array(xss_esc($email)));
      //if email exists, create code and store against it
      assignCode($email);
      echo
      "
      <html>
      <head>
        <link rel=\"stylesheet\" type=\"text/css\" href=\"../view/css/comingsoon.css\">
      </head>
      <body>
      <div class=\"bgimg\">
        <div class=\"topleft\">
          <p>Lolitas LIVE</p>
        </div>
        <div class=\"middle\">
          <h1>Thanks for registering," . $email . "!</h1>
          <p>You will receive
          an email with a free credit code soon. We'll also let you know when the
          site is up to redeem your code.</p>
        </div>
        <div class=\"bottomleft\">
          <p>Contact us: hello@lolitas.live</p>
        </div>
      </div>
      </body>
      </html>
      ";
    }
  }
}
handleSubmit();
