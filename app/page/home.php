<?php
declare (strict_types = 1);
namespace worldCup;	
header('Content-Type: text/html; charset=UTF-8');	

require_once './../fonctions.php';
require_once './../src/header.php';
require_once './../src/nav.php';
for($i = 0; $i<=100;$i++) echo $i.'<br/>';

require_once './../src/footer.php';