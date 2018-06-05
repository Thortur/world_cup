<?php
declare (strict_types = 1);
namespace worldCup;
header('Content-Type: text/html; charset=UTF-8');
require_once 'fonctions.php';


if(empty($_POST['modeInscription']) === true) {
    $data = array(
        'pseudo'   => $_POST['pseudo'],
        'password' => $_POST['password'],
    );
    $ch = curl_init();
    curl_setopt_array($ch, array(
                                CURLOPT_URL            => getUrlData('loginUser'),
                                CURLOPT_POST           => count($data),
                                CURLOPT_POSTFIELDS     => http_build_query($data),
                                CURLOPT_RETURNTRANSFER => true,
                            ));
    $reponse = curl_exec($ch);
    curl_close($ch);
    if(empty($reponse) === false) {
        $reponse = \json_decode($reponse);
        \session_start();
        if(empty($_SESSION['worldCup']) === false) {
            unset($_SESSION['worldCup']);
        }
        $_SESSION['worldCup'] = array(
            'login' => array(
                'id'     => $reponse->id,
                'nom'    => $reponse->nom,
                'prenom' => $reponse->prenom,
                'pseudo' => $reponse->pseudo,
                'mail'   => $reponse->mail
            )
        );
        header('Location: home.php');
    }
    else {
        header('Location: index.php?error=oui');
    }
}
else {
    $data = array(
        'id'       => -1,
        'nom'      => $_POST['nom'],
        'prenom'   => $_POST['prenom'],
        'pseudo'   => $_POST['pseudo'],
        'password' => $_POST['password'],
        'mail'     => $_POST['mail'],
    );
    
    $ch = curl_init();
    curl_setopt_array($ch, array(
                                CURLOPT_URL            => getUrlData('createUser'),
                                CURLOPT_POST           => count($data),
                                CURLOPT_POSTFIELDS     => http_build_query($data),
                                CURLOPT_RETURNTRANSFER => true,
                            ));
    $reponse = curl_exec($ch);
    curl_close($ch);
    echo $reponse;
    if(empty($reponse) === false) {
        $reponse = \json_decode($reponse);
        \session_start();
        
        if(empty($_SESSION['worldCup']) === false) {
            unset($_SESSION['worldCup']);
        }
        $_SESSION['worldCup'] = array(
                'login' => array(
                'id'     => $reponse->id,
                'nom'    => $reponse->nom,
                'prenom' => $reponse->prenom,
                'pseudo' => $reponse->pseudo,
                'mail'   => $reponse->mail
            )
        );
        header('Location: home.php');
    }
    else {
        header('Location: index.php?inscription=oui&error=oui');
    }
}

