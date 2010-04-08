<?php
$auth_name = 'comment';
$b3_conn = true; // this page needs to connect to the B3 database
require '../../inc.php';

if(!isset($_POST['comment-sub'])) : // if the form is submitted
	set_error('Please do not call that page directly');
	send('../../');
endif;

## check that the sent form token is corret
if(verifyFormToken('comment', $tokens) == false) // verify token
	ifTokenBad('Add comment');

// Gets vars from form
$cid = cleanvar($_POST['cid']);
$comment = cleanvar($_POST['comment']);

// Check for empties
emptyInput($comment, 'comment');
emptyInput($cid, 'client id not sent');

## Check sent client_id is a number ##
if(!is_numeric($cid))
	sendBack('Invalid data sent, ban not added');

// set common vars	
$type = 'Comment';
$user_id = $_SESSION['user_id'];

## Query ##
$result = $dbl->addEchLog($type, $comment, $cid, $user_id);
if($result)
	sendGood('Comment added');
else
	sendBack('There is a problem, your comment was not added to the database');