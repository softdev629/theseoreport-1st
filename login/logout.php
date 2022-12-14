<?php

require_once __DIR__ . '/includes/common.php';

setcookie($COOKIE_NAME, '', -1);

header("Location: $LOGIN_PAGE_PATH");