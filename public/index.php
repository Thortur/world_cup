<?php
header('Content-Type: text/html; charset=UTF-8');

if(empty($_POST['btnPassWordForgot']) === false) {
    $_POST['mailForgot'] = trim($_POST['mailForgot']);
    require_once 'passWordForgot.php';
}

$modeInscription = !empty($_GET['inscription']);

$lienGetLien = '?inscription=oui';
$labelBtn    = 'Inscription';
$labelTitle  = 'Connexion';
$btnAction   = 'Connexion';
if($modeInscription === true) {
    $lienGetLien = null;
    $labelBtn    = 'Connexion';
    $labelTitle  = 'Inscription';                
    $btnAction   = 'Inscription';                
}

echo '<!DOCTYPE html>';
echo '<html>';
    echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<title>Title of the document</title>';
        echo '<link href="./../src/bootstrap-4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">';
        echo '<link rel="stylesheet" href="./../src/fontawesome-free-5.0.13/web-fonts-with-css/css/fontawesome-all.min.css">';
        echo '<script type="text/javascript" src="./../src/jquery/jquery-3.3.1.min.js"></script>';
    echo '</head>';
    echo '<body>';
        echo '<div class="container">';
            echo '<div class="row">';
                echo '<div class="col"></div>';
                echo '<div class="col-5">';
                    echo '<div class="card">';
                        echo '<article class="card-body">';
                            echo '<a href="'.$_SERVER['PHP_SELF'].$lienGetLien.'" class="float-right btn btn-outline-primary">'.$labelBtn.'</a>';
                            echo '<h4 class="card-title mb-4 mt-1">'.$labelTitle.'</h4>';
                            unset($lienGetLien, $labelBtn, $labelTitle);
                            echo '<form action="./connexion.php" method="POST">';
                                echo '<input type="hidden" name="modeInscription" value="'.$modeInscription.'" />';
                                if($modeInscription === true) {
                                    echo '<div class="form-group">';
                                        echo '<label>Votre nom</label>';
                                        echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                                echo '<span class="input-group-text"> <i class="fa fa-user"></i> </span>';
                                            echo '</div>';
                                            echo '<input name="nom" class="form-control" placeholder="Nom" type="text" />';
                                        echo '</div>';
                                    echo '</div>';
                                    echo '<div class="form-group">';
                                        echo '<label>Votre prénom</label>';
                                        echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                                echo '<span class="input-group-text"> <i class="fa fa-user"></i> </span>';
                                            echo '</div>';
                                            echo '<input name="prenom" class="form-control" placeholder="Prenom" type="text" />';
                                        echo '</div>';
                                    echo '</div>';
                                }
                                echo '<div class="form-group">';
                                    echo '<label>Votre pseudo</label>';
                                    echo '<div class="input-group">';
                                        echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text"> <i class="fa fa-user"></i> </span>';
                                        echo '</div>';
                                        echo '<input name="pseudo" class="form-control" placeholder="Pseudo" type="Pseudo" />';
                                    echo '</div>';
                                echo '</div>';
                                if($modeInscription === true) {
                                    echo '<div class="form-group">';
                                        echo '<label>Votre e-mail</label>';
                                        echo '<div class="input-group">';
                                            echo '<div class="input-group-prepend">';
                                                echo '<span class="input-group-text"> <i class="fa fa-at"></i> </span>';
                                            echo '</div>';
                                            echo '<input name="mail" class="form-control" placeholder="E-mail" type="mail" />';
                                        echo '</div>';
                                    echo '</div>';
                                }
                                echo '<div class="form-group">';
                                    echo '<label>Votre mot de passe</label>';
                                    echo '<div class="input-group">';
                                        echo '<div class="input-group-prepend">';
                                            echo '<span class="input-group-text"> <i class="fa fa-lock"></i> </span>';
                                        echo '</div>';
                                        echo '<input name="password" class="form-control" placeholder="******" type="password"/>';
                                    echo '</div>';
                                    if($modeInscription === false) {
                                        echo '<a class="float-right" href="#" id="lienPassWordforgot">Mot de passe oublié?</a>';
                                    }
                                echo '</div>';
                                if($modeInscription === false) {
                                    // echo '<div class="form-group">';
                                    //     echo '<div class="checkbox">';
                                    //         echo '<label> <input type="checkbox"> Save password</label>';
                                    //     echo '</div>';
                                    // echo '</div>';
                                    echo '<br/>';
                                }
                                else {
                                    echo '<div class="form-group">';
                                        echo '<div class="checkbox" >';
                                            echo '<label style="cursor:pointer;"> <input type="checkbox"> En soumettant ce formulaire, j\'accepte que les informations saisies soient exploitées contre mon gré dans le cadre du jeu et de la relation commerciale qui peut en découler.</label>';
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
                echo '<div class="col"></div>';
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

        echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST">';
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
                            echo '<input type="submit" name="btnPassWordForgot" class="btn btn-primary" value="Renvoi moi un mot de passe" />"';
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
    echo '</body>';
echo '</html>';