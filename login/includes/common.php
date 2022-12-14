<?php

error_reporting(0);

$COOKIE_NAME = 'IDENTITY';
$COOKIE_SECRET = 'abc132';
$HOURS_UNTIL_COOKIE_EXPIRES = 2; // in hours

$LOGIN_PAGE_PATH = '/login/index.php';
$DASHBOARD_PAGE_PATH = '/login/dashboard.php';

$BASIC_LOGIN_TYPE = 'basic';
$VENDASTA_SSO_LOGIN_TYPE = 'vendasta-sso';

$base_url = 'https://' . $_SERVER['HTTP_HOST'];
$website_url = "$base_url/login";

$ACCOUNT_ID = 'AG-H5ZDNTTPP6';
$PRODUCT_ID = 'MP-HB4MBV4S5RFBM2Z7MQC6VSBZD2JB4WLJ';
$VENDASTA_DATA_URL = '';

$oauth_client_id = 'a7d042a7-20ff-4bb9-92f4-7c7af826fc61';
$oauth_client_secret = '3Xelv8FoDF0V6Ex1wZHooQjUfzQ13Q6UbUXM3coyTr';
$authorization_url = 'https://sso-api-prod.apigateway.co/oauth2/auth';
$oauth_redirect_url = "$base_url/login/sso-login.php";
$oauth_access_token_endpoint_url = 'https://sso-api-prod.apigateway.co/oauth2/token';
$oauth_resource_owner_details_endpoint_url = 'https://sso-api-prod.apigateway.co/oauth2/user-info';

$date = date('Y-m-d');
$offset = 5 * 60 * 60 + 1800;
$dateFormat = 'Y-m-d H:i:s';
$today = gmdate($dateFormat, time() + $offset);
$message = '';