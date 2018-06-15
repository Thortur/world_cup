<?php
namespace worldCup;
use \SendRequete\SendRequete;
use \DateTime;
use \DateInterval;
\session_start();

if(empty($_SESSION) === true || empty($_SESSION['worldCup']) === true || empty($_SESSION['worldCup']['login']) === true || empty($_SESSION['worldCup']['login']['id']) === true) {
    header('Location: /public/index.php');
}

header('Content-Type: text/html; charset=UTF-8');
require_once './../../class/SendRequete/SendRequete.class.php';

?>
<!DOCTYPE html>
<html class="loading" lang="fr" data-textdirection="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <link rel="stylesheet" type="text/css" href="/src/bootstrap-4.0.0/css/bootstrap.min.css" id="bootstrap-css">
        <link rel="stylesheet" type="text/css" href="/app/src/css/flag-icon.min.css">
        <link rel="stylesheet" type="text/css" href="/app/src/css/feather.min.css">
        <link rel="stylesheet" type="text/css" href="/app/src/fonts/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="./css/pace.css">
        <link rel="stylesheet" type="text/css" href="./css/bootstrap-extended.css">
        <link rel="stylesheet" type="text/css" href="./css/colors.css">
        <link rel="stylesheet" type="text/css" href="./css/components.css">
        <link rel="stylesheet" type="text/css" href="./css/users.css">
        <link rel="stylesheet" type="text/css" href="/app/src/css/nav.css">
        <link rel="stylesheet" type="text/css" href="./css/home.css">
        <link rel="stylesheet" type="text/css" href="./css/datatables.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
        rel="stylesheet">
    </head>
    <body class="2-columns">
        <?php require_once "./../../src/nav.php"; ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="app-content content">
                <div class="content-wrapper">
                    <div class="content-body">
                        <div class="row match-height">
                            <div class="col-xl-8 col-lg-12">
                            <h3>C'est pas encore fini!!!</h3>
                            <?php
                            // echo $TimeLine->getCardParis($tabMatch);
                            ?>
                            </div>
                            <div class="col-xl-4 col-lg-12">
                            <?php
                            // echo getCardUser($cagnotteRestante);
                            ?>
                            </div>
                        </div>
                        <div class="row match-height">
                            <div class="col-xl-12 col-lg-12">
                            <?php
                            // echo getCardHistoParis($datas);
                            ?>
                            </div>
                        </div>
                        <div class="row match-height">
                            <div class="col-xl-12 col-lg-12">
                            <?php
                            // echo getCardClassement($datas);
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <footer class="footer footer-static footer-light navbar-border">
            <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
            <span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2018 <a class="text-bold-800 grey darken-2" href="#">CHRISTOPHE</a>, All rights reserved. </span>
            <span class="float-md-right d-block d-md-inline-block d-none d-lg-block">Fait avec <i class="ft-heart pink"></i></span>
            </p>
        </footer>
        <script src="./js/vendors.min.js" type="text/javascript"></script>
        <script src="./js/app-menu.js" type="text/javascript"></script>
        <script src="./js/app.js" type="text/javascript"></script>
        <script src="./js/home.js" type="text/javascript"></script>
        <script src="./js/datatables.min.js" type="text/javascript"></script>
        <script src="./js/datatable-styling.js" type="text/javascript"></script>
    </body>
</html>