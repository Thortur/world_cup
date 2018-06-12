<?php
namespace worldCup;
use \SendRequete\SendRequete;
use \DateTime;
use \DateInterval;
\session_start();

header('Content-Type: text/html; charset=UTF-8');
require_once './../../class/SendRequete/SendRequete.class.php';
require_once './class/TimeLine.class.php';

if(empty($_POST) === false) {
    echo '<br/<br/><br/><br/><br/>';
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
$TimeLine    = new TimeLine($datas);
$tabMatch    = $TimeLine->getTabMatch();

?>
<!DOCTYPE html>
<html class="loading" lang="fr" data-textdirection="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <link rel="stylesheet" type="text/css" href="/src/bootstrap-4.0.0/css/bootstrap.min.css" id="bootstrap-css">
        <link rel="stylesheet" type="text/css" href="/src/fontawesome-free-5.0.13/web-fonts-with-css/css/fontawesome-all.min.css">
        <link rel="stylesheet" type="text/css" href="/app/src/css/nav.css">
        <link rel="stylesheet" type="text/css" href="/app/src/css/flag-icon.min.css">
        <link rel="stylesheet" type="text/css" href="/app/src/css/feather.min.css">
        <link rel="stylesheet" type="text/css" href="./css/pace.css">
        <link rel="stylesheet" type="text/css" href="./css/timeline.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
        rel="stylesheet">
    </head>
    <body class="horizontal-layout horizontal-menu 2-columns" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">
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
                            // echo getCardParis($tabMatch);
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="./js/vendors.min.js" type="text/javascript"></script>
            <script src="./js/horizontal-timeline.js" type="text/javascript"></script>
            <script src="./js/home.js" type="text/javascript"></script>
        </form>
    </body>
</html>