<?php

error_reporting(0);

$COOKIE_NAME = 'IDENTITY';
$COOKIE_SECRET = 'abc132';
$HOURS_UNTIL_COOKIE_EXPIRES = 2; // in hours

$LOGIN_PAGE_PATH = '/login/index.php';
$DASHBOARD_PAGE_PATH = '/login/dashboard.php';

$BASIC_LOGIN_TYPE = 'basic';
$VENDASTA_SSO_LOGIN_TYPE = 'vendasta-sso';

$base_url = 'http://' . $_SERVER['HTTP_HOST'];
$website_url = "$base_url/login";

$ACCOUNT_ID = 'AG-2465H6KG2P';
$PRODUCT_ID = 'MP-6KVJZT5MMFPJWQCSQ7H38LBV586Z8X55';
$VENDASTA_DATA_URL = '';

$oauth_client_id = '655e73c4-607b-4b86-a08d-c99de85b36e3';
$oauth_client_secret = 'VlM9izbsB49voikHhQmeiY6YE1nhyes6xzJpL6YNsf';
$authorization_url = 'https://sso-api-prod.apigateway.co/oauth2/auth';
$oauth_redirect_url = "https://theseoreports.com/login/sso-login.php";
$oauth_access_token_endpoint_url = 'https://sso-api-prod.apigateway.co/oauth2/token';
$oauth_resource_owner_details_endpoint_url = 'https://sso-api-prod.apigateway.co/oauth2/user-info';

$date = date('Y-m-d');
$offset = 5 * 60 * 60 + 1800;
$dateFormat = 'Y-m-d H:i:s';
$today = gmdate($dateFormat, time() + $offset);
$message = '';