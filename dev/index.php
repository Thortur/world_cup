<?php
namespace worldCup;

use \SendRequete\SendRequete;
header('Content-Type: text/html; charset=UTF-8');
require_once 'SendRequete.class.php';
$SendRequete = new SendRequete('loadDataPageDashBoard', array());
$datas = $SendRequete->exec();
echo '<pre>';
print_r($datas);
echo '</pre>';