<?php
global $global, $config;
if (!isset($global['systemRootPath'])) {
    require_once dirname(__FILE__) . '/videos/configuration.php';
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="view/css/comingsoon.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="bgimg">
  <div class="topleft">
    <p>Lolitas LIVE</p>
  </div>
  <div class="middle">
    <h1>COMING SOON</h1>
    <div class="form__group field middle" style="width: 21em!important; color: white!important">
      <form action="objects/ComingSoonEmail.php" method="post">
         <br/>
         <input type="email" id="email" name="email" class="form__field" placeholder="Enter email for free credits" required />
         <input type="submit" name="submit">
      </form>
    </div>
    <p style="margin-top: 20px;">60 days left</p>
  </div>
  <div class="bottomleft">
    <p>Enter your email above for free credits</p>
  </div>
</div>
</body>
</html>
