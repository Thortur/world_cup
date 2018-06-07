<?php
require_once 'fonctions.php';

if(empty($_POST['mailForgot']) === false) {
    $ch = curl_init();
    $data = array(
        'mail' => $_POST['mailForgot'],
    );
    curl_setopt_array($ch, array(
                                CURLOPT_URL            => getUrlData('resetPassWord'),
                                CURLOPT_POST           => count($data),
                                CURLOPT_POSTFIELDS     => http_build_query($data),
                                CURLOPT_RETURNTRANSFER => true,
                            ));
    $reponse = curl_exec($ch);
    curl_close($ch);
}
