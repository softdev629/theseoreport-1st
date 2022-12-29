<?php

$cookie = json_decode(base64_decode($_COOKIE[$COOKIE_NAME]));
if (!is_object($cookie)
    || !property_exists($cookie, 'sign')
    || !property_exists($cookie, 'login_type')) {
    throw new Exception('something-went-wrong:malformed-cookie');
}

if ($cookie->sign != md5($COOKIE_SECRET)) {
    throw new Exception('something-went-wrong:invalid-cookie-signature');
}

/** @var mysqli $link */

/** @var \mysqli_result|bool $result */
$result = null;

if ($cookie->login_type == $BASIC_LOGIN_TYPE) {

    if (!property_exists($cookie, 'id')) {
        throw new Exception('something-went-wrong:malformed-cookie');
    }

    /** @var mysqli $link */
    $result = $link->query("select * from rl_login where id='{$cookie->id}' and status=1");

}

if ($cookie->login_type == $VENDASTA_SSO_LOGIN_TYPE) {

    require_once dirname(__DIR__) . '/vendor/autoload.php';

    $client = new \GuzzleHttp\Client();

    $response = $client->get($oauth_resource_owner_details_endpoint_url, ['headers' => [
        'Authorization' => "Bearer {$cookie->value}",
    ]]);
    
    $data = json_decode($response->getBody());

    $data_from_token_id = json_decode(base64_decode(explode('.', $cookie->value)[1]));

    if ($data_from_token_id->sub != $data->sub) {
        throw new Exception('something-went-wrong:subs-do-not-match');
    }

    if (is_null($data)
        || !is_object($data)
        || !property_exists($data, 'name')
        || !property_exists($data, 'created_at')) {
        throw new Exception('something-went-wrong:api-bad-response');
    }

    $VENDASTA_DATA_URL = $data->product_navbar_data_url;

    $identifier_hash = md5($data->name . $data->created_at);

    $result = $link->query("select * from rl_login where email = '$identifier_hash'");

}

if (!($result instanceof mysqli_result)) {
    throw new Exception('something-went-wrong:unexpected-database-query-result');
}

$rows = $result->fetch_all(MYSQLI_ASSOC);

if (count($rows) == 0) {
    throw new Exception('something-went-wrong:user-does-not-exist');
}

$user = $rows[0];

$_SESSION['username'] = $user['email'];
$_SESSION['UID'] = $user['id'];
$_SESSION['name'] = $user['name'];
$_SESSION['usertype'] = $user['userType'];
$_SESSION['loginType'] = $_COOKIE['login-type'];
$_SESSION['account_id'] = $_COOKIE['account_id'];