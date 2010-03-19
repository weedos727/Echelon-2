<?php
$auth_name = 'greeting';
$b3_conn = true; // this page needs to connect to the B3 database
require '../../inc.php';

if($_POST['greeting-sub']) : // if the form is submitted

	## check that the sent form token is corret
	if(verifyFormToken('greeting', $tokens) == false) // verify token
		ifTokenBad('Add comment');

	$greeting = cleanvar($_POST['greeting']);
	$client_id = cleanvar($_POST['cid']);

	if(!is_numeric($client_id))
		sendBack('Invalid data sent, greeting not changed');

	$query = "UPDATE clients SET greeting = ? WHERE id = ? LIMIT 1";
	$stmt = $db->mysql->prepare($query) or die('Database Error: '.$db->mysql->error);
	$stmt->bind_param('si', $greeting, $client_id);
	$stmt->execute();
	if($stmt->affected_rows)
		sendGood('Greeting has been updated');
	else
		sendBack('Greeting was not updated');
	
	$stmt->close(); // close connection

else :

	set_error('Please do not call that page directly, thank you.');
	send('../../index.php');

endif;