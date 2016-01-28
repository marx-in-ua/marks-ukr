<?php

  $config = require 'config.php';

  $apiKey         = $config['apiKey'];
  $listId         = $config['listId'];
  $double_optin   = false;
  $send_welcome   = true;
  $email_type     = 'html';
  $email          = $_POST['email'];
  $name          = $_POST['name'];

  // Replace us8 with your datacentre, usually found at end of api key
  $submit_url     = "http://us12.api.mailchimp.com/1.3/?method=listSubscribe";

  $data = array(
      'email_address'=>$email,
      'merge_vars' => array('NAME'=>$name),
      'apikey'=>$apiKey,
      'id' => $listId,
      'double_optin' => $double_optin,
      'send_welcome' => $send_welcome,
      'email_type' => $email_type
  );

  $payload = json_encode($data);
   
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $submit_url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
   
  $result = curl_exec($ch);
  curl_close($ch);
  $data = json_decode($result);

    if ($data->error) {
        echo '<p class="sub-form-error"><i class="fa fa-exclamation-triangle"></i>'.$data->error.'</p>';
    } else {
        echo "<p class='sub-form-success'><i class='fa fa-envelope'></i>Дякуємо! Чекайте на новини!</p>";
    }
