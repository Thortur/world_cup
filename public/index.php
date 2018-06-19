<?php
//si Prod
if(stripos($_SERVER['SERVER_SOFTWARE'], 'win') === false) {
    //redirection vers https si on arrive sur http
    if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off"){
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirect);
        exit();
    }
}

header('Content-Type: text/html; charset=UTF-8');
session_start();
unset($_SESSION);
session_destroy();

if(empty($_POST['btnPassWordForgot']) === false) {
    $_POST['mailForgot'] = trim($_POST['mailForgot']);
    require_once 'passWordForgot.php';
}

$modeInscription = !empty($_GET['inscription']);

$lienGetLien = '?inscription=oui';
$labelBtn    = 'Inscription';
$labelTitle  = 'Connexion';
$btnAction   = 'Connexion';
$required    = '';
if($modeInscription === true) {
    $lienGetLien = null;
    $labelBtn    = 'Connexion';
    $labelTitle  = 'Inscription';                
    $btnAction   = 'Inscription';
    $required    = 'required';              
}

echo '<!DOCTYPE html>';
echo '<html>';
    echo '<head>';
        echo '<meta charset="UTF-8">';
        // echo '<meta name="viewport" content="width=device-width, maximum-scale=4" >';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
        echo '<title>Pari entre amis</title>';
        echo '<link rel="stylesheet" href="./../src/bootstrap-4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">';
        echo '<link rel="stylesheet" href="./../src/fontawesome-free-5.0.13/web-fonts-with-css/css/fontawesome-all.min.css">';
        echo '<script type="text/javascript" src="./../src/jquery/jquery-3.3.1.min.js"></script>';
        echo '<link rel="stylesheet" href="./css/index.css">';
    echo '</head>';
    echo '<body>';
        echo '<div class="container">';
            echo '<div class="row justify-content-start">';
                echo '<div class="col">';
                    echo '<img id="logoWorldCup" alt="Fichier_FIFA_World_Cup_2018_Logo.png" src="./../src/images/FIFA_World_Cup_2018_Logo.png"/>';
                echo '</div>';
            echo '</div>';
            echo '<div class="row justify-content-start">';
                echo '<div class="col-0 col-sm-3 col-lg-4"></div>';
                echo '<div class="col-12 col-sm-6 col-lg-4">';
                    echo '<div class="card">';
                        echo '<article class="card-body">';
                            echo '<a href="'.$_SERVER['PHP_SELF'].$lienGetLien.'" class="float-right btn btn-outline-primary">'.$labelBtn.'</a>';
                            echo '<h4 class="card-title mb-4 mt-1">'.$labelTitle.'</h4>';
                            unset($lienGetLien, $labelBtn, $labelTitle);
                            echo '<form action="./connexion.php" method="POST" class="needs-validation" novalidate>';
                                echo '<input type="hidden" name="modeInscription" value="'.$modeInscription.'" />';
                                if($modeInscription === true) {
                                    echo '<div class="form-group">';
                                        echo '<label>Votre nom</label>';
                                        echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                                echo '<span class="input-group-text" id="inputGroupPrependNom"> <i class="fa fa-user"></i> </span>';
                                            echo '</div>';
                                            echo '<input name="nom" class="form-control" placeholder="Nom" type="text" '.$required.' aria-describedby="inputGroupPrependNom"/>';
                                            echo '<div class="invalid-tooltip">Veuillez saisir un nom</div>';
                                        echo '</div>';
                                    echo '</div>';
                                    echo '<div class="form-group">';
                                        echo '<label>Votre prénom</label>';
                                        echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                                echo '<span class="input-group-text" id="inputGroupPrependPrenom"> <i class="fa fa-user"></i> </span>';
                                            echo '</div>';
                                            echo '<input name="prenom" class="form-control" placeholder="Prenom" type="text" '.$required.' aria-describedby="inputGroupPrependPrenom"/>';
                                            echo '<div class="invalid-tooltip">Veuillez saisir un prénom</div>';
                                        echo '</div>';
                                    echo '</div>';
                                }
                                echo '<div class="form-group">';
                                    echo '<label>Votre pseudo</label>';
                                    echo '<div class="input-group">';
                                        echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text" id="inputGroupPrependPseudo"> <i class="fa fa-user-ninja"></i> </span>';
                                        echo '</div>';
                                        echo '<input name="pseudo" class="form-control" placeholder="Pseudo" type="text" '.$required.' aria-describedby="inputGroupPrependPseudo"/>';
                                        echo '<div class="invalid-tooltip">Veuillez saisir un pseudo</div>';
                                    echo '</div>';
                                echo '</div>';
                                if($modeInscription === true) {
                                    echo '<div class="form-group">';
                                        echo '<label>Votre avatar</label>';
                                        echo '<div class="input-group">';
                                        $labelProtraitChecked = ' labelProtraitChecked';
                                        $checked = ' checked';
                                            for($i = 1; $i <= 8; $i++) {
                                                echo '<label for="portrait_'.$i.'" class="labelProtrait'.$labelProtraitChecked.'">';
                                                    echo '<input type="radio" name="avatar" id="portrait_'.$i.'" value="'.$i.'" '.$required.' '.$checked.'/>';
                                                    echo '<img src="/src/images/portrait/dessin/'.$i.'.png"/>';
                                                echo '</label>';
                                                $labelProtraitChecked = $checked = '';
                                            }
                                            unset($labelProtraitChecked);
                                            echo '<div class="invalid-tooltip">Veuillez choisir un avatar</div>';
                                        echo '</div>';
                                    echo '</div>';
                                    echo '<div class="form-group">';
                                        echo '<label>Votre e-mail</label>';
                                        echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                                echo '<span class="input-group-text" id="inputGroupPrependMail"> <i class="fa fa-at"></i> </span>';
                                            echo '</div>';
                                            echo '<input name="mail" class="form-control" placeholder="E-mail" type="email" '.$required.' aria-describedby="inputGroupPrependMail"/>';
                                            echo '<div class="invalid-tooltip">Veuillez saisir un e-mail</div>';
                                        echo '</div>';
                                    echo '</div>';
                                }
                                echo '<div class="form-group">';
                                    echo '<label>Votre mot de passe</label>';
                                    echo '<div class="input-group">';
                                        echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text" id="inputGroupPrependPassWord"> <i class="fa fa-lock"></i> </span>';
                                        echo '</div>';
                                        echo '<input name="password" class="form-control" placeholder="******" type="password" '.$required.' aria-describedby="inputGroupPrependPassWord"/>';
                                        echo '<div class="invalid-tooltip">Veuillez saisir un mot de passe</div>';
                                    echo '</div>';
                                    if($modeInscription === false) {
                                        echo '<a class="float-right" href="#" id="lienPassWordforgot">Mot de passe oublié?</a>';
                                    }
                                echo '</div>';
                                if($modeInscription === false) {
                                    echo '<br/>';
                                }
                                else {
                                    echo '<div class="form-group">';
                                        echo '<div class="custom-control custom-checkbox" >';
                                            echo '<input type="checkbox" class="custom-control-input" id="customControlValidationCheckRGPD" name="checkRGPD" '.$required.'>';
                                            echo '<label class="custom-control-label" for="customControlValidationCheckRGPD" >En soumettant ce formulaire, j\'accepte que les informations saisies soient exploitées contre mon gré dans le cadre du jeu et de la relation commerciale qui peut en découler.</label>';
                                            echo '<div class="invalid-tooltip">Veuillez accepter que j\'utilise vos données contre votre gré!</div>';
                                        echo '</div>';
                                    echo '</div>';
                                }
                                echo '<div class="form-group">';
                                    echo '<button type="submit" class="btn btn-primary btn-block">'.$btnAction.'</button>';
                                echo '</div>';
                                unset($btnAction);                                    
                            echo '</form>';
                        echo '</article>';
                    echo '</div>';
                echo '</div>';
                echo '<div class="col-0 col-sm-3 col-lg-4"></div>';
            echo '</div>';
        echo '</div>';
        
        if(empty($_GET['error']) === false) {
            echo '<div class="modal" id="modalError" tabindex="-1" role="dialog">';
                echo '<div class="modal-dialog" role="document">';
                    echo '<div class="modal-content">';
                        echo '<div class="modal-header">';
                            echo '<h5 class="modal-title">La connexion a échoué</h5>';
                            echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                                echo '<span aria-hidden="true">&times;</span>';
                            echo '</button>';
                        echo '</div>';
                        echo '<div class="modal-body">';
                            echo '<p>Etes vous sur de votre login et de votre mot de passe?</p>';
                        echo '</div>';
                        echo '<div class="modal-footer">';
                            echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            ?>
            <script type="text/javascript" >
                $(document).ready(function() {
                    $('#modalError').modal('show');
                });
            </script>
            <?php
        }
        if(empty($_GET['confirmMail']) === false) {
            echo '<div class="modal" id="modalMailConfirm" tabindex="-1" role="dialog">';
                echo '<div class="modal-dialog" role="document">';
                    echo '<div class="modal-content">';
                        echo '<div class="modal-header">';
                            echo '<h5 class="modal-title">Confirmation de l\'adresse mail</h5>';
                            echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                                echo '<span aria-hidden="true">&times;</span>';
                            echo '</button>';
                        echo '</div>';
                        echo '<div class="modal-body">';
                            echo '<p>Un mail vient de vous être envoyé pour confimer votre adresse mail.</p>';
                        echo '</div>';
                        echo '<div class="modal-footer">';
                            echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            ?>
            <script type="text/javascript" >
                $(document).ready(function() {
                    $('#modalMailConfirm').modal('show');
                });
            </script>
            <?php
        }

        echo '<form action=".'.$_SERVER['PHP_SELF'].'" method="POST">';
            echo '<div class="modal" id="modalPassWord" tabindex="-1" role="dialog">';
                echo '<div class="modal-dialog" role="document">';
                    echo '<div class="modal-content">';
                        echo '<div class="modal-header">';
                            echo '<h5 class="modal-title">Mot de passe Oublié</h5>';
                            echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                                echo '<span aria-hidden="true">&times;</span>';
                            echo '</button>';
                        echo '</div>';
                        echo '<div class="modal-body">';
                            echo '<div class="form-group">';
                                echo '<label>Votre e-mail</label>';
                                echo '<div class="input-group">';
                                    echo '<div class="input-group-prepend">';
                                        echo '<span class="input-group-text"> <i class="fa fa-at"></i> </span>';
                                    echo '</div>';
                                    echo '<input name="mailForgot" class="form-control" placeholder="E-mail" type="mail" />';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="modal-footer">';
                            echo '<input type="submit" name="btnPassWordForgot" class="btn btn-primary" value="Renvoi moi un mot de passe" />';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</form>';
        ?>
        <script type="text/javascript" >
            $(document).ready(function() {
                $('#lienPassWordforgot').on('click', function() {
                    $('#modalPassWord').modal('show');
                });
            });
        </script>
        <?php
        echo '<script type="text/javascript" src="./../src/bootstrap-4.0.0/js/bootstrap.min.js"></script>';
        echo '<script type="text/javascript" src="./js/index.js"></script>';
    echo '</body>';
echo '</html>';