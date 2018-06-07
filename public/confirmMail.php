<?php
declare (strict_types = 1);
namespace worldCup;
use \SendRequete\SendRequete;
header('Content-Type: text/html; charset=UTF-8');
require_once './../app/class/SendRequete/SendRequete.class.php';


echo '<!DOCTYPE html>';
echo '<html>';
    echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<title>Pari en amis</title>';
        echo '<link href="./../src/bootstrap-4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">';
        echo '<link rel="stylesheet" href="./../src/fontawesome-free-5.0.13/web-fonts-with-css/css/fontawesome-all.min.css">';
        echo '<script type="text/javascript" src="./../src/jquery/jquery-3.3.1.min.js"></script>';
    echo '</head>';
    echo '<body>';
        echo '<div class="container">';
            $reponse = null;
            if(empty($_GET['id']) === false && empty($_GET['mail']) === false) {
                $data = array(
                    'id'   => $_GET['id'],
                    'mail' => $_GET['mail'],
                );
                $SendRequete = new SendRequete('confirmMail', $data);
                $reponse = $SendRequete->exec();
            }

            if($reponse === true) {
                echo '<div class="alert alert-success" role="alert">';
                    echo 'Votre mail a bien été confirmé, vous pouvez vous connecter.<br/><a href="http://worldcup.lefevrechristophe.fr" >Vite vite vite je me connecte!</a>';
                echo '</div>';
            }
            else {
                echo '<div class="alert alert-danger" role="alert">';
                    echo 'Une erreur est survenu. Réessayer  ou contact le webMaster : <a href="mailto:lefevre.christophe@outlook.com" >Help!</a>';
                echo '</div>';
            }
        echo '</div>';
    echo '</body>';
echo '</html>';

