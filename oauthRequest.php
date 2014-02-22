<?php
/**
 * A simple OAuth request wrapper written in PHP.
 * @author Arjun Sreedharan (github.com/arjun024)
 * MIT License
 */

/************ You can call oauthRequest(<url>) like: *****************************

$output = oauthRequest('https://api.twitter.com/1.1/statuses/user_timeline.json');
echo $output;

/********************************************************************************/


/************ fill in your keys here *****************************************************************/
	$MY_CONSUMER_KEY        = 'xxxxxxxxxxxxxxxxxxxxx';
	$MY_CONSUMER_SECRET     = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
	$MY_ACCESS_TOKEN        = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
	$MY_ACCESS_TOKEN_SECRET = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
/*****************************************************************************************************/



function _oauth($YOUR_CONSUMER_KEY, $YOUR_ACCESS_TOKEN, $YOUR_CONSUMER_SECRET, $YOUR_ACCESS_TOKEN_SECRET, $URL) {
	$ohash = '';
	$ohash .= 'oauth_consumer_key='.$YOUR_CONSUMER_KEY.'&';
	$ohash .= 'oauth_nonce=' . time() . '&';
	$ohash .= 'oauth_signature_method=HMAC-SHA1&';
	$ohash .= 'oauth_timestamp=' . time() . '&';
	$ohash .= 'oauth_token='.$YOUR_ACCESS_TOKEN.'&';
	$ohash .= 'oauth_version=1.0';
	$base = '';
	$base .= 'GET';
	$base .= '&';
	$base .= rawurlencode($URL);
	$base .= '&';
	$base .= rawurlencode($ohash);
	$key = '';
	$key .= rawurlencode($YOUR_CONSUMER_SECRET);
	$key .= '&';
	$key .= rawurlencode($YOUR_ACCESS_TOKEN_SECRET);
	$signature = base64_encode(hash_hmac('sha1', $base, $key, true));
	$signature = rawurlencode($signature);

	$oheader = '';
	$oheader .= 'oauth_consumer_key="'.$YOUR_CONSUMER_KEY.'", ';
	$oheader .= 'oauth_nonce="' . time() . '", ';
	$oheader .= 'oauth_signature="' . $signature . '", ';
	$oheader .= 'oauth_signature_method="HMAC-SHA1", ';
	$oheader .= 'oauth_timestamp="' . time() . '", ';
	$oheader .= 'oauth_token="'.$YOUR_ACCESS_TOKEN.'", ';
	$oheader .= 'oauth_version="1.0", ';
	$curl_header = array("Authorization: Oauth {$oheader}", 'Expect:');

	$curl_request = curl_init();
	curl_setopt($curl_request, CURLOPT_HTTPHEADER, $curl_header);
	curl_setopt($curl_request, CURLOPT_HEADER, false);
	curl_setopt($curl_request, CURLOPT_URL, $URL);
	curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);
	$json = curl_exec($curl_request);
	curl_close($curl_request);
	return $json;
}

function oauthRequest($url) {
	global $MY_CONSUMER_KEY , $MY_ACCESS_TOKEN, $MY_CONSUMER_SECRET, $MY_ACCESS_TOKEN_SECRET;
	return _oauth($MY_CONSUMER_KEY , $MY_ACCESS_TOKEN, $MY_CONSUMER_SECRET, $MY_ACCESS_TOKEN_SECRET, $url);
}

?>