<?php
declare(strict_types = 1);
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="./generale/css/materialize.min.css" media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="./generale/css/nav.css" media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="./generale/css/footer.css" media="screen,projection"/>

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>
        <?php require './generale/nav.php'; ?>
        <div id="body">
        <?php
            // for($i = 0; $i <= 100; $i++) {
            //     echo $i.'<br/>';
            // }
        ?>
        </div>
        <?php require './generale/footer.php'; ?>

        <!--JavaScript at end of body for optimized loading-->
        <script type="text/javascript" src="./generale/js/materialize.min.js"></script>
        <script type="text/javascript" src="./generale/js/nav.js"></script>
    </body>
</html>