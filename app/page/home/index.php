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
require_once './class/TimeLine.class.php';

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
        $datas = $SendRequete->exec();
    }
}

$SendRequete = new SendRequete('loadDataPageDashBoard', array());
$datas       = $SendRequete->exec();


$cagnotteRestante = 0;
$idUserConnecter = $_SESSION['worldCup']['login']['id'];
if(is_array($datas->listCagnotte->$idUserConnecter) === true && empty($datas->listCagnotte->$idUserConnecter) === false) {
    $cagnotteRestante = getCagnottesUser($datas->listCagnotte->$idUserConnecter);
}
unset($idUserConnecter);

$TimeLine = new TimeLine($_SESSION['worldCup']['login']['id'], $datas, $cagnotteRestante);
$tabMatch = $TimeLine->getTabMatch();

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
function getCardUser(float $cagnotteRestante) {
    $html = '<div class="card text-center profile-card-with-stats">';
        $html .= '<div class="card-header card-head-inverse bg-blue">';
            $html .= '<h4 class="card-title">Votre profil</h4>';
        $html .= '</div>';
        $html .= '<div class="text-center">
            <div class="card-profile-image">
                <img src="/src/images/portrait/dessin/'.$_SESSION['worldCup']['login']['avatar'].'.png" class="rounded-circle img-border box-shadow-1 mt-3" alt="Card image">
            </div>
            <div class="card-body">
                <h4 class="card-title">@'.$_SESSION['worldCup']['login']['pseudo'].'</h4>
                <ul class="list-inline list-inline-pipe">
                    <li>Groupe1</li>
                    <li>Misterbooking</li>
                    <li>Groupe3</li>
                </ul>
                <h6 class="card-subtitle text-muted">'.$cagnotteRestante.' €</h6>
            </div>
            <div class="btn-group" role="group" aria-label="Profile example">
                <button type="button" class="btn btn-float box-shadow-0 btn-outline-info" data-toggle="tooltip" data-placement="bottom"
                title="Nombre de paris réussis">
                    <span class="ladda-label"><i class="fa fa-bar-chart"></i>
                        <span>0/0</span>
                    </span>
                    <span class="ladda-spinner"></span>
                </button>
                <button type="button" class="btn btn-float box-shadow-0 btn-outline-info" data-toggle="tooltip" data-placement="bottom"
                title="Plus grande côte misée">
                    <span class="ladda-label"><i class="fa fa-trophy"></i>
                        <span>1</span>
                    </span>
                    <span class="ladda-spinner"></span>
                </button>
                <button type="button" class="btn btn-float box-shadow-0 btn-outline-info" data-toggle="tooltip" data-placement="bottom"
                title="Plus grande somme gagnée sur un pari">
                    <span class="ladda-label"><i class="fa fa-money"></i>
                        <span>0</span>
                    </span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-outline-danger btn-md mr-1"><i class="fa fa-plus"></i> Passer Premium</button>
                <button type="button" class="btn btn-outline-primary btn-md mr-1"><i class="ft-user"></i> Voir le profil</button>
            </div>
        </div>
    </div>
    ';

    return $html;
}
function getCardHistoParis(object $datas) {
    // echo '<pre>'.print_r($datas->listCotesHisto,true).'</pre>';
    // echo '<pre>'.print_r($tabMatch,true).'</pre>';

    if(is_array($datas->listTeam) && empty($datas->listTeam) === false) {
        foreach($datas->listTeam as $team) {
            $tabTeam[$team->id] = array(
                'nom'  => $team->nom,
                'iso2' => $team->iso2,
            );
        }
        unset($team);
    }

    if(is_array($datas->listMatch) && empty($datas->listMatch) === false) {
        foreach($datas->listMatch as $v_match) {
            $idMatch = $v_match->id;
            $idTeamA = $v_match->teamA;
            $idTeamB = $v_match->teamB;
            $idTypePari = 1;
            $coteNul = 0;

            $tabMatch[$idMatch] = array(
                'date'       => new DateTime($v_match->date),
                'idTeamA'    => $idTeamA,
                'equipeA'    => $tabTeam[$idTeamA]['nom'],
                'flagA'      => $tabTeam[$idTeamA]['iso2'],
                'idTeamB'    => $idTeamB,
                'equipeB'    => $tabTeam[$idTeamB]['nom'],
                'flagB'      => $tabTeam[$idTeamB]['iso2'],
                'typeMatch'  => $tabGroupe[$v_match->idGroupeMatch]['nom'],
                'coteA'      => $datas->listCotesLast->$idMatch->$idTypePari->$idTeamA->cote,
                'idCoteA'    => $datas->listCotesLast->$idMatch->$idTypePari->$idTeamA->id,
                'coteB'      => $datas->listCotesLast->$idMatch->$idTypePari->$idTeamB->cote,
                'idCoteB'    => $datas->listCotesLast->$idMatch->$idTypePari->$idTeamB->id,
                'coteNul'    => $datas->listCotesLast->$idMatch->$idTypePari->$coteNul->cote,
                'idCoteNull' => $datas->listCotesLast->$idMatch->$idTypePari->$coteNul->id,
            );
            unset($idTeamA, $idTeamB, $idTypePari, $coteNul);
            unset($idMatch);
        }
    }

    unset($tabHistoPari);
    if(is_array($datas->listPari)) {
        foreach($datas->listPari as $k_pari => $v_pari) {
            if($v_pari->idUser === $_SESSION['worldCup']['login']['id']) {
                $tabHistoPari[$v_pari->id] = $v_pari;
            }
        }
    }
    // echo '<pre>'.print_r($tabHistoPari,true).'</pre>';

    $html = '<div class="card">';
        $html .= '<div class="card-header card-head-inverse bg-blue"">';
            $html .= '<h4 class="card-title">VOS PARIS REALISES</h4>';
        $html .= '</div>';
        $html .= '<div class="card-content collapse show">';
            $html .= '<div class="card-body card-dashboard">';
                $html .= '<table class="table table-striped table-bordered base-style">';
                    $html .= '<thead>';
                        $html .= '<tr>';
                            $html .= '<th>Match</th>';
                            $html .= '<th>Mise</th>';
                            $html .= '<th>Choix</th>';
                            $html .= '<th>Cote</th>';
                            $html .= '<th>Résultat</th>';
                            $html .= '<th>Date</th>';
                        $html .= '</tr>';
                    $html .= '</thead>';
                    $html .= '<tbody>';
                        if(is_array($tabHistoPari)) {
                            foreach($tabHistoPari as $k_pari => $v_pari) {
                                $idCote = $v_pari->idCotes;
                                $html .= '<tr>';
                                    $html .= '<td>'.$tabMatch[$v_pari->idMatch]['equipeA'].' - '.$tabMatch[$v_pari->idMatch]['equipeB'].'</td>';
                                    $html .= '<td>'.$v_pari->montant.'</td>';
                                    $html .= '<td><img class="flag" src="/app/src/flags/4x3/'.$tabTeam[$datas->listCotesHisto->$idCote->idTeam]['iso2'].'.svg" style="width:20px;border:1px solid black;margin-right:1px;"></td>';
                                    $html .= '<td>'.number_format($datas->listCotesHisto->$idCote->cote,2,'.','').'</td>';
                                    $html .= '<td>'.$v_pari->gain.'</td>';
                                    $html .= '<td>'.$v_pari->date.'</td>';
                                $html .= '</tr>';
                            }
                        }
                    $html .= '</tbody>';
                       $html .= '<tfoot>';
                        $html .= '<tr>';
                            $html .= '<th>Match</th>';
                            $html .= '<th>Mise</th>';
                            $html .= '<th>Choix</th>';
                            $html .= '<th>Cote</th>';
                            $html .= '<th>Résultat</th>';
                            $html .= '<th>Date</th>';
                        $html .= '</tr>';
                    $html .= '</tfoot>';
                $html .= '</table>';
            $html .= '</div>';
        $html .= '</div>';
    $html .= '</div>';

    return $html;
}
function getCardClassement(object $datas) {
    // echo '<pre>';print_r($datas->listCagnotte);echo '</pre>';

    if(is_object($datas->listCagnotte)) {
        foreach($datas->listCagnotte as $k_cagnotte => $v_cagnotte) {
            $zero = $v_cagnotte[0];
            $tabCagnotte[$zero->idUser]['montant'] = $zero->montant;
        }
    }
    // echo '<pre>';print_r($tabCagnotte);echo '</pre>';

    $html = '<div class="card">';
        $html .= '<div class="card-header card-head-inverse bg-blue"">';
            $html .= '<h4 class="card-title">CLASSEMENT</h4>';
        $html .= '</div>';
        $html .= '<div class="card-content collapse show">';
            $html .= '<div class="card-body card-dashboard">';
                $html .= '<table class="table table-striped table-bordered base-style">';
                    $html .= '<thead>';
                        $html .= '<tr>';
                            $html .= '<th>Avatar</th>';
                            $html .= '<th>Joueur</th>';
                            $html .= '<th>Cagnotte</th>';
                            $html .= '<th>Paris gagnés</th>';
                            $html .= '<th>Total côtes</th>';
                            $html .= '<th>Total des mises</th>';
                        $html .= '</tr>';
                    $html .= '</thead>';
                    $html .= '<tbody>';
                        if(is_array($tabCagnotte)) {
                            foreach($tabCagnotte as $k_user => $v_user) {
                                $html .= '<tr>';
                                    $html .= '<td><span class="avatar"><img src="/src/images/portrait/dessin/'.$_SESSION['worldCup']['login']['avatar'].'.png" alt="avatar"><i></i></span></td>';
                                    $html .= '<td>'.$_SESSION['worldCup']['login']['pseudo'].'</td>';
                                    $html .= '<td>'.$v_user['montant'].'</td>';
                                    $html .= '<td>0</td>';
                                    $html .= '<td>1</td>';
                                    $html .= '<td>0</td>';
                                $html .= '</tr>';
                            }
                        }
                    $html .= '</tbody>';
                       $html .= '<tfoot>';
                        $html .= '<tr>';
                            $html .= '<th>Avatar</th>';
                            $html .= '<th>Joueur</th>';
                            $html .= '<th>Cagnotte</th>';
                            $html .= '<th>Paris gagnés</th>';
                            $html .= '<th>Total côtes</th>';
                            $html .= '<th>Total des mises</th>';
                        $html .= '</tr>';
                    $html .= '</tfoot>';
                $html .= '</table>';
            $html .= '</div>';
        $html .= '</div>';
    $html .= '</div>';

    return $html;
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
                            echo getCardUser($cagnotteRestante);
                            ?>
                            </div>
                        </div>
                        <div class="row match-height">
                            <div class="col-xl-12 col-lg-12">
                            <?php
                            echo getCardHistoParis($datas);
                            ?>
                            </div>
                        </div>
                        <div class="row match-height">
                            <div class="col-xl-12 col-lg-12">
                            <?php
                            echo getCardClassement($datas);
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
        <script src="./js/horizontal-timeline.js" type="text/javascript"></script>
        <script src="./js/app-menu.js" type="text/javascript"></script>
        <script src="./js/app.js" type="text/javascript"></script>
        <script src="./js/home.js" type="text/javascript"></script>
        <script src="./js/datatables.min.js" type="text/javascript"></script>
        <script src="./js/datatable-styling.js" type="text/javascript"></script>
    </body>
</html>