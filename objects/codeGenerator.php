<?php

global $global, $config;

function generateCode($l){
	$coupon = "PR".substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',$l-2)),0,$l-2);
	return $coupon;
}

function assignCode($email) {
  $amount = 5;
	$res = generateCode(10);
  $sql = "INSERT INTO `vouchers` (`code`, `amount`, `user_email`, `created`, `modified`) VALUES "
  . "(?, ?, ?, now(), now())";
  sqlDAL::writeSql($sql, "sis", array(xss_esc($res), $amount, xss_esc($email)));
  getAssignedCode($email);
}
