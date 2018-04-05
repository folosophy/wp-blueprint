<?php

use Blueprint\Mail as Mail;

add_action( 'wp_ajax_bp_contact_form', 'bp_contact_form' );
add_action( 'wp_ajax_nopriv_bp_contact_form', 'bp_contact_form');

function bp_contact_form() {

  $fields = $_POST['fields'];
  $form   = (object) $_POST['form'];

  $site_name = get_bloginfo('name');

  // User Email

  $subject = "$site_name (Submission Confirmation)";
  $message = "Thanks for contacting $site_name. \r\n We'll be in touch soon!";

  $user_email  = (new Mail())
    ->setTo($fields['email'])
    ->setSubject($subject)
    ->setBody($message)
    ->send();

  // Admin Email

  if (bp_is_local()) {$email = 'aofolts@gmail.com';}
  else {$email = get_field('site_email','option') ?? 'aofolts@gmail.com';}

  if (isset($fields['first_name'])) {
    $name  = $fields['first_name'] . ' ' . $fields['last_name'];
  } else {
    $name = $fields['name'] ?? 'No Name Provided';
  }

  $fields_list = '';

  foreach ($fields as $key => $val) {
    $key = ucwords(str_replace('_',' ',$key));
    $val = ucwords(str_replace('_',' ',$val));
    $fields_list .= "<p><b>$key:</b> $val</p>\r\n";
  }

  $subject = $fields['subject'] ?? null;
  $subject = $subject ?? $form['name'];
  $subject = str_replace('_',' ',$subject);
  $subject = ucwords($subject);
  $subject = "New $site_name Message ($subject)";
  $message = $fields['message'];
  $message = "
    <html>
      <body>
        <p>You received a new $site_name message.</p>
        <p><b>Form: $form->name</b></p>
        $fields_list
      </body>
    </html>
  ";

  $admin_email = (new Mail())
    ->setTo($email)
    ->setSubject($subject)
    ->setBody($message)
    ->send();

  $response = array();

  if ($user_email && $admin_email) {
    $response['type'] = 'success';
    $response['message'] = 'Message sent!';
  } else {
    $response['type'] = 'error';
    $response['message'] = 'An error occured.';
  }

  echo json_encode($response);

  wp_die();

}
