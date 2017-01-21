<?php 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$data = json_encode( array(
		"email_address" => "supertest@test.com",
		"status" => "subscribed",
	));

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://us14.api.mailchimp.com/3.0/lists/07583bb04d/members");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 'content-type: application/json');
curl_setopt($ch, CURLOPT_USERPWD, 'mchbimvc:32eb5386486c3b7fb6d1de125e04100e-us14');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
print_r( curl_exec($ch) );
curl_close($ch);

?>