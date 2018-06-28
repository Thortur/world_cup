<?php
namespace WorldCup;
use \SendRequete\SendRequete;
use \DateTime;
use \DateInterval;
\session_start();

if(empty($_SESSION) === true || empty($_SESSION['worldCup']) === true || empty($_SESSION['worldCup']['login']) === true || empty($_SESSION['worldCup']['login']['id']) === true) {
    header('Location: /public/index.php');
}

header('Content-Type: text/html; charset=UTF-8');
require_once './../../class/SendRequete/SendRequete.class.php';
require_once './class/TimeLine.class.php';
require_once './class/CardClassement.class.php';
require_once './class/CardHistoParis.class.php';
require_once './class/CardUser.class.php';
require_once './class/CardGraph.class.php';

if(empty($_POST) === false) {
    if(empty($_POST['btnVaildPari']) === false && empty($_POST['pari']) === false) {
        $dateNow = new DateTime();
        $SendRequete = new SendRequete('insertPari', array(
            'idMatch'    => (int)$_POST['pari']['match'],
            'idTypePari' => (int)$_POST['pari']['type'],
            'idUser'     => (int)$_SESSION['worldCup']['login']['id'],
            'idCotes'    => (int)$_POST['pari']['cote'],
            'montant'    => (float)$_POST['pari']['montant'],
            'date'       => $dateNow->format('Y-m-d H:i:s'),
        ));
        $SendRequete->exec();
    }
    else if(empty($_POST['btnVaildResultat']) === false && empty($_POST['resultat']) === false) {
        $SendRequete = new SendRequete('saveResultatMatch', array(
            'idMatch'    => (int)$_POST['resultat']['match'],
            'idTeamA'    => (int)$_POST['resultat']['idTeamA'],
            'scoreTeamA' => (int)$_POST['resultat']['scoreA'],
            'idTeamB'    => (int)$_POST['resultat']['idTeamB'],
            'scoreTeamB' => (int)$_POST['resultat']['scoreB'],
        ));
        $SendRequete->exec();
    }
}

$SendRequete = new SendRequete('loadDataPageDashBoard', array());
$datas       = $SendRequete->exec();


$cagnotteRestante = 0;
$idUserConnecter = $_SESSION['worldCup']['login']['id'];
if(is_array($datas->listCagnotte->$idUserConnecter) === true && empty($datas->listCagnotte->$idUserConnecter) === false) {
    $cagnotteRestante = (float)getCagnottesUser($datas->listCagnotte->$idUserConnecter);
}


$TimeLine       = new TimeLine($idUserConnecter, $datas, $cagnotteRestante);
$CardClassement = new CardClassement($idUserConnecter, $datas);
$CardHistoParis = new CardHistoParis($idUserConnecter, $datas);
$CardUser       = new CardUser($idUserConnecter, $datas, $cagnotteRestante);
$CardGraph      = new CardGraph($idUserConnecter, $datas);

function getCagnottesUser(array $listCagnotte) {
    $montant = 0;
    if(empty($listCagnotte) === false) {
        foreach($listCagnotte as $cagnotte) {
            $montant += $cagnotte->montant;
        }
        unset($cagnotte);
    }

    return $montant;
}


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
        <link rel="stylesheet" type="text/css" href="./css/timeline.css">
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
                            <?php
                            echo $TimeLine->getCardParis($tabMatch);
                            ?>
                            </div>
                            <div class="col-xl-4 col-lg-12">
                            <?php
                            echo $CardUser->getCard($datas);
                            ?>
                            </div>
                        </div>
                        <div class="row match-height">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header card-head-inverse bg-blue">
                                        <h4 class="card-title">Graphique des cagnottes</h4>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body chartjs">
                                            <canvas id="area-chart" height="500"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row match-height">
                            <div class="col-xl-12 col-lg-12">
                            <?php
                            echo $CardHistoParis->getCard();
                            ?>
                            </div>
                        </div>
                        <div class="row match-height">
                            <div class="col-xl-12 col-lg-12">
                            <?php
                            echo $CardClassement->getCard();
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
        <script type="text/javascript">
            var chartData = {
                labels: [<?php echo $CardGraph->dataGraphDraw['label']; ?>],
                datasets: [{
                    label: "Moyenne des cagnottes",
                    data: [<?php echo $CardGraph->dataGraphDraw['moyenne']; ?>],
                    backgroundColor: "rgba(209,212,219,.4)",
                    borderColor: "transparent",
                    pointBorderColor: "#D1D4DB",
                    pointBackgroundColor: "#FFF",
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                }, {
                    label: "Votre cagnotte personnelle",
                    data: [<?php echo $CardGraph->dataGraphDraw['perso']; ?>],
                    backgroundColor: "rgba(81,117,224,.7)",
                    borderColor: "transparent",
                    pointBorderColor: "#5175E0",
                    pointBackgroundColor: "#FFF",
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                }]
            };
        </script>
        <script src="./js/vendors.min.js" type="text/javascript"></script>
        <script src="./js/horizontal-timeline.js" type="text/javascript"></script>
        <script src="./js/app-menu.js" type="text/javascript"></script>
        <script src="./js/app.js" type="text/javascript"></script>
        <script src="./js/home.js" type="text/javascript"></script>
        <script src="./js/datatables.min.js" type="text/javascript"></script>
        <script src="./js/datatable-styling.js" type="text/javascript"></script>
        <script src="./js/chart.min.js" type="text/javascript"></script>
    </body>
</html>