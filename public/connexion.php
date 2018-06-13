<?php
declare (strict_types = 1);
namespace worldCup;
use \SendRequete\SendRequete;
header('Content-Type: text/html; charset=UTF-8');
require_once './../app/class/SendRequete/SendRequete.class.php';


if(empty($_POST['modeInscription']) === true) {
    $data = array(
        'pseudo'   => (string)$_POST['pseudo'],
        'password' => (string)$_POST['password'],
    );
    $SendRequete = new SendRequete('loginUser', $data);
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
                'avatar'      => $reponse->avatar,
                'mail'        => $reponse->mail,
                'mailConfirm' => $reponse->mailConfirm
            )
        );
        
        header('Location: ./../app/page/home/index.php');
    }
    else {
        header('Location: ./index.php?error=oui');
    }
}
else {
    $data = array(
        'id'          => -1,
        'nom'         => ucfirst(strtolower((string)$_POST['nom'])),
        'prenom'      => ucfirst(strtolower((string)$_POST['prenom'])),
        'pseudo'      => ucfirst(strtolower((string)$_POST['pseudo'])),
        'avatar'      => (int)$_POST['avatar'],
        'password'    => (string)$_POST['password'],
        'mail'        => (string)$_POST['mail'],
        'mailConfirm' => false,
    );
    
    if (filter_var($data['mail'], FILTER_VALIDATE_EMAIL)) {
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
                        'avatar'      => $reponse->avatar,
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
    else {
        header('Location: ./index.php?inscription=oui&error=oui');
    }
}

