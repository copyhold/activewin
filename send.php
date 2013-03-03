<?php
$message = <<<EOM
Contact request from site

Name:  {$_POST['name']}
Email: {$_POST['email']}
Phone: {$_POST['phone']}
Message: {$_POST['text']}
EOM;
$headers = "tech@activewin.co.uk\r\nFrom: {$_POST['email'] }\r\n";
$headers = "ilya@marbellargoup.com\r\nFrom: {$_POST['email'] }\r\n";
if (!mail('moe@marbellagroup.com', 'Contact form sent' , $message, $headers)) die('mail not sent');
echo json_encode(array("reply"=>"Your request is being processed."));
