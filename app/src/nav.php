<nav class="navbar header-navbar fixed-top navbar-expand-lg navbar-dark bg-primary" id="menuPrinciaple">
    <a class="navbar-brand" href="/app/page/home/index.php" id="lienLogoNavBar"><img alt="wc-russia-2018.png" src="/src/images/wc-russia-2018.png" id="logoNavBar" /></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuPrincipale" aria-controls="menuPrincipale" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menuPrincipale">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
            <li class="nav-item">
                <a class="nav-link<?php echo $tabNavActive['home'];?>" href="/app/page/home/index.php"><i class="fa fa-home"></i>Accueil</a>
            </li>
            <!--
            <li class="nav-item">
                <a class="nav-link<?php echo $tabNavActive['bet'];?>" href="/app/page/bet.php">Pari</a>
            </li>
            <li class="nav-item<?php echo $tabNavActive['classement'];?>">
                <a class="nav-link" href="/app/page/classement.php">Classement</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?php echo $tabNavActive['groupe'];?>" href="/app/page/groupe.php">Groupe</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle<?php echo $tabNavActive['resultat'];?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Résultat
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/app/page/resultatMatch.php">Liste des matchs</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/app/page/resultatGroupe.php?idGroupe=1">Groupe A</a>
                    <a class="dropdown-item" href="/app/page/resultatGroupe.php?idGroupe=2">Groupe B</a>
                    <a class="dropdown-item" href="/app/page/resultatGroupe.php?idGroupe=3">Groupe C</a>
                    <a class="dropdown-item" href="/app/page/resultatGroupe.php?idGroupe=4">Groupe D</a>
                    <a class="dropdown-item" href="/app/page/resultatGroupe.php?idGroupe=5">Groupe E</a>
                    <a class="dropdown-item" href="/app/page/resultatGroupe.php?idGroupe=6">Groupe F</a>
                    <a class="dropdown-item" href="/app/page/resultatGroupe.php?idGroupe=7">Groupe G</a>
                    <a class="dropdown-item" href="/app/page/resultatGroupe.php?idGroupe=8">Groupe H</a>

                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link<?php echo $tabNavActive['about'];?>" href="/app/page/about.php">Help</a>
            </li>
            -->
        </ul>
    </div>
    <div class="navbar-container content">
        <div class="collapse navbar-collapse" id="navbar-mobile">
            <!-- <ul class="nav navbar-nav mr-auto float-left">
            </ul> -->
            <ul class="nav navbar-nav float-right">
                <li class="dropdown dropdown-user nav-item">
                    <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                        <span class="avatar avatar-online">
                            <img src="/src/images/portrait/dessin/<?php echo $_SESSION['worldCup']['login']['avatar']; ?>.png" alt="avatar"><i></i></span>
                        <span class="user-name">
                            <?php
                            echo $_SESSION['worldCup']['login']['pseudo'];
                            ?>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="/public/index.php"><i class="ft-power"></i> Déconnexion</a>
                    </div>
                </li>
            </ul>
            <!-- </div> -->
        </div>
    </div>
</nav>
<div style="height:56px;"></div>