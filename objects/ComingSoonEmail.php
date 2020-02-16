<?php

global $global, $config;

class ComingSoonEmail {

  private $email;

  function save() {
    // Check if the form is submitted
    if ( isset( $_POST['submit'] ) ) {
      // retrieve the form data by using the element's name attributes value as key
      $email = $_REQUEST['email'];
    }

    $sql = "INSERT INTO coming_soon_email (email, created, modified,) "
          . " VALUES ($email, now(), now(), ";
    sqlDAL::writeSql($sql));
  }
}
