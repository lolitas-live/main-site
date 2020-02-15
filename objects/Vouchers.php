<?php

global $global, $config;

Class Voucher {

  private $code;
  private $amount;
  private $created;
  private $modified;

  function generateCode($l){
		$coupon = "PR".substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',$l-2)),0,$l-2);
		return $coupon;
	}

	$res = generateCode(10);

  $sql = "INSERT INTO vouchers (code, amount, created, modified) "
        . " VALUES ($res, 5, now(), now(), ";

}
