<?php
require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/includes/database.php';
require_once __DIR__ . '/includes/common.php';

if (!array_key_exists('code', $_GET)) {
    throw new Exception('something-went-wrong:missing-code-parameter');
}

$provider = new \League\OAuth2\Client\Provider\GenericProvider([
    'urlResourceOwnerDetails' => $oauth_resource_owner_details_endpoint_url,
    'urlAccessToken' => $oauth_access_token_endpoint_url,
    'urlAuthorize' => $authorization_url,
    'clientSecret' => $oauth_client_secret,
    'clientId' => $oauth_client_id,
    'redirectUri' => $oauth_redirect_url,
]);

try {
    $access_token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code'],
    ]);
    setcookie($COOKIE_NAME, base64_encode(json_encode([
        'sign' => md5($COOKIE_SECRET),
        'value' => $access_token->__toString(),
        'expiry' => $access_token->getExpires(),
        'login_type' => $VENDASTA_SSO_LOGIN_TYPE,
    ])), $access_token->getExpires(), '', $_SERVER['HTTP_HOST'], true, true);

    $client = new \GuzzleHttp\Client();

    $response = $client->get($oauth_resource_owner_details_endpoint_url, ['headers' => [
        'Authorization' => "Bearer $access_token",
    ]]);

    $data = json_decode($response->getBody());

    $data_from_token_id = json_decode(base64_decode(explode('.', $access_token)[1]));

    if ($data_from_token_id->sub != $data->sub) {
        throw new Exception('something-went-wrong:sub-do-not-match');
    }

    if (is_null($data)
        || !is_object($data)
        || !property_exists($data, 'name')
        || !property_exists($data, 'created_at')) {
        throw new Exception('something-went-wrong:bad-api-response');
    }

    $identifier_hash = md5($data->name . $data->created_at);

    $client_select_result = $link->query("select * from rl_login where email = '$identifier_hash'");

    if (!($client_select_result instanceof mysqli_result)) {
        throw new Exception('something-went-wrong:unexpected-database-query-result');
    }

    $client_rows = $client_select_result->fetch_all(MYSQLI_ASSOC);

    if (count($client_rows) == 0) {

        $admin_select_result = $link->query("select * from rl_login where userType = 'Administrator'");

        if (!($admin_select_result instanceof mysqli_result)) {
            throw new Exception('something-went-wrong:unexpected-database-query-result');
        }

        $admin_rows = $admin_select_result->fetch_all(MYSQLI_ASSOC);

        if (count($admin_rows) == 0) {
            throw new Exception('something-went-wrong:no-admins-found');
        }

        $admin_id = $admin_rows[0]['id'];

        $dateAdded = date('Y-m-d H:i:s');

        $insert_result = $link->query("
            insert into rl_login (userType, email, name, dateAdded, createdBy, sso, zip, status, imgPath)
            values ('Client', '$identifier_hash', '{$data->name}', '$dateAdded', $admin_id, 1, '', 1, '')
        ");

        error_log('888');

        if ($insert_result !== true) {
            throw new Exception('something-went-wrong:unexpected-database-query-result');
        }
    }

    header("Location: $DASHBOARD_PAGE_PATH"."?account_id=".$_COOKIE['account_id']);

    exit;
    
}

catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
    throw new Exception('something-went-wrong:oauth-interrupted');
}