<?php

global $global, $config;

require_once $global['systemRootPath'] . 'objects/PHPMailer/src/PHPMailer.php';
require_once $global['systemRootPath'] . 'objects/PHPMailer/src/SMTP.php';
require_once $global['systemRootPath'] . 'objects/PHPMailer/src/Exception.php';

function generateCode($l){
	$coupon = "PR".substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',$l-2)),0,$l-2);
	return $coupon;
}

function saveCode($email) {
  $amount = 5;
	$res = generateCode(10);
  $sql = "INSERT INTO `vouchers` (`code`, `amount`, `user_email`, `created`, `modified`) VALUES "
  . "(?, ?, ?, now(), now())";
  sqlDAL::writeSql($sql, "sis", array(xss_esc($res), $amount, xss_esc($email)));
}

function emailVoucher($email, $code) {
  $mail = new PHPMailer;

  //Enable SMTP debugging.
  $mail->SMTPDebug = 3;
  //Set PHPMailer to use SMTP.
  $mail->isSMTP();
  //Set SMTP host name
  $mail->Host = "smtp.gmail.com";
  //Set this to true if SMTP host requires authentication to send email
  $mail->SMTPAuth = true;
  //Provide username and password
  $mail->Username = "juan@lolitas.live";
  $mail->Password = "SebwW5Q48pk7";
  //If SMTP requires TLS encryption then set it
  $mail->SMTPSecure = "tls";
  //Set TCP port to connect to
  $mail->Port = 587;

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
