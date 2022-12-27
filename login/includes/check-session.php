<?php

if (!array_key_exists($COOKIE_NAME, $_COOKIE) || $_COOKIE[$COOKIE_NAME] == '[logged-out]') {
    header("Location: $LOGIN_PAGE_PATH");
    exit;
}

$cookie = json_decode(base64_decode($_COOKIE[$COOKIE_NAME]));

if (!is_object($cookie)
    || !property_exists($cookie, 'expiry')
    || !property_exists($cookie, 'login_type')) {
    throw new Exception('something-went-wrong:malformed-cookie');
}

if (time() < $cookie->expiry) {
    return;
}

if ($cookie->login_type == $BASIC_LOGIN_TYPE) {
    header("Location: $LOGIN_PAGE_PATH");
    exit;
}

if ($cookie->login_type == $VENDASTA_SSO_LOGIN_TYPE) {

    require_once __DIR__ . '/vendor/autoload.php';

    $provider = new \League\OAuth2\Client\Provider\GenericProvider([
        'urlResourceOwnerDetails' => $oauth_resource_owner_details_endpoint_url,
        'urlAuthorize' => "$authorization_url?account_id=".$_SESSION['account_id'],
        'urlAccessToken' => $oauth_access_token_endpoint_url,
        'clientSecret' => $oauth_client_secret,
        'clientId' => $oauth_client_id,
        'redirectUri' => $oauth_redirect_url,
    ]);

    $authorizationUrl = $provider->getAuthorizationUrl([
        'state' => $ACCOUNT_ID,
        'scope' => ['profile'],
    ]);

    header("Location: $authorizationUrl");
    exit;
    
}