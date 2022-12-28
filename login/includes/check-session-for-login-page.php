<?php

if (!array_key_exists($COOKIE_NAME, $_COOKIE) || $_COOKIE[$COOKIE_NAME] == '[logged-out]') {
    return;
}

$cookie = json_decode(base64_decode($_COOKIE[$COOKIE_NAME]));

if (!is_object($cookie)
    || !property_exists($cookie, 'expiry')) {
    throw new Exception('something-went-wrong:malformed-cookie');
}

if (time() < $cookie->expiry) {
    header("Location: $DASHBOARD_PAGE_PATH"."?account_id=".$_COOKIE['account_id']);
    exit;
}