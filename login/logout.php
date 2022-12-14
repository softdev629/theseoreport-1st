<?php

require_once __DIR__ . '/includes/common.php';

setcookie($COOKIE_NAME, '[logged-out]');

header("Location: $LOGIN_PAGE_PATH");