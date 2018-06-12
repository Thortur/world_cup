<?php
declare (strict_types = 1);
namespace worldCup;
\session_start();
use \SendRequete\SendRequete;
header('Content-Type: text/html; charset=UTF-8');
require_once './../../app/class/SendRequete/SendRequete.class.php';

$SendRequete = new SendRequete('loadDataPageGroupe', array());
$datas = $SendRequete->exec();

require_once './../src/header.php';
$tabNavActive['groupe'] = ' active';
require_once './../src/nav.php';

echo '<pre>';
print_r($_SESSION['worldCup']['login']);
print_r(json_encode($_SESSION['worldCup']['login']));
print_r($datas);
echo '</pre>';



require_once './../src/footer.php';