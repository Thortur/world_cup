<?php
declare (strict_types = 1);
namespace worldCup;
use \SendRequete\SendRequete;
header('Content-Type: text/html; charset=UTF-8');
require_once './../app/class/SendRequete/SendRequete.class.php';


if(empty($_POST['modeInscription']) === true) {
    $data = array(
        'pseudo'   => $_POST['pseudo'],
        'password' => $_POST['password'],
    );
    $SendRequete = new SendRequete('loginUser', $data);
    $reponse = $SendRequete->exec();
var_dump($reponse);
    if(empty($reponse) === false) {
        \session_start();
        if(empty($_SESSION['worldCup']) === false) {
            unset($_SESSION['worldCup']);
        }
        $_SESSION['worldCup'] = array(
            'login' => array(
                'id'          => $reponse->id,
                'nom'         => $reponse->nom,
                'prenom'      => $reponse->prenom,
                'pseudo'      => $reponse->pseudo,
                'mail'        => $reponse->mail,
                'mailConfirm' => $reponse->mailConfirm
            )
        );
        header('Location: ./../app/page/home.php');
    }
    else {
        header('Location: ./index.php?error=oui');
    }
}
else {
    $data = array(
        'id'          => -1,
        'nom'         => ucfirst(strtolower($_POST['nom'])),
        'prenom'      => ucfirst(strtolower($_POST['prenom'])),
        'pseudo'      => ucfirst(strtolower($_POST['pseudo'])),
        'password'    => $_POST['password'],
        'mail'        => $_POST['mail'],
        'mailConfirm' => false,
    );
    $SendRequete = new SendRequete('createUser', $data);
    $reponse = $SendRequete->exec();
    
    if(empty($reponse) === false) {
        \session_start();
        
        if(empty($_SESSION['worldCup']) === false) {
            unset($_SESSION['worldCup']);
        }
        $_SESSION['worldCup'] = array(
                'login' => array(
                    'id'          => $reponse->id,
                    'nom'         => $reponse->nom,
                    'prenom'      => $reponse->prenom,
                    'pseudo'      => $reponse->pseudo,
                    'mail'        => $reponse->mail,
                    'mailConfirm' => $reponse->mailConfirm,
                )
        );
        header('Location: ./index.php?confirmMail=oui');
    }
    else {
        header('Location: ./index.php?inscription=oui&error=oui');
    }
}

