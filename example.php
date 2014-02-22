<?php
require('oauthRequest.php');

$output = oauthRequest('https://api.twitter.com/1.1/statuses/user_timeline.json');
echo $output;
?>