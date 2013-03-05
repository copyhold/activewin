<?php
$message = <<<EOM
You've received a message from ActiveWin contact form:

Name:  {$_POST['name']}
Email: {$_POST['email']}
Phone: {$_POST['phone']}
Message: {$_POST['text']}
EOM;
$headers = "CC: tech@activewin.co.uk\r\nFrom: {$_POST['email'] }\r\n";
$headers = "CC: ilya@marbellargoup.com\r\nFrom: {$_POST['email'] }\r\n";
if (!mail('moe@marbellagroup.com', 'A Message from ActiveWin website' , $message, $headers)) die('mail not sent');
echo json_encode(array("reply"=>"Your request is being processed."));
