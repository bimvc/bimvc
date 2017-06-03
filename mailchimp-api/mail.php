<?php

include('./src/MailChimp.php');

use \DrewM\MailChimp\MailChimp;
$MailChimp = new MailChimp('08c0778e8d05d0a8d4545cb66973a4bd-us14');

$listEn = 'b46b0b4bbb';
$listRu = '07583bb04d';

$newSubscriber = $_GET['email'];
$lang = $_GET['lang'];

if(!empty($newSubscriber) && !empty($lang)){

	if( $lang === 'ru_RU' ){
		$list = $listRu;
	}else if( $lang === 'en_US' ){
		$list = $listEn;
	}

	$result = $MailChimp->post("lists/".$list."/members", [
	                'email_address' => $newSubscriber,
	                'status'        => 'subscribed',
	            ]);

	print_r( json_encode ($result, true));
}

?>