<?php

require_once __DIR__ . '/includes/common.php';

if (array_key_exists($COOKIE_NAME, $_COOKIE) && $_COOKIE[$COOKIE_NAME] != '') {
    setcookie($COOKIE_NAME, '');
}

header("Location: $LOGIN_PAGE_PATH");