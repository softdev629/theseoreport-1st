<?php

require_once __DIR__ . '/includes/common.php';

setcookie($COOKIE_NAME, '[logged-out]', -1, '', $_SERVER['HTTP_HOST'], true, true);

header("Location: $LOGIN_PAGE_PATH");