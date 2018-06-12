<?php
declare (strict_types = 1);
namespace worldCup;
header('Content-Type: text/html; charset=UTF-8');

require_once './../src/header.php';
$tabNavActive['home'] = ' active';
require_once './../src/nav.php';
\session_start();









require_once './../src/footer.php';